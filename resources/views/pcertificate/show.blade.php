@extends('layouts.app')

@section('template_title')
    {{ $pcertificate->name ?? "{{ __('Show') Pcertificate" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Pcertificate</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('pcertificates.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Codigo:</strong>
                            {{ $pcertificate->CODIGO }}
                        </div>
                        <div class="form-group">
                            <strong>Destinatario:</strong>
                            {{ $pcertificate->DESTINATARIO }}
                        </div>
                        <div class="form-group">
                            <strong>Direccion:</strong>
                            {{ $pcertificate->DIRECCION }}
                        </div>
                        <div class="form-group">
                            <strong>Telefono:</strong>
                            {{ $pcertificate->TELEFONO }}
                        </div>
                        <div class="form-group">
                            <strong>Pais:</strong>
                            {{ $pcertificate->PAIS }}
                        </div>
                        <div class="form-group">
                            <strong>Cuidad:</strong>
                            {{ $pcertificate->CUIDAD }}
                        </div>
                        <div class="form-group">
                            <strong>Zona:</strong>
                            {{ $pcertificate->ZONA }}
                        </div>
                        <div class="form-group">
                            <strong>Ventanilla:</strong>
                            {{ $pcertificate->VENTANILLA }}
                        </div>
                        <div class="form-group">
                            <strong>Peso:</strong>
                            {{ $pcertificate->PESO }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            {{ $pcertificate->TIPO }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $pcertificate->ESTADO }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
