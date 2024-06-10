<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bag;
use Livewire\WithPagination;
use DB;

class Bagsclose extends Component
{
    use WithPagination;
    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];

    public function render()
    {
        $bags = Bag::where('ESTADO', 'APERTURA')
        ->where('first', '1') // Agregar esta línea para la condición $bag->FIN == 'F'
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
        $sum = Bag::where('ESTADO', 'APERTURA')
            ->select(
                'MARBETE',
                DB::raw('SUM(PESOF) as sum_pesoc'),
                DB::raw('SUM(PAQUETESR) + SUM(PAQUETESM) + SUM(PAQUETESU) as sum_paquetes'),
                DB::raw('COUNT(ID) + SUM(SACAR) + SUM(SACAM) as sum_sacas'),
                DB::raw('SUM(CASE WHEN TIPO = "U" THEN 1 ELSE 0 END) as sum_tipo'),
                DB::raw('SUM(PESOU) + SUM(PESOR) + SUM(PESOM) as sum_totalpeso'),
                DB::raw('SUM(PAQUETES) as sum_totalpaquetes')
            )
            ->groupBy('MARBETE')
            ->get();

        $repeatedMarbetes = Bag::select('MARBETE')
            ->where('ESTADO', 'APERTURA')
            ->groupBy('MARBETE')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('MARBETE')
            ->toArray();

        $repeatedBags = Bag::whereIn('MARBETE', $repeatedMarbetes)->get();

        return view('livewire.bagsclose', [
            'bags' => $bags,
            'sums' => $sum,
            'repeatedBags' => $repeatedBags,
        ]);
    }
}
