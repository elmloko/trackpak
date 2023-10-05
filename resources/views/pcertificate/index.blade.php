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

                            <div class="float-right">
                                <a href="{{ route('prueba.excel') }}" class="btn btn-success btn-sm" data-placement="left">
                                    Excel</a>
                                <a href="{{ route('prueba.pdf') }}" class="btn btn-danger btn-sm" data-placement="left">
                                    PDF</a>
                                <a href="{{ route('pcertificates.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Crear Nuevo') }}
                                </a>
                            </div>
                            <div>
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                        
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                        
                                <form action="{{ route('prueba1.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="file" name="file" id="file" class="form-control-file" accept=".xlsx, .csv" required onchange="this.form.submit()">
                                    </div>
                                </form>
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
                    </div>
                </div>
                {!! $pcertificates->links() !!}
            </div>
        </div>
    </div>
    @include('footer')
@endsection
