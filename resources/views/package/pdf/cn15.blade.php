<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CN 15 - Devolución</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 300px;
            border: 1px solid #000;
            padding: 10px;
            background-color: #fdd2d2;
        }
        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .checkbox-group {
            display: flex;
            flex-direction: column;
        }
        .checkbox-item {
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">CN 15 - DEVOLUCIÓN / RETOUR</div>
        <div class="checkbox-group">
            <div class="checkbox-item"><input type="checkbox"> Desconocido / Inconnu</div>
            <div class="checkbox-item"><input type="checkbox"> Se ausentó / Déménagé</div>
            <div class="checkbox-item"><input type="checkbox"> Dirección incorrecta / Adresse erronée</div>
            <div class="checkbox-item"><input type="checkbox"> Dirección insuficiente / Adresse insuffisante</div>
            <div class="checkbox-item"><input type="checkbox"> Rehusado / Refusé</div>
            <div class="checkbox-item"><input type="checkbox"> No retirado / Non réclamé</div>
            <div class="checkbox-item"><input type="checkbox"> Fallecido / Décédé</div>
        </div>
        <div class="footer">
            <strong>Codigo:</strong> {{ $data['codigo'] }}<br>
            <strong>Fecha de devolución:</strong> {{ $data['fecha'] }}<br>
            <strong>Devolución a sección:</strong> {{ $data['observaciones'] ?? 'N/A' }}
        </div>
    </div>
</body>
</html>
