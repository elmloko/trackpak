<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div>
                                    <div>
                                        <h5 id="card_title">
                                            {{ __('Despacho de Paquetes en Carteros') }}
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <input wire:model.lazy="search" type="text" class="form-control"
                                                    placeholder="Buscar...">
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-9 text-right">
                                            <div class="mr-2 d-inline-block">
                                                <a href="{{ route('package.pdf.carteropdf') }}" class="btn btn-success"
                                                    data-placement="left">
                                                    Excel
                                                </a>
                                            </div>
                                            <div class="mr-2 d-inline-block">
                                                <a href="{{ route('package.pdf.carteropdf') }}" class="btn btn-danger"
                                                    data-placement="left">
                                                    PDF
                                                </a>
                                            </div>
                                            @hasrole('SuperAdmin|Administrador|Cartero')
                                            <div class="mr-2 d-inline-block">
                                                <!-- Botón para abrir el modal de cambio de estado -->
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#buscarPaqueteModal">
                                                    Añadir Paquete
                                                </button>
                                                @include('package.modal.cartero')
                                            </div>
                                            @endhasrole
                                        </div> --}}
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
                                                        <th>No</th>
                                                        <th>Código Rastreo</th>
                                                        <th>Destinatario</th>
                                                        <th>Teléfono</th>
                                                        <th>País</th>
                                                        <th>Ciudad</th>
                                                        <th>Zona</th>
                                                        <th>Ventanilla</th>
                                                        <th>Peso</th>
                                                        <th>Tipo</th>
                                                        <th>Estado</th>
                                                        <th>Fecha Retorno</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1; // Inicializa la variable $i
                                                    @endphp
                                                    @foreach ($packages as $package)
                                                        @if ($package->ESTADO === 'RETORNO')
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
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
                                                                <td>{{ $package->updated_at }}</td>
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
    </div>
</div>
