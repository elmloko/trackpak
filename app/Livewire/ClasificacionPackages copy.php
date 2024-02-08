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
    public $cantidadSacas = 1;

    public function render()
    {
        $userAsignado = auth()->user()->name;

        $packages = Package::where('ESTADO', 'CLASIFICACION')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    // ... (continúa con las demás condiciones)
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
        // Obtener la cantidad de sacas ingresada desde la vista
        $cantidadSacas = $this->cantidadSacas ?: 1;

        // Obtener los paquetes seleccionados y actualizar su estado
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)
            ->when($this->selectedCity, function ($query) {
                $query->where('CUIDAD', $this->selectedCity);
            })
            ->get();

        // Contar la cantidad de paquetes seleccionados
        $cantidadPaquetes = count($paquetesSeleccionados);

        // Obtener la ciudad del primer paquete (si existe)
        $ciudadPaquete = $paquetesSeleccionados->isNotEmpty() ? $paquetesSeleccionados->first()->CUIDAD : null;

        // Obtener y bloquear el último número de despacho
        $lastDispatchNumber = Bag::where('OFDESTINO', $ciudadPaquete)->first();
        $lastNumber = $lastDispatchNumber ? $lastDispatchNumber->last_number : 0;

        // Incrementar el número de despacho para generar el nuevo número correlativo
        $nuevoNumeroDespacho = $lastNumber + 1;
        $nuevoNumeroDespachoFormatado = str_pad($nuevoNumeroDespacho, 4, '0', STR_PAD_LEFT);

        // Actualizar el último número de despacho en la base de datos
        $this->actualizarNumeroDespacho($cantidadPaquetes,$lastDispatchNumber, $ciudadPaquete, $nuevoNumeroDespacho);

        // Iterar sobre los paquetes seleccionados y realizar acciones
        foreach ($paquetesSeleccionados as $paquete) {
            // Definir $nuevoNumeroDespacho aquí
            $nuevoNumeroDespacho = $lastNumber + 1;

            $this->procesarPaquete($paquete,$cantidadPaquetes,$nuevoNumeroDespacho, $cantidadSacas, $nuevoNumeroDespachoFormatado, $ciudadPaquete);
        }

        // Restablecer la selección
        $this->resetSeleccion();

        // Generar y descargar el PDF con los paquetes seleccionados
        return $this->generarYDescargarPDF($paquetesSeleccionados);
    }

    protected function actualizarNumeroDespacho( $cantidadPaquetes,$lastDispatchNumber, $ciudadPaquete, $nuevoNumeroDespacho)
    {
        if ($lastDispatchNumber) {
            $lastDispatchNumber->last_number = $nuevoNumeroDespacho;
            $lastDispatchNumber->save();
        } else {
            Bag::updated([
                'last_number' => $nuevoNumeroDespacho,
            ]);
        }
    }

        protected function procesarPaquete($paquete, $cantidadPaquetes, $nuevoNumeroDespacho, $cantidadSacas, $nuevoNumeroDespachoFormatado, $ciudadPaquete)
    {
        // Verificar si el paquete ya fue procesado para evitar duplicados
        if ($paquete->ESTADO === 'DESPACHO') {
            return;
        }

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
                    'ano_creacion' => now()->year,
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
