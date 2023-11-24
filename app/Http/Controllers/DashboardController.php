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
        $userRegional = auth()->user()->Regional;

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

        //Regional Detallado Entregado
        $totallpe = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->count();
        $totalcbbae = $packages->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'ENTREGADO')->count();
        $totalscze = $packages->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'ENTREGADO')->count();
        $totalbne = $packages->where('CUIDAD', 'BENI')->where('ESTADO', 'ENTREGADO')->count();
        $totalorue = $packages->where('CUIDAD', 'ORURO')->where('ESTADO', 'ENTREGADO')->count();
        $totalpte = $packages->where('CUIDAD', 'POTOSI')->where('ESTADO', 'ENTREGADO')->count();
        $totaltje = $packages->where('CUIDAD', 'TARIJA')->where('ESTADO', 'ENTREGADO')->count();
        $totalscre = $packages->where('CUIDAD', 'SUCRE')->where('ESTADO', 'ENTREGADO')->count();
        $totalpne = $packages->where('CUIDAD', 'PANDO')->where('ESTADO', 'ENTREGADO')->count();

        //Regional Detallado Clasificacion
        $totallpc = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CLASIFICACION')->count();
        $totalcbbac = $packages->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'CLASIFICACION')->count();
        $totalsczc = $packages->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'CLASIFICACION')->count();
        $totalbnc = $packages->where('CUIDAD', 'BENI')->where('ESTADO', 'CLASIFICACION')->count();
        $totaloruc = $packages->where('CUIDAD', 'ORURO')->where('ESTADO', 'CLASIFICACION')->count();
        $totalptc = $packages->where('CUIDAD', 'POTOSI')->where('ESTADO', 'CLASIFICACION')->count();
        $totaltjc = $packages->where('CUIDAD', 'TARIJA')->where('ESTADO', 'CLASIFICACION')->count();
        $totalscrc = $packages->where('CUIDAD', 'SUCRE')->where('ESTADO', 'CLASIFICACION')->count();
        $totalpnc = $packages->where('CUIDAD', 'PANDO')->where('ESTADO', 'CLASIFICACION')->count();
        
        //Regional Detallado Reencaminado
        $totallpr = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'REENCAMINADO')->count();
        $totalcbbar = $packages->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'REENCAMINADO')->count();
        $totalsczr = $packages->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'REENCAMINADO')->count();
        $totalbnr = $packages->where('CUIDAD', 'BENI')->where('ESTADO', 'REENCAMINADO')->count();
        $totalorur = $packages->where('CUIDAD', 'ORURO')->where('ESTADO', 'REENCAMINADO')->count();
        $totalptr = $packages->where('CUIDAD', 'POTOSI')->where('ESTADO', 'REENCAMINADO')->count();
        $totaltjr = $packages->where('CUIDAD', 'TARIJA')->where('ESTADO', 'REENCAMINADO')->count();
        $totalscrr = $packages->where('CUIDAD', 'SUCRE')->where('ESTADO', 'REENCAMINADO')->count();
        $totalpnr = $packages->where('CUIDAD', 'PANDO')->where('ESTADO', 'REENCAMINADO')->count();

        //Regional Detallado Ventanilla
        $totallpv = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->count();
        $totalcbbav = $packages->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'VENTANILLA')->count();
        $totalsczv = $packages->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'VENTANILLA')->count();
        $totalbnv = $packages->where('CUIDAD', 'BENI')->where('ESTADO', 'VENTANILLA')->count();
        $totaloruv = $packages->where('CUIDAD', 'ORURO')->where('ESTADO', 'VENTANILLA')->count();
        $totalptv = $packages->where('CUIDAD', 'POTOSI')->where('ESTADO', 'VENTANILLA')->count();
        $totaltjv = $packages->where('CUIDAD', 'TARIJA')->where('ESTADO', 'VENTANILLA')->count();
        $totalscrv = $packages->where('CUIDAD', 'SUCRE')->where('ESTADO', 'VENTANILLA')->count();
        $totalpnv = $packages->where('CUIDAD', 'PANDO')->where('ESTADO', 'VENTANILLA')->count();


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
        

        return view('dashboard', compact('data',
                                        'userRegional',
                                        'totallpe',
                                        'totalcbbae',
                                        'totalscze',
                                        'totalbne',
                                        'totalorue',
                                        'totalpte',
                                        'totaltje',
                                        'totalscre',
                                        'totalpne',
                                        'totallpc',
                                        'totalcbbac',
                                        'totalsczc',
                                        'totalbnc',
                                        'totaloruc',
                                        'totalptc',
                                        'totaltjc',
                                        'totalscrc',
                                        'totalpnc',
                                        'totallpr',
                                        'totalcbbar',
                                        'totalsczr',
                                        'totalbnr',
                                        'totalorur',
                                        'totalptr',
                                        'totaltjr',
                                        'totalscrr',
                                        'totalpnr',
                                        'totallpv',
                                        'totalcbbav',
                                        'totalsczv',
                                        'totalbnv',
                                        'totaloruv',
                                        'totalptv',
                                        'totaltjv',
                                        'totalscrv',
                                        'totalpnv',
                                        'totalReecaminado',
                                        'dataArea',
                                        'dataByMonthArea',
                                        'dataByMonth',
                                        'totalpn',
                                        'totalscr',
                                        'totaltj',
                                        'totalpt',
                                        'totaloru',
                                        'totalbn',
                                        'totalscz',
                                        'totalcbba',
                                        'totallp',
                                        'packages', 
                                        'totalPaquetes',
                                        'totalUsuarios',
                                        'totalRegistradosHoy',
                                        'totalEntregadosHoy',
                                        'totalReencaminadoHoy',
                                        'totalEntregados', 
                                        'totalVentanilla', 
                                        'totalClasificacion'));
    }
}

