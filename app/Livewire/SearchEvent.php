<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Livewire\WithPagination;
use App\Exports\EventsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;

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
    public function backupProject()
    {
        try {
            // Invocar el comando backup
            Artisan::call('backup:project');
    
            // Emitir un evento para cerrar el modal
            $this->dispatch('close-modal');
    
            // Mensaje de éxito
            session()->flash('message', 'Backup generado satisfactoriamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al generar el backup: ' . $e->getMessage());
        }
    }
    
}
