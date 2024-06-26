<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/prueba/{codigo}', [ApiController::class, 'show']);
Route::post('/api/ventanillaingreso', 'VentanillaIngresoController@ventanillaIngreso');