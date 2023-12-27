<?php

namespace App\Http\Controllers;

use App\Models\National;
use App\Models\Event;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
class NationalController extends Controller
{
    public function index()
    {
        return view('national.index');
    }

    public function create()
    {
        $national = new National();
        return view('national.create', compact('national'));
    }

        public function store(Request $request)
    {
        try {
            // Obtener el usuario autenticado
            $user = auth()->user();

            // Crear el modelo National con los valores deseados
            $national = new National([
                'ORIGEN' => $user->Regional,
                'USER' => $user->name,
                // Otros campos que puedas tener en tu formulario o en la tabla
                'CODIGO' => $request->input('CODIGO'),
                'TIPOSERVICIO' => $request->input('TIPOSERVICIO'),
                'TIPOCORRESPONDENCIA' => $request->input('TIPOCORRESPONDENCIA'),
                'CANTIDAD' => $request->input('CANTIDAD'),
                'PESO' => $request->input('PESO'),
                'DESTINO' => $request->input('DESTINO'),
                'PROVINCIA' => $request->input('PROVINCIA'),
                'DIRECCION' => $request->input('DIRECCION'),
                'FACTURA' => $request->input('FACTURA'),
                'IMPORTE' => $request->input('IMPORTE'),
                'NOMBRESDESTINATARIO' => $request->input('NOMBRESDESTINATARIO'),
                'TELEFONODESTINATARIO' => $request->input('TELEFONODESTINATARIO'),
                'CIDESTINATARIO' => $request->input('CIDESTINATARIO'),
                'NOMBRESREMITENTE' => $request->input('NOMBRESREMITENTE'),
                'TELEFONOREMITENTE' => $request->input('TELEFONOREMITENTE'),
                'CIREMITENTE' => $request->input('CIREMITENTE'),
            ]);

            // Guardar el modelo en la base de datos
            $national->save();

            // Imprimir el contenido de $national para depuración
            // dd($national);
        } catch (\Exception $e) {
            // Mostrar un mensaje de error o registrar el error
            dd($e->getMessage());
        }

        // Resto del código...
        return redirect()->route('nationals.index')->with('success', 'Paquete Creado Con Éxito!');
    }

    public function show($id)
    {
        $national = National::find($id);

        return view('national.show', compact('national'));
    }

    public function edit($id)
    {
        $national = National::find($id);

        return view('national.edit', compact('national'));
    }

    public function update(Request $request, National $national)
    {
        request()->validate(National::$rules);

        $national->update($request->all());

        return redirect()->route('nationals.index')
            ->with('success', 'Paquete Actualizado Con Éxito!');
    }

    public function destroy($id)
    {
        $national = National::find($id)->delete();

        return redirect()->route('nationals.index')
            ->with('success', 'Paquete Eliminado Con Éxito!');
    }
    public function agregarPaquete($nationalId)
    {
        $national = National::findOrFail($nationalId);

        // Verifica si el paquete ya está seleccionado
        if (!in_array($nationalId, $this->selectedPackages)) {
            $this->selectedPackages[] = $nationalId;
            $national->update(['ESTADO' => 'ASIGNADO']);
            $national->touch();
        }
    }

    public function quitarPaquete($nationalId)
    {
        $national = National::findOrFail($nationalId);
        $this->selectedPackages = array_diff($this->selectedPackages, [$nationalId]);
        $national->update(['ESTADO' => 'VENTANILLA']);
        $national->touch();
    }
}
