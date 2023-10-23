<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Pcertificate;
use Livewire\Component;

class SearchTest extends Component
{
    public $search = '';
    public $results;

    public function render()
    {
        $this->results = collect([]);

        $packages = Package::where('CODIGO', 'like', '%' . $this->search . '%')
            // ->whereNull('deleted_at')  // Comentado para incluir registros eliminados
            ->take(5)
            ->withTrashed()
            ->get();

        // $pcertificates = Pcertificate::where('CODIGO', 'like', '%' . $this->search . '%')
        //     // ->whereNull('deleted_at')  // Comentado para incluir registros eliminados
        //     ->take(5)
        //     ->withTrashed()
        //     ->get();

        // Combina los resultados de ambas tablas y asigna a $results
        $this->results = $this->results->concat($packages);

        return view('livewire.search-test');
    }
}