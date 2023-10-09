@extends('adminlte::page')
@section('title', 'Paquetes')
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
                                {{ __('Paquetes Certificados') }}
                            </span>
                            <div style="display: flex; align-items: center;">
                                <div class="mr-2">
                                    <a href="{{ route('prueba1.excel') }}" class="btn btn-success btn-sm"
                                        data-placement="left">
                                        Excel
                                    </a>
                                </div>
                                <div class="mr-2">
                                    <a href="{{ route('prueba1.pdf') }}" class="btn btn-danger btn-sm"
                                        data-placement="left">
                                        PDF
                                    </a>
                                </div>
                                <div class="mr-2">
                                    <a href="{{ route('pcertificates.create') }}" class="btn btn-primary btn-sm"
                                        data-placement="left">
                                        {{ __('Crear Nuevo') }}
                                    </a>
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

                                        <th>Codigo Postal</th>
                                        <th>Destinatario</th>
                                        <th>Direccion</th>
                                        <th>Telefono</th>
                                        <th>Pais</th>
                                        <th>Cuidad</th>
                                        <th>Zona</th>
                                        <th>Ventanilla</th>
                                        <th>Peso</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Fecha Ingreso</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pcertificates as $pcertificate)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $pcertificate->CODIGO }}</td>
                                            <td>{{ $pcertificate->DESTINATARIO }}</td>
                                            <td>{{ $pcertificate->DIRECCION }}</td>
                                            <td>{{ $pcertificate->TELEFONO }}</td>
                                            <td>{{ $pcertificate->PAIS }}</td>
                                            <td>{{ $pcertificate->CUIDAD }}</td>
                                            <td>{{ $pcertificate->ZONA }}</td>
                                            <td>{{ $pcertificate->VENTANILLA }}</td>
                                            <td>{{ $pcertificate->PESO }}</td>
                                            <td>{{ $pcertificate->TIPO }}</td>
                                            <td>{{ $pcertificate->ESTADO }}</td>
                                            <td>{{ $pcertificate->created_at }}</td>
                                            <td>
                                                <form action="{{ route('pcertificates.destroy', $pcertificate->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-warning"
                                                        href="{{ route('pcertificates.delete', $pcertificate->id) }}"><i
                                                            class="fa fa-arrow-down"></i> {{ __('Baja') }}</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('pcertificates.edit', $pcertificate->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                {{ $pcertificates->links() }}
                            </div>
                            <div class="col-md-6 text-right">
                                Se encontraron {{ $pcertificates->total() }} registros en total
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
@endsection
