<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\International;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Internationalinvcasillas;

class Deleteadocasillas extends Component
{
    use WithPagination;
    public $fecha_inicio;
    public $fecha_fin;

    public $search = '';

    public function exportExcel()
    {
        return Excel::download(new Internationalinvcasillas($this->fecha_inicio, $this->fecha_fin), 'Inventario Certificados CASILLAS.xlsx');
    }
    
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
            ->where('VENTANILLA', 'CASILLAS')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('livewire.deleteadocasillas', [
            'packages' => $packages,
        ]);
    }
}
