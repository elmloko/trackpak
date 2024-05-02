@extends('adminlte::page')

@section('title', 'Paquetes Ordinarios')

@section('content')
    @hasrole('Unica')
        @livewire('deleteadounica')
    @endhasrole
    @hasrole('SuperAdmin|Administrador')
        @livewire('deleteadounicaadmin')
    @endhasrole
    @include('footer')
@endsection
