<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\International;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Internationalinvcasillas;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class Deleteadocasillas extends Component
{
    use WithPagination;
    public $fecha_inicio;
    public $fecha_fin;

    public $search = '';

    public function exportExcel()
    {
        return Excel::download(new Internationalinvcasillas($this->fecha_inicio, $this->fecha_fin), 'Inventario Certificados CASILLAS.xlsx');
    }
    
    public function render()
    {
        $userRegional = auth()->user()->Regional;

        $packages = International::onlyTrashed()
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%') // Mantenido como 'CUIDAD'
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('deleted_at', 'like', '%' . $this->search . '%');
            })
            // Filtra por la 'CUIDAD' del usuario autenticado
            ->whereIn('ESTADO', ['ENTREGADO'])
            ->where('CUIDAD', $userRegional)
            ->where('VENTANILLA', 'CASILLAS')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('livewire.deleteadocasillas', [
            'packages' => $packages,
        ]);
    }
    public function restorePackage($id)
    {
        $package = International::withTrashed()->find($id);
        if ($package) {
            Event::create([
                'action' => 'ESTADO',
                'descripcion' => 'Alta de Paquete',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            $package->update(['ESTADO' => 'VENTANILLA']);
            $package->restore();
            session()->flash('success', 'El paquete ha sido restaurado exitosamente');
        } else {
            session()->flash('error', 'El paquete no pudo ser encontrado o restaurado');
        }
    }
    public function reprintPDF($id)
    {
        $package = International::withTrashed()->find($id);

        if ($package) {
            $formulario = $package->ADUANA == 'SI' ? 'package.pdf.formularioentrega' : 'package.pdf.formularioentrega2';

            $pdf = Pdf::loadView($formulario, ['packages' => collect([$package])]);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'Formulario Certificado Casilla.pdf');
        } else {
            session()->flash('error', 'No se pudo encontrar el paquete.');
        }
    }
}
