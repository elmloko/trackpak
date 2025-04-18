<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CasillasExport;

class Casillas extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';
    public $fecha_inicio;
    public $fecha_fin;
    public $selectedPackageId = null;
    public $currentModal = null;
    public $observaciones = '';

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        $packages = Package::where('ESTADO', 'VENTANILLA')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('nrocasilla', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->where('VENTANILLA', 'CASILLAS')
            ->orderBy('updated_at', 'desc')
            ->paginate(100);

        return view('livewire.casillas', [
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
    public function cambiarEstado()
    {
        // Obtener los paquetes seleccionados y actualizar su estado
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)
            ->when($this->selectedCity, function ($query) {
                $query->where('CUIDAD', $this->selectedCity);
            })
            ->get();
    
        // Determinar el formulario según la condición de ADUANA
        $primerPaquete = $paquetesSeleccionados->first();

        if ($primerPaquete && $primerPaquete->ADUANA == 'SI') {
            $formulario = 'package.pdf.formularioentrega';
        } else {
            $formulario = 'package.pdf.formularioentrega2';
        }
    
        foreach ($paquetesSeleccionados as $paquete) {
            // Calcular el precio basado en el peso del paquete
            $peso = $paquete->PESO;
            if ($peso >= 0.000 && $peso <= 0.5) {
                $precio = 5;
            } elseif ($peso > 0.5) {
                $precio = 10;
            }
    
            // Actualizar el precio del paquete
            $paquete->PRECIO = $precio;
            $paquete->save();
    
            // Actualizar el estado del paquete
            $paquete->ESTADO = 'ENTREGADO';
            $paquete->save();
            $paquete->delete();
    
            // Crear un evento
            Event::create([
                'action' => 'ENTREGADO',
                'descripcion' => 'Entrega de paquete en ventanilla en Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
            ]);
        }
    
        // Restablecer la selección
        $this->resetSeleccion();
    
        // Generar el PDF con los paquetes seleccionados
        $pdf = PDF::loadView($formulario, ['packages' => $paquetesSeleccionados]);
    
        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();
    
        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Formulario CASILLAS.pdf');
    }    

    public function toggleSelectSingle($packageId)
    {
        if (in_array($packageId, $this->paquetesSeleccionados)) {
            $this->paquetesSeleccionados = array_diff($this->paquetesSeleccionados, [$packageId]);
        } else {
            $this->paquetesSeleccionados[] = $packageId;
        }
    }
    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        return Excel::download(new CasillasExport($this->fecha_inicio, $this->fecha_fin), 'Ventanilla Ordinarios Casillas.xlsx');
    }

    public function openModal($packageId)
    {
        $this->selectedPackageId = $packageId;
        $package = Package::find($packageId);
        $this->selectedCity = $package->CUIDAD;
        $this->observaciones = $package->OBSERVACIONES;
        $this->currentModal = 'reencaminar';
    }

    public function updatePackage()
    {
        // Guarda el valor de auth()->user()->Regional en una variable
        $cuidadre = auth()->user()->Regional;
        $package = Package::find($this->selectedPackageId);
        
        Event::create([
            'action' => 'REENCAMINADO',
            'descripcion' => 'Correccion de Destino de paquete a Oficina Postal Regional',
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);

        $package->CUIDAD = $this->selectedCity;
        $package->cuidadre = $cuidadre;
        $package->OBSERVACIONES = $this->observaciones;
        $package->ESTADO = 'REENCAMINADO';
        $package->save();

        $this->reset(['selectedCity', 'observaciones', 'selectedPackageId']);
        session()->flash('message', 'Paquete actualizado exitosamente.');

        $pdf = PDF::loadView('livewire.pdf.reencaminarentrega', compact('package'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Formulario de Rencaminamiento.pdf');
    }

    public function openPreRezagoModal($packageId)
    {
        $this->selectedPackageId = $packageId;
        $package = Package::find($packageId);
        $this->observaciones = $package->OBSERVACIONES;
        $this->currentModal = 'prerezago';
    }

    public function savePreRezago()
    {
        $package = Package::findOrFail($this->selectedPackageId);
        $package->ESTADO = 'PRE-REZAGO';
        $package->OBSERVACIONES = $this->observaciones;
        $package->dateprerezago = now();
        $package->save();

        // Reset fields
        $this->reset(['selectedPackageId', 'observaciones']);

        // Close the modal
        $this->dispatch('closeModal');

        session()->flash('message', 'Paquete actualizado a PRE-REZAGO exitosamente.');
    }
    
    private function getPackageIds()
    {
        return Package::where('ESTADO', 'VENTANILLA')->pluck('id')->toArray();
    }
    // Restores paquetes
    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}
