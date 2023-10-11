<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate();

        return view('user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $roles = Role::all();
        return view('user.create', compact('user','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
    
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password')); // Encriptar la contraseña
    
        $user->save();

        $user->assignRole($request->input('roles'));
        
        return redirect()->route('users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();

        return view('user.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id, // Utiliza $user->id
    ]);

    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->roles()->sync($request->roles);

    $user->save();

    return redirect()->route('users.index')
        ->with('success', 'Usuario actualizado correctamente');
}


    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
    public function excel()
    {
        return Excel::download(new UserExport, 'UsuariosRegistrados.xlsx');
    }

    public function pdf()
    {
        return Excel::download(new UserExport, 'UsuariosRegistrados.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    } 
    public function delete($id)
    {
        $user = User::find($id)->delete();

        return back()->with('success', 'Usuario se dio de Baja Con Exito!');
    }
    public function deleteado()
    {
        // Recupera todos los elementos eliminados (soft deleted)
        $deleteadoUser = User::onlyTrashed()->paginate(20);

        return view('users.deleteado', compact('deleteadoUser'));
    }
    public function restoring($id)
    {
        // Restaura el paquete con el ID dado
        $user = User::withTrashed()->find($id);
        // Verifica si se encontró un paquete eliminado con ese ID
        if ($user) {
            // Restaura el paquete
            $user->restore();
            return redirect()->route('users.index')
                ->with('success', 'El paquete ha sido restaurado exitosamente');
        } else {
            return redirect()->route('users.index')
                ->with('error', 'El paquete no pudo ser encontrado o restaurado');
        }
    }
}
