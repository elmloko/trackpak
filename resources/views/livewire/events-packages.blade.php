<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <h5 id="card_title">
                                {{ __('Inventario de Paquetes en Entregados') }}
                            </h5>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="buscar">Buscar por Código:</label>
                                    <input wire:model.lazy="search" type="text" class="form-control" placeholder="Buscar código...">
                                </div>
                            </div>
                            
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="user_id">Buscar por Usuario:</label>
                                    <select wire:model.lazy="selectedUserId" class="form-control">
                                        <option value="">Seleccione un usuario</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label>&nbsp;</label> <!-- Espacio para el botón -->
                                    <button wire:click="render" class="btn btn-primary btn-sm btn-block">Buscar</button>
                                </div>
                            </div>
                            
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label>&nbsp;</label> <!-- Espacio para el botón -->
                                    <button wire:click="exportToExcel" class="btn btn-success btn-sm btn-block">Exportar</button>
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
</div>
