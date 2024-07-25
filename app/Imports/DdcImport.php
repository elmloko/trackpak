<?php

namespace App\Imports;

use App\Models\International;
use Maatwebsite\Excel\Concerns\ToModel;

class DdcImport implements ToModel
{
    public function model(array $row)
    {
        return new International([
            'CODIGO' => strtoupper($row[0]),
            'DESTINATARIO' => strtoupper($row[1]),
            'TELEFONO' => is_numeric($row[2]) ? $row[2] : null,
            'PESO' => is_numeric($row[3]) ? floatval($row[3]) : null,
            'ADUANA' => strtoupper($row[4]),
            'ZONA' => strtoupper($row[5]),
            'TIPO' => strtoupper($row[6]),
            'CUIDAD' => 'LA PAZ',
            'VENTANILLA' =>  'DD',
            'ESTADO' => 'VENTANILLA',
            'created_at' => now(),
        ]);
    }
}