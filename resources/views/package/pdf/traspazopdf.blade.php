<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traspazo</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .first-table th, .first-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            line-height: 0.5;
        }
        .date {
            line-height: 0.5;
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
        .second-table {
            border: none;
            margin: 20px auto;
            line-height: 0;
        }
        .second-table th, .second-table td {
            border: none;
            padding: 5px;
            text-align: center;
            line-height: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/images.png') }}" alt="" width="150" height="50">
        </div>
        <div class="title">
            <h2>Manifiesto Traspazo de Ventanillas</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <table class="date">
        <tbody>
            <tr>
                <th style="text-align: left; font-weight: normal;">
                    <p>Nombre del Usuario: {{ auth()->user()->name }}</p>
                </th>
                <th style="text-align: left; font-weight: normal;">Regional: {{ auth()->user()->Regional }}</th>
            </tr>
            <tr>
                <td style="text-align: left; font-weight: normal;">
                    <p>Fecha: {{ now()->format('Y-m-d H:i') }}</p>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <table class="first-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Código Rastreo</th>
                <th>Destinatario</th>
                <th>Zonificación</th>
                <th>Vetanilla Asignada</th>
                <th>Peso (gr.)</th>
                <th>Tipo</th>
                <th>Fecha Ingreso</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($packages as $package)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $package->CODIGO }}</td>
                    <td>{{ $package->DESTINATARIO }}</td>
                    <td>{{ $package->ZONA }}</td>
                    <td>{{ $package->VENTANILLA }}</td>
                    <td>{{ $package->PESO }} gr.</td>
                    <td>{{ $package->TIPO }}</td>
                    <td>{{ $package->updated_at }}</td>
                </tr>
                @php $i++; @endphp
            @endforeach
        </tbody>
    </table>
    <br>
    <div>
        <table class="second-table">
            <td>
                <p>__________________________</p>
                <p>RECIBIDO POR</p>
            </td>
            <td>
                <p>__________________________</p>
                <p>ENTREGADO POR</p>
                <p>{{ auth()->user()->name }}</p>
            </td>
        </table>
    </div>
</body>
</html>
