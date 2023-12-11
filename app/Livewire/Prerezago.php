<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class Prerezago extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];

    public function render()
    {
        $packages = Package::where('ESTADO', 'PRE-REZAGO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('dateprerezago', 'like', '%' . $this->search . '%');
            })
            ->orderBy('dateprerezago', 'desc')
            ->paginate(10);

        return view('livewire.prerezago', [
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
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)->get();

        Package::whereIn('id', $this->paquetesSeleccionados)->update([
            'ESTADO' => 'REZAGO',
            'daterezago' => now(), // Guardar la fecha de despacho actual
        ]);

        foreach ($this->paquetesSeleccionados as $packageId) {
            $paquete = Package::find($packageId);

            if ($paquete) {
                // Crear un nuevo evento
                Event::create([
                    'action' => 'ALMACEN',
                    'descripcion' => 'Destino de Ventanilla hacia Almacen',
                    'user_id' => auth()->user()->id,
                    'codigo' => $paquete->CODIGO,
                ]);
            }
            $this->resetSeleccion();
            // Generar el PDF con los paquetes seleccionados
            $pdf = PDF::loadView('package.pdf.prerezago', ['packages' => $paquetesSeleccionados]);
        
            // Obtener el contenido del PDF
            $pdfContent = $pdf->output();
        
            // Generar una respuesta con el contenido del PDF para descargar
            return response()->streamDownload(function () use ($pdfContent) {
                echo $pdfContent;
            }, 'Paquetes_Prerezago.pdf');
        
            // Restablecer la selección
            $this->resetSeleccion();
        }
        // Actualizar la lista de paquetes después de cambiar el estado
        // $this->render();
    }

    private function getPackageIds()
    {
        // Obtener los IDs de los paquetes en la lista actual
        return Package::where('ESTADO', 'PRE-REZAGO')->pluck('id')->toArray();
    }

    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}
