<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class DashboardUnica extends Component
{
    public $statistics = [];
    public $userRegional;

    public function mount()
    {
        $this->userRegional = Auth::user()->Regional; // O ajusta según cómo recuperes la región del usuario
        $this->loadStatistics();
    }

    protected function loadStatistics()
    {
        $cities = ['COCHABAMBA', 'SANTA CRUZ', 'BENI', 'ORURO', 'POTOSI', 'TARIJA', 'SUCRE', 'PANDO'];

        foreach ($cities as $city) {
            $this->statistics[$city]['total_v'] = Cache::remember("{$city}_total_v", 600, function () use ($city) {
                return Package::where('CUIDAD', $city)->where('ESTADO', 'VENTANILLA')->count();
            });

            $this->statistics[$city]['total_e'] = Cache::remember("{$city}_total_e", 600, function () use ($city) {
                return Package::onlyTrashed()->where('CUIDAD', $city)->where('ESTADO', 'ENTREGADO')->count();
            });

            $this->statistics[$city]['today_e'] = Cache::remember("{$city}_today_e", 600, function () use ($city) {
                return Package::onlyTrashed()->where('CUIDAD', $city)->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
            });

            $this->statistics[$city]['today_v'] = Cache::remember("{$city}_today_v", 600, function () use ($city) {
                return Package::onlyTrashed()->where('CUIDAD', $city)->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
            });
        }
    }

    public function render()
    {
        return view('livewire.dashboard-unica', [
            'statistics' => $this->statistics,
            'userRegional' => $this->userRegional
        ]);
    }
}
