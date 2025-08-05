<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;

class CreacionExport implements FromCollection, WithHeadings, WithMapping
{
    public $desde;
    public $hasta;

    public function __construct($desde, $hasta)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
    }

    public function collection()
    {
        return Package::withTrashed()
            ->whereBetween('created_at', [$this->desde, $this->hasta])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function map($row): array
    {
        return [
            $row->CODIGO,
            $row->DESTINATARIO,
            $row->TELEFONO,
            $row->PAIS . ' - ' . $row->ISO,
            $row->CUIDAD,
            $row->VENTANILLA,
            $row->PESO,
            $row->TIPO,
            $row->ESTADO,
            $row->ADUANA,
            $row->manifiesto,
            $row->OBSERVACIONES,
            $row->created_at,
            $row->deleted_at ? 'ELIMINADO' : 'VIGENTE',
        ];
    }

    public function headings(): array
    {
        return [
            'Código',
            'Destinatario',
            'Teléfono',
            'País',
            'Ciudad',
            'Ventanilla',
            'Peso',
            'Tipo',
            'Estado',
            'Aduana',
            'Manifiesto',
            'Observaciones',
            'Fecha de Creación',
            'Estado Registro',
        ];
    }
}
