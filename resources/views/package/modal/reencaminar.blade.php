<!-- Modal -->
<div class="modal fade" id="reencaminarModal{{$package->id}}" tabindex="-1" role="dialog" aria-labelledby="reencaminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reencaminarModalLabel">Confirmar Rencaminamiento de Paquete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <p>Código Postal: {{$package->CODIGO}}</p>
                        <p>Destinatario: {{$package->DESTINATARIO}}</p>
                        <p>Destino: {{$package->CUIDAD}}</p>
                        <p>Ventanilla: {{$package->VENTANILLA}}</p>
                    </div>
                    <div class="col">
                        <p>Tipo: {{$package->TIPO}}</p>
                        <p>Estado: {{$package->ESTADO}}</p>
                        <p>Aduana: {{$package->ADUANA}}</p>
                        <p>Fecha Ingreso: {{$package->created_at}}</p>
                    </div>
                </div>
                <p>¿Donde se encontraba este paquete?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a href="{{ route('packages.redirigir', $package->id) }}" class="btn btn-success">Confirmar Rencaminamiento</a>
            </div>
        </div>
    </div>
</div>
