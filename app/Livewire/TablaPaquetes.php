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
    public $selectedPackages = [];

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
            'carters' => User::role('CARTERO')->get(),
        ]);
    }

    public function agregarPaquete($packageId)
    {
        $package = Package::findOrFail($packageId);

        // Verifica si el paquete ya está seleccionado
        if (!in_array($packageId, $this->selectedPackages)) {
            $this->selectedPackages[] = $packageId;
            $package->update(['ESTADO' => 'ASIGNADO']);
            $package->touch();
        }
    }

    public function quitarPaquete($packageId)
    {
        $package = Package::findOrFail($packageId);
        $this->selectedPackages = array_diff($this->selectedPackages, [$packageId]);
        $package->update(['ESTADO' => 'VENTANILLA']);
        $package->touch();
    }

    public function asignarPaquetes()
    {
        // Verifica si se ha seleccionado un cartero
        if (!$this->selectedCartero) {
            session()->flash('error', 'Seleccione un cartero antes de asignar paquetes.');
            return;
        }

        // Guarda el cartero seleccionado en una variable
        $carteroSeleccionado = $this->selectedCartero;

        // Verifica si hay paquetes seleccionados
        if (empty($this->selectedPackages)) {
            session()->flash('error', 'No hay paquetes seleccionados para asignar.');
            return;
        }

        try {
            // Obtén los paquetes seleccionados
            $packagesToAdd = Package::whereIn('id', $this->selectedPackages)->get();

            // Asigna el cartero a cada paquete
            foreach ($packagesToAdd as $package) {
                $package->update([
                    'ESTADO' => 'CARTERO',
                    'usercartero' => $carteroSeleccionado,
                ]);
                $package->touch();
            }

            // Reinicia las selecciones
            $this->selectedPackages = [];
            $this->selectedCartero = null;

            session()->flash('success', 'Paquetes asignados correctamente.');
        } catch (\Exception $e) {
            // Captura y maneja cualquier excepción
            session()->flash('error', 'Error al asignar paquetes. Detalles: ' . $e->getMessage());
        }
    }
}
