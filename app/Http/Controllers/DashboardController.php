<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Package;
use App\Models\International;
use App\Models\User;
use App\Models\Mensaje;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        $mensaje = Mensaje::all();
        $international = International::all();
        $totalPaquetes = $packages->count();
        $totalUsuarios = User::count();
        $userRegional = auth()->user()->Regional;

        // Aplica el filtro de fecha antes de obtenermes la colección
        $totalRegistradosHoy = Package::whereDate('created_at', today())->count();
        $totalEntregadosHoy = Package::onlyTrashed()->whereDate('deleted_at', today())->count();
        $totalReencaminadoHoy = Package::whereDate('date_redirigido', today())->count();
        //Reportes por dia Clasificacion
        $hoylpc = Package::where('ESTADO', 'DESPACHO')->whereDate('created_at', today())->count();

        //Reportes por mes Clasificacion mes
        $meslpc = Package::withTrashed()->whereMonth('created_at', now()->month)->count();

        //Aplicando Filtros
        $totalbaja = Package::onlyTrashed()->where('ESTADO', 'entregado')->count();
        $totalEntregados = $packages->where('ESTADO', 'VENTANILLA')->count();
        $totalVentanilla = $packages->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'DD')->count();
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

        //Regional Detallado Ventanilla
        $totallpvdd = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'DD')->count();
        $totallpvdnd = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'DND')->count();
        $totallpvcs = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'CASILLAS')->count();
        $totallpveca = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'ECA')->count();
        $totallpveco = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'ENCOMIENDAS')->count();
        $totalcbbav = $packages->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'VENTANILLA')->count();
        $totalsczv = $packages->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'VENTANILLA')->count();
        $totalbnv = $packages->where('CUIDAD', 'BENI')->where('ESTADO', 'VENTANILLA')->count();
        $totaloruv = $packages->where('CUIDAD', 'ORURO')->where('ESTADO', 'VENTANILLA')->count();
        $totalptv = $packages->where('CUIDAD', 'POTOSI')->where('ESTADO', 'VENTANILLA')->count();
        $totaltjv = $packages->where('CUIDAD', 'TARIJA')->where('ESTADO', 'VENTANILLA')->count();
        $totalscrv = $packages->where('CUIDAD', 'SUCRE')->where('ESTADO', 'VENTANILLA')->count();
        $totalpnv = $packages->where('CUIDAD', 'PANDO')->where('ESTADO', 'VENTANILLA')->count();

        //Regional Detallado Entregado
        $totallpedd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->count();
        $totallpeeco = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ENCOMIENDAS')->count();
        $totallpednd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DND')->count();
        $totallpecs = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CASILLA')->where('VENTANILLA', 'CASILLAS')->count();
        $totallpeeca = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ECA')->count();
        $totalcbbae = Package::onlyTrashed()->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'ENTREGADO')->count();
        $totalscze = Package::onlyTrashed()->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'ENTREGADO')->count();
        $totalbne = Package::onlyTrashed()->where('CUIDAD', 'BENI')->where('ESTADO', 'ENTREGADO')->count();
        $totalorue = Package::onlyTrashed()->where('CUIDAD', 'ORURO')->where('ESTADO', 'ENTREGADO')->count();
        $totalpte = Package::onlyTrashed()->where('CUIDAD', 'POTOSI')->where('ESTADO', 'ENTREGADO')->count();
        $totaltje = Package::onlyTrashed()->where('CUIDAD', 'TARIJA')->where('ESTADO', 'ENTREGADO')->count();
        $totalscre = Package::onlyTrashed()->where('CUIDAD', 'SUCRE')->where('ESTADO', 'ENTREGADO')->count();
        $totalpne = Package::onlyTrashed()->where('CUIDAD', 'PANDO')->where('ESTADO', 'ENTREGADO')->count();

        //Reportes por dia Ventanilla
        $hoylpedd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->count();
        $hoylpeeco = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ENCOMIENDAS')->whereDate('deleted_at', today())->count();
        $hoylpednd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DND')->whereDate('deleted_at', today())->count();
        $hoylpecs = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CASILLA')->where('VENTANILLA', 'CASILLAS')->whereDate('deleted_at', today())->count();
        $hoylpeeca = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ECA')->whereDate('deleted_at', today())->count();
        $hoycbbae = Package::onlyTrashed()->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoyscze = Package::onlyTrashed()->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoybne = Package::onlyTrashed()->where('CUIDAD', 'BENI')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoyorue = Package::onlyTrashed()->where('CUIDAD', 'ORURO')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoypte = Package::onlyTrashed()->where('CUIDAD', 'POTOSI')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoytje = Package::onlyTrashed()->where('CUIDAD', 'TARIJA')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoyscre = Package::onlyTrashed()->where('CUIDAD', 'SUCRE')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $hoypne = Package::onlyTrashed()->where('CUIDAD', 'PANDO')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();

        //Reportes por dia Ventanilla Generado PRECIO
        $hoylpvdd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoylpvdnd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DND')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoylpveco = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ENCOMIENDAS')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoylpvcs = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CASILLA')->where('VENTANILLA', 'CASILLAS')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoylpveca = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ECA')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoycbbav = Package::onlyTrashed()->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoysczv = Package::onlyTrashed()->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoybnv = Package::onlyTrashed()->where('CUIDAD', 'BENI')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoyoruv = Package::onlyTrashed()->where('CUIDAD', 'ORURO')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoyptv = Package::onlyTrashed()->where('CUIDAD', 'POTOSI')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoytjv = Package::onlyTrashed()->where('CUIDAD', 'TARIJA')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoyscrv = Package::onlyTrashed()->where('CUIDAD', 'SUCRE')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $hoypnv = Package::onlyTrashed()->where('CUIDAD', 'PANDO')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');

        //Regional Detallado Cartero
        $totallpcar = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CARTERO')->count();
        $totallpret = $packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'RETORNO')->count();
        $totallprep = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'REPARTIDO')->count();
        $hoylpent = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'REPARTIDO')->whereDate('deleted_at', today())->count();

        $totalmensajeenv = $mensaje->where('estado', 'Enviado')->count()
        + $mensaje->where('estado', 'Recibido')->count()
        + $mensaje->where('estado', 'Leído')->count();
    
        $totalmensajelei = $mensaje->where('estado', 'Leído')->count();
        $totalmensajenenv = $mensaje->where('estado', 'No enviado')->count();
        $totalmensaje = $mensaje->count();
        $totalmensajeHoy = Mensaje::whereDate('fecha_creacion', Carbon::today())->count();
        

        $totallpvr = $international->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'DD')->count();
        $totallpvren = International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->count();
        $hoylpvr = International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->count();
        $hoylpvhh = International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->sum('PRECIO');
        
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


        return view('dashboard', compact(
            'data',
            'international',
            'totallpvren',  
            'totallpvr',
            'hoylpvr',
            'hoylpvhh',
            'totalbaja',
            'hoylpeeco',
            'totallpveco',
            'totallpeeco',
            'hoylpveco',
            'totalmensaje',
            'totalmensajeenv',
            'totalmensajeHoy',
            'totalmensajenenv',
            'totalmensajelei',
            'totalDespacho',
            'totalCartero',
            'totalCartInve',
            'hoylpvdd',
            'hoylpvdnd',
            'hoylpvcs',
            'hoylpveca',
            'hoycbbav',
            'hoysczv',
            'hoybnv',
            'hoyoruv',
            'hoyptv',
            'hoytjv',
            'hoyscrv',
            'hoypnv',
            'totallpcar',
            'totallpret',
            'totallprep',
            'hoylpent',
            'totalPreRezago',
            'totalRezago',
            'meslpc',
            'hoylpedd',
            'hoylpednd',
            'hoylpecs',
            'hoylpeeca',
            'hoycbbae',
            'hoyscze',
            'hoybne',
            'hoyorue',
            'hoypte',
            'hoytje',
            'hoyscre',
            'hoypne',
            'hoylpc',
            'userRegional',
            'totallpedd',
            'totallpednd',
            'totallpecs',
            'totallpeeca',
            'totalcbbae',
            'totalscze',
            'totalbne',
            'totalorue',
            'totalpte',
            'totaltje',
            'totalscre',
            'totalpne',
            'totallpvdd',
            'totallpvdnd',
            'totallpveca',
            'totallpvcs',
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
            'totalClasificacion'
        ));
    }
}
