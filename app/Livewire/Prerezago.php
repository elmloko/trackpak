<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Package;
use App\Models\International;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class Prerezago extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];

    public function mount()
    {
        // Registrar auditoría solo cuando el usuario ingresa por primera vez a la pestaña
        Event::create([
            'action' => 'INGRESO',
            'descripcion' => 'Usuario ingresó a la pestaña "Pre-Rezago de Paquetes"',
            'user_id' => auth()->user()->id,
            'codigo' => 0,
        ]);
    }

    public function render()
    {
        $packages = $this->getPackages();

        return view('livewire.prerezago', [
            'packages' => $packages,
        ]);
    }

    public function getPackages()
    {
        $packageQuery = Package::where('ESTADO', 'PRE-REZAGO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->select('id', 'CODIGO', 'DESTINATARIO', 'TELEFONO', 'CUIDAD', 'VENTANILLA', 'PESO', 'ESTADO', 'OBSERVACIONES', 'created_at');

        $internationalQuery = International::where('ESTADO', 'PRE-REZAGO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $this->search . '%');
            })
            ->select('id', 'CODIGO', 'DESTINATARIO', 'TELEFONO', 'CUIDAD', 'VENTANILLA', 'PESO', 'ESTADO', 'OBSERVACIONES', 'created_at');

        return $packageQuery->union($internationalQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->paquetesSeleccionados = $this->getPackages()->pluck('id')->toArray();
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
        if (count($this->paquetesSeleccionados) > 0) {
            // Actualizar el estado en la tabla Package
            Package::whereIn('id', $this->paquetesSeleccionados)->update([
                'ESTADO' => 'REZAGO',
                'daterezago' => now(),
            ]);

            // Actualizar el estado en la tabla International
            International::whereIn('id', $this->paquetesSeleccionados)->update([
                'ESTADO' => 'REZAGO',
                'updated_at' => now(),
            ]);

            // Crear un evento para cada paquete actualizado en Package
            foreach ($this->paquetesSeleccionados as $packageId) {
                $paquete = Package::find($packageId);

                if ($paquete) {
                    Event::create([
                        'action' => 'ALMACEN',
                        'descripcion' => 'Destino de Ventanilla hacia Almacen',
                        'user_id' => auth()->user()->id,
                        'codigo' => $paquete->CODIGO,
                    ]);
                }
            }

            // Crear un evento para cada paquete actualizado en International
            foreach ($this->paquetesSeleccionados as $packageId) {
                $paqueteInternacional = International::find($packageId);

                if ($paqueteInternacional) {
                    Event::create([
                        'action' => 'ALMACEN',
                        'descripcion' => 'Destino de Ventanilla hacia Almacen',
                        'user_id' => auth()->user()->id,
                        'codigo' => $paqueteInternacional->CODIGO,
                    ]);
                }
            }

            // Combinar los paquetes de ambos modelos
            $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)->get()
                ->merge(International::whereIn('id', $this->paquetesSeleccionados)->get());

            // Generar el PDF con los paquetes seleccionados
            $pdf = PDF::loadView('package.pdf.prerezago', ['packages' => $paquetesSeleccionados]);

            // Obtener el contenido del PDF
            $pdfContent = $pdf->output();

            // Restablecer la selección
            $this->resetSeleccion();

            // Generar una respuesta con el contenido del PDF para descargar
            return response()->streamDownload(function () use ($pdfContent) {
                echo $pdfContent;
            }, 'Paquetes_Prerezago.pdf');
        } else {
            session()->flash('error', 'No hay paquetes seleccionados para almacenar.');
        }
    }
    public function devolverPaquete($packageId)
    {
        // Intentar encontrar el paquete en la tabla Package
        $paquete = Package::find($packageId);
        if ($paquete) {
            $paquete->update([
                'ESTADO' => 'VENTANILLA',
                'updated_at' => now(),
            ]);

            Event::create([
                'action' => 'DEVOLUCION',
                'descripcion' => 'Devolución a Ventanilla',
                'user_id' => auth()->user()->id,
                'codigo' => $paquete->CODIGO,
            ]);

            session()->flash('success', 'El paquete ha sido devuelto a Ventanilla.');
            return;
        }

        // Intentar encontrar el paquete en la tabla International
        $paqueteInternacional = International::find($packageId);
        if ($paqueteInternacional) {
            $paqueteInternacional->update([
                'ESTADO' => 'VENTANILLA',
                'updated_at' => now(),
            ]);

            Event::create([
                'action' => 'DEVOLUCION',
                'descripcion' => 'Devolución a Ventanilla',
                'user_id' => auth()->user()->id,
                'codigo' => $paqueteInternacional->CODIGO,
            ]);

            session()->flash('success', 'El paquete ha sido devuelto a Ventanilla.');
        } else {
            session()->flash('error', 'Paquete no encontrado.');
        }
    }



    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }

    public function updatedSearch()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = array_intersect($this->paquetesSeleccionados, $this->getPackages()->pluck('id')->toArray());
    }
}
