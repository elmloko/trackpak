<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;

class SearchO extends Component
{
    public $search = '';
    public $packages;

    public function render()
    {
        $this->packages = Package::where('CODIGO', 'like', '%' . $this->search . '%')
            ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
            ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
            ->orWhere('PAIS', 'like', '%' . $this->search . '%')
            ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
            ->orWhere('ZONA', 'like', '%' . $this->search . '%')
            ->orWhere('PESO', 'like', '%' . $this->search . '%')
            ->orWhere('TIPO', 'like', '%' . $this->search . '%')
            ->orWhere('ESTADO', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.search-o');
    }
}

