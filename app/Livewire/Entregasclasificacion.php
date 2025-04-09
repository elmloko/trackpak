<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClasificacionExport;
use App\Models\Event;

class Entregasclasificacion extends Component
{
    use WithPagination;

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;
    public $ciudad;

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Inventario Clasificacion"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }
    public function render()
    {
        $packages = Package::where('ESTADO', 'DESPACHO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('datedespachoclasificacion', 'like', '%' . $this->search . '%');
            })
            ->where('ESTADO', 'DESPACHO')
            ->orderBy('datedespachoclasificacion', 'desc')
            ->paginate(100);

        return view('livewire.entregasclasificacion', [
            'packages' => $packages,
        ]);
    }

    public function exportToExcel()
    {
        // Validación simple
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        // Lógica de exportación a Excel
        return Excel::download(new ClasificacionExport($this->fecha_inicio, $this->fecha_fin), 'Clasificacion.xlsx');
    }
}
