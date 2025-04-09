<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;

class SearchPackages extends Component
{
    use WithPagination;

    public $search = '';

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Todos los paquetes Ordinario"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }

    public function render()
    {
        $packages = Package::withTrashed() // Incluye los paquetes eliminados suavemente
            ->where('CODIGO', 'like', '%' . $this->search . '%')
            ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
            ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
            ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
            ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
            ->orWhere('ESTADO', 'like', '%' . $this->search . '%')
            ->orWhere('created_at', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return view('livewire.search-packages', [
            'packages' => $packages,
        ]);
    }
    public function eliminarPaquete($id)
    {
        // Encuentra el paquete
        $package = Package::find($id);

        // Verifica si el paquete existe
        if ($package) {
            $codigo = $package->CODIGO; // Obtiene el código antes de eliminar el paquete

            // Elimina el paquete permanentemente
            $package->forceDelete();

            // Crea el evento de eliminación
            Event::create([
                'action' => 'ESTADO',
                'descripcion' => 'Eliminación de Paquete',
                'user_id' => auth()->user()->id,
                'codigo' => $codigo,
            ]);

            // Mensaje de éxito
            session()->flash('success', 'Paquete Eliminado Con Éxito!');
        } else {
            // Mensaje de error si el paquete no existe
            session()->flash('error', 'Paquete no encontrado.');
        }
    }
}
