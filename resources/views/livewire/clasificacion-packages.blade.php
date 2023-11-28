<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card p-4">
                                    <div>
                                        <h5 id="card_title">
                                            {{ __('Registro de Paquetes Ordinarios') }}
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="search">Busca:</label>
                                                <input wire:model.lazy="search" type="text" class="form-control"
                                                    placeholder="Buscar...">
                                            </div>
                                        </div>
                                        <div class="col-lg-9 text-right">
                                            <div class="row">
                                                <!-- Formulario para generar Excel -->
                                                <form method="get" action="{{ route('clasificacion.excel') }}"
                                                    class="col-md-5">
                                                    @csrf
                                                    <div class="form-row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="excel_fecha_inicio">Fecha de inicio:</label>
                                                            <input type="date" name="fecha_inicio"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="excel_fecha_fin">Fecha de fin:</label>
                                                            <input type="date" name="fecha_fin" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="col-md-4" style="display:flex; inset:0;">
                                                            <button type="submit" class="btn btn-success"
                                                                target="_blank">Generar Excel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- Formulario para generar PDF -->
                                                <form method="get"
                                                    action="{{ route('package.pdf.clasificacionpdf') }}"
                                                    class="col-md-5">
                                                    @csrf
                                                    <div class="form-row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="pdf_fecha_inicio">Fecha de inicio:</label>
                                                            <input type="date" name="fecha_inicio"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="pdf_fecha_fin">Fecha de fin:</label>
                                                            <input type="date" name="fecha_fin" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="col-md-4" style="display:flex; inset:0;">
                                                            <button type="submit" class="btn btn-danger"
                                                                target="_blank">Generar PDF</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar
                                                    Clasificacion')
                                                    <div class="col-md-2">
                                                        <a href="{{ route('packages.create') }}" class="btn btn-primary"
                                                            data-placement="left">
                                                            {{ __('Crear Nuevo') }}
                                                        </a>
                                                    </div>
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
                                            @php
                                                $i = 0; // Inicializa la variable $i
                                            @endphp
                                            @if ($packages->count())
                                                <table class="table table-striped table-hover">
                                                    <thead class="thead">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Código Rastreo</th>
                                                            <th>Destinatario</th>
                                                            <th>Teléfono</th>
                                                            <th>País</th>
                                                            <th>Ciudad</th>
                                                            <th>Ventanilla</th>
                                                            <th>Peso</th>
                                                            <th>Tipo</th>
                                                            <th>Estado</th>
                                                            <th>Observaciones</th>
                                                            <th>Aduana</th>
                                                            <th>Fecha Ingreso</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($packages as $package)
                                                            @if ($package->ESTADO === 'CLASIFICACION')
                                                            {{-- @if ($package->ESTADO === 'CLASIFICACION' && $package->CUIDAD === auth()->user()->Regional) --}}
                                                                <tr>
                                                                    <td>{{ $package->id }}</td>
                                                                    <td>{{ $package->CODIGO }}</td>
                                                                    <td>{{ $package->DESTINATARIO }}</td>
                                                                    <td>{{ $package->TELEFONO }}</td>
                                                                    <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                                                                    <td>{{ $package->CUIDAD }}</td>
                                                                    <td>{{ $package->VENTANILLA }}</td>
                                                                    <td>{{ $package->PESO }} gr.</td>
                                                                    <td>{{ $package->TIPO }}</td>
                                                                    <td>{{ $package->ESTADO }}</td>
                                                                    <td>{{ $package->OBSERVACIONES }}</td>
                                                                    <td>{{ $package->ADUANA }}</td>
                                                                    <td>{{ $package->created_at }}</td>
                                                                    <td>
                                                                        @hasrole('SuperAdmin|Administrador|Clasificacion')
                                                                            <a class="btn btn-sm btn-success" href="{{ route('packages.edit', $package->id) }}">
                                                                                <i class="fa fa-fw fa-edit"></i>
                                                                                {{ __('Editar') }}
                                                                            </a>
                                                                    
                                                                            @php
                                                                                $currentDate = now(); // Obtener la fecha y hora actuales
                                                                                $creationDate = $package->created_at; // Obtener la fecha de creación del paquete
                                                                    
                                                                                // Verificar si la fecha de creación es igual a la fecha actual
                                                                                $deleteEnabled = $currentDate->isSameDay($creationDate);
                                                                            @endphp
                                                                    
                                                                            @if ($deleteEnabled)
                                                                                <form action="{{ route('packages.destroy', $package->id) }}" method="POST">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                                        <i class="fa fa-fw fa-trash"></i>
                                                                                        {{ __('Eliminar') }}
                                                                                    </button>
                                                                                </form>
                                                                            @else
                                                                                <p>Eliminar solo disponible el día del registro.</p>
                                                                            @endif
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
        </div>
    </div>
</div>
