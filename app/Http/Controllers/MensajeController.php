<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Package;
use Illuminate\Http\Request;

/**
 * Class MensajeController
 * @package App\Http\Controllers
 */
class MensajeController extends Controller
{
    public function index()
    {
        $mensajes = Mensaje::with('id_telefono')->paginate();
        $packages = Package::paginate();
    
        return view('mensaje.index', compact('mensajes', 'packages'))
            ->with('i', (request()->input('page', 1) - 1) * $mensajes->perPage())
            ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }    

    public function create()
    {
        $mensaje = new Mensaje();
        return view('mensaje.create', compact('mensaje'));
    }

    public function store(Request $request)
    {
        request()->validate(Mensaje::$rules);

        $mensaje = Mensaje::create($request->all());

        return redirect()->route('mensajes.index')
            ->with('success', 'Mensaje created successfully.');
    }

    public function show($id)
    {
        $mensaje = Mensaje::find($id);

        return view('mensaje.show', compact('mensaje'));
    }

    public function edit($id)
    {
        $mensaje = Mensaje::find($id);

        return view('mensaje.edit', compact('mensaje'));
    }

    public function update(Request $request, Mensaje $mensaje)
    {
        request()->validate(Mensaje::$rules);

        $mensaje->update($request->all());

        return redirect()->route('mensajes.index')
            ->with('success', 'Mensaje updated successfully');
    }

    public function destroy($id)
    {
        $mensaje = Mensaje::find($id)->delete();

        return redirect()->route('mensajes.index')
            ->with('success', 'Mensaje deleted successfully');
    }
}
