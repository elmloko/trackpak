<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;

class Traspasoventanillas extends Component
{
    use WithPagination;

    public $searchTerm; // Variable para el código de búsqueda

    public function searchPackage()
    {
        // Buscar el paquete por el código de rastreo y estado 'VENTANILLA'
        $package = Package::where('CODIGO', $this->searchTerm)
            ->where('ESTADO', 'VENTANILLA')
            ->first();

        if ($package) {
            // Actualizar el estado del paquete a 'TRASPAZO'
            $package->ESTADO = 'TRASPAZO';
            $package->save();

            session()->flash('message', 'El paquete con código ' . $this->searchTerm . ' ha sido actualizado a TRASPAZO.');
        } else {
            session()->flash('message', 'No se encontró ningún paquete con el código o el estado no es VENTANILLA.');
        }
    }

    public function quitarVentana($packageId)
    {
        // Buscar el paquete por ID
        $package = Package::find($packageId);

        if ($package) {
            // Actualizar el estado del paquete a 'QUITADO'
            $package->ESTADO = 'VENTANILLA';
            $package->save();

            session()->flash('message', 'El paquete ha sido quitado de la ventanilla.');
        }
    }

    public function render()
    {
        // Filtrar los paquetes con estado 'TRASPAZO' para mostrarlos en la tabla
        $packages = Package::where('ESTADO', 'TRASPAZO')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Retornar la vista con los paquetes filtrados
        return view('livewire.traspasoventanillas', [
            'packages' => $packages,
        ]);
    }
}
