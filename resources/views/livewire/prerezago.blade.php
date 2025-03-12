<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 id="card_title">{{ __('Pre-Rezago de Paquetes Ordinarios') }}</h5>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search">Busca:</label>
                                    <input wire:model.lazy="search" type="text" class="form-control"
                                        placeholder="Buscar...">
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                @hasrole('SuperAdmin|Administrador|Urbano')
                                    <button wire:click="cambiarEstado" class="btn btn-warning">Almacenar</button>
                                @endhasrole
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
                                                <input type="checkbox" wire:model="selectAll"
                                                    wire:click="toggleSelectAll">
                                            </th>
                                            <th>Código Rastreo</th>
                                            <th>Destinatario</th>
                                            <th>Teléfono</th>
                                            <th>Ciudad</th>
                                            <th>Ventanilla</th>
                                            <th>Peso (gr.)</th>
                                            <th>Estado</th>
                                            <th>Observaciones</th>
                                            <th>Foto</th>
                                            <th>Fecha Pre-rezago</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($packages as $package)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" wire:model="paquetesSeleccionados"
                                                        value="{{ $package->id }}">
                                                </td>
                                                <td>{{ $package->CODIGO }}</td>
                                                <td>{{ $package->DESTINATARIO }}</td>
                                                <td>{{ $package->TELEFONO }}</td>
                                                <td>{{ $package->CUIDAD }}</td>
                                                <td>{{ $package->VENTANILLA }}</td>
                                                <td>{{ $package->PESO }}</td>
                                                <td>{{ $package->ESTADO }}</td>
                                                <td>{{ $package->OBSERVACIONES }}</td>
                                                <td>
                                                                @if ($package->foto)
                                                                    <a href="{{ $package->foto }}" download="foto.png" class="btn btn-sm btn-secondary">Descargar</a>
                                                                @else
                                                                    <p></p>
                                                                @endif
                                                            </td>
                                                <td>{{ $package->created_at }}</td>
                                                <td>
                                                    <button wire:click="devolverPaquete({{ $package->id }})" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-undo-alt"></i> Devolver
                                                    </button>
                                                </td>
                                            </tr>
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
</div>
