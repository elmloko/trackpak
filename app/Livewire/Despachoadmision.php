<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\National;

class Despachoadmision extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $userorigen = auth()->user()->Regional;
        $nationals = National::where(function ($query) {
            $query->where('CODIGO', 'like', '%' . $this->search . '%')
                ->orWhere('NOMBRESDESTINATARIO', 'like', '%' . $this->search . '%')
                ->orWhere('TIPOSERVICIO', 'like', '%' . $this->search . '%')
                ->orWhere('TIPOCORRESPONDENCIA', 'like', '%' . $this->search . '%')
                ->orWhere('DESTINO', 'like', '%' . $this->search . '%')
                ->orWhere('FACTURA', 'like', '%' . $this->search . '%')
                ->orWhere('created_at', 'like', '%' . $this->search . '%');
        })
        ->whereIn('ESTADO', ['DESPACHO'])
        ->where('ORIGEN', $userorigen)
        ->orderBy('created_at', 'desc')
        ->paginate(100);

        return view('livewire.despachoadmision', [
            'nationals' => $nationals,
        ]);
    }
}
