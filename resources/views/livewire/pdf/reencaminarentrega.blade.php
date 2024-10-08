<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-11">
    <title>Formulario de Reencaminamiento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        * {
            margin: 0%;
            padding: 0%;
        }

        .center-text {
            text-align: center;
        }

        .small-text {
            font-size: 14px;
        }

        .special-text {
            text-align: center;
            font-size: 12px;
        }

        .normal-text {
            font-size: 12px;
        }

        .centro {
            margin-top: 0%;
            margin-bottom: 0%;
            margin-left: 12%
        }

        table {
            width: 100%;
        }

        table td {
            width: 100%;
        }

        p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="modal-body">
            <div class="logo">
                <img src="{{ public_path('images/images.png') }}" alt="" width="100" height="50">
            </div>
            <div class="center-text">
                <h2 class="normal-text" style="margin-top: 0;">FORMULARIO DE REENCAMINAMIENTO</h2>
                <h3 class="normal-text">AGENCIA BOLIVIANA DE CORREOS</h3>
            </div>
            <table class="centro">
                <tr>
                    <td>
                        <p class="barcode">{!! DNS1D::getBarcodeHTML($package->CODIGO, 'C128', 1.25, 25) !!}</p>
                        <p class="small-text"><strong>Código Rastreo:</strong> {{ $package->CODIGO }}</p>
                        <p class="small-text"><strong>Destinatario:</strong> {{ $package->DESTINATARIO }}</p>
                        <p class="small-text"><strong>Ciudad:</strong> {{ auth()->user()->Regional }}</p>
                        <p class="small-text"><strong>Rencaminado:</strong> {{ $package->CUIDAD }}</p>
                        <p class="small-text"><strong>Ventanilla:</strong> {{ $package->VENTANILLA }}</p>
                    </td>
                    <td>
                        <p class="small-text"><strong>Usuario:</strong> {{ auth()->user()->name }}</p>
                        <p class="small-text"><strong>Peso:</strong> {{ $package->PESO }} gr.</p>
                        <p class="small-text"><strong>Ventanilla:</strong> {{ $package->TELEFONO }}</p>
                        <p class="small-text"><strong>Entrega:</strong> {{ $package->ESTADO }}</p>
                        <p class="small-text"><strong>Observaciones:</strong> {{ $package->OBSERVACIONES }}</p>
                        <p class="small-text"><strong>Fecha Entrega:</strong> {{ now()->format('Y-m-d H:i') }}</p>
                    </td>
                </tr>
            </table>
            <br>
            <table>
                <td>
                    <p class="special-text">__________________________</p>
                    <p class="special-text">RECIBIDO POR</p>
                    <p class="special-text"></p>
                </td>
            </table>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="modal-body">
            <div class="logo">
                <img src="{{ public_path('images/images.png') }}" alt="" width="100" height="50">
            </div>
            <div class="center-text">
                <h2 class="normal-text" style="margin-top: 0;">FORMULARIO DE REENCAMINAMIENTO</h2>
                <h3 class="normal-text">AGENCIA BOLIVIANA DE CORREOS</h3>
            </div>
            <table class="centro">
                <tr>
                    <td>
                        <p class="barcode">{!! DNS1D::getBarcodeHTML($package->CODIGO, 'C128', 1.25, 25) !!}</p>
                        <p class="small-text"><strong>Código Rastreo:</strong> {{ $package->CODIGO }}</p>
                        <p class="small-text"><strong>Destinatario:</strong> {{ $package->DESTINATARIO }}</p>
                        <p class="small-text"><strong>Ciudad:</strong> {{ auth()->user()->Regional }}</p>
                        <p class="small-text"><strong>Rencaminado:</strong> {{ $package->CUIDAD }}</p>
                        <p class="small-text"><strong>Ventanilla:</strong> {{ $package->VENTANILLA }}</p>
                    </td>
                    <td>
                        <p class="small-text"><strong>Usuario:</strong> {{ auth()->user()->name }}</p>
                        <p class="small-text"><strong>Peso:</strong> {{ $package->PESO }} gr.</p>
                        <p class="small-text"><strong>Ventanilla:</strong> {{ $package->TELEFONO }}</p>
                        <p class="small-text"><strong>Entrega:</strong> {{ $package->ESTADO }}</p>
                        <p class="small-text"><strong>Observaciones:</strong> {{ $package->OBSERVACIONES }}</p>
                        <p class="small-text"><strong>Fecha Entrega:</strong> {{ now()->format('Y-m-d H:i') }}</p>
                    </td>
                </tr>
            </table>
            <br>
            <table>
                <td>
                    <p class="special-text">__________________________ </p>
                    <p class="special-text">ENTREGADO POR</p>
                    <p class="special-text">{{ auth()->user()->name }}</p>
                </td>
            </table>
        </div>
    </div>
</body>
</html>
