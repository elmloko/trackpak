<?php

namespace App\Exports;

use App\Models\Package;
use App\Models\International;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CarteroeExport implements FromCollection, WithHeadings, WithStyles
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
        $columns = [
            'CODIGO', 'DESTINATARIO', 'TELEFONO', 'PESO', 'ESTADO', 'usercartero', 'updated_at','foto','firma',
        ];

        // Filtrar paquetes nacionales por el cartero
        $packages = Package::select($columns)
            ->where('ESTADO', 'RETORNO')
            ->when($this->selectedCartero, function ($query) {
                return $query->where('usercartero', $this->selectedCartero);
            })
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%');
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
                    'updated_at' => \Carbon\Carbon::parse($package->updated_at)->format('d/m/Y H:i'),
                ];
            });

        // Filtrar paquetes internacionales por el cartero
        $internationalPackages = International::select($columns)
            ->where('ESTADO', 'RETORNO')
            ->when($this->selectedCartero, function ($query) {
                return $query->where('usercartero', $this->selectedCartero);
            })
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%');
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
                    'updated_at' => \Carbon\Carbon::parse($package->updated_at)->format('d/m/Y H:i'),
                ];
            });

        return $packages->concat($internationalPackages);
    }

    public function headings(): array
    {
        return [
            'Código Rastreo', 'Destinatario', 'Teléfono', 'Peso', 'Estado', 'Cartero', 'Fecha Actualización'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
