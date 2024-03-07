@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @livewire('bag-show', ['id' => $bagId])
    @include('footer')
@endsection
