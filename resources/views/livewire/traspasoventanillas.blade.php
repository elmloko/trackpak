<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h5 id="card_title">{{ __('Traspaso de Paquetes Ordinarios') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- Formulario de búsqueda -->
                            <input type="text" wire:model="searchTerm" class="form-control"
                                placeholder="Buscar código de rastreo">
                        </div>
                        <div class="col-md-1">
                            <button wire:click="searchPackage" class="btn btn-primary mt-2">Buscar</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        @php
                            $i = 1; // Inicializa la variable $i
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
                                        <th>Peso (gr.)</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Aduana</th>
                                        <th>Observaciones</th>
                                        <th>Ultima Actualización</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $package)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $package->CODIGO }}</td>
                                            <td>{{ $package->DESTINATARIO }}</td>
                                            <td>{{ $package->TELEFONO }}</td>
                                            <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                                            <td>{{ $package->CUIDAD }}</td>
                                            <td>{{ $package->VENTANILLA }}</td>
                                            <td>{{ $package->PESO }} </td>
                                            <td>{{ $package->TIPO }}</td>
                                            <td>
                                                @if ($package->ESTADO == 'REPARTIDO')
                                                    ENTREGADO CARTERO
                                                @else
                                                    {{ $package->ESTADO }}
                                                @endif
                                            </td>
                                            <td>{{ $package->ADUANA }}</td>
                                            <td>{{ $package->OBSERVACIONES }}</td>
                                            <td>{{ $package->updated_at }}</td>
                                            <td>
                                                <button wire:click="quitarVentana({{ $package->id }})"
                                                    class="btn btn-warning">Quitar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No se encontraron resultados para la búsqueda.</p>
                        @endif
                    </div>

                    <!-- Nueva funcionalidad: Select y botón para traspazar -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="ventanillaSelect">Seleccionar Ventanilla</label>
                            <select wire:model="selectedVentanilla" class="form-control" id="ventanillaSelect">
                                <option value="">Seleccione</option>
                                <option value="DD">DD</option>
                                <option value="DND">DND</option>
                                <option value="ECA">ECA</option>
                                <option value="ENCOMIENDAS">ENCOMIENDAS</option>
                                <option value="CASILLAS">CASILLAS</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button wire:click="traspazarPaquetes" class="btn btn-primary mt-4">TRASPAZAR</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
