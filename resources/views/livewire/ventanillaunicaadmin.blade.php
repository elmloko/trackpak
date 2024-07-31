    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 id="card_title">{{ __('Entregas de Paquetes en Ventanilla UNICA') }}</h5>
                                    <div class="col">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="search">Busca:</label>
                                                    <input wire:model.lazy="search" type="text" class="form-control"
                                                        placeholder="Buscar...">
                                                </div>
                                            </div>
                                            @hasrole('SuperAdmin|Administrador|Unica')
                                                <div class="col-md-6 text-right">
                                                    <button wire:click="cambiarEstado"
                                                        class="btn btn-warning">Entregar</button>
                                                    <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#buscarPaqueteModal">
                                                        Añadir Paquete
                                                    </button>
                                                    @include('package.modal.ventanilla')
                                                </div>
                                            @endhasrole
                                            @hasrole('SuperAdmin|Administrador')
                                                <div>
                                                    <form wire:submit.prevent="import" class="form-inline">
                                                        <div class="form-group mb-2">
                                                            <label for="fileUpload" class="sr-only">Archivo Excel</label>
                                                            <input type="file" wire:model="file"
                                                                class="form-control-file" id="fileUpload"
                                                                accept=".xlsx,.xls">
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-primary mb-2">Importar</button>
                                                        <a href="{{ route('plantillaunica.excel') }}"
                                                            class="btn btn-secondary mb-2 ml-2">Descargar Modelo Excel</a>
                                                    </form>
                                                    @if (session()->has('message'))
                                                        <div class="alert alert-success mt-2">
                                                            {{ session('message') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endhasrole
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <!-- Formulario para generar Excel -->
                                                    <div class="col-md-6">
                                                        <form method="get" wire:submit.prevent="exportExcel" class="col-md-12">
                                                            @csrf
                                                            <div class="form-row">
                                                                <div class="col-md-6">
                                                                    <label for="fecha_inicio">Fecha de inicio:</label>
                                                                    <input type="date" wire:model="fechaInicio" class="form-control" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="fecha_fin">Fecha de fin:</label>
                                                                    <input type="date" wire:model="fechaFin" class="form-control" required>
                                                                </div>
                                                                <div class="col-md-12 mt-3 text-center">
                                                                    <button type="submit" class="btn btn-success" target="_blank">Generar Excel</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <!-- Formulario para generar PDF -->
                                                    <div class="col-md-6">
                                                        <form method="get"
                                                            action="{{ route('package.pdf.ventanillapdf') }}"
                                                            class="col-md-12">
                                                            @csrf
                                                            <div class="form-row">
                                                                <div class="col-md-4">
                                                                    <label for="fecha_inicio">Fecha de inicio:</label>
                                                                    <input type="date" name="fecha_inicio"
                                                                        class="form-control" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="fecha_fin">Fecha de fin:</label>
                                                                    <input type="date" name="fecha_fin"
                                                                        class="form-control" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="ventanilla">Ventanilla:</label>
                                                                    <select name="ventanilla" class="form-control">
                                                                        @if (auth()->user()->Regional == 'LA PAZ')
                                                                            <option value="DD">DD</option>
                                                                        @else
                                                                            <option value="UNICA">UNICA</option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-12 mt-3 text-center">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Generar
                                                                        PDF</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

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
                                                        <th>
                                                            {{-- <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll"> --}}
                                                        </th>
                                                        <th>No</th>
                                                        <th>Código Rastreo</th>
                                                        <th>Destinatario</th>
                                                        <th>Teléfono</th>
                                                        <th>País</th>
                                                        <th>Ciudad</th>
                                                        <th>Zonificacion</th>
                                                        {{-- <th>Ventanilla</th> --}}
                                                        <th>Peso (Kg.)</th>
                                                        <th>Precio(Bs.)</th>
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
                                                        <tr>
                                                            <td><input type="checkbox"
                                                                    wire:model="paquetesSeleccionados"
                                                                    value="{{ $package->id }}"></td>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $package->CODIGO }}</td>
                                                            <td>{{ $package->DESTINATARIO }}</td>
                                                            <td>{{ $package->TELEFONO }}</td>
                                                            <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                                                            <td>{{ $package->CUIDAD }}</td>
                                                            <td>{{ $package->ZONA }}</td>
                                                            {{-- <td>{{ $package->VENTANILLA }}</td> --}}
                                                            <td>{{ $package->PESO }} </td>
                                                            <td>{{ $package->PRECIO }} </td>
                                                            <td>{{ $package->TIPO }}</td>
                                                            <td>{{ $package->ESTADO }}</td>
                                                            <td>{{ $package->OBSERVACIONES }}</td>
                                                            <td>{{ $package->ADUANA }}</td>
                                                            <td>{{ $package->updated_at }}</td>
                                                            <td>
                                                                {{-- @hasrole('SuperAdmin|Administrador|Unica')
                                                                        <a class="btn btn-sm btn-warning" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#bajaModal{{ $package->id }}">
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            {{ __('Baja') }}
                                                                        </a>
                                                                        @include('package.modal.baja')
                                                                    @endhasrole --}}
                                                                @hasrole('SuperAdmin|Administrador|Unica')
                                                                    <a class="btn btn-sm btn-success"
                                                                        href="{{ route('packages.edit', $package->id) }}">
                                                                        <i class="fa fa-fw fa-edit"></i>
                                                                        {{ __('Editar') }}
                                                                    </a>
                                                                @endhasrole
                                                                @hasrole('SuperAdmin|Administrador|Unica')
                                                                    @if (!$package->redirigido)
                                                                        <a class="btn btn-sm btn-secondary" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#reencaminarModal{{ $package->id }}">
                                                                            <i class="fas fa-arrow-up"></i>
                                                                            {{ __('Reencaminar') }}
                                                                        </a>
                                                                        @include('package.modal.reencaminar')
                                                                    @endif
                                                                @endhasrole
                                                            </td>
                                                        </tr>
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
