<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card p-4">
                                    <div>
                                        <h5 id="card_title">
                                            {{ __('Registro de Paquetes Ordinarios') }}
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="search">Busca:</label>
                                                <input wire:model.lazy="search" type="text" class="form-control"
                                                    placeholder="Buscar...">
                                            </div>
                                        </div>
                                        <div class="col-lg-9 text-right">
                                            <div class="row">
                                                <!-- Formulario para generar Excel -->
                                                <form method="get" action="{{ route('clasificacion.excel') }}" class="col-md-5" name="excelForm">
                                                    @csrf
                                                    <div class="form-row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="excel_fecha_inicio">Fecha de inicio:</label>
                                                            <input type="date" name="fecha_inicio"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="excel_fecha_fin">Fecha de fin:</label>
                                                            <input type="date" name="fecha_fin" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="col-md-4">
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
                                                        <div class="col-md-4">
                                                            <label for="ventanilla">Ventanilla:</label>
                                                            <select name="ventanilla" class="form-control" required>
                                                                <option value="DND">DND</option>
                                                                <option value="DD">DD</option>
                                                                <option value="ECA">ECA</option>
                                                                <option value="CASILLAS">CASILLAS</option>
                                                                <option value="UNICA">UNICA</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4" style="display:flex; inset:0;">
                                                            <button type="submit" class="btn btn-success"
                                                                target="_blank">Generar Excel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- Formulario para generar PDF -->
                                                <form method="get" action="{{ route('package.pdf.clasificacionpdf') }}" class="col-md-5" name="pdfForm">
                                                    @csrf
                                                    <div class="form-row align-items-center">
                                                        <div class="col-md-4">
                                                            <label for="pdf_fecha_inicio">Fecha de inicio:</label>
                                                            <input type="date" name="fecha_inicio"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="pdf_fecha_fin">Fecha de fin:</label>
                                                            <input type="date" name="fecha_fin" class="form-control"
                                                                required>
                                                        </div>
                                                        <div class="col-md-4">
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
                                                        <div class="col-md-4">
                                                            <label for="ventanilla">Ventanilla:</label>
                                                            <select name="ventanilla" class="form-control" required>
                                                                <option value="DND">DND</option>
                                                                <option value="DD">DD</option>
                                                                <option value="ECA">ECA</option>
                                                                <option value="CASILLAS">CASILLAS</option>
                                                                <option value="UNICA">UNICA</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4" style="display:flex; inset:0;">
                                                            <button type="submit" class="btn btn-danger"
                                                                target="_blank">Generar PDF</button>
                                                        </div>
                                                    </div>
                                                </form>

                                                @hasrole('SuperAdmin|Administrador|Clasificacion|Auxiliar
                                                    Clasificacion')
                                                    <div class="col-md-2">
                                                        <a href="{{ route('packages.create') }}" class="btn btn-primary"
                                                            data-placement="left">
                                                            {{ __('Crear Nuevo') }}
                                                        </a>
                                                    </div>
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
                                            @php
                                                $i = 0; // Inicializa la variable $i
                                            @endphp
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
                                                            <th>Peso</th>
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
                                                            @if ($package->ESTADO === 'CLASIFICACION')
                                                                {{-- @if ($package->ESTADO === 'CLASIFICACION' && $package->CUIDAD === auth()->user()->Regional) --}}
                                                                <tr>
                                                                    <td>{{ $package->id }}</td>
                                                                    <td>{{ $package->CODIGO }}</td>
                                                                    <td>{{ $package->DESTINATARIO }}</td>
                                                                    <td>{{ $package->TELEFONO }}</td>
                                                                    <td>{{ $package->PAIS }} - {{ $package->ISO }}
                                                                    </td>
                                                                    <td>{{ $package->CUIDAD }}</td>
                                                                    <td>{{ $package->VENTANILLA }}</td>
                                                                    <td>{{ $package->PESO }} gr.</td>
                                                                    <td>{{ $package->TIPO }}</td>
                                                                    <td>{{ $package->ESTADO }}</td>
                                                                    <td>{{ $package->OBSERVACIONES }}</td>
                                                                    <td>{{ $package->ADUANA }}</td>
                                                                    <td>{{ $package->created_at }}</td>
                                                                    <td>
                                                                        @hasrole('SuperAdmin|Administrador|Clasificacion')
                                                                            <a class="btn btn-sm btn-success"
                                                                                href="{{ route('packages.edit', $package->id) }}">
                                                                                <i class="fa fa-fw fa-edit"></i>
                                                                                {{ __('Editar') }}
                                                                            </a>

                                                                            @php
                                                                                $currentDate = now(); // Obtener la fecha y hora actuales
                                                                                $creationDate = $package->created_at; // Obtener la fecha de creación del paquete

                                                                                // Verificar si la fecha de creación es igual a la fecha actual
                                                                                $deleteEnabled = $currentDate->isSameDay($creationDate);
                                                                            @endphp

                                                                            @if ($deleteEnabled)
                                                                                <form
                                                                                    action="{{ route('packages.destroy', $package->id) }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger btn-sm">
                                                                                        <i class="fa fa-fw fa-trash"></i>
                                                                                        {{ __('Eliminar') }}
                                                                                    </button>
                                                                                </form>
                                                                            @else
                                                                                <p class="btn btn-dark btn-sm">No
                                                                                    Disponible.</p>
                                                                            @endif
                                                                        @endhasrole
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
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
        'SANTA CRUZ': ['UNICA'],
        'PANDO': ['UNICA'],
        'BENI': ['UNICA'],
        'TARIJA': ['UNICA'],
        'SUCRE': ['UNICA'],
        'ORURO': ['UNICA'],
        'POTOSI': ['UNICA'],
        // Agrega más opciones según tus necesidades
    };

    // Escucha el cambio en la selección de la ciudad para el formulario de Excel
    ciudadSelectExcel.addEventListener('change', function () {
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
        'PANDO': ['UNICA'],
        'BENI': ['UNICA'],
        'TARIJA': ['UNICA'],
        'SUCRE': ['UNICA'],
        'ORURO': ['UNICA'],
        'POTOSI': ['UNICA'],
        // Agrega más opciones según tus necesidades
    };

    // Escucha el cambio en la selección de la ciudad para el formulario de PDF
    ciudadSelectPDF.addEventListener('change', function () {
        actualizarVentanillas(ciudadSelectPDF, ventanillaSelectPDF, ventanillasPorCiudadPDF);
    });

    // Inicializa las opciones de ventanilla para el formulario de PDF
    actualizarVentanillas(ciudadSelectPDF, ventanillaSelectPDF, ventanillasPorCiudadPDF);
});
</script>
