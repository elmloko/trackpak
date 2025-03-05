<div>
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
    {{-- <div class="card card-light">
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
                </div>
                <div class="col-lg-3 col-6">
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
            </div>
        </div>
    </div> --}}
</div>
