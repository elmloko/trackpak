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
                                <a href="{{ route('mensajes.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
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

                                        <th>Estado</th>
                                        <th>Mensajes</th>
                                        <th>Observacion</th>
                                        <th>codigo</th>
                                        <th>Telefono</th>

                                        <th>Destinatario</th>

                                        <th>Fecha Creacion</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mensajes as $mensaje)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $mensaje->estado }}</td>
                                            <td>{{ $mensaje->mensajes }}</td>
                                            <td>{{ $mensaje->observacion }}</td>
                                            <td>{{ $mensaje->package->CODIGO }}</td>
                                            <td>{{ $mensaje->package->TELEFONO }}</td>
                                            <td>{{ $mensaje->package->DESTINATARIO }}</td>
                                            <td>{{ $mensaje->fecha_creacion }}</td>

                                            <td>
                                                <form action="{{ route('mensajes.destroy', $mensaje->id) }}"
                                                    method="POST">
                                                    {{-- <a class="btn btn-sm btn-primary "
                                                        href="{{ route('mensajes.show', $mensaje->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a> --}}
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('mensajes.edit', $mensaje->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
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
