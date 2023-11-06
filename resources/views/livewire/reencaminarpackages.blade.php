<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div>
                                <h5 id="card_title">
                                    {{ __('Paquetes Perdidos en Destino') }}
                                </h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <input wire:model.lazy="search" type="text" class="form-control" placeholder="Buscar...">
                                        </div>
                                    </div>
                                    <div class="mr-2 d-inline-block">
                                        <a href="{{ route('package.pdf.ventanillapdf') }}" class="btn btn-danger" data-placement="left">
                                            PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            @if ($packages->count() > 0)
                                <table class="table table-striped table-hover">
                                    <thead class="thead">
                                        <tr>
                                            <th>No</th>
                                            <th>Código Postal</th>
                                            <th>Destinatario</th>
                                            <th>País</th>
                                            <th>Destino Cuidad</th>
                                            <th>Tipo</th>
                                            <th>Estado</th>
                                            <th>Aduana</th>
                                            <th>Fecha Retorno</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($packages as $package)
                                        @if ($package->ESTADO === 'REENCAMINADO')
                                            <tr>
                                                <td>{{ $package->id }}</td>
                                                <td>{{ $package->CODIGO }}</td>
                                                <td>{{ $package->DESTINATARIO }}</td>
                                                <td>{{ $package->PAIS }}</td>
                                                <td>{{ $package->CUIDAD }}</td>
                                                <td>{{ $package->TIPO }}</td>
                                                <td>{{ $package->ESTADO }}</td>
                                                <td>{{ $package->ADUANA }}</td>
                                                <td>{{ $package->date_redirigido }}</td>
                                                <td>
                                                    @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                                                        <a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                                            data-target="#reencaminadoModal{{ $package->id }}">
                                                            <i class="fa fa-arrow-up"></i>
                                                            {{ __('Rencaminado') }}
                                                        </a>
                                                    @endhasrole
                                                    @include('package.modal.reencaminado')
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No se encontraron paquetes redirigidos.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>