<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\National;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Event;
use Livewire\WithPagination;
use PDF;

class Nacionaldespacho extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';
    public $selectedCartero = null;

    public function render()
    {
        $userasignado = auth()->user()->name;
        $nationals = National::where(function ($query) {
            $query->where('CODIGO', 'like', '%' . $this->search . '%')
                ->orWhere('NOMBRESDESTINATARIO', 'like', '%' . $this->search . '%')
                ->orWhere('TIPOSERVICIO', 'like', '%' . $this->search . '%')
                ->orWhere('TIPOCORRESPONDENCIA', 'like', '%' . $this->search . '%')
                ->orWhere('DESTINO', 'like', '%' . $this->search . '%')
                ->orWhere('FACTURA', 'like', '%' . $this->search . '%')
                ->orWhere('created_at', 'like', '%' . $this->search . '%');
        })
        ->whereIn('ESTADO', ['CLASIFICACION'])
        ->where('USER', $userasignado)
        ->when($this->selectedCity, function ($query) {
            $query->where('DESTINO', $this->selectedCity);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(100);

        $carteros = User::role('Cartero')->get(); // Obtener usuarios con el rol 'Cartero'

        return view('livewire.nacionaldespacho', [
            'nationals' => $nationals,
            'carteros' => $carteros,
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
        if (!$this->selectedCartero) {
            // Manejar error si no se seleccionó un cartero
            session()->flash('error', 'Debe seleccionar un cartero.');
            return;
        }

        // Obtener los paquetes seleccionados y actualizar su estado
        $paquetesSeleccionados = National::whereIn('id', $this->paquetesSeleccionados)->get();

        // Actualizar estado de los paquetes
        National::whereIn('id', $this->paquetesSeleccionados)->update([
            'ESTADO' => 'CARTERO',
            'datedespachocartero' => now(),
            'cartero_id' => $this->selectedCartero, // Asignar cartero
        ]);

        // Crear evento para cada paquete despachado
        foreach ($this->paquetesSeleccionados as $nationalId) {
            $national = National::find($nationalId);

            if ($national) {
                // Crear evento para el paquete actual
                Event::create([
                    'action' => 'ASIGNADO',
                    'descripcion' => 'PAQUETE ASIGNADO A CARTERO PARA EXPEDICION',
                    'user_id' => auth()->user()->id,
                    'codigo' => $national->CODIGO,
                ]);
            }
        }

        // Generar el PDF con los paquetes seleccionados
        $pdf = PDF::loadView('national.pdf.despachoemspdf', ['nationals' => $paquetesSeleccionados]);

        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();

        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho_EMS.pdf');

        // Restablecer la selección
        $this->resetSeleccion();
    }

    private function getPackageIds()
    {
        $userasignado = auth()->user()->name;

        return National::where(function ($query) {
            $query->where('CODIGO', 'like', '%' . $this->search . '%')
                ->orWhere('NOMBRESDESTINATARIO', 'like', '%' . $this->search . '%')
                ->orWhere('TIPOSERVICIO', 'like', '%' . $this->search . '%')
                ->orWhere('TIPOCORRESPONDENCIA', 'like', '%' . $this->search . '%')
                ->orWhere('DESTINO', 'like', '%' . $this->search . '%')
                ->orWhere('FACTURA', 'like', '%' . $this->search . '%')
                ->orWhere('created_at', 'like', '%' . $this->search . '%');
        })
        ->whereIn('ESTADO', ['CLASIFICACION'])
        ->where('USER', $userasignado)
        ->when($this->selectedCity, function ($query) {
            $query->where('DESTINO', $this->selectedCity);
        })
        ->pluck('id')
        ->toArray();
    }

    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}
