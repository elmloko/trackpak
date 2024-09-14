<?php

namespace App\Exports;

use App\Models\Package;
use App\Models\International;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CarteroeGeneralExport implements FromCollection, WithHeadings, WithStyles
{
    protected $search;
    protected $selectedCartero;
    protected $userRegional;

    public function __construct($search, $selectedCartero, $userRegional)
    {
        $this->search = $search;
        $this->selectedCartero = $selectedCartero;
        $this->userRegional = $userRegional;
    }

    public function collection()
    {
        $columns = ['CODIGO', 'DESTINATARIO', 'TELEFONO', 'PESO', 'ESTADO', 'usercartero', 'updated_at'];
    
        $packages = Package::select($columns)
            ->where('ESTADO', 'CARTERO')
            ->when($this->selectedCartero, function ($query) {
                return $query->where('usercartero', $this->selectedCartero);
            })
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $this->userRegional)
            ->get()
            ->map(function ($package) {
                return [
                    'CODIGO' => $package->CODIGO,
                    'DESTINATARIO' => $package->DESTINATARIO,
                    'TELEFONO' => $package->TELEFONO,
                    'PESO' => $package->PESO,
                    'ESTADO' => $package->ESTADO,
                    'usercartero' => $package->usercartero,
                    'updated_at' => \Carbon\Carbon::parse($package->updated_at)->format('d/m/Y H:i'), // Formato de fecha
                ];
            });
    
        $internationalPackages = International::select($columns)
            ->where('ESTADO', 'CARTERO')
            ->when($this->selectedCartero, function ($query) {
                return $query->where('usercartero', $this->selectedCartero);
            })
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $this->userRegional)
            ->get()
            ->map(function ($package) {
                return [
                    'CODIGO' => $package->CODIGO,
                    'DESTINATARIO' => $package->DESTINATARIO,
                    'TELEFONO' => $package->TELEFONO,
                    'PESO' => $package->PESO,
                    'ESTADO' => $package->ESTADO,
                    'usercartero' => $package->usercartero,
                    'updated_at' => \Carbon\Carbon::parse($package->updated_at)->format('d/m/Y H:i'), // Formato de fecha
                ];
            });
    
        // Combinar ambos resultados en una colección
        return $packages->concat($internationalPackages);
    }

    public function headings(): array
    {
        return [
            'Código Rastreo', 'Destinatario', 'Teléfono', 'Peso','Estado', 'Cartero', 'Fecha Actualización'
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
