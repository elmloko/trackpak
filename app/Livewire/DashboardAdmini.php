<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\National;
use App\Models\International;
use Illuminate\Support\Facades\Cache;

class DashboardAdmini extends Component
{
    public $totalPaquetes;
    public $totalRegistradosHoy;
    public $totalEntregadosHoy;

    public function mount()
    {
        $this->loadStatistics();
    }

    protected function loadStatistics()
    {
        // Cache the results for 10 minutes to reduce the load on the database
        $this->totalPaquetes = Cache::remember('totalPaquetes', 600, function () {
            $packageCount = Package::count();
            $nationalCount = National::count();
            $internationalCount = International::count();
            return $packageCount + $nationalCount + $internationalCount;
        });

        $this->totalRegistradosHoy = Cache::remember('totalRegistradosHoy', 600, function () {
            return Package::whereDate('created_at', today())->count();
        });

        $this->totalEntregadosHoy = Cache::remember('totalEntregadosHoy', 600, function () {
            return Package::onlyTrashed()
                ->whereDate('deleted_at', today())
                ->count();
        });
    }
    
    public function render()
    {
        return view('livewire.dashboard-admini');
    }
}
