<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Package;
use App\Models\International;
use App\Models\Event;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RezagoExport;
use Barryvdh\DomPDF\Facade\Pdf;

class Rezago extends Component
{
    use WithPagination;

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Rezago de Paquetes"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }

    public function render()
    {
        return view('livewire.rezago', [
            'packages' => $this->getPackages(),
            'internationals' => $this->getInternationals()
        ]);
    }

    public function getPackages()
    {
        return Package::where('ESTADO', 'REZAGO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(100);
    }

    public function getInternationals()
    {
        return International::where('ESTADO', 'REZAGO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(50);
    }

    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        return Excel::download(new RezagoExport($this->fecha_inicio, $this->fecha_fin), 'Paquetes_Rezagados.xlsx');
    }

    public function devolverPaquete($packageId, $modelType)
    {
        // Determinar si el paquete pertenece a Package o International
        if ($modelType == 'Package') {
            $package = Package::find($packageId);
        } else {
            $package = International::find($packageId);
        }

        if ($package) {
            $package->update([
                'ESTADO' => 'PRE-REZAGO',
                'updated_at' => now(),
            ]);

            Event::create([
                'action' => 'DEVOLUCION',
                'descripcion' => 'Devolución a URBANO',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);

            session()->flash('success', 'El paquete ha sido devuelto a Ventanilla.');

            // Refrescar los datos en la vista
            $this->render();
        } else {
            session()->flash('error', 'Paquete no encontrado.');
        }
    }
}
