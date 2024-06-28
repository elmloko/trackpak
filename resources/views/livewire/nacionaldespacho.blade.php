<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="col">
                            <h5 id="card_title">{{ __('Admision de Paquetes en Nacionales') }}</h5>
                            <div class="row align-items-center">
                                <div class="col-md-2">
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
                                <div class="col-md-2">
                                    <label for="carteroFilter">Asignar a Cartero:</label>
                                    <select wire:model="selectedCartero" class="form-control" id="carteroFilter">
                                        <option value="">Seleccione un Cartero</option>
                                        @foreach ($carteros as $cartero)
                                            <option value="{{ $cartero->id }}">{{ $cartero->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button wire:click="cambiarEstado" class="btn btn-warning">Despachar</button>

                                    @include('national.modal.ems')
                                </div>
                                @hasrole('SuperAdmin|Administrador|')
                                    <div class="col-md-2 text-right">
                                        <div class="form-group">
                                            <label for="search">Busca:</label>
                                            <input wire:model.lazy="search" type="text" class="form-control"
                                                placeholder="Buscar...">
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#buscarPaqueteModal">
                                                Añadir Paquete
                                            </button>
                                        </div>
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
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th><input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll">
                                    </th>
                                    <th>Codigo de Rastreo</th>
                                    <th>Nombres del Destinatario</th>
                                    <th>Telefono del Destinatario</th>
                                    <th>CI del Destinatario</th>
                                    <th>Direccion del Destinatario</th>
                                    <th>Cantidad</th>
                                    <th>Tipo Servicio</th>
                                    <th>Tipo Correspondencia</th>
                                    <th>Localidad</th>
                                    <th>Peso (Kg.)</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                    <th>N° Factura</th>
                                    <th>Importe (Bs.)</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nationals as $national)
                                    @if ($national->ESTADO === 'CLASIFICACION')
                                        <tr>
                                            <td><input type="checkbox" wire:model="paquetesSeleccionados"
                                                    value="{{ $national->id }}"></td>
                                            <td>{{ $national->CODIGO }}</td>
                                            <td>{{ $national->NOMBRESDESTINATARIO }}</td>
                                            <td>{{ $national->TELEFONODESTINATARIO }}</td>
                                            <td>{{ $national->CIDESTINATARIO }}</td>
                                            <td>{{ $national->DIRECCION }}</td>
                                            <td>{{ $national->CANTIDAD }}</td>
                                            <td>{{ $national->TIPOSERVICIO }}</td>
                                            <td>{{ $national->TIPOCORRESPONDENCIA }}</td>
                                            <td>{{ $national->PROVINCIA }}</td>
                                            <td>{{ $national->PESO }}</td>
                                            <td>{{ $national->ORIGEN }}</td>
                                            <td>{{ $national->DESTINO }}</td>
                                            <td>{{ $national->FACTURA }}</td>
                                            <td>{{ $national->IMPORTE }}</td>
                                            <td>{{ $national->DESCRIPCION }}</td>
                                            <td>{{ $national->ESTADO }}</td>
                                            <td>
                                                <form action="{{ route('nationals.destroy', $national->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('nationals.edit', $national->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <form action="{{ route('national.devolver', $national->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        Devolver
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $nationals->links() !!}
        </div>
    </div>
</div>
