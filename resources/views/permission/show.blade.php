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
                            <span class="card-title">{{ __('Show') }} Permission</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('permissions.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $permission->name }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('footer')
@endsection
