<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
            @hasrole('SuperAdmin|Administrador')
            <div class="form-group">
                {{ Form::label('NUMERO DE DESPACHO') }}
                {{ Form::text('NRODESPACHO', $bag->NRODESPACHO, ['class' => 'form-control' . ($errors->has('NRODESPACHO') ? ' is-invalid' : ''), 'placeholder' => 'Nrodespacho']) }}
                {!! $errors->first('NRODESPACHO', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('OFICINA DE CAMBIO') }}
                {{ Form::select('OFCAMBIO', ['LA PAZ' => 'LA PAZ', 'COCHABAMBA' => 'COCHABAMBA', 'SANTA CRUZ' => 'SANTA CRUZ', 'ORURO' => 'ORURO', 'POTOSI' => 'POTOSI', 'TARIJA' => 'TARIJA', 'SUCRE' => 'SUCRE', 'BENI' => 'BENI', 'PANDO' => 'PANDO'], $bag->OFCAMBIO, ['class' => 'form-control' . ($errors->has('OFCAMBIO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Cuidad', 'id' => 'ciudad-select']) }}
                {!! $errors->first('OFCAMBIO', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('OFICINA DE DESTINO') }}
                {{ Form::select('OFDESTINO', ['LA PAZ' => 'LA PAZ', 'COCHABAMBA' => 'COCHABAMBA', 'SANTA CRUZ' => 'SANTA CRUZ', 'ORURO' => 'ORURO', 'POTOSI' => 'POTOSI', 'TARIJA' => 'TARIJA', 'SUCRE' => 'SUCRE', 'BENI' => 'BENI', 'PANDO' => 'PANDO'], $bag->OFDESTINO, ['class' => 'form-control' . ($errors->has('OFDESTINO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Cuidad', 'id' => 'ciudad-select']) }}
                {!! $errors->first('OFDESTINO', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('ESTADO') }}
                {{ Form::text('ESTADO', $bag->ESTADO, ['class' => 'form-control' . ($errors->has('ESTADO') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
                {!! $errors->first('ESTADO', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('PAQUETES') }}
                {{ Form::text('PAQUETES', $bag->PAQUETES, ['class' => 'form-control' . ($errors->has('PAQUETES') ? ' is-invalid' : ''), 'placeholder' => 'Paquetes']) }}
                {!! $errors->first('PAQUETES', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            @endhasrole
            <div class="form-group">
                {{ Form::label('NUMERO DE SACAS') }}
                {{ Form::number('NROSACAS', $bag->NROSACAS, ['class' => 'form-control' . ($errors->has('NROSACAS') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese Numero de Sacas']) }}
                {!! $errors->first('NROSACAS', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('PESO (Kg.)') }}
                {{ Form::number('PESO', $bag->PESO, [
                    'class' => 'form-control' . ($errors->has('PESO') ? ' is-invalid' : ''),
                    'placeholder' => 'Expresa el Peso en Gramos',
                    'title' => 'Ingrese un número válido con hasta tres decimales (ej. 1.251)',
                    'oninput' => 'this.setCustomValidity("")', // Limpiar mensaje de validación personalizado
                    'pattern' => '^(\d+)?(\.\d{1,3})?$',
                    'required' => 'required',
                    'min' => '0', // Establecer el valor mínimo
                    'max' => '100.000',
                ]) }}
                {!! $errors->first('PESO', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('ITINERARIO') }}
                {{ Form::select('ITINERARIO', ['POR AVION' => 'POR AVION', 'POR SUPERFICIE' => 'POR SUPERFICIE'], $bag->OFCAMBIO, ['class' => 'form-control' . ($errors->has('ITINERARIO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el metodo de envio', 'id' => 'ciudad-select']) }}
                {!! $errors->first('ITINERARIO', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="box-footer mt20">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        </div>
    </div>
</div>