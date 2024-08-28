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
                        <h3>{{ $totallpvrr }}</h3>
                        <p>Total CERTIFICADO en ventanilla DND</p>
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
                        <p>Total CERTIFICADO entregados en ventanilla DND</p>
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
                        <p>Total CERTIFICADO entregados hoy en ventanilla DND</p>
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
                        <p>Total CERTIFICADO generado hoy en ventanilla DND</p>
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
                        <h3>{{ $totallpvdnd }}</h3>
                        <p>Total ORDINARIO en ventanilla DND</p>
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
                        <p>Total ORDINARIO entregados en ventanilla DND</p>
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
                        <p>Total ORDINARIO entregados hoy en ventanilla DND</p>
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
                        <p>Total ORDINARIO generado hoy en ventanilla DND</p>
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