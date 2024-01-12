<!-- Modal -->
<div class="modal fade" id="bajaModal{{ $package->id }}" tabindex="-1" role="dialog" aria-labelledby="bajaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bajaModalLabel">Confirmar Entrega de Paquete ECA Postal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <p>Código Rastreo: {{ $package->CODIGO }}</p>
                        <p>Destinatario: {{ $package->DESTINATARIO }}</p>
                        <p>Ciudad: {{ $package->CUIDAD }}</p>
                        <p>Ventanilla: {{ $package->VENTANILLA }}</p>
                    </div>
                    <div class="col">
                        <p>Tipo: {{ $package->TIPO }}</p>
                        <p>Estado: {{ $package->ESTADO }}</p>
                        <p>Precio: {{ $package->PRECIO }} Bs.</p>
                        <p>Fecha Ingreso: {{ $package->created_at }}</p>
                    </div>
                </div>
                <p>¿Estás seguro de que deseas dar de baja este paquete?</p>
                {{-- <div class="text-center">
                    <a href="{{ route('package.pdf.formularioentrega', ['id' => $package->id]) }}"
                        class="btn btn-secondary btn-lg" target="_blank">Imprimir Formulario de Entrega</a>
                </div> --}}
            </div>
            <div class="row">
                <div class="col modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <a href="{{ route('packages.deleteeca', $package->id) }}" class="btn btn-success">Confirmar Baja</a>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Agrega este bloque de script
    function reloadPageAfterDelay() {
        setTimeout(function () {
            location.reload(true);
        }, 1000);
    }
</script>