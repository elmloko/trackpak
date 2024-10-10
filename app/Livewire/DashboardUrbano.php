<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\International;
use App\Models\Package;
use Illuminate\Support\Facades\Cache;

class DashboardUrbano extends Component
{
    public $totallpvr;
    public $totallpvren;
    public $hoylpvr;
    public $hoylpvhh;
    public $totallpvdd;
    public $totallpedd;
    public $hoylpedd;
    public $hoylpvdd;
    public $despachoclasi;
    public $despachoclasid;
    public $despachoclasic;
    public $despachoclasica;

    public function mount()
    {
        $this->loadStatistics();
    }

    protected function loadStatistics()
    {
        // Cache the results for 10 minutes to reduce the load on the database
        $this->totallpvr = Cache::remember('totallpvr', 600, function () {
            return International::where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'DD')->count();
        });

        $this->totallpvren = Cache::remember('totallpvren', 600, function () {
            return International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->count();
        });

        $this->hoylpvr = Cache::remember('hoylpvr', 600, function () {
            return International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->count();
        });

        $this->hoylpvhh = Cache::remember('hoylpvhh', 600, function () {
            return International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->sum('PRECIO');
        });

        $this->totallpvdd = Cache::remember('totallpvdd', 600, function () {
            return Package::where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'DD')->count();
        });

        $this->totallpedd = Cache::remember('totallpedd', 600, function () {
            return Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->count();
        });

        $this->hoylpedd = Cache::remember('hoylpedd', 600, function () {
            return Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->count();
        });

        $this->hoylpvdd = Cache::remember('hoylpvdd', 600, function () {
            return Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->sum('PRECIO');
        });

        Cache::forget('despachoclasi');
        $this->despachoclasi = Cache::remember('despachoclasi', 600, function () {
            return Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'DESPACHO')
                ->where('VENTANILLA', 'DD')
                ->count();
        });
        Cache::forget('despachoclasid');
        $this->despachoclasid = Cache::remember('despachoclasid', 600, function () {
            return Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'DESPACHO')
                ->where('VENTANILLA', 'DND')
                ->count();
        });
        Cache::forget('despachoclasic');
        $this->despachoclasic = Cache::remember('despachoclasic', 600, function () {
            return Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'DESPACHO')
                ->where('VENTANILLA', 'CASILLAS')
                ->count();
        });
        Cache::forget('despachoclasica');
        $this->despachoclasica = Cache::remember('despachoclasica', 600, function () {
            // Contar paquetes con estado RETORNO
            $packagesCount = Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'RETORNO')
                ->count();
        
            // Contar internacionales con estado RETORNO
            $internationalCount = International::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'RETORNO')
                ->count();
        
            // Retornar la suma de ambos conteos
            return $packagesCount + $internationalCount;
        });
    }

    public function render()
    {
        if (auth()->user()->hasRole('Urbano') && $this->despachoclasi > 0) {
            toastr()->warning("TIENES PAQUETES EN DESPACHO REVISA TU CN33 PARA RECIBIRLOS!. SON :{$this->despachoclasi} PAQUETES PARA VENTANILLA DD");
        }
        if (auth()->user()->hasRole('Urbano') && $this->despachoclasid > 0) {
            toastr()->warning("TIENES PAQUETES EN DESPACHO REVISA TU CN33 PARA RECIBIRLOS!. SON :{$this->despachoclasid} PAQUETES PARA VENTANILLA DND");
        }
        if (auth()->user()->hasRole('Urbano') && $this->despachoclasic > 0) {
            toastr()->warning("TIENES PAQUETES EN DESPACHO REVISA TU CN33 PARA RECIBIRLOS!. SON :{$this->despachoclasic} PAQUETES PARA VENTANILLA CASILLAS");
        }
        if (auth()->user()->hasRole('Urbano') && $this->despachoclasica > 0) {
            toastr()->warning("PAQUETES PENDIENTES PARA RECIBIR. SON :{$this->despachoclasica} PAQUETES DEVUELTOS POR CARTEROS");
        }
        return view('livewire.dashboard-urbano');
    }
}
