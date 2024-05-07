<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 id="card_title">{{ __('Despacho de Paquetes Ordinarios') }}</h5>
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="search">Busca:</label>
                                <input wire:model.lazy="search" type="text" class="form-control"
                                    placeholder="Buscar...">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <form method="get" action="{{ route('clasificacion.excel') }}" class="mb-3">
                                        @csrf
                                        <div class="form-row align-items-center">
                                            <div class="col-md-3">
                                                <label for="excel_fecha_inicio">Fecha de inicio:</label>
                                                <input type="date" name="fecha_inicio" class="form-control" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="excel_fecha_fin">Fecha de fin:</label>
                                                <input type="date" name="fecha_fin" class="form-control" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="ciudad">Ciudad:</label>
                                                <select name="ciudad" class="form-control" required>
                                                    <option value="LA PAZ">LA PAZ</option>
                                                    <option value="COCHABAMBA">COCHABAMBA</option>
                                                    <option value="SANTA CRUZ">SANTA CRUZ</option>
                                                    <option value="ORURO">ORURO</option>
                                                    <option value="POTOSI">POTOSI</option>
                                                    <option value="SUCRE">SUCRE</option>
                                                    <option value="BENI">BENI</option>
                                                    <option value="PANDO">PANDO</option>
                                                    <option value="TARIJA">TARIJA</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="ventanilla">Ventanilla:</label>
                                                <select name="ventanilla" class="form-control" required>
                                                    <option value="DND">DND</option>
                                                    <option value="DD">DD</option>
                                                    <option value="ECA">ECA</option>
                                                    <option value="CASILLAS">CASILLAS</option>
                                                    <option value="UNICA">UNICA</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 text-center mt-3">
                                                <button type="submit" class="btn btn-success">Generar Excel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form method="get" action="{{ route('package.pdf.clasificacionpdf') }}"
                                        name="pdfForm">
                                        @csrf
                                        <div class="form-row align-items-center">
                                            <div class="col-md-3">
                                                <label for="pdf_fecha_inicio">Fecha de inicio:</label>
                                                <input type="date" name="fecha_inicio" class="form-control" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="pdf_fecha_fin">Fecha de fin:</label>
                                                <input type="date" name="fecha_fin" class="form-control" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="ciudad">Ciudad:</label>
                                                <select name="ciudad" class="form-control" required>
                                                    <option value="LA PAZ">LA PAZ</option>
                                                    <option value="COCHABAMBA">COCHABAMBA</option>
                                                    <option value="SANTA CRUZ">SANTA CRUZ</option>
                                                    <option value="ORURO">ORURO</option>
                                                    <option value="POTOSI">POTOSI</option>
                                                    <option value="SUCRE">SUCRE</option>
                                                    <option value="BENI">BENI</option>
                                                    <option value="PANDO">PANDO</option>
                                                    <option value="TARIJA">TARIJA</option>
                                                    <!-- Agrega más opciones según tus necesidades -->
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="ventanilla">Ventanilla:</label>
                                                <select name="ventanilla" class="form-control" required>
                                                    <option value="DND">DND</option>
                                                    <option value="DD">DD</option>
                                                    <option value="ECA">ECA</option>
                                                    <option value="CASILLAS">CASILLAS</option>
                                                    <option value="UNICA">UNICA</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 text-center mt-3">
                                                <button type="submit" class="btn btn-danger">Generar PDF</button>
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
                        @if ($packages->count())
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
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
                                        <th>Fecha Despacho</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $package)
                                        @if ($package->ESTADO === 'DESPACHO')
                                            <tr>
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
                                                <td>{{ $package->datedespachoclasificacion }}</td>
                                                <td>
                                                    @hasrole('SuperAdmin|Administrador|Clasificacion')
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <a class="btn btn-sm btn-success"
                                                                    href="{{ route('packages.edit', $package->id) }}">
                                                                    <i class="fa fa-fw fa-edit"></i>
                                                                    {{ __('Editar') }}
                                                                </a>
                                                            </div>
                                                            {{-- <div class="col-md-6">
                                                                <form
                                                                    action="{{ route('packages.destroy', $package->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-fw fa-trash"></i>
                                                                        {{ __('Eliminar') }}
                                                                    </button>
                                                                </form>
                                                            </div> --}}
                                                        </div>
                                                    @endhasrole
                                                </td>
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
