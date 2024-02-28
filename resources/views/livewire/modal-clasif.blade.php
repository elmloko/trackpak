<div>
    <button wire:click="openModal" class="btn btn-warning">Despachar</button>
    @if($showModal)
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar despacho de paquetes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de despachar estos paquetes?
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="option" id="option_seguir" value="seguir" wire:model="option">
                                <label class="form-check-label" for="option_seguir">
                                    Seguir despachando
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="option" id="option_nuevo" value="nuevo" wire:model="option">
                                <label class="form-check-label" for="option_nuevo">
                                    Nuevo despacho
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="closeModal">Cancelar</button>
                        <button type="button" class="btn btn-primary" wire:click="cambiarEstado">Despachar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
