<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bag;
use Livewire\WithPagination;
use DB;

class Bagsopen extends Component
{
    use WithPagination;
    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];

    public function render()
    {
        $bags = Bag::where('ESTADO', 'EXPEDICION')
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
            ->paginate(100);

        // Calcular la suma de PESOF y PAQUETES por grupo de MARBETE
        $sum = Bag::where('ESTADO', 'EXPEDICION')
        ->select(
            'MARBETE', 
            DB::raw('SUM(PESOF) as sum_pesoc'), 
            DB::raw('SUM(PAQUETES) as sum_paquetes'), 
            DB::raw('SUM(CASE WHEN TIPO = "U" THEN 1 ELSE 0 END) as sum_tipo'),
            DB::raw('SUM(PESOF) + SUM(PESOR) + SUM(PESOM) as sum_totalpeso'),
            DB::raw('SUM(PAQUETES) + SUM(PAQUETESR) + SUM(PAQUETESM) as sum_totalpaquetes')
        )
        ->groupBy('MARBETE')
        ->get();

        return view('livewire.bagsopen', [
            'bags' => $bags,
            'sums' => $sum,
        ]);
    }
}
