<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('predefined.token')->group(function () {
    Route::get('/prueba/{codigo}', [ApiController::class, 'show']);
    Route::post('/ventanilla', [ApiController::class, 'ventanilla']);
    Route::get('/packages', [ApiController::class, 'index']);
    Route::get('/softdeletes', [ApiController::class, 'softdeletes']);
    Route::post('/delete/{codigo}', [ApiController::class, 'delete']);
});
