@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elementos Eliminados</h1>
        @if($deletedPackages->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deletedPackages as $package)
                        <tr>
                            <td>{{ $package->CODIGO }}</td>
                            <td>{{ $package->DESTINATARIO }}</td>
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
