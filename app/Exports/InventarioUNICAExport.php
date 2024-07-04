<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventarioUNICAExport implements FromCollection, WithHeadings, WithStyles
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
        $regional = auth()->user()->Regional;
        $query = Package::withTrashed()
            ->where('ESTADO', 'ENTREGADO')
            ->where('VENTANILLA', 'UNICA')
            ->where('CUIDAD', $regional)
            ->select(
                'CODIGO',
                'DESTINATARIO',
                'TELEFONO',
                'CUIDAD',
                'ZONA',
                'VENTANILLA',
                'PESO',
                'ESTADO',
                'OBSERVACIONES',
                \DB::raw("DATE_FORMAT(deleted_at, '%Y-%m-%d %H:%i') AS formatted_deleted_at")
            );

        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('deleted_at', [$this->fechaInicio, $this->fechaFin]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'CODIGO',
            'DESTINATARIO',
            'TELEFONO',
            'CUIDAD',
            'ZONA',
            'VENTANILLA',
            'PESO',
            'ESTADO',
            'OBSERVACIONES',
            'FECHA BAJA',
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
