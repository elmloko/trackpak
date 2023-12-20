<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $mensaje->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('mensajes') }}
            {{ Form::text('mensajes', $mensaje->mensajes, ['class' => 'form-control' . ($errors->has('mensajes') ? ' is-invalid' : ''), 'placeholder' => 'Mensajes']) }}
            {!! $errors->first('mensajes', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('observacion') }}
            {{ Form::text('observacion', $mensaje->observacion, ['class' => 'form-control' . ($errors->has('observacion') ? ' is-invalid' : ''), 'placeholder' => 'Observacion']) }}
            {!! $errors->first('observacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('id_telefono') }}
            {{ Form::text('id_telefono', $mensaje->id_telefono, ['class' => 'form-control' . ($errors->has('id_telefono') ? ' is-invalid' : ''), 'placeholder' => 'Id Telefono']) }}
            {!! $errors->first('id_telefono', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_creacion') }}
            {{ Form::text('fecha_creacion', $mensaje->fecha_creacion, ['class' => 'form-control' . ($errors->has('fecha_creacion') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Creacion']) }}
            {!! $errors->first('fecha_creacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>