<!-- Modal -->
<div class="modal fade" id="despachoModal{{ $bag->id }}" tabindex="-1" role="dialog" aria-labelledby="bajaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="despachoModalLabel">Cerrar Expedicion de Saca {{ $bag->NROSACA }} / {{ $bag->NRODESPACHO }} </h5>
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
                            <div class="form-group">
                                {{ Form::label('ITINERARIO') }}
                                {{ Form::select('ITINERARIO', ['' => 'Seleccione una opción', 'POR AVION' => 'POR AVION', 'POR SUPERFICIE' => 'POR SUPERFICIE'], $bag->OFCAMBIO, ['class' => 'form-control' . ($errors->has('ITINERARIO') ? ' is-invalid' : ''), 'id' => 'itinerario-select']) }}
                                {!! $errors->first('ITINERARIO', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                            <div class="form-group" id="transporte-container">
                                {{ Form::label('TRASPORTE') }}
                                {{ Form::select(
                                    'TRASPORTE',
                                    [
                                        '' => 'Primero seleccione un itinerario',
                                        'BOA' => 'BOA',
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
                                        'disabled' => 'disabled',
                                    ],
                                ) }}
                                {!! $errors->first('TRASPORTE', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('PESOF (Kg.)') }}
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
                            </div>
                            <div class="form-group">
                                {{ Form::label('HORARIO') }}
                                {{ Form::select('HORARIO', ['' => 'Seleccione una opción', '08:00' => '08:00', '09:00' => '09:00', '10:00' => '10:00'], $bag->OFCAMBIO, ['class' => 'form-control' . ($errors->has('HORARIO') ? ' is-invalid' : ''), 'id' => 'horario-select']) }}
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
                    <a class="btn btn-info" href="{{ route('bags.show', $bag->id) }}">
                        Ver Paquetes
                    </a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar Baja</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var itinerarioSelect = document.getElementById('itinerario-select');
        var transporteContainer = document.getElementById('transporte-container');
        var transporteSelect = document.getElementById('transporte-select');
        var horarioSelect = document.getElementById('horario-select');

        itinerarioSelect.addEventListener('change', function() {
            // Habilitar o deshabilitar el campo TRASPORTE según la selección de ITINERARIO
            if (itinerarioSelect.value === '') {
                transporteSelect.disabled = true;
            } else {
                transporteSelect.disabled = false;
            }

            // Actualizar el valor del campo TRASPORTE según la selección de ITINERARIO
            if (itinerarioSelect.value === 'POR AVION') {
                transporteSelect.innerHTML = '<option value="BOA">BOA</option>';
            } else {
                transporteSelect.innerHTML = '<option value="TRANS VARSOVIA">TRANS VARSOVIA</option>' +
                    '<option value="TRANS DORADO">TRANS DORADO</option>' +
                    '<option value="TRANS ELITE">TRANS ELITE</option>' +
                    '<option value="TRANS 6 DE AGO">TRANS 6 DE AGO</option>' +
                    '<option value="TRANS LUPJANSA">TRANS LUPJANSA</option>' +
                    '<option value="TRANS YUNGEÑA">TRANS YUNGEÑA</option>' +
                    '<option value="TRANS COPACABANA">TRANS COPACABANA</option>' +
                    '<option value="TRANS AZUL">TRANS AZUL</option>' +
                    '<option value="TRANS RAPIDITO SUR">TRANS RAPIDITO SUR</option>' +
                    '<option value="TRANS MI PREFERIDA">TRANS MI PREFERIDA</option>';
            }
        });

        // Deshabilitar el campo TRASPORTE al cargar la página
        transporteSelect.disabled = true;

        // Actualizar los horarios según la selección de transporte
        transporteSelect.addEventListener('change', function() {
            if (transporteSelect.value === 'BOA') {
                horarioSelect.innerHTML = '<option value="08:00">08:00</option>' +
                    '<option value="09:00">09:00</option>';
            } else {
                horarioSelect.innerHTML = '<option value="10:00">10:00</option>';
            }
        });
    });
</script>
