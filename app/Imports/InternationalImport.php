<?php

namespace App\Imports;

use App\Models\International;
use Maatwebsite\Excel\Concerns\ToModel;

class InternationalImport implements ToModel
{
    public function model(array $row)
    {
        return new International([
            'CODIGO' => $row[0],
            'DESTINATARIO' => $row[1],
            'TELEFONO' => is_numeric($row[2]) ? $row[2] : null,
            'PESO' => is_numeric($row[3]) ? floatval($row[3]) : null,
            'ADUANA' => $row[4],
            'ZONA' => $row[5],
            'CUIDAD' => 'LA PAZ',
            'VENTANILLA' =>  'DND',
            'ESTADO' => 'VENTANILLA',
            'TIPO' => 'PAQUETE',
            'created_at' => now(),
        ]);
    }
}

