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
                    {{ Form::select('TIPOSERVICIO', ['EMS' => 'EMS', 'MI ENCOMIENDA' => 'MI ENCOMIENDA', 'PLIEGOS' => 'PLIEGOS', 'ORDINARIA' => 'ORDINARIA', 'ECA' => 'ECA', 'CASILLAS' => 'CASILLAS', 'SUPEREXPRESS' => 'SUPEREXPRESS', 'SACAS M' => 'SACAS M'], $national->TIPOSERVICIO, ['class' => 'form-control' . ($errors->has('TIPOSERVICIO') ? ' is-invalid' : ''), 'placeholder' => 'Tipo de servicio postal nacional', 'id' => 'tipo-correspondencia']) }}
                    {!! $errors->first('TIPOSERVICIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TIPO DE CORRESPONDENCIA') }}
                    {{ Form::select('TIPOCORRESPONDENCIA', ['PAQUETE' => 'PAQUETE', 'CARTA' => 'CARTA', 'TARJETA POSTAL' => 'TARJETA POSTAL', 'REVISTA' => 'REVISTA', 'IMPRESO' => 'IMPRESO', 'CECOGRAMA' => 'CECOGRAMA', 'PEQUEÑO PAQUETE' => 'PEQUEÑO PAQUETE', 'SACA M' => 'SACA M', 'ENCOMIENTA' => 'ENCOMIENDA', 'DOCUMENTO' => 'DOCUMENTO'], $national->TIPOCORRESPONDENCIA, ['class' => 'form-control' . ($errors->has('TIPOCORRESPONDENCIA') ? ' is-invalid' : ''), 'placeholder' => 'Tipo de correspondencia']) }}
                    {!! $errors->first('TIPOCORRESPONDENCIA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('CANTIDAD DE ENVIOS') }}
                    {{ Form::number('CANTIDAD', $national->CANTIDAD ?? 1, ['class' => 'form-control' . ($errors->has('CANTIDAD') ? ' is-invalid' : ''), 'placeholder' => 'Cantidad de envíos']) }}
                    {!! $errors->first('CANTIDAD', '<div class="invalid-feedback">:message</div>') !!}
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('DESTINO NACIONAL') }}
                    {{ Form::select('DESTINO', ['LA PAZ' => 'LA PAZ', 'COCHABAMBA' => 'COCHABAMBA', 'SANTA CRUZ' => 'SANTA CRUZ', 'ORURO' => 'ORURO', 'POTOSI' => 'POTOSI', 'TARIJA' => 'TARIJA', 'SUCRE' => 'SUCRE', 'BENI' => 'BENI', 'PANDO' => 'PANDO'], $national->DESTINO, ['class' => 'form-control' . ($errors->has('DESTINO') ? ' is-invalid' : ''), 'placeholder' => 'Destino nacional', 'id' => 'ciudad-select']) }}
                    {!! $errors->first('DESTINO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('LOCALIDAD') }}
                    {{ Form::select('PROVINCIA',['LOCAL 1' => 'LOCAL 1','LOCAL 2' => 'LOCAL 2','LOCAL 3' => 'LOCAL 3','LOCAL 4' => 'LOCAL 4','CUIDAD CAPITAL EMS' => 'CUIDAD CAPITAL EMS','CUIDAD INTERMEDIA EMS' => 'CUIDAD INTERMEDIA EMS','TRINIDAD/COBIJA EMS' => 'TRINIDAD/COBIJA EMS','RIBERALTA/GUAYARAMERIN EMS' => 'RIBERALTA/GUAYARAMERIN EMS','CUIDAD CAPITAL ME' => 'CUIDAD CAPITAL ME','TRINIDAD/COBIJA ME' => 'TRINIDAD/COBIJA ME','PROVINCIA-DENTRO ME' => 'PROVINCIA-DENTRO ME','PROVINCIA-OTRO ME' => 'PROVINCIA-OTRO ME','SERVICIO-LOCAL LC/AO' => 'SERVICIO-LOCAL LC/AO','SERVICIO-NACIONAL LC/AO' => 'SERVICIO-NACIONAL LC/AO','PROVINCIA-DENTRO LC/AO' => 'PROVINCIA-DENTRO LC/AO','PROVINCIA-OTRO LC/AO' => 'PROVINCIA-OTRO LC/AO','TRINIDAD/COBIJA LC/AO' => 'TRINIDAD/COBIJA LC/AO','RIBERALTA/GUAYARAMERIN LC/AO' => 'RIBERALTA/GUAYARAMERIN LC/AO','SERVICIO-LOCAL ECA' => 'SERVICIO-LOCAL ECA','SERVICIO-NACIONAL ECA' => 'SERVICIO-NACIONAL ECA','PROVINCIA-DENTRO ECA' => 'PROVINCIA-DENTRO ECA','PROVINCIA-OTRO ECA' => 'PROVINCIA-OTRO ECA','TRINIDAD/COBIJA ECA' => 'TRINIDAD/COBIJA ECA','RIBERALTA/GUAYARAMERIN ECA' => 'RIBERALTA/GUAYARAMERIN ECA','UNICO SE' => 'UNICO SE','SERVICIO-LOCAL PO' => 'SERVICIO-LOCAL PO','SERVICIO-NACIONAL PO' => 'SERVICIO-NACIONAL PO','PROVINCIA-DENTRO PO' => 'PROVINCIA-DENTRO PO','PROVINCIA-OTRO PO' => 'PROVINCIA-OTRO PO','SERVICIO-NACIONAL SM' => 'SERVICIO-NACIONAL SM','SERVICIO-PROVICIONAL SM' => 'SERVICIO-PROVICIONAL SM'],$national->PROVINCIA,['class' => 'form-control' . ($errors->has('PROVINCIA') ? ' is-invalid' : ''), 'placeholder' => 'Destino Local', 'id' => 'provincia-select']) }}
                    {!! $errors->first('PROVINCIA', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('DIRECCION O DOMICILIO') }}
                    {{ Form::text('DIRECCION', strtoupper($national->DIRECCION), ['class' => 'form-control' . ($errors->has('DIRECCION') ? ' is-invalid' : ''), 'style' => 'text-transform: uppercase;', 'placeholder' => 'Direccion del domicilio remitente']) }}
                    {!! $errors->first('DIRECCION', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('PESO (gr.)') }}
                    {{ Form::text('PESO', $national->PESO, [
                        'class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''),
                        'placeholder' => 'Expresa el Peso en Gramos',
                        'title' => 'Ingrese un número válido con hasta tres decimales (ej. 1.251)',
                        'oninput' => 'this.setCustomValidity("")', // Limpiar mensaje de validación personalizado
                        'pattern' => '^(\d+)?(\.\d{1,3})?$',
                        'required' => 'required',
                        'min' => '0', // Establecer el valor mínimo
                        'max' => '20.000',
                    ]) }}
                    {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                {{-- <div class="form-group">
                    {{ Form::label('N° DE FACTURA') }}
                    {{ Form::number('FACTURA', $national->FACTURA, ['class' => 'form-control' . ($errors->has('FACTURA') ? ' is-invalid' : ''), 'placeholder' => 'Numero de Factura']) }}
                    {!! $errors->first('FACTURA', '<div class="invalid-feedback">:message</div>') !!}
                </div> --}}
                {{-- <div class="form-group">
                    {{ Form::label('IMPORTE (Bs.)') }}
                    {{ Form::number('IMPORTE', $national->IMPORTE, ['class' => 'form-control' . ($errors->has('IMPORTE') ? ' is-invalid' : ''), 'placeholder' => 'Importe expresado en Bs.', 'id' => 'importe-select']) }}
                    {!! $errors->first('IMPORTE', '<div class="invalid-feedback">:message</div>') !!}
                </div> --}}
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h4>Datos del Remitente</h4>
                <div class="form-group">
                    {{ Form::label('NOMBRE Y APELLIDO DEL REMITENTE') }}
                    {{ Form::text('NOMBRESREMITENTE', strtoupper($national->NOMBRESREMITENTE), ['class' => 'form-control' . ($errors->has('NOMBRESREMITENTE') ? ' is-invalid' : ''), 'placeholder' => 'Nombre y Apellido del Remitente']) }}
                    {!! $errors->first('NOMBRESREMITENTE', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TELEFONO DEL REMITENTE') }}
                    {{ Form::number('TELEFONOREMITENTE', $national->TELEFONOREMITENTE ?? 0, ['class' => 'form-control' . ($errors->has('TELEFONOREMITENTE') ? ' is-invalid' : ''), 'placeholder' => 'Telefono del Remitente']) }}
                    {!! $errors->first('TELEFONOREMITENTE', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('C.I. REMITENTE') }}
                    {{ Form::number('CIREMITENTE', $national->CIREMITENTE, ['class' => 'form-control' . ($errors->has('CIREMITENTE') ? ' is-invalid' : ''), 'placeholder' => 'Celula de Identidad del Remitente']) }}
                    {!! $errors->first('CIREMITENTE', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <h4>Datos del Destinatario</h4>
                <div class="form-group">
                    {{ Form::label('NOMBRES DEL DESTINATARIO') }}
                    {{ Form::text('NOMBRESDESTINATARIO', strtoupper($national->NOMBRESDESTINATARIO), ['class' => 'form-control' . ($errors->has('NOMBRESDESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Nombres y Apellido del Destinatario']) }}
                    {!! $errors->first('NOMBRESDESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('TELEFONO DEL DESTINATARIO') }}
                    {{ Form::number('TELEFONODESTINATARIO', $national->TELEFONODESTINATARIO  ?? 0, ['class' => 'form-control' . ($errors->has('TELEFONODESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Telefono del Destinatario']) }}
                    {!! $errors->first('TELEFONODESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('C.I. DESTINATARIO') }}
                    {{ Form::number('CIDESTINATARIO', $national->CIDESTINATARIO, ['class' => 'form-control' . ($errors->has('CIDESTINATARIO') ? ' is-invalid' : ''), 'placeholder' => 'Celula de Identidad del Destinatario']) }}
                    {!! $errors->first('CIDESTINATARIO', '<div class="invalid-feedback">:message</div>') !!}
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Oculta todas las opciones de PROVINCIA al cargar la página
        $('#provincia-select option').hide();

        // Maneja el cambio en el select de TIPOCORRESPONDENCIA
        $('#tipo-correspondencia').on('change', function() {
            var tipo = $(this).val();

            // Muestra u oculta las opciones de PROVINCIA según el tipo seleccionado
            if (tipo === 'EMS') {
                $('#provincia-select option').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL EMS"]').show();
                $('#provincia-select option[value="LOCAL 1"]').show();
                $('#provincia-select option[value="LOCAL 2"]').show();
                $('#provincia-select option[value="LOCAL 3"]').show();
                $('#provincia-select option[value="LOCAL 4"]').show();
                $('#provincia-select option[value="CUIDAD INTERMEDIA EMS"]').show();
                $('#provincia-select option[value="TRINIDAD/COBIJA EMS"]').show();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN EMS"]').show();
                $('#provincia-select option[value="CUIDAD CAPITAL ME"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ME"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO LC/AO"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA LC/AO"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL ECA"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ECA"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ECA"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN ECA"]').hide();
                $('#provincia-select option[value="UNICO SE"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL SM"]').hide();
                $('#provincia-select option[value="SERVICIO-PROVICIONAL SM"]').hide();
            } else if (tipo === 'MI ENCOMIENDA') {
                $('#provincia-select option').hide();
                $('#provincia-select option[value="LOCAL 1"]').hide();
                $('#provincia-select option[value="LOCAL 2"]').hide();
                $('#provincia-select option[value="LOCAL 3"]').hide();
                $('#provincia-select option[value="LOCAL 4"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL EMS"]').hide();
                $('#provincia-select option[value="CUIDAD INTERMEDIA EMS"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA EMS"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN EMS"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL ME"]').show();
                $('#provincia-select option[value="TRINIDAD/COBIJA ME"]').show();
                $('#provincia-select option[value="PROVINCIA-DENTRO ME"]').show();
                $('#provincia-select option[value="PROVINCIA-OTRO ME"]').show();
                $('#provincia-select option[value="SERVICIO-LOCAL LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO LC/AO"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA LC/AO"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL ECA"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ECA"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ECA"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN ECA"]').hide();
                $('#provincia-select option[value="UNICO SE"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL SM"]').hide();
                $('#provincia-select option[value="SERVICIO-PROVICIONAL SM"]').hide();
            } else if (tipo === 'ORDINARIA') {
                $('#provincia-select option').hide();
                $('#provincia-select option[value="LOCAL 1"]').hide();
                $('#provincia-select option[value="LOCAL 2"]').hide();
                $('#provincia-select option[value="LOCAL 3"]').hide();
                $('#provincia-select option[value="LOCAL 4"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL EMS"]').hide();
                $('#provincia-select option[value="CUIDAD INTERMEDIA EMS"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA EMS"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN EMS"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL ME"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ME"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL LC/AO"]').show();
                $('#provincia-select option[value="SERVICIO-NACIONAL LC/AO"]').show();
                $('#provincia-select option[value="PROVINCIA-DENTRO LC/AO"]').show();
                $('#provincia-select option[value="PROVINCIA-OTRO LC/AO"]').show();
                $('#provincia-select option[value="TRINIDAD/COBIJA LC/AO"]').show();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN LC/AO"]').show();
                $('#provincia-select option[value="SERVICIO-LOCAL ECA"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ECA"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ECA"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN ECA"]').hide();
                $('#provincia-select option[value="UNICO SE"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL SM"]').hide();
                $('#provincia-select option[value="SERVICIO-PROVICIONAL SM"]').hide();
            } else if (tipo === 'ECA') {
                $('#provincia-select option').hide();
                $('#provincia-select option[value="LOCAL 1"]').hide();
                $('#provincia-select option[value="LOCAL 2"]').hide();
                $('#provincia-select option[value="LOCAL 3"]').hide();
                $('#provincia-select option[value="LOCAL 4"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL EMS"]').hide();
                $('#provincia-select option[value="CUIDAD INTERMEDIA EMS"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA EMS"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN EMS"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL ME"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ME"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO LC/AO"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA LC/AO"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL ECA"]').show();
                $('#provincia-select option[value="SERVICIO-NACIONAL ECA"]').show();
                $('#provincia-select option[value="PROVINCIA-DENTRO ECA"]').show();
                $('#provincia-select option[value="PROVINCIA-OTRO ECA"]').show();
                $('#provincia-select option[value="TRINIDAD/COBIJA ECA"]').show();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN ECA"]').show();
                $('#provincia-select option[value="UNICO SE"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL SM"]').hide();
                $('#provincia-select option[value="SERVICIO-PROVICIONAL SM"]').hide();
            } else if (tipo === 'SUPEREXPRESS') {
                $('#provincia-select option').hide();
                $('#provincia-select option[value="LOCAL 1"]').hide();
                $('#provincia-select option[value="LOCAL 2"]').hide();
                $('#provincia-select option[value="LOCAL 3"]').hide();
                $('#provincia-select option[value="LOCAL 4"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL EMS"]').hide();
                $('#provincia-select option[value="CUIDAD INTERMEDIA EMS"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA EMS"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN EMS"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL ME"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ME"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO LC/AO"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA LC/AO"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL ECA"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ECA"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ECA"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN ECA"]').hide();
                $('#provincia-select option[value="UNICO SE"]').show();
                $('#provincia-select option[value="SERVICIO-LOCAL PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL SM"]').hide();
                $('#provincia-select option[value="SERVICIO-PROVICIONAL SM"]').hide();
            } else if (tipo === 'PLIEGOS') {
                $('#provincia-select option').hide();
                $('#provincia-select option[value="LOCAL 1"]').hide();
                $('#provincia-select option[value="LOCAL 2"]').hide();
                $('#provincia-select option[value="LOCAL 3"]').hide();
                $('#provincia-select option[value="LOCAL 4"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL EMS"]').hide();
                $('#provincia-select option[value="CUIDAD INTERMEDIA EMS"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA EMS"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN EMS"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL ME"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ME"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO LC/AO"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA LC/AO"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL ECA"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ECA"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ECA"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN ECA"]').hide();
                $('#provincia-select option[value="UNICO SE"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL PO"]').show();
                $('#provincia-select option[value="SERVICIO-NACIONAL PO"]').show();
                $('#provincia-select option[value="PROVINCIA-DENTRO PO"]').show();
                $('#provincia-select option[value="PROVINCIA-OTRO PO"]').show();
                $('#provincia-select option[value="SERVICIO-NACIONAL SM"]').hide();
                $('#provincia-select option[value="SERVICIO-PROVICIONAL SM"]').hide();
            } else if (tipo === 'SACAS M') {
                $('#provincia-select option').hide();
                $('#provincia-select option[value="LOCAL 1"]').hide();
                $('#provincia-select option[value="LOCAL 2"]').hide();
                $('#provincia-select option[value="LOCAL 3"]').hide();
                $('#provincia-select option[value="LOCAL 4"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL EMS"]').hide();
                $('#provincia-select option[value="CUIDAD INTERMEDIA EMS"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA EMS"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN EMS"]').hide();
                $('#provincia-select option[value="CUIDAD CAPITAL ME"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ME"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ME"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO LC/AO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO LC/AO"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA LC/AO"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN LC/AO"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL ECA"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO ECA"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO ECA"]').hide();
                $('#provincia-select option[value="TRINIDAD/COBIJA ECA"]').hide();
                $('#provincia-select option[value="RIBERALTA/GUAYARAMERIN ECA"]').hide();
                $('#provincia-select option[value="UNICO SE"]').hide();
                $('#provincia-select option[value="SERVICIO-LOCAL PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-DENTRO PO"]').hide();
                $('#provincia-select option[value="PROVINCIA-OTRO PO"]').hide();
                $('#provincia-select option[value="SERVICIO-NACIONAL SM"]').show();
                $('#provincia-select option[value="SERVICIO-PROVICIONAL SM"]').show();
            } else {
                $('#provincia-select option').hide();
            }
        });
    });
</script>
