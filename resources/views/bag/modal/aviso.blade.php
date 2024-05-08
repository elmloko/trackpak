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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('ITINERARIO') }}
                                {{ Form::select('ITINERARIO', ['' => 'Seleccione una opción', 'POR AVION' => 'POR AVION', 'POR SUPERFICIE' => 'POR SUPERFICIE'], $bag->ITINERARIO, ['class' => 'form-control' . ($errors->has('ITINERARIO') ? ' is-invalid' : ''), 'id' => 'itinerario-select']) }}
                                {!! $errors->first('ITINERARIO', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- <div class="form-group">
                                {{ Form::label('CONTROL PESO (Kg.)') }}
                                {{ Form::text('PESOF', $bag->PESOF, [
                                    'class' => 'form-control' . ($errors->has('PESOF') ? ' is-invalid' : ''),
                                    'placeholder' => 'Expresa el Peso en Gramos',
                                    'title' => 'Ingrese un número válido con hasta tres decimales (ej. 1.251)',
                                    'oninput' => 'this.setCustomValidity("")', // Limpiar mensaje de validación personalizado
                                    'pattern' => '^(\d+)?(\.\d{1,3})?$',
                                    'required' => 'required',
                                    'min' => '0', // Establecer el valor mínimo
                                    'max' => '100.000',
                                ]) }}
                                {!! $errors->first('PESOF', '<div class="invalid-feedback">:message</div>') !!}
                            </div> --}}
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
                    <button type="submit" class="btn btn-success">Imprimir CN-31</button>
                </div>
            </form>
        </div>
    </div>
</div>