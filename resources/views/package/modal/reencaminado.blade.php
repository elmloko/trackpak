<!-- Modal -->
<div class="modal fade" id="reencaminadoModal{{$packages->id}}" tabindex="-1" role="dialog" aria-labelledby="reencaminadoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reencaminadoModalLabel">Confirmar Rencaminamiento de Paquete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <p>Código Postal: {{$packages->CODIGO}}</p>
                        <p>Destinatario: {{$packages->DESTINATARIO}}</p>
                        <p>Ciudad: {{$packages->CUIDAD}}</p>
                        <p>Ventanilla: {{$packages->VENTANILLA}}</p>
                    </div>
                    <div class="col">
                        <p>Tipo: {{$packages->TIPO}}</p>
                        <p>Estado: {{$packages->ESTADO}}</p>
                        <p>Aduana: {{$packages->ADUANA}}</p>
                        <p>Fecha Ingreso: {{$packages->created_at}}</p>
                    </div>
                </div>
                <p>¿Estás seguro de que deseas reencaminar este paquete?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a href="{{ route('packages.dirigido', $packages->id) }}" class="btn btn-success">Confirmar Rencaminamiento</a>
            </div>
        </div>
    </div>
</div>
