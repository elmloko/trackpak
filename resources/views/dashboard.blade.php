@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Sistema de Paquetes Ordinario/ Casillas Postales/ Envios de Correspondencia Agrupada/ Encomiendas Nacionales de la
        Agencia Boliviana de Correos</h1>
@stop

@section('content')
    @hasrole('SuperAdmin')
    @endhasrole
    @hasrole('Administrador')
    @endhasrole
    @hasrole('Clasificacion|Auxiliar Clasificacion')
    @endhasrole
    @hasrole('ENCOMIENDAS')
    @endhasrole
    @hasrole('Urbano|Auxiliar Urbano')
        @livewire('dashboard-urbano')
    @endhasrole
    @hasrole('DND')
        @livewire('dashboarddnd')
    @endhasrole
    @hasrole('Casillas')
    @endhasrole
    @hasrole('ECA')
    @endhasrole
    @hasrole('Unica')
    @endhasrole
    @include('footer')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stop
