<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CN 22</title>
    <style>
        body {
            margin: 20px; /* Agrega margen al body */
        }

        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            /* text-align: center; */
            padding: 3px;
        }

        thead {
            background-color: #f2f2f2;
        }

        /* Estilos para la imagen y el título */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            line-height: 0.5;
        }

        .rotated-table-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: auto;
        }

        .rotated-table {
            transform: rotate(90deg);
            display: flex;
            align-items: flex-start;
            margin-top: 50px;
            margin-left: 50px;
        }
    </style>
</head>

<body>
    <div class="rotated-table-wrapper">
        <div class="rotated-table">
            <table style="undefined;table-layout: fixed; width: 400px">
                <colgroup>
                    <col style="width: 100px">
                    <col style="width: 100px">
                    <col style="width: 100px">
                    <col style="width: 100px">
                </colgroup>
                <thead>
                    <tr>
                        <th colspan="3" rowspan="4">{!! DNS1D::getBarcodeHTML($national->CODIGO, 'C128', 1.25, 50) !!}<br></p>{{ $national->CODIGO }}</th>
                        <th>RETORNAR A:</th>
                    </tr>
                    <tr>
                        <th rowspan="3"></th>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="3"><img src="{{ public_path('images/images.png') }}" alt=""
                                width="80" height="30"></td>
                        <td colspan="2">DECLARACION ADUANERA</td>
                        <td rowspan="3">A1-NACIONAL</td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="2"></td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td>DESDE:</td>
                        <td colspan="3">DESTINATARIO</td>
                    </tr>
                    <tr>
                        <td>AGENCIA BOLIVIANA DE CORREOS - LA PAZ</td>
                        <td colspan="3">{{ $national->NOMBRESREMITENTE }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3">DIRECCION:</td>
                    </tr>
                    <tr>
                        <td>PESO:{{ $national->PESO }}</td>
                        <td colspan="3">{{ $national->DIRECCION }}</td>
                    </tr>
                    <tr>
                        <td>DESTINO: {{ $national->DESTINO }}</td>
                        <td colspan="3">TELEFONO:</td>
                    </tr>
                    <tr>
                        <td>SERVICIO:{{ $national->TIPOSERVICIO }}</td>
                        <td colspan="3">{{ $national->TELEFONOREMITENTE }}</td>
                    </tr>
                    <tr>
                        <td>CONTENIDO</td>
                        <td>CANTIDAD</td>
                        <td>VALOR</td>
                        <td>FECHA ENVIO</td>
                    </tr>
                    <tr>
                        <td rowspan="2"></td>
                        <td rowspan="2">{{ $national->CANTIDAD }}</td>
                        <td rowspan="2">{{ $national->IMPORTE }}</td>
                        <td rowspan="2">{{ $national->created_at }}</td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td rowspan="3">BO | 
                            <?php echo substr($national->CODIGO, 0, 2); ?>
                        </td>
                        <td colspan="3" rowspan="5">El destinatario firmante, cuyo nombre y dirección figuran en
                            el envío,
                            certifica que los datos indicados en la declaración son correctos y que este envío no
                            contiene
                            ningún artículo peligroso prohibido por la legislación o las normas aduaneras.</td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td rowspan="2">AGBC</td>
                    </tr>
                    <tr>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
