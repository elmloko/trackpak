@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Role Has Permission</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('role-has-permissions.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('role-has-permission.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('footer')
@endsection
