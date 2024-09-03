<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Package;
use App\Models\International;
use App\Models\Event;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class TablaPaquetes extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCartero;
    public $selectedPackages = [];

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        // Paquetes nacionales para agregar
        $packagesToAdd = Package::where('ESTADO', 'VENTANILLA')
            ->where('CUIDAD', $userRegional)
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        // Paquetes internacionales para agregar
        $internationalPackagesToAdd = International::where('ESTADO', 'VENTANILLA')
            ->where('CUIDAD', $userRegional)
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        // Combina los resultados de paquetes nacionales e internacionales
        $combinedPackagesToAdd = $packagesToAdd->merge($internationalPackagesToAdd);

        // Paginación manual de los resultados combinados
        $combinedPackagesToAdd = $combinedPackagesToAdd->sortByDesc('updated_at')->values()->forPage(1, 10);

        // Paquetes asignados nacionales
        $assignedPackages = Package::where('ESTADO', 'ASIGNADO')
            ->where('CUIDAD', $userRegional)
            ->orderBy('updated_at', 'desc')
            ->get();

        // Paquetes asignados internacionales
        $internationalAssignedPackages = International::where('ESTADO', 'ASIGNADO')
            ->where('CUIDAD', $userRegional)
            ->orderBy('updated_at', 'desc')
            ->get();

        // Combina los resultados de paquetes asignados nacionales e internacionales
        $combinedAssignedPackages = $assignedPackages->merge($internationalAssignedPackages);
        $combinedAssignedPackages = $combinedAssignedPackages->sortByDesc('updated_at')->values()->forPage(1, 10);

        return view('livewire.tabla-paquetes', [
            'packagesToAdd' => $combinedPackagesToAdd,
            'assignedPackages' => $combinedAssignedPackages,
            'carters' => User::role('CARTERO')->get(),
        ]);
    }

    public function agregarPaquete($packageId)
    {
        // Intenta encontrar el paquete en el modelo Package
        $package = Package::find($packageId);

        // Si no se encuentra en el modelo Package, intenta en el modelo International
        if (!$package) {
            $package = International::findOrFail($packageId);
        }

        // Verifica si el paquete ya está seleccionado
        if (!in_array($packageId, $this->selectedPackages)) {
            $this->selectedPackages[] = $packageId;
            $package->update(['ESTADO' => 'ASIGNADO']);
            $package->update(['PRECIO' => '10']);
            $package->touch();
        }
    }

    public function quitarPaquete($packageId)
    {
        // Intenta encontrar el paquete en el modelo Package
        $package = Package::find($packageId);

        // Si no se encuentra en el modelo Package, intenta en el modelo International
        if (!$package) {
            $package = International::findOrFail($packageId);
        }

        // Elimina el paquete de la lista de seleccionados
        $this->selectedPackages = array_diff($this->selectedPackages, [$packageId]);

        // Calcular el precio basado en el peso
        $peso = $package->PESO;
        $precio = 0;

        if ($peso >= 0.001 && $peso <= 0.5) {
            $precio = 5;
        } elseif ($peso > 0.5) {
            $precio = 10;
        }

        // Actualizar el estado y el precio calculado
        $package->update(['PRECIO' => $precio]);
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
            // Asigna el cartero a los paquetes nacionales
            Package::whereIn('id', $this->selectedPackages)
                ->update([
                    'ESTADO' => 'CARTERO',
                    'usercartero' => $carteroSeleccionado,
                ]);

            // Asigna el cartero a los paquetes internacionales
            International::whereIn('id', $this->selectedPackages)
                ->update([
                    'ESTADO' => 'CARTERO',
                    'usercartero' => $carteroSeleccionado,
                ]);

            // Crea eventos para cada paquete asignado
            foreach ($this->selectedPackages as $packageId) {
                // Verifica si el paquete es nacional o internacional
                $package = Package::find($packageId);
                if (!$package) {
                    $package = International::findOrFail($packageId);
                }

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

            // Recupera los datos necesarios para el PDF
            $packages = Package::where('ESTADO', 'CARTERO')
                ->whereIn('id', $this->selectedPackages)
                ->where('usercartero', $carteroSeleccionado)
                ->orderBy('created_at', 'desc')
                ->get();

            $internationalPackages = International::where('ESTADO', 'CARTERO')
                ->whereIn('id', $this->selectedPackages)
                ->where('usercartero', $carteroSeleccionado)
                ->orderBy('created_at', 'desc')
                ->get();

            // Combina los resultados de paquetes nacionales e internacionales
            $combinedPackages = $packages->concat($internationalPackages);

            // Genera el PDF con los detalles
            $pdf = PDF::loadView('package.pdf.asignarcartero', [
                'packages' => $combinedPackages, 
                'cartero' => $carteroSeleccionado
            ]);
            $pdfContent = $pdf->output();

            $this->dispatch('pdf-generated');
            // Devuelve el PDF como una descarga
            return response()->streamDownload(function () use ($pdfContent) {
                echo $pdfContent;
            }, 'Paquetes Asignados.pdf');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al asignar paquetes: ' . $e->getMessage());
        }
    }
}
