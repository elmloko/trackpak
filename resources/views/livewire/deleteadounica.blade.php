<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 id="card_title">
                                    {{ __('Inventario de Paquetes en Entregados en Ventanilla') }}
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="search">Busca:</label>
                                    <input wire:model.lazy="search" type="text" class="form-control"
                                        placeholder="Buscar...">
                                </div>
                            </div>
                            <form wire:submit.prevent="export" class="form-row align-items-center">
                                <div class="col-md-4">
                                    <label for="fecha_inicio">Fecha de inicio:</label>
                                    <input type="date" wire:model="fecha_inicio" class="form-control" required>
                                    @error('fecha_inicio')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha_fin">Fecha de fin:</label>
                                    <input type="date" wire:model="fecha_fin" class="form-control" required>
                                    @error('fecha_fin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success">Generar Excel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($packages->count() > 0)
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Código Rastreo</th>
                                        <th>Destinatario</th>
                                        <th>Telefono</th>
                                        <th>Pais</th>
                                        <th>Ciudad</th>
                                        <th>Dirección</th>
                                        <th>Ventanilla</th>
                                        <th>Peso</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Observaciones</th>
                                        <th>Aduana</th>
                                        <th>Fecha Baja</th>
                                        <th>Acciones</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @foreach ($packages as $package)
                                        @if ($package->ESTADO !== 'DOMICILIO')
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $package->CODIGO }}</td>
                                                <td>{{ $package->DESTINATARIO }}</td>
                                                <td>{{ $package->TELEFONO }}</td>
                                                <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                                                <td>{{ $package->CUIDAD }}</td>
                                                <td>{{ $package->ZONA }}</td>
                                                <td>{{ $package->VENTANILLA }}</td>
                                                <td>{{ $package->PESO }} gr.</td>
                                                <td>{{ $package->TIPO }}</td>
                                                <td>{{ $package->ESTADO }}</td>
                                                <td>{{ $package->OBSERVACIONES }}</td>
                                                <td>{{ $package->ADUANA }}</td>
                                                <td>{{ $package->deleted_at }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        {{-- @hasrole('SuperAdmin|Administrador')
                                                            <button wire:click="restorePackage({{ $package->id }})"
                                                                class="btn btn-sm btn-info">
                                                                <i class="fa fa-arrow-up"></i> {{ __('Alta') }}
                                                            </button>
                                                        @endhasrole --}}
                                                        @hasrole('SuperAdmin|Administrador|Unica')
                                                            <button wire:click="reprintPDF({{ $package->id }})"
                                                                class="btn btn-sm btn-warning">
                                                                <i class="fa fa-print"></i> Reimprimir
                                                            </button>
                                                        @endhasrole
                                                    </div>
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
                @else
                    <p>No hay elementos eliminados.</p>
                @endif
            </div>
        </div>
    </div>
</div>
