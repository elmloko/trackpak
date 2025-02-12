<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International;
use App\Models\User;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CarteroeGeneralExport;
use App\Models\Event;

class Carterosgeneral extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCartero = '';

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Entregas Paqueteria CarteroAdmin"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }

    public function render()
    {
        // Obtener todos los usuarios con rol CARTERO usando Spatie Laravel Permission
        $carteros = User::role('CARTERO')->get();

        $userRegional = auth()->user()->Regional;

        $columns = ['CODIGO', 'DESTINATARIO', 'TELEFONO', 'ADUANA', 'updated_at', 'ESTADO', 'usercartero', 'PESO', 'TIPO'];

        // Filtrar paquetes según el cartero seleccionado
        $packages = Package::select($columns)
            ->where('ESTADO', 'CARTERO')
            ->when($this->selectedCartero, function ($query) {
                return $query->where('usercartero', $this->selectedCartero);
            })
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->orderBy('updated_at', 'desc');

        $internationalPackages = International::select($columns)
            ->where('ESTADO', 'CARTERO')
            ->when($this->selectedCartero, function ($query) {
                return $query->where('usercartero', $this->selectedCartero);
            })
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->orderBy('updated_at', 'desc');

        // Unión de ambos resultados
        $packages = $packages->union($internationalPackages)->paginate(10);

        return view('livewire.carterosgeneral', [
            'packages' => $packages,
            'carteros' => $carteros,
        ]);
    }
    public function exportToExcel()
    {
        // Obtener la regional del usuario logueado
        $userRegional = auth()->user()->Regional;

        return Excel::download(new CarteroeGeneralExport($this->search, $this->selectedCartero, $userRegional), 'Entregas Cartero.xlsx');
    }
}
