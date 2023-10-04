<table class="table table-striped table-hover">
    <thead class="thead">
        <tr>
            <th>No</th>
            <th>Codigo Postal</th>
            <th>Destinatario</th>
            <th>Telefono</th>
            <th>Pais</th>
            <th>Cuidad</th>
            <th>Zona</th>
            <th>Ventanilla</th>
            <th>Peso</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Fecha Ingreso</th>

            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($packages as $package)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $package->CODIGO }}</td>
                <td>{{ $package->DESTINATARIO }}</td>
                <td>{{ $package->TELEFONO }}</td>
                <td>{{ $package->PAIS }}</td>
                <td>{{ $package->CUIDAD }}</td>
                <td>{{ $package->ZONA }}</td>
                <td>{{ $package->VENTANILLA }}</td>
                <td>{{ $package->PESO }}</td>
                <td>{{ $package->TIPO }}</td>
                <td>{{ $package->ESTADO }}</td>
                <td>{{ $package->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>