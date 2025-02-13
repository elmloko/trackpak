<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <h5 id="card_title">
                                {{ __('Eventos del Sistema TrackingBO') }}
                            </h5>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="buscar">Buscar por Código:</label>
                                    <input wire:model.lazy="search" type="text" class="form-control"
                                        placeholder="Buscar código...">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="user_id">Buscar por Usuario:</label>
                                    <select wire:model.lazy="selectedUserId" class="form-control">
                                        <option value="">Seleccione un usuario</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label>&nbsp;</label> <!-- Espacio para el botón -->
                                    <button wire:click="exportToExcel"
                                        class="btn btn-success btn-sm btn-block">Exportar</button>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <!-- Botón para generar el backup -->
                                    <button type="button" class="btn btn-info btn-sm btn-block" wire:click="backupProject"
                                        wire:loading.attr="disabled" wire:target="backupProject" data-bs-toggle="modal"
                                        data-bs-target="#backupModal">
                                        Generar Backup
                                    </button>

                                    <!-- Modal de carga -->
                                    <div wire:loading wire:target="backupProject">
                                        <div class="modal fade show" id="backupModal" tabindex="-1" role="dialog"
                                            style="display:block; background:rgba(0,0,0,0.5);" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Generando Backup</h5>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <p>Por favor espere, el proceso puede tardar unos segundos...
                                                        </p>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                                style="width: 100%;"></div>
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
                                    <th>No</th>
                                    <th>Accion</th>
                                    <th>Descripcion</th>
                                    <th>Usuario</th>
                                    <th>Codigo</th>
                                    <th>Fecha y Hora del Evento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1; // Inicializa la variable $i
                                @endphp
                                @foreach ($events as $event)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $event->action }}</td>
                                        <td>{{ $event->descripcion }}</td>
                                        <td>{{ $event->user->name }}</td>
                                        <td>{{ $event->codigo }}</td>
                                        <td>{{ $event->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $events->links() !!}
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('close-modal', () => {
                var modal = document.getElementById('backupModal');
                var modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });
        });
    </script>
</div>
