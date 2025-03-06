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
    Route::get('/packagesUDD', [ApiController::class, 'packagesUDD']);
    Route::get('/packagesUDND', [ApiController::class, 'packagesUDND']);
    Route::get('/packagesUECA', [ApiController::class, 'packagesUECA']);
    Route::get('/packagesUCASILLAS', [ApiController::class, 'packagesUCASILLAS']);
    Route::get('/packagesUENCOMIENDAS', [ApiController::class, 'packagesUENCOMIENDAS']);
    Route::get('/packagesRDD', [ApiController::class, 'packagesRDD']);
    Route::get('/packagesRDND', [ApiController::class, 'packagesRDND']);
    Route::get('/packagesRCASILLAS', [ApiController::class, 'packagesRCASILLAS']);
    Route::get('/softdeletes', [ApiController::class, 'softdeletes']);
    Route::get('/softdeletesUDD', [ApiController::class, 'softdeletesUDD']);
    Route::get('/softdeletesUDND', [ApiController::class, 'softdeletesUDND']);
    Route::get('/softdeletesUECA', [ApiController::class, 'softdeletesUECA']);
    Route::get('/softdeletesUCASILLAS', [ApiController::class, 'softdeletesUCASILLAS']);
    Route::get('/softdeletesUENCOMIENDAS', [ApiController::class, 'softdeletesUENCOMIENDAS']);
    Route::get('/softdeletesRDD', [ApiController::class, 'softdeletesRDD']);
    Route::get('/softdeletesRDND', [ApiController::class, 'softdeletesRDND']);
    Route::get('/softdeletesRCASILLAS', [ApiController::class, 'softdeletesRCASILLAS']);
    Route::get('/callventanilla', [ApiController::class, 'callventanilla']);
    Route::get('/callclasi', [ApiController::class, 'callclasi']);
    Route::get('/callclasiUDD', [ApiController::class, 'callclasiUDD']);
    Route::get('/callclasiUDND', [ApiController::class, 'callclasiUDND']);
    Route::get('/callclasiUCASILLAS', [ApiController::class, 'callclasiUCASILLAS']);
    Route::get('/callclasiUECA', [ApiController::class, 'callclasiUECA']);
    Route::get('/callclasiUENCOMIENDAS', [ApiController::class, 'callclasiUENCOMIENDAS']);
    Route::post('/delete/{codigo}', [ApiController::class, 'delete']);
    Route::get('/events/repeated-codes/{codigo}', [ApiController::class, 'getEventsByCodigo']);
    Route::get('/searchbymanifiesto', [ApiController::class, 'searchByManifiesto']);
    Route::put('/updatePackage/{id}', [ApiController::class, 'updatePackage']);
    Route::post('/actualizar-imagenes', [ApiController::class, 'updateImages']);
});
