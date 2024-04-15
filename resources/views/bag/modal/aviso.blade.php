<!-- Modal -->
<div class="modal fade" id="avisoModal{{ $bag->id }}" tabindex="-1" role="dialog" aria-labelledby="bajaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avisoModalLabel">Hoja de Aviso para {{ $bag->MARBETE }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('bags.avisoExpedition', $bag->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p>¿Desea añadir sacas a su Despacho?</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('SACA BLANCAS/AZULES') }}
                                <p>{{ $sum->sum_tipo }}</p>
                            </div>
                            <div class="form-group">
                                {{ Form::label('SACAS ROJAS') }}
                                {{ Form::text('SACAR', strtoupper($bag->SACAR), [
                                    'class' => 'form-control' . ($errors->has('SACAR') ? ' is-invalid' : ''),
                                    'placeholder' => 'Cantidad Total Saca Certificada',
                                ]) }}
                                {!! $errors->first('SACAR', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('SACAS M') }}
                                {{ Form::text('SACAM', strtoupper($bag->SACAM), [
                                    'class' => 'form-control' . ($errors->has('SACAM') ? ' is-invalid' : ''),
                                    'placeholder' => 'Cantidad Total Saca M',
                                ]) }}
                                {!! $errors->first('SACAM', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('PESO') }}
                                <p>{{ $sum->sum_pesoc }} Kg.</p>
                            </div>
                            <div class="form-group">
                                {{ Form::label('PESO') }}
                                {{ Form::text('PESOR', strtoupper($bag->PESOR), [
                                    'class' => 'form-control' . ($errors->has('PESOR') ? ' is-invalid' : ''),
                                    'placeholder' => 'Peso Total Saca R',
                                ]) }}
                                {!! $errors->first('PESOR', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('PESO') }}
                                {{ Form::text('PESOM', strtoupper($bag->PESOM), [
                                    'class' => 'form-control' . ($errors->has('PESOM') ? ' is-invalid' : ''),
                                    'placeholder' => 'Peso Total Saca M',
                                ]) }}
                                {!! $errors->first('PESOM', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('PAQUETES') }}
                                <p>{{ $sum->sum_paquetes }}</p>
                            </div>
                            <div class="form-group">
                                {{ Form::label('PAQUETES') }}
                                {{ Form::text('PAQUETESR', strtoupper($bag->PAQUETESR), [
                                    'class' => 'form-control' . ($errors->has('PAQUETESR') ? ' is-invalid' : ''),
                                    'placeholder' => 'Paquetes Total Saca R',
                                ]) }}
                                {!! $errors->first('PAQUETESR', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('PAQUETES') }}
                                {{ Form::text('PAQUETESM', strtoupper($bag->PAQUETESM), [
                                    'class' => 'form-control' . ($errors->has('PAQUETESM') ? ' is-invalid' : ''),
                                    'placeholder' => 'Paquetes Total Saca M',
                                ]) }}
                                {!! $errors->first('PAQUETESM', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>