<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificacion</title>
    <style>
        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        thead {
            background-color: #f2f2f2;
        }

        /* Estilos para la página en formato horizontal */
        @page {
            size: landscape;
        }

        /* Estilos para la imagen y el título */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .title {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            {{-- <img src="{{ asset('images/images.png') }}"> --}}
        </div>
        <div class="title">
            <h2>Lista Área Clasificación</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Código Postal</th>
                <th>Destinatario</th>
                <th>Telefono</th>
                <th>Pais</th>
                <th>Ciudad</th>
                <th>Zona</th>
                <th>Ventanilla</th>
                <th>Peso</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Aduana</th>
                <th>Fecha Baja</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp <!-- Inicializa $i con 1 -->
            @foreach ($packages as $package)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $package->CODIGO }}</td>
                    <td>{{ $package->DESTINATARIO }}</td>
                    <td>{{ $package->TELEFONO }}</td>
                    <td>{{ $package->PAIS }}</td>
                    <td>{{ $package->CIUDAD }}</td>
                    <td>{{ $package->ZONA }}</td>
                    <td>{{ $package->VENTANILLA }}</td>
                    <td>{{ $package->PESO }}</td>
                    <td>{{ $package->TIPO }}</td>
                    <td>{{ $package->ESTADO }}</td>
                    <td>{{ $package->ADUANA }}</td>
                    <td>{{ $package->deleted_at }}</td>
                </tr>
                @php $i++; @endphp <!-- Incrementa $i en cada iteración -->
            @endforeach
        </tbody>
    </table>
</body>

</html>