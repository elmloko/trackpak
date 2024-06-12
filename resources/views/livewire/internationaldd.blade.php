<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card-header">
                <h5 id="card_title">
                    {{ __('PAQUTERIA CERTIFICADA') }}
                </h5>
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="search">Busca:</label>
                                        <input wire:model.lazy="search" type="text" class="form-control"
                                            placeholder="Buscar...">
                                    </div>
                                </div>
                                @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
                                    <div class="col-md-3">
                                        <button wire:click="cambiarEstado" class="btn btn-warning">Entregar</button>
                                    </div>
                                    {{-- <div class="col-md-3 text-right">
                                        <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#buscarPaqueteModal">
                                            Añadir Paquete
                                        </button>
                                        @include('package.modal.ventanilla')
                                    </div> --}}
                                @endhasrole
                                <div class="col-md-12">
                                    <div class="row">
                                        <!-- Formulario para generar Excel -->
                                        <div class="col-md-6">
                                            <form method="get" action="{{ route('ventanilla.excel') }}"
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
                                        <div class="col-md-6">
                                            <form method="get"
                                                action="{{ route('package.pdf.ventanillapdf') }}"
                                                class="col-md-12">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="col-md-4">
                                                        <label for="fecha_inicio">Fecha de inicio:</label>
                                                        <input type="date" name="fecha_inicio"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="fecha_fin">Fecha de fin:</label>
                                                        <input type="date" name="fecha_fin"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="ventanilla">Ventanilla:</label>
                                                        <select name="ventanilla" class="form-control">
                                                            @if (auth()->user()->Regional == 'LA PAZ')
                                                                <option value="DD">DD</option>
                                                            @else
                                                                <option value="UNICA">UNICA</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mt-3 text-center">
                                                        <button type="submit" class="btn btn-danger">Generar
                                                            PDF</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="float-right">
                            {{-- <a href="{{ route('internationals.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                              {{ __('Create New') }}
                            </a> --}}
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
                                    <th>Pais</th>
                                    <th>Cuidad</th>
                                    <th>Zona</th>
                                    <th>Ventanilla</th>
                                    <th>Peso</th>
                                    <th>Tipo</th>
                                    <th>Aduana</th>
                                    <th>Estado</th>
                                    <th>Precio</th>
                                    <th>Observaciones</th>
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
                                            !$international->redirigido &&
                                            $international->CUIDAD === auth()->user()->Regional &&
                                            in_array($international->VENTANILLA, ['DD']))
                                        <tr>
                                            <td><input type="checkbox" wire:model="paquetesSeleccionados"
                                                    value="{{ $international->id }}"></td>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $international->CODIGO }}</td>
                                            <td>{{ $international->DESTINATARIO }}</td>
                                            <td>{{ $international->TELEFONO }}</td>
                                            <td>{{ $international->PAIS }}-{{ $international->ISO }}</td>
                                            <td>{{ $international->CUIDAD }}</td>
                                            <td>{{ $international->ZONA }}</td>
                                            <td>{{ $international->VENTANILLA }}</td>
                                            <td>{{ $international->PESO }}</td>
                                            <td>{{ $international->TIPO }}</td>
                                            <td>{{ $international->ADUANA }}</td>
                                            <td>{{ $international->ESTADO }}</td>
                                            <td>{{ $international->PRECIO }}</td>
                                            <td>{{ $international->OBSERVACIONES }}</td>
                                            <td>

                                                <form
                                                    action="{{ route('internationals.destroy', $international->id) }}"
                                                    method="POST">
                                                    @hasrole('SuperAdmin|Administrador|Urbano')
                                                        <a class="btn btn-sm btn-success"
                                                            href="{{ route('internationals.edit', $international->id) }}"><i
                                                                class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                        @csrf
                                                        @method('DELETE')
                                                    @endhasrole
                                                    @hasrole('SuperAdmin|Administrador')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                                class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                    @endhasrole
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
</div>
