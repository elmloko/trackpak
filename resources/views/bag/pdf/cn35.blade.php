<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CN-35</title>
    <style>
        /* Estilos para la tabla */
        table {
            width: 64%;
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

        /* Hacer transparente el borde izquierdo y derecho de las celdas */
        .transparent-left-border {
            border-left-color: transparent !important;
        }

        .transparent-right-border {
            border-right-color: transparent !important;
        }
        .transparent-top-border {
            border-top-color: transparent !important;
        }

        .transparent-bottom-border {
            border-bottom-color: transparent !important;
        }
        /* Clase para centrar el texto */
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
  @foreach ($bags as $bag)
  <table border="1">
    <tr>
      <td colspan="2" class="transparent-bottom-border">PARA :</td>
      <td class="transparent-bottom-border text-center">TrackingBO LC/AO</td>
      <td class="transparent-bottom-border text-center">CN 35</td>
    </tr>
    <tr>
      <td colspan="2" class="text-center">{{ $bag->OFDESTINO }}</td>
      <td></td>
      <h1 class="text-center">{{ $bag->FIN == 'F' ? 'F' : '' }}</h1>
    </tr>
    <tr>
      <td>Desp:BUN</td>
      <td>DespNo:{{ $bag->NRODESPACHO }}</td>
      <td class="transparent-right-border text-right">{{ $bag->OFCAM108 }}(BOA)</td>
      <td>{{ $bag->OFCAMBIO }} LC/AO</td>
    </tr>
    <tr>
      <td colspan="2" class="text-center">{{ $bag->updated_at }}</td>
      <td colspan="2" class="transparent-bottom-border text-center">AGENCIA BOLIVIANA DE CORREOS</td>
    </tr>
    <tr>
      <td>SubC:AUN</td>
      <td>RecNo:{{ $bag->NROSACA }}</td>
      <td colspan="2" class="text-center">(AGBC)</td>
      
    </tr>
    <tr>
      <td>Peso:{{ $bag->PESOF }} Kg.</td>
      <td>NoItem:{{ $bag->PAQUETES }}</td>
      <td colspan="2" class="transparent-bottom-border text-center">{{ $bag->RECEPTACULO }}</td>
    </tr>
    <tr>
      <td>Via:{{ $bag->ITINERARIO }}</td>
      <td></td>
      <td colspan="2"><p>{!! DNS1D::getBarcodeHTML($bag->RECEPTACULO, 'C128', 1.08, 40) !!}</p></td>
    </tr>
  </table> 
  <br>
  @endforeach 
</body>
</html>
