<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Illuminate\Support\Facades\Cache;

class DashboardClasificacion extends Component
{
    public $hoylpc;
    public $totalClasificacion;
    public $totalDespacho;
    public $meslpc;

    public function mount()
    {
        $this->loadStatistics();
    }

    protected function loadStatistics()
    {
        // Cache the results for 10 minutes to reduce the load on the database
        $this->hoylpc = Cache::remember('hoylpc', 600, function () {
            return Package::where('ESTADO', 'DESPACHO')
                ->whereDate('created_at', today())
                ->count();
        });

        $this->totalClasificacion = Cache::remember('totalClasificacion', 600, function () {
            return Package::where('ESTADO', 'CLASIFICACION')
                ->count();
        });

        $this->totalDespacho = Cache::remember('totalDespacho', 600, function () {
            return Package::where('ESTADO', 'DESPACHO')
                ->count();
        });

        $this->meslpc = Cache::remember('meslpc', 600, function () {
            return Package::withTrashed()
                ->whereMonth('created_at', now()->month)
                ->count();
        });
    }

    public function render()
    {
        return view('livewire.dashboard-clasificacion');
    }
}
