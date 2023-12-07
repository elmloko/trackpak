<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 id="card_title">{{ __('Registro de Paquetes Ordinarios') }}</h5>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search">Busca:</label>
                                    <input wire:model.lazy="search" type="text" class="form-control"
                                        placeholder="Buscar...">
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                @hasrole('SuperAdmin|Administrador|Cartero')
                                    <button wire:click="cambiarEstado" class="btn btn-warning">Almacenar</button>
                                @endhasrole
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="table-responsive">
                            @if ($packages->count())
                                <table class="table table-striped table-hover">
                                    <thead class="thead">
                                        <tr>
                                            <th><input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll"></th>
                                            <th>No</th>
                                            <th>Código Rastreo</th>
                                            <th>Destinatario</th>
                                            <th>Teléfono</th>
                                            <th>País</th>
                                            <th>Ciudad</th>
                                            <th>Ventanilla</th>
                                            <th>Peso (gr.)</th>
                                            <th>Tipo</th>
                                            <th>Estado</th>
                                            <th>Observaciones</th>
                                            <th>Aduana</th>
                                            <th>Fecha Ingreso</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($packages as $package)
                                            @if ($package->ESTADO === 'PRE-RESAGO')
                                            <tr wire:click="toggleSelectSingle('{{ $package->id }}')" style="cursor: pointer;"
                                                class="{{ in_array($package->id, $paquetesSeleccionados) ? 'table-info' : '' }}">
                                                <td><input type="checkbox" wire:model="paquetesSeleccionados"
                                                        value="{{ $package->id }}"></td>
                                                    <td>{{ $package->estadoclasificacion }}</td>
                                                    <td>{{ $package->id }}</td>
                                                    <td>{{ $package->CODIGO }}</td>
                                                    <td>{{ $package->DESTINATARIO }}</td>
                                                    <td>{{ $package->TELEFONO }}</td>
                                                    <td>{{ $package->PAIS }} - {{ $package->ISO }}
                                                    </td>
                                                    <td>{{ $package->CUIDAD }}</td>
                                                    <td>{{ $package->VENTANILLA }}</td>
                                                    <td>{{ $package->PESO }}</td>
                                                    <td>{{ $package->TIPO }}</td>
                                                    <td>{{ $package->ESTADO }}</td>
                                                    <td>{{ $package->OBSERVACIONES }}</td>
                                                    <td>{{ $package->ADUANA }}</td>
                                                    <td>{{ $package->created_at }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        {{ $packages->links() }}
                                    </div>
                                    <div class="col-md-6 text-right">
                                        Se encontraron {{ $packages->total() }} registros en total
                                    </div>
                                </div>
                            @else
                                <p>No se encontraron resultados para la búsqueda.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para actualizar las opciones de ventanilla
        function actualizarVentanillas(ciudadSelect, ventanillaSelect, ventanillasPorCiudad) {
            const ciudadSeleccionada = ciudadSelect.value;
            const opcionesVentanilla = ventanillasPorCiudad[ciudadSeleccionada] || [];

            // Borra las opciones existentes
            ventanillaSelect.innerHTML = '';

            // Agrega las nuevas opciones
            opcionesVentanilla.forEach(opcion => {
                const optionElement = document.createElement('option');
                optionElement.value = opcion;
                optionElement.text = opcion;
                ventanillaSelect.appendChild(optionElement);
            });
        }

        // Obtiene referencias a los elementos de ciudad y ventanilla para el formulario de Excel
        const ciudadSelectExcel = document.querySelector('form[name="excelForm"] select[name="ciudad"]');
        const ventanillaSelectExcel = document.querySelector('form[name="excelForm"] select[name="ventanilla"]');

        // Define las opciones de ventanilla por ciudad para el formulario de Excel
        const ventanillasPorCiudadExcel = {
            'LA PAZ': ['DND', 'DD', 'CASILLAS', 'ECA'],
            'COCHABAMBA': ['UNICA'],
            // Agrega más opciones según tus necesidades
        };

        // Escucha el cambio en la selección de la ciudad para el formulario de Excel
        ciudadSelectExcel.addEventListener('change', function() {
            actualizarVentanillas(ciudadSelectExcel, ventanillaSelectExcel, ventanillasPorCiudadExcel);
        });

        // Inicializa las opciones de ventanilla para el formulario de Excel
        actualizarVentanillas(ciudadSelectExcel, ventanillaSelectExcel, ventanillasPorCiudadExcel);

        // Obtiene referencias a los elementos de ciudad y ventanilla para el formulario de PDF
        const ciudadSelectPDF = document.querySelector('form[name="pdfForm"] select[name="ciudad"]');
        const ventanillaSelectPDF = document.querySelector('form[name="pdfForm"] select[name="ventanilla"]');

        // Define las opciones de ventanilla por ciudad para el formulario de PDF
        const ventanillasPorCiudadPDF = {
            'LA PAZ': ['DND', 'DD', 'CASILLAS', 'ECA'],
            'COCHABAMBA': ['UNICA'],
            // Agrega más opciones según tus necesidades
        };

        // Escucha el cambio en la selección de la ciudad para el formulario de PDF
        ciudadSelectPDF.addEventListener('change', function() {
            actualizarVentanillas(ciudadSelectPDF, ventanillaSelectPDF, ventanillasPorCiudadPDF);
        });

        // Inicializa las opciones de ventanilla para el formulario de PDF
        actualizarVentanillas(ciudadSelectPDF, ventanillaSelectPDF, ventanillasPorCiudadPDF);
    });
</script>

