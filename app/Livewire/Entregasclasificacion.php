<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;

class Entregasclasificacion extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        // $userRegional = auth()->user()->Regional;

        $packages = Package::where('ESTADO', 'DESPACHO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('datedespachoclasificacion', 'like', '%' . $this->search . '%');
            })
            ->where('ESTADO', 'DESPACHO')
            ->orderBy('datedespachoclasificacion', 'desc')
            ->paginate(100);

        return view('livewire.entregasclasificacion', [
            'packages' => $packages,
        ]);
    }
}
