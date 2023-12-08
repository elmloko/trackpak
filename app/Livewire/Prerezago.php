<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;

class Prerezago extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];

    public function render()
    {
        $packages = Package::where('ESTADO', 'PRE-REZAGO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('dateprerezago', 'like', '%' . $this->search . '%');
            })
            ->orderBy('dateprerezago', 'desc')
            ->paginate(10);

        return view('livewire.prerezago', [
            'packages' => $packages,
        ]);
    }

    public function toggleSelectAll()
    {
        $this->selectAll = !$this->selectAll;

        if ($this->selectAll) {
            $this->paquetesSeleccionados = $this->packages->pluck('id')->map(function ($id) {
                return (string) $id;
            })->toArray();
        } else {
            $this->paquetesSeleccionados = [];
        }
    }

    public function selectAllPackages()
    {
        $this->selectAll = !$this->selectAll;

        if ($this->selectAll) {
            $this->paquetesSeleccionados = $this->packages->pluck('id')->map(function ($id) {
                return (string) $id;
            })->toArray();
        } else {
            $this->paquetesSeleccionados = [];
        }
    }

        public function cambiarEstado()
    {
        foreach ($this->paquetesSeleccionados as $packageId) {
            $paquete = Package::find($packageId);

            // Cambiar el estado del paquete
            $paquete->update([
                'ESTADO' => 'REZAGO',
                'daterezago' => now()->toDateTimeString(), // Asegúrate de que 'daterezago' sea el nombre correcto del campo
            ]);

            // Crear un nuevo evento
            Event::create([
                'action' => 'ALMACEN',
                'descripcion' => 'Destino de Ventanilla hacia Almacen',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
            ]);
            $paquete->save();
        }

        // Limpiar la selección después de almacenar
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];

        // Actualizar la lista de paquetes después de cambiar el estado
        $this->render();
    }
}
