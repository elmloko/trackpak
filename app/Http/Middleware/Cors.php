<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Verificar si la respuesta es de tipo BinaryFileResponse o StreamedResponse
        if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            // Para BinaryFileResponse y StreamedResponse, usar el objeto headers
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
        } else {
            // Para respuestas normales, usar el método header
            $response->header('Access-Control-Allow-Origin', '*')
                     ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                     ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
        }

        return $response;
    }
}
