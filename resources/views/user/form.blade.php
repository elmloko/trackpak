<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group">
            {{ Form::label('Nombre Completo') }}
            {{ Form::text('name', $user->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nombre Completo']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('email') }}
            {{ Form::text('email', $user->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email']) }}
            {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Contraseña') }}
            {{ Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => 'Contraseña']) }}
            {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Regional') }}
            {{ Form::select('Regional', ['LA PAZ' => 'LA PAZ', 'COCHABAMBA' => 'COCHABAMBA', 'SANTA CRUZ' => 'SANTA CRUZ', 'ORURO' => 'ORURO', 'POTOSI' => 'POTOSI', 'TARIJA' => 'TARIJA', 'CHUQUISACA' => 'CHUQUISACA', 'BENI' => 'BENI', 'PANDO' => 'PANDO'], $user->Regional, ['class' => 'form-control' . ($errors->has('Regional') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Regional']) }}
            {!! $errors->first('Regional', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <h2 class="h5">Listado de Roles</h2>
        @foreach ($roles as $role)
            <div>
                <label>
                    {!! Form::checkbox('roles[]', $role->id, $user->hasRole($role->name), ['class' => 'mr-1']) !!}
                    {{ $role->name }}
                </label>
            </div>
        @endforeach
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Listo') }}</button>
    </div>
</div>
