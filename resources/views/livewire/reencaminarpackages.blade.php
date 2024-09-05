<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-body">
                        <div>
                            <h5 id="card_title">
                                {{ __('Paquetes Perdidos en Destino') }}
                            </h5>
                            <div class="row d-flex justify-content-between align-items-center ">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="search">Busca:</label>
                                        <input wire:model.lazy="search" type="text" class="form-control"
                                            placeholder="Buscar...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <form wire:submit.prevent="export" class="form-row align-items-center">
                                        <div class="col-md-4">
                                            <label for="fecha_inicio">Fecha de inicio:</label>
                                            <input type="date" wire:model="fecha_inicio" class="form-control"
                                                required>
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
                                            <button type="submit" class="btn btn-success">Generar
                                                Excel</button>
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
                                        <th>País</th>
                                        <th>Destino Perdido</th>
                                        <th>Destino Final</th>
                                        <th>Tipo</th>
                                        <th>Peso</th>
                                        <th>Estado</th>
                                        <th>Observaciones</th>
                                        <th>Fecha Retorno</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $package)
                                        @if ($package->ESTADO === 'REENCAMINADO')
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $package->CODIGO }}</td>
                                                <td>{{ $package->DESTINATARIO }}</td>
                                                <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                                                <td>{{ $package->cuidadre }}</td>
                                                <td>{{ $package->CUIDAD }}</td>
                                                <td>{{ $package->TIPO }}</td>
                                                <td>{{ $package->PESO }} gr.</td>
                                                <td>{{ $package->ESTADO }}</td>
                                                <td>{{ $package->OBSERVACIONES }}</td>
                                                <td>{{ $package->date_redirigido }}</td>
                                                <td>
                                                    <button wire:click="editPackage({{ $package->id }})"
                                                        class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#editModal">
                                                        Recibir Paquete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    {{ $packages->links() }}
                                </div>
                                <div class="col-md-6 text-right">
                                    Se encontraron {{ $packages->total() }} registros en total
                                </div>
                            </div>
                        @else
                            <p>No hay elementos eliminados.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Recepcion de Paquete para Despacho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="ciudad">Ciudad</label>
                            <select wire:model="editCiudad" class="form-control" id="ciudad">
                                <option value="">Seleccione una ciudad</option>
                                <option value="LA PAZ">LA PAZ</option>
                                <option value="COCHABAMBA">COCHABAMBA</option>
                                <option value="SANTA CRUZ">SANTA CRUZ</option>
                                <option value="ORURO">ORURO</option>
                                <option value="POTOSI">POTOSI</option>
                                <option value="TARIJA">TARIJA</option>
                                <option value="SUCRE">SUCRE</option>
                                <option value="BENI">BENI</option>
                                <option value="PANDO">PANDO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ventanilla">Ventanilla</label>
                            <select wire:model="editVentanilla" class="form-control" id="ventanilla">
                                <option value="">Seleccione Ventanilla</option>
                                <option value="DD">DD</option>
                                <option value="DND">DND</option>
                                <option value="ENCOMIENDAS">ENCOMIENDAS</option>
                                <option value="CASILLAS">CASILLAS</option>
                                <option value="ECA">ECA</option>
                                <option value="UNICA">UNICA</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" wire:click="updatePackage" class="btn btn-primary">Recibir</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:load', function() {
        window.addEventListener('closeModal', event => {
            $('#editModal').modal('hide');
        });
    });
</script>
