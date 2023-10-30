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
                            <span class="card-title">{{ __('Show') }} Event</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('events.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Action:</strong>
                            {{ $event->action }}
                        </div>
                        <div class="form-group">
                            <strong>User Id:</strong>
                            {{ $event->user_id }}
                        </div>
                        <div class="form-group">
                            <strong>Codigo:</strong>
                            {{ $event->codigo }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
