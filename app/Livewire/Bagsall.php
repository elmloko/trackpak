<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bag;
use Livewire\WithPagination;
use DB;

class Bagsall extends Component
{
    use WithPagination;
    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public function render()
    {
        $bags = Bag::when($this->search, function ($query) {
            $query->where('NRODESPACHO', 'like', '%' . $this->search . '%')
                ->orWhere('OFCAMBIO', 'like', '%' . $this->search . '%')
                ->orWhere('OFDESTINO', 'like', '%' . $this->search . '%')
                ->orWhere('NROSACAS', 'like', '%' . $this->search . '%')
                ->orWhere('PESO', 'like', '%' . $this->search . '%')
                ->orWhere('PAQUETES', 'like', '%' . $this->search . '%')
                ->orWhere('ITINERARIO', 'like', '%' . $this->search . '%')
                ->orWhere('created_at', 'like', '%' . $this->search . '%');
        })
            ->orderBy('MARBETE', 'asc')
            ->paginate(100);

        // Calcular la suma de PESOF y PAQUETES por grupo de MARBETE
        $sum = Bag::select('MARBETE',
            DB::raw('SUM(PESO)as sum_totalpeso'),
            DB::raw('SUM(PAQUETES)as sum_totalpaquetes'),
            DB::raw('COUNT(ID) as sum_totalsaca'),
        )
            ->groupBy('MARBETE')
            ->get();


        return view('livewire.bagsall', [
            'bags' => $bags,
            'sums' => $sum,
        ]);
    }
}
