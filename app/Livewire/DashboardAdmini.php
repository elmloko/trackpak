<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\National;
use App\Models\User;

use App\Models\International;
use Illuminate\Support\Facades\Cache;

class DashboardAdmini extends Component
{
    public $totalPaquetes;
    public $totalRegistradosHoy;
    public $totalEntregadosHoy;
    public $totalUsuarios;
    public $totalEntregados;

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

        $this->totalEntregadosHoy = Cache::remember('totalEntregadosHoy', 600, function () {
            $packageEntregados = Package::onlyTrashed()
                ->whereDate('deleted_at', today())
                ->count();

            $internationalEntregados = International::onlyTrashed()
                ->whereDate('deleted_at', today())
                ->count();

            return $packageEntregados + $internationalEntregados;
        });
        $this->totalUsuarios = Cache::remember('totalUsuarios', 600, function () {
            return User::count();
        });
        $this->totalEntregados = Cache::remember('totalEntregados', 600, function () {
            $packageCount = Package::where('ESTADO', 'VENTANILLA')->count();
            $internationalCount = International::where('ESTADO', 'VENTANILLA')->count();
            return $packageCount + $internationalCount;
        });
    }

    public function render()
    {
        return view('livewire.dashboard-admini');
    }
}
