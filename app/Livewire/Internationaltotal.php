<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\International;
use Livewire\WithPagination;

class Internationaltotal extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $international = International::withTrashed() // Incluye los paquetes eliminados suavemente
            ->where('CODIGO', 'like', '%' . $this->search . '%')
            ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
            ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
            ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
            ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')  
            ->orWhere('ESTADO', 'like', '%' . $this->search . '%')
            ->orWhere('created_at', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.internationaltotal', [
            'internationals' => $international,
        ]);
    }
}
