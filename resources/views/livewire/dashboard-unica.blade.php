<div>

    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Estadisticas Área de Ventanilla </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        @foreach ($statistics as $city => $data)
            @if ($userRegional === $city || $userRegional === 'LA PAZ')
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $data['total_v'] }}</h3>
                                    <p>Total LC/AO en ventanilla en {{ $city }}</p>
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
                                    <h3>{{ $data['total_e'] }}</h3>
                                    <p>Total LC/AO entregados en ventanilla en {{ $city }}</p>
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
                                    <h3>{{ $data['today_e'] }}</h3>
                                    <p>Total LC/AO entregados hoy en ventanilla en {{ $city }}</p>
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
                                    <h3>{{ $data['today_v'] }} Bs.</h3>
                                    <p>Total LC/AO generado hoy en ventanilla en {{ $city }}</p>
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
            @endif
        @endforeach
    </div>

    @foreach ($statistics as $city => $data)
        @if ($userRegional === $city)
            <div style="text-align: center;">
                <div class="row">
                    <div class="col-6">
                        <a class="btn btn-warning btn-lg btn-block"
                            href="https://correos.gob.bo:8000/packages/ventanillaunica">Entregar Paqueteria Postal</a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-warning btn-lg btn-block"
                            href="https://correos.gob.bo:8000/packages/ventanillaunicarecibir">Recibir Paqueteria
                            Postal</a>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
