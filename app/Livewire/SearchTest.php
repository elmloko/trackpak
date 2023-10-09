<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Pcertificate;
use Livewire\Component;

class SearchTest extends Component
{
    public $search = '';
    public $packages;
    public $pcertificates;
    public $results; 
    
    public function render()
    {
        $this->packages = Package::where('CODIGO', 'like', '%' . $this->search . '%')->take(5)->get();
        $this->pcertificates = Pcertificate::where('CODIGO', 'like', '%' . $this->search . '%')->take(5)->get();
        
        // Combina los resultados de ambas tablas y asigna a $results
        $this->results = $this->packages->concat($this->pcertificates);
        
        return view('livewire.search-test');
    }
}
