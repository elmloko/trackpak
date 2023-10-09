@extends('adminlte::page')
@section('title', 'Paquetes')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Paquetes Certificados Nacionales') }}
                            </span>
                            <div style="display: flex; align-items: center;">
                                <div class="mr-2">
                                    <a href="{{ route('prueba.excel') }}" class="btn btn-success btn-sm"
                                        data-placement="left">
                                        Excel
                                    </a>
                                </div>
                                <div class="mr-2">
                                    <a href="{{ route('prueba.pdf') }}" class="btn btn-danger btn-sm" data-placement="left">
                                        PDF
                                    </a>
                                </div>
                                <div class="mr-2">
                                    <a href="{{ route('packages.create') }}" class="btn btn-primary btn-sm"
                                        data-placement="left">
                                        {{ __('Crear Nuevo') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        @livewire('search-o')
                        <div class="row mt-3">
                            <div class="col-md-6 ">
                                {{ $packages->links() }}
                            </div>
                            <div class="col-md-6 text-right">
                                Se encontraron {{ $packages->total() }} registros en total
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
@endsection
