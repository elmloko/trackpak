<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\International;

class KardexExport implements FromCollection, WithHeadings, WithCustomStartCell, WithStyles
{
    protected $fechaHoy;
    protected $user;
    protected $packages; // Cambiado a múltiples paquetes

    public function __construct($fechaHoy, $user, $packages)
    {
        $this->fechaHoy = $fechaHoy;
        $this->user = $user;
        $this->packages = $packages; // Guardar todos los paquetes filtrados
    }

    public function collection()
    {
        $data = collect(); // Crear una nueva colección para los datos

        // Iterar sobre los paquetes y configurar cada fila de la tabla
        foreach ($this->packages as $index => $package) {
            // Definir el tipo de envío basado en el código
            if (str_starts_with($package->CODIGO, 'R')) {
                $tipoEnvio = 'CERTIFICADO';
            } elseif (str_starts_with($package->CODIGO, 'L') || str_starts_with($package->CODIGO, 'U')) {
                $tipoEnvio = 'ORDINARIO';
            } else {
                $tipoEnvio = 'DESCONOCIDO'; // Por si acaso el código no coincide con las condiciones
            }

            // Agregar los datos a la colección
            $data->push([
                'Nro' => $index + 1, // Numeración secuencial que empieza en 1
                'FECHA' => $package->deleted_at->format('d/m/Y'), // Fecha del paquete
                'TIPO DE ENVÍO' => $tipoEnvio, // Tipo de envío basado en el código
                'CÓDIGO DEL ÍTEM' => $package->CODIGO, // Código del ítem
                'CANTIDAD' => 1, // Cantidad siempre 1
                'PESO DE ENVÍO' => $package->PESO, // Peso del paquete
                'FACTURA N.º' => $package->FACTURA, // Número de factura
                'IMPORTE' => $package->PRECIO, // Importe del paquete
            ]);
        }

        return $data; // Retornar la colección con los datos
    }

    public function headings(): array
    {
        return [
            'Nro',
            'FECHA',
            'TIPO DE ENVÍO',
            'CÓDIGO',
            'CANTIDAD',
            'PESO',
            'FACTURA N.º',
            'IMPORTE'
        ];
    }

    public function startCell(): string
    {
        return 'B10'; // Ajusta según tu formato
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar estilo centrado solo para los datos de la tabla
        $dataRange = 'B10:I' . ($this->packages->count() + 10); // Rango de datos basado en el número de paquetes
        $sheet->getStyle($dataRange)->getAlignment()->setHorizontal('center'); // Centrar horizontalmente los datos

        // Aplicar color opaco a los encabezados
        $sheet->getStyle('B10:I10')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD3D3D3'); // Un color gris suave (puedes cambiar el código del color)

        // Enmarcar solo los extremos de la tabla
        $sheet->getStyle('B10:I' . ($this->packages->count() + 10))
            ->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN); // Bordes alrededor de la tabla

        // Ajustar el contenido de las primeras filas, empezando en las posiciones requeridas
        $sheet->mergeCells('B1:E3'); // Combinación para el título principal
        $sheet->mergeCells('F1:H3'); // Combinación para la segunda sección

        // Centrando y agregando bordes gruesos a las celdas de la primera sección (B1:D3)
        $sheet->mergeCells('B1:D3');
        $sheet->setCellValue('B1', "KARDEX DIARIO DE RENDICIÓN\nAGENCIA BOLIVIANA DE CORREOS\nEXPRESADO EN BS.");
        $sheet->getStyle('B1')->getAlignment()->setWrapText(true);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B1')->getAlignment()->setVertical('center');
        $sheet->getStyle('B1:H3')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        // Centrando y agregando bordes gruesos a la segunda sección (F1:H3)
        $sheet->mergeCells('F1:H3');
        $sheet->setCellValue('F1', "Dirección de Operaciones\nDistribución Domiciliaria\nKardex 3");
        $sheet->getStyle('F1')->getAlignment()->setWrapText(true);
        $sheet->getStyle('F1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F1')->getAlignment()->setVertical('center');
        $sheet->getStyle('F1:H3')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        // Centrando y agregando bordes gruesos a las celdas seleccionadas en la imagen
        $sheet->mergeCells('B6:E6'); // Oficina Postal
        $sheet->setCellValue('B6', 'Oficina Postal: LA PAZ');
        $sheet->getStyle('B6')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B6:E6')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        $sheet->mergeCells('B7:E7'); // Ventanilla
        $sheet->setCellValue('B7', 'Ventanilla: DD');
        $sheet->getStyle('B7')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B7:E7')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        $sheet->mergeCells('B8:I8'); // Nombre del Cartero
        $sheet->setCellValue('B8', 'Nombre del Cartero: Veronica Virginia Miranda Vaca');
        $sheet->getStyle('B8')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B8:I8')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        $sheet->mergeCells('F6:I6'); // Nombre Responsable
        $sheet->setCellValue('F6', 'Nombre Responsable:');
        $sheet->getStyle('F6')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F6:I6')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

        $sheet->mergeCells('F7:I7'); // Fecha de Recaudación
        $sheet->setCellValue('F7', 'Fecha de Recaudación: 2024-09-17');
        $sheet->getStyle('F7')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F7:I7')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);


        // Oficina Postal desde la tabla user.Regional
        $sheet->setCellValue('B6', 'Oficina Postal: ' . $this->user->Regional);

