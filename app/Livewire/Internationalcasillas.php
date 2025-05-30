<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\International;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CasillaImport;
use App\Exports\InternationalcasillasExport;

class Internationalcasillas extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';
    public $observaciones = '';
    public $selectedPackageId = null;
    public $currentModal = null;
    public $file; 
    public $fecha_inicio;
    public $fecha_fin;

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        $international = International::where('ESTADO', 'VENTANILLA')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ZONA', 'like', $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) use ($userRegional) {
                $query->where(function ($subQuery) {
                    $subQuery->where('VENTANILLA', 'CASILLAS');
                })
                    ->where('CUIDAD', $userRegional);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(100);

        return view('livewire.internationalcasillas', [
            'internationals' => $international,
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
        $paquetesSeleccionados = International::whereIn('id', $this->paquetesSeleccionados)
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
                'descripcion' => 'Entrega de paquete casillas en ventanilla en Oficina Postal Regional',
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
        }, 'Formulario Certificado Casilla.pdf');
    }

    public function toggleSelectSingle($packageId)
    {
        if (in_array($packageId, $this->paquetesSeleccionados)) {
            $this->paquetesSeleccionados = array_diff($this->paquetesSeleccionados, [$packageId]);
        } else {
            $this->paquetesSeleccionados[] = $packageId;
        }
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
    
        if ($this->file && $this->file->isValid()) {
            // Subir el archivo al servidor y luego importarlo
            $path = $this->file->store('temp'); // Guarda temporalmente el archivo
            $fullPath = storage_path('app/' . $path); // Obtén la ruta completa
    
            Excel::import(new CasillaImport, $fullPath);
    
            session()->flash('message', 'Archivo importado exitosamente.');
        } else {
            session()->flash('error', 'El archivo no es válido o no ha sido cargado correctamente.');
        }
    }
    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        return Excel::download(new InternationalcasillasExport($this->fecha_inicio, $this->fecha_fin), 'Ventanilla Certificados DD.xlsx');
    }
    public function openPreRezagoModal($packageId)
    {
        $this->selectedPackageId = $packageId;
        $package = International::find($packageId);
        $this->observaciones = $package->OBSERVACIONES;
        $this->currentModal = 'prerezago';
    }

    public function savePreRezago()
    {
        $package = International::findOrFail($this->selectedPackageId);
        $package->ESTADO = 'PRE-REZAGO';
        $package->OBSERVACIONES = $this->observaciones;
        $package->save();

        // Reset fields
        $this->reset(['selectedPackageId', 'observaciones']);

        // Close the modal
        $this->dispatch('closeModal');

        session()->flash('message', 'Paquete actualizado a PRE-REZAGO exitosamente.');
    }

    private function getPackageIds()
    {
        return International::where('ESTADO', 'VENTANILLA')->pluck('id')->toArray();
    }

    // Restablecer la selección
    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}
