<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::paginate();

        return view('role.index', compact('roles'))
            ->with('i', (request()->input('page', 1) - 1) * $roles->perPage());
    }

    public function create()
    {
        $permissions = Permission::all();
        $role = new Role();
        return view('role.create', compact('role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
            // Otras reglas de validación según tus necesidades
        ]);
    
        $role = Role::create($request->all());
    
        return redirect()->route('roles.index')
            ->with('success', 'Rol creado correctamente.');
    }

    public function show($id)
    {
        $role = Role::find($id);

        return view('role.show', compact('role'));
    }

    public function edit($id)
    {
        $role = Role::find($id);

        return view('role.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('roles')->ignore($role->id),
            ],
            // Otras reglas de validación según tus necesidades
        ]);
    
        $role->update($request->all());
    
        return redirect()->route('roles.index')
            ->with('success', 'Role actualizado correctamente');
    }

    public function destroy($id)
    {
        $role = Role::find($id)->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role eliminado correctamente');
    }
}
