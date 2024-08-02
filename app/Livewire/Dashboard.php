<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Package;
use App\Models\International;
use App\Models\National;
use App\Models\User;
use App\Models\Mensaje;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $data = [];
    public $dataArea = [];
    public $dataByMonth = [];
    public $dataByMonthArea = [];
    public $totallpvrr, $totallpvrenn, $hoylpvrr, $hoylpvhhh, $totallpvren;
    public $totallpvr, $hoylpvr, $hoylpvhh;
    public $totalbaja, $hoylpeeco, $totallpveco, $totallpeeco, $hoylpveco;
    public $totalmensaje, $totalmensajeenv, $totalmensajeHoy, $totalmensajenenv, $totalmensajelei;
    public $totalDespacho, $totalCartero, $totalCartInve, $hoylpvdd, $hoylpvdnd, $hoylpvcs, $hoylpveca;
    public $hoycbbav, $hoysczv, $hoybnv, $hoyoruv, $hoyptv, $hoytjv, $hoyscrv, $hoypnv;
    public $totallpcar, $totallpret, $totallprep, $hoylpent;
    public $totalPreRezago, $totalRezago, $meslpc, $hoylpedd, $hoylpednd, $hoylpecs, $hoylpeeca;
    public $hoycbbae, $hoyscze, $hoybne, $hoyorue, $hoypte, $hoytje, $hoyscre, $hoypne, $hoylpc;
    public $userRegional, $totallpedd, $totallpednd, $totallpecs, $totallpeeca;
    public $totalcbbae, $totalscze, $totalbne, $totalorue, $totalpte, $totaltje, $totalscre, $totalpne;
    public $totallpvdd, $totallpvdnd, $totallpveca, $totallpvcs, $totalcbbav, $totalsczv, $totalbnv, $totaloruv;
    public $totalptv, $totaltjv, $totalscrv, $totalpnv, $totalReecaminado;
    public $totalpn, $totalscr, $totaltj, $totalpt, $totaloru, $totalbn, $totalscz, $totalcbba, $totallp;
    public $packages, $totalPaquetes, $totalUsuarios, $totalRegistradosHoy, $totalEntregadosHoy, $totalReencaminadoHoy;
    public $totalEntregados, $totalVentanilla, $totalClasificacion;

    public function mount()
    {
        $this->fetchData();
    }

    public function fetchData()
    {
        $this->packages = Package::all();
        $mensaje = Mensaje::all();
        $national = National::all();
        $international = International::all();
        $this->totalPaquetes = $this->packages->count() + $national->count() + $international->count();
        $this->totalUsuarios = User::count();
        $this->userRegional = auth()->user()->Regional;

        // Aplica el filtro de fecha antes de obtenermes la colección
        $this->totalRegistradosHoy = Package::whereDate('created_at', today())->count();
        $this->totalEntregadosHoy = Package::onlyTrashed()->whereDate('deleted_at', today())->count() 
            + International::onlyTrashed()->whereDate('deleted_at', today())->count();
        $this->totalReencaminadoHoy = Package::whereDate('date_redirigido', today())->count();
        // Reportes por dia Clasificacion
        $this->hoylpc = Package::where('ESTADO', 'DESPACHO')->whereDate('created_at', today())->count();

        // Reportes por mes Clasificacion mes
        $this->meslpc = Package::withTrashed()->whereMonth('created_at', now()->month)->count();

        // Aplicando Filtros
        $this->totalbaja = Package::onlyTrashed()->where('ESTADO', 'entregado')->count();
        $this->totalEntregados = $this->packages->where('ESTADO', 'VENTANILLA')->count() + $international->where('ESTADO', 'VENTANILLA')->count();
        $this->totalVentanilla = $this->packages->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'DD')->count();
        $this->totalClasificacion = $this->packages->where('ESTADO', 'CLASIFICACION')->count();
        $this->totalDespacho = $this->packages->where('ESTADO', 'DESPACHO')->count();
        $this->totalReecaminado = $this->packages->where('ESTADO', 'REENCAMINADO')->count();
        $this->totalPreRezago = $this->packages->where('ESTADO', 'PRE-REZAGO')->count();
        $this->totalRezago = $this->packages->where('ESTADO', 'REZAGO')->count();
        $this->totalCartero = $this->packages->where('ESTADO', 'CARTERO')->count();
        $this->totalCartInve = $this->packages->where('ESTADO', 'REPARTIDO')->count();

        // Regionales 
        $this->totallp = $this->packages->where('CUIDAD', 'LA PAZ')->count();
        $this->totalcbba = $this->packages->where('CUIDAD', 'COCHABAMBA')->count();
        $this->totalscz = $this->packages->where('CUIDAD', 'SANTA CRUZ')->count();
        $this->totalbn = $this->packages->where('CUIDAD', 'BENI')->count();
        $this->totaloru = $this->packages->where('CUIDAD', 'ORURO')->count();
        $this->totalpt = $this->packages->where('CUIDAD', 'POTOSI')->count();
        $this->totaltj = $this->packages->where('CUIDAD', 'TARIJA')->count();
        $this->totalscr = $this->packages->where('CUIDAD', 'SUCRE')->count();
        $this->totalpn = $this->packages->where('CUIDAD', 'PANDO')->count();

        // Regional Detallado Ventanilla
        $this->totallpvdd = $this->packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'DD')->count();
        $this->totallpvdnd = $this->packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'DND')->count();
        $this->totallpvcs = $this->packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'CASILLAS')->count();
        $this->totallpveca = $this->packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'ECA')->count();
        $this->totallpveco = $this->packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'ENCOMIENDAS')->count();
        $this->totalcbbav = $this->packages->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'VENTANILLA')->count();
        $this->totalsczv = $this->packages->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'VENTANILLA')->count();
        $this->totalbnv = $this->packages->where('CUIDAD', 'BENI')->where('ESTADO', 'VENTANILLA')->count();
        $this->totaloruv = $this->packages->where('CUIDAD', 'ORURO')->where('ESTADO', 'VENTANILLA')->count();
        $this->totalptv = $this->packages->where('CUIDAD', 'POTOSI')->where('ESTADO', 'VENTANILLA')->count();
        $this->totaltjv = $this->packages->where('CUIDAD', 'TARIJA')->where('ESTADO', 'VENTANILLA')->count();
        $this->totalscrv = $this->packages->where('CUIDAD', 'SUCRE')->where('ESTADO', 'VENTANILLA')->count();
        $this->totalpnv = $this->packages->where('CUIDAD', 'PANDO')->where('ESTADO', 'VENTANILLA')->count();

        // Regional Detallado Entregado
        $this->totallpedd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->count();
        $this->totallpeeco = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ENCOMIENDAS')->count();
        $this->totallpednd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DND')->count();
        $this->totallpecs = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CASILLA')->where('VENTANILLA', 'CASILLAS')->count();
        $this->totallpeeca = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ECA')->count();
        $this->totalcbbae = Package::onlyTrashed()->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'ENTREGADO')->count();
        $this->totalscze = Package::onlyTrashed()->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'ENTREGADO')->count();
        $this->totalbne = Package::onlyTrashed()->where('CUIDAD', 'BENI')->where('ESTADO', 'ENTREGADO')->count();
        $this->totalorue = Package::onlyTrashed()->where('CUIDAD', 'ORURO')->where('ESTADO', 'ENTREGADO')->count();
        $this->totalpte = Package::onlyTrashed()->where('CUIDAD', 'POTOSI')->where('ESTADO', 'ENTREGADO')->count();
        $this->totaltje = Package::onlyTrashed()->where('CUIDAD', 'TARIJA')->where('ESTADO', 'ENTREGADO')->count();
        $this->totalscre = Package::onlyTrashed()->where('CUIDAD', 'SUCRE')->where('ESTADO', 'ENTREGADO')->count();
        $this->totalpne = Package::onlyTrashed()->where('CUIDAD', 'PANDO')->where('ESTADO', 'ENTREGADO')->count();

        // Reportes por dia Ventanilla
        $this->hoylpedd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->count();
        $this->hoylpeeco = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ENCOMIENDAS')->whereDate('deleted_at', today())->count();
        $this->hoylpednd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DND')->whereDate('deleted_at', today())->count();
        $this->hoylpecs = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CASILLA')->where('VENTANILLA', 'CASILLAS')->whereDate('deleted_at', today())->count();
        $this->hoylpeeca = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ECA')->whereDate('deleted_at', today())->count();
        $this->hoycbbae = Package::onlyTrashed()->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $this->hoyscze = Package::onlyTrashed()->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $this->hoybne = Package::onlyTrashed()->where('CUIDAD', 'BENI')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $this->hoyorue = Package::onlyTrashed()->where('CUIDAD', 'ORURO')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $this->hoypte = Package::onlyTrashed()->where('CUIDAD', 'POTOSI')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $this->hoytje = Package::onlyTrashed()->where('CUIDAD', 'TARIJA')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $this->hoyscre = Package::onlyTrashed()->where('CUIDAD', 'SUCRE')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();
        $this->hoypne = Package::onlyTrashed()->where('CUIDAD', 'PANDO')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->count();

        // Reportes por dia Ventanilla Generado PRECIO
        $this->hoylpvdd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoylpvdnd = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DND')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoylpveco = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ENCOMIENDAS')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoylpvcs = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CASILLA')->where('VENTANILLA', 'CASILLAS')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoylpveca = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'ECA')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoycbbav = Package::onlyTrashed()->where('CUIDAD', 'COCHABAMBA')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoysczv = Package::onlyTrashed()->where('CUIDAD', 'SANTA CRUZ')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoybnv = Package::onlyTrashed()->where('CUIDAD', 'BENI')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoyoruv = Package::onlyTrashed()->where('CUIDAD', 'ORURO')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoyptv = Package::onlyTrashed()->where('CUIDAD', 'POTOSI')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoytjv = Package::onlyTrashed()->where('CUIDAD', 'TARIJA')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoyscrv = Package::onlyTrashed()->where('CUIDAD', 'SUCRE')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->hoypnv = Package::onlyTrashed()->where('CUIDAD', 'PANDO')->where('ESTADO', 'ENTREGADO')->whereDate('deleted_at', today())->sum('PRECIO');

        // Regional Detallado Cartero
        $this->totallpcar = $this->packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'CARTERO')->count();
        $this->totallpret = $this->packages->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'RETORNO')->count();
        $this->totallprep = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'REPARTIDO')->count();
        $this->hoylpent = Package::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'REPARTIDO')->whereDate('deleted_at', today())->count();

        $this->totalmensajeenv = $mensaje->where('estado', 'Enviado')->count()
            + $mensaje->where('estado', 'Recibido')->count()
            + $mensaje->where('estado', 'Leído')->count();
        $this->totalmensajelei = $mensaje->where('estado', 'Leído')->count();
        $this->totalmensajenenv = $mensaje->where('estado', 'No enviado')->count();
        $this->totalmensaje = $mensaje->count();
        $this->totalmensajeHoy = Mensaje::whereDate('fecha_creacion', Carbon::today())->count();
        
        $this->totallpvr = $international->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'DD')->count();
        $this->totallpvren = International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->count();
        $this->hoylpvr = International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->count();
        $this->hoylpvhh = International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DD')->whereDate('deleted_at', today())->sum('PRECIO');
        $this->totallpvrr = $international->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'VENTANILLA')->where('VENTANILLA', 'DND')->count();
        $this->totallpvrenn = International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DND')->count();
        $this->hoylpvrr = International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DND')->whereDate('deleted_at', today())->count();
        $this->hoylpvhhh = International::onlyTrashed()->where('CUIDAD', 'LA PAZ')->where('ESTADO', 'ENTREGADO')->where('VENTANILLA', 'DND')->whereDate('deleted_at', today())->sum('PRECIO');
        
        // Datos por mes 
        $dataByMonth = Package::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->get();

        // Formatear las fechas a nombres de meses
        $formattedMonths = $dataByMonth->pluck('month')->map(function ($date) {
            return \Illuminate\Support\Carbon::parse($date)->format('F Y'); // 'F' representa el nombre completo del mes
        });

        // Organizar los datos por tipo (clasificación y ventanilla)
        $this->data = [
            'Clasificacion' => [],
            'Ventanilla' => [],
        ];

        foreach ($dataByMonth as $entry) {
            $dataByType = Package::select('ESTADO')
                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $entry->month)
                ->get();

            $this->data['Clasificacion'][] = $dataByType->where('ESTADO', 'CLASIFICACION')->count();
            $this->data['Ventanilla'][] = $dataByType->where('ESTADO', 'VENTANILLA')->count();
        }

        $dataByMonthArea = Package::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('COUNT(*) as total'))
            ->where('ESTADO', 'ENTREGADO') // Filtrar por ESTADO=ENTREGADO
            ->orWhere('ESTADO', 'CLASIFICACION') // Filtrar por ESTADO=CLASIFICACION
            ->groupBy('month')
            ->get();

        $this->dataArea = [
            'Entregado' => [],
            'Clasificacion' => [],
        ];

        foreach ($dataByMonthArea as $entry) {
            $dataByTypeArea = Package::select('ESTADO')
                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $entry->month)
                ->whereIn('ESTADO', ['ENTREGADO', 'CLASIFICACION'])
                ->get();

            $this->dataArea['Entregado'][] = $dataByTypeArea->where('ESTADO', 'ENTREGADO')->count();
            $this->dataArea['Clasificacion'][] = $dataByTypeArea->where('ESTADO', 'CLASIFICACION')->count();
        }
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'data' => $this->data,
            'dataArea' => $this->dataArea,
            'dataByMonth' => $this->dataByMonth,
            'dataByMonthArea' => $this->dataByMonthArea,
            'national' => National::all(),
            'international' => International::all(),
            'totallpvrr' => $this->totallpvrr,
            'totallpvrenn' => $this->totallpvrenn,
            'hoylpvrr' => $this->hoylpvrr,
            'hoylpvhhh' => $this->hoylpvhhh,
            'totallpvren' => $this->totallpvren,
            'totallpvr' => $this->totallpvr,
            'hoylpvr' => $this->hoylpvr,
            'hoylpvhh' => $this->hoylpvhh,
            'totalbaja' => $this->totalbaja,
            'hoylpeeco' => $this->hoylpeeco,
            'totallpveco' => $this->totallpveco,
            'totallpeeco' => $this->totallpeeco,
            'hoylpveco' => $this->hoylpveco,
            'totalmensaje' => $this->totalmensaje,
            'totalmensajeenv' => $this->totalmensajeenv,
            'totalmensajeHoy' => $this->totalmensajeHoy,
            'totalmensajenenv' => $this->totalmensajenenv,
            'totalmensajelei' => $this->totalmensajelei,
            'totalDespacho' => $this->totalDespacho,
            'totalCartero' => $this->totalCartero,
            'totalCartInve' => $this->totalCartInve,
            'hoylpvdd' => $this->hoylpvdd,
            'hoylpvdnd' => $this->hoylpvdnd,
            'hoylpvcs' => $this->hoylpvcs,
            'hoylpveca' => $this->hoylpveca,
            'hoycbbav' => $this->hoycbbav,
            'hoysczv' => $this->hoysczv,
            'hoybnv' => $this->hoybnv,
            'hoyoruv' => $this->hoyoruv,
            'hoyptv' => $this->hoyptv,
            'hoytjv' => $this->hoytjv,
            'hoyscrv' => $this->hoyscrv,
            'hoypnv' => $this->hoypnv,
            'totallpcar' => $this->totallpcar,
            'totallpret' => $this->totallpret,
            'totallprep' => $this->totallprep,
            'hoylpent' => $this->hoylpent,
            'totalPreRezago' => $this->totalPreRezago,
            'totalRezago' => $this->totalRezago,
            'meslpc' => $this->meslpc,
            'hoylpedd' => $this->hoylpedd,
            'hoylpednd' => $this->hoylpednd,
            'hoylpecs' => $this->hoylpecs,
            'hoylpeeca' => $this->hoylpeeca,
            'hoycbbae' => $this->hoycbbae,
            'hoyscze' => $this->hoyscze,
            'hoybne' => $this->hoybne,
            'hoyorue' => $this->hoyorue,
            'hoypte' => $this->hoypte,
            'hoytje' => $this->hoytje,
            'hoyscre' => $this->hoyscre,
            'hoypne' => $this->hoypne,
            'hoylpc' => $this->hoylpc,
            'userRegional' => $this->userRegional,
            'totallpedd' => $this->totallpedd,
            'totallpednd' => $this->totallpednd,
            'totallpecs' => $this->totallpecs,
            'totallpeeca' => $this->totallpeeca,
            'totalcbbae' => $this->totalcbbae,
            'totalscze' => $this->totalscze,
            'totalbne' => $this->totalbne,
            'totalorue' => $this->totalorue,
            'totalpte' => $this->totalpte,
            'totaltje' => $this->totaltje,
            'totalscre' => $this->totalscre,
            'totalpne' => $this->totalpne,
            'totallpvdd' => $this->totallpvdd,
            'totallpvdnd' => $this->totallpvdnd,
            'totallpveca' => $this->totallpveca,
            'totallpvcs' => $this->totallpvcs,
            'totalcbbav' => $this->totalcbbav,
            'totalsczv' => $this->totalsczv,
            'totalbnv' => $this->totalbnv,
            'totaloruv' => $this->totaloruv,
            'totalptv' => $this->totalptv,
            'totaltjv' => $this->totaltjv,
            'totalscrv' => $this->totalscrv,
            'totalpnv' => $this->totalpnv,
            'totalReecaminado' => $this->totalReecaminado,
            'totalpn' => $this->totalpn,
            'totalscr' => $this->totalscr,
            'totaltj' => $this->totaltj,
            'totalpt' => $this->totalpt,
            'totaloru' => $this->totaloru,
            'totalbn' => $this->totalbn,
            'totalscz' => $this->totalscz,
            'totalcbba' => $this->totalcbba,
            'totallp' => $this->totallp,
            'packages' => $this->packages,
            'totalPaquetes' => $this->totalPaquetes,
            'totalUsuarios' => $this->totalUsuarios,
            'totalRegistradosHoy' => $this->totalRegistradosHoy,
            'totalEntregadosHoy' => $this->totalEntregadosHoy,
            'totalReencaminadoHoy' => $this->totalReencaminadoHoy,
            'totalEntregados' => $this->totalEntregados,
            'totalVentanilla' => $this->totalVentanilla,
            'totalClasificacion' => $this->totalClasificacion,
        ]);
    }
}

