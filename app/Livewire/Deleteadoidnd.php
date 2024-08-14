<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\International;
use Livewire\WithPagination;
use App\Exports\Internationalinvdnd;
use Maatwebsite\Excel\Facades\Excel;

class Deleteadoidnd extends Component
{
    use WithPagination; // Mueve el uso de WithPagination aquí

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;
    
    public function render()
    {
        $userRegional = auth()->user()->Regional;

        $packages = International::onlyTrashed()
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%') // Mantenido como 'CUIDAD'
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('deleted_at', 'like', '%' . $this->search . '%');
            })
            // Filtra por la 'CUIDAD' del usuario autenticado
            ->whereIn('ESTADO', ['ENTREGADO'])
            ->where('CUIDAD', $userRegional)
            ->where('VENTANILLA', 'DND')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('livewire.deleteadoidnd', [
            'packages' => $packages,
        ]);
    }

    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        return Excel::download(new Internationalinvdnd($this->fecha_inicio, $this->fecha_fin), 'Inventario Certificados DD.xlsx');
    }
}
