<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Illuminate\Support\Facades\Cache;

class DashboardEca extends Component
{
    public $totallpveca;
    public $totallpeeca;
    public $hoylpeeca;
    public $hoylpveca;
    public $despachoclasi;

    public function mount()
    {
        $this->loadStatistics();
    }

    protected function loadStatistics()
    {
        // Cache the results for 10 minutes to reduce the load on the database
        $this->totallpveca = Cache::remember('totallpveca', 600, function () {
            return Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'VENTANILLA')
                ->where('VENTANILLA', 'ECA')
                ->count();
        });

        $this->totallpeeca = Cache::remember('totallpeeca', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'ECA')
                ->count();
        });

        $this->hoylpeeca = Cache::remember('hoylpeeca', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'ECA')
                ->whereDate('deleted_at', today())
                ->count();
        });

        $this->hoylpveca = Cache::remember('hoylpveca', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'ECA')
                ->whereDate('deleted_at', today())
                ->sum('PRECIO');
        });
        Cache::forget('despachoclasi');
        $this->despachoclasi = Cache::remember('despachoclasi', 600, function () {
            return Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'DESPACHO')
                ->where('VENTANILLA', 'ECA')
                ->count();
        });
    }

    public function render()
    {
        if (auth()->user()->hasRole('ECA') && $this->despachoclasi > 0) {
            toastr()->warning("TIENES PAQUETES EN DESPACHO REVISA TU CN33 PARA RECIBIRLOS!. SON :{$this->despachoclasi} PAQUETES");
        }
        return view('livewire.dashboard-eca');
    }
}
