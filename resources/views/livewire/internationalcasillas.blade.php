<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card-header">
                <h5 id="card_title">
                    {{ __('PAQUTERIA CERTIFICADA CASILLAS') }}
                </h5>
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="search">Busca:</label>
                                                <input wire:model.lazy="search" type="text" class="form-control"
                                                    placeholder="Buscar...">
                                            </div>
                                        </div>
                                        <!-- Formulario para generar Excel -->
                                        <div class="col-md-5">
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
                                        @hasrole('SuperAdmin|Administrador|Casillas')
                                            <div class="col-md-1">
                                                <button wire:click="cambiarEstado" class="btn btn-warning">Entregar</button>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="{{ route('internationals.create') }}" class="btn btn-primary"
                                                    data-placement="left">
                                                    {{ __('Crear Nuevo') }}
                                                </a>
                                            </div>
                                        @endhasrole
                                        @hasrole('SuperAdmin|Administrador')
                                            <div>
                                                <form wire:submit.prevent="import" class="form-inline">
                                                    <div class="form-group mb-2">
                                                        <label for="fileUpload" class="sr-only">Archivo Excel</label>
                                                        <input type="file" wire:model="file" class="form-control-file"
                                                            id="fileUpload" accept=".xlsx,.xls">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mb-2">Importar</button>
                                                    <a href="{{ route('plantillacasillas.excel') }}"
                                                        class="btn btn-secondary mb-2 ml-2">Descargar Modelo Excel</a>
                                                </form>
                                                @if (session()->has('message'))
                                                    <div class="alert alert-success mt-2">
                                                        {{ session('message') }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endhasrole
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
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Codigo</th>
                                    <th>Destinatario</th>
                                    <th>Telefono</th>
                                    <th>Cuidad</th>
                                    <th>Nro Casillero</th>
                                    <th>Ventanilla</th>
                                    <th>Peso</th>
                                    <th>Tipo</th>
                                    <th>Aduana</th>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1; // Inicializa la variable $i
                                @endphp
                                @foreach ($internationals as $international)
                                    @if (
                                        $international->ESTADO === 'VENTANILLA' &&
                                            $international->CUIDAD === auth()->user()->Regional &&
                                            in_array($international->VENTANILLA, ['CASILLAS']))
                                        <tr>
                                            <td><input type="checkbox" wire:model="paquetesSeleccionados"
                                                    value="{{ $international->id }}"></td>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $international->CODIGO }}</td>
                                            <td>{{ $international->DESTINATARIO }}</td>
                                            <td>{{ $international->TELEFONO }}</td>
                                            <td>{{ $international->CUIDAD }}</td>
                                            <td>{{ $international->ZONA }}</td>
                                            <td>{{ $international->VENTANILLA }}</td>
                                            <td>{{ $international->PESO }}</td>
                                            <td>{{ $international->TIPO }}</td>
                                            <td>{{ $international->ADUANA }}</td>
                                            <td>{{ $international->ESTADO }}</td>
                                            <td>{{ $international->OBSERVACIONES }}</td>
                                            <td>{{ $international->created_at }}</td>
                                            <td>
                                                <div class="d-flex" role="group" aria-label="Acciones">
                                                    @hasrole('SuperAdmin|Administrador|Casillas')
                                                        <a class="btn btn-sm btn-success mr-2"
                                                            href="{{ route('internationals.edit', $international->id) }}">
                                                            <i class="fa fa-fw fa-edit"></i>
                                                            {{ __('Editar') }}
                                                        </a>
                                                        <button wire:click="openPreRezagoModal({{ $international->id }})"
                                                            class="btn btn-sm btn-warning mr-2" data-toggle="modal"
                                                            data-target="#preRezagoModal">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            PRE-REZAGO
                                                        </button>
                                                    @endhasrole
                                                    @hasrole('SuperAdmin|Administrador')
                                                        <form
                                                            action="{{ route('internationals.destroy', $international->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger mr-2">
                                                                <i class="fa fa-fw fa-trash"></i>
                                                                {{ __('Eliminar') }}
                                                            </button>
                                                        </form>
                                                    @endhasrole
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    {{ $internationals->links() }}
                </div>
                <div class="col-md-6 text-right">
                    Se encontraron {{ $internationals->total() }} registros en total
                </div>
            </div>
        </div>
    </div>
    @if ($currentModal === 'prerezago')
        <div wire:ignore.self class="modal fade show d-block" id="preRezagoModal" tabindex="-1" role="dialog"
            aria-labelledby="preRezagoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="preRezagoModalLabel">Cambiar a PRE-REZAGO</h5>
                        <button type="button" class="close" wire:click="$set('currentModal', null)"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea wire:model="observaciones" class="form-control" id="observaciones" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('currentModal', null)">Cerrar</button>
                        <button type="button" wire:click="savePreRezago" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
