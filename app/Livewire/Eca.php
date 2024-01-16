<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class Eca extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];

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
            ->paginate(10);

        return view('livewire.eca', [
            'packages' => $packages,
        ]);
    }
    public function selectAll()
    {
        $this->selectAll = !$this->selectAll;
    
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
            // 'datedespachoclasificacion' => now(), // Guardar la fecha de despacho actual
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
            }
        }
        $this->resetSeleccion();
        // Generar el PDF con los paquetes seleccionados
        $pdf = PDF::loadView('package.pdf.despachoecapdf', ['packages' => $paquetesSeleccionados]);

        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();
        $paquete->delete();

        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho_ECA.pdf');

        // Restablecer la selección
        $this->resetSeleccion();
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
