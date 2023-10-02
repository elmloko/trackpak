@extends('adminlte::page')
@section('title', 'Paquetes')
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
                            <span class="card-title">{{ __('Show') }} Package</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('packages.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Codigo:</strong>
                            {{ $package->CODIGO }}
                        </div>
                        <div class="form-group">
                            <strong>Destinatario:</strong>
                            {{ $package->DESTINATARIO }}
                        </div>
                        <div class="form-group">
                            <strong>Telefono:</strong>
                            {{ $package->TELEFONO }}
                        </div>
                        <div class="form-group">
                            <strong>Pais:</strong>
                            {{ $package->PAIS }}
                        </div>
                        <div class="form-group">
                            <strong>Cuidad:</strong>
                            {{ $package->CUIDAD }}
                        </div>
                        <div class="form-group">
                            <strong>Zona:</strong>
                            {{ $package->ZONA }}
                        </div>
                        <div class="form-group">
                            <strong>Ventanilla:</strong>
                            {{ $package->VENTANILLA }}
                        </div>
                        <div class="form-group">
                            <strong>Peso:</strong>
                            {{ $package->PESO }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            {{ $package->TIPO }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $package->ESTADO }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
