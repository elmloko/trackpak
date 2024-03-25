<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CN-38</title>
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
            line-height: 0.5;
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

        .cn {
            text-align: center;
            float: right;
            /* Alinear a la derecha */
        }

        .special-text {
            text-align: center;
            font-size: 12px;
            border: none;
            font-weight: normal;
            line-height: 0.1;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/images.png') }}" alt="" width="150" height="50">
            <p class="cn">CN 38</p>
        </div>
        <div class="title">
            <h2>Factura de Entrega</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <table>
        <tbody>
            <tr>
                <th style="border: none; text-align: left; font-weight: normal; line-height: 0.1;">
                    @foreach ($bags->take(1) as $bag)
                        Oficina de Cambio:{{ $bag->OFCAMBIO }} - {{ $bag->OFCAM108 }} / Oficina de
                        Destino:{{ $bag->OFDESTINO }} - {{ $bag->OFDES108 }}
                    @endforeach
                </th>
                <th style="border: none; text-align: left; font-weight: normal; line-height: 0.1;">
                    @foreach ($bags->take(1) as $bag)
                        Medio de Trasporte:{{ $bag->ITINERARIO }} = {{ $bag->TRASPORTE }}
                    @endforeach
                </th>
            </tr>
            <tr>
                <td style="border: none; text-align: left; font-weight: normal; line-height: 0.1;">
                    <p>Fecha: {{ now()->format('Y-m-d H:i') }}</p>
                </td>
                <td style="border: none; text-align: left; font-weight: normal; line-height: 0.1;">
                    @foreach ($bags->take(1) as $bag)
                        Observaciones:{{ $bag->OBSERVACIONESG }}
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
    <table class="first-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Despacho</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Correspondencia</th>
                <th>Peso (Kg.)</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp <!-- Inicializa $i con 1 -->
            @foreach ($bags as $bag)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $bag->NRODESPACHO }} / {{ $bag->NROSACA }}{{ $bag->FIN == 'F' ? 'F' : '' }}</td>
                    <td>{{ $bag->OFCAMBIO }}</td>
                    <td>{{ $bag->OFDESTINO }}</td>
                    <td>1</td>
                    <td>{{ $bag->PESOF }}</td>
                    <td>{{ $bag->OBSERVACIONES }}</td>
                </tr>
                @php $i++; @endphp <!-- Incrementa $i en cada iteración -->
            @endforeach
        </tbody>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    DESPACHO TOTAL: {{ $sum->sum_paquetes }}
                </td>
                <td>
                    PESO TOTAL: {{ $sum->sum_pesoc }}
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <br>
    <table>
        <td style="border: none; text-align: left; font-weight: normal; line-height: 0.1;">
            <p class="special-text">__________________________</p>
            <p class="special-text">RECIBIDO POR</p>
            <p class="special-text">{{ $bag->TRASPORTE }}</p>
        </td>
        <td style="border: none; text-align: left; font-weight: normal; line-height: 0.1;">
            <p class="special-text">__________________________ </p>
            <p class="special-text">ENTREGADO POR</p>
            <p class="special-text">{{ auth()->user()->name }}</p>
        </td>
    </table>
</body>

</html>
