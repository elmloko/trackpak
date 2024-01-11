<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;

class Ventanilladnd extends Component
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
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) use ($userRegional) {
                $query->where(function ($subQuery) {
                    $subQuery->where('VENTANILLA', 'DND');
                })
                    ->where('CUIDAD', $userRegional);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('livewire.ventanilladnd', [
            'packages' => $packages,
        ]);
    }
}
