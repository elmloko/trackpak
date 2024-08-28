@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Sistema de Paquetes Ordinario/ Casillas Postales/ Envios de Correspondencia Agrupada/ Encomiendas Nacionales de la Agencia Boliviana de Correos</h1>
@stop

@section('content')

    @hasrole('SuperAdmin|Administrador')
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

    @include('footer')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <!-- En el head de tu archivo de diseño -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stop
