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
                                @hasrole('SuperAdmin|Administrador|Urbano')
                                    <div class="col-md-6 text-right">
                                        <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#buscarPaqueteModal">
                                            Admitir Saca
                                        </button>
                                        @include('bag.modal.add')
                                    </div>
                                @endhasrole
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
                                    <th>Itinerario</th>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                    <th>Fecha Apertura</th>
                                    {{-- <th>Acciones</th> --}}
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bags as $bag)
                                        <tr>
                                            <td>{{ $bag->RECEPTACULO }}</td>
                                            <td>{{ $bag->OFCAMBIO }}</td>
                                            <td>{{ $bag->OFDESTINO }}</td>
                                            <td>{{ $bag->PESO }}</td>
                                            <td>{{ $bag->PAQUETES }}</td>
                                            <td>{{ $bag->ITINERARIO }}</td>
                                            <td>{{ $bag->ESTADO }}</td>
                                            <td>{{ $bag->OBSERVACIONES }}</td>
                                            <td>{{ $bag->updated_at }}</td>
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
