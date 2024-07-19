<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\NationalController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BagController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PackagesHasBagController;
use App\Http\Controllers\RoleHasPermissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternationalController;
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
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::put('utest/{id}/restoring', [UserController::class, 'restoring'])->name('users.restoring');
    Route::get('users/excel', [UserController::class, 'excel'])->name('users.excel');
    Route::get('users/pdf', [UserController::class, 'pdf'])->name('users.pdf');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

    //Roles
    Route::get('/roles', [RoleController::class, 'index'])->middleware('can:users.index')->name('roles.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('roles.create');
    // Route::get('/role/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::post('/role', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/role/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    //Permisos
    Route::get('/permissions', [PermissionController::class, 'index'])->middleware('can:users.index')->name('permissions.index');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permissions.create');
    // Route::get('/permission/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
    Route::post('/permission', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permission/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permission/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permission/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    //Accesos
    Route::get('/role-has-permissions', [RoleHasPermissionController::class, 'index'])->middleware('can:users.index')->name('role-has-permissions.index');
    Route::get('/role-has-permission/create', [RoleHasPermissionController::class, 'create'])->name('role-has-permissions.create');
    // Route::get('/role-has-permission/{roleHasPermission}', [RoleHasPermissionController::class, 'show'])->name('role-has-permissions.show');
    Route::post('/role-has-permission', [RoleHasPermissionController::class, 'store'])->name('role-has-permissions.store');
    Route::get('/role-has-permission/{roleHasPermission}/edit', [RoleHasPermissionController::class, 'edit'])->name('role-has-permissions.edit');
    Route::put('/role-has-permission/{roleHasPermission', [RoleHasPermissionController::class, 'update'])->name('role-has-permissions.update');
    Route::delete('/role-has-permission/{roleHasPermission}', [RoleHasPermissionController::class, 'destroy'])->name('role-has-permissions.destroy');

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
    Route::get('packages/ventanilladnd', [PackageController::class, 'ventanilladnd'])->middleware('can:packages.dnd')->name('packages.ventanilladnd');
    Route::get('packages/ventanillaunica', [PackageController::class, 'ventanillaunica'])->name('packages.ventanillaunica');
    Route::get('packages/ventanillaunicarecibir', [PackageController::class, 'ventanillaunicarecibir'])->name('packages.ventanillaunicarecibir');
    Route::get('test/deleteado', [PackageController::class, 'deleteado'])->middleware('can:packages.delete')->name('test.deleteado');
    Route::get('test/deleteadounica', [PackageController::class, 'deleteadounica'])->name('test.deleteadounica');
    Route::get('test/deleteadodnd', [PackageController::class, 'deleteadodnd'])->middleware('can:packages.dnd')->name('test.deleteadodnd');
    Route::post('packages/buscarPaquete', [PackageController::class, 'buscarPaquete'])->name('packages.buscarPaquete');
    Route::post('packages/buscarPaqueteunica', [PackageController::class, 'buscarPaqueteunica'])->name('packages.buscarPaqueteunica');
    Route::get('packages/{id}/delete', [PackageController::class, 'delete'])->name('packages.delete');
    Route::put('test/{id}/restoring', [PackageController::class, 'restoring'])->name('packages.restoring');
    Route::get('packages/redirigir/{id}', [PackageController::class, 'redirigir'])->name('packages.redirigir');
    Route::get('packages/prerezago', [PackageController::class, 'prerezago'])->middleware('can:packages.prerezago')->name('packages.prerezago');
    Route::get('packages/rezago', [PackageController::class, 'rezago'])->middleware('can:packages.rezago')->name('packages.rezago');

    //Modulo Cartero
    Route::get('packages/carteros', [PackageController::class, 'carteros'])->middleware('can:packages.carteros')->name('packages.carteros');
    Route::get('packages/carterosgeneral', [PackageController::class, 'carterosgeneral'])->middleware('can:packages.ventanilla')->name('packages.carterosgeneral');
    Route::get('packages/inventariocartero', [PackageController::class, 'inventariocartero'])->middleware('can:packages.inventariocartero')->name('packages.inventariocartero');
    Route::post('packages/{id}/deletecartero', [PackageController::class, 'deletecartero'])->name('packages.deletecartero');
    Route::post('packages/buscarPaqueteCartero', [PackageController::class, 'buscarPaqueteCartero'])->name('packages.buscarPaqueteCartero');
    Route::get('packages/distribuicioncartero', [PackageController::class, 'distribuicioncartero'])->middleware('can:packages.distribuicioncartero')->name('packages.distribuicioncartero');
    Route::get('packages/generalcartero', [PackageController::class, 'generalcartero'])->middleware('can:packages.generalcartero')->name('packages.generalcartero');
    Route::get('packages/despachocartero', [PackageController::class, 'despachocartero'])->middleware('can:packages.carteros')->name('packages.despachocartero');
    Route::get('packages/despachocarterogeneral', [PackageController::class, 'despachocarterogeneral'])->middleware('can:packages.ventanilla')->name('packages.despachocarterogeneral');
    Route::get('packages/despachogeneralcartero', [PackageController::class, 'despachogeneralcartero'])->name('packages.despachogeneralcartero');

    //Casillas
    Route::get('packages/casillas', [PackageController::class, 'casillas'])->name('packages.casillas');
    Route::get('packages/{id}/deletecasillas', [PackageController::class, 'deletecasillas'])->name('packages.deletecasillas');
    Route::get('packages/casillasinventario', [PackageController::class, 'casillasinventario'])->name('packages.casillasinventario');
    Route::post('packages/buscarPaquetecasilla', [PackageController::class, 'buscarPaquetecasilla'])->name('packages.buscarPaquetecasilla');

    //Eca
    Route::get('packages/eca', [PackageController::class, 'eca'])->name('packages.eca');
    Route::get('packages/{id}/deleteeca', [PackageController::class, 'deleteeca'])->name('packages.deleteeca');
    Route::get('packages/ecainventario', [PackageController::class, 'ecainventario'])->name('packages.ecainventario');
    Route::post('packages/buscarPaqueteeca', [PackageController::class, 'buscarPaqueteeca'])->name('packages.buscarPaqueteeca');

    Route::get('packages/encomiendas', [PackageController::class, 'encomiendas'])->name('packages.encomiendas');
    Route::get('packages/encomiendasinventario', [PackageController::class, 'encomiendasinventario'])->name('packages.encomiendasinventario');
    // Route::get('packages/{id}/deleteencomiendas', [PackageController::class, 'deleteencomiendas'])->name('packages.deleteencomiendas');
    // Route::post('packages/buscarPaqueteencomiendas', [PackageController::class, 'buscarPaqueteeca'])->name('packages.buscarPaqueteencomiendas');

    // Reportes PDF
    Route::get('package/pdf/packagesallpdf', [PackageController::class, 'packagesallpdf'])->name('package.pdf.packagesall');
    Route::get('package/pdf/clasificacionpdf', [PackageController::class, 'clasificacionpdf'])->name('package.pdf.clasificacionpdf');
    Route::post('package/pdf/despachopdf', [PackageController::class, 'despachopdf'])->name('package.pdf.despachopdf');
    Route::post('package/pdf/despachoecapdf', [PackageController::class, 'despachoecapdf'])->name('package.pdf.despachoecapdf');
    Route::get('package/pdf/redirigidospdf', [PackageController::class, 'redirigidospdf'])->name('package.pdf.redirigidospdf');
    Route::get('package/pdf/ventanillapdf', [PackageController::class, 'ventanillapdf'])->name('package.pdf.ventanillapdf');
    Route::get('package/pdf/deleteadopdf', [PackageController::class, 'deleteadopdf'])->name('package.pdf.deleteadopdf');
    Route::get('/events/pdf/eventspdf', [EventController::class, 'eventspdf'])->name('events.pdf.eventspdf');
    Route::get('package/pdf/formularioentrega/{id}', [PackageController::class, 'formularioentrega'])->name('package.pdf.formularioentrega');
    Route::get('package/pdf/formularioentrega2/{id}', [PackageController::class, 'formularioentrega2'])->name('package.pdf.formularioentrega2');
    Route::get('package/pdf/abandono/{id}', [PackageController::class, 'abandono'])->name('package.pdf.abandono');
    Route::get('package/pdf/carteropdf', [PackageController::class, 'carteropdf'])->name('package.pdf.carteropdf');
    Route::get('package/pdf/deleteadocarteropdf', [PackageController::class, 'deleteadocarteropdf'])->name('package.pdf.deleteadocarteropdf');
    Route::get('package/pdf/deleteadogeneralcarteropdf', [PackageController::class, 'deleteadogeneralcarteropdf'])->name('package.pdf.deleteadogeneralcarteropdf');
    Route::get('package/pdf/asignarcartero', [PackageController::class, 'asignarcartero'])->name('package.pdf.asignarcartero');
    Route::get('package/pdf/prerezago', [PackageController::class, 'prerezago'])->name('package.pdf.prerezago');
    Route::get('package/pdf/deleteadoencomiendaspdf', [PackageController::class, 'deleteadoencomiendaspdf'])->name('package.pdf.deleteadoencomiendaspdf');

    // Reportes Excel
    Route::get('package/packagesallexcel', [PackageController::class, 'packagesallexcel'])->name('packagesall.excel');
    Route::get('clasificacion/clasificacionexcel', [PackageController::class, 'clasificacionexcel'])->name('clasificacion.excel');
    Route::get('clasificacion/reencaminarexcel', [PackageController::class, 'reencaminarexcel'])->name('reencaminar.excel');
    Route::get('ventanilla/ventanillaexcel', [PackageController::class, 'ventanillaexcel'])->name('ventanilla.excel');
    Route::get('ventanilla/ventanilladndexcel', [PackageController::class, 'ventanilladndexcel'])->name('ventanilladnd.excel');
    Route::get('ventanilla/encomiendasexcel', [PackageController::class, 'encomiendasexcel'])->name('encomiendas.excel');
    Route::get('ventanilla/casillasexcel', [PackageController::class, 'casillasexcel'])->name('casillas.excel');
    Route::get('ventanilla/ecaexcel', [PackageController::class, 'ecaexcel'])->name('eca.excel');
    Route::get('ventanilla/inventarioexcel', [PackageController::class, 'inventarioexcel'])->name('inventario.excel');
    Route::get('ventanilla/inventarioDDexcel', [PackageController::class, 'inventarioDDexcel'])->name('inventarioDD.excel');
    Route::get('ventanilla/inventarioDNDexcel', [PackageController::class, 'inventarioDNDexcel'])->name('inventarioDND.excel');
    Route::get('ventanilla/inventarioECAexcel', [PackageController::class, 'inventarioECAexcel'])->name('inventarioECA.excel');
    Route::get('ventanilla/inventarioCASIexcel', [PackageController::class, 'inventarioCASIexcel'])->name('inventarioCASI.excel');
    Route::get('ventanilla/inventarioUNICAexcel', [PackageController::class, 'inventarioUNICAexcel'])->name('inventarioUNICA.excel');
    Route::get('ventanilla/casillasinventarioexcel', [PackageController::class, 'casillasinventarioexcel'])->name('casillasinventarioexcel.excel');
    Route::get('ventanilla/ecainventarioexcel', [PackageController::class, 'ecainventarioexcel'])->name('ecainventarioexcel.excel');
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
    Route::get('/national/pdf/cn22', [NationalController::class, 'cn22'])->name('national.pdf.cn22');
    Route::get('national/despachoadmisionexcel', [NationalController::class, 'despachoadmisionexcel'])->name('despachoadmision.excel');
    Route::get('/national/nacionaldespacho', [NationalController::class, 'nacionaldespacho'])->name('national.nacionaldespacho');
    Route::post('national/buscarPaquete', [NationalController::class, 'buscarPaquete'])->name('national.buscarPaquete');
    Route::put('/national/{id}/devolver', [NationalController::class, 'devolver'])->name('national.devolver');
    Route::get('/national/nacionalcartero', [NationalController::class, 'nacionalcartero'])->name('national.nacionalcartero');
    Route::get('/national/nacionalexpedision', [NationalController::class, 'nacionalexpedision'])->name('national.nacionalexpedision');
    Route::get('/national/nacionalunica', [NationalController::class, 'nacionalunica'])->name('national.nacionalunica');
    Route::get('/national/nacionalunicainventario', [NationalController::class, 'nacionalunicainventario'])->name('national.nacionalunicainventario');
    Route::get('/national/nacionalexpedisionexcel', [NationalController::class, 'nacionalexpedisionexcel'])->name('nacionalexpedision.excel');
    Route::post('national/llegarPaquete', [NationalController::class, 'llegarPaquete'])->name('national.llegarPaquete');
    //Eventos
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
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

    //Sacas
    Route::get('/bags', [BagController::class, 'index'])->name('bags.index');
    Route::get('/bag/create', [BagController::class, 'create'])->name('bags.create');
    Route::get('bags/{bags}', [BagController::class, 'show'])->name('bags.show');
    Route::post('/bag', [BagController::class, 'store'])->name('bags.store');
    Route::get('/bag/{bag}/edit', [BagController::class, 'edit'])->name('bags.edit');
    Route::put('/bag/{bag}', [BagController::class, 'update'])->name('bags.update');
    Route::delete('/bag/{bag}', [BagController::class, 'destroy'])->name('bags.destroy');
    Route::put('/bags/close/{id}', [BagController::class, 'closeExpedition'])->name('bags.closeExpedition');
    Route::put('/bags/show/{id}', [BagController::class, 'showExpedition'])->name('bags.showExpedition');
    Route::put('/bags/aviso/{id}', [BagController::class, 'avisoExpedition'])->name('bags.avisoExpedition');
    Route::put('/bags/go/{id}', [BagController::class, 'goExpedition'])->name('bags.goExpedition');
    Route::put('/bags/return/{id}', [BagController::class, 'returnExpedition'])->name('bags.returnExpedition');
    Route::get('/bag/bagsclose', [BagController::class, 'bagsclose'])->name('bags.bagsclose');
    Route::get('/bag/bagsopen', [BagController::class, 'bagsopen'])->name('bags.bagsopen');
    Route::get('/bag/bagstrans', [BagController::class, 'bagstrans'])->name('bags.bagstrans');
    Route::post('bag/bagsadd', [BagController::class, 'bagsadd'])->name('bag.bagsadd');
    Route::get('bag/pdf/cn31', [BagController::class, 'cn35'])->name('bag.pdf.cn31');
    Route::get('bag/pdf/cn35', [BagController::class, 'cn35'])->name('bag.pdf.cn35');
    Route::get('bag/pdf/cn38', [BagController::class, 'cn38'])->name('bag.pdf.cn38');
    Route::get('/bag/bagsall', [BagController::class, 'bagsall'])->name('bags.bagsall');

    //Sacas y paquetes
    Route::get('/packages-has-bags', [PackagesHasBagController::class, 'index'])->name('packages-has-bags.index');
    Route::get('/packages-has-bags/create', [PackagesHasBagController::class, 'create'])->name('packages-has-bags.create');
    // Route::get('packages-has-bags/{bags}', [PackagesHasBagController::class, 'show'])->name('packages-has-bags.show');
    Route::post('/packages-has-bags', [PackagesHasBagController::class, 'store'])->name('packages-has-bags.store');
    Route::get('/packages-has-bags/{packages-has-bags}/edit', [PackagesHasBagController::class, 'edit'])->name('packages-has-bags.edit');
    Route::put('/packages-has-bags/{packages-has-bags}', [PackagesHasBagController::class, 'update'])->name('packages-has-bags.update');
    Route::delete('/packages-has-bags/{packages-has-bags}', [PackagesHasBagController::class, 'destroy'])->name('packages-has-bags.destroy');

    Route::get('/internationals', [InternationalController::class, 'index'])->name('internationals.index');
    Route::get('/internationals/create', [InternationalController::class, 'create'])->name('internationals.create');
    Route::post('/internationals', [InternationalController::class, 'store'])->name('internationals.store');
    // Route::get('/internationals/{id}', [InternationalController::class, 'show'])->name('internationals.show');
    Route::get('/internationals/{id}/edit', [InternationalController::class, 'edit'])->name('internationals.edit');
    Route::put('/internationals/{international}', [InternationalController::class, 'update'])->name('internationals.update');
    Route::delete('/internationals/{id}', [InternationalController::class, 'destroy'])->name('internationals.destroy');
    Route::get('internationals/ventanilladd', [InternationalController::class, 'ventanilladd'])->name('internationals.ventanilladd');
    Route::get('/internationals/deleteadodd', [InternationalController::class, 'deleteadodd'])->name('internationals.deleteadodd');
    Route::post('internationals/{id}/restore', [InternationalController::class, 'restore'])->name('internationals.restore');
    Route::get('internationals/certificadosexcel', [InternationalController::class, 'certificadosexcel'])->name('certificados.excel');
    Route::get('internationals/inventarioDRDexcel', [InternationalController::class, 'inventarioDRDexcel'])->name('inventarioDRD.excel');
    Route::get('internationals/ventanilladnd', [InternationalController::class, 'ventanilladnd'])->name('internationals.ventanilladnd');
    Route::get('/internationals/deleteadodnd', [InternationalController::class, 'deleteadodnd'])->name('internationals.deleteadodnd');
    Route::get('internationals/certificadosdndexcel', [InternationalController::class, 'certificadosdndexcel'])->name('certificadosdnd.excel');
    Route::get('internationals/inventarioDNDexcel', [InternationalController::class, 'inventarioDNDexcel'])->name('inventarioDND.excel');

    Blade::if('role', function ($roles) {
        return auth()->check() && auth()->user()->hasAnyRole(explode('|', $roles));
    });
});

require __DIR__ . '/auth.php';
