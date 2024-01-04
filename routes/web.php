<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\NationalController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\PcertificateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
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
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->middleware('can:users.index')->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
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
    Route::get('packages/listas', [PackageController::class, 'listas'])->name('packages.listas');

    //Modulo Clasificacion
    Route::get('packages/clasificacion', [PackageController::class, 'clasificacion'])->middleware('can:packages.clasificacion')->name('packages.clasificacion');
    Route::get('test/redirigidos', [PackageController::class, 'redirigidos'])->name('packages.redirigidos');
    Route::get('test/dirigido/{id}', [PackageController::class, 'dirigido'])->name('packages.dirigido');
    Route::get('packages/entregasclasificacion', [PackageController::class, 'entregasclasificacion'])->middleware('can:packages.clasificacion')->name('packages.entregasclasificacion');

    //Modulo Ventanilla
    Route::get('packages/ventanilla', [PackageController::class, 'ventanilla'])->middleware('can:packages.ventanilla')->name('packages.ventanilla');
    Route::get('test/deleteado', [PackageController::class, 'deleteado'])->middleware('can:packages.delete')->name('test.deleteado');
    Route::post('packages/buscarPaquete', [PackageController::class, 'buscarPaquete'])->name('packages.buscarPaquete');
    Route::get('packages/{id}/delete', [PackageController::class, 'delete'])->name('packages.delete');
    Route::put('test/{id}/restoring', [PackageController::class, 'restoring'])->name('packages.restoring');
    Route::get('packages/redirigir/{id}', [PackageController::class, 'redirigir'])->name('packages.redirigir');
    Route::get('packages/prerezago', [PackageController::class, 'prerezago'])->middleware('can:packages.prerezago')->name('packages.prerezago');
    Route::get('packages/rezago', [PackageController::class, 'rezago'])->middleware('can:packages.rezago')->name('packages.rezago');

    //Modulo Cartero
    Route::get('packages/carteros', [PackageController::class, 'carteros'])->middleware('can:packages.carteros')->name('packages.carteros');
    Route::get('packages/inventariocartero', [PackageController::class, 'inventariocartero'])->middleware('can:packages.inventariocartero')->name('packages.inventariocartero');
    Route::post('packages/{id}/deletecartero', [PackageController::class, 'deletecartero'])->name('packages.deletecartero');
    Route::post('packages/buscarPaqueteCartero', [PackageController::class, 'buscarPaqueteCartero'])->name('packages.buscarPaqueteCartero');
    Route::get('packages/distribuicioncartero', [PackageController::class, 'distribuicioncartero'])->middleware('can:packages.distribuicioncartero')->name('packages.distribuicioncartero');
    Route::get('packages/generalcartero', [PackageController::class, 'generalcartero'])->middleware('can:packages.generalcartero')->name('packages.generalcartero');
    Route::get('packages/despachocartero', [PackageController::class, 'despachocartero'])->middleware('can:packages.carteros')->name('packages.despachocartero');
    Route::get('packages/despachogeneralcartero', [PackageController::class, 'despachogeneralcartero'])->name('packages.despachogeneralcartero');

    // Reportes PDF
    Route::get('package/pdf/packagesallpdf', [PackageController::class, 'packagesallpdf'])->name('package.pdf.packagesall');
    Route::get('package/pdf/clasificacionpdf', [PackageController::class, 'clasificacionpdf'])->name('package.pdf.clasificacionpdf');
    Route::post('package/pdf/despachopdf', [PackageController::class, 'despachopdf'])->name('package.pdf.despachopdf');
    Route::get('package/pdf/redirigidospdf', [PackageController::class, 'redirigidospdf'])->name('package.pdf.redirigidospdf');
    Route::get('package/pdf/ventanillapdf', [PackageController::class, 'ventanillapdf'])->name('package.pdf.ventanillapdf');
    Route::get('package/pdf/deleteadopdf', [PackageController::class, 'deleteadopdf'])->name('package.pdf.deleteadopdf');
    Route::get('/events/pdf/eventspdf', [EventController::class, 'eventspdf'])->name('events.pdf.eventspdf');
    Route::get('package/pdf/formularioentrega/{id}', [PackageController::class, 'formularioentrega'])->name('package.pdf.formularioentrega');
    Route::get('package/pdf/abandono/{id}', [PackageController::class, 'abandono'])->name('package.pdf.abandono');
    Route::get('package/pdf/carteropdf', [PackageController::class, 'carteropdf'])->name('package.pdf.carteropdf');
    Route::get('package/pdf/deleteadocarteropdf', [PackageController::class, 'deleteadocarteropdf'])->name('package.pdf.deleteadocarteropdf');
    Route::get('package/pdf/deleteadogeneralcarteropdf', [PackageController::class, 'deleteadogeneralcarteropdf'])->name('package.pdf.deleteadogeneralcarteropdf');
    Route::get('package/pdf/asignarcartero', [PackageController::class, 'asignarcartero'])->name('package.pdf.asignarcartero');
    Route::get('package/pdf/prerezago', [PackageController::class, 'prerezago'])->name('package.pdf.prerezago');
    Route::post('national/pdf/despachopdf', [PackageController::class, 'despachopdf'])->name('national.pdf.despachopdf');
    
    // Reportes Excel
    Route::get('package/packagesallexcel', [PackageController::class, 'packagesallexcel'])->name('packagesall.excel');
    Route::get('clasificacion/clasificacionexcel', [PackageController::class, 'clasificacionexcel'])->name('clasificacion.excel');
    Route::get('clasificacion/reencaminarexcel', [PackageController::class, 'reencaminarexcel'])->name('reencaminar.excel');
    Route::get('ventanilla/ventanillaexcel', [PackageController::class, 'ventanillaexcel'])->name('ventanilla.excel');
    Route::get('ventanilla/inventarioexcel', [PackageController::class, 'inventarioexcel'])->name('inventario.excel');
    Route::get('cartero/carteroexcel', [PackageController::class, 'carteroexcel'])->name('cartero.excel');
    Route::get('cartero/carterogeneralexcel', [PackageController::class, 'carterogeneralexcel'])->name('carterogeneralexcel.excel');

    Route::get('/national', [NationalController::class, 'index'])->name('nationals.index');
    Route::get('/national/create', [NationalController::class, 'create'])->name('nationals.create');
    Route::post('/national', [NationalController::class, 'store'])->name('nationals.store');
    // Route::get('/national/{national}', [NationalController::class, 'show'])->name('nationals.show');
    Route::get('/national/{national}/edit', [NationalController::class, 'edit'])->name('nationals.edit');
    Route::put('/national/{national}', [NationalController::class, 'update'])->name('nationals.update');
    Route::delete('/national/{national}', [NationalController::class, 'destroy'])->name('nationals.destroy');
    Route::get('/national/total', [NationalController::class, 'total'])->name('national.total');
    Route::get('/national/despachoadmision', [NationalController::class, 'despachoadmision'])->name('national.despachoadmision');
    //Eventos
    Route::get('/events', [EventController::class, 'index'])->middleware('can:users.index')->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::get('events/{events}', [EventController::class, 'show'])->name('events.show');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    //Mensajeria
    Route::get('/mensajes', [MensajeController::class, 'index'])->middleware('can:users.index')->name('mensajes.index');
    Route::get('/mensaje/create', [MensajeController::class, 'create'])->name('mensajes.create');
    // Route::get('/mensajes/{mensaje}', [MensajeController::class, 'show'])->name('mensajes.show');
    Route::post('/mensaje', [MensajeController::class, 'store'])->name('mensajes.store');
    Route::get('/mensaje/{mensaje}/edit', [MensajeController::class, 'edit'])->name('mensajes.edit');
    Route::put('/mensaje/{mensaje}', [MensajeController::class, 'update'])->name('mensajes.update');
    Route::delete('/mensaje/{mensaje}', [MensajeController::class, 'destroy'])->name('mensajes.destroy');

    //Roles
    Route::get('/roles', [RoleController::class, 'index'])->middleware('can:users.index')->name('roles.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('roles.create');
    // Route::get('/role/{mensaje}', [RoleController::class, 'show'])->name('roles.show');
    Route::post('/role', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/role/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Blade::if('role', function ($roles) {
        return auth()->check() && auth()->user()->hasAnyRole(explode('|', $roles));
    });
});

require __DIR__ . '/auth.php';
