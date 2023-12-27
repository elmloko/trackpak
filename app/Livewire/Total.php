<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\National;
use Livewire\WithPagination;
use PDF;

class Total extends Component
{
    use WithPagination;

    public $search = '';
    public function render()
    {
        $nationals = National::where(function ($query) {
            $query->where('CODIGO', 'like', '%' . $this->search . '%')
                ->orWhere('NOMBRESDESTINATARIO', 'like', '%' . $this->search . '%')
                ->orWhere('TIPOSERVICIO', 'like', '%' . $this->search . '%')
                ->orWhere('TIPOCORRESPONDENCIA', 'like', '%' . $this->search . '%')
                ->orWhere('DESTINO', 'like', '%' . $this->search . '%')
                ->orWhere('FACTURA', 'like', '%' . $this->search . '%')
                ->orWhere('created_at', 'like', '%' . $this->search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('livewire.total', [
            'nationals' => $nationals,
        ]);
    }
}
