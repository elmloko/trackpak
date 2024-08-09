<?php

namespace App\Imports;

use App\Models\International;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CasillaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new International([
            'CODIGO' => strtoupper($row['codigo'] ?? ''),
            'DESTINATARIO' => strtoupper($row['destinatario'] ?? ''),
            'TELEFONO' => isset($row['telefono']) && is_numeric($row['telefono']) ? $row['telefono'] : null,
            'PESO' => isset($row['peso']) && is_numeric($row['peso']) ? floatval($row['peso']) : null,
            'ZONA' => strtoupper($row['zona'] ?? ''),
            'TIPO' => strtoupper($row['tipo'] ?? ''),
            'CUIDAD' => 'LA PAZ',
            'VENTANILLA' => 'CASILLAS',
            'ESTADO' => 'VENTANILLA',
            'ADUANA' => 'NO',
            'created_at' => now(),
        ]);
    }
}
