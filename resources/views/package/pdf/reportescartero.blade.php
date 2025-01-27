<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Paquetes en Retorno</title>
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

        .resume-table {
            border: 1px solid #000;
            margin: 20px auto;
            width: 70%;
            /* Ancho de la tabla */
            text-align: center;
            /* Centra el contenido de la tabla */
        }

        .resume-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 10px;
            /* Tamaño de la fuente más pequeño */
            line-height: 0.5;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .resume-table th {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 12px;
            /* Tamaño de la fuente para los títulos */
            font-weight: bold;
            /* Texto en negrita para los títulos */
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/images.png') }}" alt="" width="150" height="50">
        </div>
        <div class="title">
            <h2>Lista Carteros Reportes</h2>
            <h4>AGENCIA BOLIVIANA DE CORREOS</h4>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Destinatario</th>
                <th>Teléfono</th>
                <th>Peso</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Cartero</th>
                <th>Fecha Actualización</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                <tr>
                    <td>{{ $package->CODIGO }}</td>
                    <td>{{ $package->DESTINATARIO }}</td>
                    <td>{{ $package->TELEFONO }}</td>
                    <td>{{ $package->PESO }}</td>
                    <td>{{ $package->TIPO }}</td>
                    <td>{{ $package->ESTADO }}</td>
                    <td>{{ $package->usercartero }}</td>
                    <td>{{ $package->updated_at }}</td>
                </tr>
            @endforeach
            @foreach ($internationals as $international)
                <tr>
                    <td>{{ $international->CODIGO }}</td>
                    <td>{{ $international->DESTINATARIO }}</td>
                    <td>{{ $international->TELEFONO }}</td>
                    <td>{{ $international->PESO }}</td>
                    <td>{{ $international->TIPO }}</td>
                    <td>{{ $international->ESTADO }}</td>
                    <td>{{ $international->usercartero }}</td>
                    <td>{{ $international->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="resume-table">
        <thead>
            <tr>
                <th></th>
                <th>CERTIFICADO</th>
                <th>ORDINARIO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>TOTAL ENTREGADOS</td>
                <td>{{ $totals['certificado']['entregados'] }}</td>
                <td>{{ $totals['ordinario']['entregados'] }}</td>
            </tr>
            <tr>
                <td>TOTAL NOTIFICADOS</td>
                <td>{{ $totals['certificado']['notificados'] }}</td>
                <td>{{ $totals['ordinario']['notificados'] }}</td>
            </tr>
            <tr>
                <td>TOTAL PENDIENTE</td>
                <td>{{ $totals['certificado']['pendiente'] }}</td>
                <td>{{ $totals['ordinario']['pendiente'] }}</td>
            </tr>
            <tr>
                <td>TOTAL REZAGO</td>
                <td>{{ $totals['certificado']['rezago'] }}</td>
                <td>{{ $totals['ordinario']['rezago'] }}</td>
            </tr>
            <tr>
                <td><b>TOTAL ENVIOS LLEVADOS</b></td>
                <td>{{ $totals['certificado']['total_envios'] }}</td>
                <td>{{ $totals['ordinario']['total_envios'] }}</td>
            </tr>
        </tbody>
    </table>
              
</body>

</html>
