<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EcaExport;

class Eca extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $fecha_inicio;
    public $fecha_fin;
    public $selectedCity = '';
    public $selectedPackageId = null;
    public $currentModal = null;
    public $observaciones = '';

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Entregas Paqueteria ECA"',
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
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->where('VENTANILLA', 'ECA')
            ->orderBy('updated_at', 'desc')
            ->paginate(100);

        return view('livewire.eca', [
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
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)->get();

        // Actualizar estado de los paquetes
        Package::whereIn('id', $this->paquetesSeleccionados)->update([
            'ESTADO' => 'ENTREGADO',
        ]);

        // Crear evento para cada paquete despachado
        foreach ($this->paquetesSeleccionados as $paqueteId) {
            $paquete = Package::find($paqueteId);

            if ($paquete) {
                // Crear evento para el paquete actual
                Event::create([
                    'action' => 'ENTREGADO',
                    'descripcion' => 'Paquete entregado a Empresa Correspondiente Envíos de Correspondencia Agrupada',
                    'user_id' => auth()->user()->id,
                    'codigo' => $paquete->CODIGO,
                ]);
                // Eliminar el paquete
                $paquete->delete();
            }
        }
        $this->resetSeleccion();
        // Generar el PDF con los paquetes seleccionados
        $pdf = PDF::loadView('package.pdf.despachoecapdf', ['packages' => $paquetesSeleccionados]);

        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();

        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho_ECA.pdf');

        // Restablecer la selección
        $this->resetSeleccion();
    }
    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        return Excel::download(new EcaExport($this->fecha_inicio, $this->fecha_fin), 'Ventanilla Ordinarios ECA.xlsx');
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
        return Package::where('ESTADO', 'ENTREGADO')->pluck('id')->toArray();
    }

    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}
