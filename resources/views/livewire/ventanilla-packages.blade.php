<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div>
                                        <h5 id="card_title">
                                            {{ __('Entregas de Paquetes en Ventanilla') }}
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <input wire:model.lazy="searchv" type="text" class="form-control"
                                                    placeholder="Buscar...">
                                            </div>
                                        </div>
                                        <div class="col-lg-9 text-right">
                                            <div class="mr-2 d-inline-block">
                                                <a href="{{ route('ventanilla.excel') }}" class="btn btn-success"
                                                    data-placement="left">
                                                    Excel
                                                </a>
                                            </div>
                                            <div class="mr-2 d-inline-block">
                                                <a href="{{ route('ventanilla.pdf') }}" class="btn btn-danger"
                                                    data-placement="left">
                                                    PDF
                                                </a>
                                            </div>
                                            <div class="mr-2 d-inline-block">
                                                <!-- Botón para abrir el modal de cambio de estado -->
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#buscarPaqueteModal">
                                                    Añadir Paquete
                                                </button>
                                                @include('package.modal.ventanilla')
                                            </div>
                                            {{-- @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                                                <div class="d-inline-block">
                                                    <a href="{{ route('packages.create') }}" class="btn btn-primary btn-sm"
                                                        data-placement="left">
                                                        {{ __('Crear Nuevo') }}
                                                    </a>
                                                </div>
                                            @endhasrole --}}
                                        </div>
                                    </div>
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            <p>{{ $message }}</p>
                                        </div>
                                    @elseif ($message = Session::get('error'))
                                        <div class="alert alert-danger">
                                            <p>{{ $message }}</p>
                                        </div>
                                    @endif

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead class="thead">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Código Postal</th>
                                                        <th>Destinatario</th>
                                                        <th>Teléfono</th>
                                                        <th>País</th>
                                                        <th>Ciudad</th>
                                                        <th>Zona</th>
                                                        <th>Ventanilla</th>
                                                        <th>Peso</th>
                                                        <th>Tipo</th>
                                                        <th>Estado</th>
                                                        <th>Aduana</th>
                                                        <th>Fecha Ingreso</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1; // Inicializa la variable $i
                                                    @endphp
                                                    @foreach ($packages as $package)
                                                        @if ($package->ESTADO === 'VENTANILLA' && !$package->redirigido)
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td>{{ $package->CODIGO }}</td>
                                                                <td>{{ $package->DESTINATARIO }}</td>
                                                                <td>{{ $package->TELEFONO }}</td>
                                                                <td>{{ $package->PAIS }}</td>
                                                                <td>{{ $package->CUIDAD }}</td>
                                                                <td>{{ $package->ZONA }}</td>
                                                                <td>{{ $package->VENTANILLA }}</td>
                                                                <td>{{ $package->PESO }}</td>
                                                                <td>{{ $package->TIPO }}</td>
                                                                <td>{{ $package->ESTADO }}</td>
                                                                <td>{{ $package->ADUANA }}</td>
                                                                <td>{{ $package->created_at }}</td>
                                                                <td>
                                                                    <form
                                                                        action="{{ route('packages.destroy', $package->id) }}"
                                                                        method="POST">
                                                                        @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                                                                            <a class="btn btn-sm btn-warning"
                                                                                href="#" data-toggle="modal"
                                                                                data-target="#bajaModal{{ $package->id }}">
                                                                                <i class="fa fa-arrow-down"></i>
                                                                                {{ __('Baja') }}
                                                                            </a>
                                                                            @include('package.modal.baja')
                                                                        @endhasrole
                                                                        @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano|Clasificacion|Auxiliar Clasificacion')
                                                                            <a class="btn btn-sm btn-success"
                                                                                href="{{ route('packages.edit', $package->id) }}">
                                                                                <i class="fa fa-fw fa-edit"></i>
                                                                                {{ __('Editar') }}
                                                                            </a>
                                                                        @endhasrole
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                                                                            @if (!$package->redirigido)
                                                                                <a class="btn btn-sm btn-secondary"
                                                                                    href="#" data-toggle="modal"
                                                                                    data-target="#reencaminarModal{{ $package->id }}">
                                                                                    <i class="fas fa-arrow-up"></i>
                                                                                    {{ __('Reencaminar') }}
                                                                                </a>
                                                                                @include('package.modal.reencaminar')
                                                                            @endif
                                                                        @endhasrole
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                {{ $packages->links() }}
                                            </div>
                                            <div class="col-md-6 text-right">
                                                Se encontraron {{ $packages->total() }} registros en total
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>