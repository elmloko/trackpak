<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;

class SearchComponent extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $packages = Package::where('CODIGO', 'like', '%' . $this->search . '%')->paginate(10);

        return view('livewire.search', ['packages' => $packages]);
    }
}


