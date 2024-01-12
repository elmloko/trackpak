<!-- Modal de búsqueda de paquete -->
<div class="modal fade" id="buscarPaqueteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscar Paquetes DND Ventanilla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para buscar un paquete por código -->
                <form action="{{ route('packages.buscarPaquete') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="codigo">Código del Paquete</label>
                        <input type="text" class="form-control" id="codigo" name="codigo">
                    </div>
                    {{-- @if (auth()->user()->Regional == 'LA PAZ')
                        <div class="form-group">
                            <label for="zona">Zona</label>
                            <select class="form-control" id="zona" name="zona">
                                <option value="DND">DND</option>
                            </select>
                        </div>
                    @else
                        
                    @endif --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
