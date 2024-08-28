<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Illuminate\Support\Facades\Cache;

class DashboardEncomienda extends Component
{
    public $totallpveco;
    public $totallpeeco;
    public $hoylpeeco;
    public $hoylpveco;

    public function mount()
    {
        $this->loadStatistics();
    }

    protected function loadStatistics()
    {
        // Cache the results for 10 minutes to reduce the load on the database
        $this->totallpveco = Cache::remember('totallpveco', 600, function () {
            return Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'VENTANILLA')
                ->where('VENTANILLA', 'ENCOMIENDAS')
                ->count();
        });

        $this->totallpeeco = Cache::remember('totallpeeco', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'ENCOMIENDAS')
                ->count();
        });

        $this->hoylpeeco = Cache::remember('hoylpeeco', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'ENCOMIENDAS')
                ->whereDate('deleted_at', today())
                ->count();
        });

        $this->hoylpveco = Cache::remember('hoylpveco', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'ENCOMIENDAS')
                ->whereDate('deleted_at', today())
                ->sum('PRECIO');
        });
    }

    public function render()
    {
        return view('livewire.dashboard-encomienda');
    }
}
