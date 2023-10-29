@extends('adminlte::page')

@section('title', 'Paquetes Ordinarios')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h5 id="card_title">
                                    {{ __('Inventario de Paquetes en Entregados') }}
                                </h5>
                            </div>
                            <div style="display: flex; align-items: center;">
                                {{-- <div class="mr-2">
                                    <a href="{{ route('prueba.excel') }}" class="btn btn-success btn-sm"
                                        data-placement="left">
                                        Excel
                                    </a>
                                </div>
                                <div class="mr-2">
                                    <a href="{{ route('prueba.pdf') }}" class="btn btn-danger btn-sm" data-placement="left">
                                        PDF
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($deleteadoPackages->count() > 0)
                    <div class="card-body">
                        <div class="card-body">
                            <div class="table-responsive">
                                @php
                                $i = 0; // Inicializa la variable $i
                                @endphp
                                <table class="table table-striped table-hover">
                                    <thead class="thead">
                                        <tr>
                                            <th>No</th>
                        
                                            <th>Código Postal</th>
                                            <th>Destinatario</th>
                                            <th>Telefono</th>
                                            <th>Pais</th>
                                            <th>Ciudad</th>
                                            <th>Zona</th>
                                            <th>Ventanilla</th>
                                            <th>Peso</th>
                                            <th>Tipo</th>
                                            <th>Estado</th>
                                            <th>Aduana</th>
                                            <th>Fecha Baja</th>
                                            <th>Acciones</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deleteadoPackages as $package)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                        
                                            <td>{{ $package->CODIGO }}</td>
                                            <td>{{ $package->DESTINATARIO }}</td>
                                            <td>{{ $package->TELEFONO }}</td>
                                            <td>{{ $package->PAIS }}</td>
                                            <td>{{ $package->CIUDAD }}</td>
                                            <td>{{ $package->ZONA }}</td>
                                            <td>{{ $package->VENTANILLA }}</td>
                                            <td>{{ $package->PESO }}</td>
                                            <td>{{ $package->TIPO }}</td>
                                            <td>{{ $package->ESTADO }}</td>
                                            <td>{{ $package->ADUANA }}</td>
                                            <td>{{ $package->deleted_at }}</td>
                                            <td>
                                                @hasrole('SuperAdmin|Administrador|Urbano')
                                                <form action="{{ route('packages.restoring', $package->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn btn-info"">
                                                        <i class="fa fa-arrow-up"></i> {{ __('Alta') }}
                                                    </button>
                                                </form>
                                                @endhasrole
                                            </td>                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        <div class="row mt-3">
                            <div class="col-md-6 ">
                                {{ $deleteadoPackages->links() }}
                            </div>
                            <div class="col-md-6 text-right">
                                Se encontraron {{ $deleteadoPackages->total() }} registros en total
                            </div>
                            @else
                            <p>No hay elementos eliminados.</p>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
@endsection
