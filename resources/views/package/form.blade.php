<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-md-6">
                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                    <div class="form-group">
                        {{ Form::label('CODIGO RASTREO*') }}
                        {{ Form::text('CODIGO', strtoupper($package->CODIGO), [
                            'class' => 'form-control' . ($errors->has('CODIGO') ? ' is-invalid' : ''),
                            'placeholder' => 'Codigo',
                            'pattern' => '^[A-Z0-9]+$',
                            'title' => 'Ingrese solo letras mayúsculas y números',
                            'maxlength' => '20',
                        ]) }}
                        {!! $errors->first('CODIGO', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole

                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion|Urbano|ENCOMIENDAS')
                    <div class="form-group">
                        {{ Form::label('DESTINATARIO*') }}
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
                            'pattern' => '^[0-9]*$',
                            'title' => 'Ingrese solo números',
                            'autocomplete' => 'off',
                        ]) }}
                        {!! $errors->first('TELEFONO', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole

                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                    <div class="form-group">
                        {{ Form::label('PESO (Kg.)*') }}
                        {{ Form::text('PESO', $package->PESO, [
                            'class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''),
                            'placeholder' => 'Expresa el Peso en Gramos',
                            'title' => 'Ingrese un número válido con hasta tres decimales (ej. 1.251)',
                            'oninput' => 'this.setCustomValidity("")',
                            'pattern' => '^(\d+)?(\.\d{1,3})?$',
                            'required' => 'required',
                            'min' => '0',
                            'max' => '10.000',
                        ]) }}
                        {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole

                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion|Urbano')
                    <div class="form-group">
                        {{ Form::label('TIPO*') }}
                        {{ Form::select('TIPO', ['PAQUETE' => 'PAQUETE', 'SOBRE' => 'SOBRE'], $package->TIPO, [
                            'class' => 'form-control' . ($errors->has('TIPO') ? ' is-invalid' : ''),
                            'placeholder' => 'Selecione el tipo de paquete',
                        ]) }}
                        {!! $errors->first('TIPO', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole

                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                    <div class="form-group">
                        {{ Form::label('CIUDAD*') }}
                        {{ Form::select(
                            'CUIDAD',
                            [
                                'LA PAZ' => 'LA PAZ',
                                'COCHABAMBA' => 'COCHABAMBA',
                                'SANTA CRUZ' => 'SANTA CRUZ',
                                'ORURO' => 'ORURO',
                                'POTOSI' => 'POTOSI',
                                'TARIJA' => 'TARIJA',
                                'SUCRE' => 'SUCRE',
                                'BENI' => 'BENI',
                                'PANDO' => 'PANDO',
                            ],
                            $package->CUIDAD,
                            [
                                'class' => 'form-control' . ($errors->has('CUIDAD') ? ' is-invalid' : ''),
                                'placeholder' => 'Selecione la Ciudad',
                                'id' => 'ciudad-select',
                            ],
                        ) }}
                        {!! $errors->first('CUIDAD', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole

                @hasrole('SuperAdmin|Administrador')
                    <div class="form-group">
                        {{ Form::label('ESTADO*') }}
                        {{ Form::select(
                            'ESTADO',
                            [
                                'CLASIFICACION' => 'CLASIFICACION',
                                'DESPACHO' => 'DESPACHO',
                                'VENTANILLA' => 'VENTANILLA',
                                'ENTREGADO' => 'ENTREGADO',
                                'CARTERO' => 'CARTERO',
                                'RETORNO' => 'RETORNO',
                                'REENCAMINADO' => 'REENCAMINADO',
                                'RECIBIDO' => 'RECIBIDO',
                                'REPARTIDO' => 'REPARTIDO',
                                'PRE-REZAGO' => 'PRE-REZAGO',
                                'REZAGO' => 'REZAGO',
                            ],
                            $package->ESTADO,
                            [
                                'class' => 'form-control' . ($errors->has('ESTADO') ? ' is-invalid' : ''),
                                'placeholder' => 'Selecione la Ciudad',
                                'id' => 'ciudad-select',
                            ],
                        ) }}
                        {!! $errors->first('ESTADO', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole
            </div>
            <!-- Columna Derecha -->
            <div class="col-md-6">
                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar Clasificacion')
                    <div class="form-group">
                        {{ Form::label('VENTANILLA*') }}
                        {{ Form::select(
                            'VENTANILLA',
                            [
                                'ECA' => 'ECA',
                                'UNICA' => 'UNICA',
                                'ENCOMIENDAS' => 'VENTANILLA 7',
                                'DND' => 'DND',
                                'DD' => 'DD',
                                'CASILLAS' => 'CASILLAS',
                            ],
                            $package->VENTANILLA,
                            [
                                'class' => 'form-control' . ($errors->has('VENTANILLA') ? ' is-invalid' : ''),
                                'placeholder' => 'Selecione la Ventanilla',
                                'id' => 'ventanilla-select',
                            ],
                        ) }}
                        {!! $errors->first('VENTANILLA', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('Nro DE CASILLERO POSTAL') }}
                        {{ Form::number('nrocasilla', $package->nrocasilla, [
                            'class' => 'form-control' . ($errors->has('nrocasilla') ? ' is-invalid' : ''),
                            'placeholder' => 'Ingrese el número de casillero postal',
                            'pattern' => '^[0-9]*$',
                            'title' => 'Ingrese solo números',
                            'autocomplete' => 'off',
                            'id' => 'casilla-select',
                        ]) }}
                        {!! $errors->first('nrocasilla', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('ADUANA*') }}
                        {{ Form::select('ADUANA', ['SI' => 'SI', 'NO' => 'NO'], $package->ADUANA, [
                            'class' => 'form-control' . ($errors->has('ADUANA') ? ' is-invalid' : ''),
                            'placeholder' => 'Selecione el estado en el cual se observó el paquete',
                        ]) }}
                        {!! $errors->first('ADUANA', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole

                @hasrole('SuperAdmin|Administrador|ENCOMIENDAS')
                    <div class="form-group">
                        {{ Form::label('ZONA*') }}
                        {{ Form::text('ZONA', strtoupper($package->ZONA), [
                            'class' => 'form-control' . ($errors->has('ZONA') ? ' is-invalid' : ''),
                            'placeholder' => 'Indique la Bandeja',
                        ]) }}
                        {!! $errors->first('ZONA', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('ADUANA*') }}
                        {{ Form::select('ADUANA', ['SI' => 'SI', 'NO' => 'NO'], $package->ADUANA, [
                            'class' => 'form-control' . ($errors->has('ADUANA') ? ' is-invalid' : ''),
                            'placeholder' => 'Selecione el estado en el cual se observó el paquete',
                        ]) }}
                        {!! $errors->first('ADUANA', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole

                @hasrole('SuperAdmin|Administrador|Urbano')
                    <div class="form-group">
                        {{ Form::label('ZONA*') }}
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
                        'style' => 'text-transform: uppercase;',
                        'maxlength' => '255',
                    ]) }}
                    {!! $errors->first('OBSERVACIONES', '<div class="invalid-feedback">:message</div>') !!}
                </div>

                <div class="form-group">
                    {{ Form::label('FOTO') }}
                    <input type="file" id="capturephoto" class="form-control" accept="image/*">
                    <input type="hidden" id="inputbase64foto" name="foto">
                    <!-- Campo oculto para almacenar la imagen en base64 -->
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer mt20">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" id="submit-btn">{{ __('Guardar') }}</button>
        </div>
    </div>
</div>

<!-- Cargar jQuery una sola vez -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // 1. Convertir a mayúsculas todos los inputs de texto
        $('input[type="text"]').on('input', function() {
            $(this).val($(this).val().toUpperCase());
        });

        // 2. Foco automático en el campo CODIGO
        $('input[name="CODIGO"]').focus();

        // 3. Manejo de la carga de imagen y conversión a Base64
        $('#capturephoto').on('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        canvas.getContext('2d').drawImage(img, 0, 0);
                        // Comprimir imagen y asignar valor Base64
                        $('#inputbase64foto').val(canvas.toDataURL('image/jpeg', 0.5));
                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // 4. Mostrar/ocultar opciones de Ventanilla según la ciudad seleccionada
        function updateVentanillaOptions() {
            const ciudad = $('#ciudad-select').val();
            if (ciudad === 'LA PAZ') {
                $('#ventanilla-select option[value="UNICA"]').hide();
                $('#ventanilla-select option[value="DND"], option[value="DD"], option[value="ECA"], option[value="CASILLAS"], option[value="ENCOMIENDAS"]')
                    .show();
            } else {
                $('#ventanilla-select option[value="UNICA"]').show();
                $('#ventanilla-select option[value="DND"], option[value="DD"], option[value="ECA"], option[value="CASILLAS"]')
                    .hide();
            }
            toggleCasillero();
        }
        $('#ciudad-select').on('change', updateVentanillaOptions);
        updateVentanillaOptions();

        // 5. Habilitar/deshabilitar el campo Nro de Casillero según Ventanilla
        function toggleCasillero() {
            const ventanilla = $('#ventanilla-select').val();
            const casillaInput = $('#casilla-select');
            if (ventanilla === 'CASILLAS') {
                casillaInput.prop('disabled', false);
            } else {
                casillaInput.prop('disabled', true).val('');
            }
            // 6. Si la ventanilla es DND, deshabilitar el campo ZONA
            if (ventanilla === 'DND') {
                $('select[name="ZONA"], input[name="ZONA"]').prop('disabled', true);
            } else {
                $('select[name="ZONA"], input[name="ZONA"]').prop('disabled', false);
            }
        }
        $('#ventanilla-select').on('change', toggleCasillero);
        toggleCasillero();

        // 7. Deshabilitar el botón de submit para evitar envíos duplicados
        $('#submit-btn').on('click', function() {
            $(this).prop('disabled', true);
            $(this).closest('form').submit();
        });
    });
</script>
