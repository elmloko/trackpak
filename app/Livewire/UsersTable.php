<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTable extends Component
{
    use WithPagination;

    public $search = ''; // Campo para búsqueda
    public $searchQuery = ''; // Campo que se actualizará al hacer clic en el botón
    public $newPassword = ''; // Nueva contraseña
    public $userIdBeingUpdated = null; // ID del usuario que será actualizado

    protected $paginationTheme = 'bootstrap'; // Usar paginación de Bootstrap

    // Método que se ejecuta cuando se presiona el botón de búsqueda
    public function searchUsers()
    {
        $this->searchQuery = $this->search; // Actualiza la query de búsqueda
        $this->resetPage(); // Resetea la paginación cuando se realiza una búsqueda
    }

    // Establecer el ID del usuario para cambiar la contraseña y abrir el modal
    public function setPasswordUser($userId)
    {
        $this->userIdBeingUpdated = $userId;
        $this->dispatch('openModal'); // Disparar evento para abrir el modal
    }

    // Método para actualizar la contraseña del usuario
    public function updatePassword()
    {
        $this->validate([
            'newPassword' => 'required|min:6', // Validar que la nueva contraseña tenga al menos 6 caracteres
        ]);

        $user = User::find($this->userIdBeingUpdated);

        if ($user) {
            $user->password = Hash::make($this->newPassword); // Cambiar la contraseña
            $user->save();
            session()->flash('success', 'Contraseña actualizada correctamente.');
        } else {
            session()->flash('error', 'Usuario no encontrado.');
        }

        // Limpiar el campo de la nueva contraseña y el ID del usuario
        $this->newPassword = '';
        $this->userIdBeingUpdated = null;

        // Cerrar el modal después de la actualización
        $this->dispatch('closeModal');
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
