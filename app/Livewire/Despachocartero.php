<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International; // Importa el modelo International
use Livewire\WithPagination;
use App\Models\Event;

class Despachocartero extends Component
{
    use WithPagination;

    public $search = '';

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Despacho de Paqueteria Carteros"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }

    public function render()
    {
        $userRegional = auth()->user()->Regional;
        $userasignado = auth()->user()->name;

        // Define las columnas que deben ser seleccionadas en ambas consultas
        $columns = [
            'CODIGO', 'DESTINATARIO', 'TELEFONO', 'ADUANA', 'created_at', 'ESTADO' , 'usercartero' , 'PESO' ,'foto','firma', 'TIPO' , 'updated_at'
        ];

        // Consulta para obtener paquetes de la tabla Package
        $packages = Package::select($columns)
            ->where('ESTADO', 'RETORNO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->where('usercartero', $userasignado)
            ->orderBy('created_at', 'desc');

        // Consulta para obtener paquetes de la tabla International
        $internationalPackages = International::select($columns)
            ->where('ESTADO', 'RETORNO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->where('usercartero', $userasignado)
            ->orderBy('created_at', 'desc');

        // Une ambos conjuntos de resultados
        $packages = $packages->union($internationalPackages)->paginate(100);

        return view('livewire.despachocartero', [
            'packages' => $packages,
        ]);
    }
}
