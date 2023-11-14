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
                                    <input wire:model.lazy="search" type="text" class="form-control"
                                        placeholder="Buscar...">
                                </div>
                            </div>
                            <div class="col-lg-9 text-right">
                                <div class="mr-2 d-inline-block">
                                    <a href="{{ route('events.pdf.eventspdf') }}" class="btn btn-danger"
                                        data-placement="left">
                                        PDF
                                    </a>
                                </div>
                                <div class="mr-2 d-inline-block">
                                    @hasrole('SuperAdmin')
                                    <a href="{{ route('events.create') }}" class="btn btn-primary">{{ __('Crear Nuevo') }}</a>
                                    @endhasrole
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
                                    <th>Fecha y Hora de Modificacion</th>
                                    <th>Acciones</th>
                                    <th></th>
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

                                        <td>
                                            <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('events.show', $event->id) }}">
                                                    <i class="fa fa-fw fa-eye"></i> {{ __('Show') }}
                                                </a>
                                                @hasrole('SuperAdmin')
                                                <a class="btn btn-sm btn-success" href="{{ route('events.edit', $event->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}
                                                </a>
                                                @endhasrole
                                                @hasrole('SuperAdmin')
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}
                                                </button>
                                                @endhasrole
                                            </form>
                                        </td>
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
