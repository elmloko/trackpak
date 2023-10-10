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
                            <div style="display: flex; align-items: center;">
                                <div class="mr-2">
                                    <a href="{{ route('prueba.excel') }}" class="btn btn-success btn-sm"
                                        data-placement="left">
                                        Excel
                                    </a>
                                </div>
                                <div class="mr-2">
                                    <a href="{{ route('prueba.pdf') }}" class="btn btn-danger btn-sm" data-placement="left">
                                        PDF
                                    </a>
                                </div>
                                <div class="mr-2">
                                    <a href="{{ route('packages.create') }}" class="btn btn-primary btn-sm"
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
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="px-6 py-4">
                                    <input type="text" wire:model="search-o"
                                        class="w-full bg-gray-100 rounded-full py-2 px-4 mb-2 md:mb-0 text-black" placeholder="Busca">
                                </div>
                                @php
                                $i = 0; // Inicializa la variable $i
                                @endphp
                                <table class="table table-striped table-hover">
                                    <thead class="thead">
                                        <tr>
                                            <th>No</th>
                        
                                            <th>Codigo Postal</th>
                                            <th>Destinatario</th>
                                            <th>Telefono</th>
                                            <th>Pais</th>
                                            <th>Ciudad</th>
                                            <th>Zona</th>
                                            <th>Ventanilla</th>
                                            <th>Peso</th>
                                            <th>Tipo</th>
                                            <th>Estado</th>
                                            <th>Fecha Ingreso</th>
                                            <th>Acciones</th>
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
                                            <td>{{ $package->CIUDAD }}</td>
                                            <td>{{ $package->ZONA }}</td>
                                            <td>{{ $package->VENTANILLA }}</td>
                                            <td>{{ $package->PESO }}</td>
                                            <td>{{ $package->TIPO }}</td>
                                            <td>{{ $package->ESTADO }}</td>
                                            <td>{{ $package->created_at }}</td>
                        
                                            <td>
                                                <form action="{{ route('packages.destroy', $package->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-warning" href="{{ route('packages.delete', $package->id) }}"><i
                                                            class="fa fa-arrow-down"></i> {{ __('Baja') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('packages.edit', $package->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i>
                                                        {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        {{-- @livewire('search-o') --}}
                        <div class="row mt-3">
                            <div class="col-md-6 ">
                                {{ $packages->links() }}
                            </div>
                            <div class="col-md-6 text-right">
                                Se encontraron {{ $packages->total() }} registros en total
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
@endsection
