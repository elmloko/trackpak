@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Seguimiento de Paqueteria Nacional de Agencia Boliviana de Correos</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
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
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalRegistradosHoy }}</h3>
                    <p>Total Registrados Hoy</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
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
            <div class="small-box bg-danger">
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
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalEntregados }}</h3>
                    <p>Total Paquetes en Inventario</p>
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
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalVentanilla }}</h3>
                    <p>Total Paquetes en Ventanilla</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('test.deleteado') }}" class="small-box-footer">
                    Mas Informacion <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalClasificacion }}</h3>
                    <p>Total Paquetes en Clasificacion</p>
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
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalReecaminado }}</h3>
                    <p>Total Paquetes en Reencaminamiento</p>
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

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Estadistica de Regionales</h3>
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
                            <h3 class="card-title">Area Chart</h3>
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
                    <h3 class="card-title">Estadisticas de Areas</h3>
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
                    datasets: [
                        {
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
