
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Seguimiento de Paqueteria de Agencia Boliviana de Correos</h1>
@stop

@section('content')
    <p>Panel de Control</p>
    
@include('footer')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
