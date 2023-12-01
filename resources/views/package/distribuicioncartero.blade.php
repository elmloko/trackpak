@extends('adminlte::page')

@section('title', 'Paquetes Ordinarios')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h5 id="card_title">
                                            {{ __('Entregas de Paquetes en Carteros') }}
                                        </h5>
                                    </div>

                                    <div>
                                        @livewire('tabla-paquetes')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Agrega el pie de página o cualquier otro contenido necesario -->
    @include('footer')
@endsection
