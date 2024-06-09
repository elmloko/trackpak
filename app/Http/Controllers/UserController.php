<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::withTrashed()->paginate(); // Incluye usuarios eliminados

        return view('user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    public function create()
    {
        $user = new User();
        $roles = Role::all();
        return view('user.create', compact('user','roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'Regional' => 'required',
            'ci' => 'required',
        ]);
    
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password')); // Encriptar la contraseña
        $user->Regional = $request->input('Regional');
        $user->ci = $request->input('ci');

        $user->save();

        $user->assignRole($request->input('roles'));
        
        return redirect()->route('users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();

        return view('user.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id, // Utiliza $user->id
            'Regional' => 'required',
            'ci' => 'required',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->roles()->sync($request->roles);
        $user->Regional = $request->input('Regional');
        $user->ci = $request->input('ci');
        
        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario dado de baja correctamente');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index')
            ->with('success', 'Usuario reactivado correctamente');
    }
}
