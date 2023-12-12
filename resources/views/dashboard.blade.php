@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Seguimiento de Paqueteria Nacional de Agencia Boliviana de Correos</h1>
@stop

@section('content')
    <div class="row">
        @hasrole('SuperAdmin')
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
        @endhasrole
        @hasrole('SuperAdmin|Administrador')
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
        @endhasrole
        @hasrole('SuperAdmin|Administrador')
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
        @endhasrole
        @hasrole('SuperAdmin|Administrador')
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
        @endhasrole
        @hasrole('SuperAdmin|Administrador')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalEntregados }}</h3>
                        <p>Total Paquetes en Inventario</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                        Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endhasrole
        @hasrole('SuperAdmin|Administrador')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalVentanilla }}</h3>
                        <p>Total Paquetes en Ventanilla</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                        Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endhasrole
        @hasrole('SuperAdmin|Administrador')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalClasificacion }}</h3>
                        <p>Total Paquetes en Clasificacion</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                        Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endhasrole
        @hasrole('SuperAdmin|Administrador')
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
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
        @endhasrole

        @if ($userRegional === 'LA PAZ')
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
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
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalDespacho }}</h3>
                            <p>Total Despacho</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
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
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $hoylpc }}</h3>
                            <p>Total Hoy Clasificacion La Paz</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Expedicion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totallpr }}</h3>
                            <p>Total Reencaminado en La Paz</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="{{ route('packages.redirigidos') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totallpv }}</h3>
                            <p>Total Ventanilla en La Paz</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totallpe }}</h3>
                            <p>Total Entregados La Paz</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $hoylpe }}</h3>
                            <p>Total Hoy Entregados La Paz</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
        @endif

        @if ($userRegional === 'COCHABAMBA')
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalcbbac }}</h3>
                            <p>Total Clasificacion Cochabamba</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Expedicion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalcbbar }}</h3>
                            <p>Total Reencaminado en Cochabamba</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <a href="{{ route('packages.redirigidos') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalcbbav }}</h3>
                            <p>Total Ventanilla en Cochabamba</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalcbbae }}</h3>
                            <p>Total Entregados Cochabamba</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $hoycbbac }}</h3>
                            <p>Total Hoy Clasificacion Cochabamba</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $hoycbbae }}</h3>
                            <p>Total Hoy Entregados Cochabamba</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
        @endif

        @if ($userRegional === 'SANTA CRUZ')
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalsczc }}</h3>
                            <p>Total Clasificacion Santa Cruz</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Expedicion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalsczr }}</h3>
                            <p>Total Reencaminado en Santa Cruz</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('packages.redirigidos') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalsczv }}</h3>
                            <p>Total Ventanilla en Santa Cruz</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalscze }}</h3>
                            <p>Total Entregados Santa Cruz</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $hoysczc }}</h3>
                            <p>Total Hoy Clasificacion Santa Cruz</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $hoyscze }}</h3>
                            <p>Total Hoy Entregados Santa Cruz</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
        @endif

        @if ($userRegional === 'BENI')
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalbnc }}</h3>
                            <p>Total Clasificacion Beni</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Expedicion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalbnr }}</h3>
                            <p>Total Reencaminado en Beni</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.redirigidos') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalbnv }}</h3>
                            <p>Total Ventanilla en Beni</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalbne }}</h3>
                            <p>Total Entregados Beni</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $hoybnc }}</h3>
                            <p>Total Hoy Clasificacion Beni</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $hoybne }}</h3>
                            <p>Total Hoy Entregados Beni</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
        @endif

        @if ($userRegional === 'ORURO')
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totaloruc }}</h3>
                            <p>Total Clasificacion Oruro</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Expedicion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalorur }}</h3>
                            <p>Total Reencaminado en Oruro</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.redirigidos') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totaloruv }}</h3>
                            <p>Total Ventanilla en Oruro</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalorue }}</h3>
                            <p>Total Entregados Oruro</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $hoyoruc }}</h3>
                            <p>Total Hoy Clasificacion Oruro</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $hoyorue }}</h3>
                            <p>Total Hoy Entregados Oruro</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
        @endif

        @if ($userRegional === 'TARIJA')
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totaltjc }}</h3>
                            <p>Total Clasificacion Tarija</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Expedicion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totaltjr }}</h3>
                            <p>Total Reencaminado en Tarija</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.redirigidos') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totaltjv }}</h3>
                            <p>Total Ventanilla en Tarija</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totaltje }}</h3>
                            <p>Total Entregados Tarija</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $hoytjc }}</h3>
                            <p>Total Hoy Clasificacion Tarija</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $hoytjc }}</h3>
                            <p>Total Hoy Entregados Tarija</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
        @endif

        @if ($userRegional === 'SUCRE')
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalscrc }}</h3>
                            <p>Total Clasificacion en Sucre</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Expedicion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalscrr }}</h3>
                            <p>Total Reencaminado en Sucre</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.redirigidos') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalscrv }}</h3>
                            <p>Total Ventanilla en Sucre</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalscre }}</h3>
                            <p>Total Entregados Sucre</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $hoyscrc }}</h3>
                            <p>Total Hoy Clasificacion Sucre</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $hoyscrc }}</h3>
                            <p>Total Hoy Entregados Sucre</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
        @endif

        @if ($userRegional === 'PANDO')
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalpnc }}</h3>
                            <p>Total Clasificacion en Pando</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Expedicion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalpnr }}</h3>
                            <p>Total Reencaminado en Pando</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.redirigidos') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalpnv }}</h3>
                            <p>Total Ventanilla en Rando</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalpne }}</h3>
                            <p>Total Entregados Pando</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $hoypnc }}</h3>
                            <p>Total Hoy Clasificacion Pando</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $hoypne }}</h3>
                            <p>Total Hoy Entregados Pando</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
        @endif

        @if ($userRegional === 'POTOSI')
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalptc }}</h3>
                            <p>Total Clasificacion Potosi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Expedicion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalptr }}</h3>
                            <p>Total Reencaminado en Potosi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.redirigidos') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalptv }}</h3>
                            <p>Total Ventanilla en Potosi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.ventanilla') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalpte }}</h3>
                            <p>Total Entregados Potosi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $hoyptc }}</h3>
                            <p>Total Hoy Clasificacion Potosi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('packages.clasificacion') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
            @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $hoypte }}</h3>
                            <p>Total Hoy Entregados Potosi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                            Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endhasrole
        @endif
    </div>


        <section class="content">
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
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
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
        </section>

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
