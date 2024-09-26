<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card-header">
                <h5 id="card_title">
                    {{ __('PAQUTERIA CERTIFICADA') }}
                </h5>
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <label for="search">Busca:</label>
                        <input wire:model.lazy="search" type="text" class="form-control" placeholder="Buscar...">
                        <div class="float-right">
                            {{-- <a href="{{ route('internationals.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                              {{ __('Create New') }}
                            </a> --}}
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
                                    <th>Codigo</th>
                                    <th>Destinatario</th>
                                    <th>Telefono</th>
                                    <th>Pais</th>
                                    <th>Cuidad</th>
                                    <th>Zona</th>
                                    <th>Ventanilla</th>
                                    <th>Peso</th>
                                    <th>Tipo</th>
                                    <th>Aduana</th>
                                    <th>Estado</th>
                                    <th>Precio</th>
                                    <th>Observaciones</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1; // Inicializa la variable $i
                                @endphp
                                @foreach ($internationals as $international)
                                    <tr>
                                        <td>{{ ++$i }}</td>

                                        <td>{{ $international->CODIGO }}</td>
                                        <td>{{ $international->DESTINATARIO }}</td>
                                        <td>{{ $international->TELEFONO }}</td>
                                        <td>{{ $international->PAIS }}-{{ $international->ISO }}</td>
                                        <td>{{ $international->CUIDAD }}</td>
                                        <td>{{ $international->ZONA }}</td>
                                        <td>{{ $international->VENTANILLA }}</td>
                                        <td>{{ $international->PESO }}</td>
                                        <td>{{ $international->TIPO }}</td>
                                        <td>{{ $international->ADUANA }}</td>
                                        <td>
                                            @if($international->ESTADO == 'REPARTIDO')
                                                ENTREGADO CARTERO
                                            @else
                                                {{ $international->ESTADO }}
                                            @endif
                                        </td>
                                        <td>{{ $international->PRECIO }}</td>
                                        <td>{{ $international->OBSERVACIONES }}</td>
                                        <td>{{ $international->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $internationals->links() !!}
        </div>
    </div>
</div>
