<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 id="card_title">{{ __('Entregas de Paquetes para Encomiendas Postales') }}</h5>
                                <div class="col">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="search">Busca:</label>
                                                <input wire:model.lazy="search" type="text" class="form-control"
                                                    placeholder="Buscar...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <!-- Formulario para generar Excel -->
                                                <div class="col-md-9">
                                                    <form method="get" action="{{ route('encomiendas.excel') }}"
                                                        class="col-md-12">
                                                        @csrf
                                                        <div class="form-row">
                                                            <div class="col-md-6">
                                                                <label for="excel_fecha_inicio">Fecha de inicio:</label>
                                                                <input type="date" name="fecha_inicio"
                                                                    class="form-control" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="excel_fecha_fin">Fecha de fin:</label>
                                                                <input type="date" name="fecha_fin"
                                                                    class="form-control" required>
                                                            </div>
                                                            <div class="col-md-12 mt-3 text-center">
                                                                <button type="submit" class="btn btn-success"
                                                                    target="_blank">Generar Excel</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- Formulario para generar PDF -->
                                                <div class="col-md-3">
                                                    <button wire:click="cambiarEstado"
                                                        class="btn btn-warning">Entregar</button>
                                                </div>
                                                @hasrole('SuperAdmin|Administrador')
                                                    <div>
                                                        <form wire:submit.prevent="import" class="form-inline">
                                                            <div class="form-group mb-2">
                                                                <label for="fileUpload" class="sr-only">Archivo
                                                                    Excel</label>
                                                                <input type="file" wire:model="file"
                                                                    class="form-control-file" id="fileUpload"
                                                                    accept=".xlsx,.xls">
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary mb-2">Importar</button>
                                                                <a href="{{ route('plantillae.excel') }}" class="btn btn-secondary mb-2 ml-2">Descargar Modelo Excel</a>
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
                                                    <th>Bandeja</th>
                                                    <th>Teléfono</th>
                                                    {{-- <th>Ciudad</th> --}}
                                                    {{-- <th>Ventanilla</th> --}}
                                                    <th>Peso (gr.)</th>
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
                                                @foreach ($packages as $package)
                                                    @if (
                                                        $package->ESTADO === 'VENTANILLA' &&
                                                            !$package->redirigido &&
                                                            $package->CUIDAD === auth()->user()->Regional &&
                                                            in_array($package->VENTANILLA, ['ENCOMIENDAS']))
                                                        <tr>
                                                            <td><input type="checkbox"
                                                                    wire:model="paquetesSeleccionados"
                                                                    value="{{ $package->id }}"></td>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $package->CODIGO }}</td>
                                                            <td>{{ $package->DESTINATARIO }}</td>
                                                            <td>{{ $package->ZONA }}</td>
                                                            <td>{{ $package->TELEFONO }}</td>
                                                            <td>{{ $package->PESO }}</td>
                                                            <td>{{ $package->ESTADO }}</td>
                                                            <td>{{ $package->OBSERVACIONES }}</td>
                                                            <td>{{ $package->created_at }}</td>
                                                            <td>
                                                                @hasrole('SuperAdmin|Administrador|ENCOMIENDAS')
                                                                    <a class="btn btn-sm btn-success"
                                                                        href="{{ route('packages.edit', $package->id) }}">
                                                                        <i class="fa fa-fw fa-edit"></i>
                                                                        {{ __('Editar') }}
                                                                    </a>
                                                                    <button wire:click="openModal({{ $package->id }})" class="btn btn-sm btn-info">
                                                                        <i class="fa fa-edit"></i> Reencaminar
                                                                    </button>
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
    @if($selectedPackageId)
        <div class="modal show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Actualizar Paquete</h5>
                        <button type="button" class="close" wire:click="$set('selectedPackageId', null)" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                                <input type="text" wire:model="observaciones" class="form-control" id="observaciones">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('selectedPackageId', null)">Cerrar</button>
                        <button type="button" wire:click="updatePackage" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
