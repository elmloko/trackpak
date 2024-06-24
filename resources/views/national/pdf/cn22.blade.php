<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CN 22</title>
    <style>
        body {
            margin: 20px;
            /* Agrega margen al body */
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
            vertical-align: top;
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
    <table style="undefined;table-layout: fixed; width: 734px">
        <colgroup>
            <col style="width: 87px">
            <col style="width: 90px">
            <col style="width: 80px">
            <col style="width: 86px">
            <col style="width: 108px">
            <col style="width: 138px">
            <col style="width: 20px">
            <col style="width: 125px">
        </colgroup>
        <thead>
            <tr>
                <td colspan="3"><img src="{{ public_path('images/images.png') }}" alt="" width="150"
                        height="50"></td>
                <td colspan="3" rowspan="2">
                    <div style="text-align: center;">{!! DNS1D::getBarcodeHTML($national->CODIGO, 'C128', 1.25, 50) !!}<br>{{ $national->CODIGO }}</div>
                </td>
                <td rowspan="8"></td>
            </tr>
            <tr>
                <td>OF. ORIGEN: <br>
                    <div style="text-align: right;">{{ $national->ORIGEN }}</div>
                </td>
                <td>OF. DESTINO: <br>
                    <div style="text-align: right;">{{ $national->DESTINO }}</div>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" rowspan="2">
                    NOMBRE REMITENTE: <br>
                    <div style="text-align: right;">{{ $national->NOMBRESREMITENTE }}</div>
                </td>
                <td colspan="3" rowspan="2">NOMBRE DESTINATARIO: <br>
                    <div style="text-align: right;">{{ $national->NOMBRESDESTINATARIO }} </div>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="3" rowspan="2">DIRECCION Y TELEFONO:
                    <div style="text-align: right;"><br>{{ $national->TELEFONOREMITENTE }}</div>
                </td>
                <td colspan="3" rowspan="2">DIRECCION Y TELEFONO:<br>
                    <div style="text-align: right;">
                        {{ $national->DIRECCION }}<br>{{ $national->TELEFONOREMITENTE }}</div>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="3">DESCRIPCIÓN:</td>
                <td rowspan="2" style="vertical-align: top;">FIRMA AGBC:<br></td>
                <td rowspan="2" style="vertical-align: top;">FIRMA REMITENTE:<br></td>
                <td rowspan="2" style="vertical-align: top;">FIRMA DESTINATARIO:<br></td>
            </tr>
            <tr>
                <td>IMPORTE: <br>
                    <div style="text-align: right;">{{ $national->IMPORTE }}</div>
                </td>
                <td>PESO:<br>
                    <div style="text-align: right;">{{ $national->PESO }}</div>
                </td>
                <td>FECHA:<br>
                    <div style="text-align: right;">{{ $national->created_at }}</div>
                </td>
            </tr>
        </thead>
    </table>
    <table style="undefined;table-layout: fixed; width: 734px">
        <colgroup>
            <col style="width: 87px">
            <col style="width: 90px">
            <col style="width: 80px">
            <col style="width: 86px">
            <col style="width: 108px">
            <col style="width: 138px">
            <col style="width: 20px">
            <col style="width: 125px">
        </colgroup>
        <thead>
            <tr>
                <td colspan="3"><img src="{{ public_path('images/images.png') }}" alt="" width="150"
                        height="50"></td>
                <td colspan="3" rowspan="2">
                    <div style="text-align: center;">{!! DNS1D::getBarcodeHTML($national->CODIGO, 'C128', 1.25, 50) !!}<br>{{ $national->CODIGO }}</div>
                </td>
                <td rowspan="8"></td>
            </tr>
            <tr>
                <td>OF. ORIGEN: <br>
                    <div style="text-align: right;">{{ $national->ORIGEN }}</div>
                </td>
                <td>OF. DESTINO: <br>
                    <div style="text-align: right;">{{ $national->DESTINO }}</div>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" rowspan="2">
                    NOMBRE REMITENTE: <br>
                    <div style="text-align: right;">{{ $national->NOMBRESREMITENTE }}</div>
                </td>
                <td colspan="3" rowspan="2">NOMBRE DESTINATARIO: <br>
                    <div style="text-align: right;">{{ $national->NOMBRESDESTINATARIO }} </div>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="3" rowspan="2">DIRECCION Y TELEFONO:
                    <div style="text-align: right;"><br>{{ $national->TELEFONOREMITENTE }}</div>
                </td>
                <td colspan="3" rowspan="2">DIRECCION Y TELEFONO:<br>
                    <div style="text-align: right;">
                        {{ $national->DIRECCION }}<br>{{ $national->TELEFONOREMITENTE }}</div>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="3">DESCRIPCIÓN:</td>
                <td rowspan="2" style="vertical-align: top;">FIRMA AGBC:<br></td>
                <td rowspan="2" style="vertical-align: top;">FIRMA REMITENTE:<br></td>
                <td rowspan="2" style="vertical-align: top;">FIRMA DESTINATARIO:<br></td>
            </tr>
            <tr>
                <td>IMPORTE: <br>
                    <div style="text-align: right;">{{ $national->IMPORTE }}</div>
                </td>
                <td>PESO:<br>
                    <div style="text-align: right;">{{ $national->PESO }}</div>
                </td>
                <td>FECHA:<br>
                    <div style="text-align: right;">{{ $national->created_at }}</div>
                </td>
            </tr>
        </thead>
    </table>
    <table style="undefined;table-layout: fixed; width: 734px">
        <colgroup>
            <col style="width: 87px">
            <col style="width: 90px">
            <col style="width: 80px">
            <col style="width: 86px">
            <col style="width: 108px">
            <col style="width: 138px">
            <col style="width: 20px">
            <col style="width: 125px">
        </colgroup>
        <thead>
            <tr>
                <td colspan="3"><img src="{{ public_path('images/images.png') }}" alt="" width="150"
                        height="50"></td>
                <td colspan="3" rowspan="2">
                    <div style="text-align: center;">{!! DNS1D::getBarcodeHTML($national->CODIGO, 'C128', 1.25, 50) !!}<br>{{ $national->CODIGO }}</div>
                </td>
                <td rowspan="8"></td>
            </tr>
            <tr>
                <td>OF. ORIGEN: <br>
                    <div style="text-align: right;">{{ $national->ORIGEN }}</div>
                </td>
                <td>OF. DESTINO: <br>
                    <div style="text-align: right;">{{ $national->DESTINO }}</div>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" rowspan="2">
                    NOMBRE REMITENTE: <br>
                    <div style="text-align: right;">{{ $national->NOMBRESREMITENTE }}</div>
                </td>
                <td colspan="3" rowspan="2">NOMBRE DESTINATARIO: <br>
                    <div style="text-align: right;">{{ $national->NOMBRESDESTINATARIO }} </div>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="3" rowspan="2">DIRECCION Y TELEFONO:
                    <div style="text-align: right;"><br>{{ $national->TELEFONOREMITENTE }}</div>
                </td>
                <td colspan="3" rowspan="2">DIRECCION Y TELEFONO:<br>
                    <div style="text-align: right;">
                        {{ $national->DIRECCION }}<br>{{ $national->TELEFONOREMITENTE }}</div>
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td colspan="3">DESCRIPCIÓN:</td>
                <td rowspan="2" style="vertical-align: top;">FIRMA AGBC:<br></td>
                <td rowspan="2" style="vertical-align: top;">FIRMA REMITENTE:<br></td>
                <td rowspan="2" style="vertical-align: top;">FIRMA DESTINATARIO:<br></td>
            </tr>
            <tr>
                <td>IMPORTE: <br>
                    <div style="text-align: right;">{{ $national->IMPORTE }}</div>
                </td>
                <td>PESO:<br>
                    <div style="text-align: right;">{{ $national->PESO }}</div>
                </td>
                <td>FECHA:<br>
                    <div style="text-align: right;">{{ $national->created_at }}</div>
                </td>
            </tr>
        </thead>
    </table>
</body>

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
                        <th colspan="3" rowspan="4">{!! DNS1D::getBarcodeHTML($national->CODIGO, 'C128', 1.25, 50) !!}<br>{{ $national->CODIGO }}</th>
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
