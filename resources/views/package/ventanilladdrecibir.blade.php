@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @hasrole('SuperAdmin|Administrador|ENCOMIENDAS')
        @livewire('ventanilladdrecibir')
    @endhasrole
    @include('footer')
@endsection
