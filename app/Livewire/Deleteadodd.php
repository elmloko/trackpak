<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\International;
use Livewire\WithPagination;

class Deleteadodd extends Component
{
    use WithPagination; // Mueve el uso de WithPagination aquí

    public $search = '';

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
            ->where('VENTANILLA', 'DD')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('livewire.deleteadodd', [
            'packages' => $packages,
        ]);
    }
}
