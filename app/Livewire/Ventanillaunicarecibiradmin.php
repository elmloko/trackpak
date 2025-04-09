<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;

class Ventanillaunicarecibiradmin extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';
    public $zona = '';
    public $paqueteSeleccionado = null;
    public $showModal = false; // Variable para controlar la visibilidad del modal

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Recibir Paqueteria AdminRegional"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }

    public function render()
    {
        $packages = Package::where('ESTADO', 'RECIBIDO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ZONA', 'like', $this->search . '%') 
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where('VENTANILLA', 'UNICA')
            ->orderBy('updated_at', 'desc')
            ->paginate(100);
    
        return view('livewire.ventanillaunicarecibir', [
            'packages' => $packages,
        ]);
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->paquetesSeleccionados = $this->getPackageIds();
        } else {
            $this->paquetesSeleccionados = [];
        }
    }

    public function buscarPaquete()
    {
        $package = Package::where('CODIGO', $this->search)->first();
        $userRegional = auth()->user()->Regional;
        
        if ($package) {
            if ($userRegional === $package->CUIDAD) {
                $package->ESTADO = 'RECIBIDO';
                $package->save();

                $this->paqueteSeleccionado = $package->id;
                $this->zona = $package->ZONA;
                $this->showModal = true; // Mostrar el modal

                session()->flash('success', 'El estado del paquete ha sido actualizado a RECIBIDO.');
            } else {
                session()->flash('error', 'No se puede recibir el paquete porque no pertenece a la misma regional.');
            }
        } else {
            session()->flash('error', 'Paquete no encontrado.');
        }
        
        $this->search = '';
    }

    public function guardarZona()
    {
        if ($this->paqueteSeleccionado) {
            $package = Package::find($this->paqueteSeleccionado);
            $package->ZONA = $this->zona;
            $package->save();

            session()->flash('success', 'La ZONA del paquete ha sido actualizada.');
            $this->showModal = false; // Ocultar el modal
        }
    }

    public function cambiarEstado()
    {
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)
            ->when($this->selectedCity, function ($query) {
                $query->where('CUIDAD', $this->selectedCity);
            })
            ->get();
    
        foreach ($paquetesSeleccionados as $paquete) {
            $peso = $paquete->PESO;
            if ($peso >= 0.000 && $peso <= 0.5) {
                $precio = 5;
            } elseif ($peso > 0.5) {
                $precio = 10;
            }
    
            $paquete->PRECIO = $precio;
            $paquete->save();
    
            $paquete->ESTADO = 'VENTANILLA';
            $paquete->save();
    
            Event::create([
                'action' => 'RECEPCIONADO',
                'descripcion' => 'Paquete llego a ventanilla en Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
            ]);
        }
        $this->resetSeleccion();
    }

    public function toggleSelectSingle($packageId)
    {
        if (in_array($packageId, $this->paquetesSeleccionados)) {
            $this->paquetesSeleccionados = array_diff($this->paquetesSeleccionados, [$packageId]);
        } else {
            $this->paquetesSeleccionados[] = $packageId;
        }
    }

    private function getPackageIds()
    {
        return Package::where('ESTADO', 'RECIBIDO')->pluck('id')->toArray();
    }

    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }

    public function updatedSearch()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = array_intersect($this->paquetesSeleccionados, $this->getPackageIds());
    }

    public function cerrarModal()
    {
        $this->showModal = false; // Método para cerrar el modal desde la vista
    }
}
