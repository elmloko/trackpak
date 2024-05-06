<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="col">
                            <h5 id="card_title">{{ __('Transito de Paquetes en Nacionales') }}</h5>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="search">Busca:</label>
                                        <input wire:model.lazy="search" type="text" class="form-control"
                                            placeholder="Buscar...">
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
                                    <th>Despacho</th>
                                    <th>Oficina de Cambio</th>
                                    <th>Oficina de Destino</th>
                                    <th>Numero de Sacas</th>
                                    <th>Peso (Kg.)</th>
                                    <th>Numero de Paquetes</th>
                                    <th>Itinerario</th>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                    <th>Fecha Expedicion</th>
                                    {{-- <th>Acciones</th> --}}
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bags as $bag)
                                    @if ($bag->FIN == 'F')
                                        <tr>
                                            <td>{{ $bag->MARBETE }}</td>
                                            <td>{{ $bag->OFCAMBIO }}</td>
                                            <td>{{ $bag->OFDESTINO }}</td>
                                            <td>
                                                @foreach ($sums as $sum)
                                                    @if ($sum->MARBETE == $bag->MARBETE)
                                                        {{ $sum->sum_totalsaca }}
                                                    @endif
                                                @endforeach
                                            </td>
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
                                                        {{ $sum->sum_totalpaquetes }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($bag->ITINERARIO && $bag->TRASPORTE && $bag->HORARIO)
                                                    {{ $bag->ITINERARIO }} / {{ $bag->TRASPORTE }}={{ $bag->HORARIO }}
                                                @elseif($bag->ITINERARIO && !$bag->TRASPORTE && !$bag->HORARIO)
                                                    {{ $bag->ITINERARIO }}
                                                @else
                                                    <!-- Campo vacío -->
                                                @endif
                                            </td>
                                            <td>{{ $bag->ESTADO }}</td>
                                            <td>{{ $bag->OBSERVACIONES }}</td>
                                            <td>{{ $bag->updated_at }}</td>
                                            {{-- <td>
                                                @hasrole('SuperAdmin|Administrador|Areo')
                                                    <a class="btn btn-sm btn-warning" href="#" data-toggle="modal"
                                                        data-target="#returnModal{{ $bag->id }}">
                                                        <i class="fa fa-arrow-down"></i>
                                                        {{ __('Return') }}
                                                    </a>
                                                    @include('bag.modal.return')
                                                @endhasrole
                                            </td> --}}
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
