<?php

namespace App\Imports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EncomiendasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Package([
            'CODIGO' => strtoupper($row['codigo'] ?? ''),
            'DESTINATARIO' => strtoupper($row['destinatario'] ?? ''),
            'TELEFONO' => isset($row['telefono']) && is_numeric($row['telefono']) ? $row['telefono'] : null,
            'PESO' => isset($row['peso']) && is_numeric($row['peso']) ? floatval($row['peso']) : null,
            'ZONA' => strtoupper($row['zona'] ?? ''),
            'ADUANA' => 'NO',
            'TIPO' => 'PAQUETE',
            'CUIDAD' => 'LA PAZ',
            'VENTANILLA' => 'ENCOMIENDAS',
            'ESTADO' => 'VENTANILLA',
            'created_at' => now(),
        ]);
    }
}
