<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReencaminarExport implements FromCollection, WithHeadings, WithStyles
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
        $query = Package::where('ESTADO', 'REENCAMINADO')
            ->select(
                'CODIGO',
                'DESTINATARIO',
                'PAIS',
                'CUIDAD',
                'ZONA',
                'PESO',
                'TIPO',
                'ADUANA',
                'ESTADO',
                \DB::raw("DATE_FORMAT(date_redirigido, '%Y-%m-%d %H:%i') AS formatted_date_redirigido"),
            );

        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('date_redirigido', [$this->fechaInicio, $this->fechaFin]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'CODIGO',
            'DESTINATARIO',
            'PAIS',
            'CUIDAD',
            'DIRECCION',
            'PESO',
            'TIPO',
            'ADUANA',
            'ESTADO',
            'FECHA REENCAMINADO'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);

        $sheet->getStyle('A2:L' . ($sheet->getHighestRow()))->getAlignment()->setVertical('center');
        $sheet->getStyle('A2:L' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center');

        $sheet->getStyle('A:L')->getFont()->setSize(12);

        foreach(range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
