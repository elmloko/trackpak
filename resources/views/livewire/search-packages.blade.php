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
                                            {{ __('Paquetes Ordinarios Nacionales') }}
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="search">Busca:</label>
                                                <input wire:model.lazy="search" type="text" class="form-control" placeholder="Buscar...">
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-9 text-right">
                                            <form method="get" action="{{ route('packagesall.excel') }}">
                                                @csrf
                                                <div class="form-row align-items-center">
                                                    <div class="col-md-4">
                                                        <label for="fecha_inicio">Fecha de inicio:</label>
                                                        <input type="date" name="fecha_inicio" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="fecha_fin">Fecha de fin:</label>
                                                        <input type="date" name="fecha_fin" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn btn-success" target="_blank">Generar Excel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <form method="get" action="{{ route('package.pdf.packagesall') }}">
                                                @csrf
                                                <div class="form-row align-items-center">
                                                    <div class="col-md-4">
                                                        <label for="fecha_inicio">Fecha de inicio:</label>
                                                        <input type="date" name="fecha_inicio" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="fecha_fin">Fecha de fin:</label>
                                                        <input type="date" name="fecha_fin" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn btn-danger" target="_blank">Generar PDF</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div> --}}
                                    </div>                                    
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        @php
                                            $i = 0; // Inicializa la variable $i
                                        @endphp
                                        @if ($packages->count())
                                            <table class="table table-striped table-hover">
                                                <thead class="thead">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Código Rastreo</th>
                                                        <th>Destinatario</th>
                                                        <th>Teléfono</th>
                                                        <th>País</th>
                                                        <th>Ciudad</th>
                                                        <th>Ventanilla</th>
                                                        <th>Peso (gr.)</th>
                                                        <th>Tipo</th>
                                                        <th>Estado</th>
                                                        <th>Observaciones</th>
                                                        <th>Aduana</th>
                                                        <th>Ultima Actualizacion</th>
                                                        @hasrole('SuperAdmin|Administrador')
                                                        <th>Acciones</th>
                                                        @endhasrole
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($packages as $package)
                                                        <tr>
                                                            <td>{{ $package->id }}</td>
                                                            <td>{{ $package->CODIGO }}</td>
                                                            <td>{{ $package->DESTINATARIO }}</td>
                                                            <td>{{ $package->TELEFONO }}</td>
                                                            <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                                                            <td>{{ $package->CUIDAD }}</td>
                                                            <td>{{ $package->VENTANILLA }}</td>
                                                            <td>{{ $package->PESO }} </td>
                                                            <td>{{ $package->TIPO }}</td>
                                                            <td>{{ $package->ESTADO }}</td>
                                                            <td>{{ $package->OBSERVACIONES }}</td>
                                                            <td>{{ $package->ADUANA }}</td>
                                                            <td>{{ $package->updated_at }}</td>
                                                            <td>
                                                                <form id="eliminarForm{{ $package->id }}"
                                                                    action="{{ route('packages.destroy', $package->id) }}"
                                                                    method="POST">
                                                                    @hasrole('SuperAdmin|Administrador')
                                                                        <a class="btn btn-sm btn-warning" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#bajaModal{{ $package->id }}">
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            {{ __('Baja') }}
                                                                        </a>
                                                                        @include('package.modal.baja')
                                                                    @endhasrole
                                                                    @hasrole('SuperAdmin|Administrador')
                                                                        <a class="btn btn-sm btn-success"
                                                                            href="{{ route('packages.edit', $package->id) }}">
                                                                            <i class="fa fa-fw fa-edit"></i>
                                                                            {{ __('Editar') }}
                                                                        </a>
                                                                    @endhasrole
                                                                    @hasrole('SuperAdmin|Administrador')
                                                                    @csrf
                                                                    @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm"><i
                                                                                class="fa fa-fw fa-trash"></i>
                                                                            {{ __('Eliminar') }}
                                                                        </button>
                                                                    @endhasrole
                                                                    @hasrole('SuperAdmin|Administrador')
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
                                @else
                                    <p>No se encontraron resultados para la búsqueda.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
