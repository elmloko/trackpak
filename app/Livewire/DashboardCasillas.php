<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Illuminate\Support\Facades\Cache;

class DashboardCasillas extends Component
{
    public $totallpvcs;
    public $totallpecs;
    public $hoylpecs;
    public $hoylpvcs;
    public $despachoclasica;

    public function mount()
    {
        $this->loadStatistics();
    }

    protected function loadStatistics()
    {
        // Cache the results for 10 minutes to reduce the load on the database
        $this->totallpvcs = Cache::remember('totallpvcs', 600, function () {
            return Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'VENTANILLA')
                ->where('VENTANILLA', 'CASILLAS')
                ->count();
        });

        $this->totallpecs = Cache::remember('totallpecs', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'CASILLA')
                ->where('VENTANILLA', 'CASILLAS')
                ->count();
        });

        $this->hoylpecs = Cache::remember('hoylpecs', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'CASILLA')
                ->where('VENTANILLA', 'CASILLAS')
                ->whereDate('deleted_at', today())
                ->count();
        });

        $this->hoylpvcs = Cache::remember('hoylpvcs', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'CASILLA')
                ->where('VENTANILLA', 'CASILLAS')
                ->whereDate('deleted_at', today())
                ->sum('PRECIO');
        });
        Cache::forget('despachoclasica');
        $this->despachoclasica = Cache::remember('despachoclasica', 600, function () {
            return Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'DESPACHO')
                ->where('VENTANILLA', 'CASILLAS')
                ->count();
        });
    }

    public function render()
    {
        if (auth()->user()->hasRole('Casillas') && $this->despachoclasica > 0) {
            toastr()->warning("TIENES PAQUETES EN DESPACHO REVISA TU CN33 PARA RECIBIRLOS!. SON :{$this->despachoclasica} PAQUETES PARA VENTANILLA CASILLAS");
        }

        return view('livewire.dashboard-casillas');
    }
}
