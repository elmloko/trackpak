<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use Response;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function show(Request $request)
    {
        // Realizar la solicitud a la API para buscar el objeto de correo
        $codigo = $request->input('codigo');

        $searchResponse = Http::get('http://localhost:5254/api/O_MAIL_OBJECTS/buscar', [
            'id' => $codigo
        ]);

        // Verificar si la solicitud de búsqueda fue exitosa
        if ($searchResponse->successful()) {
            $result = $searchResponse->json();

            // También realizamos la búsqueda en la base de datos
            $data = trim($codigo);
            $packages = Package::where('CODIGO', 'like', '%' . $data . '%')
                ->orWhere('DESTINATARIO', 'like', '%' . $data . '%')
                ->limit(5)
                ->get();

            return view('search', ['result' => $result, 'packages' => $packages]);
        } else {
            dd($codigo);
            // Manejar el caso de error de la solicitud de búsqueda
            return response()->json(['error' => 'No se pudo obtener los datos de la API de búsqueda'], 500);
        }
    }
}
