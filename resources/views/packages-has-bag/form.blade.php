<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('bags_id') }}
            {{ Form::text('bags_id', $packagesHasBag->bags_id, ['class' => 'form-control' . ($errors->has('bags_id') ? ' is-invalid' : ''), 'placeholder' => 'Bags Id']) }}
            {!! $errors->first('bags_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('packages_id') }}
            {{ Form::text('packages_id', $packagesHasBag->packages_id, ['class' => 'form-control' . ($errors->has('packages_id') ? ' is-invalid' : ''), 'placeholder' => 'Packages Id']) }}
            {!! $errors->first('packages_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>