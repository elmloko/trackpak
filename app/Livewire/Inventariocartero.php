<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\Event;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CarteroExport;

class Inventariocartero extends Component
{
    use WithPagination;

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;
    public $user;

    public function render()
    {
        $userasignado = auth()->user()->name;

        $packages = Package::onlyTrashed()
            ->where('usercartero', $userasignado)
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

        return view('livewire.inventariocartero', [
            'packages' => $packages,
        ]);
    }

    public function export()
    {
        $this->user = auth()->user()->name;

        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'user' => 'required|string',
        ]);

        return Excel::download(new CarteroExport($this->fecha_inicio, $this->fecha_fin, $this->user), 'Inventario Ordinario Cartero.xlsx');
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
