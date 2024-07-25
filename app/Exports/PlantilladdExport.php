<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class PlantilladdExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        // Retorna una colección vacía
        return new Collection([]);
    }

    public function headings(): array
    {
        // Define los encabezados del Excel
        return [
            'CODIGO', 
            'DESTINATARIO', 
            'TELEFONO', 
            'PESO', 
            'ADUANA', 
            'ZONA', 
            'TIPO'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Establece el espaciado entre las tablas
        $sheet->getStyle('A1:G1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        // Ajusta el espaciado según tus necesidades
        $sheet->getStyle('A:F')->getAlignment()->setVertical('center');
        $sheet->getStyle('A:F')->getFont()->setSize(12);

        // Autoajusta el ancho de las columnas
        foreach(range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
