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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index()
    {
        $mensajes = Mensaje::with('package')->paginate();

        // Pluck para obtener solo los valores de CODIGO de los paquetes
        $codigos = $mensajes->pluck('package.CODIGO');
        $destinatario = $mensajes->pluck('package.DESTINATARIO');
        $telefono = $mensajes->pluck('package.TELEFONO');

        return view('mensaje.index', compact('mensajes', 'codigos','destinatario','telefono'))
            ->with('i', ($mensajes->currentPage() - 1) * $mensajes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mensaje = new Mensaje();
        return view('mensaje.create', compact('mensaje'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Mensaje::$rules);

        $mensaje = Mensaje::create($request->all());

        return redirect()->route('mensajes.index')
            ->with('success', 'Mensaje created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mensaje = Mensaje::find($id);

        return view('mensaje.show', compact('mensaje'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mensaje = Mensaje::find($id);

        return view('mensaje.edit', compact('mensaje'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mensaje $mensaje
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mensaje $mensaje)
    {
        request()->validate(Mensaje::$rules);

        $mensaje->update($request->all());

        return redirect()->route('mensajes.index')
            ->with('success', 'Mensaje updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $mensaje = Mensaje::find($id)->delete();

        return redirect()->route('mensajes.index')
            ->with('success', 'Mensaje deleted successfully');
    }
}
