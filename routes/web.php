<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PcertificateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\EventController;
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

Route::get('/search', [EventController::class, 'search'])->name('search');
Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/{id}/delete', [PackageController::class, 'delete'])->name('users.delete');
    Route::get('utest/deleteado', [UserController::class, 'deleteado'])->name('utest.deleteado');
    Route::put('utest/{id}/restoring', [UserController::class, 'restoring'])->name('users.restoring');
    Route::get('users/excel', [UserController::class, 'excel'])->name('users.excel');
    Route::get('users/pdf', [UserController::class, 'pdf'])->name('users.pdf');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
    Route::get('packages/create', [PackageController::class, 'create'])->name('packages.create');
    Route::post('packages', [PackageController::class, 'store'])->name('packages.store');
    // Route::get('test/{test}', [PackageController::class, 'show'])->name('test.show');
    Route::get('packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
    Route::put('packages/{package}', [PackageController::class, 'update'])->name('packages.update');
    Route::delete('packages/{packages}', [PackageController::class, 'destroy'])->name('packages.destroy');
    Route::get('packages/{id}/delete', [PackageController::class, 'delete'])->name('packages.delete');
    Route::get('test/deleteado', [PackageController::class, 'deleteado'])->name('test.deleteado');
    Route::put('test/{id}/restoring', [PackageController::class, 'restoring'])->name('packages.restoring');
    Route::get('prueba/excel', [PackageController::class, 'excel'])->name('prueba.excel');
    Route::get('prueba/pdf', [PackageController::class, 'pdf'])->name('prueba.pdf');
    Route::get('packages/redirigir/{id}', [PackageController::class, 'redirigir'])->name('packages.redirigir');
    Route::get('packages/ventanilla', [PackageController::class, 'ventanilla'])->name('packages.ventanilla');
    Route::get('packages/clasificacion', [PackageController::class, 'clasificacion'])->name('packages.clasificacion');
    Route::get('test/redirigidos', [PackageController::class, 'redirigidos'])->name('packages.redirigidos');
    Route::get('test/dirigido/{id}', [PackageController::class, 'dirigido'])->name('packages.dirigido');
    Route::get('ventanilla/ventanillaexcel', [PackageController::class, 'ventanillaexcel'])->name('ventanilla.excel');
    Route::get('package/pdf/ventanillapdf', [PackageController::class, 'ventanillapdf'])->name('package.pdf.ventanillapdf');
    Route::get('clasificacion/clasificacionexcel', [PackageController::class, 'clasificacionexcel'])->name('clasificacion.excel');
    Route::get('package/pdf/clasificacionpdf', [PackageController::class, 'clasificacionpdf'])->name('package.pdf.clasificacionpdf');
    Route::post('packages/buscarPaquete', [PackageController::class, 'buscarPaquete'])->name('packages.buscarPaquete');

    Route::resource('events', EventController::class);
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/pdf/eventspdf', [EventController::class, 'eventspdf'])->name('events.pdf.eventspdf');

    Blade::if('role', function ($roles) {
        return auth()->check() && auth()->user()->hasAnyRole(explode('|', $roles));
    });
});

require __DIR__ . '/auth.php';
