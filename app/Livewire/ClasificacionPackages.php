<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\Bag;
use App\Models\PackagesHasBag;
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
    public $findespacho = false;
    public $nroDespacho = '001';

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
            ->paginate(10);

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
        // Obtener el último NROSACA de la base de datos
        $ultimoSaco = Bag::max('NROSACA');

        // Incrementar el número de SACO solo si findespacho está marcado
        if ($this->findespacho) {
            $nroSaco = str_pad($ultimoSaco + 1, 4, '0', STR_PAD_LEFT);
        } else {
            if ($ultimoSaco === null) {
                $nroSaco = '0001'; // Si no hay ningún valor, comenzar desde '0001'
            } else {
                $nroSaco = $ultimoSaco; // Mantener el mismo número de SACO
            }
        }

        // Incrementar el número de despacho solo si findespacho no está marcado
        if (!$this->findespacho) {
            $ultimoDespacho = Bag::max('NRODESPACHO');
            $this->nroDespacho = str_pad($ultimoDespacho + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $this->nroDespacho = '0001'; // Resetear a '001' si findespacho está marcado
        }

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

        // Crear la nueva bolsa
        $bag = Bag::create([
            'NRODESPACHO' => $this->nroDespacho,
            'NROSACA' => $nroSaco, // Asignar el número de SACO
            'ESTADO' => 'APERTURA',
            'ano_creacion' => date('Y'),
            'created_at' => now(),
            'PAQUETES' => $paquetesSeleccionados->count(),
            'PESO' => $paquetesSeleccionados->sum('PESO'),
            'OFCAMBIO' => auth()->user()->Regional,
            'OFDESTINO' => $paquetesSeleccionados->first()->CUIDAD,
        ]);

        // Vincular los paquetes seleccionados con la bolsa
        foreach ($paquetesSeleccionados as $paquete) {
            // Crear la relación en la tabla pivote 'packages_has_bags'
            PackagesHasBag::create([
                'bags_id' => $bag->id,  // Usar el id de la bolsa creada
                'packages_id' => $paquete->id,
            ]);
        }

        // Restablecer la selección
        $this->resetSeleccion();

        // Generar el PDF con los paquetes seleccionados
        $pdf = PDF::loadView('package.pdf.despachopdf', ['packages' => $paquetesSeleccionados]);
        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();

        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho_Clasificacion.pdf');
    }


    private function getPackageIds()
    {
        return Package::where('ESTADO', 'CLASIFICACION')->pluck('id')->toArray();
    }

    // Restaurar selección
    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}
