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
    
    Route::resource('roles', App\Http\Controllers\RoleHasPermissionController::class);    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('packages', App\Http\Controllers\PackageController::class);
    Route::get('packages/{id}/delete', [PackageController::class, 'delete'])->name('packages.delete');
    Route::get('test/deleteado', [PackageController::class, 'deleteado'])->name('test.deleteado');
    Route::put('test/{id}/restoring', [PackageController::class, 'restoring'])->name('packages.restoring');
    Route::get('prueba/excel', [PackageController::class, 'excel'])->name('prueba.excel');
    Route::get('prueba/pdf', [PackageController::class, 'pdf'])->name('prueba.pdf');

    Route::resource('pcertificates', App\Http\Controllers\PcertificateController::class);    
    Route::get('pcertificates/{id}/delete', [PcertificateController::class, 'delete'])->name('pcertificates.delete');
    Route::get('ctest/deleteado', [PcertificateController::class, 'deleteado'])->name('ctest.deleteado');
    Route::put('ctest/{id}/restoring', [PcertificateController::class, 'restoring'])->name('pcertificates.restoring');
    Route::get('prueba1/excel', [PcertificateController::class, 'excel'])->name('prueba1.excel');
    Route::get('prueba1/pdf', [PcertificateController::class, 'pdf'])->name('prueba1.pdf');

    Blade::if('role', function ($roles) {
        return auth()->check() && auth()->user()->hasAnyRole(explode('|', $roles));
    });
});

require __DIR__.'/auth.php';
