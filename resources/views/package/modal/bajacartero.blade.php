<!-- ... código anterior ... -->

<!-- Modal -->
<div class="modal fade" id="bajaModal{{ $package->id }}" tabindex="-1" role="dialog" aria-labelledby="bajaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bajaModalLabel">Confirmar Baja de Paquete Cartero</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('packages.deletecartero', $package->id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <p>Código Rastreo: {{ $package->CODIGO }}</p>
                            <p>Destinatario: {{ $package->DESTINATARIO }}</p>
                            <p>Ciudad: {{ $package->CUIDAD }}</p>
                        </div>
                        <div class="col">
                            <p>Tipo: {{ $package->TIPO }}</p>
                            <p>Estado: {{ $package->ESTADO }}</p>
                            <p>Fecha Ingreso: {{ $package->created_at }}</p>
                        </div>
                    </div>
                    <div class="col">
                        <p>¿En qué estado se entregó el paquete?</p>
                        <select name="estado" class="form-control" id="estadoSelect">
                            <option value="REPARTIDO">ENTREGADO</option>
                            <option value="RETORNO">RETORNO</option>
                            <option value="PRE-REZAGO">PRE-REZAGO</option>
                        </select>
                    </div>
                    <div id="observaciones" style="display: none;">
                        <p>Selecciona la razón:</p>
                        <select name="razon" class="form-control">
                            <option value="Direccion incorrecta">Direccion incorrecta</option>
                            <option value="No se localizó el destinatario">No se localizó el destinatario</option>
                            <option value="El destinatario no esta direccion">El destinatario no está en la dirección</option>
                            <option value="El remitente solicitó entrega posterior">El remitente solicitó entrega posterior</option>
                            <option value="Direccion inaccesible">Dirección inaccesible</option>
                            <option value="Entrega Perdida">Entrega perdida</option>
                            <option value="Artículo Perdido">Artículo perdido</option>
                            <option value="Articulo Incorrecto">Artículo incorrecto</option>
                            <option value="Articulo Dañado">Artículo dañado</option>
                            <option value="Articulo Prohibido">Artículo prohibido</option>
                            <option value="Importacion Restringida">Importación restringida</option>
                            <option value="No Reclamado">No reclamado</option>
                            <option value="Por Fuerza Mayor, Articulo no entregado">Por fuerza mayor, artículo no entregado</option>
                            <option value="Destinatario Solicita recojo en Agencia">Destinatario solicita recojo en agencia</option>
                            <option value="Destinatario en Vacaciones">Destinatario en vacaciones</option>
                            <option value="Destinatario en Traslado">Destinatario en traslado</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>
                    <div id="observacionespre" style="display: none;">
                        <p>Selecciona la razón:</p>
                        <select name="razon" class="form-control">
                            <option value="Articulo rechazado por el destinatario">Artículo rechazado por el destinatario</option>
                            <option value="Fallecido">Fallecido</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Aceptar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Agrega un evento para mostrar u ocultar el segundo select y las observaciones
    document.getElementById('estadoSelect').addEventListener('change', function() {
        var observacionesDiv = document.getElementById('observaciones');
        var observacionespreDiv = document.getElementById('observacionespre');

        // Muestra u oculta el div de observaciones según la opción seleccionada
        observacionesDiv.style.display = this.value === 'RETORNO' ? 'block' : 'none';
        observacionespreDiv.style.display = this.value === 'PRE-REZAGO' ? 'block' : 'none';
    });
</script>
