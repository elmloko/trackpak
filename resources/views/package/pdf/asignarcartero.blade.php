<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro de Entregas</title>
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

        .date {
            line-height: 0.5;
        }

        .second-table {
            border: none;
            margin: 20px auto;
            /* Centra la segunda tabla en el medio */
            line-height: 0.5;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .second-table th {
            background-color: white;
            /* Establece el fondo de los th a blanco */
            border: none;
            padding: 5px;
            text-align: center;
            /* Centra el texto en las celdas */
            line-height: 1;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .second-table td {
            border: none;
            padding: 5px;
            text-align: center;
            /* Centra el texto en las celdas */
            line-height: 1;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .notification-table {
            border: 1px solid #000;
            margin: 20px auto;
            /* Centra la segunda tabla en el medio */
            line-height: 1;
            /* Ajusta el line-height para quitar el interlineado */
        }

        .notification-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            /* Centra el texto en las celdas */
            line-height: 1;
            /* Ajusta el line-height para quitar el interlineado */
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
            <h3>Registro de entregas de Correspondencia a Domicilio</h3>
        </div><br>
    </div>
    <table class="date">
        <tbody>
            @foreach ($packages as $package)
            <tr>
                <th>
                    <p>Nombre del Distribuidor: {{ $package->usercartero }}</p>
                </th>
                <th>Regional: {{ auth()->user()->Regional }}</th>
            </tr>
            <tr>
                <td>
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
                <th>Código Rastreo</th>
                <th>Destinatario</th>
                <th>Dirección</th>
                <th>Peso (Kg.)</th>
                <th>Fecha y Hora</th>
                <th>Razon</th>
                <th>Accion</th>
                <th>Firma/Sello Destinatario</th>
                <th>Cobro (Bs.)</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp <!-- Inicializa $i con 1 -->
            @foreach ($packages as $package)
                {{-- @if ($package->CUIDAD === auth()->user()->Regional) --}}
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            <p class="barcode">{!! DNS1D::getBarcodeHTML($package->CODIGO, 'C128', 1.25, 25) !!} <br></p>{{ $package->CODIGO }}
                        </td>
                        <td>{{ $package->DESTINATARIO }}</td>
                        <td>{{ $package->ZONA }}</td>
                        <td>{{ $package->PESO }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $package->PRECIO }}</td>
                    </tr>
                    @php $i++; @endphp <!-- Incrementa $i en cada iteración -->
                {{-- @endif --}}
            @endforeach
        </tbody>
    </table>
    <table class="notification-table">
        <thead>
            <tr>
                <td>Accion</td>
                <td><b>10.</b>Direccion incorrecta -
                    <b>11.</b>No se localizo el destinatario -
                    <b>12.</b>El destinatario no esta direccion -
                    <b>13.</b>Articulo rechazado por el destinatario -
                    <b>14.</b>El remitente solicito entrega posterior -
                    <b>15.</b>Direccion inacesible -
                    <b>16.</b>Entrega Perdida -
                    <b>17.</b>Artculo Perdido -
                    <b>18.</b>Articulo Incorrecto -
                    <b>19.</b>Artuculo Dañado -
                    <b>20.</b>Articulo Prohibido -
                    <b>21.</b>Importacion Restringida -
                    <b>22.</b>No Reclamado -
                    <b>23.</b>Fallecido -
                    <b>24.</b>Por Fuerza Mayor, Articulo no entregado -
                    <b>25.</b>Destinatario Solicita recojo en Agencia -
                    <b>26.</b>Destinatario en Vacaciones -
                    <b>27.</b>Destinatario en Traslado -
                    <b>99.</b>Otros
                </td>
            </tr>
            <tr>
                <td>Razon</td>
                <td>
                    <b>A.</b>Intento de entrega HOY -
                    <b>B.</b>Intento de entrega MAÑANA -
                    <b>C.</b>Articulo Retenido, Destinatario Notificado -
                    <b>D.</b>Remitente Contactado -
                    <b>E.</b>Devuelto a Ventanilla -
                </td>
            </tr>
        </thead>
    </table>
    <table class="resume-table">
        <thead>
            <tr>
                <th></th>
                <th>CERTIFICADO</th>
                <th>ORDINARIO</th>
                <th>EMS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>TOTAL ENTREGADOS</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>TOTAL NOTIFICADOS</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>TOTAL PENDIENTE</td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
            <tr>
                <td>TOTAL REZAGO</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>TOTAL ENVIOS LLEVADOS</b></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="second-table">
        <thead>
            <tr>
                <th>__________________________</th>
                <th>__________________________</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                <tr>
                    <td>
                        <p>SUPERVISOR/SALIDA<br>{{ auth()->user()->name }}</p>
                    </td>
                    <td>
                        <p>ENTREGADO POR<br>{{ $package->usercartero }}</p>
                    </td>
                </tr>
            @break
        @endforeach
    </tbody>
</table>
</body>

</html>
