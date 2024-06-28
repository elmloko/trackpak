<!-- Modal -->
<div class="modal fade" id="despachoModal{{ $bag->id }}" tabindex="-1" role="dialog" aria-labelledby="bajaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="despachoModalLabel">Cerrar Expedicion de Saca {{ $bag->MARBETE }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('bags.goExpedition', $bag->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if ($bag->ITINERARIO == 'POR AVION')
                                <div class="form-group" id="transporte-container">
                                    {{ Form::label('TRASPORTE') }}
                                    {{ Form::select(
                                        'TRASPORTE',
                                        [
                                            '' => 'Primero seleccione un itinerario',
                                            'BOA' => 'BOA',
                                        ],
                                        $bag->TRASPORTE,
                                        [
                                            'class' => 'form-control' . ($errors->has('TRASPORTE') ? ' is-invalid' : ''),
                                            'id' => 'transporte-select',
                                            
                                        ],
                                    ) }}
                                    {!! $errors->first('TRASPORTE', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            @elseif($bag->ITINERARIO == 'POR SUPERFICIE')
                                <div class="form-group" id="transporte-container">
                                    {{ Form::label('TRASPORTE') }}
                                    {{ Form::select(
                                        'TRASPORTE',
                                        [
                                            'TRANS VARSOVIA' => 'TRANS VARSOVIA',
                                            'TRANS DORADO' => 'TRANS DORADO',
                                            'TRANS ELITE' => 'TRANS ELITE',
                                            'TRANS 6 DE AGO' => 'TRANS 6 DE AGO',
                                            'TRANS LUPJANSA' => 'TRANS LUPJANSA',
                                            'TRANS YUNGEÑA' => 'TRANS YUNGEÑA',
                                            'TRANS COPACABANA' => 'TRANS COPACABANA',
                                            'TRANS AZUL' => 'TRANS AZUL',
                                            'TRANS RAPIDITO SUR' => 'TRANS RAPIDITO SUR',
                                            'TRANS MI PREFERIDA' => 'TRANS MI PREFERIDA',
                                        ],
                                        $bag->TRASPORTE,
                                        [
                                            'class' => 'form-control' . ($errors->has('TRASPORTE') ? ' is-invalid' : ''),
                                            'id' => 'transporte-select',
                                            
                                        ],
                                    ) }}
                                    {!! $errors->first('TRASPORTE', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            @endif
                            {{-- <div class="form-group">
                                {{ Form::label('NFACTURA') }}
                                {{ Form::number('NFACTURA', strtoupper($bag->NFACTURA), [
                                    'class' => 'form-control' . ($errors->has('NFACTURA') ? ' is-invalid' : ''),
                                    'placeholder' => 'Observaciones de Saca',
                                ]) }}
                                {!! $errors->first('NFACTURA', '<div class="invalid-feedback">:message</div>') !!}
                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('HORARIO', 'Horario') }}
                                {{ Form::input('time', 'HORARIO', $bag->OFCAMBIO, ['class' => 'form-control' . ($errors->has('HORARIO') ? ' is-invalid' : ''), 'id' => 'horario-input']) }}
                                {!! $errors->first('HORARIO', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('OBSERVACIONES') }}
                                {{ Form::text('OBSERVACIONES', strtoupper($bag->OBSERVACIONES), [
                                    'class' => 'form-control' . ($errors->has('OBSERVACIONES') ? ' is-invalid' : ''),
                                    'placeholder' => 'Observaciones de Saca',
                                ]) }}
                                {!! $errors->first('OBSERVACIONES', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Imprimir</button>
                </div>
            </form>
        </div>
    </div>
</div>
