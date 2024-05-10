<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">{{ __('Mensaje') }}</span>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="float-right">
                                    <input wire:model.lazy="search" type="text" class="form-control"
                                    placeholder="Buscar...">
                                    
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
                                    <th>Codigo de Rastreo</th>
                                    <th>Destinatario</th>
                                    <th>Telefono</th>
                                    <th>Ventanilla</th>
                                    <th>Estado</th>
                                    <th>Ciudad</th>
                                    <th>Mensajes</th>
                                    <th>Observacion</th>
                                    <th>Estado</th>
                                    <th>Intentos</th>
                                    <th>Fecha Enviado</th>
                                    <th>Fecha Actualizacion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mensajes as $key => $mensaje)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        @if ($mensaje->package)
                                            <td>{{ $mensaje->package->CODIGO }}</td>
                                            <td>{{ $mensaje->package->DESTINATARIO }}</td>
                                            <td>{{ $mensaje->package->TELEFONO }}</td>
                                            <td>{{ $mensaje->package->VENTANILLA }}</td>
                                            <td>{{ $mensaje->package->ESTADO }}</td>
                                            <td>{{ $mensaje->package->CUIDAD }}</td>
                                            <td>{{ $mensaje->mensajes }}</td>
                                            <td>{{ $mensaje->observacion }}</td>
                                            <td>{{ $mensaje->estado }}</td>
                                            <td>
                                                @if($mensaje->Intentos == 0)
                                                    PRIMERO
                                                @elseif($mensaje->Intentos == 1)
                                                    SEGUNDO
                                                @elseif($mensaje->Intentos == 2)
                                                    TERCERO
                                                @else
                                                    <!-- En caso de que no coincida con ningún valor -->
                                                    Otro valor o lógica aquí
                                                @endif
                                            </td>
                                            <td>{{ $mensaje->fecha_actualizacion }}</td>
                                            <td>{{ $mensaje->package->updated_at ?? $mensaje->package->created_at }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {!! $mensajes->links() !!}
            </div>
        </div>
    </div>
</div>
