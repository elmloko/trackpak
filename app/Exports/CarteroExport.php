<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Package;
use App\Models\International; // Añadimos el modelo de paquetes internacionales

class CarteroExport implements FromCollection, WithHeadings, WithStyles
{
    protected $fechaInicio;
    protected $fechaFin;
    protected $user;

    public function __construct($fechaInicio, $fechaFin, $user)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->user = $user;
    }

    public function collection()
    {
        // Paquetes nacionales (Package)
        $nationalPackages = Package::withTrashed()->where('ESTADO', 'REPARTIDO')
            ->select(
                'CODIGO',
                'DESTINATARIO',
                'TELEFONO',
                'PAIS',
                'CUIDAD', // Puedes corregir el nombre de la columna si es necesario
                'ZONA',
                'VENTANILLA',
                'PESO',
                'PRECIO',
                'TIPO',
                'ESTADO',
                'ADUANA',
                'usercartero',
                \DB::raw("DATE_FORMAT(deleted_at, '%Y-%m-%d %H:%i') AS formatted_deleted_at")
            )
            ->where('usercartero', $this->user);

        if ($this->fechaInicio && $this->fechaFin) {
            $nationalPackages->whereBetween('deleted_at', [$this->fechaInicio, $this->fechaFin]);
        }

        $nationalPackages = $nationalPackages->get();

        // Paquetes internacionales (International)
        $internationalPackages = International::withTrashed()->where('ESTADO', 'REPARTIDO')
            ->select(
                'CODIGO',
                'DESTINATARIO',
                'TELEFONO',
                'ZONA',
                'VENTANILLA',
                'PESO',
                'TIPO',
                'ESTADO',
                'usercartero',
                \DB::raw("DATE_FORMAT(deleted_at, '%Y-%m-%d %H:%i') AS formatted_deleted_at")
            )
            ->where('usercartero', $this->user);

        if ($this->fechaInicio && $this->fechaFin) {
            $internationalPackages->whereBetween('deleted_at', [$this->fechaInicio, $this->fechaFin]);
        }

        $internationalPackages = $internationalPackages->get();

        // Unir ambas colecciones
        return $nationalPackages->concat($internationalPackages);
    }

    public function headings(): array
    {
        return [
            'CODIGO',
            'DESTINATARIO',
            'TELEFONO',
            'DIRECCION',
            'VENTANILLA',
            'PESO',
            'TIPO',
            'ESTADO',
            'CARTERO',
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
        $sheet->getStyle('A:L')->getFont()->setSize(12);

        // Autoajusta el ancho de las columnas
        foreach (range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
