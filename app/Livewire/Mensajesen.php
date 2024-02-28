<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Mensaje;
use Livewire\WithPagination;

class Mensajesen extends Component
{
    use WithPagination; // 
    public $search = '';

    public function render()
    {
        $mensajes = Mensaje::with(['package' => function ($query) {
            $query->withTrashed()
                ->where('CODIGO', 'like', '%' . $this->search . '%')
                ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                ->orWhere('CUIDAD', 'like', '%' . $this->search . '%') // Corregido 'CIUDAD'
                ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                ->orWhere('ESTADO', 'like', '%' . $this->search . '%');
        }])
        ->orderBy('fecha_actualizacion', 'desc')
        ->paginate(10);

        return view('livewire.mensajesen', compact('mensajes'));
    }
}
