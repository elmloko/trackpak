<?php

namespace App\Livewire;

use App\Models\Package;
use Livewire\Component;

class SearchTest extends Component
{
    public $search = '';
    public $packages;
    public function render()
    {
        $this->packages = Package::where('CODIGO', 'like', '%' . $this->search . '%')->take(5)->get();
     
        return view('livewire.search-test');
    }
}
