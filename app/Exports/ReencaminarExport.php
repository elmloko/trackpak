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

    public function __construct($fechaInicio, $fechaFin, $ciudad)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->ciudad = $ciudad;
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

        if ($this->ciudad) {
            $query->where('CUIDAD', $this->ciudad);
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