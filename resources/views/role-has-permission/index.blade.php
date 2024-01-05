@extends('adminlte::page')
@section('title', 'Paquetes Ordinarios')
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
                                {{ __('Role Has Permission') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('role-has-permissions.create') }}"
                                    class="btn btn-primary btn-sm float-right" data-placement="left">
                                    {{ __('Create New') }}
                                </a>
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

                                        <th>Permission Id</th>
                                        <th>Role Id</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roleHasPermissions as $roleHasPermission)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $permissions[$roleHasPermission->permission_id] }}</td>
                                            <td>{{ $roles[$roleHasPermission->role_id] }}</td>

                                            {{-- <td>
                                                <form action="{{ route('role-has-permissions.destroy',$roleHasPermission->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('role-has-permissions.show',$roleHasPermission->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $roleHasPermissions->links() !!}
            </div>
        </div>
    </div>
    @include('footer')
@endsection
