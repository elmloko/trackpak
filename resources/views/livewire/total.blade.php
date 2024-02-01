<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="col">
                            <h5 id="card_title">{{ __('Todos los Paquetes Nacionales') }}</h5>
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="search">Busca:</label>
                                        <input wire:model.lazy="search" type="text" class="form-control"
                                            placeholder="Buscar...">
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
                                    <th>Codigo de Rastreo</th>
                                    <th>Nombres del Remitente</th>
                                    <th>Telefono de Remitente</th>
                                    <th>CI del Remitente</th>
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
                                    <th>Usuario</th>
                                    <th>Estado</th>
                                    @hasrole('SuperAdmin|Administrador')
                                        <th>Acciones</th>
                                    @endhasrole
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nationals as $national)
                                    @if ($national->ESTADO === 'ADMISION')
                                        <tr>
                                            <td>{{ $national->CODIGO }}</td>
                                            <td>{{ $national->NOMBRESREMITENTE }}</td>
                                            <td>{{ $national->TELEFONOREMITENTE }}</td>
                                            <td>{{ $national->CIREMITENTE }}</td>
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
                                            <td>{{ $national->USER }}</td>
                                            <td>{{ $national->ESTADO }}</td>
                                            @hasrole('SuperAdmin|Administrador')
                                            <td>
                                                <form action="{{ route('nationals.destroy', $national->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('nationals.edit', $national->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-fw fa-trash"></i>
                                                        {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                            @endhasrole
                                            {{-- <td>{{ $national->MUNICIPIO }}</td> --}}
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
