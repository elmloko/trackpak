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
                        // 'style' => 'text-transform: uppercase;', // Mostrar todo en mayúsculas visualmente
                    ]) }}
                    {!! $errors->first('CODIGO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TIPO', 'Tipo') }}
                    {{ Form::select('TIPO', ['PAQUETE' => 'PAQUETE', 'SOBRE' => 'SOBRE'], $package->TIPO, ['class' => 'form-control' . ($errors->has('TIPO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el tipo de paquete']) }}
                    {!! $errors->first('TIPO', '<div class="invalid-feedback">:message</div>') !!}
                </div> 
                <div class="form-group">
                    {{ Form::label('PESO') }}
                    {{ Form::number('PESO', $package->PESO, [
                        'class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''),
                        'placeholder' => 'Expresa el Peso en Gramos',
                        'step' => '0.01', // Establece el paso para permitir hasta dos decimales
                        'title' => 'Ingrese un número válido con hasta dos decimales (ej. 1.25)',
                        'oninput' => 'validity.valid||(value="")', // Elimina caracteres no permitidos
                    ]) }}
                    {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
                </div>                              
                <div class="form-group">
                    {{ Form::label('DESTINATARIO') }}
                    {{ Form::text('DESTINATARIO', strtoupper($package->DESTINATARIO), [
                        'class' => 'form-control' . ($errors->has('DESTINATARIO') ? ' is-invalid' : ''),
                        'placeholder' => 'Destinatario',
                        // 'pattern' => '^[A-Z]+$',
                        // 'title' => 'Ingrese solo letras mayúsculas',
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
                
                <!-- Fin de las primeras columnas -->
            </div>
            <div class="col-md-6">
                <!-- Segundas columnas del formulario -->
                <div class="form-group">
                    {{ Form::label('CUIDAD') }}
                    {{ Form::select('CUIDAD', ['LA PAZ' => 'LA PAZ', 'COCHABAMBA' => 'COCHABAMBA', 'SANTA CRUZ' => 'SANTA CRUZ', 'ORURO' => 'ORURO', 'POTOSI' => 'POTOSI', 'TARIJA' => 'TARIJA', 'CHUQUISACA' => 'CHUQUISACA', 'BENI' => 'BENI', 'PANDO' => 'PANDO'], $package->CUIDAD, ['class' => 'form-control' . ($errors->has('CUIDAD') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Cuidad', 'id' => 'ciudad-select']) }}
                    {!! $errors->first('CUIDAD', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                
                <div class="form-group">
                    {{ Form::label('VENTANILLA') }}
                    {{ Form::select('VENTANILLA', ['DND' => 'DND', 'DD' => 'DD','ECA' => 'ECA','CASILLAS' => 'CASILLAS', 'UNICA' => 'UNICA'], $package->VENTANILLA, ['class' => 'form-control' . ($errors->has('VENTANILLA') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Ventanilla', 'id' => 'ventanilla-select']) }}
                    {!! $errors->first('VENTANILLA', '<div class="invalid-feedback">:message</div>') !!}
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function(){
        // Ocultar opciones de Ventanilla al cargar la página
        $('#ventanilla-select option[value="UNICA"]').hide();

        // Al cambiar la ciudad
        $('#ciudad-select').change(function(){
            // Mostrar u ocultar opciones de Ventanilla según la ciudad seleccionada
            if ($(this).val() === 'LA PAZ') {
                $('#ventanilla-select option[value="UNICA"]').hide();
                $('#ventanilla-select option[value="DND"]').show();
                $('#ventanilla-select option[value="DD"]').show();
                $('#ventanilla-select option[value="ECA"]').show();
                $('#ventanilla-select option[value="CASILLAS"]').show();
            } else {
                $('#ventanilla-select option[value="UNICA"]').show();
                $('#ventanilla-select option[value="DND"]').hide();
                $('#ventanilla-select option[value="DD"]').hide();
                $('#ventanilla-select option[value="ECA"]').hide();
                $('#ventanilla-select option[value="CASILLAS"]').hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function(){
        // Al cargar la página, verificar la opción seleccionada y actuar en consecuencia
        checkVentanilla();

        // Al cambiar la ciudad
        $('#ciudad-select').change(function(){
            // Al cambiar la ciudad, volver a verificar la opción seleccionada y actuar en consecuencia
            checkVentanilla();
        });

        // Al cambiar la ventanilla
        $('#ventanilla-select').change(function(){
            // Al cambiar la ventanilla, volver a verificar la opción seleccionada y actuar en consecuencia
            checkVentanilla();
        });

        function checkVentanilla() {
            // Obtener el valor de la ventanilla seleccionada
            var ventanillaSeleccionada = $('#ventanilla-select').val();

            // Verificar si la ventanilla seleccionada es 'DND'
            if (ventanillaSeleccionada === 'DND') {
                // Deshabilitar la entrada de la zona
                $('#ZONA').prop('disabled', true);
            } else {
                // Habilitar la entrada de la zona
                $('#ZONA').prop('disabled', false);
            }
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Seleccionar todos los elementos de entrada de texto del formulario
        $('input[type="text"]').on('input', function () {
            // Convertir el valor a mayúsculas y actualizar el valor del campo
            $(this).val($(this).val().toUpperCase());
        });
    });
</script>

