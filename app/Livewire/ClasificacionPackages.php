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
        $userasignado = auth()->user()->name;
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
            // ->where('CUIDAD', 'LA PAZ')
            // ->where('usercartero', $userasignado)
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
        
        // Contar la cantidad de paquetes seleccionados
        $cantidadPaquetes = count($paquetesSeleccionados);
        
        // Obtener la ciudad del primer paquete (si existe)
        $ciudadPaquete = $paquetesSeleccionados->isNotEmpty() ? $paquetesSeleccionados->first()->CUIDAD : null;
        
        // Obtener el último número de despacho para la ciudad seleccionada
        $ultimoNumeroDespacho = Bag::where('OFDESTINO', $ciudadPaquete)->max('NRODESPACHO');
        $ultimoNumeroDespacho = $ultimoNumeroDespacho ? $ultimoNumeroDespacho : 0;
        
        // Incrementar el número de despacho para generar el nuevo número correlativo
        $nuevoNumeroDespacho = (int)$ultimoNumeroDespacho + 1;
        $nuevoNumeroDespachoFormatado = str_pad($nuevoNumeroDespacho, 4, '0', STR_PAD_LEFT);
        
        foreach ($paquetesSeleccionados as $indice => $paquete) {
            $numeroSaca = $indice + 1;
            $numeroSacaFormatado = str_pad($numeroSaca, 4, '0', STR_PAD_LEFT);
            
            // Generar el código con el formato solicitado
            $codigoDespacho = $nuevoNumeroDespachoFormatado . '/' . $numeroSacaFormatado;
    
            if ($paquete) {
                $paquete->ESTADO = 'DESPACHO';
                $paquete->datedespachoclasificacion = now()->toDateTimeString();
                $paquete->save();
            }
    
            // Agregar lógica para el evento y cualquier otra acción que necesites
            Event::create([
                'action' => 'DESPACHO',
                'descripcion' => 'Destino de Clasificacion hacia Ventanilla',
                'user_id' => auth()->user()->id,
                'codigo' => $codigoDespacho, // Utiliza el nuevo código generado
            ]);
    
            // Incrementar el número de saca
            $nuevoNumeroDespacho++;
        }
    
        // Actualizar la base de datos con el nuevo número de despacho para la ciudad
        Bag::create([
            'OFDESTINO' => $ciudadPaquete,
            'PAQUETES' => $cantidadPaquetes,
            'NRODESPACHO' => $nuevoNumeroDespachoFormatado,
            'OFCAMBIO' => auth()->user()->Regional,
            'ESTADO' => 'APERTURA',
            'ano_creacion' => now()->year,
        ]);
    
        // Restablecer la selección
        $this->resetSeleccion();
    
        // Generar el PDF con los paquetes seleccionados
        $pdf = PDF::loadView('package.pdf.despachopdf', ['packages' => $paquetesSeleccionados]);
        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();
    
        // Generar una respuesta con el contenido del PDF para descargar
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

