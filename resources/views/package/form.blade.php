<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                    <div class="form-group">
                        {{ Form::label('CODIGO RASTREO') }}
                        {{ Form::text('CODIGO', strtoupper($package->CODIGO), [
                            'class' => 'form-control' . ($errors->has('CODIGO') ? ' is-invalid' : ''),
                            'placeholder' => 'Codigo',
                            'pattern' => '^[A-Z0-9]+$', // Solo letras mayúsculas y números, al menos uno
                            'title' => 'Ingrese solo letras mayúsculas y números',
                            'maxlength' => '20',
                        ]) }}
                        {!! $errors->first('CODIGO', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole
                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion|Urbano|ENCOMIENDAS')
                    <div class="form-group">
                        {{ Form::label('DESTINATARIO') }}
                        {{ Form::text('DESTINATARIO', strtoupper($package->DESTINATARIO), [
                            'class' => 'form-control' . ($errors->has('DESTINATARIO') ? ' is-invalid' : ''),
                            'placeholder' => 'Destinatario',
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
                @endhasrole
                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                    <div class="form-group">
                        {{ Form::label('PESO (Kg.)') }}
                        {{ Form::text('PESO', $package->PESO, [
                            'class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''),
                            'placeholder' => 'Expresa el Peso en Gramos',
                            'title' => 'Ingrese un número válido con hasta tres decimales (ej. 1.251)',
                            'oninput' => 'this.setCustomValidity("")', // Limpiar mensaje de validación personalizado
                            'pattern' => '^(\d+)?(\.\d{1,3})?$',
                            'required' => 'required',
                            'min' => '0', // Establecer el valor mínimo
                            'max' => '10.000',
                        ]) }}
                        {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole
                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion|Urbano')
                    <div class="form-group">
                        {{ Form::label('TIPO', 'Tipo') }}
                        {{ Form::select('TIPO', ['PAQUETE' => 'PAQUETE', 'SOBRE' => 'SOBRE'], $package->TIPO, ['class' => 'form-control' . ($errors->has('TIPO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el tipo de paquete']) }}
                        {!! $errors->first('TIPO', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole
                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                    <div class="form-group">
                        {{ Form::label('CIUDAD') }}
                        {{ Form::select('CUIDAD', ['LA PAZ' => 'LA PAZ', 'COCHABAMBA' => 'COCHABAMBA', 'SANTA CRUZ' => 'SANTA CRUZ', 'ORURO' => 'ORURO', 'POTOSI' => 'POTOSI', 'TARIJA' => 'TARIJA', 'SUCRE' => 'SUCRE', 'BENI' => 'BENI', 'PANDO' => 'PANDO'], $package->CUIDAD, ['class' => 'form-control' . ($errors->has('CUIDAD') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Ciudad', 'id' => 'ciudad-select']) }}
                        {!! $errors->first('CUIDAD', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole
            </div>
            <div class="col-md-6">
                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                    <div class="form-group">
                        {{ Form::label('VENTANILLA') }}
                        {{ Form::select('VENTANILLA', ['ECA' => 'ECA', 'UNICA' => 'UNICA', 'ENCOMIENDA' => 'ENCOMIENDA', 'DND' => 'DND', 'DD' => 'DD', 'ECA' => 'ECA', 'CASILLAS' => 'CASILLAS', 'UNICA' => 'UNICA'], $package->VENTANILLA, ['class' => 'form-control' . ($errors->has('VENTANILLA') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Ventanilla', 'id' => 'ventanilla-select']) }}
                        {!! $errors->first('VENTANILLA', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('Nro DE CASILLERO POSTAL') }}
                        {{ Form::number('nrocasilla', $package->nrocasilla, [
                            'class' => 'form-control' . ($errors->has('nrocasilla') ? ' is-invalid' : ''),
                            'placeholder' => 'Ingrese el numero de casillero postal',
                            'pattern' => '^[0-9]*$', // Solo números
                            'title' => 'Ingrese solo números',
                            'autocomplete' => 'off', // Desactivar autocompletar
                            'id' => 'casilla-select',
                        ]) }}
                        {!! $errors->first('nrocasilla', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('ADUANA') }}
                        {{ Form::select('ADUANA', ['SI' => 'SI', 'NO' => 'NO'], $package->ADUANA, ['class' => 'form-control' . ($errors->has('ADUANA') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el estado en el cual se observo el paquete']) }}
                        {!! $errors->first('ADUANA', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole
                @hasrole('SuperAdmin|Administrador|ENCOMIENDAS')
                    <div class="form-group">
                        {{ Form::label('ZONA') }}
                        {{ Form::text('ZONA', strtoupper($package->ZONA), [
                            'class' => 'form-control' . ($errors->has('ZONA') ? ' is-invalid' : ''),
                            'placeholder' => 'Indique la Bandeja',
                        ]) }}
                        {!! $errors->first('ZONA', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole
                @hasrole('SuperAdmin|Administrador|Urbano')
                    <div class="form-group">
                        {{ Form::label('ZONA') }}
                        {{ Form::select(
                            'ZONA',
                            [
                                'DND' => 'DND',
                                'EL ALTO' => 'EL ALTO',
                                'CALACOTO' => 'CALACOTO',
                                'SAN PEDRO' => 'SAN PEDRO',
                                'LOS ANDES' => 'LOS ANDES',
                                'SEGUENCOMA' => 'SEGUENCOMA',
                                'VILLA PABON' => 'VILLA PABON',
                                'VILLA ARMONIA' => 'VILLA ARMONIA',
                                'IRPAVI' => 'IRPAVI',
                                'CENTRO' => 'CENTRO',
                                'VILLA NUEVA POTOSI' => 'VILLA NUEVA POTOSI',
                                'AUQUISAMANA' => 'AUQUISAMAÑA',
                                'ROSARIO GRAN PODER' => 'ROSARIO GRAN PODER',
                                'VILLA EL CARMEN' => 'VILLA EL CARMEN',
                                'ACHUMANI' => 'ACHUMANI',
                                'MIRAFLORES' => 'MIRAFLORES',
                                'CEMENTERIO' => 'CEMENTERIO',
                                'MALLASILLA' => 'MALLASILLA',
                                'VILLA SALOME' => 'VILLA SALOME',
                                'LOS PINOS / SAN MIGUEL' => 'LOS PINOS / SAN MIGUEL',
                                'VILLA FATIMA' => 'VILLA FATIMA',
                                'PASANKERI' => 'PASANKERI',
                                'ALTO OBRAJES' => 'ALTO OBRAJES',
                                'PURA PURA' => 'PURA PURA',
                                'OBRAJES' => 'OBRAJES',
                                'VILLA COPACABANA' => 'VILLA COPACABANA',
                                'LLOJETA' => 'LLOJETA',
                                'BUENOS AIRES' => 'BUENOS AIRES',
                                'ACHACHICALA' => 'ACHACHICALA',
                                'TEMBLADERANI' => 'TEMBLADERANI',
                                'SOPOCACHI' => 'SOPOCACHI',
                                'ZONA NORTE' => 'ZONA NORTE',
                                'PAMPAHASSI' => 'PAMPAHASSI',
                                'VINO TINTO' => 'VINO TINTO',
                                'BELLA VISTA / BOLONIA' => 'BELLA VISTA / BOLONIA',
                                'VILLA SAN ANTONIO' => 'VILLA SAN ANTONIO',
                                'MUNAYPATA' => 'MUNAYPATA',
                                'SAN SEBASTIAN' => 'SAN SEBASTIAN',
                                'PERIFERICA' => 'PERIFERICA',
                                'COTA COTA / CHASQUIPAMPA' => 'COTA COTA / CHASQUIPAMPA',
                                'LA PORTADA' => 'LA PORTADA',
                                'FLORIDA' => 'FLORIDA',
                                'VILLA VICTORIA' => 'VILLA VICTORIA',
                                'CIUDADELA FERROVIARIA' => 'CIUDADELA FERROVIARIA',
                                'PG1A' => 'PG1A',
                                'PG2A' => 'PG2A',
                                'PG3A' => 'PG3A',
                                'PG4A' => 'PG4A',
                                'PG5A' => 'PG5A',
                                'PG1B' => 'PG1B',
                                'PG2B' => 'PG2B',
                                'PG3B' => 'PG3B',
                                'PG4B' => 'PG4B',
                                'PG5B' => 'PG5B',
                                'PG1C' => 'PG1C',
                                'PG2C' => 'PG2C',
                                'PG3C' => 'PG3C',
                                'PG4C' => 'PG4C',
                                'PG5C' => 'PG5C',
                                'PG1D' => 'PG1D',
                                'PG2D' => 'PG2D',
                                'PG3D' => 'PG3D',
                                'PG4D' => 'PG4D',
                                'PG5D' => 'PG5D',
                            ],
                            $package->ZONA,
                            [
                                'class' => 'form-control' . ($errors->has('ZONA') ? ' is-invalid' : ''),
                                'placeholder' => 'Seleccione la Zona',
                            ],
                        ) }}

                        {!! $errors->first('ZONA', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole
                <div class="form-group">
                    {{ Form::label('OBSERVACIONES') }}
                    {{ Form::text('OBSERVACIONES', strtoupper($package->OBSERVACIONES), [
                        'class' => 'form-control' . ($errors->has('OBSERVACIONES') ? ' is-invalid' : ''),
                        'placeholder' => 'Observaciones',
                        'style' => 'text-transform: uppercase;', // Mostrar todo en mayúsculas visualmente
                        'maxlength' => '255',
                    ]) }}
                    {!! $errors->first('OBSERVACIONES', '<div class="invalid-feedback">:message</div>') !!}
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Ocultar opciones de Ventanilla al cargar la página
        $('#ventanilla-select option[value="UNICA"]').hide();

        // Al cambiar la ciudad
        $('#ciudad-select').change(function() {
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
    $(document).ready(function() {
        // Al cargar la página, verificar la opción seleccionada y actuar en consecuencia
        checkVentanilla();

        // Al cambiar la ciudad
        $('#ciudad-select').change(function() {
            // Al cambiar la ciudad, volver a verificar la opción seleccionada y actuar en consecuencia
            checkVentanilla();
        });

        // Al cambiar la ventanilla
        $('#ventanilla-select').change(function() {
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
    $(document).ready(function() {
        // Seleccionar todos los elementos de entrada de texto del formulario
        $('input[type="text"]').on('input', function() {
            // Convertir el valor a mayúsculas y actualizar el valor del campo
            $(this).val($(this).val().toUpperCase());
        });
    });
</script>
<script>
    // Función para mostrar u ocultar el campo de Nro DE CASILLERO POSTAL
    function toggleCasillero() {
        var ventanillaSelect = document.getElementById('ventanilla-select');
        var casillaInput = document.getElementById('casilla-select');

        // Habilitar o deshabilitar el campo según la opción seleccionada
        casillaInput.disabled = ventanillaSelect.value !== 'CASILLAS';

        // Limpiar el valor si se deshabilita
        if (!casillaInput.disabled) {
            casillaInput.value = '';
        }
    }

    // Asignar la función al evento onchange del campo de ventanilla
    document.getElementById('ventanilla-select').onchange = toggleCasillero;

    // Llamar a la función al cargar la página para establecer el estado inicial
    window.onload = toggleCasillero;
</script>
