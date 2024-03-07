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
                            <span class="card-title">{{ __('Show') }} Packages Has Bag</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('packages-has-bags.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Bags Id:</strong>
                            {{ $packagesHasBag->bags_id }}
                        </div>
                        <div class="form-group">
                            <strong>Packages Id:</strong>
                            {{ $packagesHasBag->packages_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('footer')
@endsection
