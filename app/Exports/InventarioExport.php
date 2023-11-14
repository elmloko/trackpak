<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventarioExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Package::withTrashed()->where('ESTADO', 'ENTREGADO')
            ->select('CODIGO', 'DESTINATARIO', 'TELEFONO', 'PAIS', 'CUIDAD', 'ZONA', 'VENTANILLA', 'PESO', 'TIPO', 'ESTADO', 'ADUANA', \DB::raw("DATE_FORMAT(deleted_at, '%Y-%m-%d %H:%i') AS formatted_deleted_at"))
            ->get();
    }

    public function headings(): array
    {
        return [
            'CODIGO',
            'DESTINATARIO',
            'TELEFONO',
            'PAIS',
            'DESTINO',
            'DIRECCION',
            'VENTANILLA',
            'PESO',
            'TIPO',
            'ESTADO',
            'ADUANA',
            'FECHA BAJA',
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
