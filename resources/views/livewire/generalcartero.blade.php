<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <h5 id="card_title">
                                {{ __('Inventario de Paquetes Generales Entregados de Todos Carteros') }}
                            </h5>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="buscar">Buscar:</label>
                                    <input wire:model.lazy="search" type="text" class="form-control"
                                        placeholder="Buscar...">
                                </div>
                            </div>
                            <div class="col-lg-6">
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
                                        <th>Peso(gr.)</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Cartero</th>
                                        <th>Observaciones</th>
                                        <th>Foto</th>
                                        <th>Fecha Baja</th>
                                        <th>Acciones</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0; // Inicializa la variable $i
                                    @endphp
                                    @foreach ($packages as $package)
                                        @if ($package->ESTADO !== 'ENTREGADO')
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $package->CODIGO }}</td>
                                                <td>{{ $package->DESTINATARIO }}</td>
                                                <td>{{ $package->TELEFONO }}</td>
                                                <td>{{ $package->PESO }} </td>
                                                <td>{{ $package->TIPO }}</td>
                                                <td>
                                                    @if ($package->ESTADO == 'REPARTIDO')
                                                        ENTREGADO CARTERO
                                                    @else
                                                        {{ $package->ESTADO }}
                                                    @endif
                                                </td>
                                                <td>{{ $package->usercartero }}</td>
                                                <td>{{ $package->OBSERVACIONES }}</td>
                                                <td>
                                                    @if ($package->firma)
                                                        <a href="{{ $package->firma }}" download="foto.png" class="btn btn-sm btn-secondary">Descargar</a>
                                                    @else
                                                        <p></p>
                                                    @endif
                                                </td>
                                                <td>{{ $package->deleted_at }}</td>
                                                <td>
                                                    @hasrole('SuperAdmin|Administrador')
                                                        <button wire:click="restore('{{ $package->CODIGO }}')"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fa fa-arrow-up"></i> Alta
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
                @else
                    <p>No hay elementos eliminados.</p>
                @endif
            </div>
        </div>
    </div>
</div>
