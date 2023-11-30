<!-- resources/views/livewire/tabla-paquetes.blade.php -->
<div>
    <div class="row mb-3">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="carteroSelect">Seleccionar Cartero:</label>
                <select wire:model="selectedCartero" class="form-control" id="carteroSelect">
                    <option value="">Seleccione un cartero</option>
                    @foreach ($carters as $cartero)
                        <option value="{{ $cartero->id }}">{{ $cartero->name }}</option>
                    @endforeach
                </select>
                <div class="col-lg-3">
                    <button wire:click="cambiarEstadoVentanillaMasivo" class="btn btn-warning">Cambiar a Ventanilla</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <input wire:model.lazy="search" type="text" class="form-control" placeholder="Buscar...">
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

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Paquetes para Agregar') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Código Rastreo</th>
                                    <th>Destinatario</th>
                                    <th>Zona</th>
                                    <!-- Agrega otros encabezados según tu estructura de base de datos -->
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packagesToAdd as $package)
                                    <tr>
                                        <td>{{ $package->CODIGO }}</td>
                                        <td>{{ $package->DESTINATARIO }}</td>
                                        <td>{{ $package->ZONA }}</td>
                                        <!-- Agrega otras celdas según tu estructura de base de datos -->
                                        <td>
                                            <button wire:click="agregarPaquete({{ $package->id }})" class="btn btn-success">Agregar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                {{ $packagesToAdd->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Paquetes Asignados') }}</h5>
                    @if ($assignedPackages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Código Rastreo</th>
                                        <th>Destinatario</th>
                                        <th>Zona</th>
                                        <!-- Agrega otros encabezados según tu estructura de base de datos -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignedPackages as $package)
                                        <tr>
                                            <td>{{ $package->CODIGO }}</td>
                                            <td>{{ $package->DESTINATARIO }}</td>
                                            <td>{{ $package->ZONA }}</td>
                                            <td>
                                                <button wire:click="quitarPaquete({{ $package->id }})" class="btn btn-danger">Quitar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    {{ $assignedPackages->links() }}
                                </div>
                                <div class="col-md-6 text-right">
                                    Se asignaron {{ $assignedPackages->total() }} Paquetes
                                </div>
                            </div>
                        </div>
                    @else
                        <p>No hay paquetes asignados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


