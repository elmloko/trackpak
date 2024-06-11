<?php

namespace App\Http\Controllers;

use App\Models\International;
use Illuminate\Http\Request;

class InternationalController extends Controller
{

    public function index()
    {
        $internationals = International::paginate();

        return view('international.index', compact('internationals'))
            ->with('i', (request()->input('page', 1) - 1) * $internationals->perPage());
    }

    public function create()
    {
        $international = new International();
        return view('international.create', compact('international'));
    }

    public function store(Request $request)
    {
        request()->validate(International::$rules);

        $international = International::create($request->all());

        return redirect()->route('internationals.index')
            ->with('success', 'Creacion de Paquete con exito');
    }

    public function show($id)
    {
        $international = International::find($id);

        return view('international.show', compact('international'));
    }

    public function edit($id)
    {
        $international = International::find($id);

        return view('international.edit', compact('international'));
    }

    public function update(Request $request, International $international)
    {
        request()->validate(International::$rules);

        $international->update($request->all());

        return redirect()->route('internationals.index')
            ->with('success', 'Actualizacion de Paquete con exito');
    }

    public function destroy($id)
    {
        $international = International::findOrFail($id);
        $international->delete();

        return redirect()->route('internationals.index')
            ->with('success', 'Baja de Paquete con exito');
    }
    public function restore($id)
    {
        $international = International::withTrashed()->findOrFail($id);
        $international->restore();

        return redirect()->route('internationals.index')
            ->with('success', 'Alta de Paquete con exito');
    }
    public function ventanilladd()
    {
        return view('international.ventanilladd');
    }
}
