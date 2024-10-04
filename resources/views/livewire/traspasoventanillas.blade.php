<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div>
                                        <h5 id="card_title">
                                            {{ __('Traspaso de Paquetes Ordinarios') }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        @php
                                            $i = 1; // Inicializa la variable $i
                                        @endphp
                                        @if ($packages->count())
                                            <table class="table table-striped table-hover">
                                                <thead class="thead">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Código Rastreo</th>
                                                        <th>Destinatario</th>
                                                        <th>Teléfono</th>
                                                        <th>País</th>
                                                        <th>Ciudad</th>
                                                        <th>Ventanilla</th>
                                                        <th>Peso (gr.)</th>
                                                        <th>Tipo</th>
                                                        <th>Estado</th>
                                                        <th>Aduana</th>
                                                        <th>Observaciones</th>
                                                        <th>Ultima Actualizacion</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($packages as $package)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $package->CODIGO }}</td>
                                                            <td>{{ $package->DESTINATARIO }}</td>
                                                            <td>{{ $package->TELEFONO }}</td>
                                                            <td>{{ $package->PAIS }} - {{ $package->ISO }}</td>
                                                            <td>{{ $package->CUIDAD }}</td>
                                                            <td>{{ $package->VENTANILLA }}</td>
                                                            <td>{{ $package->PESO }} </td>
                                                            <td>{{ $package->TIPO }}</td>
                                                            <td>
                                                                @if($package->ESTADO == 'REPARTIDO')
                                                                    ENTREGADO CARTERO
                                                                @else
                                                                    {{ $package->ESTADO }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $package->ADUANA }}</td>
                                                            <td>{{ $package->OBSERVACIONES }}</td>
                                                            <td>{{ $package->updated_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            {{ $packages->links() }}
                                        </div>
                                        <div class="col-md-6 text-right">
                                            Se encontraron {{ $packages->total() }} registros en total
                                        </div>
                                    </div>
                                @else
                                    <p>No se encontraron resultados para la búsqueda.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
