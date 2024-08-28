<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 id="card_title">{{ __('Entregas de Paquetes para Casillas Postales') }}</h5>
                                <div class="col">
                                    <div class="row align-items-center">
                                        @hasrole('SuperAdmin|Administrador|Casillas')
                                            <div class="col-md-12 text-right">
                                                <button wire:click="cambiarEstado" class="btn btn-warning">Entregar</button>
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#buscarPaqueteModal">
                                                    Añadir Paquete
                                                </button>
                                                @include('package.modal.ventanillacasilla')
                                            </div>
                                        @endhasrole
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="search">Busca:</label>
                                                <input wire:model.lazy="search" type="text" class="form-control"
                                                    placeholder="Buscar...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <form wire:submit.prevent="export" class="form-row align-items-center">
                                                <div class="col-md-4">
                                                    <label for="fecha_inicio">Fecha de inicio:</label>
                                                    <input type="date" wire:model="fecha_inicio" class="form-control"
                                                        required>
                                                    @error('fecha_inicio')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="fecha_fin">Fecha de fin:</label>
                                                    <input type="date" wire:model="fecha_fin" class="form-control"
                                                        required>
                                                    @error('fecha_fin')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-success">Generar
                                                        Excel</button>
                                                </div>
                                            </form>
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
                                                    <th></th>
                                                    <th>No</th>
                                                    <th>Nro de Casillero</th>
                                                    <th>Código Rastreo</th>
                                                    <th>Destinatario</th>
                                                    <th>Teléfono</th>
                                                    <th>País</th>
                                                    <th>Ciudad</th>
                                                    <th>Ubicacion</th>
                                                    <th>Peso (gr.)</th>
                                                    <th>Tipo</th>
                                                    <th>Estado</th>
                                                    <th>Aduana</th>
                                                    <th>Observaciones</th>
                                                    <th>Fecha Pendiente</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1; // Inicializa la variable $i
                                                @endphp
                                                @foreach ($packages as $package)
                                                    @if (
                                                        $package->ESTADO === 'VENTANILLA' &&
                                                            !$package->redirigido &&
                                                            $package->CUIDAD === auth()->user()->Regional &&
                                                            in_array($package->VENTANILLA, ['CASILLAS']))
                                                        <tr>
                                                            <td><input type="checkbox"
                                                                    wire:model="paquetesSeleccionados"
                                                                    value="{{ $package->id }}"></td>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $package->nrocasilla }}</td>
                                                            <td>{{ $package->CODIGO }}</td>
                                                            <td>{{ $package->DESTINATARIO }}</td>
                                                            <td>{{ $package->TELEFONO }}</td>
                                                            <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                                                            <td>{{ $package->CUIDAD }}</td>
                                                            <td>{{ $package->ZONA }}</td>
                                                            <td>{{ $package->PESO }} </td>
                                                            <td>{{ $package->TIPO }}</td>
                                                            <td>{{ $package->ESTADO }}</td>
                                                            <td>{{ $package->ADUANA }}</td>
                                                            <td>{{ $package->OBSERVACIONES }}</td>
                                                            <td>{{ $package->updated_at }}</td>
                                                            <td>
                                                                @hasrole('SuperAdmin|Administrador|Casillas')
                                                                    <div class="d-flex" role="group"
                                                                        aria-label="Acciones">
                                                                        <a class="btn btn-sm btn-success"
                                                                            href="{{ route('packages.edit', $package->id) }}"
                                                                            style="margin-right: 10px;">
                                                                            <i class="fa fa-fw fa-edit"></i>
                                                                            {{ __('Editar') }}
                                                                        </a>
                                                                        <button wire:click="openModal({{ $package->id }})"
                                                                            class="btn btn-sm btn-info">
                                                                            <i class="fa fa-edit"></i> Reencaminar
                                                                        </button>
                                                                    </div>
                                                                @endhasrole
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

    <!-- Modal -->
    @if ($selectedPackageId)
        <div class="modal show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reencaminar Paquete</h5>
                        <button type="button" class="close" wire:click="$set('selectedPackageId', null)"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Donde se debe reencaminar el paquete?</p>
                        <form>
                            <div class="form-group">
                                <label for="city">Ciudad</label>
                                <select wire:model="selectedCity" class="form-control" id="city">
                                    <option value="">Seleccione una ciudad</option>
                                    <option value="LA PAZ">LA PAZ</option>
                                    <option value="COCHABAMBA">COCHABAMBA</option>
                                    <option value="SANTA CRUZ">SANTA CRUZ</option>
                                    <option value="ORURO">ORURO</option>
                                    <option value="POTOSI">POTOSI</option>
                                    <option value="SUCRE">SUCRE</option>
                                    <option value="BENI">BENI</option>
                                    <option value="PANDO">PANDO</option>
                                    <option value="TARIJA">TARIJA</option>
                                    <!-- Añade las ciudades necesarias -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <input type="text" wire:model="observaciones" class="form-control"
                                    id="observaciones">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('selectedPackageId', null)">Cerrar</button>
                        <button type="button" wire:click="updatePackage" class="btn btn-primary">Guardar
                            cambios</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
