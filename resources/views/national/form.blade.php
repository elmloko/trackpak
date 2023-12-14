<div class="box box-info padding-1">
    <div class="box-body">
        <h4>Datos del Paquete</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('CODIGO DE RASTEO') }}
                    {{ Form::text('CODIGO', strtoupper($national->CODIGO), ['class' => 'form-control' . ($errors->has('CODIGO') ? ' is-invalid' : ''), 'style' => 'text-transform: uppercase;','placeholder' => 'Codigo de Rastreo']) }}
                    {!! $errors->first('CODIGO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TIPO DE SERVICIO') }}
                    {{ Form::select('TIPO', ['EMS' => 'EMS', 'CERTIFICADA' => 'CERTIFICADA', 'ORDINARIA' => 'ORDINARIA', 'ECA' => 'ECA', 'CASILLAS' => 'CASILLAS', 'SUPEREXPRESS' => 'SUPEREXPRESS', 'EXPRESS' => 'EXPRESS', 'AVISO RECIBO' => 'AVISO RECIBO'], $national->TIPOSERVICIO, ['class' => 'form-control' . ($errors->has('TIPOSERVICIO') ? ' is-invalid' : ''), 'placeholder' => 'Tipo de servicio postal nacional']) }}
                    {!! $errors->first('TIPOSERVICIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TIPO DE CORRESPONDENCIA') }}
                    {{ Form::select('TIPO', ['PAQUETE' => 'PAQUETE', 'CARTA' => 'CARTA', 'TARJETA POSTAL' => 'TARJETA POSTAL', 'REVISTA' => 'REVISTA', 'IMPRESO' => 'IMPRESO', 'CECOGRAMA' => 'CECOGRAMA', 'PEQUEÑO PAQUETE' => 'PEQUEÑO PAQUETE', 'SACA M' => 'SACA M', 'ENCOMIENTA' => 'ENCOMIENDA', 'DOCUMENTO' => 'DOCUMENTO'], $national->TIPOCORRESPONDENCIA, ['class' => 'form-control' . ($errors->has('TIPOCORRESPONDENCIA') ? ' is-invalid' : ''), 'placeholder' => 'Tipo de correspondencia']) }}
                    {!! $errors->first('TIPOCORRESPONDENCIA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('CANTIDAD DE ENVIOS') }}
                    {{ Form::number('CANTIDAD', $national->CANTIDAD, ['class' => 'form-control' . ($errors->has('CANTIDAD') ? ' is-invalid' : ''), 'placeholder' => 'Cantidad de envios']) }}
                    {!! $errors->first('CANTIDAD', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('PESO (Kg.)') }}
                    {{ Form::number('PESO', $national->PESO, ['class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''), 'placeholder' => 'Peso expresado en Kilogramos']) }}
                    {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('DESTINO NACIONAL') }}
                    {{ Form::text('DESTINO', strtoupper($national->DESTINO), ['class' => 'form-control' . ($errors->has('DESTINO') ? ' is-invalid' : ''), 'placeholder' => 'Destino nacional']) }}
                    {!! $errors->first('DESTINO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('N° DE FACTURA') }}
                    {{ Form::number('FACTURA', $national->FACTURA, ['class' => 'form-control' . ($errors->has('FACTURA') ? ' is-invalid' : ''), 'placeholder' => 'Numero de Factura']) }}
                    {!! $errors->first('FACTURA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('IMPORTE (Bs.)') }}
                    {{ Form::number('IMPORTE', $national->IMPORTE, ['class' => 'form-control' . ($errors->has('IMPORTE') ? ' is-invalid' : ''), 'placeholder' => 'Importe expresado en Bs.']) }}
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
