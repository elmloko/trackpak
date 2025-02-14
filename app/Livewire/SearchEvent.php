<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Livewire\WithPagination;
use App\Exports\EventsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

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
            ->paginate(100);

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
            // Ejecutar el comando de backup
            Artisan::call('backup:project');
            $output = Artisan::output();

            // Extraer la ruta del archivo de backup del output
            if (preg_match('/Backup generado correctamente: (.+)$/m', $output, $matches)) {
                $fullPath = trim($matches[1]);
                // Convertir la ruta absoluta a relativa (asumiendo que está en storage/app)
                $relativePath = str_replace(storage_path('app') . DIRECTORY_SEPARATOR, '', $fullPath);

                // Redirigir a la ruta que realizará la descarga
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
            // Invocar el comando backup
            Artisan::call('deploy');

            // Emitir un evento para cerrar el modal
            $this->dispatch('close-modal');

            // Mensaje de éxito
            session()->flash('message', 'Cambios hechos satisfactoriamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al traer los cambios: ' . $e->getMessage());
        }
    }
}
