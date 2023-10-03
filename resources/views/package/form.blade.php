<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <!-- Primeras columnas del formulario -->
                <div class="form-group">
                    {{ Form::label('CODIGO') }}
                    {{ Form::text('CODIGO', $package->CODIGO, ['class' => 'form-control' . ($errors->has('CODIGO') ? ' is-invalid' : ''), 'placeholder' => 'Codigo']) }}
                    {!! $errors->first('CODIGO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('DESTINATARIO') }}
                    {{ Form::text('DESTINATARIO', $package->DESTINATARIO, ['class' => 'form-control' . ($errors->has('DESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Destinatario']) }}
                    {!! $errors->first('DESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TELEFONO') }}
                    {{ Form::text('TELEFONO', $package->TELEFONO, ['class' => 'form-control' . ($errors->has('TELEFONO') ? ' is-invalid' : ''), 'placeholder' => 'Telefono']) }}
                    {!! $errors->first('TELEFONO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('PAIS') }}
                    {{ Form::text('PAIS', $package->PAIS, ['class' => 'form-control' . ($errors->has('PAIS') ? ' is-invalid' : ''), 'placeholder' => 'Pais']) }}
                    {!! $errors->first('PAIS', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('CUIDAD') }}
                    {{ Form::select('CUIDAD', ['La Paz' => 'La Paz', 'Cochabamba' => 'Cochabamba', 'Santa Cruz' => 'Santa Cruz', 'Oruro' => 'Oruro', 'Potosi' => 'Potosi', 'Tarija' => 'Tarija', 'Chuquisaca' => 'Chuquisaca', 'Beni' => 'Beni', 'Pando' => 'Pando'], $package->CUIDAD, ['class' => 'form-control' . ($errors->has('CUIDAD') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Cuidad']) }}
                    {!! $errors->first('CUIDAD', '<div class="invalid-feedback">:message</div>') !!}
                </div>

                <!-- Fin de las primeras columnas -->
            </div>
            <div class="col-md-6">
                <!-- Segundas columnas del formulario -->
                <div class="form-group">
                    {{ Form::label('VENTANILLA') }}
                    {{ Form::select('VENTANILLA', ['32' => '32', '33' => '33', '7' => '7', 'UNICA' => 'UNICA'], $package->VENTANILLA, ['class' => 'form-control' . ($errors->has('VENTANILLA') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Ventanilla']) }}
                    {!! $errors->first('VENTANILLA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('PESO') }}
                    {{ Form::text('PESO', $package->PESO, ['class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''), 'placeholder' => 'Peso']) }}
                    {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TIPO', 'Tipo') }}
                    {{ Form::select('TIPO', ['Paquete' => 'Paquete', 'Sobre' => 'Sobre'], $package->TIPO, ['class' => 'form-control' . ($errors->has('TIPO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el tipo de paquete']) }}
                    {!! $errors->first('TIPO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('ESTADO') }}
                    {{ Form::select('ESTADO', ['Almacen' => 'Almacen', 'Transito' => 'Transito', 'Pendiente' => 'Pendiente', 'Pre-Return' => 'Pre-Return'], $package->ESTADO, ['class' => 'form-control' . ($errors->has('ESTADO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el estado en el cual se encuentra el paquete']) }}
                    {!! $errors->first('ESTADO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('ZONA') }}
                    {{ Form::text('ZONA', $package->ZONA, ['class' => 'form-control' . ($errors->has('ZONA') ? ' is-invalid' : ''), 'placeholder' => 'Zona']) }}
                    {!! $errors->first('ZONA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <!-- Fin de las segundas columnas -->
            </div>
        </div>
    </div>
    <div class="box-footer mt20">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        </div>
    </div>
</div>
