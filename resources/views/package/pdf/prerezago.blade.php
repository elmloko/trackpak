<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prerezago</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
        }

        thead {
            background-color: #f2f2f2;
        }

        @page {
            size: landscape;
        }

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
            <h2>Manifiesto Rezago</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <div class="date">
        <p>Nombre del Usuario: {{ auth()->user()->name }}</p>
        <p>Regional: {{ auth()->user()->Regional }}</p>
        <p>Fecha: {{ now()->format('Y-m-d H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Código Rastreo</th>
                <th>Destinatario</th>
                <th>Teléfono</th>
                <th>Ciudad</th>
                <th>Ventanilla</th>
                <th>Peso (gr.)</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($packages as $package)
                @if ($package->ESTADO === 'REZAGO')
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $package->CODIGO }}</td>
                        <td>{{ $package->DESTINATARIO }}</td>
                        <td>{{ $package->TELEFONO }}</td>
                        <td>{{ $package->CUIDAD }}</td>
                        <td>{{ $package->VENTANILLA }}</td>
                        <td>{{ $package->PESO }} gr.</td>
                        <td>{{ $package->ESTADO }}</td>
                        <td>{{ $package->OBSERVACIONES }}</td>
                    </tr>
                    @php $i++; @endphp
                @endif
            @endforeach
        </tbody>
    </table>
    <br>
    <div class="firma">
        <p>__________________________ </p>
        <p>ENTREGADO POR</p>
        <p>{{ auth()->user()->name }}</p>
    </div>
</body>
</html>
