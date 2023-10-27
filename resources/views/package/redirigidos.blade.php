@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h1>Paquetes Redirigidos</h1>
                                @if ($paquetesRedirigidos->count() > 0)
                                    <table class="table table-striped table-hover">
                                        <thead class="thead">
                                            <tr>
                                                <th>No</th>
                                                <th>Código Postal</th>
                                                <th>Destinatario</th>
                                                <th>País</th>
                                                <th>Destino Cuidad</th>
                                                <th>Tipo</th>
                                                <th>Estado</th>
                                                <th>Aduana</th>
                                                <th>Fecha Retorno</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($paquetesRedirigidos as $packages)
                                                <tr>
                                                    <td>{{ $packages->id }}</td>
                                                    <td>{{ $packages->CODIGO }}</td>
                                                    <td>{{ $packages->DESTINATARIO }}</td>
                                                    <td>{{ $packages->PAIS }}</td>
                                                    <td>{{ $packages->CUIDAD }}</td>
                                                    <td>{{ $packages->TIPO }}</td>
                                                    <td>{{ $packages->ESTADO }}</td>
                                                    <td>{{ $packages->ADUANA }}</td>
                                                    <td>{{ $packages->date_redirigido }}</td>
                                                    <td><a href="{{ route('packages.dirigido', $packages->id) }}" class="btn btn-info"><i class="fa fa-arrow-up"></i>Rencaminado</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>No se encontraron paquetes redirigidos.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
@endsection
