<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International;
use App\Models\User;
use Livewire\WithPagination;

class Carterosgeneral extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCartero = '';

    public function render()
    {
        // Obtener todos los usuarios con rol CARTERO usando Spatie Laravel Permission
        $carteros = User::role('CARTERO')->get();

        $userRegional = auth()->user()->Regional;

        $columns = ['CODIGO', 'DESTINATARIO', 'TELEFONO', 'ADUANA', 'updated_at', 'ESTADO', 'usercartero', 'PESO', 'TIPO'];

        // Filtrar paquetes según el cartero seleccionado
        $packages = Package::select($columns)
            ->where('ESTADO', 'CARTERO')
            ->when($this->selectedCartero, function ($query) {
                return $query->where('usercartero', $this->selectedCartero);
            })
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->orderBy('updated_at', 'desc');

        $internationalPackages = International::select($columns)
            ->where('ESTADO', 'CARTERO')
            ->when($this->selectedCartero, function ($query) {
                return $query->where('usercartero', $this->selectedCartero);
            })
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->orderBy('updated_at', 'desc');

        // Unión de ambos resultados
        $packages = $packages->union($internationalPackages)->paginate(10);

        return view('livewire.carterosgeneral', [
            'packages' => $packages,
            'carteros' => $carteros,
        ]);
    }
}
