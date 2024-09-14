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
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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
