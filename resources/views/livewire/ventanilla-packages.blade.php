<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div>
                                    <h5 id="card_title">
                                        {{ __('Entregas de Paquetes en Ventanilla') }}
                                    </h5>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="search">Busca:</label>
                                                <input wire:model.lazy="search" type="text" class="form-control"
                                                    placeholder="Buscar..." wire:loading.attr="disabled">
                                                <div wire:loading>
                                                    Processing Payment...
                                                </div>
                                            </div>
                                        </div>
                                        @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                                            <div class="ml-2 d-inline-block float-right">
                                                <!-- Botón para abrir el modal de cambio de estado -->
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#buscarPaqueteModal">
                                                    Añadir Paquete
                                                </button>
                                                @include('package.modal.ventanilla')
                                            </div>
                                        @endhasrole
                                    </div>
                                    <div class="row">
                                        <form method="get" action="{{ route('ventanilla.excel') }}" class="col-md-4">
                                            @csrf
                                            <div class="form-row align-items-center">
                                                <div class="col-md-3">
                                                    <label for="excel_fecha_inicio">Fecha de inicio:</label>
                                                    <input type="date" name="fecha_inicio" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="excel_fecha_fin">Fecha de fin:</label>
                                                    <input type="date" name="fecha_fin" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="ventanilla">Seleccionar Ventanilla:</label>
                                                    <select name="ventanilla" class="form-control">
                                                        @if (auth()->user()->Regional == 'LA PAZ')
                                                            <option value="DD">DD</option>
                                                            <option value="DND">DND</option>
                                                            <option value="CASILLAS">CASILLAS</option>
                                                            <option value="ECA">ECA</option>
                                                        @else
                                                            <option value="UNICA">UNICA</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-success"
                                                        target="_blank">Generar Excel</button>
                                                </div>
                                            </div>
                                        </form>
                                        <form method="get" action="{{ route('package.pdf.ventanillapdf') }}"
                                            class="col-md-4">
                                            @csrf
                                            <div class="form-row align-items-center">
                                                <div class="col-md-3">
                                                    <label for="fecha_inicio">Fecha de inicio:</label>
                                                    <input type="date" name="fecha_inicio" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="fecha_fin">Fecha de fin:</label>
                                                    <input type="date" name="fecha_fin" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="ventanilla">Seleccionar Ventanilla:</label>
                                                    <select name="ventanilla" class="form-control">
                                                        @if (auth()->user()->Regional == 'LA PAZ')
                                                            <option value="DD">DD</option>
                                                            <option value="DND">DND</option>
                                                            <option value="CASILLAS">CASILLAS</option>
                                                            <option value="ECA">ECA</option>
                                                        @else
                                                            <option value="UNICA">UNICA</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-danger">Generar
                                                        PDF</button>
                                                </div>
                                            </div>
                                        </form>
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
                                                    <th>Código Rastreo</th>
                                                    <th>Destinatario</th>
                                                    <th>Teléfono</th>
                                                    <th>País</th>
                                                    <th>Ciudad</th>
                                                    <th>Dirección</th>
                                                    <th>Ventanilla</th>
                                                    <th>Peso</th>
                                                    <th>Precio</th>
                                                    <th>Tipo</th>
                                                    <th>Estado</th>
                                                    <th>Observaciones</th>
                                                    <th>Aduana</th>
                                                    <th>Fecha Pendiente</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1; // Inicializa la variable $i
                                                @endphp
                                                @foreach ($packages as $package)
                                                    @if ($package->ESTADO === 'VENTANILLA' && !$package->redirigido && $package->CUIDAD === auth()->user()->Regional)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $package->CODIGO }}</td>
                                                            <td>{{ $package->DESTINATARIO }}</td>
                                                            <td>{{ $package->TELEFONO }}</td>
                                                            <td>{{ $package->PAIS }}</td>
                                                            <td>{{ $package->CUIDAD }}</td>
                                                            <td>{{ $package->ZONA }}</td>
                                                            <td>{{ $package->VENTANILLA }}</td>
                                                            <td>{{ $package->PESO }} gr.</td>
                                                            <td>{{ $package->PRECIO }} Bs.</td>
                                                            <td>{{ $package->TIPO }}</td>
                                                            <td>{{ $package->ESTADO }}</td>
                                                            <td>{{ $package->OBSERVACIONES }}</td>
                                                            <td>{{ $package->ADUANA }}</td>
                                                            <td>{{ $package->updated_at }}</td>
                                                            <td>
                                                                <form
                                                                    action="{{ route('packages.destroy', $package->id) }}"
                                                                    method="POST">
                                                                    @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar
                                                                        Urbano')
                                                                        <a class="btn btn-sm btn-warning" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#bajaModal{{ $package->id }}">
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            {{ __('Baja') }}
                                                                        </a>
                                                                        @include('package.modal.baja')
                                                                    @endhasrole
                                                                    @hasrole('SuperAdmin|Administrador|Urbano')
                                                                        <a class="btn btn-sm btn-success"
                                                                            href="{{ route('packages.edit', $package->id) }}">
                                                                            <i class="fa fa-fw fa-edit"></i>
                                                                            {{ __('Editar') }}
                                                                        </a>
                                                                    @endhasrole
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    @hasrole('SuperAdmin|Administrador|Urbano')
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

