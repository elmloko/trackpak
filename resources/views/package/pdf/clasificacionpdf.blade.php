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

        th, td {
            border: 1px solid #000;
            padding: 5px;
        }

        .first-table th,
        .first-table td {
            border: 1px solid #000;
            padding: 5px;
            line-height: 0.5;
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
            border: none;
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
            <h2>Manifiesto Área Clasificación</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <table>
        <tbody>
            @foreach ($packages as $package)
            <tr>
                <th style="border: none; text-align: left; font-weight: normal; line-height: 0.5;">
                    <p>Nombre del Usuario: {{ auth()->user()->name }}</p>
                </th>
                <th style="border: none; text-align: left; font-weight: normal; line-height: 0.5;">Regional: {{ auth()->user()->Regional }}</th>
            </tr>
            <tr>
                <td style="border: none; text-align: left; font-weight: normal; line-height: 0.5;">
                    <p>Fecha: {{ now()->format('Y-m-d H:i') }}</p>
                </td>
                <td style="border: none; text-align: left; font-weight: normal; line-height: 0.5;">

                </td>
            </tr>
            @break
    @endforeach
        </tbody>
    </table>
    <table class="first-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Código Rastreo</th>
                <th>Destinatario</th>
                <th>Casillero</th>
                <th>Teléfono</th>
                <th>País</th>
                <th>Ventanilla</th>
                <th>Peso (gr.)</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Aduana</th>
                <th>Fecha Ingreso</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp <!-- Inicializa $i con 1 -->
            @foreach ($packages as $package)
                @if ($package->ESTADO === 'DESPACHO')
                {{-- @if ($package->ESTADO === 'CLASIFICACION' && $package->CUIDAD === auth()->user()->Regional) --}}
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $package->CODIGO }}</td>
                    <td>{{ $package->DESTINATARIO }}</td>
                    <td>{{ $package->nrocasilla }}</td>
                    <td>{{ $package->TELEFONO }}</td>
                    <td>{{ $package->PAIS }}</td>
                    <td>{{ $package->VENTANILLA }}</td>
                    <td>{{ $package->PESO }} gr.</td>
                    <td>{{ $package->TIPO }}</td>
                    <td>{{ $package->ESTADO }}</td>
                    <td>{{ $package->ADUANA }}</td>
                    <td>{{ $package->datedespachoclasificacion }}</td>
                </tr>
                @php $i++; @endphp <!-- Incrementa $i en cada iteración -->
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
