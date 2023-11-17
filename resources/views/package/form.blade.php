<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <!-- Primeras columnas del formulario -->
                <div class="form-group">
                    {{ Form::label('CODIGO RASTREO') }}
                    {{ Form::text('CODIGO', strtoupper($package->CODIGO), [
                        'class' => 'form-control' . ($errors->has('CODIGO') ? ' is-invalid' : ''),
                        'placeholder' => 'Codigo',
                        'pattern' => '^[A-Z0-9]+$',// Solo letras mayúsculas y números, al menos uno
                        'title' => 'Ingrese solo letras mayúsculas y números',
                        'maxlength' => '20',
                        'style' => 'text-transform: uppercase;', // Mostrar todo en mayúsculas visualmente
                    ]) }}
                    {!! $errors->first('CODIGO', '<div class="invalid-feedback">:message</div>') !!}
                </div>                
                <div class="form-group">
                    {{ Form::label('DESTINATARIO') }}
                    {{ Form::text('DESTINATARIO', strtoupper($package->DESTINATARIO), [
                        'class' => 'form-control' . ($errors->has('DESTINATARIO') ? ' is-invalid' : ''),
                        'placeholder' => 'Destinatario',
                        // 'pattern' => '^[A-Z]+$',
                        'title' => 'Ingrese solo letras mayúsculas',
                        // 'style' => 'text-transform: uppercase;', // Mostrar todo en mayúsculas visualmente
                    ]) }}
                    {!! $errors->first('DESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TELEFONO') }}
                    {{ Form::number('TELEFONO', $package->TELEFONO, [
                        'class' => 'form-control' . ($errors->has('TELEFONO') ? ' is-invalid' : ''),
                        'placeholder' => 'Telefono',
                        'pattern' => '^[0-9]*$', // Solo números
                        'title' => 'Ingrese solo números',
                        'autocomplete' => 'off', // Desactivar autocompletar
                    ]) }}
                    {!! $errors->first('TELEFONO', '<div class="invalid-feedback">:message</div>') !!}
                </div>                                                           
                <div class="form-group">
                    {{ Form::label('CUIDAD') }}
                    {{ Form::select('CUIDAD', ['LA PAZ' => 'LA PAZ', 'COCHABAMBA' => 'COCHABAMBA', 'SANTA CRUZ' => 'SANTA CRUZ', 'ORURO' => 'ORURO', 'POTOSI' => 'POTOSI', 'TARIJA' => 'TARIJA', 'CHUQUISACA' => 'CHUQUISACA', 'BENI' => 'BENI', 'PANDO' => 'PANDO'], $package->CUIDAD, ['class' => 'form-control' . ($errors->has('CUIDAD') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Cuidad']) }}
                    {!! $errors->first('CUIDAD', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('ZONA') }}
                    {{ Form::text('ZONA', strtoupper($package->ZONA), [
                        'class' => 'form-control' . ($errors->has('ZONA') ? ' is-invalid' : ''),
                        'placeholder' => 'Zona',
                        // 'pattern' => '^[A-Z]+$',
                        'title' => 'Ingrese solo letras mayúsculas',
                        'style' => 'text-transform: uppercase;', // Mostrar todo en mayúsculas visualmente
                        'maxlength' => '255',
                    ]) }}
                    {!! $errors->first('ZONA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <!-- Fin de las primeras columnas -->
            </div>
            <div class="col-md-6">
                <!-- Segundas columnas del formulario -->
                <div class="form-group">
                    {{ Form::label('VENTANILLA') }}
                    {{ Form::select('VENTANILLA', ['DND' => 'DND', 'DD' => 'DD', '27' => '27', '8' => '8'], $package->VENTANILLA, ['class' => 'form-control' . ($errors->has('VENTANILLA') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Ventanilla']) }}
                    {!! $errors->first('VENTANILLA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('PESO') }}
                    {{ Form::text('PESO', $package->PESO, [
                        'class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''),
                        'placeholder' => 'Expresa el Peso en Gramos',
                        'pattern' => '\d+(\.\d{1,2})?', // Expresión regular para permitir números con hasta dos decimales
                        'title' => 'Ingrese un número válido con hasta dos decimales',
                    ]) }}
                    {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
                </div>                               
                <div class="form-group">
                    {{ Form::label('TIPO', 'Tipo') }}
                    {{ Form::select('TIPO', ['PAQUETE' => 'PAQUETE', 'SOBRE' => 'SOBRE'], $package->TIPO, ['class' => 'form-control' . ($errors->has('TIPO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el tipo de paquete']) }}
                    {!! $errors->first('TIPO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('ADUANA') }}
                    {{ Form::select('ADUANA', ['SI' => 'SI', 'NO' => 'NO'], $package->ADUANA, ['class' => 'form-control' . ($errors->has('ADUANA') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el estado en el cual se observo el paquete']) }}
                    {!! $errors->first('ADUANA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('OBSERVACIONES') }}
                    {{ Form::text('OBSERVACIONES', strtoupper($package->OBSERVACIONES), [
                        'class' => 'form-control' . ($errors->has('OBSERVACIONES') ? ' is-invalid' : ''),
                        'placeholder' => 'Observaciones',
                        // 'pattern' => '^[A-Z]+$',
                        'title' => 'Ingrese solo letras mayúsculas',
                        'style' => 'text-transform: uppercase;', // Mostrar todo en mayúsculas visualmente
                        'maxlength' => '255',
                    ]) }}
                    {!! $errors->first('OBSERVACIONES', '<div class="invalid-feedback">:message</div>') !!}
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
