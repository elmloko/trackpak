@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Sistema de Paquetes Ordinario/ Casillas Postales/ Envios de Correspondencia Agrupada/ Encomiendas Nacionales de la Agencia Boliviana de Correos</h1>
@stop

@section('content')

    @hasrole('SuperAdmin')
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Estadisticas de Sistema</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-light  ">
                            <div class="inner">
                                <h3>{{ $totalUsuarios }}</h3>
                                <p>Total Usuarios</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <a href="{{ route('users.index') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-dark">
                            <div class="inner">
                                <h3>{{ $totalPaquetes }}</h3>
                                <p>Total Paquetes Nacionales</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.index') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalEntregados }}</h3>
                                <p>Paqutes por Entregar</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalEntregadosHoy }}</h3>
                                <p>Total Entregados Hoy</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <p class="small-box-footer">
                                {{ now()->format('Y-m-d') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('Administrador')
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Estadisticas de Sistema</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-dark">
                            <div class="inner">
                                <h3>{{ $totalPaquetes }}</h3>
                                <p>Total Paquetes Nacionales</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.index') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalRegistradosHoy }}</h3>
                                <p>Total Registrados Hoy</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalEntregadosHoy }}</h3>
                                <p>Total Entregados Hoy</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <p class="small-box-footer">
                                {{ now()->format('Y-m-d') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Área Clasificacion</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalClasificacion }}</h3>
                                <p>Total Clasificacion</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalDespacho }}</h3>
                                <p>Total Despacho en Clasificacion</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.entregasclasificacion') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $meslpc }}</h3>
                                <p>Total Mes Clasificacion</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $hoylpc }}</h3>
                                <p>Total Hoy Clasificacion</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('SuperAdmin|Administrador')
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Área de Ventanilla LA PAZ</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvr }}</h3>
                                <p>Total Paquetes en Ventanilla CERTIFICADO DD</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('internationals.ventanilladd') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvren }}</h3>
                                <p>Total Entregados CERTIFICADO DD</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.encomiendas') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvr }}</h3>
                                <p>Total Hoy Entregados CERTIFICADO DD</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvhh }} Bs.</h3>
                                <p>Total Hoy Generado CERTIFICADO DD</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvrr }}</h3>
                                <p>Total Paquetes en Ventanilla CERTIFICADO DND</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('internationals.ventanilladd') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvrenn }}</h3>
                                <p>Total Entregados CERTIFICADO DND</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.encomiendas') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvrr }}</h3>
                                <p>Total Hoy Entregados CERTIFICADO DND</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvhhh }} Bs.</h3>
                                <p>Total Hoy Generado CERTIFICADO DND</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpveco }}</h3>
                                <p>Total Paquetes en Ventanilla ENCOMIENDAS</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.encomiendas') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpeeco }}</h3>
                                <p>Total Entregados ENCOMIENDAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpeeco }}</h3>
                                <p>Total Hoy Entregados ENCOMIENDAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpveco }} Bs.</h3>
                                <p>Total Hoy Generado ENCOMIENDAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvdd }}</h3>
                                <p>Total Paquetes en Ventanilla DD</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpedd }}</h3>
                                <p>Total Entregados DD</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpedd }}</h3>
                                <p>Total Hoy Entregados DD</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvdd }} Bs.</h3>
                                <p>Total Hoy Generado DD</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvdnd }}</h3>
                                <p>Total Paquetes en Ventanilla DND</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanilladnd') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpednd }}</h3>
                                <p>Total Entregados DND</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadodnd') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpednd }}</h3>
                                <p>Total Hoy Entregados DND</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadodnd') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvdnd }} Bs.</h3>
                                <p>Total Hoy Generado DND</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadodnd') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvcs }}</h3>
                                <p>Total Paquetes en Ventanilla CASILLAS</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.casillas') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpecs }}</h3>
                                <p>Total Entregados CASILLAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.casillasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpecs }}</h3>
                                <p>Total Hoy Entregados CASILLAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.casillasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvcs }} Bs.</h3>
                                <p>Total Hoy Generado CASILLAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.casillasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpveca }}</h3>
                                <p>Total Paquetes en Ventanilla ECA</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.eca') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpeeca }}</h3>
                                <p>Total Entregados ECA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.ecainventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpeeca }}</h3>
                                <p>Total Hoy Entregados ECA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.ecainventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpveca }} Bs.</h3>
                                <p>Total Hoy Generado ECA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.ecainventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Área de Ventanilla REGIONALES</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalcbbav }}</h3>
                                <p>Total Paquetes en Ventanilla COCHABAMBA</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalcbbae }}</h3>
                                <p>Total Entregados COCHABAMBA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoycbbae }}</h3>
                                <p>Total Hoy Entregados COCHABAMBA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoycbbav }} Bs.</h3>
                                <p>Total Hoy Generado COCHABAMBA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalsczv }}</h3>
                                <p>Total Paquetes en Ventanilla SANTA CRUZ</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalscze }}</h3>
                                <p>Total Entregados SANTA CRUZ</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoyscze }}</h3>
                                <p>Total Hoy Entregados SANTA CRUZ</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoysczv }} Bs.</h3>
                                <p>Total Hoy Generado SANTA CRUZ</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalbnv }}</h3>
                                <p>Total Paquetes en Ventanilla BENI</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalbne }}</h3>
                                <p>Total Entregados BENI</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoybne }}</h3>
                                <p>Total Hoy Entregados BENI</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoybnv }} Bs.</h3>
                                <p>Total Hoy Generado BENI</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totaloruv }}</h3>
                                <p>Total Paquetes en Ventanilla ORURO</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalorue }}</h3>
                                <p>Total Entregados ORURO</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoyorue }}</h3>
                                <p>Total Hoy Entregados ORURO</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoyoruv }} Bs.</h3>
                                <p>Total Hoy Generado ORURO</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totaltjv }}</h3>
                                <p>Total Paquetes en Ventanilla TARIJA</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totaltje }}</h3>
                                <p>Total Entregados TARIJA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoytje }}</h3>
                                <p>Total Hoy Entregados TARIJA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoytjv }} Bs.</h3>
                                <p>Total Hoy Generado TARIJA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalscrv }}</h3>
                                <p>Total Paquetes en Ventanilla SUCRE</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalscre }}</h3>
                                <p>Total Entregados SUCRE</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoyscre }}</h3>
                                <p>Total Hoy Entregados SUCRE</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoyscrv }} Bs.</h3>
                                <p>Total Hoy Generado SUCRE</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalpnv }}</h3>
                                <p>Total Paquetes en Ventanilla PANDO</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalpne }}</h3>
                                <p>Total Entregados PANDO</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoypne }}</h3>
                                <p>Total Hoy Entregados PANDO</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoypnv }} Bs.</h3>
                                <p>Total Hoy Generado PANDO</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalptv }}</h3>
                                <p>Total Paquetes en Ventanilla POTOSI</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalpte }}</h3>
                                <p>Total Entregados POTOSI</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoypte }}</h3>
                                <p>Total Hoy Entregados POTOSI</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoyptv }} Bs.</h3>
                                <p>Total Hoy Generado POTOSI</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Área de Carteros</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $totallpcar }}</h3>
                                <p>Total Paquetes con Carteros</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $totallpret }}</h3>
                                <p>Total Retornados a Ventanilla</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $totallprep }}</h3>
                                <p>Total Entregados Carteros</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $hoylpent }}</h3>
                                <p>Total Hoy Entregados por Carteros</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Área de REZAGO</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $totalRezago }}</h3>
                                <p>Total Paquetes en Rezago</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <a href="{{ route('packages.rezago') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $totalPreRezago }}</h3>
                                <p>Total Paquetes en Pre-Rezago</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <a href="{{ route('packages.prerezago') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Mensajes</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-light">
                            <div class="inner">
                                <h3>{{ $totalmensaje }}</h3>
                                <p>Total mensajes enviados</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <a href="{{ route('packages.rezago') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div><div class="col-lg-3 col-6">
                        <div class="small-box bg-light">
                            <div class="inner">
                                <h3>{{ $totalmensajeHoy }}</h3>
                                <p>Total mensajes enviados Hoy</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <a href="{{ route('packages.rezago') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-light">
                            <div class="inner">
                                <h3>{{ $totalmensajeenv }}</h3>
                                <p>Total mensajes enviados Exito</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <a href="{{ route('packages.prerezago') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-light">
                            <div class="inner">
                                <h3>{{ $totalmensajenenv }}</h3>
                                <p>Total mensajes enviados con Falla</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <a href="{{ route('packages.prerezago') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    {{-- <div class="col-lg-3 col-6">
                        <div class="small-box bg-light">
                            <div class="inner">
                                <h3>{{ $totalmensajelei }}</h3>
                                <p>Total mensajes enviados Leidos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <a href="{{ route('packages.prerezago') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('ENCOMIENDAS')
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Área de Ventanilla ENCOMIENDAS</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpveco }}</h3>
                                <p>Total Paquetes en Ventanilla ENCOMIENDAS</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.encomiendas') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpeeco }}</h3>
                                <p>Total Entregados ENCOMIENDAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpeeco }}</h3>
                                <p>Total Hoy Entregados ENCOMIENDAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpveco }} Bs.</h3>
                                <p>Total Hoy Generado ENCOMIENDAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('Urbano|Auxiliar Urbano')
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Área de Ventanilla DD</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvr }}</h3>
                                <p>Total Paquetes en Ventanilla CERTIFICADO</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('internationals.ventanilladd') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvren }}</h3>
                                <p>Total Paquetes en Ventanilla CERTIFICADO</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.encomiendas') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvr }}</h3>
                                <p>Total Hoy Entregados CERTIFICADO</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvhh }} Bs.</h3>
                                <p>Total Hoy Generado CERTIFICADO</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.encomiendasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvdd }}</h3>
                                <p>Total Paquetes en Ventanilla DD</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpedd }}</h3>
                                <p>Total Entregados DD</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpedd }}</h3>
                                <p>Total Hoy Entregados DD</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvdd }} Bs.</h3>
                                <p>Total Hoy Generado DD</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('DND')
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Área de Ventanilla DND</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvdnd }}</h3>
                                <p>Total Paquetes en Ventanilla DND</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.ventanilladnd') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpednd }}</h3>
                                <p>Total Entregados DND</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadodnd') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpednd }}</h3>
                                <p>Total Hoy Entregados DND</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadodnd') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvdnd }} Bs.</h3>
                                <p>Total Hoy Generado DND</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('test.deleteadodnd') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('Casillas')
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Área de Ventanilla CASILLAS</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpvcs }}</h3>
                                <p>Total Paquetes en Ventanilla CASILLAS</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.casillasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpecs }}</h3>
                                <p>Total Entregados CASILLAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.casillasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpecs }}</h3>
                                <p>Total Hoy Entregados CASILLAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.casillasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpvcs }} Bs.</h3>
                                <p>Total Hoy Generado CASILLAS</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.casillasinventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('ECA')
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Área de Ventanilla ECA</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpveca }}</h3>
                                <p>Total Paquetes en Ventanilla ECA</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('packages.eca') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totallpeeca }}</h3>
                                <p>Total Entregados ECA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.ecainventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpeeca }}</h3>
                                <p>Total Hoy Entregados ECA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.ecainventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $hoylpveca }} Bs.</h3>
                                <p>Total Hoy Generado ECA</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="{{ route('packages.ecainventario') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endhasrole

    @hasrole('SuperAdmin|Administrador|Expedicion')
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Estadisticas Área de Expedicion</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{ $totalReecaminado }}</h3>
                                <p>Total Paquetes en Reencaminamiento</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <a href="{{ route('packages.redirigidos') }}" class="small-box-footer">
                                Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endhasrole

    @if ($userRegional === 'COCHABAMBA')
        @hasrole('Unica')
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Estadisticas Área de Ventanilla COCHABAMBA</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalcbbav }}</h3>
                                    <p>Total Paquetes en Ventanilla UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalcbbae }}</h3>
                                    <p>Total Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoycbbae }}</h3>
                                    <p>Total Hoy Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoycbbav }} Bs.</h3>
                                    <p>Total Hoy Generado UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endhasrole
    @endif

    @if ($userRegional === 'SANTA CRUZ')
        @hasrole('Unica')
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Estadisticas Área de Ventanilla SANTA CRUZ</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalsczv }}</h3>
                                    <p>Total Paquetes en Ventanilla UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalscze }}</h3>
                                    <p>Total Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoyscze }}</h3>
                                    <p>Total Hoy Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoysczv }} Bs.</h3>
                                    <p>Total Hoy Generado UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endhasrole
    @endif

    @if ($userRegional === 'BENI')
        @hasrole('Unica')
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Estadisticas Área de Ventanilla BENI</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalbnv }}</h3>
                                    <p>Total Paquetes en Ventanilla UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalbne }}</h3>
                                    <p>Total Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoybne }}</h3>
                                    <p>Total Hoy Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoybnv }} Bs.</h3>
                                    <p>Total Hoy Generado UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endhasrole
    @endif

    @if ($userRegional === 'ORURO')
        @hasrole('Unica')
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Estadisticas Área de Ventanilla ORURO</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totaloruv }}</h3>
                                    <p>Total Paquetes en Ventanilla UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalorue }}</h3>
                                    <p>Total Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoyorue }}</h3>
                                    <p>Total Hoy Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoyoruv }} Bs.</h3>
                                    <p>Total Hoy Generado UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endhasrole
    @endif

    @if ($userRegional === 'TARIJA')
        @hasrole('Unica')
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Estadisticas Área de Ventanilla TARIJA</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totaltjv }}</h3>
                                    <p>Total Paquetes en Ventanilla UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totaltje }}</h3>
                                    <p>Total Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoytje }}</h3>
                                    <p>Total Hoy Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoytjv }} Bs.</h3>
                                    <p>Total Hoy Generado UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endhasrole
    @endif

    @if ($userRegional === 'SUCRE')
        @hasrole('Unica')
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Estadisticas Área de Ventanilla SUCRE</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalscrv }}</h3>
                                    <p>Total Paquetes en Ventanilla UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalscre }}</h3>
                                    <p>Total Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoyscre }}</h3>
                                    <p>Total Hoy Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoyscrv }} Bs.</h3>
                                    <p>Total Hoy Generado UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endhasrole
    @endif

    @if ($userRegional === 'PANDO')
        @hasrole('Unica')
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Estadisticas Área de Ventanilla PANDO</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalpnv }}</h3>
                                    <p>Total Paquetes en Ventanilla UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalpne }}</h3>
                                    <p>Total Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoypne }}</h3>
                                    <p>Total Hoy Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoypnv }} Bs.</h3>
                                    <p>Total Hoy Generado UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endhasrole
    @endif

    @if ($userRegional === 'POTOSI')
        @hasrole('Unica')
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Estadisticas Área de Ventanilla POTOSI</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalptv }}</h3>
                                    <p>Total Paquetes en Ventanilla UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('packages.ventanillaunica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalpte }}</h3>
                                    <p>Total Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoypte }}</h3>
                                    <p>Total Hoy Entregados UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $hoyptv }} Bs.</h3>
                                    <p>Total Hoy Generado UNICA</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="{{ route('test.deleteadounica') }}" class="small-box-footer">
                                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endhasrole
    @endif

    {{-- <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Estadistica de Paquetes Total en Regionales</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Estadistica de Comparacion por Mes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="areaChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Estadisticas de Comparacion de Areas</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="stackedBarChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
    </section> --}}

    @include('footer')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <!-- En el head de tu archivo de diseño -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('pieChart').getContext('2d');
            var pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['La Paz', 'Cochabamba', 'Santa Cruz', 'Beni', 'Oruro', 'Potosi', 'Tarija',
                        'Sucre', 'Pando'
                    ],
                    datasets: [{
                        data: [{{ $totallp }}, {{ $totalcbba }}, {{ $totalscz }},
                            {{ $totalbn }}, {{ $totaloru }}, {{ $totalpt }},
                            {{ $totaltj }}, {{ $totalscr }}, {{ $totalpn }}
                        ],
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                            '#FF9657', '#D9534F', '#5CB85C', '#4285F4'
                        ],
                        hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF', '#FF9657', '#D9534F', '#5CB85C', '#4285F4'
                        ]
                    }]
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('stackedBarChart').getContext('2d');
            var stackedBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($dataByMonth->pluck('month')->toArray()) !!},
                    datasets: [{
                            label: 'Clasificacion',
                            backgroundColor: '#FF6384',
                            data: {!! json_encode($data['Clasificacion']) !!}
                        },
                        {
                            label: 'Ventanilla',
                            backgroundColor: '#36A2EB',
                            data: {!! json_encode($data['Ventanilla']) !!}
                        }
                    ]
                },
                options: {
                    scales: {
                        xAxes: [{
                            stacked: true,
                            type: 'time',
                            time: {
                                unit: 'month',
                                displayFormats: {
                                    month: 'MMM YYYY'
                                }
                            }
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('areaChart').getContext('2d');
            var areaChart = new Chart(ctx, {
                type: 'line', // Cambiar a 'line' para un gráfico de área
                data: {
                    labels: {!! json_encode($dataByMonth->pluck('month')->toArray()) !!},
                    datasets: [{
                            label: 'Entregado',
                            borderColor: '#FF6384',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            data: {!! json_encode($dataArea['Entregado']) !!}
                        },
                        {
                            label: 'Clasificacion',
                            borderColor: '#36A2EB',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            data: {!! json_encode($dataArea['Clasificacion']) !!}
                        }
                    ]
                },
                options: {
                    scales: {
                        xAxes: [{
                            type: 'time',
                            time: {
                                unit: 'month',
                                displayFormats: {
                                    month: 'MMM YYYY'
                                }
                            }
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
        });
    </script>
@stop
