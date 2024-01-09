<?php

namespace App\Http\Controllers;

use App\Models\RoleHasPermission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class RoleHasPermissionController
 * @package App\Http\Controllers
 */
class RoleHasPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roleHasPermissions = RoleHasPermission::paginate();
        $permissions = Permission::pluck('name', 'id');
        $roles = Role::pluck('name', 'id');

        return view('role-has-permission.index', compact('roleHasPermissions', 'permissions', 'roles'))
            ->with('i', (request()->input('page', 1) - 1) * $roleHasPermissions->perPage());
    }

    public function create()
    {
        $roleHasPermission = new RoleHasPermission();
        $permissions = Permission::pluck('name', 'id');
        $roles = Role::pluck('name', 'id');
        
        return view('role-has-permission.create', compact('roleHasPermission', 'permissions', 'roles'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(RoleHasPermission::$rules);

        $roleHasPermission = RoleHasPermission::create($request->all());

        return redirect()->route('role-has-permissions.index')
            ->with('success', 'RoleHasPermission created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roleHasPermission = RoleHasPermission::find($id);

        return view('role-has-permission.show', compact('roleHasPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roleHasPermission = RoleHasPermission::find($id);

        return view('role-has-permission.edit', compact('roleHasPermission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  RoleHasPermission $roleHasPermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoleHasPermission $roleHasPermission)
    {
        request()->validate(RoleHasPermission::$rules);

        $roleHasPermission->update($request->all());

        return redirect()->route('role-has-permissions.index')
            ->with('success', 'RoleHasPermission updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $roleHasPermission = RoleHasPermission::find($id)->delete();

        return redirect()->route('role-has-permissions.index')
            ->with('success', 'RoleHasPermission deleted successfully');
    }
}
