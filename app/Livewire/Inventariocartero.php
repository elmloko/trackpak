<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International; // Importa el modelo International
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

        // Define las columnas que deben ser seleccionadas en ambas consultas
        $columns = [
            'CODIGO',
            'DESTINATARIO',
            'TELEFONO',
            'TIPO',
            'ADUANA',
            'OBSERVACIONES',
            'PESO',
            'deleted_at',
            'firma',
            'ESTADO'
        ];

        // Consulta para obtener paquetes de la tabla Package que han sido eliminados
        $packages = Package::onlyTrashed()
            ->select($columns)
            ->where('usercartero', $userasignado)
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
            ->where('usercartero', $userasignado)
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('deleted_at', 'like', '%' . $this->search . '%');
            })
            ->whereIn('ESTADO', ['REPARTIDO'])
            ->orderBy('deleted_at', 'desc');

        // Une ambos conjuntos de resultados
        $packages = $packages->union($internationalPackages)->paginate(10);

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
