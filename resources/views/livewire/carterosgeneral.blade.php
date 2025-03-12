<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div>
                                    <h5 id="card_title">
                                        {{ __('Entregas de Paquetes en Carteros') }}
                                    </h5>
                                </div>
                                <div class="row align-items-end">
                                    <div class="col-lg-4 mb-2">
                                        <div class="form-group">
                                            <label for="buscar">Buscar:</label>
                                            <input wire:model.lazy="search" type="text" class="form-control" placeholder="Buscar...">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 mb-2">
                                        <div class="form-group">
                                            <label for="cartero">Seleccionar Cartero:</label>
                                            <select wire:model.lazy="selectedCartero" class="form-control">
                                                <option value="">{{ __('Seleccionar Cartero') }}</option>
                                                @foreach ($carteros as $cartero)
                                                    <option value="{{ $cartero->name }}">{{ $cartero->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="col-lg-1 mb-2">
                                        <button wire:click="exportToExcel" class="btn btn-success btn-block">Exportar a Excel</button>
                                    </div>
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
                                                    <th>Peso</th>
                                                    <th>Tipo</th>
                                                    <th>Estado</th>
                                                    <th>Cartero</th>
                                                    <th>Foto</th>
                                                    <th>Fecha Ingreso</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 1; @endphp
                                                @foreach ($packages as $package)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $package->CODIGO }}</td>
                                                        <td>{{ $package->DESTINATARIO }}</td>
                                                        <td>{{ $package->TELEFONO }}</td>
                                                        <td>{{ $package->PESO }} gr.</td>
                                                        <td>{{ $package->TIPO }}</td>
                                                        <td>{{ $package->ESTADO }}</td>
                                                        <td>{{ $package->usercartero }}</td>
                                                        <td>
                                                            @if ($package->foto)
                                                                <a href="{{ $package->foto }}" download="foto.png" class="btn btn-sm btn-secondary">Descargar</a>
                                                            @else
                                                                <p></p>
                                                            @endif
                                                        </td>
                                                        <td>{{ $package->updated_at }}</td>
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
