<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('CODIGO POSTAL') }}
                    {{ Form::text('CODIGO', $pcertificate->CODIGO, ['class' => 'form-control' . ($errors->has('CODIGO') ? ' is-invalid' : ''), 'placeholder' => 'Codigo Postal']) }}
                    {!! $errors->first('CODIGO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('DESTINATARIO') }}
                    {{ Form::text('DESTINATARIO', $pcertificate->DESTINATARIO, ['class' => 'form-control' . ($errors->has('DESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Destinatario']) }}
                    {!! $errors->first('DESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('DIRECCION') }}
                    {{ Form::text('DIRECCION', $pcertificate->DIRECCION, ['class' => 'form-control' . ($errors->has('DIRECCION') ? ' is-invalid' : ''), 'placeholder' => 'Direccion']) }}
                    {!! $errors->first('DIRECCION', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TELEFONO') }}
                    {{ Form::text('TELEFONO', $pcertificate->TELEFONO, ['class' => 'form-control' . ($errors->has('TELEFONO') ? ' is-invalid' : ''), 'placeholder' => 'Telefono']) }}
                    {!! $errors->first('TELEFONO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('ESTADO') }}
                    {{ Form::select('ESTADO',['ALMACEN' => 'ALMACEN', 'TRANSITO' => 'TRANSITO','PENDIENTE' => 'PENDIENTE','PRE-RETURN' => 'PRE-RETURN'], $pcertificate->ESTADO, ['class' => 'form-control' . ($errors->has('ESTADO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el estado en el cual se encuentra el paquete']) }}
                    {!! $errors->first('ESTADO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('PAIS') }}
                    {{ Form::text('PAIS', $pcertificate->PAIS, ['class' => 'form-control' . ($errors->has('PAIS') ? ' is-invalid' : ''), 'placeholder' => 'Pais']) }}
                    {!! $errors->first('PAIS', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('CUIDAD') }}
                    {{ Form::select('CUIDAD', ['LA PAZ' => 'LA PAZ', 'COCHABAMBA' => 'COCHABAMBA', 'SANTA CRUZ' => 'SANTA CRUZ', 'ORURO' => 'ORURO', 'POTOSI' => 'POTOSI', 'TARIJA' => 'TARIJA', 'CHUQUISACA' => 'CHUQUISACA', 'BENI' => 'BENI', 'PANDO' => 'PANDO'], $pcertificate->CUIDAD, ['class' => 'form-control' . ($errors->has('CUIDAD') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Cuidad']) }}
                    {!! $errors->first('CUIDAD', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('ZONA') }}
                    {{ Form::text('ZONA', $pcertificate->ZONA, ['class' => 'form-control' . ($errors->has('ZONA') ? ' is-invalid' : ''), 'placeholder' => 'Zona']) }}
                    {!! $errors->first('ZONA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('VENTANILLA') }}
                    {{ Form::select('VENTANILLA',['32' => '32', '33' => '33', '7' => '7', 'UNICA' => 'UNICA'], $pcertificate->VENTANILLA, ['class' => 'form-control' . ($errors->has('VENTANILLA') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Ventanilla']) }}
                    {!! $errors->first('VENTANILLA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('PESO') }}
                    {{ Form::text('PESO', $pcertificate->PESO, ['class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''), 'placeholder' => 'Peso']) }}
                    {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TIPO') }}
                    {{ Form::select('TIPO', ['PAQUETE' => 'PAQUETE', 'SOBRE' => 'SOBRE'], $pcertificate->TIPO, ['class' => 'form-control' . ($errors->has('TIPO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el tipo de paquete']) }}
                    {!! $errors->first('TIPO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer mt20">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        </div>
    </div>
</div>
