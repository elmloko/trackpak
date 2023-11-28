<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClasificacionExport implements FromCollection, WithHeadings, WithStyles
{
    protected $fechaInicio;
    protected $fechaFin;

    public function collection()
    {
        $ciudad = request()->input('ciudad'); // Obtén la ciudad seleccionada del formulario

        $query = Package::where('ESTADO', 'CLASIFICACION')
            ->where('CUIDAD', $ciudad) // Agrega la condición para la ciudad
            ->select(
                'CODIGO',
                'DESTINATARIO',
                'TELEFONO',
                'PAIS',
                'CUIDAD',
                'ZONA',
                'VENTANILLA',
                'PESO',
                'TIPO',
                'ADUANA',
                'ESTADO',
                \DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') AS formatted_created_at"),
            );

        if ($this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('created_at', [$this->fechaInicio, $this->fechaFin]);
        }
        
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
            'TIPO',
            'ADUANA',
            'ESTADO',
            'FECHA INGRESO'
        ];
    }

    public function styles(Worksheet $sheet)
    {
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
