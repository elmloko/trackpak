<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;

class Rezago extends Component
{
    use WithPagination; // Mueve el uso de WithPagination aquí

    public $search = '';

    public function render()
    {

        $packages = Package::whereIn('ESTADO', ['REZAGO'])
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%') // Mantenido como 'CUIDAD'
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('daterezago', 'like', '%' . $this->search . '%');
            })
            ->orderBy('daterezago', 'desc')
            ->paginate(10);

        return view('livewire.rezago', [
            'packages' => $packages,
        ]);
    }
}
