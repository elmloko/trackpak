<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EncomiendasImport;
use App\Exports\EncomiendasExport;

class Ventanillaencomienda extends Component
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

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Entregas Paqueteria V7"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        $packages = Package::where('ESTADO', 'VENTANILLA')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ZONA', 'like', $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) use ($userRegional) {
                $query->where(function ($subQuery) {
                    $subQuery->where('VENTANILLA', 'ENCOMIENDAS');
                })
                    ->where('CUIDAD', $userRegional);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.ventanillaencomienda', [
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

        // Determinar el formulario correspondiente
        $formulario = $paquete->ADUANA === 'SI' ? 'package.pdf.formularioentrega' : 'package.pdf.formularioentrega2';

        // Generar el PDF del paquete
        $pdf = PDF::loadView($formulario, ['packages' => collect([$paquete])]);
        $pdfContent = $pdf->output();

        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho Encomiendas.pdf');
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
        $import = new \App\Imports\EncomiendasImport();

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
                'descripcion' => 'Paquete a la espera de ser recogido en ventanilla ENCOMIENDAS',
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

    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        return Excel::download(new EncomiendasExport($this->fecha_inicio, $this->fecha_fin), 'Ventanilla Ordinarios ENCOMIENDA.xlsx');
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
        $package = Package::find($this->selectedPackageId);

        Event::create([
            'action' => 'REENCAMINADO',
            'descripcion' => 'Correccion de Destino de paquete a Oficina Postal Regional',
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);

        $package->CUIDAD = $this->selectedCity;
        $package->OBSERVACIONES = $this->observaciones;
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
