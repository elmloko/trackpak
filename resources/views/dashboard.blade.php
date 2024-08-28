@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Sistema de Paquetes Ordinario/ Casillas Postales/ Envios de Correspondencia Agrupada/ Encomiendas Nacionales de la
        Agencia Boliviana de Correos</h1>
@stop

@section('content')
    @hasrole('SuperAdmin|Administrador')
        @livewire('dashboard-admini')
    @endhasrole
    @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
        @livewire('dashboard-clasificacion')
    @endhasrole
    @hasrole('SuperAdmin|Administrador|Urbano|Auxiliar Urbano')
        @livewire('dashboard-urbano')
    @endhasrole
    @hasrole('SuperAdmin|Administrador|DND')
        @livewire('dashboarddnd')
    @endhasrole
    @hasrole('SuperAdmin|Administrador|Casillas')
        @livewire('dashboard-casillas')
    @endhasrole
    @hasrole('SuperAdmin|Administrador|ENCOMIENDAS')
        @livewire('dashboard-encomienda')
    @endhasrole
    @hasrole('SuperAdmin|Administrador|ECA')
        @livewire('dashboard-eca')
    @endhasrole
    @hasrole('SuperAdmin|Administrador|Unica')
        @livewire('dashboard-unica')
    @endhasrole
    @include('footer')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stop
