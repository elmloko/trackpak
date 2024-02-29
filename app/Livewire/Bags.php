<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bag;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class Bags extends Component
{
    use WithPagination;
    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public function render()
    {
        $bags = Bag::where('ESTADO', 'APERTURA')
            ->when($this->search, function ($query) {
                $query->where('NRODESPACHO', 'like', '%' . $this->search . '%')
                    ->orWhere('OFCAMBIO', 'like', '%' . $this->search . '%')
                    ->orWhere('OFDESTINO', 'like', '%' . $this->search . '%')
                    ->orWhere('NROSACAS', 'like', '%' . $this->search . '%')
                    ->orWhere('PESO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAQUETES', 'like', '%' . $this->search . '%')
                    ->orWhere('ITINERARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('ESTADO', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->orderBy('NROSACA', 'asc')
            ->paginate(10);

        return view('livewire.bags', [
            'bags' => $bags,
        ]);
        return view('livewire.bags');
    }
    
    public function cambiarEstado()
    {
        // Obtener los paquetes seleccionados y actualizar su estado
        $paquetesSeleccionados = Bag::whereIn('id', $this->paquetesSeleccionados)
            // ->when($this->selectedCity, function ($query) {
            //     $query->where('CUIDAD', $this->selectedCity);
            // })
            ->get();
        foreach ($paquetesSeleccionados as $paquete) {
            if ($paquete) {
                $paquete->ESTADO = 'CIERRE';
                $paquete->save();
            }
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
}
