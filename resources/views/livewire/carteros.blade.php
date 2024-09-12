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
                            <option value="REPARTIDO">ENTREGADO</option>
                            <option value="RETORNO">NOTIFICADO</option>
                            <option value="PRE-REZAGO">RECHAZADO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipoSeleccion">Seleccione una opción</label>
                        <select class="form-control" id="tipoSeleccion" onchange="toggleDivs()">
                            <option value="">Seleccione una opción</option>
                            <option value="foto">Foto</option>
                            <option value="firma">Firma</option>
                        </select>
                    </div>
                    <div id="divFirma" class="mb-3 text-center" style="display: none;">
                        <div class="mb-3 text-center">
                            <input type="text" class="form-control mb-2" name="firma" wire:model="firma"
                                id="inputbase64" readonly>
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
                    <div id="divFoto" class="mb-3 text-center" style="display: none;">
                        <div class="mb-3">
                            <input type="text" class="form-control mb-2" name="foto" wire:model="foto"
                                id="inputbase64foto" readonly>
                        </div>
                        <label class="border border-secondary rounded w-100 bg-light p-5">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-4x fa-image text-info"></i>
                                <p class="mt-2">Sacar Foto</p>
                            </div>
                            <input type="file" accept="image/*" id="capturephoto" wire:model="foto"
                                capture="camera" class="d-none">
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <select class="form-control" id="observaciones" wire:model="observaciones">
                            <option value="" selected>Seleccione una observación</option>
                            <option value="Destinatario Notificado en Puerta">Destinatario Notificado en Puerta</option>
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
        function toggleDivs() {
            const seleccion = document.getElementById('tipoSeleccion').value;
            const divFirma = document.getElementById('divFirma');
            const divFoto = document.getElementById('divFoto');

            if (seleccion === 'foto') {
                divFirma.style.display = 'none';
                divFoto.style.display = 'block';
            } else if (seleccion === 'firma') {
                divFoto.style.display = 'none';
                divFirma.style.display = 'block';
            } else {
                divFoto.style.display = 'none';
                divFirma.style.display = 'none';
            }
        }

        // Inicialmente ocultar ambos divs
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('divFirma').style.display = 'none';
            document.getElementById('divFoto').style.display = 'none';
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
                    <option value="Destinatario Notificado en Puerta">Destinatario Notificado en Puerta</option>
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
                observacionesGroup.style.display = 'none';
            } else if (estado === 'PRE-REZAGO') {
                observaciones.innerHTML =
                    observaciones.innerHTML = `
                    <option value="" selected>Seleccione una observación</option>
                    <option value="Articulo rechazado por el destinatario">Artículo rechazado por el destinatario</option>
                    <option value="Fallecido">Fallecido</option>
                `;
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
            const generatingMessage = document.getElementById('generatingMessage');
            const generatedMessage = document.getElementById('generatedMessage');
            const message = document.getElementById('message');
            const div1 = document.getElementById('div1');

            // Función para actualizar visibilidad dependiendo del tamaño de la pantalla
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

            // Limpiar la firma del canvas
            clearButton.addEventListener('click', function() {
                signaturePad.clear();
                base64Input.value = "";
                generatedMessage.classList.add('d-none');
            });

            // Guardar la firma en Base64 y enviarla a Livewire
            generateButton.addEventListener('click', function() {
                if (!signaturePad.isEmpty()) {
                    generatingMessage.classList.remove('d-none');
                    generatedMessage.classList.add('d-none');

                    setTimeout(() => {
                        const firma = signaturePad.toDataURL(); // Convertir la firma en Base64
                        base64Input.value = firma; // Asignar el valor en el input Base64
                        @this.set('firma', firma); // Enviar el valor de la firma a Livewire

                        generatingMessage.classList.add('d-none');
                        generatedMessage.classList.remove('d-none');

                        setTimeout(() => {
                            generatedMessage.classList.add('d-none');
                        }, 2000);
                    }, 2000);
                } else {
                    alert("Por favor, firme antes de guardar.");
                }
            });

            // Manejo de la orientación de la pantalla
            window.addEventListener('orientationchange', updateVisibility);
            window.addEventListener('resize', updateVisibility);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('capturephoto');
            const base64Inputfoto = document.getElementById(
            'inputbase64foto'); // Input para almacenar la imagen base64

            fileInput.addEventListener('change', function() {
                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = new Image();
                        img.onload = function() {
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');
                            canvas.width = img.width;
                            canvas.height = img.height;
                            ctx.drawImage(img, 0, 0);
                            const dataurl = canvas.toDataURL('image/jpeg',
                            0.5); // Generar imagen base64 comprimida

                            base64Inputfoto.value =
                            dataurl; // Asignar el valor base64 al input oculto
                            @this.set('foto',
                            dataurl); // Enviar el valor de la imagen en base64 a Livewire
                        }
                        img.src = e.target.result;
                    }
                    reader.readAsDataURL(fileInput.files[0]);
                }
            });
        });
    </script>
</div>
