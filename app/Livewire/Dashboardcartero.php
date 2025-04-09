<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\International;
use App\Models\Package;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class Dashboardcartero extends Component
{
    public $total;
    public $entregas;
    public $despacho;
    public $entregado;

    public function mount()
    {
        $this->loadStatistics();
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Estadisticas del Sistema Cartero"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }

    protected function loadStatistics()
    {
        // Cache the results for 10 minutes to reduce the load on the database
        $this->total = Cache::remember('total', 600, function () {
            // Contar internacionales con estado VENTANILLA
            $internationalCount = International::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'VENTANILLA')
                ->count();

            // Contar paquetes con estado VENTANILLA
            $packagesCount = Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'VENTANILLA')
                ->count();

            // Retornar la suma de ambos conteos
            return $internationalCount + $packagesCount;
        });

        // Cache the results for 10 minutes to reduce the load on the database
        $this->entregas = Cache::remember('entregas', 600, function () {
            // Contar internacionales con estado CARTERO para el cartero logueado
            $internationalCount = International::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'CARTERO')
                ->where('usercartero', Auth::user()->name) // Filtrar por el usuario logueado
                ->count();

            // Contar paquetes con estado CARTERO para el cartero logueado
            $packagesCount = Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'CARTERO')
                ->where('usercartero', Auth::user()->name) // Filtrar por el usuario logueado
                ->count();

            // Retornar la suma de ambos conteos
            return $internationalCount + $packagesCount;
        });

        // Cache the results for 10 minutes to reduce the load on the database
        $this->despacho = Cache::remember('despacho', 600, function () {
            // Contar internacionales con estado DESPACHO para el cartero logueado
            $internationalCount = International::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'RETORNO')
                ->where('usercartero', Auth::user()->name) // Filtrar por el usuario logueado
                ->count();

            // Contar paquetes con estado DESPACHO para el cartero logueado
            $packagesCount = Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'RETORNO')
                ->where('usercartero', Auth::user()->name) // Filtrar por el usuario logueado
                ->count();

            // Retornar la suma de ambos conteos
            return $internationalCount + $packagesCount;
        });

        // Cache the results for 10 minutes to reduce the load on the database
        $this->entregado = Cache::remember('entregado', 600, function () {
            // Contar internacionales con estado REPARTIDO para el cartero logueado
            $internationalCount = International::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'REPARTIDO')
                ->where('usercartero', Auth::user()->name) // Filtrar por el usuario logueado
                ->count();

            // Contar paquetes con estado REPARTIDO para el cartero logueado
            $packagesCount = Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'REPARTIDO')
                ->where('usercartero', Auth::user()->name) // Filtrar por el usuario logueado
                ->count();

            // Retornar la suma de ambos conteos
            return $internationalCount + $packagesCount;
        });
    }

    public function render()
    {
        return view('livewire.dashboardcartero');
    }
}
