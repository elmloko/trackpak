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
                                    @hasrole('SuperAdmin|Administrador|Expedicion')
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
                                    <th>Despacho</th>
                                    <th>Oficina de Cambio</th>
                                    <th>Oficina de Destino</th>
                                    <th>Peso (Kg.)</th>
                                    <th>Numero de Paquetes</th>
                                    <th>Numero de Sacas</th>
                                    <th>Itinerario</th>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                    <th>Fecha Apertura</th>
                                    <th>Acciones</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bags as $bag)
                                    @if ($bag->first == '1')
                                        <tr>
                                            <td>{{ $bag->MARBETE }}</td>
                                            <td>{{ $bag->OFCAMBIO }}</td>
                                            <td>{{ $bag->OFDESTINO }}</td>
                                            <td>
                                                @foreach ($sums as $sum)
                                                    @if ($sum->MARBETE == $bag->MARBETE)
                                                        {{ $sum->sum_totalpeso }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($sums as $sum)
                                                    @if ($sum->MARBETE == $bag->MARBETE)
                                                        {{ $sum->sum_paquetes }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($sums as $sum)
                                                    @if ($sum->MARBETE == $bag->MARBETE)
                                                        {{ $sum->sum_sacas }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $bag->ITINERARIO }}</td>
                                            <td>{{ $bag->ESTADO }}</td>
                                            <td>{{ $bag->OBSERVACIONES }}</td>
                                            <td>{{ $bag->updated_at }}</td>
                                            <td>
                                                @hasrole('Expedicion')
                                                    @if ($bag->T == 0)
                                                        <a class="btn btn-sm btn-warning" href="#" data-toggle="modal"
                                                            data-target="#avisoModal{{ $bag->id }}">
                                                            <i class="fa fa-arrow-down"></i>
                                                            {{ __('CN31') }}
                                                        </a>
                                                        @include('bag.modal.aviso')
                                                    @elseif ($bag->T == 1)
                                                        <a class="btn btn-sm btn-warning" href="#" data-toggle="modal"
                                                            data-target="#showModal{{ $bag->id }}">
                                                            <i class="fa fa-arrow-down"></i>
                                                            {{ __('CN35') }}
                                                        </a>
                                                        @include('bag.modal.show')
                                                    @endif
                                                @endhasrole
                                                @hasrole('Areo')
                                                    @if ($bag->T == 2)
                                                        <a class="btn btn-sm btn-warning" href="#" data-toggle="modal"
                                                            data-target="#despachoModal{{ $bag->id }}">
                                                            <i class="fa fa-arrow-down"></i>
                                                            {{ __('Trasportar') }}
                                                        </a>
                                                        @include('bag.modal.cierre')
                                                    @endif
                                                @endhasrole
                                                @hasrole('SuperAdmin|Administrador')
                                                    <a class="btn btn-sm btn-warning" href="#" data-toggle="modal"
                                                        data-target="#showModal{{ $bag->id }}">
                                                        <i class="fa fa-arrow-down"></i>
                                                        {{ __('CN35') }}
                                                    </a>
                                                    @include('bag.modal.show')
                                                    <a class="btn btn-sm btn-warning" href="#" data-toggle="modal"
                                                        data-target="#avisoModal{{ $bag->id }}">
                                                        <i class="fa fa-arrow-down"></i>
                                                        {{ __('CN31') }}
                                                    </a>
                                                    @include('bag.modal.aviso')
                                                    <a class="btn btn-sm btn-warning" href="#" data-toggle="modal"
                                                        data-target="#despachoModal{{ $bag->id }}">
                                                        <i class="fa fa-arrow-down"></i>
                                                        {{ __('Trasportar') }}
                                                    </a>
                                                    @include('bag.modal.cierre')
                                                @endhasrole
                                            </td>
                                        </tr>
                                    @endif
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
