@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    <div class="container">
        <h2>Lista de Backups Disponibles</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Botón para ejecutar el backup -->
        <form action="{{ route('run-backup') }}" method="GET">
            <button type="submit" class="btn btn-primary">
                Ejecutar Respaldo
            </button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Nombre del Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    <tr>
                        <td>{{ basename($file) }}</td>
                        <td>
                            <a href="{{ route('backups.download', basename($file)) }}" class="btn btn-success">Descargar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('footer')
@endsection
