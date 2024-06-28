<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despacho Admision</title>
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
            text-align: center;
            line-height: 1;
        }

        .date {
            line-height: 0.2;
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
            line-height: 0.2;
        }

        .title {
            text-align: center;
        }

        .second-table {
            border: none;
            margin: 20px auto;
            /* Centra la segunda tabla en el medio */
            line-height: 0.1;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .second-table th {
            background-color: white;
            /* Establece el fondo de los th a blanco */
            border: none;
            padding: 5px;
            text-align: center;
            /* Centra el texto en las celdas */
            line-height: 0.1;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .second-table td {
            border: none;
            padding: 5px;
            text-align: center;
            /* Centra el texto en las celdas */
            line-height: 0.1;
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
            <h2>Manifiesto Área Admision</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <table class="date">
        <tbody>
            @foreach ($nationals as $national)
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
                    <td>

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
            <th>Codigo de Rastreo</th>
            <th>Nombres del Destinatario</th>
            <th>Telefono del Destinatario</th>
            <th>CI del Destinatario</th>
            <th>Direccion del Destinatario</th>
            <th>Cantidad</th>
            <th>Tipo Servicio</th>
            <th>Tipo Correspondencia</th>
            <th>Localidad</th>
            <th>Peso (Kg.)</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>N° Factura</th>
            {{-- <th>Importe (Bs.)</th>
            <th>Usuario</th>
            <th>Estado</th> --}}
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp <!-- Inicializa $i con 1 -->
        @foreach ($nationals as $national)
            @if ($national->ESTADO === 'CLASIFICACION')
                {{-- @if ($package->ESTADO === 'CLASIFICACION' && $package->CUIDAD === auth()->user()->Regional) --}}
                <tr>
                    <td>{{ $i }}</td>
                    <td><p class="barcode">{!! DNS1D::getBarcodeHTML($national->CODIGO, 'C128', 1.25, 25) !!} <br></p>{{ $national->CODIGO }}</td>
                    <td>{{ $national->NOMBRESDESTINATARIO }}</td>
                    <td>{{ $national->TELEFONODESTINATARIO }}</td>
                    <td>{{ $national->CIDESTINATARIO }}</td>
                    <td>{{ $national->DIRECCION }}</td>
                    <td>{{ $national->CANTIDAD }}</td>
                    <td>{{ $national->TIPOSERVICIO }}</td>
                    <td>{{ $national->TIPOCORRESPONDENCIA }}</td>
                    <td>{{ $national->PROVINCIA }}</td>
                    <td>{{ $national->PESO }}</td>
                    <td>{{ $national->ORIGEN }}</td>
                    <td>{{ $national->DESTINO }}</td>
                    <td>{{ $national->FACTURA }}</td>
                    {{-- <td>{{ $national->IMPORTE }}</td>
                    <td>{{ $national->USER }}</td>
                    <td>{{ $national->ESTADO }}</td> --}}
                </tr>
                @php $i++; @endphp <!-- Incrementa $i en cada iteración -->
            @endif
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
