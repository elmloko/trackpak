<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class DashboardUnica extends Component
{
    public $statistics = [];
    public $userRegional;
    public $despachoclasica;

    public function mount()
    {
        $this->userRegional = Auth::user()->Regional; // O ajusta según cómo recuperes la región del usuario
        $this->loadStatistics();
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Estadisticas del Sistema Regional"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
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
            // Eliminar el caché anterior y volver a calcular el valor
            Cache::forget('despachoclasica');
            $this->despachoclasica = Cache::remember('despachoclasica', 600, function () {
                return Package::where('CUIDAD', $this->userRegional)
                    ->where('ESTADO', 'DESPACHO')
                    ->where('VENTANILLA', 'UNICA')
                    ->count();
            });
        }
    }

    public function render()
    {
        // Mostrar notificación solo si el usuario tiene el rol 'Casillas' y hay paquetes en despacho
        if (auth()->user()->hasRole('Unica') && $this->despachoclasica > 0) {
            toastr()->warning("TIENES PAQUETES EN DESPACHO REVISA TU CN33 PARA RECIBIRLOS!. SON :{$this->despachoclasica} PAQUETES PARA VENTANILLA $this->userRegional ");
        }

        return view('livewire.dashboard-unica', [
            'statistics' => $this->statistics,
            'userRegional' => $this->userRegional,
        ]);
    }
}
