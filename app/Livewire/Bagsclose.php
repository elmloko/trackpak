<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bag;
use Livewire\WithPagination;

class Bagsclose extends Component
{
    use WithPagination;
    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public function render()
    {
        $bags = Bag::where('ESTADO', 'CIERRE')
            ->when($this->search, function ($query) {
                $query->where('NRODESPACHO', 'like', '%' . $this->search . '%')
                    ->orWhere('OFCAMBIO', 'like', '%' . $this->search . '%')
                    ->orWhere('OFDESTINO', 'like', '%' . $this->search . '%')
                    ->orWhere('NROSACAS', 'like', '%' . $this->search . '%')
                    ->orWhere('PESO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAQUETES', 'like', '%' . $this->search . '%')
                    ->orWhere('ITINERARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('ESTADO', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->orderBy('MARBETE', 'asc')
            ->paginate(10);

        return view('livewire.bagsclose', [
            'bags' => $bags,
        ]);
        return view('livewire.bagsclose');
    }
}
