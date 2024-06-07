<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('NUMERO DE DESPACHO') }}
                {{ Form::number('NRODESPACHO', $bag->NRODESPACHO, ['class' => 'form-control' . ($errors->has('NRODESPACHO') ? ' is-invalid' : ''), 'placeholder' => 'Nrodespacho']) }}
                {!! $errors->first('NRODESPACHO', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('OFICINA DE DESTINO') }}
                {{ Form::select('OFDESTINO', ['LA PAZ' => 'LA PAZ', 'COCHABAMBA' => 'COCHABAMBA', 'SANTA CRUZ' => 'SANTA CRUZ', 'ORURO' => 'ORURO', 'POTOSI' => 'POTOSI', 'TARIJA' => 'TARIJA', 'SUCRE' => 'SUCRE', 'BENI' => 'BENI', 'PANDO' => 'PANDO'], $bag->OFDESTINO, ['class' => 'form-control' . ($errors->has('OFDESTINO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione la Cuidad', 'id' => 'ciudad-select']) }}
                {!! $errors->first('OFDESTINO', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="box-footer mt20">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        </div>
    </div>
</div>