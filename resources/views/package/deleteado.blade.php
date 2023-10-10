@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elementos Eliminados</h1>
        @if($deletedPackages->count() > 0)
            <table class="table">
                <thead>
                    <tr>
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
                        <th>Fecha Salida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deletedPackages as $package)
                        <tr>
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
                            <td>{{ $package->deleted_at }}</td>
                            <td>
                                <a href="{{ route('package.restore', $package->id) }}" class="btn btn-primary">Restaurar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $deletedPackages->links() }}
        @else
            <p>No hay elementos eliminados.</p>
        @endif
    </div>
@endsection
