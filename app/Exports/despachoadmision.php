<?php

namespace App\Exports;

use App\Models\National;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DespachoAdmision implements FromCollection, WithHeadings, WithStyles
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
        $regional = auth()->user();
        $query = National::where('ESTADO', 'DESPACHO')
            ->select(
                \DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') AS formatted_created_at"),
                'CODIGO',
                'CANTIDAD',
                'ORIGEN',
                'TIPOSERVICIO',
                'PESO',
                'DESTINO',
                'IMPORTE',
            );

        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('created_at', [$this->fechaInicio, $this->fechaFin]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'FECHA',
            'CODIGO',
            'CANTIDAD',
            'ORIGEN',
            'TIPO DE CORRESPONDENCIA',
            'PESO',
            'DESTINO',
            'IMPORTE',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Establece el espaciado entre las tablas
        $sheet->getStyle('A1:J1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        // Establece un espaciado adicional después de cada fila de datos
        $sheet->getStyle('A2:J' . ($sheet->getHighestRow()))->getAlignment()->setVertical('center');
        $sheet->getStyle('A2:J' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center');

        // Ajusta el espaciado según tus necesidades
        // $sheet->getStyle('A:J')->getAlignment()->setVertical('center');
        $sheet->getStyle('A:J')->getFont()->setSize(12);

        // Autoajusta el ancho de las columnas
        foreach(range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
