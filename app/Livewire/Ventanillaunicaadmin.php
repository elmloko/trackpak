<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UnicaImport;
use App\Exports\VentanillaunicadminExport;

class Ventanillaunicaadmin extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';
    public $file;
    public $fechaInicio;
    public $fechaFin;
    public $observaciones = '';
    public $selectedPackageId = null;
    public $currentModal = null;

    public function render()
    {
        $packages = Package::where('ESTADO', 'VENTANILLA')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ZONA', 'like', $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where('VENTANILLA', 'UNICA')
            ->orderBy('updated_at', 'desc')
            ->paginate(100);

        return view('livewire.ventanillaunicaadmin', [
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

    public function exportExcel()
    {
        return Excel::download(new VentanillaunicadminExport($this->fechaInicio, $this->fechaFin), 'ventanilla_unica_admin.xlsx');
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
        }, 'Formulario Entrega UNICA.pdf');
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

        // Crear una instancia de UnicaImport
        $import = new \App\Imports\UnicaImport();

        // Realizar la importación usando la instancia
        Excel::import($import, $this->file->path());

        // Obtener los paquetes importados
        $importedPackages = Package::latest()->take($import->getRowCount())->get();

        $eventData = []; // Array para almacenamiento masivo de eventos

        foreach ($importedPackages as $paquete) {
            $eventData[] = [
                'action' => 'ADMISION',
                'descripcion' => 'Llegada de Paquete en Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $eventData[] = [
                'action' => 'CLASIFICACION',
                'descripcion' => 'Clasificación del Paquete en Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $eventData[] = [
                'action' => 'DESPACHO',
                'descripcion' => 'Destino de Clasificación hacia Ventanilla',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $eventData[] = [
                'action' => 'RECEPCIONADO',
                'descripcion' => 'Paquete llegó a ventanilla en Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $eventData[] = [
                'action' => 'DISPONIBLE',
                'descripcion' => 'Paquete a la espera de ser recogido en ventanilla REGIONAL',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $eventData[] = [
                'action' => 'ESTADO',
                'descripcion' => 'Paquete importado desde excel (Eventos creados por TrackingBO)',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Inserción masiva de todos los eventos
        Event::insert($eventData);

        session()->flash('message', 'Archivo importado exitosamente y eventos creados.');
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
    public function updatedSearch()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = array_intersect($this->paquetesSeleccionados, $this->getPackageIds());
    }
}
