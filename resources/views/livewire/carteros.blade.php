<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div>
                                    <div>
                                        <h5 id="card_title">
                                            {{ __('Entregas de Paquetes en Carteros') }}
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <input wire:model.lazy="search" type="text" class="form-control"
                                                    placeholder="Buscar...">
                                            </div>
                                        </div>
                                    </div>
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            <p>{{ $message }}</p>
                                        </div>
                                    @elseif ($message = Session::get('error'))
                                        <div class="alert alert-danger">
                                            <p>{{ $message }}</p>
                                        </div>
                                    @endif

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead class="thead">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Código Rastreo</th>
                                                        <th>Destinatario</th>
                                                        <th>Teléfono</th>
                                                        <th>Peso</th>
                                                        <th>Tipo</th>
                                                        <th>Estado</th>

                                                        <th>Fecha Ingreso</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1; // Inicializa la variable $i
                                                    @endphp
                                                    @foreach ($packages as $package)
                                                        @if ($package->ESTADO === 'CARTERO')
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td>{{ $package->CODIGO }}</td>
                                                                <td>{{ $package->DESTINATARIO }}</td>
                                                                <td>{{ $package->TELEFONO }}</td>
                                                                <td>{{ $package->PESO }} gr.</td>
                                                                <td>{{ $package->TIPO }}</td>
                                                                <td>{{ $package->ESTADO }}</td>
                                                                <td>{{ $package->created_at }}</td>
                                                                <td>
                                                                    <button
                                                                        wire:click="openModal('{{ $package->CODIGO }}')"
                                                                        class="btn btn-warning btn-sm">
                                                                        <i class="fas fa-edit"></i> Dar de Baja
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                {{ $packages->links() }}
                                            </div>
                                            <div class="col-md-6 text-right">
                                                Se encontraron {{ $packages->total() }} registros en total
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="bajaModal" tabindex="-1" role="dialog" aria-labelledby="bajaModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bajaModalLabel">Dar de Baja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado" wire:model="estado" onchange="updateObservations()">
                            <option value="" selected>Seleccione un estado</option>
                            <option value="REPARTIDO">REPARTIDO</option>
                            <option value="RETORNO">RETORNO</option>
                            <option value="PRE-REZAGO">PRE-REZAGO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <input type="text" class="form-control mb-2" name="firma" wire:model="firma" id="inputbase64" readonly>
                        </div>
                        <div id="message" class="alert alert-warning text-center d-none">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-4x fa-exclamation-triangle text-warning"></i>
                                <span class="mt-2">Por favor ponga en modo horizontal la pantalla de su teléfono si
                                    desea
                                    firmar</span>
                            </div>
                        </div>

                        <div id="generatingMessage" class="d-none text-center">
                            <div class="alert alert-info">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-4x fa-spinner fa-spin text-primary"></i>
                                    <span class="mt-2">Generando código de la imagen...</span>
                                </div>
                            </div>
                        </div>

                        <div id="generatedMessage" class="d-none text-center">
                            <div class="alert alert-success">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-4x fa-check-circle text-success"></i>
                                    <span class="mt-2">El código de la imagen se generó correctamente.</span>
                                </div>
                            </div>
                        </div>

                        <div id="div1" class="mb-3 text-center">
                            <canvas id="canvas" class="border border-secondary rounded bg-white" width="600"
                                height="250"></canvas>
                            <div class="mt-3 div-button">
                                <button type="button" id="guardar" class="btn btn-primary me-2"><i
                                        class="fas fa-save"></i></button>
                                <button type="button" id="limpiar" class="btn btn-secondary"><i
                                        class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <select class="form-control" id="observaciones" wire:model="observaciones">
                            <!-- Opciones iniciales -->
                            <option value="" selected>Seleccione una observación</option>
                            <option value="Direccion incorrecta">Direccion incorrecta</option>
                            <option value="No se localizó el destinatario">No se localizó el destinatario</option>
                            <option value="El destinatario no esta direccion">El destinatario no está en la dirección
                            </option>
                            <option value="El remitente solicitó entrega posterior">El remitente solicitó entrega
                                posterior</option>
                            <option value="Direccion inaccesible">Dirección inaccesible</option>
                            <option value="Entrega Perdida">Entrega perdida</option>
                            <option value="Artículo Perdido">Artículo perdido</option>
                            <option value="Articulo Incorrecto">Artículo incorrecto</option>
                            <option value="Articulo Dañado">Artículo dañado</option>
                            <option value="Articulo Prohibido">Artículo prohibido</option>
                            <option value="Importacion Restringida">Importación restringida</option>
                            <option value="No Reclamado">No reclamado</option>
                            <option value="Por Fuerza Mayor, Articulo no entregado">Por fuerza mayor, artículo no
                                entregado</option>
                            <option value="Destinatario Solicita recojo en Agencia">Destinatario solicita recojo en
                                agencia</option>
                            <option value="Destinatario en Vacaciones">Destinatario en vacaciones</option>
                            <option value="Destinatario en Traslado">Destinatario en traslado</option>
                            <option value="Otros">Otros</option>
                            <option value="Articulo rechazado por el destinatario">Artículo rechazado por el
                                destinatario</option>
                            <option value="Fallecido">Fallecido</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="saveChanges">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('show-modal', event => {
                $('#bajaModal').modal('show');
            });

            window.addEventListener('close-modal', event => {
                $('#bajaModal').modal('hide');
            });
        });
    </script>
    <script>
        function updateObservations() {
            const estado = document.getElementById('estado').value;
            const observaciones = document.getElementById('observaciones');

            // Limpiar las opciones actuales
            observaciones.innerHTML = '';

            if (estado === 'RETORNO') {
                observaciones.innerHTML = `
                    <option value="" selected>Seleccione una observación</option>
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
                `;
            } else if (estado === 'REPARTIDO') {
                observacionesGroup.style.display = 'none'; // Ocultar las observaciones
            } else {
                observacionesGroup.style.display = 'block'; // Mostrar las observaciones
                observaciones.innerHTML = '<option value="" selected>Seleccione una observación</option>';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@5.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('canvas');
            const signaturePad = new SignaturePad(canvas);
            const generateButton = document.getElementById('guardar');
            const clearButton = document.getElementById('limpiar');
            const base64Input = document.getElementById('inputbase64');
            // const submitButton = document.getElementById('submitButton');
            const generatingMessage = document.getElementById('generatingMessage');
            const generatedMessage = document.getElementById('generatedMessage');
            const message = document.getElementById('message');
            const div1 = document.getElementById('div1');
            // submitButton.disabled = true;

            function updateVisibility() {
                const mobileWidthThreshold = 768;
                const screenWidth = window.innerWidth;

                if (screenWidth <= mobileWidthThreshold) {
                    if (window.orientation === 0) {
                        message.classList.remove('d-none');
                        div1.classList.add('d-none');
                    } else {
                        message.classList.add('d-none');
                        div1.classList.remove('d-none');
                    }
                } else {
                    message.classList.add('d-none');
                    div1.classList.remove('d-none');
                }
            }

            updateVisibility();

            clearButton.addEventListener('click', function() {
                signaturePad.clear();
                base64Input.value = "";
                // submitButton.disabled = true;
                generatedMessage.classList.add('d-none');
            });

            generateButton.addEventListener('click', function() {
                generatingMessage.classList.remove('d-none');
                generatedMessage.classList.add('d-none');
                // submitButton.disabled = true;

                setTimeout(() => {
                    const firma = signaturePad.toDataURL();
                    base64Input.value = firma;
                    generatingMessage.classList.add('d-none');
                    generatedMessage.classList.remove('d-none');
                    // submitButton.disabled = false;
                    setTimeout(() => {
                        generatedMessage.classList.add('d-none');
                    }, 2000);
                }, 2000);
            });

            window.addEventListener('orientationchange', updateVisibility);
            window.addEventListener('resize', updateVisibility);
        });
    </script>
</div>
