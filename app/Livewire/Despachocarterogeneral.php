<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International; // Importa el modelo International
use Livewire\WithPagination;
use App\Models\Event;

class Despachocarterogeneral extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        // Define las columnas que deben ser seleccionadas en ambas consultas
        $columns = [
            'CODIGO',
            'DESTINATARIO',
            'TELEFONO',
            'ADUANA',
            'created_at',
            'ESTADO',
            'usercartero',
            'PESO',
            'TIPO',
            'updated_at'
        ];

        // Consulta para obtener paquetes de la tabla Package
        $packages = Package::select($columns)
            ->where('ESTADO', 'RETORNO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->orderBy('created_at', 'desc');

        // Consulta para obtener paquetes de la tabla International
        $internationalPackages = International::select($columns)
            ->where('ESTADO', 'RETORNO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->orderBy('created_at', 'desc');

        // Une ambos conjuntos de resultados
        $packages = $packages->union($internationalPackages)->paginate(10);

        return view('livewire.despachocarterogeneral', [
            'packages' => $packages,
        ]);
    }
    public function recuperar($codigo)
    {
        $package = Package::where('CODIGO', $codigo)->first();
        if ($package) {
            Event::create([
                'action' => 'DEVUELTO',
                'descripcion' => 'Paquete Devuelto a Oficina Postal Regional.',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            $package->ESTADO = 'VENTANILLA';
            $package->save();
        } else {
            $internationalPackage = International::where('CODIGO', $codigo)->first();
            if ($internationalPackage) {
                Event::create([
                    'action' => 'DEVUELTO',
                    'descripcion' => 'Paquete Devuelto a Oficina Postal Regional.',
                    'user_id' => auth()->user()->id,
                    'codigo' => $internationalPackage->CODIGO,
                ]);
                $internationalPackage->ESTADO = 'VENTANILLA';
                $internationalPackage->save();
            }
        }

        session()->flash('success', 'El paquete ha sido recuperado y su estado ha sido actualizado a VENTANILLA.');
    }
}
