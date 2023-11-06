<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
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
        }

        .title {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            {{-- <img src="{{ asset('images/images.png') }}"> --}}
        </div>
        <div class="title">
            <h2>Lista de Eventos</h2>
        </div>
    </div>

    <table>
        <tr class="thead">
            <th>No</th>
            <th>Accion</th>
            <th>Descripcion</th>
            <th>Usuario</th>
            <th>Codigo</th>
            <th>Fecha y Hora de Modificacion</th>
        </tr>
        <tbody>
            @php
                $i = 1; // Inicializa la variable $i
            @endphp
            @foreach ($events as $event)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $event->action }}</td>
                    <td>{{ $event->descripcion }}</td>
                    <td>{{ $event->user->name }}</td>
                    <td>{{ $event->codigo }}</td>
                    <td>{{ $event->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
