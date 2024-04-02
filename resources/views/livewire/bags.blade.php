<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="col">
                            <h5 id="card_title">{{ __('Expedición de Paquetes en Nacionales') }}</h5>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="search">Busca:</label>
                                        <input wire:model.lazy="search" type="text" class="form-control"
                                            placeholder="Buscar...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @hasrole('SuperAdmin|Administrador')
                                        <a href="{{ route('bags.create') }}" class="btn btn-primary btn-md float-right ml-2"
                                            data-placement="left">
                                            {{ __('Crear Nuevo') }}
                                        </a>
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
                                    <th>Receptaculo</th>
                                    <th>Numero de Despacho</th>
                                    <th>Oficina de Cambio</th>
                                    <th>Oficina de Destino</th>
                                    <th>Numero de Paquetes</th>
                                    <th>Peso Despachado</th>
                                    <th>Estado</th>
                                    <th>Fecha Apertura</th>
                                    <th>Acciones</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bags as $bag)
                                    <tr>
                                        <td>{{ $bag->RECEPTACULO }}</td>
                                        <td>{{ $bag->NRODESPACHO }} / {{ $bag->NROSACA }}{{ $bag->FIN == 'F' ? 'F' : '' }}</td>
                                        <td>{{ $bag->OFCAMBIO }}</td>
                                        <td>{{ $bag->OFDESTINO }}</td>
                                        <td>{{ $bag->PAQUETES }}</td>
                                        <td>{{ $bag->PESO }}</td>
                                        <td>{{ $bag->ESTADO }}</td>
                                        <td>{{ $bag->created_at }}</td>
                                        <td>
                                            @hasrole('SuperAdmin|Administrador|Expedicion')
                                                <a class="btn btn-sm btn-warning" href="#" data-toggle="modal"
                                                    data-target="#despachoModal{{ $bag->id }}">
                                                    <i class="fa fa-arrow-down"></i>
                                                    {{ __('Despacho') }}
                                                </a>
                                                @include('bag.modal.despacho')
                                                {{-- <a class="btn btn-sm btn-info" href="{{ route('bags.show', $bag->id) }}">
                                                    Ver Paquetes
                                                </a> --}}
                                            @endhasrole
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $bags->links() !!}
        </div>
    </div>
</div>
