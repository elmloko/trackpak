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
                <div class="row">
                    <div class="col">
                        <p>Código Postal: {{ $package->CODIGO }}</p>
                        <p>Destinatario: {{ $package->DESTINATARIO }}</p>
                        <p>Ciudad: {{ $package->CUIDAD }}</p>
                    </div>
                    <div class="col">
                        <p>Tipo: {{ $package->TIPO }}</p>
                        <p>Estado: {{ $package->ESTADO }}</p>
                        <p>Fecha Ingreso: {{ $package->created_at }}</p>
                    </div>
                </div>
                <p>¿Estás seguro de que deseas dar de baja este paquete?</p>
                <div class="text-center">
                    <a href="{{ route('package.pdf.formularioentrega', ['id' => $package->id]) }}"
                        class="btn btn-secondary btn-lg">Imprimir Formulario de Entrega</a>
                </div>
            </div>
            <div class="row">
                <div class="col text-left mt-3">
                    <a href="{{ route('package.pdf.abandono', $package->id) }}" class="btn btn-info ml-2">
                        Abandono Paquete
                    </a>
                </div>
                <div class="col modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <a href="{{ route('packages.deletecartero', $package->id) }}" class="btn btn-success">Confirmar Baja</a>
                </div>
            </div>
        </div>
    </div>
</div>
