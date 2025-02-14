<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventarioDNDExport;
use App\Exports\KardexExport;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class Deleteadodnd extends Component
{
    use WithPagination; // Mueve el uso de WithPagination aquí

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        $packages = Package::onlyTrashed()
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
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
            ->paginate(100);

        return view('livewire.deleteadodnd', [
            'packages' => $packages,
        ]);
    }
    public function export()
    {
        $this->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        return Excel::download(new InventarioDNDExport($this->fecha_inicio, $this->fecha_fin), 'Inventario Ordinario DND.xlsx');
    }
    public function restorePackage($id)
    {
        $package = Package::withTrashed()->find($id);
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
        $package = Package::withTrashed()->find($id);

        Event::create([
            'action' => 'ESTADO',
            'descripcion' => 'Reimprimir PDF de Paquete',
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);

        if ($package) {
            $formulario = $package->ADUANA == 'SI' ? 'package.pdf.formularioentrega' : 'package.pdf.formularioentrega2';

            $pdf = Pdf::loadView($formulario, ['packages' => collect([$package])]);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'Formulario Ordinario DND.pdf');
        } else {
            session()->flash('error', 'No se pudo encontrar el paquete.');
        }
    }
    public function generateKardex()
    {
        // Obtiene la fecha actual
        $fechaHoy = now()->toDateString();
    
        // Obtiene el usuario actual
        $user = auth()->user();
    
        Event::create([
            'action' => 'ESTADO',
            'descripcion' => 'Generar Kardex DND',
            'user_id' => auth()->user()->id,
            'codigo' => 'N/A',
        ]);

        // Obtiene todos los paquetes internacionales que han sido dados de baja hoy y tienen VENTANILLA = 'DD'
        $internationalPackages = International::onlyTrashed()
            ->whereDate('deleted_at', $fechaHoy) // Filtrar por la fecha de baja de hoy
            ->where('VENTANILLA', 'DND') // Filtrar por ventanilla 'DD'
            ->get(); // Obtener todos los paquetes internacionales
    
        // Obtiene todos los paquetes locales (Packages) que han sido dados de baja hoy y tienen VENTANILLA = 'DD'
        $packages = Package::onlyTrashed()
            ->whereDate('deleted_at', $fechaHoy) // Filtrar por la fecha de baja de hoy
            ->where('VENTANILLA', 'DND') // Filtrar por ventanilla 'DD'
            ->get(); // Obtener todos los paquetes locales
    
        // Combina ambos resultados (paquetes internacionales y locales)
        $combinedPackages = $internationalPackages->merge($packages);
    
        // Llama a la clase exportable con la fecha de hoy, el usuario y todos los paquetes combinados
        return Excel::download(new KardexExport($fechaHoy, $user, $combinedPackages), 'Kardex_Inventario_' . $fechaHoy . '.xlsx');
    }
}
