<div>
    <!-- Contenido de la vista -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 id="card_title">{{ __('Recibir Correspondencia en Ventanilla 7') }}</h5>
                                    <div class="col">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="search">Busca:</label>
                                                    <div class="input-group">
                                                        <input wire:model.lazy="search" type="text"
                                                            class="form-control" placeholder="Buscar...">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary"
                                                                wire:click="buscarPaquete">Buscar</button>
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
                                                        <th>
                                                            <input type="checkbox" wire:model="selectAll"
                                                                wire:click="toggleSelectAll">
                                                        </th>
                                                        <th>No</th>
                                                        <th>Código Rastreo</th>
                                                        <th>Destinatario</th>
                                                        <th>País</th>
                                                        <th>Ciudad</th>
                                                        <th>Zonificación</th>
                                                        <th>Peso (Kg.)</th>
                                                        <th>Tipo</th>
                                                        <th>Estado</th>
                                                        <th>Observaciones</th>
                                                        <th>Aduana</th>
                                                        <th>Foto</th>
                                                        <th>Fecha Pendiente</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($packages as $package)
                                                        <tr>
                                                            <td><input type="checkbox"
                                                                    wire:model="paquetesSeleccionados"
                                                                    value="{{ $package->id }}"></td>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $package->CODIGO }}</td>
                                                            <td>{{ $package->DESTINATARIO }}</td>
                                                            <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                                                            <td>{{ $package->CUIDAD }}</td>
                                                            <td>{{ $package->ZONA }}</td>
                                                            <td>{{ $package->PESO }} </td>
                                                            <td>{{ $package->TIPO }}</td>
                                                            <td>{{ $package->ESTADO }}</td>
                                                            <td>{{ $package->OBSERVACIONES }}</td>
                                                            <td>{{ $package->ADUANA }}</td>
                                                            <td>
                                                                @if ($package->foto)
                                                                    <a href="{{ $package->foto }}" download="foto.png" class="btn btn-sm btn-secondary">Descargar</a>
                                                                @else
                                                                    <p></p>
                                                                @endif
                                                            </td>
                                                            <td>{{ $package->updated_at }}</td>
                                                            <td>
                                                                @hasrole('SuperAdmin|Administrador|ENCOMIENDAS')
                                                                    <a class="btn btn-sm btn-success"
                                                                        href="{{ route('packages.edit', $package->id) }}">
                                                                        <i class="fa fa-fw fa-edit"></i>
                                                                        {{ __('Editar') }}
                                                                    </a>
                                                                @endhasrole
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @hasrole('SuperAdmin|Administrador|ENCOMIENDAS')
                                                <div class="col-md-12 text-right">
                                                    <button wire:click="cambiarEstado"
                                                        class="btn btn-warning">Guardar</button>
                                                </div>
                                            @endhasrole
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

    <!-- Modal para editar la ZONA -->
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar ZONA</h5>
                        <button type="button" class="close" wire:click="cerrarModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="zona">ZONA</label>
                            <select class="form-control" id="zona" name="zona" wire:model.defer="zona">
                                <option value="DND">DND</option>
                                <option value="ACHACHICALA">ACHACHICALA</option>
                                <option value="ACHUMANI">ACHUMANI</option>
                                <option value="ALTO OBRAJES">ALTO OBRAJES</option>
                                <option value="AUQUISAMANA">AUQUISAMAÑA</option>
                                <option value="BELLA VISTA / BOLONIA">BELLA VISTA / BOLONIA</option>
                                <option value="BUENOS AIRES">BUENOS AIRES</option>
                                <option value="CALACOTO">CALACOTO</option>
                                <option value="CEMENTERIO">CEMENTERIO</option>
                                <option value="CENTRO">CENTRO</option>
                                <option value="CIUDADELA FERROVIARIA">CIUDADELA FERROVIARIA</option>
                                <option value="COTA COTA / CHASQUIPAMPA">COTA COTA / CHASQUIPAMPA</option>
                                <option value="EL ALTO">EL ALTO</option>
                                <option value="FLORIDA">FLORIDA</option>
                                <option value="IRPAVI">IRPAVI</option>
                                <option value="LA PORTADA">LA PORTADA</option>
                                <option value="LLOJETA">LLOJETA</option>
                                <option value="LOS ANDES">LOS ANDES</option>
                                <option value="LOS PINOS / SAN MIGUEL">LOS PINOS / SAN MIGUEL</option>
                                <option value="MALLASILLA">MALLASILLA</option>
                                <option value="MIRAFLORES">MIRAFLORES</option>
                                <option value="MUNAYPATA">MUNAYPATA</option>
                                <option value="OBRAJES">OBRAJES</option>
                                <option value="PAMPAHASSI">PAMPAHASSI</option>
                                <option value="PASANKERI">PASANKERI</option>
                                <option value="PERIFERICA">PERIFERICA</option>
                                <option value="PROVINCIA">PROVINCIA</option>
                                <option value="PURA PURA">PURA PURA</option>
                                <option value="ROSARIO GRAN PODER">ROSARIO GRAN PODER</option>
                                <option value="SAN PEDRO">SAN PEDRO</option>
                                <option value="SAN SEBASTIAN">SAN SEBASTIAN</option>
                                <option value="SEGUENCOMA">SEGUENCOMA</option>
                                <option value="SOPOCACHI">SOPOCACHI</option>
                                <option value="TEMBLADERANI">TEMBLADERANI</option>
                                <option value="VILLA ARMONIA">VILLA ARMONIA</option>
                                <option value="VILLA COPACABANA">VILLA COPACABANA</option>
                                <option value="VILLA EL CARMEN">VILLA EL CARMEN</option>
                                <option value="VILLA FATIMA">VILLA FATIMA</option>
                                <option value="VILLA NUEVA POTOSI">VILLA NUEVA POTOSI</option>
                                <option value="VILLA PABON">VILLA PABON</option>
                                <option value="VILLA SALOME">VILLA SALOME</option>
                                <option value="VILLA SAN ANTONIO">VILLA SAN ANTONIO</option>
                                <option value="VILLA VICTORIA">VILLA VICTORIA</option>
                                <option value="VINO TINTO">VINO TINTO</option>
                                <option value="ZONA NORTE">ZONA NORTE</option>
                                <option value="PG1A">PG1A</option>
                                <option value="PG2A">PG2A</option>
                                <option value="PG3A">PG3A</option>
                                <option value="PG4A">PG4A</option>
                                <option value="PG5A">PG5A</option>
                                <option value="PG1B">PG1B</option>
                                <option value="PG2B">PG2B</option>
                                <option value="PG3B">PG3B</option>
                                <option value="PG4B">PG4B</option>
                                <option value="PG5B">PG5B</option>
                                <option value="PG1C">PG1C</option>
                                <option value="PG2C">PG2C</option>
                                <option value="PG3C">PG3C</option>
                                <option value="PG4C">PG4C</option>
                                <option value="PG5C">PG5C</option>
                                <option value="PG1D">PG1D</option>
                                <option value="PG2D">PG2D</option>
                                <option value="PG3D">PG3D</option>
                                <option value="PG4D">PG4D</option>
                                <option value="PG5D">PG5D</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cerrar</button>
                        <button type="button" class="btn btn-primary" wire:click="guardarZona">Guardar
                            cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
