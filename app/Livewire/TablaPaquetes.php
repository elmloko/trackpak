<?php
// app/Livewire/TablaPaquetes.php

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
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%');
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
            'carters' => User::role('CARTERO')->get(), // Ajusta según tu lógica de roles
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
        Package::where('ESTADO', 'ASIGNADO')
            ->where('usercartero', auth()->user()->name)
            ->update(['ESTADO' => 'CARTERO']);

        $this->resetPage(); // Para reiniciar la paginación después de la actualización
    }
}