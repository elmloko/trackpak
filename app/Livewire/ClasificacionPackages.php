<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class ClasificacionPackages extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';

    public function render()
    {
        $userasignado = auth()->user()->name;
        $packages = Package::where('ESTADO', 'CLASIFICACION')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCity, function ($query) {
                $query->where('CUIDAD', $this->selectedCity);
            })
            // ->where('CUIDAD', 'LA PAZ')
            // ->where('usercartero', $userasignado)
            ->orderBy('created_at', 'desc')
            ->paginate(100);

        return view('livewire.clasificacion-packages', [
            'packages' => $packages,
        ]);
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->paquetesSeleccionados = $this->getPackageIds();
        } else {
            $this->paquetesSeleccionados = [];
        }
    }

    public function toggleSelectSingle($packageId)
    {
        if (in_array($packageId, $this->paquetesSeleccionados)) {
            $this->paquetesSeleccionados = array_diff($this->paquetesSeleccionados, [$packageId]);
        } else {
            $this->paquetesSeleccionados[] = $packageId;
        }
    }

    public function cambiarEstado()
    {
        // Obtener los paquetes seleccionados y actualizar su estado
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)
            ->when($this->selectedCity, function ($query) {
                $query->where('CUIDAD', $this->selectedCity);
            })
            ->get();

        foreach ($paquetesSeleccionados as $paquete) {
            if ($paquete) {
                $paquete->ESTADO = 'DESPACHO';
                $paquete->datedespachoclasificacion = now()->toDateTimeString();
                $paquete->save();
            }

            Event::create([
                'action' => 'DESPACHO',
                'descripcion' => 'Destino de Clasificacion hacia Ventanilla',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
            ]);
        }

        // Obtener la ciudad de origen
        $ciudadOrigen = auth()->user()->Regional;
        // Obtener la ciudad de destino
        $ciudadDestino = $paquetesSeleccionados->first()->CUIDAD;

        // Mapas de siglas
        $siglasOrigen = [
            'LA PAZ' => 'BOLPA',
            'COCHABAMBA' => 'BOCBA',
            'SANTA CRUZ' => 'BOSCA',
            'POTOSI' => 'BOPTA',
            'ORURO' => 'BOORA',
            'BENI' => 'BOBNA',
            'TARIJA' => 'BOTJA',
            'SUCRE' => 'BOSRA',
            'PANDO' => 'BOPNA',
        ];

        $siglasDestino = [
            'POTOSI' => 'BOPTA',
            'ORURO' => 'BOORA',
            'BENI' => 'BOBNA',
            'LA PAZ' => 'BOLPA',
            'COCHABAMBA' => 'BOCBA',
            'SANTA CRUZ' => 'BOSCA',
            'TARIJA' => 'BOTJA',
            'SUCRE' => 'BOSRA',
            'PANDO' => 'BOPNA',
        ];

        // Transformar las siglas
        $siglasOrigen = $siglasOrigen[$ciudadOrigen] ?? 'SIGLA DESCONOCIDA';
        $siglasDestino = $siglasDestino[$ciudadDestino] ?? 'SIGLA DESCONOCIDA';

        // Obtener el año del paquete (se asume que hay un campo 'created_at' o similar)
        $anioPaquete = $paquetesSeleccionados->first()->created_at->format('Y');

        // Generar el PDF con los paquetes seleccionados y las siglas
        $pdf = PDF::loadView('package.pdf.despachopdf', [
            'packages' => $paquetesSeleccionados,
            'siglasOrigen' => $siglasOrigen,
            'siglasDestino' => $siglasDestino,
            'ciudadOrigen' => $ciudadOrigen,
            'ciudadDestino' => $ciudadDestino,
            'anioPaquete' => $anioPaquete
        ]);
        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();


        toastr()->success('Data has been saved successfully!', 'Congrats');
        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho_Clasificacion.pdf');
    }
    public function eliminarPaquete($id)
    {
        // Encuentra el paquete
        $package = Package::find($id);

        // Verifica si el paquete existe
        if ($package) {
            $codigo = $package->CODIGO; // Obtiene el código antes de eliminar el paquete

            // Elimina el paquete permanentemente
            $package->forceDelete();

            // Crea el evento de eliminación
            Event::create([
                'action' => 'ESTADO',
                'descripcion' => 'Eliminación de Paquete',
                'user_id' => auth()->user()->id,
                'codigo' => $codigo,
            ]);

            // Mensaje de éxito
            session()->flash('success', 'Paquete Eliminado Con Éxito!');
        } else {
            // Mensaje de error si el paquete no existe
            session()->flash('error', 'Paquete no encontrado.');
        }
    }

    private function getPackageIds()
    {
        return Package::where('ESTADO', 'CLASIFICACION')->pluck('id')->toArray();
    }
    // Restores paquetes
    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}
