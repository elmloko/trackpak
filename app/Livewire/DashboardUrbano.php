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
    }

    public function render()
    {
        return view('livewire.dashboard-urbano');
    }
}
