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
        $totalDespacho = $packages->where('ESTADO', 'DESPACHO')->count();
        $totalReecaminado = $packages->where('ESTADO', 'REENCAMINADO')->count();
        $totalPreRezago = $packages->where('ESTADO', 'PRE-REZAGO')->count();
        $totalRezago = $packages->where('ESTADO', 'REZAGO')->count();
        $totalCartero = $packages->where('ESTADO', 'CARTERO')->count();
        $totalCartInve = $packages->where('ESTADO', 'REPARTIDO')->count();
        
        
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

        //Regional Detallado Clasificacion Despacho
        $totallpd = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'DESPACHO')->count();
        $totalcbbad = $packages->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'DESPACHO')->count();
        $totalsczd = $packages->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'DESPACHO')->count();
        $totalbnd = $packages->where('CUIDAD', 'BENI')->where('ESTADO', 'DESPACHO')->count();
        $totalorud = $packages->where('CUIDAD', 'ORURO')->where('ESTADO', 'DESPACHO')->count();
        $totalptd = $packages->where('CUIDAD', 'POTOSI')->where('ESTADO', 'DESPACHO')->count();
        $totaltjd = $packages->where('CUIDAD', 'TARIJA')->where('ESTADO', 'DESPACHO')->count();
        $totalscrd = $packages->where('CUIDAD', 'SUCRE')->where('ESTADO', 'DESPACHO')->count();
        $totalpnd = $packages->where('CUIDAD', 'PANDO')->where('ESTADO', 'DESPACHO')->count();
        
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

        //Reportes por dia Clasificacion
        $hoylpc = Package::where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CLASIFICACION')->whereDate('created_at', today())->count();
        $hoycbbac = Package::where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'CLASIFICACION')->whereDate('created_at', today())->count();
        $hoysczc = Package::where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'CLASIFICACION')->whereDate('created_at', today())->count();
        $hoybnc = Package::where('CUIDAD', 'BENI')->where('ESTADO', 'CLASIFICACION')->whereDate('created_at', today())->count();
        $hoyoruc = Package::where('CUIDAD', 'ORURO')->where('ESTADO', 'CLASIFICACION')->whereDate('created_at', today())->count();
        $hoyptc = Package::where('CUIDAD', 'POTOSI')->where('ESTADO', 'CLASIFICACION')->whereDate('created_at', today())->count();
        $hoytjc = Package::where('CUIDAD', 'TARIJA')->where('ESTADO', 'CLASIFICACION')->whereDate('created_at', today())->count();
        $hoyscrc = Package::where('CUIDAD', 'SUCRE')->where('ESTADO', 'CLASIFICACION')->whereDate('created_at', today())->count();
        $hoypnc = Package::where('CUIDAD', 'PANDO')->where('ESTADO', 'CLASIFICACION')->whereDate('created_at', today())->count();

        //Reportes por dia Clasificacion mes
        $meslpc = Package::where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CLASIFICACION')->whereMonth('created_at', now()->month)->count();
        $mescbbac = Package::where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'CLASIFICACION')->whereMonth('created_at', now()->month)->count();
        $messczc = Package::where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'CLASIFICACION')->whereMonth('created_at', now()->month)->count();
        $mesbnc = Package::where('CUIDAD', 'BENI')->where('ESTADO', 'CLASIFICACION')->whereMonth('created_at', now()->month)->count();
        $mesoruc = Package::where('CUIDAD', 'ORURO')->where('ESTADO', 'CLASIFICACION')->whereMonth('created_at', now()->month)->count();
        $mesptc = Package::where('CUIDAD', 'POTOSI')->where('ESTADO', 'CLASIFICACION')->whereMonth('created_at', now()->month)->count();
        $mestjc = Package::where('CUIDAD', 'TARIJA')->where('ESTADO', 'CLASIFICACION')->whereMonth('created_at', now()->month)->count();
        $messcrc = Package::where('CUIDAD', 'SUCRE')->where('ESTADO', 'CLASIFICACION')->whereMonth('created_at', now()->month)->count();
        $mespnc = Package::where('CUIDAD', 'PANDO')->where('ESTADO', 'CLASIFICACION')->whereMonth('created_at', now()->month)->count();

        //Reportes por dia Ventanilla
        $hoylpe = Package::where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoycbbae = Package::where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoyscze = Package::where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoybne = Package::where('CUIDAD', 'BENI')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoyorue = Package::where('CUIDAD', 'ORURO')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoypte = Package::where('CUIDAD', 'POTOSI')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoytje = Package::where('CUIDAD', 'TARIJA')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoyscre = Package::where('CUIDAD', 'SUCRE')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoypne = Package::where('CUIDAD', 'PANDO')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();

        //Regional Detallado Ventanilla
        $totallppr = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'PRE-REZAGO')->count();
        $totalcbbapr = $packages->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'PRE-REZAGO')->count();
        $totalsczpr = $packages->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'PRE-REZAGO')->count();
        $totalbnpr = $packages->where('CUIDAD', 'BENI')->where('ESTADO', 'PRE-REZAGO')->count();
        $totalorupr = $packages->where('CUIDAD', 'ORURO')->where('ESTADO', 'PRE-REZAGO')->count();
        $totalptpr = $packages->where('CUIDAD', 'POTOSI')->where('ESTADO', 'PRE-REZAGO')->count();
        $totaltjpr = $packages->where('CUIDAD', 'TARIJA')->where('ESTADO', 'PRE-REZAGO')->count();
        $totalscrpr = $packages->where('CUIDAD', 'SUCRE')->where('ESTADO', 'PRE-REZAGO')->count();
        $totalpnpr = $packages->where('CUIDAD', 'PANDO')->where('ESTADO', 'PRE-REZAGO')->count();

        //Regional Detallado Cartero
        $totallpcar = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CARTERO')->count();
        $totalcbbacar = $packages->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'CARTERO')->count();
        $totalsczcar = $packages->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'CARTERO')->count();
        $totalbncar = $packages->where('CUIDAD', 'BENI')->where('ESTADO', 'CARTERO')->count();
        $totalorucar = $packages->where('CUIDAD', 'ORURO')->where('ESTADO', 'CARTERO')->count();
        $totalptcar = $packages->where('CUIDAD', 'POTOSI')->where('ESTADO', 'CARTERO')->count();
        $totaltjcar = $packages->where('CUIDAD', 'TARIJA')->where('ESTADO', 'CARTERO')->count();
        $totalscrpcar = $packages->where('CUIDAD', 'SUCRE')->where('ESTADO', 'CARTERO')->count();
        $totalpnpcar = $packages->where('CUIDAD', 'PANDO')->where('ESTADO', 'CARTERO')->count();

        //Regional Entregado Cartero
        $totallprep = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'REPARTIDO')->count();
        $totalcbbarep = $packages->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'REPARTIDO')->count();
        $totalsczrep = $packages->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'REPARTIDO')->count();
        $totalbnrep = $packages->where('CUIDAD', 'BENI')->where('ESTADO', 'REPARTIDO')->count();
        $totalorurep = $packages->where('CUIDAD', 'ORURO')->where('ESTADO', 'REPARTIDO')->count();
        $totalptrep = $packages->where('CUIDAD', 'POTOSI')->where('ESTADO', 'REPARTIDO')->count();
        $totaltjrep = $packages->where('CUIDAD', 'TARIJA')->where('ESTADO', 'REPARTIDO')->count();
        $totalscrprep = $packages->where('CUIDAD', 'SUCRE')->where('ESTADO', 'REPARTIDO')->count();
        $totalpnprep = $packages->where('CUIDAD', 'PANDO')->where('ESTADO', 'REPARTIDO')->count();

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
                                        'totalDespacho',
                                        'totalCartero',
                                        'totalCartInve',
                                        'totallpcar',
                                        'totalcbbacar',
                                        'totalsczcar',
                                        'totalbncar',
                                        'totalorucar',
                                        'totalptcar',
                                        'totaltjcar',
                                        'totalscrpcar',
                                        'totalpnpcar',
                                        'totallprep',
                                        'totalcbbarep',
                                        'totalsczrep',
                                        'totalbnrep',
                                        'totalorurep',
                                        'totalptrep',
                                        'totaltjrep',
                                        'totalscrprep',
                                        'totalpnprep',
                                        'totalPreRezago',
                                        'totalRezago',
                                        'totallppr',
                                        'totalcbbapr',
                                        'totalsczpr',
                                        'totalbnpr',
                                        'totalorupr',
                                        'totalptpr',
                                        'totaltjpr',
                                        'totalscrpr',
                                        'totalpnpr',
                                        'meslpc',
                                        'mescbbac',
                                        'messczc',
                                        'mesbnc',
                                        'mesoruc',
                                        'mesptc',
                                        'mestjc',
                                        'messcrc',
                                        'mespnc',
                                        'totallpd',
                                        'totalcbbad',
                                        'totalsczd',
                                        'totalbnd',
                                        'totalorud',
                                        'totalptd',
                                        'totaltjd',
                                        'totalscrd',
                                        'totalpnd',
                                        'hoylpe',
                                        'hoycbbae',
                                        'hoyscze',
                                        'hoybne',
                                        'hoyorue',
                                        'hoypte',
                                        'hoytje',
                                        'hoyscre',
                                        'hoypne',
                                        'hoylpc',
                                        'hoycbbac',
                                        'hoysczc',
                                        'hoybnc',
                                        'hoyoruc',
                                        'hoyptc',
                                        'hoytjc',
                                        'hoyscrc',
                                        'hoypnc',
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

