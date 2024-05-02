@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @hasrole('SuperAdmin|Administrador')
        @livewire('ventanillaunicaadmin')
    @endhasrole
    @hasrole('Unica')
        @livewire('ventanillaunica')
    @endhasrole
    @include('footer')
@endsection
