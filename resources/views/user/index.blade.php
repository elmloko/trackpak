@extends('adminlte::page')
@section('title', 'Usuarios')
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
                                {{ __('Usuarios') }}
                            </span>
                            <div style="display: flex; align-items: center;">
                                <div class="mr-2">
                                    <a href="{{ route('usuario1.excel') }}" class="btn btn-success btn-sm"
                                        data-placement="left">
                                        Excel
                                    </a>
                                </div>
                                <div class="mr-2">
                                    <a href="{{ route('usuario1.pdf') }}" class="btn btn-danger btn-sm"
                                        data-placement="left">
                                        PDF
                                    </a>
                                </div>
                                <div class="float-right">
                                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right"
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
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

                                        <th>Nombre Completo</th>
                                        <th>Email</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>

                                            <td>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('users.edit', $user->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-fw fa-trash"></i>
                                                        {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                {{ $users->links() }}
                            </div>
                            <div class="col-md-6 text-right">
                                Se encontraron {{ $users->total() }} registros en total
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('footer')
    </div>
@endsection
