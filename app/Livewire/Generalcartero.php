<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International; // Importa el modelo International
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CarteroGeneralExport;
use App\Models\Event;

class Generalcartero extends Component
{
    use WithPagination;

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;

    public function render()
    {
        // Define las columnas que deben ser seleccionadas en ambas consultas
        $columns = [
            'CODIGO',
            'DESTINATARIO',
            'TELEFONO',
            'TIPO',
            'deleted_at',
            'OBSERVACIONES',
            'PESO',
            'ESTADO',
            'usercartero',
        ];

        // Consulta para obtener paquetes de la tabla Package que han sido eliminados
        $packages = Package::onlyTrashed()
            ->select($columns)
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('deleted_at', 'like', '%' . $this->search . '%');
            })
            ->whereIn('ESTADO', ['REPARTIDO'])
            ->orderBy('deleted_at', 'desc');

        // Consulta para obtener paquetes internacionales que han sido eliminados
        $internationalPackages = International::onlyTrashed()
            ->select($columns)
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('deleted_at', 'like', '%' . $this->search . '%');
            })
            ->whereIn('ESTADO', ['REPARTIDO'])
            ->orderBy('deleted_at', 'desc');

        // Une ambos conjuntos de resultados
        $packages = $packages->union($internationalPackages)->paginate(100);

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
    public function restore($codigo)
    {
        // Intenta restaurar el paquete de la tabla Package
        $package = Package::onlyTrashed()->where('CODIGO', $codigo)->first();
        if ($package) {
            Event::create([
                'action' => 'ESTADO',
                'descripcion' => 'Alta de Paquete',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            $package->restore();
            $package->ESTADO = 'VENTANILLA';
            $package->save();
        } else {
            // Si no se encuentra en Package, intenta restaurar en International
            $internationalPackage = International::onlyTrashed()->where('CODIGO', $codigo)->first();
            if ($internationalPackage) {
                Event::create([
                    'action' => 'ESTADO',
                    'descripcion' => 'Alta de Paquete',
                    'user_id' => auth()->user()->id,
                    'codigo' => $internationalPackage->CODIGO,
                ]);
                $internationalPackage->restore();
                $internationalPackage->ESTADO = 'VENTANILLA';
                $internationalPackage->save();
            }
        }
        session()->flash('success', 'El paquete ha sido restaurado y su estado ha sido actualizado a VENTANILLA.');
    }
}
