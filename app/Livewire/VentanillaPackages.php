<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class VentanillaPackages extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        $packages = Package::where('ESTADO', 'VENTANILLA')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%') // Mantenido como 'CUIDAD'
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            // Filtra por la 'CUIDAD' del usuario autenticado
            ->where('CUIDAD', $userRegional)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.ventanilla-packages', [
            'packages' => $packages,
        ]);
    }
}




