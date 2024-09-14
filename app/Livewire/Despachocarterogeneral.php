<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International;
use App\Models\User;  // Importamos el modelo de usuario
use App\Models\Event;
use Livewire\WithPagination;
use App\Exports\CarteroeExport;
use Maatwebsite\Excel\Facades\Excel;

class Despachocarterogeneral extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCartero = '';

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        // Obtener la lista de carteros
        $carteros = User::role('CARTERO')->get();

        $columns = [
            'CODIGO', 'DESTINATARIO', 'TELEFONO', 'PESO', 'ESTADO', 'usercartero', 'updated_at'
        ];

        // Filtrar paquetes por cartero y otros criterios
        $packages = Package::select($columns)
            ->where('ESTADO', 'RETORNO')
            ->when($this->selectedCartero, function ($query) {
                return $query->where('usercartero', $this->selectedCartero);
            })
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->orderBy('updated_at', 'desc');

        // Filtrar también en los paquetes internacionales
        $internationalPackages = International::select($columns)
            ->where('ESTADO', 'RETORNO')
            ->when($this->selectedCartero, function ($query) {
                return $query->where('usercartero', $this->selectedCartero);
            })
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->orderBy('updated_at', 'desc');

        $packages = $packages->union($internationalPackages)->paginate(10);

        return view('livewire.despachocarterogeneral', [
            'packages' => $packages,
            'carteros' => $carteros, // Pasar los carteros a la vista
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
    public function exportToExcel()
    {
        $userRegional = auth()->user()->Regional;
        return Excel::download(new CarteroeExport($this->search, $this->selectedCartero, $userRegional), 'despacho_carteros.xlsx');
    }
}
