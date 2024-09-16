<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UsersTable extends Component
{
    use WithPagination;

    public $search = ''; // Campo para búsqueda
    public $searchQuery = ''; // Campo que se actualizará al hacer clic en el botón

    protected $paginationTheme = 'bootstrap'; // Usar paginación de Bootstrap

    // Método que se ejecuta cuando se presiona el botón de búsqueda
    public function searchUsers()
    {
        $this->searchQuery = $this->search; // Actualiza la query de búsqueda
        $this->resetPage(); // Resetea la paginación cuando se realiza una búsqueda
    }

    public function render()
    {
        // Obtener los usuarios con paginación y filtrados por el campo de búsqueda
        $users = User::withTrashed()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%')
                      ->orWhere('email', 'like', '%' . $this->searchQuery . '%');
            })
            ->paginate(10);

        return view('livewire.users-table', ['users' => $users]);
    }
}
