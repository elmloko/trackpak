<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bag;
use Livewire\WithPagination;
use DB;

class Bagstrans extends Component
{
    use WithPagination;
    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];

    public function render()
    {
        $bags = Bag::where('ESTADO', 'TRASPORTADO')
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

        // Calcular la suma de PESOF y PAQUETES por grupo de MARBETE
        $sum = Bag::where('ESTADO', 'TRASPORTADO    ')
        ->select(
            'MARBETE', 
            DB::raw('SUM(PESO)as sum_totalpeso'),
            DB::raw('SUM(PAQUETES)as sum_totalpaquetes'),
            DB::raw('COUNT(ID) as sum_totalsaca'),
        )
        ->groupBy('MARBETE')
        ->get();

        return view('livewire.bagstrans', [
            'bags' => $bags,
            'sums' => $sum,
        ]);
    }
}
