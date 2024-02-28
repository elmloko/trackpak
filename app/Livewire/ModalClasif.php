<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class ModalClasif extends Component
{
    public $showModal = false;
    public $packages = [];
    public $paquetesSeleccionados = [];
    public $selectedCity = '';

    public function openModal()
    {
        $this->packages = Package::where('ESTADO', 'CLASIFICACION')->get();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function confirmDespacho()
    {
        // Obtener los paquetes seleccionados y actualizar su estado
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)
            ->when($this->selectedCity, function ($query) {
                $query->where('CUIDAD', $this->selectedCity);
            })
            ->get();

        foreach ($paquetesSeleccionados as $paquete) {
            if ($paquete) {
                $paquete->ESTADO = 'DESPACHO';
                $paquete->datedespachoclasificacion = now()->toDateTimeString();
                $paquete->save();
            }

            Event::create([
                'action' => 'DESPACHO',
                'descripcion' => 'Destino de Clasificacion hacia Ventanilla',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
            ]);
        }

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

    public function toggleSelectAll()
    {
        if (count($this->paquetesSeleccionados) < count($this->packages)) {
            $this->paquetesSeleccionados = $this->packages->pluck('id')->toArray();
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
    private function getPackageIds()
    {
        return Package::where('ESTADO', 'CLASIFICACION')->pluck('id')->toArray();
    }
    // Restores paquetes
    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }

    public function render()
    {
        return view('livewire.modal-clasif');
    }
}
