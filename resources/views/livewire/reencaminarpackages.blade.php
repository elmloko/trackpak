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
                                            <input wire:model.lazy="search" type="text" class="form-control"
                                                placeholder="Buscar...">
                                        </div>
                                    </div>
                                    <div class="mr-2 d-inline-block">
                                        <a href="{{ route('reencaminar.excel') }}" class="btn btn-success"
                                            data-placement="left">
                                            Excel
                                        </a>
                                        <form method="get" action="{{ route('package.pdf.redirigidospdf') }}">
                                            @csrf
                                            <div class="form-row align-items-center">
                                                <div class="col-md-4">
                                                    <label for="fecha_inicio">Fecha de inicio:</label>
                                                    <input type="date" name="fecha_inicio" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="fecha_fin">Fecha de fin:</label>
                                                    <input type="date" name="fecha_fin" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-danger">Generar
                                                        PDF</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            @if ($packages->count() > 0)
                                <table class="table table-striped table-hover">
                                    <thead class="thead">
                                        <tr>
                                            <th>No</th>
                                            <th>Código Rastreo</th>
                                            <th>Destinatario</th>
                                            <th>País</th>
                                            <th>Destino Cuidad</th>
                                            <th>Tipo</th>
                                            <th>Peso</th>
                                            <th>Estado</th>
                                            <th>Observaciones</th>
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
                                                    <td>{{ $package->PESO }} gr.</td>
                                                    <td>{{ $package->ESTADO }}</td>
                                                    <td>{{ $package->OBSERVACIONES }}</td>
                                                    <td>{{ $package->date_redirigido }}</td>
                                                    <td>
                                                        @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar
                                                            Clasificacion')
                                                            <a class="btn btn-sm btn-info" href="#"
                                                                data-toggle="modal"
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
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        {{ $packages->links() }}
                                    </div>
                                    <div class="col-md-6 text-right">
                                        Se encontraron {{ $packages->total() }} registros en total
                                    </div>
                                </div>
                            @else
                                <p>No hay elementos eliminados.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
