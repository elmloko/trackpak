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
                                                <div class="input-group">
                                                    <input wire:model.lazy="search" type="text" class="form-control" placeholder="Buscar...">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" wire:click="buscarPaquete">Buscar</button>
                                                    </div>
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
                                                        <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll">
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
                                                            <td><input type="checkbox" wire:model="paquetesSeleccionados" value="{{ $package->id }}"></td>
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
                                                                @hasrole('SuperAdmin|Administrador|Unica')
                                                                    <a class="btn btn-sm btn-success" href="{{ route('packages.edit', $package->id) }}">
                                                                        <i class="fa fa-fw fa-edit"></i>
                                                                        {{ __('Editar') }}
                                                                    </a>
                                                                @endhasrole
                                                                @hasrole('SuperAdmin|Administrador|Unica')
                                                                    @if (!$package->redirigido)
                                                                        <a class="btn btn-sm btn-secondary" href="#" data-toggle="modal" data-target="#reencaminarModal{{ $package->id }}">
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
                                        @hasrole('SuperAdmin|Administrador|Unica')
                                            <div class="col-md-12 text-right">
                                                <button wire:click="cambiarEstado" class="btn btn-warning">Guardar</button>
                                            </div>
                                        @endhasrole
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
