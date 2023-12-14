@extends('layouts.app')

@section('template_title')
    {{ $national->name ?? "{{ __('Show') National" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} National</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('nationals.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Codigo:</strong>
                            {{ $national->CODIGO }}
                        </div>
                        <div class="form-group">
                            <strong>Nombresdestinatario:</strong>
                            {{ $national->NOMBRESDESTINATARIO }}
                        </div>
                        <div class="form-group">
                            <strong>Nombresremitente:</strong>
                            {{ $national->NOMBRESREMITENTE }}
                        </div>
                        <div class="form-group">
                            <strong>Telefonodestinatario:</strong>
                            {{ $national->TELEFONODESTINATARIO }}
                        </div>
                        <div class="form-group">
                            <strong>Telefonoremitente:</strong>
                            {{ $national->TELEFONOREMITENTE }}
                        </div>
                        <div class="form-group">
                            <strong>Cidestinatario:</strong>
                            {{ $national->CIDESTINATARIO }}
                        </div>
                        <div class="form-group">
                            <strong>Ciremitente:</strong>
                            {{ $national->CIREMITENTE }}
                        </div>
                        <div class="form-group">
                            <strong>Cantidad:</strong>
                            {{ $national->CANTIDAD }}
                        </div>
                        <div class="form-group">
                            <strong>Tiposervicio:</strong>
                            {{ $national->TIPOSERVICIO }}
                        </div>
                        <div class="form-group">
                            <strong>Tipocorrespondencia:</strong>
                            {{ $national->TIPOCORRESPONDENCIA }}
                        </div>
                        <div class="form-group">
                            <strong>Peso:</strong>
                            {{ $national->PESO }}
                        </div>
                        <div class="form-group">
                            <strong>Destino:</strong>
                            {{ $national->DESTINO }}
                        </div>
                        <div class="form-group">
                            <strong>Factura:</strong>
                            {{ $national->FACTURA }}
                        </div>
                        <div class="form-group">
                            <strong>Importe:</strong>
                            {{ $national->IMPORTE }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $national->ESTADO }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
