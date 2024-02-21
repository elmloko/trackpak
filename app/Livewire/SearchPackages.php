<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;

class SearchPackages extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $packages = Package::where('CODIGO', 'like', '%' . $this->search . '%')
            ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
            ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
            ->orWhere('PAIS', 'like', '%' . $this->search . '%')
            ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
            ->orWhere('ZONA', 'like', '%' . $this->search . '%')
            ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
            ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
            ->orWhere('PESO', 'like', '%' . $this->search . '%')
            ->orWhere('TIPO', 'like', '%' . $this->search . '%')
            ->orWhere('ESTADO', 'like', '%' . $this->search . '%')
            ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
            ->orWhere('created_at', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.search-packages', [
            'packages' => $packages,
        ]);
    }
}



