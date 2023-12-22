<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Package;
use App\Models\Event;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

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
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        $assignedPackages = Package::where('ESTADO', 'ASIGNADO')
            ->where('CUIDAD', $userRegional)
            ->orderBy('updated_at', 'desc')
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
            // Asigna el cartero a cada paquete
            Package::whereIn('id', $this->selectedPackages)
                ->update([
                    'ESTADO' => 'CARTERO', // Cambiado a 'CARTERO'
                    'usercartero' => $carteroSeleccionado,
                ]);

            // Crea eventos para cada paquete asignado
            foreach ($this->selectedPackages as $packageId) {
                $package = Package::findOrFail($packageId);

                Event::create([
                    'action' => 'EN TRASCURSO',
                    'descripcion' => 'Paquete Destinado por envío con Cartero',
                    'user_id' => auth()->user()->id,
                    'codigo' => $package->CODIGO,
                ]);

                // Busca el ID del cartero basándote en su nombre
                $carteroId = User::where('name', $carteroSeleccionado)->value('id');

                Event::create([
                    'action' => 'EN ENTREGA',
                    'descripcion' => 'Paquete en camino a Destino',
                    'user_id' => $carteroId,
                    'codigo' => $package->CODIGO,
                ]);
            }

            // Recupera los datos necesarios para el PDF después de actualizar el estado
            $user = auth()->user();
            $packages = Package::where('ESTADO', 'CARTERO')
                ->whereIn('id', $this->selectedPackages)
                ->where('usercartero', $carteroSeleccionado)
                ->orderBy('created_at', 'desc')
                ->get();

            $pdf = PDF::loadView('package.pdf.asignarcartero', ['packages' => $packages, 'user' => $user]);
            $pdfContent = $pdf->output();

            // Reinicia las selecciones
            $this->selectedPackages = [];
            $this->selectedCartero = null;

            return response()->streamDownload(function () use ($pdfContent) {
                echo $pdfContent;
            }, 'Paquetes Asignados.pdf');

            session()->flash('success', 'Paquetes asignados correctamente.');
        } catch (\Exception $e) {
            // Loguea la excepción para obtener más detalles
            \Log::error('Error al asignar paquetes. Detalles: ' . $e->getMessage());

            session()->flash('error', 'Error al asignar paquetes. Detalles: ' . $e->getMessage());
        }
    }
}

