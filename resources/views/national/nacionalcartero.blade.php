@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @hasrole('Unica')
        @livewire('nacionalcartero')
    @endhasrole
    @hasrole('SuperAdmin|Administrador')
        @livewire('nacionalcarterogeneral')
    @endhasrole
    @include('footer')
@endsection
