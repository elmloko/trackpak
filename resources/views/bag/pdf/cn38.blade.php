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
                    <td>1 ORDINARIO</td>
                    <td>{{ $bag->PESOF }}</td>
                    <td>{{ $bag->OBSERVACIONES }}</td>
                </tr>
                @php $i++; @endphp <!-- Incrementa $i en cada iteración -->
            @endforeach
            @foreach ($bags as $bag)
                @php
                    $nrosaca_number = (int) $bag->NROSACA + 1;
                    $pesom_shown = false; // Variable para controlar si $bag->PESOM ya ha sido mostrado
                    $pesor_shown = false; // Variable para controlar si $bag->PESOR ya ha sido mostrado
                @endphp

                @for ($j = 0; $j < $bag->SACAR; $j++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $bag->NRODESPACHO }} / {{ str_pad($nrosaca_number, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $bag->OFCAMBIO }}</td>
                        <td>{{ $bag->OFDESTINO }}</td>
                        <td>1 CERTFICADO</td>
                        <td>{{ $pesor_shown ? '' : $bag->PESOR }}</td>
                        <!-- Solo mostrar si $bag->PESOR no ha sido mostrado antes -->
                        <td>{{ $bag->OBSERVACIONES }}</td>
                    </tr>
                    @php
                        if (!$pesor_shown) {
                            $pesor_shown = true; // Marcar $bag->PESOR como mostrado
                        }
                        if (!$pesom_shown) {
                            $pesom_shown = false; // Marcar $bag->PESOM como mostrado
                        }
                        $nrosaca_number++;
                        $i++;
                    @endphp
                @endfor

                @php
                    $nrosaca_number = (int) $bag->NROSACA;
                @endphp

                @for ($k = 0; $k < $bag->SACAM; $k++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $bag->NRODESPACHO }} / {{ str_pad($nrosaca_number, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $bag->OFCAMBIO }}</td>
                        <td>{{ $bag->OFDESTINO }}</td>
                        <td>1 SACA M</td>
                        <td>{{ $pesom_shown ? '' : $bag->PESOM }}</td>
                        <!-- Solo mostrar si $bag->PESOM no ha sido mostrado antes -->
                        <td>{{ $bag->OBSERVACIONES }}</td>
                    </tr>
                    @php
                        if (!$pesor_shown) {
                            $pesor_shown = true; // Marcar $bag->PESOR como mostrado
                        }
                        if (!$pesom_shown) {
                            $pesom_shown = true; // Marcar $bag->PESOM como mostrado
                        }
                        $nrosaca_number++;
                        $i++;
                    @endphp
                @endfor
            @endforeach
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <td>SACAS TOTAL</td>
                <th>{{ $sum->sum_totalsaca }}</th>
                <td>PESO TOTAL</td>
                <th>{{ $sum->sum_totalpeso }}</th>
                <td>PAQUETES TOTAL</td>
                <th>{{ $sum->sum_totalpaquetes }}</th>
            </tr>
        </thead>
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
