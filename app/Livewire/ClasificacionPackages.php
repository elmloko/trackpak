<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\Bag;
use Livewire\WithPagination;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class ClasificacionPackages extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';

    public function render()
    {

        $packages = Package::where('ESTADO', 'CLASIFICACION')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCity, function ($query) {
                $query->where('CUIDAD', $this->selectedCity);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.clasificacion-packages', [
            'packages' => $packages,
        ]);
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->paquetesSeleccionados = $this->getPackageIds();
        } else {
            $this->paquetesSeleccionados = [];
        }
    }

    public function toggleSelectSingle($packageId)
    {
        if (in_array($packageId, $this->paquetesSeleccionados)) {
            $this->paquetesSeleccionados = array_diff($this->paquetesSeleccionados, [$packageId]);
        } else {
            $this->paquetesSeleccionados[] = $packageId;
        }
    }

    public function cambiarEstado()
{
    // Obtener los paquetes seleccionados y actualizar su estado
    $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)
        ->when($this->selectedCity, function ($query) {
            $query->where('CUIDAD', $this->selectedCity);
        })
        ->get();

    // Obtener la ciudad del primer paquete (si existe)
    $ciudadPaquete = $paquetesSeleccionados->isNotEmpty() ? $paquetesSeleccionados->first()->CUIDAD : null;

    // Obtener y bloquear el último número de despacho
    $lastDispatchNumber = Bag::where('OFDESTINO', $ciudadPaquete)->first();
    $lastNumber = $lastDispatchNumber ? $lastDispatchNumber->last_number : 0;

    // Incrementar el número de despacho para generar el nuevo número correlativo
    $nuevoNumeroDespacho = $lastNumber + 1;
    $nuevoNumeroDespachoFormatado = str_pad($nuevoNumeroDespacho, 4, '0', STR_PAD_LEFT);

    // Actualizar el último número de despacho en la base de datos
    $this->actualizarNumeroDespacho(count($paquetesSeleccionados), $lastDispatchNumber, $ciudadPaquete, $nuevoNumeroDespacho);

    // Iterar sobre los paquetes seleccionados y realizar acciones
    foreach ($paquetesSeleccionados as $paquete) {
        // Calcular la cantidad de paquetes seleccionados
        $cantidadPaquetes = $paquetesSeleccionados->count();

        // Procesar cada paquete una vez
        $this->procesarPaquete($paquete, $nuevoNumeroDespacho, $nuevoNumeroDespachoFormatado, $ciudadPaquete, $cantidadPaquetes, $paquetesSeleccionados);
    }

    // Restablecer la selección
    $this->resetSeleccion();

    // Generar y descargar el PDF con los paquetes seleccionados
    return $this->generarYDescargarPDF($paquetesSeleccionados);
}

    protected function actualizarNumeroDespacho($cantidadPaquetes, $lastDispatchNumber, $ciudadPaquete, $nuevoNumeroDespacho)
    {
        if ($lastDispatchNumber) {
            $lastDispatchNumber->last_number = $nuevoNumeroDespacho;
            $lastDispatchNumber->save();
        } else {
            Bag::create([
                'OFDESTINO' => $ciudadPaquete,
                'last_number' => $nuevoNumeroDespacho,
                'ano_creacion' => date('Y'), // Asignando el año actual como valor para 'ano_creacion'
            ]);
        }
    }

    protected function procesarPaquete($paquete, $nuevoNumeroDespacho, $nuevoNumeroDespachoFormatado, $ciudadPaquete, $cantidadPaquetes, $paquetesSeleccionados)
    {
        // Verificar si el paquete ya fue procesado para evitar duplicados
        if ($paquete->ESTADO === 'DESPACHO') {
            return;
        }
    
        // Definir el número de sacas según la cantidad de paquetes
        $cantidadSacas = 1; // Cambiar esto según tus necesidades
    
        for ($i = 1; $i <= $cantidadSacas; $i++) {
            $numeroSacaFormatado = str_pad($i, 4, '0', STR_PAD_LEFT);
            $codigoDespacho = $nuevoNumeroDespachoFormatado . '/' . $numeroSacaFormatado;
    
            if ($paquete) {
                $paquete->ESTADO = 'DESPACHO';
                $paquete->datedespachoclasificacion = now()->toDateTimeString();
                $paquete->save();
            }
    
            Event::create([
                'action' => 'DESPACHO',
                'descripcion' => 'Destino de Clasificacion hacia Ventanilla',
                'user_id' => auth()->user()->id,
                'codigo' => $codigoDespacho,
            ]);
    
            // Verificar si ya existe un registro para evitar duplicados
            $existingBag = Bag::where('OFDESTINO', $ciudadPaquete)
                ->where('NRODESPACHO', $codigoDespacho)
                ->first();
    
            if (!$existingBag) {
                Bag::create([
                    'OFDESTINO' => $ciudadPaquete,
                    'PAQUETES' => $cantidadPaquetes,
                    'last_number' => $nuevoNumeroDespacho,
                    'NRODESPACHO' => $codigoDespacho,
                    'OFCAMBIO' => auth()->user()->Regional,
                    'ESTADO' => 'APERTURA',
                    'ano_creacion' => now()->year, // Asignando el año actual como valor para 'ano_creacion'
                ]);
            }
        }
    }

    protected function generarYDescargarPDF($paquetesSeleccionados)
    {
        $pdf = PDF::loadView('package.pdf.despachopdf', ['packages' => $paquetesSeleccionados]);
        $pdfContent = $pdf->output();

        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho_Clasificacion.pdf');
    }

    private function getPackageIds()
    {
        return Package::where('ESTADO', 'CLASIFICACION')->pluck('id')->toArray();
    }

    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}
