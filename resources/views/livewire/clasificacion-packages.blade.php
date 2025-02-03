<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 id="card_title">{{ __('Registro de Paquetes Ordinarios') }}</h5>
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label for="cityFilter">Filtrar por Ciudad:</label>
                            <select wire:model="selectedCity" class="form-control" id="cityFilter">
                                <option value=""></option>
                                <option value="LA PAZ">LA PAZ</option>
                                <option value="COCHABAMBA">COCHABAMBA</option>
                                <option value="SANTA CRUZ">SANTA CRUZ</option>
                                <option value="ORURO">ORURO</option>
                                <option value="POTOSI">POTOSI</option>
                                <option value="SUCRE">SUCRE</option>
                                <option value="BENI">BENI</option>
                                <option value="PANDO">PANDO</option>
                                <option value="TARIJA">TARIJA</option>
                                <!-- Agrega más opciones según tus necesidades -->
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search">Busca:</label>
                                <input wire:model.lazy="search" type="text" class="form-control"
                                    placeholder="Buscar...">
                            </div>
                        </div>
                        
                        <div class="col-md-6 text-right">
                            @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                                <a href="{{ route('packages.create') }}" class="btn btn-primary" data-placement="left">
                                    {{ __('Crear Nuevo') }}
                                </a>
                                <button wire:click="cambiarEstado" class="btn btn-warning">
                                    {{ __('Despachar') }}
                                </button>
                            @endhasrole
                        </div>
                        <div class="col-md-3">
                            <button wire:click="abrirModal" class="btn btn-primary">Generar Manifiesto</button>
    
                            @if ($showModal)
                                <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Generar Manifiesto</h5>
                                                <button type="button" class="close" wire:click="cerrarModal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <label for="codigoManifiesto">Código de Manifiesto:</label>
                                                <input type="text" class="form-control" wire:model="codigoManifiesto">
                                                @if(session()->has('error'))
                                                    <div class="alert alert-danger mt-2">
                                                        {{ session('error') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cerrar</button>
                                                <button type="button" class="btn btn-success" wire:click="generarPDF">Generar PDF</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                        @if ($packages->count())
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
                                        <th>Ventanilla</th>
                                        <th>Peso (gr.)</th>
                                        <th>Tipo</th>
                                        <th>Nro Casilla</th>
                                        <th>Estado</th>
                                        <th>Observaciones</th>
                                        <th>Aduana</th>
                                        <th>Foto</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1; // Inicializa la variable $i
                                    @endphp
                                    @foreach ($packages as $package)
                                        @if ($package->ESTADO === 'CLASIFICACION')
                                            <tr>
                                                <td><input type="checkbox" wire:model="paquetesSeleccionados"
                                                        value="{{ $package->id }}"></td>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $package->CODIGO }}</td>
                                                <td>{{ $package->DESTINATARIO }}</td>
                                                <td>{{ $package->TELEFONO }}</td>
                                                <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                                                <td>{{ $package->CUIDAD }}</td>
                                                <td>
                                                    {{ $package->VENTANILLA === 'ENCOMIENDAS' ? 'VENTANILLA 7' : $package->VENTANILLA }}
                                                </td>
                                                <td>{{ $package->PESO }}</td>
                                                <td>{{ $package->TIPO }}</td>
                                                <td>{{ $package->nrocasilla }}</td>
                                                <td>{{ $package->ESTADO }}</td>
                                                <td>{{ $package->OBSERVACIONES }}</td>
                                                <td>{{ $package->ADUANA }}</td>
                                                <td>
                                                    @if ($package->foto)
                                                        <img src="{{ $package->foto }}" alt="Foto" class="bg-white"
                                                            style="width: 200px; height: auto; border: 1px solid #ccc; padding: 5px;">
                                                    @else
                                                        <p></p>
                                                    @endif
                                                </td>
                                                <td>{{ $package->created_at }}</td>
                                                <td>
                                                    @hasrole('SuperAdmin|Administrador|Clasificacion')
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <a class="btn btn-sm btn-success"
                                                                    href="{{ route('packages.edit', $package->id) }}">
                                                                    <i class="fa fa-fw fa-edit"></i>
                                                                    {{ __('Editar') }}
                                                                </a>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button wire:click="eliminarPaquete({{ $package->id }})"
                                                                    class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash-alt"></i> Eliminar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endhasrole
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
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