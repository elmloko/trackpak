<?php

namespace App\Imports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\ToModel;

class EncomiendasImport implements ToModel
{
    public function model(array $row)
    {
        return new Package([
            'CODIGO' => strtoupper($row[0] ?? ''),
            'DESTINATARIO' => strtoupper($row[1] ?? ''),
            'TELEFONO' => isset($row[2]) && is_numeric($row[2]) ? $row[2] : null,
            'PESO' => isset($row[3]) && is_numeric($row[3]) ? floatval($row[3]) : null,
            'ZONA' => strtoupper($row[4] ?? ''),
            'TIPO' => strtoupper($row[5] ?? ''),
            'CUIDAD' => 'LA PAZ',
            'VENTANILLA' => 'ENCOMIENDAS',
            'ESTADO' => 'VENTANILLA',
            'created_at' => now(),
        ]);
    }
}
