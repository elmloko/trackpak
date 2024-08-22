@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @hasrole('SuperAdmin|Administrador')
        @livewire('ventanillaunicarecibiradmin')
    @endhasrole
    @hasrole('Unica')
        @livewire('ventanillaunicarecibir')
    @endhasrole
    @include('footer')
@endsection
