<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
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
            ->where('usercartero', $userasignado)
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
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)->get();

        // Actualizar estado de los paquetes
        Package::whereIn('id', $this->paquetesSeleccionados)->update([
            'ESTADO' => 'DESPACHO',
            'datedespachoclasificacion' => now(), // Guardar la fecha de despacho actual
        ]);

        // Crear evento para cada paquete despachado
        foreach ($this->paquetesSeleccionados as $paqueteId) {
            $paquete = Package::find($paqueteId);

            if ($paquete) {
                // Crear evento para el paquete actual
                Event::create([
                    'action' => 'DESPACHO',
                    'descripcion' => 'Destino de Clasificacion hacia Ventanilla',
                    'user_id' => auth()->user()->id,
                    'codigo' => $paquete->CODIGO,
                ]);
            }
        }
        $this->resetSeleccion();
        // Generar el PDF con los paquetes seleccionados
        $pdf = PDF::loadView('package.pdf.despachopdf', ['packages' => $paquetesSeleccionados]);

        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();

        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho_Clasificacion.pdf');

        // Restablecer la selección
        $this->resetSeleccion();
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

