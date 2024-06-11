<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('usuarios', ApiController::class);
// Route::apiResource('/prueba', ApiController::class);
Route::get('/prueba/{codigo}', [ApiController::class, 'show']);