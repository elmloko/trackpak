<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;

class Traspasoventanillas extends Component
{
    use WithPagination;

    public function render()
    {
        // Filtrar paquetes donde el estado sea 'TRASPAZO'
        $packages = Package::withTrashed()
            ->where('ESTADO', 'TRASPAZO') // Filtrar por estado TRASPAZO
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Retorna la vista con los paquetes filtrados
        return view('livewire.traspasoventanillas', [
            'packages' => $packages,
        ]);
    }
}
