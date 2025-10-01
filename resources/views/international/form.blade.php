<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
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
                    {{ Form::number('TELEFONO', $international->TELEFONO, ['class' => 'form-control' . ($errors->has('TELEFONO') ? ' is-invalid' : ''), 'placeholder' => 'Telefono']) }}
                    {!! $errors->first('TELEFONO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                @hasrole('SuperAdmin|Administrador|Casillas')
                    <div class="form-group">
                        {{ Form::label('Nro. Casilla') }}
                        {{ Form::text('ZONA', $international->ZONA, ['class' => 'form-control' . ($errors->has('ZONA') ? ' is-invalid' : ''), 'placeholder' => 'Nro Casilla Postal']) }}
                        {!! $errors->first('ZONA', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole
                @hasrole('SuperAdmin|Administrador|Urbano')
                    <div class="form-group">
                        {{ Form::label('ZONA') }}
                        {{ Form::text('ZONA', old('ZONA', $international->ZONA ?? ''), [
                            'class' => 'form-control' . ($errors->has('ZONA') ? ' is-invalid' : ''),
                            'placeholder' => 'Ej: VILLAFATIMA, PG1A',
                            'maxlength' => 40,
                            'autocomplete' => 'off',
                            'inputmode' => 'latin',
                            // Limpia en el cliente: quita tildes, deja A-Z y 0-9, sin espacios
                            'oninput' => "this.value = this.value
                                        .normalize('NFD').replace(/[\\u0300-\\u036f]/g,'')
                                        .toUpperCase().replace(/[^A-Z0-9]/g,'');",
                        ]) }}
                        {!! $errors->first('ZONA', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole
                {{-- @hasrole('SuperAdmin|Administrador|Urbano')
                    <div class="form-group">
                        {{ Form::label('ZONA') }}
                        {{ Form::select(
                            'ZONA',
                            [
                                
                                'ACHACHICALA' => 'ACHACHICALA',
                                'ACHUMANI' => 'ACHUMANI',
                                'ALTO OBRAJES' => 'ALTO OBRAJES',
                                'AUQUISAMAÑA' => 'AUQUISAMAÑA',
                                'BELLA VISTA / BOLONIA' => 'BELLA VISTA / BOLONIA',
                                'BUENOS AIRES' => 'BUENOS AIRES',
                                'CALACOTO' => 'CALACOTO',
                                'CEMENTERIO' => 'CEMENTERIO',
                                'CENTRO' => 'CENTRO',
                                'CIUDADELA FERROVIARIA' => 'CIUDADELA FERROVIARIA',
                                'COTA COTA / CHASQUIPAMPA' => 'COTA COTA / CHASQUIPAMPA',
                                'EL ALTO' => 'EL ALTO',
                                'FLORIDA' => 'FLORIDA',
                                'IRPAVI' => 'IRPAVI',
                                'LA PORTADA' => 'LA PORTADA',
                                'LLOJETA' => 'LLOJETA',
                                'LOS ANDES' => 'LOS ANDES',
                                'LOS PINOS / SAN MIGUEL' => 'LOS PINOS / SAN MIGUEL',
                                'MALLASILLA' => 'MALLASILLA',
                                'MIRAFLORES' => 'MIRAFLORES',
                                'MUNAYPATA' => 'MUNAYPATA',
                                'OBRAJES' => 'OBRAJES',
                                'PAMPAHASSI' => 'PAMPAHASSI',
                                'PASANKERI' => 'PASANKERI',
                                'PERIFERICA' => 'PERIFERICA',
                                'PURA PURA' => 'PURA PURA',
                                'ROSARIO GRAN PODER' => 'ROSARIO GRAN PODER',
                                'SAN PEDRO' => 'SAN PEDRO',
                                'SAN SEBASTIAN' => 'SAN SEBASTIAN',
                                'SEGUENCOMA' => 'SEGUENCOMA',
                                'SOPOCACHI' => 'SOPOCACHI',
                                'TEMBLADERANI' => 'TEMBLADERANI',
                                'VILLA ARMONIA' => 'VILLA ARMONIA',
                                'VILLA COPACABANA' => 'VILLA COPACABANA',
                                'VILLA EL CARMEN' => 'VILLA EL CARMEN',
                                'VILLA FATIMA' => 'VILLA FATIMA',
                                'VILLA NUEVA POTOSI' => 'VILLA NUEVA POTOSI',
                                'VILLA PABON' => 'VILLA PABON',
                                'VILLA SALOME' => 'VILLA SALOME',
                                'VILLA SAN ANTONIO' => 'VILLA SAN ANTONIO',
                                'VILLA VICTORIA' => 'VILLA VICTORIA',
                                'VINO TINTO' => 'VINO TINTO',
                                'ZONA NORTE' => 'ZONA NORTE',
                                'PROVINCIA' => 'PROVINCIA',
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
                                'RETURN' => 'RETURN',
                                'DND' => 'DND',
                            ],
                            $international->ZONA,
                            [
                                'class' => 'form-control' . ($errors->has('ZONA') ? ' is-invalid' : ''),
                                'placeholder' => 'Seleccione la Zona',
                            ],
                        ) }}

                        {!! $errors->first('ZONA', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                @endhasrole --}}
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('VENTANILLA') }}
                    {{ Form::select('VENTANILLA', ['DND' => 'DND', 'DD' => 'DD', 'CASILLAS' => 'CASILLAS'], $international->VENTANILLA, ['class' => 'form-control' . ($errors->has('VENTANILLA') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Ventanilla', 'id' => 'ventanilla-select']) }}
                    {!! $errors->first('VENTANILLA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('PESO') }}
                    {{ Form::text('PESO', $international->PESO, ['class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''), 'placeholder' => 'Peso']) }}
                    {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TIPO', 'Tipo') }}
                    {{ Form::select('TIPO', ['PAQUETE GRANDE' => 'PAQUETE GRANDE', 'PAQUETE PEQUEÑO' => 'PAQUETE PEQUEÑO', 'SOBRE' => 'SOBRE'], $international->TIPO, ['class' => 'form-control' . ($errors->has('TIPO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el tipo de paquete']) }}
                    {!! $errors->first('TIPO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('ADUANA') }}
                    {{ Form::select('ADUANA', ['SI' => 'SI', 'NO' => 'NO'], $international->ADUANA, ['class' => 'form-control' . ($errors->has('ADUANA') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el estado en el cual se observo el paquete']) }}
                    {!! $errors->first('ADUANA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('OBSERVACIONES') }}
                    {{ Form::text('OBSERVACIONES', $international->OBSERVACIONES, ['class' => 'form-control' . ($errors->has('OBSERVACIONES') ? ' is-invalid' : ''), 'placeholder' => 'Observaciones']) }}
                    {!! $errors->first('OBSERVACIONES', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
        <div class="box-footer mt20">
            <div class="text-right">
                <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
            </div>
        </div>
    </div>
</div>
