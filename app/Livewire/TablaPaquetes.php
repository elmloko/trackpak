<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Package;
use Livewire\WithPagination;

class TablaPaquetes extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCartero;

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        $packagesToAdd = Package::where('ESTADO', 'VENTANILLA')
            ->where('CUIDAD', $userRegional)
            ->when($this->search, function ($query) {
                // ... your existing search code ...
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $assignedPackages = Package::where('ESTADO', 'ASIGNADO')
            ->where('CUIDAD', $userRegional)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.tabla-paquetes', [
            'packagesToAdd' => $packagesToAdd,
            'assignedPackages' => $assignedPackages,
            'carters' => User::role('CARTERO')->get(),
        ]);
    }

    public function agregarPaquete($packageId)
    {
        $package = Package::findOrFail($packageId);
        $package->update(['ESTADO' => 'ASIGNADO']);
        $package->touch();
    }

    public function quitarPaquete($packageId)
    {
        $package = Package::findOrFail($packageId);
        $package->update(['ESTADO' => 'VENTANILLA']);
        $package->touch();
    }

    public function cambiarEstadoVentanillaMasivo()
    {
        if (!$this->selectedCartero) {
            session()->flash('error', 'Debe seleccionar un cartero antes de cambiar el estado.');
            return;
        }

        $selectedCartero = User::findOrFail($this->selectedCartero);

        Package::where('ESTADO', 'ASIGNADO')
            ->where('CUIDAD', auth()->user()->Regional)
            ->update([
                'ESTADO' => 'CARTERO',
                'usercartero' => $selectedCartero->name,
            ]);

        $this->resetPage();
        session()->flash('success', 'Se cambiaron los estados y asignó el cartero correctamente.');
    }
}
