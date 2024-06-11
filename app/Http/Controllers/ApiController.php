<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\User;

class ApiController extends Controller
{
    //  public function index()
    // {
    //     return Package::all();
    // }
    public function store(Request $request)
    {
        // Método de prueba para recibir datos y devolver una respuesta
        $data = $request->all();
        
        // Puedes hacer algo con los datos aquí, por ejemplo, validarlos o guardarlos en la base de datos

        // Devolver una respuesta de prueba
        return response()->json([
            'message' => 'Datos recibidos correctamente',
            'data' => $data
        ], 201);
    }
    public function show($codigo)
    {
        // Buscar el paquete por el código proporcionado
        $package = Package::where('CODIGO', $codigo)->first();

        // Verificar si se encontró el paquete
        if (!$package) {
            return response()->json(['error' => 'Package not found'], 404);
        }

        // Devolver los datos del paquete
        return response()->json([
            'CODIGO' => $package->CODIGO,
            'DESTINATARIO' => $package->DESTINATARIO,
            'UBICACION' => $package->CUIDAD . ', ' . $package->PAIS . ', ' . $package->ZONA
        ]);
    }
    
}
