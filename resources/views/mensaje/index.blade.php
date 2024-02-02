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
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Mensaje') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('mensajes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
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
                                        <th>Codigo de Rastreo</th>
                                        <th>Destinatario</th>
                                        <th>Telefono</th>
										<th>Mensajes</th>
										<th>Observacion</th>
                                        <th>Estado</th>
										<th>Fecha Enviado</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mensajes as $mensaje)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $codigos[$loop->index] }}</td>
                                            <td>{{ $destinatario[$loop->index] }}</td>
                                            <td>{{ $telefono[$loop->index] }}</td>
                                            <td>{{ $mensaje->mensajes }}</td>
                                            <td>{{ $mensaje->observacion }}</td>
                                            <td>{{ $mensaje->estado }}</td>
                                            <td>{{ $mensaje->fecha_actualizacion }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $mensajes->links() !!}
            </div>
        </div>
    </div>
    @include('footer')
@endsection
