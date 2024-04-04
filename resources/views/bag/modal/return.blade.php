<!-- Modal -->
<div class="modal fade" id="returnModal{{ $bag->id }}" tabindex="-1" role="dialog" aria-labelledby="bajaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnModalLabel">Return para {{ $bag->MARBETE }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('bags.returnExpedition', $bag->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p>¿Esta seguro que desea devolver a destino? {{ $bag->OFDESTINO }} > {{ $bag->OFCAMBIO }}</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('SACA BLANCAS/AZULES') }}
                                <p>{{ $sum->sum_tipo }}</p>
                            </div>
                            <div class="form-group">
                                {{ Form::label('SACAS ROJAS') }}
                                <p>{{ $bag->SACAR }}</p>
                            </div>
                            <div class="form-group">
                                {{ Form::label('SACAS M') }}
                                <p>{{ $bag->SACAM }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('PESO') }}
                                <p>{{ $sum->sum_pesoc }} Kg.</p>
                            </div>
                            <div class="form-group">
                                {{ Form::label('PESO') }}
                                <p>{{ $bag->PESOR }}</p>
                            </div>
                            <div class="form-group">
                                {{ Form::label('PESO') }}
                                <p>{{ $bag->PESOM }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('PAQUETES') }}
                                <p>{{ $sum->sum_paquetes }}</p>
                            </div>
                            <div class="form-group">
                                {{ Form::label('PAQUETES') }}
                                <p>{{ $bag->PAQUETESR }}</p>
                            </div>
                            <div class="form-group">
                                {{ Form::label('PAQUETES') }}
                                <p>{{ $bag->PAQUETESM }}</p>
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
