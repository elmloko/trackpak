<div>
    <!-- Contenido de la vista -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 id="card_title">{{ __('Recibir Correspondencia en Ventanilla') }}</h5>
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
                                                        <th>País</th>
                                                        <th>Ciudad</th>
                                                        <th>Zonificación</th>
                                                        <th>Peso (Kg.)</th>
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
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($packages as $package)
                                                        <tr>
                                                            <td><input type="checkbox" wire:model="paquetesSeleccionados" value="{{ $package->id }}"></td>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $package->CODIGO }}</td>
                                                            <td>{{ $package->DESTINATARIO }}</td>
                                                            <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                                                            <td>{{ $package->CUIDAD }}</td>
                                                            <td>{{ $package->ZONA }}</td>
                                                            <td>{{ $package->PESO }} </td>
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

    <!-- Modal para editar la ZONA -->
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar ZONA</h5>
                        <button type="button" class="close" wire:click="cerrarModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="zona">ZONA</label>
                            <input type="text" class="form-control" id="zona" wire:model.defer="zona">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cerrar</button>
                        <button type="button" class="btn btn-primary" wire:click="guardarZona">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
