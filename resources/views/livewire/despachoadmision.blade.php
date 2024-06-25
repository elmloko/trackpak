<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 id="card_title">{{ __('Despacho de Paquetes Ordinarios') }}</h5>
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="search">Busca:</label>
                                        <input wire:model.lazy="search" type="text" class="form-control"
                                            placeholder="Buscar...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <form method="get" action="{{ route('despachoadmision.excel') }}" class="mb-3">
                                        @csrf
                                        <div class="form-row align-items-center">
                                            <div class="col-md-4">
                                                <label for="excel_fecha_inicio">Fecha de inicio:</label>
                                                <input type="date" name="fecha_inicio" class="form-control" required>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="excel_fecha_fin">Fecha de fin:</label>
                                                <input type="date" name="fecha_fin" class="form-control" required>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-success">Generar Excel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
                        @if ($nationals->count())
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>Codigo de Rastreo</th>
                                        {{-- <th>Nombres del Remitente</th>
                                        <th>Telefono de Remitente</th>
                                        <th>CI del Remitente</th> --}}
                                        <th>Nombres del Destinatario</th>
                                        <th>Telefono del Destinatario</th>
                                        <th>CI del Destinatario</th>
                                        <th>Direccion del Destinatario</th>
                                        <th>Cantidad</th>
                                        <th>Tipo Servicio</th>
                                        <th>Tipo Correspondencia</th>
                                        <th>Localidad</th>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Peso (Kg.)</th>
                                        <th>Importe (Bs.)</th>
                                        <th>N° Factura</th>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nationals as $national)
                                        @if ($national->ESTADO === 'DESPACHO')
                                            <tr>
                                                <td>{{ $national->CODIGO }}</td>
                                                {{-- <td>{{ $national->NOMBRESREMITENTE }}</td>
                                                <td>{{ $national->TELEFONOREMITENTE }}</td>
                                                <td>{{ $national->CIREMITENTE }}</td> --}}
                                                <td>{{ $national->NOMBRESDESTINATARIO }}</td>
                                                <td>{{ $national->TELEFONODESTINATARIO }}</td>
                                                <td>{{ $national->CIDESTINATARIO }}</td>
                                                <td>{{ $national->DIRECCION }}</td>
                                                <td>{{ $national->CANTIDAD }}</td>
                                                <td>{{ $national->TIPOSERVICIO }}</td>
                                                <td>{{ $national->TIPOCORRESPONDENCIA }}</td>
                                                <td>{{ $national->PROVINCIA }}</td>
                                                <td>{{ $national->ORIGEN }}</td>
                                                <td>{{ $national->DESTINO }}</td>
                                                <td>{{ $national->PESO }}</td>
                                                <td>{{ $national->IMPORTE }}</td>
                                                <td>{{ $national->FACTURA }}</td>
                                                <td>{{ $national->USER }}</td>
                                                <td>{{ $national->ESTADO }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    {{ $nationals->links() }}
                                </div>
                                <div class="col-md-6 text-right">
                                    Se encontraron {{ $nationals->total() }} registros en total
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
        const ventanillaSelectExcel = document.querySelector(
            'form[name="excelForm"] select[name="ventanilla"]');

        // Define las opciones de ventanilla por ciudad para el formulario de Excel
        const ventanillasPorCiudadExcel = {
            'LA PAZ': ['DND', 'DD', 'CASILLAS', 'ECA'],
            'COCHABAMBA': ['UNICA'],
            'SANTA CRUZ': ['UNICA'],
            'ORURO': ['UNICA'],
            'SUCRE': ['UNICA'],
            'POTOSI': ['UNICA'],
            'BENI': ['UNICA'],
            'PANDO': ['UNICA'],
            'TARIJA': ['UNICA'],
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
            'SANTA CRUZ': ['UNICA'],
            'ORURO': ['UNICA'],
            'SUCRE': ['UNICA'],
            'POTOSI': ['UNICA'],
            'BENI': ['UNICA'],
            'PANDO': ['UNICA'],
            'TARIJA': ['UNICA'],
        };

        // Escucha el cambio en la selección de la ciudad para el formulario de PDF
        ciudadSelectPDF.addEventListener('change', function() {
            actualizarVentanillas(ciudadSelectPDF, ventanillaSelectPDF, ventanillasPorCiudadPDF);
        });

        // Inicializa las opciones de ventanilla para el formulario de PDF
        actualizarVentanillas(ciudadSelectPDF, ventanillaSelectPDF, ventanillasPorCiudadPDF);
    });
</script>
