<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PackageImport; // Importa la clase PackageImport

class PackageExport extends Controller
{
    public function import(Request $request)
    {
        // Valida y procesa el archivo importado
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            // Importa los datos desde el archivo Excel utilizando la clase de importación
            Excel::import(new PackageImport, $request->file('file'));

            // Redirige a una vista de éxito después de la importación exitosa
            return redirect()->route('package.index')->with('success', 'Datos importados exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores en caso de que la importación falle
            return redirect()->route('package.index')->with('error', 'Error al importar datos: ' . $e->getMessage());
        }
    }
}
