<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Package;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class Traspasoventanillas extends Component
{
    use WithPagination;

    public $searchTerm; // Variable para el código de búsqueda
    public $selectedVentanilla; // Variable para el select de ventanillas

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Traspazo de Ventanillas"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }

    public function searchPackage()
    {
        // Buscar el paquete por el código de rastreo y estado 'VENTANILLA'
        $package = Package::where('CODIGO', $this->searchTerm)
            ->where('ESTADO', 'VENTANILLA')
            ->first();

        if ($package) {
            // Actualizar el estado del paquete a 'TRASPAZO'
            $package->ESTADO = 'TRASPAZO';
            $package->save();

            // Crear el evento para el cambio de estado
            Event::create([
                'action' => 'TRASPAZO',
                'descripcion' => 'Paquete seleccionado para traspaso de Ventanilla',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);

            session()->flash('message', 'El paquete con código ' . $this->searchTerm . ' ha sido actualizado a TRASPAZO.');
        } else {
            session()->flash('message', 'No se encontró ningún paquete con el código ingresado o el estado no es VENTANILLA.');
        }
    }

    public function quitarVentana($packageId)
    {
        // Buscar el paquete por ID
        $package = Package::find($packageId);

        if ($package) {
            // Actualizar el estado del paquete a 'VENTANILLA'
            $package->ESTADO = 'VENTANILLA';
            $package->save();

            session()->flash('message', 'El paquete ha sido regresado a la ventanilla.');
        } else {
            session()->flash('message', 'No se pudo encontrar el paquete para quitar de la ventanilla.');
        }
    }

    public function traspazarPaquetes()
    {
        // Verificar si se ha seleccionado una ventanilla
        if (!$this->selectedVentanilla) {
            session()->flash('message', 'Seleccione una ventanilla antes de traspasar.');
            return;
        }
    
        // Actualizar todos los paquetes con estado 'TRASPAZO' a la ventanilla seleccionada
        $packages = Package::where('ESTADO', 'TRASPAZO')->get();
    
        foreach ($packages as $package) {
            $package->VENTANILLA = $this->selectedVentanilla;
            $package->ESTADO = 'VENTANILLA'; // Cambiar el estado de nuevo a 'VENTANILLA'
            $package->save();
    
            // Crear el evento para el cambio de ventanilla
            Event::create([
                'action' => 'TRASPAZO',
                'descripcion' => 'Paquete traspasado a Ventanilla ' . $this->selectedVentanilla,
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
        }
    
        // Generar el PDF con los datos de los paquetes traspasados
        $pdf = PDF::loadView('package.pdf.traspazopdf', ['packages' => $packages, 'selectedVentanilla' => $this->selectedVentanilla]);
    
        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();

        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Traspazo Ventanillas.pdf');
    }

    public function render()
    {
        // Filtrar los paquetes con estado 'TRASPAZO' para mostrarlos en la tabla
        $packages = Package::where('ESTADO', 'TRASPAZO')
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        // Retornar la vista con los paquetes filtrados
        return view('livewire.traspasoventanillas', [
            'packages' => $packages,
        ]);
    }
}
