<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\International;
use Livewire\WithPagination;
use App\Exports\Internationalinvdnd;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class Deleteadoidnd extends Component
{
    use WithPagination; // Mueve el uso de WithPagination aquí

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;
    
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
            ->where('VENTANILLA', 'DND')
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('livewire.deleteadoidnd', [
            'packages' => $packages,
        ]);
    }

    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        return Excel::download(new Internationalinvdnd($this->fecha_inicio, $this->fecha_fin), 'Inventario Certificados DND.xlsx');
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
            }, 'Formulario Certificado DND.pdf');
        } else {
            session()->flash('error', 'No se pudo encontrar el paquete.');
        }
    }
}
