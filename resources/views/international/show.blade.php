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
                            <span class="card-title">{{ __('Show') }} International</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('internationals.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Codigo:</strong>
                            {{ $international->CODIGO }}
                        </div>
                        <div class="form-group">
                            <strong>Destinatario:</strong>
                            {{ $international->DESTINATARIO }}
                        </div>
                        <div class="form-group">
                            <strong>Telefono:</strong>
                            {{ $international->TELEFONO }}
                        </div>
                        <div class="form-group">
                            <strong>Pais:</strong>
                            {{ $international->PAIS }}
                        </div>
                        <div class="form-group">
                            <strong>Cuidad:</strong>
                            {{ $international->CUIDAD }}
                        </div>
                        <div class="form-group">
                            <strong>Zona:</strong>
                            {{ $international->ZONA }}
                        </div>
                        <div class="form-group">
                            <strong>Ventanilla:</strong>
                            {{ $international->VENTANILLA }}
                        </div>
                        <div class="form-group">
                            <strong>Peso:</strong>
                            {{ $international->PESO }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            {{ $international->TIPO }}
                        </div>
                        <div class="form-group">
                            <strong>Aduana:</strong>
                            {{ $international->ADUANA }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $international->ESTADO }}
                        </div>
                        <div class="form-group">
                            <strong>Iso:</strong>
                            {{ $international->ISO }}
                        </div>
                        <div class="form-group">
                            <strong>Precio:</strong>
                            {{ $international->PRECIO }}
                        </div>
                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            {{ $international->OBSERVACIONES }}
                        </div>
                        <div class="form-group">
                            <strong>Usercartero:</strong>
                            {{ $international->usercartero }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('footer')
@endsection
