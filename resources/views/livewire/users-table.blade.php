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
                                <a href="{{ route('users.excel') }}" class="btn btn-success btn-sm"
                                    data-placement="left">Excel</a>
                            </div>
                            <div class="mr-2">
                                <a href="{{ route('users.pdf') }}" class="btn btn-danger btn-sm"
                                    data-placement="left">PDF</a>
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

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="card-body">
                    <!-- Barra de búsqueda con botón de búsqueda -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" wire:model="search" class="form-control"
                                placeholder="Buscar por nombre o email...">
                        </div>
                        <div class="col-md-2">
                            <button wire:click="searchUsers" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Nombre Completo</th>
                                    <th>Email</th>
                                    <th>Contraseña</th>
                                    <th>Regional</th>
                                    <th>Carnet Identidad</th>
                                    <th>Estado</th>
                                    <th>Nivel de Usuario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ str_repeat('*', min(12, strlen($user->password))) }}</td>
                                        <td>{{ $user->Regional }}</td>
                                        <td>{{ $user->ci }}</td>
                                        <td><span class="badge {{ $user->trashed() ? 'badge-danger' : 'badge-info' }}">
                                                {{ $user->trashed() ? 'Inactivo' : 'Activo' }}
                                            </span></td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span class="badge badge-info">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($user->trashed())
                                                <button wire:click="restore({{ $user->id }})"
                                                    class="btn btn-sm btn-success">
                                                    <i class="fa fa-arrow-up"></i> {{ __('Alta') }}
                                                </button>
                                            @else
                                                <button wire:click="delete({{ $user->id }})"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fa fa-arrow-down"></i> {{ __('Baja') }}
                                                </button>
                                                <a class="btn btn-sm btn-success"
                                                    href="{{ route('users.edit', $user->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                                </a>
                                                @hasrole('SuperAdmin')
                                                    <button wire:click="setPasswordUser({{ $user->id }})"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fa fa-key"></i> {{ __('Cambiar Contraseña') }}
                                                    </button>
                                                @endhasrole
                                            @endif
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

    <!-- Modal para cambiar la contraseña -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="password" wire:model="newPassword" class="form-control" placeholder="Nueva Contraseña">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" wire:click="updatePassword" class="btn btn-primary">Actualizar
                        Contraseña</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para controlar el modal -->
<script>
    window.addEventListener('openModal', event => {
        $('#changePasswordModal').modal('show');
    });

    window.addEventListener('closeModal', event => {
        $('#changePasswordModal').modal('hide');
    });
</script>
