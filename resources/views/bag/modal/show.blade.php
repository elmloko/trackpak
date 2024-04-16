<!-- Modal -->
<div class="modal fade" id="showModal{{ $bag->id }}" tabindex="-1" role="dialog" aria-labelledby="bajaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showModalLabel">Cerrar Expedicion de Saca {{ $bag->MARBETE }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('bags.showExpedition', $bag->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Edite los datos</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>PAQUETES</th>
                                        <th>PESO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($repeatedBags as $repeatedBag)
                                        @if ($repeatedBag->MARBETE == $bag->MARBETE)
                                            <tr>
                                                <td>{{ $repeatedBag->NRODESPACHO }}/{{ $repeatedBag->NROSACA }}</td>
                                                <td>
                                                    {{ Form::text("PAQUETES[$repeatedBag->id]", $repeatedBag->PAQUETES, [
                                                        'class' => 'form-control' . ($errors->has("PAQUETES.$repeatedBag->id") ? ' is-invalid' : ''),
                                                        'placeholder' => 'Expresa el Peso en Gramos',
                                                        'title' => 'Ingrese un número válido con hasta tres decimales (ej. 1.251)',
                                                        'oninput' => 'this.setCustomValidity("")', // Limpiar mensaje de validación personalizado
                                                        'pattern' => '^(\d+)?(\.\d{1,3})?$',
                                                        'required' => 'required',
                                                        'min' => '0', // Establecer el valor mínimo
                                                        'max' => '100.000',
                                                    ]) }}
                                                    {!! $errors->first("PAQUETES.$repeatedBag->id", '<div class="invalid-feedback">:message</div>') !!}
                                                </td>
                                                <td>
                                                    {{ Form::text("PESOF[$repeatedBag->id]", $repeatedBag->PESOF, [
                                                        'class' => 'form-control' . ($errors->has("PESOF.$repeatedBag->id") ? ' is-invalid' : ''),
                                                        'placeholder' => 'Expresa el Peso en Gramos',
                                                        'title' => 'Ingrese un número válido con hasta tres decimales (ej. 1.251)',
                                                        'oninput' => 'this.setCustomValidity("")', // Limpiar mensaje de validación personalizado
                                                        'pattern' => '^(\d+)?(\.\d{1,3})?$',
                                                        'required' => 'required',
                                                        'min' => '0', // Establecer el valor mínimo
                                                        'max' => '100.000',
                                                    ]) }}
                                                    {!! $errors->first("PESOF.$repeatedBag->id", '<div class="invalid-feedback">:message</div>') !!}
                                                </td>                                                
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar Baja</button>
                </div>
            </form>
        </div>
    </div>
</div>
