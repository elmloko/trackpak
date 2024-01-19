<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;

class Despachocarterogeneral extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $userRegional = auth()->user()->Regional;
        $userasignado = auth()->user()->name;
        $packages = Package::where('ESTADO', 'RETORNO')
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
        // Filtra por la 'CUIDAD' del usuario autenticado
        ->where('CUIDAD', $userRegional)
        // ->where('usercartero', $userasignado)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('livewire.despachocarterogeneral', [
            'packages' => $packages,
        ]);
    }
}
