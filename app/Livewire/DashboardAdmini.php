<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\National;
use App\Models\User;
use App\Models\Mensaje;
use Carbon\Carbon;

use App\Models\International;
use Illuminate\Support\Facades\Cache;

class DashboardAdmini extends Component
{
    public $totalPaquetes;
    public $totalRegistradosHoy;
    public $totalEntregadosHoy;
    public $totalUsuarios;
    public $totalEntregados;
    public $totalmensajeenv;
    public $totalmensajeHoy;
    public $totalmensajenenv;
    public $totalmensaje;

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
        $this->totalmensajeenv = Cache::remember('totalmensajeenv', 600, function () {
            $mensajeEnviado = Mensaje::where('estado', 'Enviado')->count();
            $mensajeRecibido = Mensaje::where('estado', 'Recibido')->count();
            $mensajeLeido = Mensaje::where('estado', 'Leído')->count();
            return $mensajeEnviado + $mensajeRecibido + $mensajeLeido;
        });

        $this->totalmensajeHoy = Cache::remember('totalmensajeHoy', 600, function () {
            return Mensaje::whereDate('fecha_creacion', Carbon::today())->count();
        });
        $this->totalmensaje = Cache::remember('totalmensaje', 600, function () {
            return Mensaje::count();
        });
        $this->totalmensajenenv = Cache::remember('totalmensajenenv', 600, function () {
            return Mensaje::where('estado', 'No enviado')->count();
        });
    }

    public function render()
    {
        return view('livewire.dashboard-admini');
    }
}