<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CarteroGeneralExport;
use App\Models\Event;

class Generalcartero extends Component
{
    use WithPagination; // Mueve el uso de WithPagination aquí

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;

    public function render()
    {
        $packages = Package::onlyTrashed()
    ->when($this->search, function ($query) {
        $query->where('CODIGO', 'like', '%' . $this->search . '%')
            ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
            ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
            ->orWhere('PAIS', 'like', '%' . $this->search . '%')
            ->orWhere('CUIDAD', 'like', '%' . $this->search . '%') // Mantenido como 'CUIDAD'
            ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
            ->orWhere('TIPO', 'like', '%' . $this->search . '%')
            ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
            ->orWhere('deleted_at', 'like', '%' . $this->search . '%');
        })
        ->whereIn('ESTADO', ['REPARTIDO'])
        ->orderBy('deleted_at', 'desc')
        ->paginate(10);


        return view('livewire.generalcartero', [
            'packages' => $packages,
        ]);
    }
    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        return Excel::download(new CarteroGeneralExport($this->fecha_inicio, $this->fecha_fin), 'Inventario Ordinario Cartero.xlsx');
    }
    public function restorePackage($id)
    {
        $package = Package::withTrashed()->find($id);
        if ($package) {
            Event::create([
                'action' => 'ESTADO',
                'descripcion' => 'Alta de Paquete',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            $package->update(['ESTADO' => 'VENTANILLA']);
            $package->restore();
            session()->flash('success', 'El paquete ha sido restaurado exitosamente');
        } else {
            session()->flash('error', 'El paquete no pudo ser encontrado o restaurado');
        }
    }
}
