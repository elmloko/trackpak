@extends('adminlte::page')
@section('title', 'Editar Paquetes Ordinarios')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Paquetes</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('packages.update', $package->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @include('package.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('footer')
@endsection
