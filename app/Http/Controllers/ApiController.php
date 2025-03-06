<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Event;
use App\Models\National;
use App\Models\International;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function updateImages(Request $request)
    {
        // Validar los campos: 'codigo' es obligatorio, 'foto' y 'firma' pueden ser nulos
        $request->validate([
            'codigo' => 'required|string',
            'foto'   => 'nullable|string',
            'firma'  => 'nullable|string'
        ]);

        // Buscar el paquete usando el campo CODIGO
        $package = Package::where('CODIGO', $request->codigo)->first();

        if (!$package) {
            return response()->json(['message' => 'No se encontró el paquete con ese código'], 404);
        }

        // Actualizar los campos si se proporcionan
        if ($request->has('foto')) {
            $package->foto = $request->foto;
        }
        if ($request->has('firma')) {
            $package->firma = $request->firma;
        }

        $package->save();

        return response()->json(['message' => 'Imágenes actualizadas correctamente'], 200);
    }

    public function updatePackage(Request $request, $codigo)
    {
        // Validar los datos recibidos
        $data = $request->validate([
            'ESTADO'      => 'required|string',
            'action'      => 'required|string',
            'user_id'     => 'required|exists:users,id',
            'descripcion' => 'nullable|string',
            'OBSERVACIONES' => 'nullable|string',
            'usercartero' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Buscar el paquete por el campo CODIGO
            $package = Package::where('CODIGO', $codigo)->firstOrFail();

            // Actualizar estado y otros datos del paquete
            $package->ESTADO = $data['ESTADO'];
            $package->usercartero = $data['usercartero'] ?? null;
            $package->OBSERVACIONES = $data['OBSERVACIONES'] ?? null;
            $package->updated_at = now();

            // Si el estado es ENTREGADO o REPARTIDO, aplicar soft delete
            if (in_array($data['ESTADO'], ['ENTREGADO', 'REPARTIDO'])) {
                $package->save();
                $package->delete(); // Aplicar SoftDelete
            } else {
                $package->save(); // Guardar sin eliminar
            }

            // Registrar el evento relacionado con el paquete
            Event::create([
                'action'      => $data['action'],
                'user_id'     => $data['user_id'],
                'codigo'      => $codigo,
                'descripcion' => $data['descripcion'] ?? null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            DB::commit();

            return response()->json(['message' => 'Actualización y registro de evento exitosos'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error: ' . $e->getMessage()], 500);
        }
    }

    public function searchByManifiesto(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'manifiesto' => 'required|string|max:8', // Se asume que "manifiesto" tiene un formato "A1234567"
        ]);

        // Buscar paquetes por el campo "manifiesto" y obtener los campos CODIGO, CUIDAD y PESO
        $packages = Package::where('manifiesto', $request->manifiesto)
            ->get(['CODIGO', 'CUIDAD', 'PESO']);

        // Verificar si se encontraron resultados
        if ($packages->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron paquetes con el manifiesto especificado.',
            ], 404);
        }

        // Devolver los datos de los paquetes encontrados
        return response()->json([
            'success' => true,
            'message' => 'Paquetes encontrados.',
            'data' => $packages,
        ]);
    }

    public function index()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackages()');

            // Devolver los resultados como JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function packagesUDD()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesVentanillaUDD()');

            // Devolver los resultados como JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function packagesUDND()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesVentanillaUDND()');

            // Devolver los resultados como JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function packagesUECA()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesVentanillaUECA()');

            // Devolver los resultados como JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function packagesUCASILLAS()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesVentanillaUCASILLAS()');

            // Devolver los resultados como JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function packagesUENCOMIENDAS()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesVentanillaUENCOMIENDA()');

            // Devolver los resultados como JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function packagesRDD()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesVentanillaRDD()');

            // Devolver los resultados como JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function packagesRDND()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesVentanillaRDND()');

            // Devolver los resultados como JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function packagesRCASILLAS()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesVentanillaRCASILLAS()');

            // Devolver los resultados como JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function softdeletes()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesSoft()');

            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function softdeletesUDD()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesSoftUDD()');
            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function softdeletesUDND()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesSoftUDND()');
            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function softdeletesUCASILLAS()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesSoftUCASILLAS()');
            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function softdeletesUENCOMIENDAS()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesSoftUENCOMIENDAS()');
            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function softdeletesUECA()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesSoftUECA()');
            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function softdeletesRDD()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesSoftRDD()');
            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function softdeletesRDND()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesSoftRDND()');
            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function softdeletesRCASILLAS()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesSoftRCASILLAS()');
            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function callventanilla()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesVentanilla()');

            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function callclasi()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesClasi()');

            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function callclasiUDD()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesClasiUDD()');

            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function callclasiUDND()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesClasiUDND()');

            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function callclasiUECA()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesClasiUECA()');

            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function callclasiUCASILLAS()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesClasiUCASILLAS()');

            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function callclasiUENCOMIENDAS()
    {
        try {
            // Llamar al procedimiento almacenado
            $packages = DB::select('CALL GetAllPackagesClasiUENCOMIENDA()');

            // Devolver los datos de los paquetes en formato JSON
            return response()->json($packages);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getEventsByCodigo($codigo)
    {
        // Verificar si el código se repite
        $codigoCount = Event::where('codigo', $codigo)->count();

        // Si el código se repite, obtener los eventos
        if ($codigoCount > 1) {
            $events = Event::where('codigo', $codigo)->get();
            return response()->json($events);
        } else {
            // Si el código no se repite, retornar un mensaje
            return response()->json([
                'message' => 'El código no se repite o no existe.'
            ], 404);
        }
    }

    public function delete(Request $request, $codigo)
    {
        $package = Package::where('CODIGO', $codigo)->first();

        if ($package) {
            // Registra el evento de entrega
            Event::create([
                'action' => 'ENTREGADO',
                'descripcion' => 'Entrega de paquete en ventanilla en Oficina Postal Regional (SISTEMA ATM)',
                'user_id' => 86,  // Asignar un ID de usuario predeterminado o ajustarlo según tus necesidades
                'codigo' => $package->CODIGO,
            ]);

            // Cambia el estado del paquete a "ENTREGADO"
            $package->estado = 'ENTREGADO';

            // Guarda el paquete actualizado
            $package->save();

            // Elimina el paquete (soft delete)
            $package->delete();

            return response()->json(['success' => true, 'message' => 'Paquete eliminado y evento registrado.']);
        } else {
            return response()->json(['error' => 'No se pudo encontrar el paquete para dar de baja.'], 404);
        }
    }

    public function store(Request $request)
    {
        // Método de prueba para recibir datos y devolver una respuesta
        $data = $request->all();

        return response()->json([
            'message' => 'Datos recibidos correctamente',
            'data' => $data
        ], 201);
    }
    public function show($codigo)
    {
        // Buscar el paquete por el código proporcionado en ambos modelos
        $package = Package::withTrashed()->where('CODIGO', $codigo)->first();
        $international = International::withTrashed()->where('CODIGO', $codigo)->first();

        // Verificar si se encontró en alguno de los dos modelos
        if (!$package && !$international) {
            return response()->json(['error' => 'Package not found'], 404);
        }

        // Si se encuentra en el modelo Package
        if ($package) {
            return response()->json([
                'CODIGO' => $package->CODIGO,
                'DESTINATARIO' => $package->DESTINATARIO,
                'ESTADO' => $package->ESTADO,
                'TELEFONO' => $package->TELEFONO,
                'ZONA' => $package->ZONA,
                'TIPO' => $package->TIPO,
                'PESO' => $package->PESO,
                'ADUANA' => $package->ADUANA,
                'CUIDAD' => $package->CUIDAD,
                'VENTANILLA' => $package->VENTANILLA,
            ]);
        }

        // Si se encuentra en el modelo International
        if ($international) {
            return response()->json([
                'CODIGO' => $international->CODIGO,
                'DESTINATARIO' => $international->DESTINATARIO,
                'ESTADO' => $international->ESTADO,
                'TELEFONO' => $international->TELEFONO,
                'ZONA' => $international->ZONA,
                'ADUANA' => $international->ADUANA,
                'CUIDAD' => $international->CUIDAD,
                'VENTANILLA' => $international->VENTANILLA,
            ]);
        }
    }
    public function ventanilla(Request $request)
    {
        try {

            $importe = 0;
            $provincia = strtoupper($request->input('PROVINCIA'));
            $peso = $request->input('PESO');
            $cantidad = $request->input('CANTIDAD');

            // Calcular el precio basado en el peso y la provincia usando un método auxiliar
            $precio = $this->calcularPrecio($provincia, $peso, $cantidad);
            $importe = $precio * $cantidad;

            // Crear el modelo National con los valores obtenidos
            $national = new National([
                'ORIGEN' => $request->input('ORIGEN'),
                'USER' => $request->input('USER'),
                'CODIGO' => $request->input('CODIGO'),
                'TIPOSERVICIO' => $request->input('TIPOSERVICIO'),
                'TIPOCORRESPONDENCIA' => $request->input('TIPOCORRESPONDENCIA'),
                'CANTIDAD' => $cantidad,
                'PESO' => $peso,
                'DESTINO' => $request->input('DESTINO'),
                'PROVINCIA' => $provincia,
                'DIRECCION' => $request->input('DIRECCION'),
                'FACTURA' => $request->input('FACTURA'),
                'IMPORTE' => $importe,
                'NOMBRESDESTINATARIO' => $request->input('NOMBRESDESTINATARIO'),
                'TELEFONODESTINATARIO' => $request->input('TELEFONODESTINATARIO'),
                'CIDESTINATARIO' => $request->input('CIDESTINATARIO'),
                'NOMBRESREMITENTE' => $request->input('NOMBRESREMITENTE'),
                'TELEFONOREMITENTE' => $request->input('TELEFONOREMITENTE'),
                'CIREMITENTE' => $request->input('CIREMITENTE'),
            ]);

            // Guardar el modelo en la base de datos
            $national->save();

            // Devolver una respuesta JSON exitosa
            return response()->json([
                'message' => 'Paquete creado con éxito',
                'data' => $national
            ], 201);
        } catch (\Exception $e) {
            // Devolver una respuesta JSON de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    private function calcularPrecio($provincia, $peso)
    {
        // Definición de tarifas según el rango de peso
        $tarifas = $this->obtenerTarifas($peso);

        // Comprobar si la provincia está en las tarifas
        if (!array_key_exists($provincia, $tarifas)) {
            throw new \Exception("No se encuentra la tarifa para la provincia especificada.");
        }

        return $tarifas[$provincia];
    }

    private function obtenerTarifas($peso)
    {
        // Aquí puedes definir las diferentes tarifas según los rangos de peso
        if ($peso >= 0.001 && $peso <= 0.020) {
            return [
                'LOCAL 1' => 3,
                'LOCAL 2' => 4,
                'LOCAL 3' => 5,
                'LOCAL 4' => 6,
                'CUIDAD CAPITAL EMS' => 10,
                'CUIDAD INTERMEDIA EMS' => 18,
                'TRINIDAD/COBIJA EMS' => 16,
                'RIBERALTA/GUAYARAMERIN EMS' => 21,
                'CUIDAD CAPITAL ME' => 8,
                'TRINIDAD/COBIJA ME' => 12,
                'PROVINCIA-DENTRO ME' => 17,
                'PROVINCIA-OTRO ME' => 25,
                'SERVICIO-LOCAL LC/AO' => 2,
                'SERVICIO-NACIONAL LC/AO' => 8,
                'PROVINCIA-DENTRO LC/AO' => 12,
                'PROVINCIA-OTRO LC/AO' => 16,
                'TRINIDAD/COBIJA LC/AO' => 16,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 5,
                'SERVICIO-LOCAL ECA' => 2,
                'SERVICIO-NACIONAL ECA' => 4,
                'PROVINCIA-DENTRO ECA' => 11,
                'PROVINCIA-OTRO ECA' => 15,
                'TRINIDAD/COBIJA ECA' => 5,
                'RIBERALTA/GUAYARAMERIN ECA' => 5,
                'UNICO SE' => 32,
                'SERVICIO-LOCAL PO' => 4,
                'SERVICIO-NACIONAL PO' => 7,
                'PROVINCIA-DENTRO PO' => 15,
                'PROVINCIA-OTRO PO' => 18,
                'SERVICIO-NACIONAL SM' => 23,
                'SERVICIO-PROVINCIONAL SM' => 26,
            ];
        } elseif ($peso > 0.021 && $peso <= 0.100) {
            return [
                'LOCAL 1' => 3,
                'LOCAL 2' => 4,
                'LOCAL 3' => 5,
                'LOCAL 4' => 6,
                'CUIDAD CAPITAL EMS' => 10,
                'CUIDAD INTERMEDIA EMS' => 18,
                'TRINIDAD/COBIJA EMS' => 16,
                'RIBERALTA/GUAYARAMERIN EMS' => 21,
                'CUIDAD CAPITAL ME' => 8,
                'TRINIDAD/COBIJA ME' => 12,
                'PROVINCIA-DENTRO ME' => 17,
                'PROVINCIA-OTRO ME' => 25,
                'SERVICIO-LOCAL LC/AO' => 3,
                'SERVICIO-NACIONAL LC/AO' => 8,
                'PROVINCIA-DENTRO LC/AO' => 14,
                'PROVINCIA-OTRO LC/AO' => 19,
                'TRINIDAD/COBIJA LC/AO' => 16,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 7,
                'SERVICIO-LOCAL ECA' => 2,
                'SERVICIO-NACIONAL ECA' => 6,
                'PROVINCIA-DENTRO ECA' => 12,
                'PROVINCIA-OTRO ECA' => 17,
                'TRINIDAD/COBIJA ECA' => 6,
                'RIBERALTA/GUAYARAMERIN ECA' => 6,
                'UNICO SE' => 32,
                'SERVICIO-LOCAL PO' => 5,
                'SERVICIO-NACIONAL PO' => 9,
                'PROVINCIA-DENTRO PO' => 16,
                'PROVINCIA-OTRO PO' => 21,
                'SERVICIO-NACIONAL SM' => 23,
                'SERVICIO-PROVINCIONAL SM' => 26,
            ];
        } elseif ($peso > 0.101 && $peso <= 0.250) {
            return [
                'LOCAL 1' => 3,
                'LOCAL 2' => 4,
                'LOCAL 3' => 5,
                'LOCAL 4' => 6,
                'CUIDAD CAPITAL EMS' => 10,
                'CUIDAD INTERMEDIA EMS' => 18,
                'TRINIDAD/COBIJA EMS' => 16,
                'RIBERALTA/GUAYARAMERIN EMS' => 21,
                'CUIDAD CAPITAL ME' => 8,
                'TRINIDAD/COBIJA ME' => 12,
                'PROVINCIA-DENTRO ME' => 17,
                'PROVINCIA-OTRO ME' => 25,
                'SERVICIO-LOCAL LC/AO' => 4,
                'SERVICIO-NACIONAL LC/AO' => 8,
                'PROVINCIA-DENTRO LC/AO' => 15,
                'PROVINCIA-OTRO LC/AO' => 20,
                'TRINIDAD/COBIJA LC/AO' => 16,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 10,
                'SERVICIO-LOCAL ECA' => 4,
                'SERVICIO-NACIONAL ECA' => 6,
                'PROVINCIA-DENTRO ECA' => 13,
                'PROVINCIA-OTRO ECA' => 18,
                'TRINIDAD/COBIJA ECA' => 7,
                'RIBERALTA/GUAYARAMERIN ECA' => 9,
                'UNICO SE' => 32,
                'SERVICIO-LOCAL PO' => 6,
                'SERVICIO-NACIONAL PO' => 10,
                'PROVINCIA-DENTRO PO' => 17,
                'PROVINCIA-OTRO PO' => 22,
                'SERVICIO-NACIONAL SM' => 23,
                'SERVICIO-PROVINCIONAL SM' => 26,
            ];
        } elseif ($peso > 0.251 && $peso <= 0.500) {
            return [
                'LOCAL 1' => 6,
                'LOCAL 2' => 7,
                'LOCAL 3' => 8,
                'LOCAL 4' => 10,
                'CUIDAD CAPITAL EMS' => 12,
                'CUIDAD INTERMEDIA EMS' => 20,
                'TRINIDAD/COBIJA EMS' => 24,
                'RIBERALTA/GUAYARAMERIN EMS' => 26,
                'CUIDAD CAPITAL ME' => 8,
                'TRINIDAD/COBIJA ME' => 12,
                'PROVINCIA-DENTRO ME' => 17,
                'PROVINCIA-OTRO ME' => 25,
                'SERVICIO-LOCAL LC/AO' => 5,
                'SERVICIO-NACIONAL LC/AO' => 8,
                'PROVINCIA-DENTRO LC/AO' => 17,
                'PROVINCIA-OTRO LC/AO' => 22,
                'TRINIDAD/COBIJA LC/AO' => 16,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 17,
                'SERVICIO-LOCAL ECA' => 4,
                'SERVICIO-NACIONAL ECA' => 7,
                'PROVINCIA-DENTRO ECA' => 15,
                'PROVINCIA-OTRO ECA' => 20,
                'TRINIDAD/COBIJA ECA' => 11,
                'RIBERALTA/GUAYARAMERIN ECA' => 15,
                'UNICO SE' => 39,
                'SERVICIO-LOCAL PO' => 7,
                'SERVICIO-NACIONAL PO' => 11,
                'PROVINCIA-DENTRO PO' => 19,
                'PROVINCIA-OTRO PO' => 24,
                'SERVICIO-NACIONAL SM' => 23,
                'SERVICIO-PROVINCIONAL SM' => 26,
            ];
        } elseif ($peso > 0.501 && $peso <= 1.000) {
            return [
                'LOCAL 1' => 10,
                'LOCAL 2' => 11,
                'LOCAL 3' => 12,
                'LOCAL 4' => 15,
                'CUIDAD CAPITAL EMS' => 17,
                'CUIDAD INTERMEDIA EMS' => 25,
                'TRINIDAD/COBIJA EMS' => 31,
                'RIBERALTA/GUAYARAMERIN EMS' => 42,
                'CUIDAD CAPITAL ME' => 10,
                'TRINIDAD/COBIJA ME' => 26,
                'PROVINCIA-DENTRO ME' => 19,
                'PROVINCIA-OTRO ME' => 29,
                'SERVICIO-LOCAL LC/AO' => 7,
                'SERVICIO-NACIONAL LC/AO' => 10,
                'PROVINCIA-DENTRO LC/AO' => 19,
                'PROVINCIA-OTRO LC/AO' => 24,
                'TRINIDAD/COBIJA LC/AO' => 26,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 31,
                'SERVICIO-LOCAL ECA' => 5,
                'SERVICIO-NACIONAL ECA' => 8,
                'PROVINCIA-DENTRO ECA' => 17,
                'PROVINCIA-OTRO ECA' => 22,
                'TRINIDAD/COBIJA ECA' => 24,
                'RIBERALTA/GUAYARAMERIN ECA' => 28,
                'UNICO SE' => 52,
                'SERVICIO-LOCAL PO' => 9,
                'SERVICIO-NACIONAL PO' => 12,
                'PROVINCIA-DENTRO PO' => 21,
                'PROVINCIA-OTRO PO' => 26,
                'SERVICIO-NACIONAL SM' => 23,
                'SERVICIO-PROVINCIONAL SM' => 26,
            ];
        } elseif ($peso > 1.001 && $peso <= 2.000) {
            return [
                'LOCAL 1' => 17,
                'LOCAL 2' => 18,
                'LOCAL 3' => 19,
                'LOCAL 4' => 21,
                'CUIDAD CAPITAL EMS' => 23,
                'CUIDAD INTERMEDIA EMS' => 29,
                'TRINIDAD/COBIJA EMS' => 47,
                'RIBERALTA/GUAYARAMERIN EMS' => 62,
                'CUIDAD CAPITAL ME' => 16,
                'TRINIDAD/COBIJA ME' => 42,
                'PROVINCIA-DENTRO ME' => 25,
                'PROVINCIA-OTRO ME' => 41,
                'SERVICIO-LOCAL LC/AO' => 11,
                'SERVICIO-NACIONAL LC/AO' => 16,
                'PROVINCIA-DENTRO LC/AO' => 25,
                'PROVINCIA-OTRO LC/AO' => 28,
                'TRINIDAD/COBIJA LC/AO' => 42,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 47,
                'SERVICIO-LOCAL ECA' => 9,
                'SERVICIO-NACIONAL ECA' => 12,
                'PROVINCIA-DENTRO ECA' => 22,
                'PROVINCIA-OTRO ECA' => 25,
                'TRINIDAD/COBIJA ECA' => 37,
                'RIBERALTA/GUAYARAMERIN ECA' => 43,
                'UNICO SE' => 68,
                'SERVICIO-LOCAL PO' => 14,
                'SERVICIO-NACIONAL PO' => 18,
                'PROVINCIA-DENTRO PO' => 27,
                'PROVINCIA-OTRO PO' => 30,
                'SERVICIO-NACIONAL SM' => 23,
                'SERVICIO-PROVINCIONAL SM' => 26,
            ];
        } elseif ($peso > 2.001 && $peso <= 3.000) {
            return [
                'LOCAL 1' => 22,
                'LOCAL 2' => 24,
                'LOCAL 3' => 24,
                'LOCAL 4' => 26,
                'CUIDAD CAPITAL EMS' => 28,
                'CUIDAD INTERMEDIA EMS' => 37,
                'TRINIDAD/COBIJA EMS' => 62,
                'RIBERALTA/GUAYARAMERIN EMS' => 83,
                'CUIDAD CAPITAL ME' => 21,
                'TRINIDAD/COBIJA ME' => 57,
                'PROVINCIA-DENTRO ME' => 31,
                'PROVINCIA-OTRO ME' => 52,
                'SERVICIO-LOCAL LC/AO' => 15.50,
                'SERVICIO-NACIONAL LC/AO' => 21,
                'PROVINCIA-DENTRO LC/AO' => 31,
                'PROVINCIA-OTRO LC/AO' => 34,
                'TRINIDAD/COBIJA LC/AO' => 57,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 68,
                'SERVICIO-LOCAL ECA' => 11,
                'SERVICIO-NACIONAL ECA' => 17,
                'PROVINCIA-DENTRO ECA' => 28,
                'PROVINCIA-OTRO ECA' => 31,
                'TRINIDAD/COBIJA ECA' => 52,
                'RIBERALTA/GUAYARAMERIN ECA' => 61,
                'UNICO SE' => 83,
                'SERVICIO-LOCAL PO' => 20,
                'SERVICIO-NACIONAL PO' => 23,
                'PROVINCIA-DENTRO PO' => 33,
                'PROVINCIA-OTRO PO' => 36,
                'SERVICIO-NACIONAL SM' => 23,
                'SERVICIO-PROVINCIONAL SM' => 26,
            ];
        } elseif ($peso > 3.001 && $peso <= 4.000) {
            return [
                'LOCAL 1' => 24,
                'LOCAL 2' => 25,
                'LOCAL 3' => 26,
                'LOCAL 4' => 28,
                'CUIDAD CAPITAL EMS' => 34,
                'CUIDAD INTERMEDIA EMS' => 44,
                'TRINIDAD/COBIJA EMS' => 78,
                'RIBERALTA/GUAYARAMERIN EMS' => 104,
                'CUIDAD CAPITAL ME' => 26,
                'TRINIDAD/COBIJA ME' => 73,
                'PROVINCIA-DENTRO ME' => 37,
                'PROVINCIA-OTRO ME' => 63,
                'SERVICIO-LOCAL LC/AO' => 18,
                'SERVICIO-NACIONAL LC/AO' => 26,
                'PROVINCIA-DENTRO LC/AO' => 37,
                'PROVINCIA-OTRO LC/AO' => 41,
                'TRINIDAD/COBIJA LC/AO' => 73,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 88,
                'SERVICIO-LOCAL ECA' => 14,
                'SERVICIO-NACIONAL ECA' => 21,
                'PROVINCIA-DENTRO ECA' => 33,
                'PROVINCIA-OTRO ECA' => 36,
                'TRINIDAD/COBIJA ECA' => 65,
                'RIBERALTA/GUAYARAMERIN ECA' => 75,
                'UNICO SE' => 99,
                'SERVICIO-LOCAL PO' => 24,
                'SERVICIO-NACIONAL PO' => 28,
                'PROVINCIA-DENTRO PO' => 39,
                'PROVINCIA-OTRO PO' => 43,
                'SERVICIO-NACIONAL SM' => 23,
                'SERVICIO-PROVINCIONAL SM' => 26,
            ];
        } elseif ($peso > 4.001 && $peso <= 5.000) {
            return [
                'LOCAL 1' => 26,
                'LOCAL 2' => 27,
                'LOCAL 3' => 28,
                'LOCAL 4' => 30,
                'CUIDAD CAPITAL EMS' => 41,
                'CUIDAD INTERMEDIA EMS' => 47,
                'TRINIDAD/COBIJA EMS' => 94,
                'RIBERALTA/GUAYARAMERIN EMS' => 125,
                'CUIDAD CAPITAL ME' => 31,
                'TRINIDAD/COBIJA ME' => 88,
                'PROVINCIA-DENTRO ME' => 44,
                'PROVINCIA-OTRO ME' => 75,
                'SERVICIO-LOCAL LC/AO' => 22,
                'SERVICIO-NACIONAL LC/AO' => 31,
                'PROVINCIA-DENTRO LC/AO' => 44,
                'PROVINCIA-OTRO LC/AO' => 47,
                'TRINIDAD/COBIJA LC/AO' => 88,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 109,
                'SERVICIO-LOCAL ECA' => 16,
                'SERVICIO-NACIONAL ECA' => 25,
                'PROVINCIA-DENTRO ECA' => 39,
                'PROVINCIA-OTRO ECA' => 43,
                'TRINIDAD/COBIJA ECA' => 80,
                'RIBERALTA/GUAYARAMERIN ECA' => 99,
                'UNICO SE' => 114,
                'SERVICIO-LOCAL PO' => 26,
                'SERVICIO-NACIONAL PO' => 33,
                'PROVINCIA-DENTRO PO' => 46,
                'PROVINCIA-OTRO PO' => 49,
                'SERVICIO-NACIONAL SM' => 23,
                'SERVICIO-PROVINCIONAL SM' => 26,
            ];
        } elseif ($peso > 5.001 && $peso <= 6.000) {
            return [
                'LOCAL 1' => 28,
                'LOCAL 2' => 29,
                'LOCAL 3' => 30,
                'LOCAL 4' => 32,
                'CUIDAD CAPITAL EMS' => 48,
                'CUIDAD INTERMEDIA EMS' => 56,
                'TRINIDAD/COBIJA EMS' => 109,
                'RIBERALTA/GUAYARAMERIN EMS' => 145,
                'CUIDAD CAPITAL ME' => 36,
                'TRINIDAD/COBIJA ME' => 104,
                'PROVINCIA-DENTRO ME' => 51,
                'PROVINCIA-OTRO ME' => 87,
                'SERVICIO-LOCAL LC/AO' => 24,
                'SERVICIO-NACIONAL LC/AO' => 36,
                'PROVINCIA-DENTRO LC/AO' => 51,
                'PROVINCIA-OTRO LC/AO' => 54,
                'TRINIDAD/COBIJA LC/AO' => 104,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 130,
                'SERVICIO-LOCAL ECA' => 22,
                'SERVICIO-NACIONAL ECA' => 33,
                'PROVINCIA-DENTRO ECA' => 46,
                'PROVINCIA-OTRO ECA' => 49,
                'TRINIDAD/COBIJA ECA' => 94,
                'RIBERALTA/GUAYARAMERIN ECA' => 117,
                'UNICO SE' => 130,
                'SERVICIO-LOCAL PO' => 28,
                'SERVICIO-NACIONAL PO' => 38,
                'PROVINCIA-DENTRO PO' => 53,
                'PROVINCIA-OTRO PO' => 56,
                'SERVICIO-NACIONAL SM' => 27,
                'SERVICIO-PROVINCIONAL SM' => 31,
            ];
        } elseif ($peso > 6.001 && $peso <= 7.000) {
            return [
                'LOCAL 1' => 30,
                'LOCAL 2' => 31,
                'LOCAL 3' => 32,
                'LOCAL 4' => 34,
                'CUIDAD CAPITAL EMS' => 54,
                'CUIDAD INTERMEDIA EMS' => 62,
                'TRINIDAD/COBIJA EMS' => 125,
                'RIBERALTA/GUAYARAMERIN EMS' => 166,
                'CUIDAD CAPITAL ME' => 42,
                'TRINIDAD/COBIJA ME' => 119,
                'PROVINCIA-DENTRO ME' => 58,
                'PROVINCIA-OTRO ME' => 100,
                'SERVICIO-LOCAL LC/AO' => 26,
                'SERVICIO-NACIONAL LC/AO' => 42,
                'PROVINCIA-DENTRO LC/AO' => 58,
                'PROVINCIA-OTRO LC/AO' => 61,
                'TRINIDAD/COBIJA LC/AO' => 119,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 151,
                'SERVICIO-LOCAL ECA' => 24,
                'SERVICIO-NACIONAL ECA' => 37,
                'PROVINCIA-DENTRO ECA' => 52,
                'PROVINCIA-OTRO ECA' => 55,
                'TRINIDAD/COBIJA ECA' => 108,
                'RIBERALTA/GUAYARAMERIN ECA' => 136,
                'UNICO SE' => 145,
                'SERVICIO-LOCAL PO' => 30,
                'SERVICIO-NACIONAL PO' => 44,
                'PROVINCIA-DENTRO PO' => 60,
                'PROVINCIA-OTRO PO' => 63,
                'SERVICIO-NACIONAL SM' => 31,
                'SERVICIO-PROVINCIONAL SM' => 36,
            ];
        } elseif ($peso > 7.001 && $peso <= 8.000) {
            return [
                'LOCAL 1' => 32,
                'LOCAL 2' => 33,
                'LOCAL 3' => 34,
                'LOCAL 4' => 36,
                'CUIDAD CAPITAL EMS' => 60,
                'CUIDAD INTERMEDIA EMS' => 70,
                'TRINIDAD/COBIJA EMS' => 140,
                'RIBERALTA/GUAYARAMERIN EMS' => 187,
                'CUIDAD CAPITAL ME' => 47,
                'TRINIDAD/COBIJA ME' => 135,
                'PROVINCIA-DENTRO ME' => 65,
                'PROVINCIA-OTRO ME' => 112,
                'SERVICIO-LOCAL LC/AO' => 28,
                'SERVICIO-NACIONAL LC/AO' => 47,
                'PROVINCIA-DENTRO LC/AO' => 65,
                'PROVINCIA-OTRO LC/AO' => 69,
                'TRINIDAD/COBIJA LC/AO' => 135,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 171,
                'SERVICIO-LOCAL ECA' => 25,
                'SERVICIO-NACIONAL ECA' => 43,
                'PROVINCIA-DENTRO ECA' => 59,
                'PROVINCIA-OTRO ECA' => 61,
                'TRINIDAD/COBIJA ECA' => 117,
                'RIBERALTA/GUAYARAMERIN ECA' => 155,
                'UNICO SE' => 161,
                'SERVICIO-LOCAL PO' => 32,
                'SERVICIO-NACIONAL PO' => 49,
                'PROVINCIA-DENTRO PO' => 68,
                'PROVINCIA-OTRO PO' => 71,
                'SERVICIO-NACIONAL SM' => 35,
                'SERVICIO-PROVINCIONAL SM' => 42,
            ];
        } elseif ($peso > 8.001 && $peso <= 9.000) {
            return [
                'LOCAL 1' => 34,
                'LOCAL 2' => 35,
                'LOCAL 3' => 36,
                'LOCAL 4' => 38,
                'CUIDAD CAPITAL EMS' => 68,
                'CUIDAD INTERMEDIA EMS' => 77,
                'TRINIDAD/COBIJA EMS' => 156,
                'RIBERALTA/GUAYARAMERIN EMS' => 208,
                'CUIDAD CAPITAL ME' => 52,
                'TRINIDAD/COBIJA ME' => 151,
                'PROVINCIA-DENTRO ME' => 73,
                'PROVINCIA-OTRO ME' => 125,
                'SERVICIO-LOCAL LC/AO' => 30,
                'SERVICIO-NACIONAL LC/AO' => 52,
                'PROVINCIA-DENTRO LC/AO' => 73,
                'PROVINCIA-OTRO LC/AO' => 76,
                'TRINIDAD/COBIJA LC/AO' => 151,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 192,
                'SERVICIO-LOCAL ECA' => 27,
                'SERVICIO-NACIONAL ECA' => 47,
                'PROVINCIA-DENTRO ECA' => 65,
                'PROVINCIA-OTRO ECA' => 69,
                'TRINIDAD/COBIJA ECA' => 131,
                'RIBERALTA/GUAYARAMERIN ECA' => 174,
                'UNICO SE' => 177,
                'SERVICIO-LOCAL PO' => 34,
                'SERVICIO-NACIONAL PO' => 54,
                'PROVINCIA-DENTRO PO' => 75,
                'PROVINCIA-OTRO PO' => 78,
                'SERVICIO-NACIONAL SM' => 39,
                'SERVICIO-PROVINCIONAL SM' => 47,
            ];
        } elseif ($peso > 9.001 && $peso <= 10.000) {
            return [
                'LOCAL 1' => 36,
                'LOCAL 2' => 37,
                'LOCAL 3' => 38,
                'LOCAL 4' => 41,
                'CUIDAD CAPITAL EMS' => 74,
                'CUIDAD INTERMEDIA EMS' => 83,
                'TRINIDAD/COBIJA EMS' => 171,
                'RIBERALTA/GUAYARAMERIN EMS' => 229,
                'CUIDAD CAPITAL ME' => 57,
                'TRINIDAD/COBIJA ME' => 166,
                'PROVINCIA-DENTRO ME' => 80,
                'PROVINCIA-OTRO ME' => 137,
                'SERVICIO-LOCAL LC/AO' => 32,
                'SERVICIO-NACIONAL LC/AO' => 57,
                'PROVINCIA-DENTRO LC/AO' => 80,
                'PROVINCIA-OTRO LC/AO' => 83,
                'TRINIDAD/COBIJA LC/AO' => 166,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 213,
                'SERVICIO-LOCAL ECA' => 29,
                'SERVICIO-NACIONAL ECA' => 52,
                'PROVINCIA-DENTRO ECA' => 72,
                'PROVINCIA-OTRO ECA' => 75,
                'TRINIDAD/COBIJA ECA' => 145,
                'RIBERALTA/GUAYARAMERIN ECA' => 192,
                'UNICO SE' => 192,
                'SERVICIO-LOCAL PO' => 36,
                'SERVICIO-NACIONAL PO' => 59,
                'PROVINCIA-DENTRO PO' => 82,
                'PROVINCIA-OTRO PO' => 85,
                'SERVICIO-NACIONAL SM' => 44,
                'SERVICIO-PROVINCIONAL SM' => 52,
            ];
        } elseif ($peso > 10.001 && $peso <= 11.000) {
            return [
                'LOCAL 1' => 38,
                'LOCAL 2' => 39,
                'LOCAL 3' => 41,
                'LOCAL 4' => 43,
                'CUIDAD CAPITAL EMS' => 81,
                'CUIDAD INTERMEDIA EMS' => 86,
                'TRINIDAD/COBIJA EMS' => 186,
                'RIBERALTA/GUAYARAMERIN EMS' => 249,
                'CUIDAD CAPITAL ME' => 62,
                'TRINIDAD/COBIJA ME' => 182,
                'PROVINCIA-DENTRO ME' => 87,
                'PROVINCIA-OTRO ME' => 150,
                'SERVICIO-LOCAL LC/AO' => 34,
                'SERVICIO-NACIONAL LC/AO' => 62,
                'PROVINCIA-DENTRO LC/AO' => 87,
                'PROVINCIA-OTRO LC/AO' => 90,
                'TRINIDAD/COBIJA LC/AO' => 182,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 234,
                'SERVICIO-LOCAL ECA' => 31,
                'SERVICIO-NACIONAL ECA' => 56,
                'PROVINCIA-DENTRO ECA' => 79,
                'PROVINCIA-OTRO ECA' => 81,
                'TRINIDAD/COBIJA ECA' => 159,
                'RIBERALTA/GUAYARAMERIN ECA' => 211,
                'UNICO SE' => 208,
                'SERVICIO-LOCAL PO' => 38,
                'SERVICIO-NACIONAL PO' => 64,
                'PROVINCIA-DENTRO PO' => 89,
                'PROVINCIA-OTRO PO' => 92,
                'SERVICIO-NACIONAL SM' => 48,
                'SERVICIO-PROVINCIONAL SM' => 57,
            ];
        } elseif ($peso > 11.001 && $peso <= 12.000) {
            return [
                'LOCAL 1' => 41,
                'LOCAL 2' => 42,
                'LOCAL 3' => 43,
                'LOCAL 4' => 45,
                'CUIDAD CAPITAL EMS' => 87,
                'CUIDAD INTERMEDIA EMS' => 96,
                'TRINIDAD/COBIJA EMS' => 203,
                'RIBERALTA/GUAYARAMERIN EMS' => 270,
                'CUIDAD CAPITAL ME' => 68,
                'TRINIDAD/COBIJA ME' => 197,
                'PROVINCIA-DENTRO ME' => 95,
                'PROVINCIA-OTRO ME' => 162,
                'SERVICIO-LOCAL LC/AO' => 36,
                'SERVICIO-NACIONAL LC/AO' => 68,
                'PROVINCIA-DENTRO LC/AO' => 95,
                'PROVINCIA-OTRO LC/AO' => 98,
                'TRINIDAD/COBIJA LC/AO' => 197,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 255,
                'SERVICIO-LOCAL ECA' => 33,
                'SERVICIO-NACIONAL ECA' => 61,
                'PROVINCIA-DENTRO ECA' => 85,
                'PROVINCIA-OTRO ECA' => 88,
                'TRINIDAD/COBIJA ECA' => 174,
                'RIBERALTA/GUAYARAMERIN ECA' => 230,
                'UNICO SE' => 223,
                'SERVICIO-LOCAL PO' => 41,
                'SERVICIO-NACIONAL PO' => 70,
                'PROVINCIA-DENTRO PO' => 97,
                'PROVINCIA-OTRO PO' => 100,
                'SERVICIO-NACIONAL SM' => 52,
                'SERVICIO-PROVINCIONAL SM' => 62,
            ];
        } elseif ($peso > 12.001 && $peso <= 13.000) {
            return [
                'LOCAL 1' => 43,
                'LOCAL 2' => 44,
                'LOCAL 3' => 45,
                'LOCAL 4' => 47,
                'CUIDAD CAPITAL EMS' => 94,
                'CUIDAD INTERMEDIA EMS' => 102,
                'TRINIDAD/COBIJA EMS' => 218,
                'RIBERALTA/GUAYARAMERIN EMS' => 291,
                'CUIDAD CAPITAL ME' => 73,
                'TRINIDAD/COBIJA ME' => 213,
                'PROVINCIA-DENTRO ME' => 102,
                'PROVINCIA-OTRO ME' => 175,
                'SERVICIO-LOCAL LC/AO' => 38,
                'SERVICIO-NACIONAL LC/AO' => 73,
                'PROVINCIA-DENTRO LC/AO' => 102,
                'PROVINCIA-OTRO LC/AO' => 105,
                'TRINIDAD/COBIJA LC/AO' => 213,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 275,
                'SERVICIO-LOCAL ECA' => 34,
                'SERVICIO-NACIONAL ECA' => 65,
                'PROVINCIA-DENTRO ECA' => 91,
                'PROVINCIA-OTRO ECA' => 95,
                'TRINIDAD/COBIJA ECA' => 187,
                'RIBERALTA/GUAYARAMERIN ECA' => 248,
                'UNICO SE' => 239,
                'SERVICIO-LOCAL PO' => 43,
                'SERVICIO-NACIONAL PO' => 75,
                'PROVINCIA-DENTRO PO' => 104,
                'PROVINCIA-OTRO PO' => 107,
                'SERVICIO-NACIONAL SM' => 56,
                'SERVICIO-PROVINCIONAL SM' => 68,
            ];
        } elseif ($peso > 13.001 && $peso <= 14.000) {
            return [
                'LOCAL 1' => 45,
                'LOCAL 2' => 46,
                'LOCAL 3' => 47,
                'LOCAL 4' => 49,
                'CUIDAD CAPITAL EMS' => 101,
                'CUIDAD INTERMEDIA EMS' => 109,
                'TRINIDAD/COBIJA EMS' => 234,
                'RIBERALTA/GUAYARAMERIN EMS' => 312,
                'CUIDAD CAPITAL ME' => 78,
                'TRINIDAD/COBIJA ME' => 229,
                'PROVINCIA-DENTRO ME' => 109,
                'PROVINCIA-OTRO ME' => 187,
                'SERVICIO-LOCAL LC/AO' => 41,
                'SERVICIO-NACIONAL LC/AO' => 78,
                'PROVINCIA-DENTRO LC/AO' => 109,
                'PROVINCIA-OTRO LC/AO' => 112,
                'TRINIDAD/COBIJA LC/AO' => 229,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 296,
                'SERVICIO-LOCAL ECA' => 36,
                'SERVICIO-NACIONAL ECA' => 71,
                'PROVINCIA-DENTRO ECA' => 99,
                'PROVINCIA-OTRO ECA' => 101,
                'TRINIDAD/COBIJA ECA' => 202,
                'RIBERALTA/GUAYARAMERIN ECA' => 267,
                'UNICO SE' => 255,
                'SERVICIO-LOCAL PO' => 45,
                'SERVICIO-NACIONAL PO' => 80,
                'PROVINCIA-DENTRO PO' => 111,
                'PROVINCIA-OTRO PO' => 114,
                'SERVICIO-NACIONAL SM' => 60,
                'SERVICIO-PROVINCIONAL SM' => 73,
            ];
        } elseif ($peso > 14.001 && $peso <= 15.000) {
            return [
                'LOCAL 1' => 47,
                'LOCAL 2' => 48,
                'LOCAL 3' => 49,
                'LOCAL 4' => 51,
                'CUIDAD CAPITAL EMS' => 107,
                'CUIDAD INTERMEDIA EMS' => 112,
                'TRINIDAD/COBIJA EMS' => 249,
                'RIBERALTA/GUAYARAMERIN EMS' => 332,
                'CUIDAD CAPITAL ME' => 83,
                'TRINIDAD/COBIJA ME' => 244,
                'PROVINCIA-DENTRO ME' => 116,
                'PROVINCIA-OTRO ME' => 199,
                'SERVICIO-LOCAL LC/AO' => 43,
                'SERVICIO-NACIONAL LC/AO' => 83,
                'PROVINCIA-DENTRO LC/AO' => 116,
                'PROVINCIA-OTRO LC/AO' => 119,
                'TRINIDAD/COBIJA LC/AO' => 244,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 317,
                'SERVICIO-LOCAL ECA' => 38,
                'SERVICIO-NACIONAL ECA' => 75,
                'PROVINCIA-DENTRO ECA' => 105,
                'PROVINCIA-OTRO ECA' => 108,
                'TRINIDAD/COBIJA ECA' => 215,
                'RIBERALTA/GUAYARAMERIN ECA' => 286,
                'UNICO SE' => 270,
                'SERVICIO-LOCAL PO' => 47,
                'SERVICIO-NACIONAL PO' => 85,
                'PROVINCIA-DENTRO PO' => 118,
                'PROVINCIA-OTRO PO' => 122,
                'SERVICIO-NACIONAL SM' => 64,
                'SERVICIO-PROVINCIONAL SM' => 78,
            ];
        } elseif ($peso > 15.001 && $peso <= 16.000) {
            return [
                'LOCAL 1' => 49,
                'LOCAL 2' => 50,
                'LOCAL 3' => 51,
                'LOCAL 4' => 53,
                'CUIDAD CAPITAL EMS' => 114,
                'CUIDAD INTERMEDIA EMS' => 123,
                'TRINIDAD/COBIJA EMS' => 265,
                'RIBERALTA/GUAYARAMERIN EMS' => 353,
                'CUIDAD CAPITAL ME' => 88,
                'TRINIDAD/COBIJA ME' => 260,
                'PROVINCIA-DENTRO ME' => 124,
                'PROVINCIA-OTRO ME' => 212,
                'SERVICIO-LOCAL LC/AO' => 45,
                'SERVICIO-NACIONAL LC/AO' => 88,
                'PROVINCIA-DENTRO LC/AO' => 124,
                'PROVINCIA-OTRO LC/AO' => 127,
                'TRINIDAD/COBIJA LC/AO' => 260,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 338,
                'SERVICIO-LOCAL ECA' => 41,
                'SERVICIO-NACIONAL ECA' => 80,
                'PROVINCIA-DENTRO ECA' => 111,
                'PROVINCIA-OTRO ECA' => 114,
                'TRINIDAD/COBIJA ECA' => 230,
                'RIBERALTA/GUAYARAMERIN ECA' => 304,
                'UNICO SE' => 286,
                'SERVICIO-LOCAL PO' => 49,
                'SERVICIO-NACIONAL PO' => 90,
                'PROVINCIA-DENTRO PO' => 126,
                'PROVINCIA-OTRO PO' => 129,
                'SERVICIO-NACIONAL SM' => 69,
                'SERVICIO-PROVINCIONAL SM' => 83,
            ];
        } elseif ($peso > 16.001 && $peso <= 17.000) {
            return [
                'LOCAL 1' => 51,
                'LOCAL 2' => 52,
                'LOCAL 3' => 53,
                'LOCAL 4' => 55,
                'CUIDAD CAPITAL EMS' => 121,
                'CUIDAD INTERMEDIA EMS' => 129,
                'TRINIDAD/COBIJA EMS' => 281,
                'RIBERALTA/GUAYARAMERIN EMS' => 374,
                'CUIDAD CAPITAL ME' => 94,
                'TRINIDAD/COBIJA ME' => 275,
                'PROVINCIA-DENTRO ME' => 131,
                'PROVINCIA-OTRO ME' => 224,
                'SERVICIO-LOCAL LC/AO' => 47,
                'SERVICIO-NACIONAL LC/AO' => 94,
                'PROVINCIA-DENTRO LC/AO' => 131,
                'PROVINCIA-OTRO LC/AO' => 134,
                'TRINIDAD/COBIJA LC/AO' => 275,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 358,
                'SERVICIO-LOCAL ECA' => 43,
                'SERVICIO-NACIONAL ECA' => 84,
                'PROVINCIA-DENTRO ECA' => 117,
                'PROVINCIA-OTRO ECA' => 121,
                'TRINIDAD/COBIJA ECA' => 243,
                'RIBERALTA/GUAYARAMERIN ECA' => 323,
                'UNICO SE' => 301,
                'SERVICIO-LOCAL PO' => 51,
                'SERVICIO-NACIONAL PO' => 96,
                'PROVINCIA-DENTRO PO' => 133,
                'PROVINCIA-OTRO PO' => 136,
                'SERVICIO-NACIONAL SM' => 73,
                'SERVICIO-PROVINCIONAL SM' => 88,
            ];
        } elseif ($peso > 17.001 && $peso <= 18.000) {
            return [
                'LOCAL 1' => 53,
                'LOCAL 2' => 54,
                'LOCAL 3' => 55,
                'LOCAL 4' => 57,
                'CUIDAD CAPITAL EMS' => 127,
                'CUIDAD INTERMEDIA EMS' => 135,
                'TRINIDAD/COBIJA EMS' => 296,
                'RIBERALTA/GUAYARAMERIN EMS' => 395,
                'CUIDAD CAPITAL ME' => 99,
                'TRINIDAD/COBIJA ME' => 291,
                'PROVINCIA-DENTRO ME' => 138,
                'PROVINCIA-OTRO ME' => 237,
                'SERVICIO-LOCAL LC/AO' => 49,
                'SERVICIO-NACIONAL LC/AO' => 99,
                'PROVINCIA-DENTRO LC/AO' => 138,
                'PROVINCIA-OTRO LC/AO' => 143,
                'TRINIDAD/COBIJA LC/AO' => 291,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 379,
                'SERVICIO-LOCAL ECA' => 44,
                'SERVICIO-NACIONAL ECA' => 89,
                'PROVINCIA-DENTRO ECA' => 125,
                'PROVINCIA-OTRO ECA' => 129,
                'TRINIDAD/COBIJA ECA' => 258,
                'RIBERALTA/GUAYARAMERIN ECA' => 342,
                'UNICO SE' => 317,
                'SERVICIO-LOCAL PO' => 53,
                'SERVICIO-NACIONAL PO' => 101,
                'PROVINCIA-DENTRO PO' => 140,
                'PROVINCIA-OTRO PO' => 145,
                'SERVICIO-NACIONAL SM' => 77,
                'SERVICIO-PROVINCIONAL SM' => 94,
            ];
        } elseif ($peso > 18.001 && $peso <= 19.000) {
            return [
                'LOCAL 1' => 55,
                'LOCAL 2' => 56,
                'LOCAL 3' => 57,
                'LOCAL 4' => 59,
                'CUIDAD CAPITAL EMS' => 134,
                'CUIDAD INTERMEDIA EMS' => 142,
                'TRINIDAD/COBIJA EMS' => 312,
                'RIBERALTA/GUAYARAMERIN EMS' => 416,
                'CUIDAD CAPITAL ME' => 104,
                'TRINIDAD/COBIJA ME' => 307,
                'PROVINCIA-DENTRO ME' => 145,
                'PROVINCIA-OTRO ME' => 249,
                'SERVICIO-LOCAL LC/AO' => 51,
                'SERVICIO-NACIONAL LC/AO' => 104,
                'PROVINCIA-DENTRO LC/AO' => 145,
                'PROVINCIA-OTRO LC/AO' => 151,
                'TRINIDAD/COBIJA LC/AO' => 307,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 400,
                'SERVICIO-LOCAL ECA' => 46,
                'SERVICIO-NACIONAL ECA' => 94,
                'PROVINCIA-DENTRO ECA' => 131,
                'PROVINCIA-OTRO ECA' => 136,
                'TRINIDAD/COBIJA ECA' => 271,
                'RIBERALTA/GUAYARAMERIN ECA' => 361,
                'UNICO SE' => 332,
                'SERVICIO-LOCAL PO' => 55,
                'SERVICIO-NACIONAL PO' => 106,
                'PROVINCIA-DENTRO PO' => 148,
                'PROVINCIA-OTRO PO' => 153,
                'SERVICIO-NACIONAL SM' => 81,
                'SERVICIO-PROVINCIONAL SM' => 99,
            ];
        } elseif ($peso > 18.001 && $peso <= 19.000) {
            return [
                'LOCAL 1' => 57,
                'LOCAL 2' => 58,
                'LOCAL 3' => 59,
                'LOCAL 4' => 61,
                'CUIDAD CAPITAL EMS' => 140,
                'CUIDAD INTERMEDIA EMS' => 150,
                'TRINIDAD/COBIJA EMS' => 327,
                'RIBERALTA/GUAYARAMERIN EMS' => 436,
                'CUIDAD CAPITAL ME' => 109,
                'TRINIDAD/COBIJA ME' => 322,
                'PROVINCIA-DENTRO ME' => 153,
                'PROVINCIA-OTRO ME' => 262,
                'SERVICIO-LOCAL LC/AO' => 53,
                'SERVICIO-NACIONAL LC/AO' => 109,
                'PROVINCIA-DENTRO LC/AO' => 153,
                'PROVINCIA-OTRO LC/AO' => 158,
                'TRINIDAD/COBIJA LC/AO' => 322,
                'RIBERALTA/GUAYARAMERIN LC/AO' => 421,
                'SERVICIO-LOCAL ECA' => 48,
                'SERVICIO-NACIONAL ECA' => 99,
                'PROVINCIA-DENTRO ECA' => 137,
                'PROVINCIA-OTRO ECA' => 142,
                'TRINIDAD/COBIJA ECA' => 281,
                'RIBERALTA/GUAYARAMERIN ECA' => 379,
                'UNICO SE' => 348,
                'SERVICIO-LOCAL PO' => 57,
                'SERVICIO-NACIONAL PO' => 111,
                'PROVINCIA-DENTRO PO' => 155,
                'PROVINCIA-OTRO PO' => 160,
                'SERVICIO-NACIONAL SM' => 85,
                'SERVICIO-PROVINCIONAL SM' => 104,
            ];
        }

        throw new \Exception("Peso fuera de rango para tarificación.");
    }
}
