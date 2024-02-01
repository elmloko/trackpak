@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Bag</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('bags.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nrodespacho:</strong>
                            {{ $bag->NRODESPACHO }}
                        </div>
                        <div class="form-group">
                            <strong>Ofcambio:</strong>
                            {{ $bag->OFCAMBIO }}
                        </div>
                        <div class="form-group">
                            <strong>Ofdestino:</strong>
                            {{ $bag->OFDESTINO }}
                        </div>
                        <div class="form-group">
                            <strong>Nrosacas:</strong>
                            {{ $bag->NROSACAS }}
                        </div>
                        <div class="form-group">
                            <strong>Peso:</strong>
                            {{ $bag->PESO }}
                        </div>
                        <div class="form-group">
                            <strong>Paquetes:</strong>
                            {{ $bag->PAQUETES }}
                        </div>
                        <div class="form-group">
                            <strong>Itinerario:</strong>
                            {{ $bag->ITINERARIO }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $bag->ESTADO }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('footer')
@endsection