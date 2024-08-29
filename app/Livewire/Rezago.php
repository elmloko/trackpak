<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RezagoExport;

class Rezago extends Component
{
    use WithPagination; // Mueve el uso de WithPagination aquí

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;

    public function render()
    {
        $packages = $this->getPackages();

        return view('livewire.rezago', [
            'packages' => $packages,
        ]);
    }
    public function getPackages()
    {
        $packageQuery = Package::where('ESTADO', 'REZAGO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->select('id', 'CODIGO', 'DESTINATARIO', 'TELEFONO', 'CUIDAD', 'VENTANILLA', 'PESO', 'ESTADO', 'OBSERVACIONES', 'created_at');

        $internationalQuery = International::where('ESTADO', 'REZAGO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->select('id', 'CODIGO', 'DESTINATARIO', 'TELEFONO', 'CUIDAD', 'VENTANILLA', 'PESO', 'ESTADO', 'OBSERVACIONES', 'created_at');

        return $packageQuery->union($internationalQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);
    
        return Excel::download(new RezagoExport($this->fecha_inicio, $this->fecha_fin), 'Paquetes Rezagados.xlsx');
    }
}
