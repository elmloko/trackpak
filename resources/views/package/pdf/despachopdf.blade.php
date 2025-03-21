<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despacho</title>
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
        .first-table th,
        .first-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            line-height: 0.5;
        }
        /* .date {
            line-height: 0.5;
        } */
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
        .second-table {
            border: none;
            margin: 20px auto;
            /* Centra la segunda tabla en el medio */
            line-height: 0;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .second-table th {
            background-color: white;
            /* Establece el fondo de los th a blanco */
            border: none;
            padding: 5px;
            text-align: center;
            /* Centra el texto en las celdas */
            line-height: 0;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .second-table td {
            border: none;
            padding: 5px;
            text-align: center;
            /* Centra el texto en las celdas */
            line-height: 0;
            /* Ajusta el line-height para quitar el interlineado */
        }
        .cn {
        text-align: center;
        float: right; /* Alinear a la derecha */
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/images.png') }}" alt="Logo" width="150" height="50">
        </div>
        <div class="barcode-section" style="text-align: right; margin-top: -50px;">
            <!-- Código de barras -->
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($packages[0]->manifiesto ?? '0000', 'C128',1.25, 25) }}" alt="Código de barras" style="display: block; margin-bottom: 10px;">
            
            <!-- Manifiesto -->
            <p style="margin: 5px 0; font-size: 15px; font-weight: bold;">{{ $packages[0]->manifiesto ?? 'Manifiesto no disponible' }}</p>
            
            <!-- CN -->
            <p style="margin: 5px 0; font-size: 18px;">CN 33</p>
        </div>
        <div class="title">
            <h2>Manifiesto Área Clasificación</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th rowspan="2">Operadores</th>
                <th>Origen</th>
                <td colspan="5">{{ $ciudadOrigen }} - AGENCIA BOLIVIANA DE CORREOS</td>
            </tr>
            <tr>
                <th>Destino</th>
                <td colspan="5">{{ $ciudadDestino }} - AGENCIA BOLIVIANA DE CORREOS</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Origen AE</th>
                <th>Destino OE</th>
                <th>Categoria</th>
                <th>Sub-Clase</th>
                <th>Año</th>
                <th>Despacho No</th>
                <th>Fecha</th>
            </tr>
            <tr>
                <td>{{ $siglasOrigen }}</td>
                <td>{{ $siglasDestino }}</td>
                <td>A</td>
                <td>UN</td>
                <td>{{ $anioPaquete }}</td>
                <td></td>
                {{-- <td>{{ $bag->NRODESPACHO }} / {{ $bag->NROSACA }}-{{ $bag->ano_creacion }}</td> --}}
                <td>{{ now()->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <th colspan="2" rowspan="2">Nombre del Usuario:</th>
                <td colspan="5" rowspan="2">{{ auth()->user()->name }}</td>
            </tr>
            <tr>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="first-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Código Rastreo</th>
                <th>Destinatario</th>
                <th>Teléfono</th>
                <th>País</th>
                <th>Ventanilla</th>
                <th>Peso (gr.)</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Aduana</th>
                <th>Observaciones</th>
                <th>Fecha Ingreso</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp <!-- Inicializa $i con 1 -->
            @foreach ($packages  as $package)
                {{-- @if ($package->ESTADO === 'CLASIFICACION') --}}
                {{-- @if ($package->ESTADO === 'CLASIFICACION' && $package->CUIDAD === auth()->user()->Regional) --}}
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $package->CODIGO }}</td>
                    <td>{{ $package->DESTINATARIO }}</td>
                    <td>{{ $package->TELEFONO }}</td>
                    <td>{{ $package->PAIS }}</td>
                    <td>{{ $package->VENTANILLA }}</td>
                    <td>{{ $package->PESO }} gr.</td>
                    <td>{{ $package->TIPO }}</td>
                    <td>{{ $package->ESTADO }}</td>
                    <td>{{ $package->ADUANA }}</td>
                    <td>{{ $package->OBSERVACIONES }}</td>
                    <td>{{ $package->created_at }}</td>
                </tr>
                @php $i++; @endphp <!-- Incrementa $i en cada iteración -->
                {{-- @endif --}}
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
                <p>__________________________ </p>
                <p>ENTREGADO POR</p>
                <p>{{ auth()->user()->name }}</p>
            </td>
        </table>
    </div>
</body>
</html>
