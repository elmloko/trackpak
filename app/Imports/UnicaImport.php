<?php

namespace App\Imports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnicaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Package([
            'CODIGO' => strtoupper($row['codigo'] ?? ''),
            'DESTINATARIO' => strtoupper($row['destinatario'] ?? ''),
            'TELEFONO' => isset($row['telefono']) && is_numeric($row['telefono']) ? $row['telefono'] : null,
            'PESO' => isset($row['peso']) && is_numeric($row['peso']) ? floatval($row['peso']) : null,
            'ADUANA' => strtoupper($row['aduana'] ?? ''),
            'ZONA' => strtoupper($row['zona'] ?? ''),
            'CUIDAD' => strtoupper($row['cuidad'] ?? ''),
            'VENTANILLA' => 'UNICA',
            'ESTADO' => 'VENTANILLA',
            'TIPO' => 'PAQUETE',
            'created_at' => now(),
        ]);
    }
}
