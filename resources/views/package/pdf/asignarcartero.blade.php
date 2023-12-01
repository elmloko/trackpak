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

        th,
        td {
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
    <table>
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
    <table>
        <thead>
            <tr>
                <th>__________________________</th>
                <th>__________________________</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><p>SUPERVISOR/SALIDA</p>
                    <p>{{ auth()->user()->name }}</p></td>
                <td><p>ENTREGADO POR</p>
                    <p>{{ auth()->user()->name }}</p></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
