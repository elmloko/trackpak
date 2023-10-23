<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PcertificateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);    
    Route::get('users/{id}/delete', [PackageController::class, 'delete'])->name('users.delete');
    Route::get('utest/deleteado', [UserController::class, 'deleteado'])->name('utest.deleteado');
    Route::put('utest/{id}/restoring', [UserController::class, 'restoring'])->name('users.restoring');
    Route::get('prueba2/excel', [UserController::class, 'excel'])->name('usuario1.excel');
    Route::get('prueba2/pdf', [UserController::class, 'pdf'])->name('usuario1.pdf');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');   

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('packages', App\Http\Controllers\PackageController::class);
    Route::get('packages/{id}/delete', [PackageController::class, 'delete'])->name('packages.delete');
    Route::get('test/deleteado', [PackageController::class, 'deleteado'])->name('test.deleteado');
    Route::put('test/{id}/restoring', [PackageController::class, 'restoring'])->name('packages.restoring');
    Route::get('prueba/excel', [PackageController::class, 'excel'])->name('prueba.excel');
    Route::get('prueba/pdf', [PackageController::class, 'pdf'])->name('prueba.pdf');
    Route::get('packages/redirigir/{id}', [PackageController::class, 'redirigir'])->name('packages.redirigir');
    Route::get('test/redirigidos', [PackageController::class, 'redirigidos'])->name('packages.redirigidos');
    Route::get('test/dirigido/{id}', [PackageController::class, 'dirigido'])->name('packages.dirigido');


    Blade::if('role', function ($roles) {
        return auth()->check() && auth()->user()->hasAnyRole(explode('|', $roles));
    });
});

require __DIR__.'/auth.php';
