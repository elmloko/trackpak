<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BagController extends Controller
{

    public function index()
    {
        return view('bag.index');
    }

    public function create()
    {
        $bag = new Bag();
        return view('bag.create', compact('bag'));
    }

    public function store(Request $request)
    {
        request()->validate(Bag::$rules);

        $bag = Bag::create($request->all());

        return redirect()->route('bags.index')
            ->with('success', 'Bag created successfully.');
    }

    public function show($id)
    {
        // Obtener la bolsa según el ID
        $bag = Bag::findOrFail($id);
        
        // Pasar el ID de la bolsa a la vista
        return view('bag.show', ['bagId' => $id]);
    }
    public function edit($id)
    {
        $bag = Bag::find($id);

        return view('bag.edit', compact('bag'));
    }

    public function update(Request $request, Bag $bag)
    {
        request()->validate(Bag::$rules);

        $bag->update($request->all());

        return redirect()->route('bags.index')
            ->with('success', 'Bag updated successfully');
    }

    public function destroy($id)
    {
        $bag = Bag::find($id)->delete();

        return redirect()->route('bags.index')
            ->with('success', 'Bag deleted successfully');
    }
    public function closeExpedition($id, Request $request)
    {
        $bag = Bag::find($id);

        // Verifica si la bolsa existe
        if (!$bag) {
            return redirect()->route('bags.index')
                ->with('success', 'El despacho no se pudo cerrar');
        }

        // Actualiza los campos adicionales
        $bag->update([
            'PESO' => $request->input('PESO'),
            'ITINERARIO' => $request->input('ITINERARIO'),
            'ESTADO' => 'CIERRE',
        ]);

        return redirect()->route('bags.index')
            ->with('success', 'Despacho cerrado con exito!');
    }
    public function bagsclose()
    {
        return view('bag.bagsclose');
    }
}
