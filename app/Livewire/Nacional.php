<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\National;
use Carbon\Carbon;
use App\Models\Event;
use Livewire\WithPagination;
use PDF;

class Nacional extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';

    public function render()
    {
        $nationals = National::where(function ($query) {
            $query->where('CODIGO', 'like', '%' . $this->search . '%')
                ->orWhere('NOMBRESDESTINATARIO', 'like', '%' . $this->search . '%')
                ->orWhere('TIPOSERVICIO', 'like', '%' . $this->search . '%')
                ->orWhere('TIPOCORRESPONDENCIA', 'like', '%' . $this->search . '%')
                ->orWhere('DESTINO', 'like', '%' . $this->search . '%')
                ->orWhere('FACTURA', 'like', '%' . $this->search . '%')
                ->orWhere('created_at', 'like', '%' . $this->search . '%');
        })
        ->when($this->selectedCity, function ($query) {
            $query->where('DESTINO', $this->selectedCity);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('livewire.nacional', [
            'nationals' => $nationals,
        ]);
    }
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->paquetesSeleccionados = $this->getPackageIds(); // Cambiar aquí
        } else {
            $this->paquetesSeleccionados = [];
        }
    }

    public function toggleSelectSingle($nationalId)
    {
        if (in_array($nationalId, $this->paquetesSeleccionados)) {
            $this->paquetesSeleccionados = array_diff($this->paquetesSeleccionados, [$nationalId]);
        } else {
            $this->paquetesSeleccionados[] = $nationalId;
        }
    }
    public function cambiarEstado()
    {
        // Obtener los paquetes seleccionados y actualizar su estado
        $paquetesSeleccionados = National::whereIn('id', $this->paquetesSeleccionados)->get();

        // Actualizar estado de los paquetes
        National::whereIn('id', $this->paquetesSeleccionados)->update([
            'ESTADO' => 'DESPACHO',
            'datedespachoadmision' => now(), // Guardar la fecha de despacho actual
        ]);

        // Crear evento para cada paquete despachado
        foreach ($this->paquetesSeleccionados as $nationalId) {
            $national = National::find($nationalId);

            if ($national) {
                // Crear evento para el paquete actual
                Event::create([
                    'action' => 'ADMITIDO',
                    'descripcion' => 'Destino a Despacho en Ventanilla',
                    'user_id' => auth()->user()->id,
                    'codigo' => $national->CODIGO,
                ]);
            }
        }

        // Generar el PDF con los paquetes seleccionados
        $pdf = PDF::loadView('national.pdf.despachopdf', ['nationals' => $paquetesSeleccionados]);

        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();

        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho_Admision.pdf');

        // Restablecer la selección
        $this->resetSeleccion();
    }

    private function getPackageIds() // Corregir el nombre del método
    {
        return National::where('ESTADO', 'ADMISION')->pluck('id')->toArray();
    }

    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}
