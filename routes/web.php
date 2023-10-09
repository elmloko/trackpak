<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PcertificateController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('packages', App\Http\Controllers\PackageController::class);
    Route::get('packages/{id}/delete', [PackageController::class, 'delete'])->name('packages.delete');
    Route::get('packages/deleted', [PackageController::class, 'deleted'])->name('packages.deleted');
    Route::get('packages/{id}/restore', [PackageController::class, 'restore'])->name('packages.restore');

    Route::get('prueba/excel', [PackageController::class, 'excel'])->name('prueba.excel');
    Route::get('prueba/pdf', [PackageController::class, 'pdf'])->name('prueba.pdf');

    Route::resource('pcertificates', App\Http\Controllers\PcertificateController::class);    
    Route::get('pcertificates/{id}/delete', [PcertificateController::class, 'delete'])->name('pcertificates.delete');
    Route::get('pcertificates/{id}/restore', [PcertificateController::class, 'restore'])->name('pcertificates.restore');
    Route::get('prueba1/excel', [PcertificateController::class, 'excel'])->name('prueba1.excel');
    Route::get('prueba1/pdf', [PcertificateController::class, 'pdf'])->name('prueba1.pdf');

    
});

require __DIR__.'/auth.php';
