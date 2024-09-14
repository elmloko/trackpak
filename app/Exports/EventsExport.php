<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventsExport implements FromCollection, WithHeadings, WithStyles
{
    protected $search;
    protected $selectedUserId;

    // Constructor para recibir los filtros
    public function __construct($search, $selectedUserId)
    {
        $this->search = $search;
        $this->selectedUserId = $selectedUserId;
    }

    // Este método obtiene los datos a exportar
    public function collection()
    {
        return Event::with('user')
            ->when($this->search, function ($query) {
                return $query->where('codigo', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedUserId, function ($query) {
                return $query->where('user_id', $this->selectedUserId);
            })
            ->get()
            ->map(function ($event) {
                return [
                    'action' => $event->action,
                    'descripcion' => $event->descripcion,
                    'user' => $event->user ? $event->user->name : 'N/A', // Nombre del usuario
                    'codigo' => $event->codigo,
                    'created_at' => $event->created_at,
                ];
            });
    }

    // Definir los encabezados del archivo Excel
    public function headings(): array
    {
        return [
            'Accion',
            'Descripcion',
            'Usuario',
            'Codigo',
            'Fecha y Hora del Evento',
        ];
    }

    // Estilos para la hoja de cálculo
    public function styles(Worksheet $sheet)
    {
        // Establece el espaciado entre las tablas
        $sheet->getStyle('A1:E1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        // Establece un espaciado adicional después de cada fila de datos
        $sheet->getStyle('A2:E' . ($sheet->getHighestRow()))->getAlignment()->setVertical('center');
        $sheet->getStyle('A2:E' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center');

        // Ajusta el tamaño de la fuente
        $sheet->getStyle('A:E')->getFont()->setSize(12);

        // Autoajusta el ancho de las columnas
        foreach(range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
