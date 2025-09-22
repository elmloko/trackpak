<?php

namespace App\Imports;

use App\Models\International;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DdcImport implements ToModel, WithHeadingRow
{
    protected $regional;

    public function __construct($regional)
    {
        $this->regional = $regional;
    }

    public function model(array $row)
    {
        return new International([
            'CODIGO' => strtoupper($row['codigo'] ?? ''),
            'DESTINATARIO' => strtoupper($row['destinatario'] ?? ''),
            'TELEFONO' => isset($row['telefono']) && is_numeric($row['telefono']) ? $row['telefono'] : null,
            'PESO' => isset($row['peso']) && is_numeric($row['peso']) ? floatval($row['peso']) : null,
            'ADUANA' => strtoupper($row['aduana'] ?? ''),
            'ZONA' => strtoupper($row['zona'] ?? ''),
            'TIPO' => strtoupper($row['tipo'] ?? ''),
            'CUIDAD' => $this->regional,   // ✅ ahora guarda según la regional del usuario
            'VENTANILLA' => 'DD',
            'ESTADO' => 'VENTANILLA',
            'created_at' => now(),
        ]);
    }
}
