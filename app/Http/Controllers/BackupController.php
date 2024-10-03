<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    // Listar los archivos de backup
    public function index()
    {
        // Obtener archivos desde storage/app/TrackPak
        $files = Storage::disk('local')->files('TrackPak');

        // Retornar vista con la lista de archivos
        return view('backups.index', compact('files'));
    }

    // Descargar un archivo de backup específico
    public function download($file)
    {
        $filePath = "TrackPak/{$file}";

        if (Storage::disk('local')->exists($filePath)) {
            // Usar streamDownload y agregar encabezados en el tercer parámetro
            return response()->streamDownload(function () use ($filePath) {
                echo Storage::disk('local')->get($filePath);
            }, basename($filePath), [
                'Access-Control-Allow-Origin' => '*',  // Encabezado para CORS
            ]);
        }

        return redirect()->back()->with('error', 'Archivo no encontrado');
    }
    public function runBackup()
    {
        try {
            // Ejecuta el comando php artisan backup:run
            Artisan::call('backup:run');
            
            // Mensaje de éxito
            return redirect()->back()->with('success', 'Respaldo ejecutado correctamente.');
        } catch (\Exception $e) {
            // Capturar y mostrar el error
            return redirect()->back()->with('error', 'Ocurrió un error durante el respaldo: ' . $e->getMessage());
        }
    }
    
}
