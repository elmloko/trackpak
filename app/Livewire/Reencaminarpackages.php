<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReencaminarExport;

class Reencaminarpackages extends Component
{
    use WithPagination;

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;

    public function render()
    {
        $packages = Package::where('ESTADO', 'REENCAMINADO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%') // Mantenido como 'CUIDAD'
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.reencaminarpackages', [
            'packages' => $packages,
        ]);
    }
    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);
    
        return Excel::download(new ReencaminarExport($this->fecha_inicio, $this->fecha_fin), 'Ventanilla Ordinarios DND.xlsx');
    }
}
