@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @livewire('despachocarterogeneral')
    @include('footer')
@endsection
