<div class="box box-info padding-1">
    <div class="box-body">
        <h4>Datos del Paquete</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('CODIGO DE RASTEO') }}
                    {{ Form::text('CODIGO', strtoupper($national->CODIGO), ['class' => 'form-control' . ($errors->has('CODIGO') ? ' is-invalid' : ''), 'style' => 'text-transform: uppercase;', 'placeholder' => 'Codigo de Rastreo']) }}
                    {!! $errors->first('CODIGO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TIPO DE SERVICIO') }}
                    {{ Form::select('TIPOSERVICIO', ['EMS' => 'EMS', 'CERTIFICADA' => 'CERTIFICADA', 'ORDINARIA' => 'ORDINARIA', 'ECA' => 'ECA', 'CASILLAS' => 'CASILLAS', 'SUPEREXPRESS' => 'SUPEREXPRESS', 'EXPRESS' => 'EXPRESS', 'AVISO RECIBO' => 'AVISO RECIBO'], $national->TIPOSERVICIO, ['class' => 'form-control' . ($errors->has('TIPOSERVICIO') ? ' is-invalid' : ''), 'placeholder' => 'Tipo de servicio postal nacional']) }}
                    {!! $errors->first('TIPOSERVICIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TIPO DE CORRESPONDENCIA') }}
                    {{ Form::select('TIPOCORRESPONDENCIA', ['PAQUETE' => 'PAQUETE', 'CARTA' => 'CARTA', 'TARJETA POSTAL' => 'TARJETA POSTAL', 'REVISTA' => 'REVISTA', 'IMPRESO' => 'IMPRESO', 'CECOGRAMA' => 'CECOGRAMA', 'PEQUEÑO PAQUETE' => 'PEQUEÑO PAQUETE', 'SACA M' => 'SACA M', 'ENCOMIENTA' => 'ENCOMIENDA', 'DOCUMENTO' => 'DOCUMENTO'], $national->TIPOCORRESPONDENCIA, ['class' => 'form-control' . ($errors->has('TIPOCORRESPONDENCIA') ? ' is-invalid' : ''), 'placeholder' => 'Tipo de correspondencia']) }}
                    {!! $errors->first('TIPOCORRESPONDENCIA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('CANTIDAD DE ENVIOS') }}
                    {{ Form::number('CANTIDAD', $national->CANTIDAD, ['class' => 'form-control' . ($errors->has('CANTIDAD') ? ' is-invalid' : ''), 'placeholder' => 'Cantidad de envios']) }}
                    {!! $errors->first('CANTIDAD', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('PESO (gr.)') }}
                    {{ Form::text('PESO', $national->PESO, [
                        'class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''),
                        'placeholder' => 'Expresa el Peso en Gramos',
                        'title' => 'Ingrese un número válido con hasta tres decimales (ej. 1.251)',
                        'oninput' => 'this.setCustomValidity("")',  // Limpiar mensaje de validación personalizado
                        'pattern' => '^(\d+)?(\.\d{1,3})?$',
                        'required' => 'required',
                    ]) }}
                    {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
                </div> 
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('DESTINO NACIONAL') }}
                    {{ Form::select('DESTINO', ['LA PAZ' => 'LA PAZ', 'COCHABAMBA' => 'COCHABAMBA', 'SANTA CRUZ' => 'SANTA CRUZ', 'ORURO' => 'ORURO', 'POTOSI' => 'POTOSI', 'TARIJA' => 'TARIJA', 'SUCRE' => 'SUCRE', 'BENI' => 'BENI', 'PANDO' => 'PANDO'], $national->DESTINO, ['class' => 'form-control' . ($errors->has('DESTINO') ? ' is-invalid' : ''), 'placeholder' => 'Destino nacional', 'id' => 'ciudad-select']) }}
                    {!! $errors->first('DESTINO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('PROVINCIA') }}
                    {{ Form::select('PROVINCIA', ['LOCAL 1' => 'LOCAL 1', 'LOCAL 2' => 'LOCAL 2', 'LOCAL 3' => 'LOCAL 3', 'LOCAL 4' => 'LOCAL 4', 'CUIDAD CAPITAL' => 'CUIDAD CAPITAL', 'CUIDAD INTERMEDIA' => 'CUIDAD INTERMEDIA', 'TRINIDAD/COBIJA' => 'TRINIDAD/COBIJA', 'RIBERALTA/GUAYARAMERIN' => 'RIBERALTA/GUAYARAMERIN'], $national->PROVINCIA, ['class' => 'form-control' . ($errors->has('PROVINCIA') ? ' is-invalid' : ''), 'placeholder' => 'Destino Local', 'id' => 'local-select']) }}
                    {!! $errors->first('PROVINCIA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('DIRECCION O DOMICILIO') }}
                    {{ Form::text('DIRECCION', strtoupper($national->DIRECCION), ['class' => 'form-control' . ($errors->has('DIRECCION') ? ' is-invalid' : ''), 'style' => 'text-transform: uppercase;', 'placeholder' => 'Direccion del domicilio remitente']) }}
                    {!! $errors->first('DIRECCION', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('N° DE FACTURA') }}
                    {{ Form::number('FACTURA', $national->FACTURA, ['class' => 'form-control' . ($errors->has('FACTURA') ? ' is-invalid' : ''), 'placeholder' => 'Numero de Factura']) }}
                    {!! $errors->first('FACTURA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('IMPORTE (Bs.)') }}
                    {{ Form::number('IMPORTE', $national->IMPORTE, ['class' => 'form-control' . ($errors->has('IMPORTE') ? ' is-invalid' : ''), 'placeholder' => 'Importe expresado en Bs.', 'id' => 'importe-select']) }}
                    {!! $errors->first('IMPORTE', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h4>Datos del Destinatario</h4>
                <div class="form-group">
                    {{ Form::label('NOMBRES DEL DESTINATARIO') }}
                    {{ Form::text('NOMBRESDESTINATARIO', strtoupper($national->NOMBRESDESTINATARIO), ['class' => 'form-control' . ($errors->has('NOMBRESDESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Nombres y Apellido del Destinatario']) }}
                    {!! $errors->first('NOMBRESDESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TELEFONO DEL DESTINATARIO') }}
                    {{ Form::number('TELEFONODESTINATARIO', $national->TELEFONODESTINATARIO, ['class' => 'form-control' . ($errors->has('TELEFONODESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Telefono del Destinatario']) }}
                    {!! $errors->first('TELEFONODESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('C.I. DESTINATARIO') }}
                    {{ Form::number('CIDESTINATARIO', $national->CIDESTINATARIO, ['class' => 'form-control' . ($errors->has('CIDESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Celula de Identidad del Destinatario']) }}
                    {!! $errors->first('CIDESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <h4>Datos del Remitente</h4>
                <div class="form-group">
                    {{ Form::label('NOMBRE Y APELLIDO DEL REMITENTE') }}
                    {{ Form::text('NOMBRESREMITENTE', strtoupper($national->NOMBRESREMITENTE), ['class' => 'form-control' . ($errors->has('NOMBRESREMITENTE') ? ' is-invalid' : ''), 'placeholder' => 'Nombre y Apellido del Remitente']) }}
                    {!! $errors->first('NOMBRESREMITENTE', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TELEFONO DEL REMITENTE') }}
                    {{ Form::number('TELEFONOREMITENTE', $national->TELEFONOREMITENTE, ['class' => 'form-control' . ($errors->has('TELEFONOREMITENTE') ? ' is-invalid' : ''), 'placeholder' => 'Telefono del Remitente']) }}
                    {!! $errors->first('TELEFONOREMITENTE', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('C.I. REMITENTE') }}
                    {{ Form::number('CIREMITENTE', $national->CIREMITENTE, ['class' => 'form-control' . ($errors->has('CIREMITENTE') ? ' is-invalid' : ''), 'placeholder' => 'Celula de Identidad del Remitente']) }}
                    {!! $errors->first('CIREMITENTE', '<div class="invalid-feedback">:message</div>') !!}
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
