<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\User;
use Livewire\WithPagination;
use App\Exports\EventsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;

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
        $users = User::all(); // Obtener todos los usuarios

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
        ->paginate(100); // Elegí 100, tú decides si prefieres 50

        return view('livewire.events-packages', [
            'events' => $events,
            'users' => $users,
        ]);
    }

    public function exportToExcel()
    {
        return Excel::download(new EventsExport($this->search, $this->selectedUserId), 'events.xlsx');
    }

    public function backupProject()
    {
        try {
            Artisan::call('backup:project');
            $output = Artisan::output();

            if (preg_match('/Backup generado correctamente: (.+)$/m', $output, $matches)) {
                $fullPath = trim($matches[1]);
                $relativePath = str_replace(storage_path('app') . DIRECTORY_SEPARATOR, '', $fullPath);

                return redirect()->to(route('backup.download', ['file' => urlencode($relativePath)]));
            } else {
                session()->flash('error', 'No se encontró el archivo de backup.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al generar el backup: ' . $e->getMessage());
        }
    }

    public function gitProject()
    {
        try {
            Artisan::call('deploy');

            $this->dispatch('close-modal');

            session()->flash('message', 'Cambios hechos satisfactoriamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al traer los cambios: ' . $e->getMessage());
        }
    }
}
