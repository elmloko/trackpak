<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h5>{{ __('Inventario de Paquetes en Rezagados en Ventanilla') }}</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="search">Buscar:</label>
                                <input wire:model.lazy="search" type="text" class="form-control" placeholder="Buscar...">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form wire:submit.prevent="export" class="form-row align-items-center">
                                <div class="col-md-4">
                                    <label for="fecha_inicio">Fecha de inicio:</label>
                                    <input type="date" wire:model="fecha_inicio" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha_fin">Fecha de fin:</label>
                                    <input type="date" wire:model="fecha_fin" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success">Generar Excel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">{{ $message }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead">
                            <tr>
                                <th>No</th>
                                <th>Código Rastreo</th>
                                <th>Destinatario</th>
                                <th>Ciudad</th>
                                <th>Ventanilla</th>
                                <th>Peso</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                                <th>Foto</th>
                                <th>Fecha Rezago</th>
                                @hasrole('SuperAdmin|Administrador')
                                <th>Acciones</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp

                            {{-- Listar paquetes nacionales --}}
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $package->CODIGO }}</td>
                                    <td>{{ $package->DESTINATARIO }}</td>
                                    <td>{{ $package->CUIDAD }}</td>
                                    <td>{{ $package->VENTANILLA }}</td>
                                    <td>{{ $package->PESO }} gr.</td>
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
                                        <button wire:click="devolverPaquete({{ $package->id }}, 'Package')" class="btn btn-primary btn-sm">
                                            <i class="fas fa-undo-alt"></i> Devolver
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Listar paquetes internacionales --}}
                            @foreach ($internationals as $international)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $international->CODIGO }}</td>
                                    <td>{{ $international->DESTINATARIO }}</td>
                                    <td>{{ $international->CUIDAD }}</td>
                                    <td>{{ $international->VENTANILLA }}</td>
                                    <td>{{ $international->PESO }} gr.</td>
                                    <td>{{ $international->ESTADO }}</td>
                                    <td>{{ $international->OBSERVACIONES }}</td>
                                    <td></td>
                                    <td>{{ $international->created_at }}</td>
                                    <td>
                                        <button wire:click="devolverPaquete({{ $international->id }}, 'International')" class="btn btn-primary btn-sm">
                                            <i class="fas fa-undo-alt"></i> Devolver
                                        </button>
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
                        Se encontraron {{ $packages->total() + $internationals->total() }} registros en total
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
