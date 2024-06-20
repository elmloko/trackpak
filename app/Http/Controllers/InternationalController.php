<?php

namespace App\Http\Controllers;

use App\Models\International;
use App\Models\Event;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Internationaldd;
use App\Exports\Internationaldnd;
use App\Exports\Internationalinvdd;
use App\Exports\Internationalinvdnd;

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
        // Validación de datos
        $request->validate([
            'CODIGO' => 'required|string|max:20|regex:/^[A-Z0-9]+$/',
            'DESTINATARIO' => 'required|string|max:255|regex:/^[A-Z\s]+$/',
            'TELEFONO' => 'required|numeric',
            'ZONA' => 'required|string|max:255|regex:/^[A-Z\s]+$/',
            'PESO' => 'required|string|regex:/^\d+(\.\d{1,3})?$/|between:0.001,10.000',
            'TIPO' => 'required|string|in:PAQUETE GRANDE,PAQUETE PEQUEÑO,SOBRE',
            'ADUANA' => 'required|string|in:SI,NO',
            'VENTANILLA' => 'required|in:DND,DD',
        ]);

        // Obtener los datos del request y convertir a mayúsculas
        $codigo = strtoupper($request->input('CODIGO'));
        $destinatario = strtoupper($request->input('DESTINATARIO'));
        $telefono = $request->input('TELEFONO');
        $peso = $request->input('PESO');
        $ventanilla = strtoupper($request->input('VENTANILLA')); // Asegúrate de que este campo sea capturado correctamente
        $zona = strtoupper($request->input('ZONA'));
        $tipo = strtoupper($request->input('TIPO'));
        $aduana = strtoupper($request->input('ADUANA'));
        $observaciones = strtoupper($request->input('OBSERVACIONES'));
        $ciudad = auth()->user()->Regional;

        // Obtener el nombre de usuario del cartero actualmente autenticado
        $usercartero = strtoupper(auth()->user()->name ?? '');

        // Crear la nueva instancia de International y guardar en la base de datos
        $international = new International([
            'CODIGO' => $codigo,
            'DESTINATARIO' => $destinatario,
            'TELEFONO' => $telefono,
            'CUIDAD' => $ciudad, // Revisa qué valor debe ir aquí, asegúrate de que esté correcto
            'ESTADO' => 'VENTANILLA', // Asegúrate de que ESTADO esté configurado correctamente
            'VENTANILLA' => $ventanilla,
            'ZONA' => $zona,
            'PESO' => $peso,
            'TIPO' => $tipo,
            'ADUANA' => $aduana,
            'OBSERVACIONES' => $observaciones,
            'usercartero' => $usercartero,
        ]);

        try {
            $international->save();
        } catch (\Exception $e) {
            return redirect()->route('internationals.index')
                ->with('error', 'Error al crear el paquete: ' . $e->getMessage());
        }

        return redirect()->route('internationals.index')
            ->with('success', 'Creacion de Paquete con éxito');
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
        $request->validate(International::$rules);

        $codigo = $international->CODIGO;
        $international->update($request->all());

        Event::create([
            'action' => 'ESTADO',
            'descripcion' => 'Edición de Paquete',
            'user_id' => auth()->user()->id,
            'codigo' => $codigo, // Utiliza el código obtenido previamente
        ]);

        return redirect()->route('internationals.ventanilladd')
            ->with('success', 'Actualizacion de Paquete con exito');
    }

    public function destroy($id)
    {
        $international = International::findOrFail($id);

        Event::create([
            'action' => 'ESTADO',
            'descripcion' => 'Baja de Paquete',
            'user_id' => auth()->user()->id,
            'codigo' => $international->CODIGO,
        ]);
        $international->delete();

        return redirect()->route('internationals.index')
            ->with('success', 'Baja de Paquete con exito');
    }
    public function restore($id)
    {
        $international = International::withTrashed()->findOrFail($id);
        Event::create([
            'action' => 'ESTADO',
            'descripcion' => 'Alta de Paquete',
            'user_id' => auth()->user()->id,
            'codigo' => $international->CODIGO,
        ]);
        $international->update(['ESTADO' => 'VENTANILLA']);
        $international->restore();

        return redirect()->route('internationals.index')
            ->with('success', 'Alta de Paquete con exito');
    }
    public function certificadosexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $regional = $request->input('regional');
        return Excel::download(new Internationaldd($fechaInicio, $fechaFin, $regional), 'Ventanilla Certificados DD.xlsx');
    }
    public function inventarioDRDexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        return Excel::download(new Internationalinvdd($fechaInicio, $fechaFin), 'Inventario Certificados DD.xlsx');
    }
    public function certificadosdndexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $regional = $request->input('regional');
        return Excel::download(new Internationaldnd($fechaInicio, $fechaFin, $regional), 'Ventanilla Certificados DND.xlsx');
    }
    public function inventarioDNDexcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        return Excel::download(new Internationalinvdnd($fechaInicio, $fechaFin), 'Inventario Certificados DND.xlsx');
    }
    public function ventanilladd()
    {
        return view('international.ventanilladd');
    }
    public function deleteadodd()
    {
        return view('international.deleteadodd');
    }
    public function ventanilladnd()
    {
        return view('international.ventanilladnd');
    }
    public function deleteadodnd()
    {
        return view('international.deleteadodnd');
    }
}
