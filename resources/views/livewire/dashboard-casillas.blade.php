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
                        <p>Total LC/AO en ventanilla CASILLAS</p>
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
                        <p>Total LC/AO entregados en ventanilla CASILLAS</p>
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
                        <p>Total LC/AO entregados hoy en ventanilla CASILLAS</p>
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
                        <p>Total LC/AO generado hoy en ventanilla CASILLAS</p>
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