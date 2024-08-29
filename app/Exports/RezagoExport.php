<?php

namespace App\Exports;

use App\Models\Package;
use App\Models\International;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RezagoExport implements FromCollection, WithHeadings, WithStyles
{
    protected $fechaInicio;
    protected $fechaFin;

    public function __construct($fechaInicio, $fechaFin)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    public function collection()
    {
        $query1 = Package::where('ESTADO', 'REZAGO')
            ->select(
                'CODIGO',
                'DESTINATARIO',
                'CUIDAD',
                'PESO',
                'ESTADO',
                \DB::raw("DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i') AS formatted_date_redirigido")
            );

        $query2 = International::where('ESTADO', 'REZAGO')
            ->select(
                'CODIGO',
                'DESTINATARIO',
                'CUIDAD',
                'PESO',
                'ESTADO',
                \DB::raw("DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i') AS formatted_date_redirigido")
            );

        // Combinar ambas consultas
        $combinedQuery = $query1->union($query2);

        if ($this->fechaInicio && $this->fechaFin) {
            $combinedQuery->whereBetween('updated_at', [$this->fechaInicio, $this->fechaFin]);
        }

        return $combinedQuery->get();
    }

    public function headings(): array
    {
        return [
            'CODIGO',
            'DESTINATARIO',
            'CUIDAD',
            'PESO',
            'ESTADO',
            'FECHA REENCAMINADO'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        $sheet->getStyle('A2:J' . ($sheet->getHighestRow()))->getAlignment()->setVertical('center');
        $sheet->getStyle('A2:J' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center');

        $sheet->getStyle('A:J')->getFont()->setSize(12);

        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
