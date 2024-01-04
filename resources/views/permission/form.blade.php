<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('name') }}
            {{ Form::text('name', $permission->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('guard_name') }}
            {{ Form::text('guard_name', 'web', [
                'class' => 'form-control' . ($errors->has('guard_name') ? ' is-invalid' : ''),
                'placeholder' => 'Guard Name',
                'readonly' => true,
            ]) }}
            {!! $errors->first('guard_name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="box-footer mt20">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        </div>
    </div>
</div>