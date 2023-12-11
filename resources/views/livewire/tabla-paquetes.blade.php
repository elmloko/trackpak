<!-- resources/views/livewire/tabla-paquetes.blade.php -->
<div>
    <div class="row mb-12">
        <!-- Columna de Búsqueda -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="packagesToAdd">Buscar:</label>
                <input wire:model.lazy="search" type="text" class="form-control" id="packagesToAdd" placeholder="Buscar...">
            </div>
        </div>

        <!-- Columna de Seleccionar Cartero -->
        <div class="col-md-5">
            <div class="form-group">
                <label for="carteroSelect">Seleccionar Cartero:</label>
                <select wire:model="selectedCartero" class="form-control" id="carteroSelect">
                    <option value="">Seleccione un cartero</option>
                    @foreach ($carters as $cartero)
                        <option value="{{ $cartero->name }}">{{ $cartero->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>        

        <!-- Columna de Botón Asignar -->
        <div class="col-md-1">
            <div class="row mb-12">
                <div class="col-md-3">
                    <button wire:click="asignarPaquetes" class="btn btn-warning btn-lg">
                        <i class="fas fa-check"></i> ASIGNAR
                    </button>
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

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Paquetes para Agregar') }}</h5>
                    <div class="table-responsive">
                        <div class="col-lg-3">
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Código Rastreo</th>
                                    <th>Destinatario</th>
                                    <th>Zona</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packagesToAdd as $package)
                                    <tr>
                                        <td>{{ $package->CODIGO }}</td>
                                        <td>{{ $package->DESTINATARIO }}</td>
                                        <td>{{ $package->ZONA }}</td>
                                        <td>
                                            <button wire:click="agregarPaquete({{ $package->id }})"
                                                class="btn btn-success">
                                                <i class="fas fa-plus"></i> Agregar
                                            </button>
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
                                                <button wire:click="quitarPaquete({{ $package->id }})"
                                                    class="btn btn-danger ">
                                                    <i class="fas fa-minus"></i> Quitar
                                                </button>
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