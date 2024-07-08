<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;

class Ventanillaunicarecibir extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';

    public function render()
    {
        $userRegional = auth()->user()->Regional;
        $packages = Package::where('ESTADO', 'RECIBIDO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ZONA', 'like', $this->search . '%') 
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->where('VENTANILLA', 'UNICA')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);
    
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
        // Buscar el paquete por el código ingresado
        $package = Package::where('CODIGO', $this->search)->first();
        
        // Si el paquete es encontrado, cambiar su estado a RECIBIDO
        if ($package) {
            $package->ESTADO = 'RECIBIDO';
            $package->save();
            
            // Agregar un mensaje de éxito a la sesión
            session()->flash('success', 'El estado del paquete ha sido actualizado a RECIBIDO.');
        } else {
            // Agregar un mensaje de error a la sesión
            session()->flash('error', 'Paquete no encontrado.');
        }
        
        // Reiniciar la búsqueda
        $this->search = '';
    }

    public function cambiarEstado()
    {
        // Obtener los paquetes seleccionados y actualizar su estado
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)
            ->when($this->selectedCity, function ($query) {
                $query->where('CUIDAD', $this->selectedCity);
            })
            ->get();
    
        foreach ($paquetesSeleccionados as $paquete) {
            // Calcular el precio basado en el peso del paquete
            $peso = $paquete->PESO;
            if ($peso >= 0.000 && $peso <= 0.5) {
                $precio = 5;
            } elseif ($peso > 0.5) {
                $precio = 10;
            }
    
            // Actualizar el precio del paquete
            $paquete->PRECIO = $precio;
            $paquete->save();
    
            // Actualizar el estado del paquete
            $paquete->ESTADO = 'VENTANILLA';
            $paquete->save();
    
            // Crear un evento
            Event::create([
                'action' => 'RECEPCIONADO',
                'descripcion' => 'Paquete llego a ventanilla en Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
            ]);
        }
        // Restablecer la selección
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
}
