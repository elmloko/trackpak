<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EncomiendasExport implements FromCollection, WithHeadings, WithStyles
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

    $query = Package::where('ESTADO', 'VENTANILLA')
        ->where('redirigido', 0)
        ->whereIn('VENTANILLA', ['ENCOMIENDAS'])
        ->select(
            'CODIGO',
            'DESTINATARIO',
            'TELEFONO',
            'PAIS',
            'CUIDAD',
            'ZONA',
            'VENTANILLA',
            'PESO',
            'PRECIO',
            'TIPO',
            'ESTADO',
            'ADUANA',
            'updated_at',
            \DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') AS formatted_updated_at"),
        );

    if ($this->fechaInicio && $this->fechaFin) {
        $query->whereBetween('updated_at', [$this->fechaInicio, $this->fechaFin]);
    }

    $query->where('CUIDAD', $regional);

    return $query->get();
}


    public function headings(): array
    {
        return [
            'CODIGO',
            'DESTINATARIO',
            'TELEFONO',
            'PAIS',
            'CUIDAD',
            'DIRECCION',
            'VENTANILLA',
            'PESO',
            'PRECIO',
            'TIPO',
            'ESTADO',
            'ADUANA',
            'FECHA PENDIENTE'
            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Establece el espaciado entre las tablas
        $sheet->getStyle('A1:L1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);

        // Establece un espaciado adicional después de cada fila de datos
        $sheet->getStyle('A2:L' . ($sheet->getHighestRow()))->getAlignment()->setVertical('center');
        $sheet->getStyle('A2:L' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center');

        // Ajusta el espaciado según tus necesidades
        // $sheet->getStyle('A:L')->getAlignment()->setVertical('center');
        $sheet->getStyle('A:L')->getFont()->setSize(12);

        // Autoajusta el ancho de las columnas
        foreach(range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}