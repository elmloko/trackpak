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
                            <span class="card-title">{{ __('Show') }} Mensaje</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('mensajes.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $mensaje->estado }}
                        </div>
                        <div class="form-group">
                            <strong>Mensajes:</strong>
                            {{ $mensaje->mensajes }}
                        </div>
                        <div class="form-group">
                            <strong>Observacion:</strong>
                            {{ $mensaje->observacion }}
                        </div>
                        <div class="form-group">
                            <strong>Id Telefono:</strong>
                            {{ $mensaje->id_telefono }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Creacion:</strong>
                            {{ $mensaje->fecha_creacion }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('footer')
@endsection
