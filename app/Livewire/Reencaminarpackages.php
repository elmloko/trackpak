<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReencaminarExport;
use App\Models\Event;

class Reencaminarpackages extends Component
{
    use WithPagination;

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;
    public $editPackageId;
    public $editCiudad;
    public $editVentanilla;

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Reencaminar Paquetes"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }
    public function render()
    {
        $packages = Package::where('ESTADO', 'REENCAMINADO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%') // Mantenido como 'CUIDAD'
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return view('livewire.reencaminarpackages', [
            'packages' => $packages,
        ]);
    }
    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);
    
        return Excel::download(new ReencaminarExport($this->fecha_inicio, $this->fecha_fin), 'Paquetes Reencaminados.xlsx');
    }
    public function editPackage($id)
    {
        $package = Package::findOrFail($id);
        $this->editPackageId = $package->id;
        $this->editCiudad = $package->CUIDAD;
        $this->editVentanilla = $package->VENTANILLA;
    }

    public function updatePackage()
    {
        $package = Package::findOrFail($this->editPackageId);
        $package->CUIDAD = $this->editCiudad;
        $package->VENTANILLA = $this->editVentanilla;
        $package->ESTADO = 'CLASIFICACION';
        $package->save();

        // Reset fields
        $this->reset(['editPackageId', 'editCiudad', 'editVentanilla']);

        // Close the modal
        $this->dispatch('closeModal');

        session()->flash('message', 'Paquete actualizado exitosamente.');
    }
}
