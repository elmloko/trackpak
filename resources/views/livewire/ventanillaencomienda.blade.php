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
                                                    <form wire:submit.prevent="export"
                                                        class="form-row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="fecha_inicio">Fecha de inicio:</label>
                                                            <input type="date" wire:model="fecha_inicio"
                                                                class="form-control" required>
                                                            @error('fecha_inicio')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="fecha_fin">Fecha de fin:</label>
                                                            <input type="date" wire:model="fecha_fin"
                                                                class="form-control" required>
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
                                                            <a href="{{ route('plantillae.excel') }}"
                                                                class="btn btn-secondary mb-2 ml-2">Descargar Modelo
                                                                Excel</a>
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
                                                    <th>Peso (gr.)</th>
                                                    <th>Aduana</th>
                                                    <th>Estado</th>
                                                    <th>Observaciones</th>
                                                    <th>Foto</th>
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
                                                            <td>{{ $package->ADUANA }}</td>
                                                            <td>{{ $package->ESTADO }}</td>
                                                            <td>{{ $package->OBSERVACIONES }}</td>
                                                            <td>
                                                                @if ($package->foto)
                                                                    <img src="{{ $package->foto }}" alt="Foto" class="bg-white"
                                                                        style="width: 100px; height: auto; border: 1px solid #ccc; padding: 5px;">
                                                                @else
                                                                    <p></p>
                                                                @endif
                                                            </td>
                                                            <td>{{ $package->created_at }}</td>
                                                            <td>
                                                                @hasrole('SuperAdmin|Administrador|ENCOMIENDAS')
                                                                    <div class="d-flex" role="group"
                                                                        aria-label="Acciones">
                                                                        <a class="btn btn-sm btn-success"
                                                                            href="{{ route('packages.edit', $package->id) }}"
                                                                            style="margin-right: 10px;">
                                                                            <i class="fa fa-fw fa-edit"></i>
                                                                            {{ __('Editar') }}
                                                                        </a>
                                                                        <button wire:click="openModal({{ $package->id }})"
                                                                            class="btn btn-sm btn-info mr-2">
                                                                            <i class="fa fa-edit"></i> Reencaminar
                                                                        </button>
                                                                        <button
                                                                            wire:click="openPreRezagoModal({{ $package->id }})"
                                                                            class="btn btn-sm btn-warning "
                                                                            data-toggle="modal"
                                                                            data-target="#preRezagoModal">
                                                                            <i class="fas fa-exclamation-circle"></i>
                                                                            PRE-REZAGO
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
    @if ($currentModal === 'reencaminar')
        <div class="modal show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reencaminar Paquete</h5>
                        <button type="button" class="close" wire:click="$set('currentModal', null)"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <p>Donde se debe reencaminar el paquete?</p>
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
                            wire:click="$set('currentModal', null)">Cerrar</button>
                        <button type="button" wire:click="updatePackage" class="btn btn-primary">Guardar
                            cambios</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                                <select wire:model="observaciones" class="form-control" id="observaciones">
                                    <option value="">Seleccione una opción</option>
                                    <option value="Articulo rechazado por el destinatario">Artículo rechazado por el destinatario</option>
                                    <option value="Fallecido">Fallecido</option>
                                    <option value="No Reclamado">No reclamado</option>
                                    <option value="El Destinatario desistio paquete marca de aduana">El Destinatario desistió paquete marca de aduana</option>
                                </select>
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
