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
                                {{ __('Paquetes Certificados Nacionales') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('packages.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Crear Nuevo') }}
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
                                        
										<th>Codigo Postal</th>
										<th>Destinatario</th>
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
                                    @foreach ($packages as $package)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $package->CODIGO }}</td>
											<td>{{ $package->DESTINATARIO }}</td>
											<td>{{ $package->TELEFONO }}</td>
											<td>{{ $package->PAIS }}</td>
											<td>{{ $package->CUIDAD }}</td>
											<td>{{ $package->ZONA }}</td>
											<td>{{ $package->VENTANILLA }}</td>
											<td>{{ $package->PESO }}</td>
											<td>{{ $package->TIPO }}</td>
											<td>{{ $package->ESTADO }}</td>
                                            <td>{{ $package->created_at }}</td>

                                            <td>
                                                <form action="{{ route('packages.destroy',$package->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-success" href="{{ route('packages.edit',$package->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Se encontraron {{ $packages->currentPage() }} de {{ $packages->lastPage() }} Paginas
                    </div>
                    <div class="mt-8">
                        {{$packages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('footer')
@endsection
