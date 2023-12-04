<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro de Entregas</title>
    <style>
        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .first-table th,
        .first-table td {
            border: 1px solid #000;
            padding: 5px;
        }

        thead {
            background-color: #f2f2f2;
        }

        /* Estilos para la página en formato horizontal */
        /* @page {
            size: landscape;
        } */

        /* Estilos para la imagen y el título */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            line-height: 0.5;
        }

        .title {
            text-align: center;
        }

        .firma {
            text-align: center;
            margin-top: 20px;
            line-height: 0;
        }

        .date {
            line-height: 0.5;
        }

        .second-table {
            border: none;
            margin: 20px auto;
            /* Centra la segunda tabla en el medio */
            line-height: 1;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .second-table {
            border: none;
            margin: 20px auto;
            /* Centra la segunda tabla en el medio */
            line-height: 1;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .second-table th {
            background-color: white;
            /* Establece el fondo de los th a blanco */
            border: none;
            padding: 5px;
            text-align: center;
            /* Centra el texto en las celdas */
            line-height: 1;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .second-table td {
            border: none;
            padding: 5px;
            text-align: center;
            /* Centra el texto en las celdas */
            line-height: 1;
            /* Ajusta el line-height para quitar el interlineado */
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/images.png') }}" alt="" width="150" height="50">
        </div>
        <div class="title">
            <h3>Registro de entregas de Correspondencia a Domicilio</h3>
        </div><br>
    </div>
    <div class="date">
        <p>Nombre del Distribuidor: {{ auth()->user()->name }}</p>
        <p>Regional: {{ auth()->user()->Regional }}</p>
        <p>Fecha: {{ now()->format('Y-m-d H:i') }}</p>
    </div>
    <table class="first-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Código Rastreo</th>
                <th>Destinatario</th>
                <th>Dirección</th>
                <th>Tipo</th>
                <th>Firma/Sello Destinatario</th>
                <th>Cobro (Bs.)</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp <!-- Inicializa $i con 1 -->
            @foreach ($packages as $package)
                @if ($package->CUIDAD === auth()->user()->Regional)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $package->CODIGO }}</td>
                        <td>{{ $package->DESTINATARIO }}</td>
                        <td>{{ $package->ZONA }}</td>
                        <td>{{ $package->TIPO }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @php $i++; @endphp <!-- Incrementa $i en cada iteración -->
                @endif
            @endforeach
        </tbody>
    </table>
    <br>
    <table class="second-table">
        <thead>
            <tr>
                <th>__________________________</th>
                <th>__________________________</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                    <tr>
                        <td>
                            <p>SUPERVISOR/SALIDA<br>{{ auth()->user()->name }}</p>
                        </td>
                        <td>
                            <p>ENTREGADO POR<br>{{ $package->usercartero }}</p>
                        </td>
                    </tr>
                    @break <!-- Rompe el bucle después de la primera iteración -->
            @endforeach
        </tbody>
    </table>
</body>

</html>
