<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        $totalPaquetes = $packages->count();
        $totalUsuarios = User::count();

        // Aplica el filtro de fecha antes de obtener la colección
        $totalRegistradosHoy = Package::whereDate('created_at', today())->count();
        $totalEntregadosHoy = Package::whereDate('deleted_at', today())->count();
        $totalReencaminadoHoy = Package::whereDate('date_redirigido', today())->count();

        //Aplicando Filtros 
        $totalEntregados = $packages->where('ESTADO', 'ENTREGADO')->count();
        $totalVentanilla = $packages->where('ESTADO', 'VENTANILLA')->count();
        $totalClasificacion = $packages->where('ESTADO', 'CLASIFICACION')->count();
        $totalReecaminado = $packages->where('ESTADO', 'REENCAMINADO')->count();
        
        //Regionales 
        $totallp = $packages->where('CUIDAD', 'LA PAZ')->count();
        $totalcbba = $packages->where('CUIDAD', 'COCHABAMBA')->count();
        $totalscz = $packages->where('CUIDAD', 'SANTA CRUZ')->count();
        $totalbn = $packages->where('CUIDAD', 'BENI')->count();
        $totaloru = $packages->where('CUIDAD', 'ORURO')->count();
        $totalpt = $packages->where('CUIDAD', 'POTOSI')->count();
        $totaltj = $packages->where('CUIDAD', 'TARIJA')->count();
        $totalscr = $packages->where('CUIDAD', 'SUCRE')->count();
        $totalpn = $packages->where('CUIDAD', 'PANDO')->count();

        //Datos por mes 
        $dataByMonth = Package::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('COUNT(*) as total'))
        ->groupBy('month')
        ->get();

        // Formatear las fechas a nombres de meses
        $formattedMonths = $dataByMonth->pluck('month')->map(function ($date) {
            return \Illuminate\Support\Carbon::parse($date)->format('F Y'); // 'F' representa el nombre completo del mes
        });

        // Organizar los datos por tipo (clasificación y ventanilla)
        $data = [
            'Clasificacion' => [],
            'Ventanilla' => [],
        ];

        foreach ($dataByMonth as $entry) {
            $dataByType = Package::select('ESTADO')
                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $entry->month)
                ->get();

            $data['Clasificacion'][] = $dataByType->where('ESTADO', 'CLASIFICACION')->count();
            $data['Ventanilla'][] = $dataByType->where('ESTADO', 'VENTANILLA')->count();
        }
        $dataByMonthArea = Package::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('COUNT(*) as total'))
            ->where('ESTADO', 'ENTREGADO') // Filtrar por ESTADO=ENTREGADO
            ->orWhere('ESTADO', 'CLASIFICACION') // Filtrar por ESTADO=CLASIFICACION
            ->groupBy('month')
            ->get();

        $dataArea = [
            'Entregado' => [],
            'Clasificacion' => [],
        ];

        foreach ($dataByMonthArea as $entry) {
            $dataByTypeArea = Package::select('ESTADO')
                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $entry->month)
                ->whereIn('ESTADO', ['ENTREGADO', 'CLASIFICACION'])
                ->get();

            $dataArea['Entregado'][] = $dataByTypeArea->where('ESTADO', 'ENTREGADO')->count();
            $dataArea['Clasificacion'][] = $dataByTypeArea->where('ESTADO', 'CLASIFICACION')->count();
        }
        

        return view('dashboard', compact('totalReecaminado','dataArea','dataByMonthArea','dataByMonth','data','totalpn','totalscr','totaltj','totalpt','totaloru','totalbn','totalscz','totalcbba','totallp','packages', 'totalPaquetes', 'totalUsuarios', 'totalRegistradosHoy', 'totalEntregadosHoy', 'totalReencaminadoHoy', 'totalEntregados', 'totalVentanilla', 'totalClasificacion'));
    }
}

