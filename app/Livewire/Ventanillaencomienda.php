<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class Ventanillaencomienda extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        $packages = Package::where('ESTADO', 'VENTANILLA')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) use ($userRegional) {
                $query->where(function ($subQuery) {
                    $subQuery->where('VENTANILLA', 'ENCOMIENDAS');
                })
                    ->where('CUIDAD', $userRegional);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.ventanillaencomienda', [
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
    public function cambiarEstado()
    {
        // Obtener los paquetes seleccionados y actualizar su estado
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)
            ->when($this->selectedCity, function ($query) {
                $query->where('CUIDAD', $this->selectedCity);
            })
            ->get();


        foreach ($paquetesSeleccionados as $paquete) {
            // Calcular el precio basado en el peso del paquete
            $peso = $paquete->PESO;
            if ($peso >= 0.000 && $peso <= 0.5) {
                $precio = 5;
            } elseif ($peso > 0.5) {
                $precio = 10;
            }

            // Actualizar el precio del paquete
            $paquete->PRECIO = $precio;
            $paquete->save();

            // Actualizar el estado del paquete
            $paquete->ESTADO = 'ENTREGADO';
            $paquete->save();
            $paquete->delete();

            // Crear un evento
            Event::create([
                'action' => 'ENTREGADO',
                'descripcion' => 'Entrega de paquete en ventanilla en Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
            ]);
        }

        // Restablecer la selección
        $this->resetSeleccion();

        // Generar el PDF con los paquetes seleccionados
        $pdf = PDF::loadView('package.pdf.deleteadoencomiendaspdf', ['packages' => $paquetesSeleccionados]);
        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();

        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho Encomiendas.pdf');
    }

    public function toggleSelectSingle($packageId)
    {
        if (in_array($packageId, $this->paquetesSeleccionados)) {
            $this->paquetesSeleccionados = array_diff($this->paquetesSeleccionados, [$packageId]);
        } else {
            $this->paquetesSeleccionados[] = $packageId;
        }
    }
    private function getPackageIds()
    {
        return Package::where('ESTADO', 'VENTANILLA')->pluck('id')->toArray();
    }
    // Restores paquetes
    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}
