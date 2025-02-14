<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International;
use App\Models\User;  // Importamos el modelo de usuario
use App\Models\Event;
use Livewire\WithPagination;
use App\Exports\CarteroeExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class Despachocarterogeneral extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCartero = '';
    public $selectedDate;

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        // Obtener la lista de carteros
        $carteros = User::role('CARTERO')->get();

        $columns = [
            'CODIGO',
            'DESTINATARIO',
            'TELEFONO',
            'PESO',
            'ESTADO',
            'usercartero',
            'updated_at'
        ];

        // Filtrar paquetes por cartero y otros criterios
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
            ->where('CUIDAD', $userRegional)
            ->orderBy('updated_at', 'desc');

        // Filtrar también en los paquetes internacionales
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
            ->where('CUIDAD', $userRegional)
            ->orderBy('updated_at', 'desc');

        $packages = $packages->union($internationalPackages)->paginate(100);

        return view('livewire.despachocarterogeneral', [
            'packages' => $packages,
            'carteros' => $carteros, // Pasar los carteros a la vista
        ]);
    }

    public function recuperar($codigo)
    {
        $package = Package::where('CODIGO', $codigo)->first();
        if ($package) {
            Event::create([
                'action' => 'DEVUELTO',
                'descripcion' => 'Paquete Devuelto a Oficina Postal Regional.',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            $package->ESTADO = 'VENTANILLA';
            $package->save();
        } else {
            $internationalPackage = International::where('CODIGO', $codigo)->first();
            if ($internationalPackage) {
                Event::create([
                    'action' => 'DEVUELTO',
                    'descripcion' => 'Paquete Devuelto a Oficina Postal Regional.',
                    'user_id' => auth()->user()->id,
                    'codigo' => $internationalPackage->CODIGO,
                ]);
                $internationalPackage->ESTADO = 'VENTANILLA';
                $internationalPackage->save();
            }
        }

        session()->flash('success', 'El paquete ha sido recuperado y su estado ha sido actualizado a VENTANILLA.');
    }
    public function exportToExcel()
    {
        $userRegional = auth()->user()->Regional;
        return Excel::download(new CarteroeExport($this->search, $this->selectedCartero, $userRegional), 'despacho_carteros.xlsx');
    }
    public function exportToPdf()
    {
        $userRegional = auth()->user()->Regional;

        // Obtener los paquetes filtrados, incluyendo eliminados lógicamente
        $packages = Package::withTrashed() // Incluye tanto registros activos como eliminados lógicamente
            ->select('CODIGO', 'DESTINATARIO', 'TELEFONO', 'PESO', 'TIPO', 'ESTADO', 'usercartero', 'updated_at')
            ->whereIn('ESTADO', ['PRE-REZAGO', 'RETORNO', 'REPARTIDO', 'CARTERO'])
            ->when($this->selectedCartero, function ($query) {
                return $query->where('usercartero', $this->selectedCartero);
            })
            ->when($this->search, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('CODIGO', 'like', '%' . $this->search . '%')
                        ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                        ->orWhere('TELEFONO', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedDate, function ($query) {
                return $query->whereDate('updated_at', $this->selectedDate);
            })
            ->where('CUIDAD', $userRegional)
            ->get();

        // Contar los paquetes por estado, incluyendo eliminados
        $totalEntregados = $packages->where('ESTADO', 'REPARTIDO')->count();
        $totalNotificados = $packages->where('ESTADO', 'RETORNO')->count();
        $totalPendiente = $packages->where('ESTADO', 'CARTERO')->count();
        $totalRezago = $packages->where('ESTADO', 'PRE-REZAGO')->count();
        $totalEnvios = $packages->count();

        // Generar el PDF
        $pdf = Pdf::loadView('package.pdf.reportescartero', [
            'packages' => $packages,
            'totals' => [
                'entregados' => $totalEntregados,
                'notificados' => $totalNotificados,
                'pendiente' => $totalPendiente,
                'rezago' => $totalRezago,
                'envios' => $totalEnvios,
            ],
        ]);

        // Descargar el PDF
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'despacho_carteros.pdf');
    }
}