        // Ventanilla desde la tabla packages.VENTANILLA
        if ($this->packages->isNotEmpty()) {
            $sheet->setCellValue('B7', 'Ventanilla: ' . $this->packages->first()->VENTANILLA);
        } else {
            $sheet->setCellValue('B7', 'Ventanilla: N/A'); // Valor por defecto si no hay paquetes
        }

        // Nombre del Cartero desde la tabla user.name
        $sheet->setCellValue('B8', 'Nombre del Cartero: ' . $this->user->name);

        // Nombre Responsable (puedes ajustar si es dinámico)
        $sheet->setCellValue('F6', 'Nombre Responsable:');

        // Fecha de Recaudación (fecha actual)
        $sheet->setCellValue('F7', 'Fecha de Recaudación: ' . $this->fechaHoy);

        // Aplicar estilo adicional si es necesario
        $sheet->getStyle('B6:B8')->getFont()->setBold(true);
        $sheet->getStyle('F6:F7')->getFont()->setBold(true);

        // Ajustar manualmente el tamaño de la columna F (CANTIDAD)
        $sheet->getColumnDimension('B')->setWidth(5);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(6);
        $sheet->getColumnDimension('H')->setWidth(8);
        $sheet->getColumnDimension('I')->setWidth(10);

        $startRow = 10;
        $endRow = $this->packages->count() + $startRow;

        // Calcular la suma de los pesos y mostrarla en una celda al final de la tabla
        $totalRow = $endRow + 1; // Dejar una fila de espacio

        // Combinar las celdas de B a H para el texto "TOTAL GENERAL"
        $sheet->mergeCells('B' . $totalRow . ':H' . $totalRow);
        $sheet->setCellValue('B' . $totalRow, 'TOTAL GENERAL');
        $sheet->getStyle('B' . $totalRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $totalRow)->getAlignment()->setHorizontal('center');

        // Poner el cálculo de la suma en la celda I
        $sheet->setCellValue('I' . $totalRow, '=SUM(I' . $startRow . ':I' . $endRow . ')'); // Sumar todos los pesos desde la fila de inicio hasta la última fila
        $sheet->getStyle('I' . $totalRow)->getFont()->setBold(true);

        // Aplicar bordes a las celdas combinadas y la celda de la suma
        $sheet->getStyle('B' . $totalRow . ':H' . $totalRow)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('I' . $totalRow)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        // Añadir la sección de firmas y observaciones al final
        $finalRow = $totalRow + 2;

        // "Observaciones" - combinar celdas B: D para las observaciones
        $sheet->mergeCells('B' . $finalRow . ':D' . ($finalRow + 8));
        $sheet->setCellValue('B' . $finalRow, 'Observaciones:');
        $sheet->getStyle('B' . $finalRow)->getAlignment()->setVertical('top');
        $sheet->getStyle('B' . $finalRow)->getAlignment()->setHorizontal('left');

        // Sección de firmas - Recaudador (celdas E:F)
        $sheet->mergeCells('E' . $finalRow . ':F' . ($finalRow + 8));
        $sheet->setCellValue('E' . $finalRow, "SELLO / FIRMA DE CONFORMIDAD\nRECAUDADOR");
        $sheet->getStyle('E' . $finalRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('E' . $finalRow)->getAlignment()->setVertical('bottom');
        $sheet->getStyle('E' . $finalRow)->getAlignment()->setWrapText(true); // Habilitar ajuste de texto
        $sheet->getStyle('E' . $finalRow . ':F' . ($finalRow + 8))->getFont()->setSize(8);
        $sheet->getStyle('E' . $finalRow . ':F' . ($finalRow + 8))->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Sección de firmas - Revisor (celdas G:H)
        $sheet->mergeCells('G' . $finalRow . ':H' . ($finalRow + 8));
        $sheet->setCellValue('G' . $finalRow, "SELLO / FIRMA DE CONFORMIDAD\nREVISOR");
        $sheet->getStyle('G' . $finalRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G' . $finalRow)->getAlignment()->setVertical('bottom');
        $sheet->getStyle('G' . $finalRow)->getAlignment()->setWrapText(true); // Habilitar ajuste de texto
        $sheet->getStyle('G' . $finalRow . ':H' . ($finalRow + 8))->getFont()->setSize(8);
        $sheet->getStyle('G' . $finalRow . ':H' . ($finalRow + 8))->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Sección de firmas - Tesorería (celda I)
        $sheet->mergeCells('I' . ($finalRow) . ':I' . ($finalRow + 8));
        $sheet->setCellValue('I' . ($finalRow), 'SELLO RECEPCIÓN TESORERÍA');
        $sheet->getStyle('I' . ($finalRow))->getAlignment()->setHorizontal('center');
        $sheet->getStyle('I' . ($finalRow))->getAlignment()->setVertical('bottom');
        $sheet->getStyle('I' . ($finalRow))->getAlignment()->setWrapText(true); // Habilitar ajuste de texto
        $sheet->getStyle('I' . ($finalRow) . ':I' . ($finalRow + 8))->getFont()->setSize(8);
        $sheet->getStyle('I' . ($finalRow) . ':I' . ($finalRow + 8))->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Aplicar bordes a toda la sección de observaciones y firmas
        $sheet->getStyle('B' . $finalRow . ':I' . ($finalRow + 8))->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }
}
