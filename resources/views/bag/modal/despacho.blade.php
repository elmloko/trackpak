<!-- Modal -->
<div class="modal fade" id="despachoModal{{ $bag->id }}" tabindex="-1" role="dialog" aria-labelledby="bajaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="despachoModalLabel">Cerrar Expedicion de Saca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('bags.closeExpedition', $bag->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            {{-- <div class="form-group">
                                {{ Form::label('NUMERO DE SACAS') }}
                                {{ Form::number('NROSACAS', $bag->NROSACAS, ['class' => 'form-control' . ($errors->has('NROSACAS') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese Numero de Sacas']) }}
                                {!! $errors->first('NROSACAS', '<div class="invalid-feedback">:message</div>') !!}
                            </div> --}}
                            <div class="form-group">
                                {{ Form::label('ITINERARIO') }}
                                {{ Form::select('ITINERARIO', ['POR AVION' => 'POR AVION', 'POR SUPERFICIE' => 'POR SUPERFICIE'], $bag->OFCAMBIO, ['class' => 'form-control' . ($errors->has('ITINERARIO') ? ' is-invalid' : ''), 'placeholder' => 'Selecione el metodo de envio', 'id' => 'ciudad-select']) }}
                                {!! $errors->first('ITINERARIO', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('PESO (Kg.)') }}
                                {{ Form::text('PESO', $bag->PESO, [
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
                        </div>
                    </div>
                </div>  
                <div class="modal-footer">
                    <a class="btn btn-sm btn-info" href="{{ route('bags.show', $bag->id) }}">
                        Ver Paquetes
                    </a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar Baja</button>
                </div>
            </form>
        </div>
    </div>
</div>
