<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\International;
use App\Models\Package;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Internationalinvcasillas;
use App\Exports\KardexExport;
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
    
    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Inventario Paqueteria Casillas Certificado"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
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
            ->paginate(100);

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
    public function generateKardex()
    {
        // Obtiene la fecha actual
        $fechaHoy = now()->toDateString();
    
        // Obtiene el usuario actual
        $user = auth()->user();

        Event::create([
            'action' => 'ESTADO',
            'descripcion' => 'Generar Kardex Casillas',
            'user_id' => auth()->user()->id,
            'codigo' => 'N/A',
        ]);
    
        // Obtiene todos los paquetes internacionales que han sido dados de baja hoy y tienen VENTANILLA = 'DD'
        $internationalPackages = International::onlyTrashed()
            ->whereDate('deleted_at', $fechaHoy) // Filtrar por la fecha de baja de hoy
            ->where('VENTANILLA', 'CASILLAS') // Filtrar por ventanilla 'DD'
            ->get(); // Obtener todos los paquetes internacionales
    
        // Obtiene todos los paquetes locales (Packages) que han sido dados de baja hoy y tienen VENTANILLA = 'DD'
        $packages = Package::onlyTrashed()
            ->whereDate('deleted_at', $fechaHoy) // Filtrar por la fecha de baja de hoy
            ->where('VENTANILLA', 'CASILLAS') // Filtrar por ventanilla 'DD'
            ->get(); // Obtener todos los paquetes locales
    
        // Combina ambos resultados (paquetes internacionales y locales)
        $combinedPackages = $internationalPackages->merge($packages);
    
        // Llama a la clase exportable con la fecha de hoy, el usuario y todos los paquetes combinados
        return Excel::download(new KardexExport($fechaHoy, $user, $combinedPackages), 'Kardex_Inventario_' . $fechaHoy . '.xlsx');
    }
}
