<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('CODIGO') }}
            {{ Form::text('CODIGO', $international->CODIGO, ['class' => 'form-control' . ($errors->has('CODIGO') ? ' is-invalid' : ''), 'placeholder' => 'Codigo']) }}
            {!! $errors->first('CODIGO', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('DESTINATARIO') }}
            {{ Form::text('DESTINATARIO', $international->DESTINATARIO, ['class' => 'form-control' . ($errors->has('DESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Destinatario']) }}
            {!! $errors->first('DESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('TELEFONO') }}
            {{ Form::text('TELEFONO', $international->TELEFONO, ['class' => 'form-control' . ($errors->has('TELEFONO') ? ' is-invalid' : ''), 'placeholder' => 'Telefono']) }}
            {!! $errors->first('TELEFONO', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('PAIS') }}
            {{ Form::text('PAIS', $international->PAIS, ['class' => 'form-control' . ($errors->has('PAIS') ? ' is-invalid' : ''), 'placeholder' => 'Pais']) }}
            {!! $errors->first('PAIS', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('CUIDAD') }}
            {{ Form::text('CUIDAD', $international->CUIDAD, ['class' => 'form-control' . ($errors->has('CUIDAD') ? ' is-invalid' : ''), 'placeholder' => 'Cuidad']) }}
            {!! $errors->first('CUIDAD', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ZONA') }}
            {{ Form::text('ZONA', $international->ZONA, ['class' => 'form-control' . ($errors->has('ZONA') ? ' is-invalid' : ''), 'placeholder' => 'Zona']) }}
            {!! $errors->first('ZONA', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('VENTANILLA') }}
            {{ Form::text('VENTANILLA', $international->VENTANILLA, ['class' => 'form-control' . ($errors->has('VENTANILLA') ? ' is-invalid' : ''), 'placeholder' => 'Ventanilla']) }}
            {!! $errors->first('VENTANILLA', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('PESO') }}
            {{ Form::text('PESO', $international->PESO, ['class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''), 'placeholder' => 'Peso']) }}
            {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('TIPO') }}
            {{ Form::text('TIPO', $international->TIPO, ['class' => 'form-control' . ($errors->has('TIPO') ? ' is-invalid' : ''), 'placeholder' => 'Tipo']) }}
            {!! $errors->first('TIPO', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ADUANA') }}
            {{ Form::text('ADUANA', $international->ADUANA, ['class' => 'form-control' . ($errors->has('ADUANA') ? ' is-invalid' : ''), 'placeholder' => 'Aduana']) }}
            {!! $errors->first('ADUANA', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ESTADO') }}
            {{ Form::text('ESTADO', $international->ESTADO, ['class' => 'form-control' . ($errors->has('ESTADO') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('ESTADO', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ISO') }}
            {{ Form::text('ISO', $international->ISO, ['class' => 'form-control' . ($errors->has('ISO') ? ' is-invalid' : ''), 'placeholder' => 'Iso']) }}
            {!! $errors->first('ISO', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('PRECIO') }}
            {{ Form::text('PRECIO', $international->PRECIO, ['class' => 'form-control' . ($errors->has('PRECIO') ? ' is-invalid' : ''), 'placeholder' => 'Precio']) }}
            {!! $errors->first('PRECIO', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('OBSERVACIONES') }}
            {{ Form::text('OBSERVACIONES', $international->OBSERVACIONES, ['class' => 'form-control' . ($errors->has('OBSERVACIONES') ? ' is-invalid' : ''), 'placeholder' => 'Observaciones']) }}
            {!! $errors->first('OBSERVACIONES', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('usercartero') }}
            {{ Form::text('usercartero', $international->usercartero, ['class' => 'form-control' . ($errors->has('usercartero') ? ' is-invalid' : ''), 'placeholder' => 'Usercartero']) }}
            {!! $errors->first('usercartero', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>