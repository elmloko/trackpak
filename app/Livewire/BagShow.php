<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bag;
use Illuminate\Support\Facades\DB;

class BagShow extends Component
{
    public $bag;
    public $packages;

    public function mount($id)
    {
        $this->bag = Bag::findOrFail($id);
        
        $this->packages = DB::table('packages_has_bags')
                    ->join('packages', 'packages_has_bags.packages_id', '=', 'packages.id')
                    ->select('packages.id', 'packages.CODIGO','packages.DESTINATARIO','packages.PAIS','packages.CUIDAD','packages.PESO','packages.ISO') // Ajusta las columnas según tu necesidad
                    ->where('packages_has_bags.bags_id', '=', $id)
                    ->get();
    }

    public function render()
    {
        return view('livewire.bag-show');
    }
}

