<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\International;
use App\Models\Package;
use Illuminate\Support\Facades\Cache;
use App\Models\Event;

class Dashboarddnd extends Component
{
    public $totallpvrr;
    public $totallpvrenn;
    public $hoylpvrr;
    public $hoylpvhhh;
    public $totallpvdnd;
    public $totallpednd;
    public $hoylpednd;
    public $hoylpvdnd;
    public $despachoclasi;

    public function mount()
    {
        $this->loadStatistics();
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Estadisticas del Sistema DND"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }

    protected function loadStatistics()
    {
        // Cache the results for 10 minutes to reduce the load on the database
        $this->totallpvrr = Cache::remember('totallpvrr', 600, function () {
            return International::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'VENTANILLA')
                ->where('VENTANILLA', 'DND')
                ->count();
        });

        $this->totallpvrenn = Cache::remember('totallpvrenn', 600, function () {
            return International::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'DND')
                ->count();
        });

        $this->hoylpvrr = Cache::remember('hoylpvrr', 600, function () {
            return International::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'DND')
                ->whereDate('deleted_at', today())
                ->count();
        });

        $this->hoylpvhhh = Cache::remember('hoylpvhhh', 600, function () {
            return International::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'DND')
                ->whereDate('deleted_at', today())
                ->sum('PRECIO');
        });

        $this->totallpvdnd = Cache::remember('totallpvdnd', 600, function () {
            return Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'VENTANILLA')
                ->where('VENTANILLA', 'DND')
                ->count();
        });

        $this->totallpednd = Cache::remember('totallpednd', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'DND')
                ->count();
        });

        $this->hoylpednd = Cache::remember('hoylpednd', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'DND')
                ->whereDate('deleted_at', today())
                ->count();
        });

        $this->hoylpvdnd = Cache::remember('hoylpvdnd', 600, function () {
            return Package::onlyTrashed()
                ->where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'ENTREGADO')
                ->where('VENTANILLA', 'DND')
                ->whereDate('deleted_at', today())
                ->sum('PRECIO');
        });
        Cache::forget('despachoclasi');
        $this->despachoclasi = Cache::remember('despachoclasi', 600, function () {
            return Package::where('CUIDAD', 'LA PAZ')
                ->where('ESTADO', 'DESPACHO')
                ->where('VENTANILLA', 'DND')
                ->count();
        });
    }

    public function render()
    {
        if (auth()->user()->hasRole('DND') && $this->despachoclasi > 0) {
            toastr()->warning("TIENES PAQUETES EN DESPACHO REVISA TU CN33 PARA RECIBIRLOS!. SON :{$this->despachoclasi} PAQUETES PARA VENTANILLA DND");
        }
        return view('livewire.dashboarddnd');
    }
}
