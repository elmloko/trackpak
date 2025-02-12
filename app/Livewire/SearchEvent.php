<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Livewire\WithPagination;
use App\Exports\EventsExport;
use Maatwebsite\Excel\Facades\Excel;

class SearchEvent extends Component
{
    use WithPagination;

    public $search = ''; // Para búsqueda en el campo 'codigo'
    public $selectedUserId = ''; // Para búsqueda por 'user_id'

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Consulta de Eventos del Sistema"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }

    public function render()
    {
        $users = \App\Models\User::all(); // Obtener todos los usuarios

        $events = Event::with(['user' => function ($query) {
            $query->withTrashed();
        }])
            ->when($this->search, function ($query) {
                return $query->where('codigo', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedUserId, function ($query) {
                return $query->where('user_id', $this->selectedUserId);
            })
            ->when(!auth()->user()->hasRole('SuperAdmin'), function ($query) {
                return $query->where('action', '!=', 'INGRESO'); // Ocultar eventos de ingreso
            })
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('livewire.events-packages', [
            'events' => $events,
            'users' => $users, // Pasar los usuarios a la vista
        ]);
    }
    public function exportToExcel()
    {
        return Excel::download(new EventsExport($this->search, $this->selectedUserId), 'events.xlsx');
    }
}
