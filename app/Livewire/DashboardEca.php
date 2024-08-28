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
    }

    public function render()
    {
        return view('livewire.dashboard-eca');
    }
}
