<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;

class ClasificacionPackages extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';

    public function render()
    {
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
        // Obtener los paquetes seleccionados y actualizar su estado
        Package::whereIn('id', $this->paquetesSeleccionados)->update([
            'ESTADO' => 'DESPACHO',
            'datedespachoclasificacion' => now(), // Guardar la fecha de despacho actual
        ]);

        // Crear evento para cada paquete despachado
        foreach ($this->paquetesSeleccionados as $paqueteId) {
            $paquete = Package::find($paqueteId);

            if ($paquete) {
                // Crear evento para el paquete actual
                Event::create([
                    'action' => 'DESPACHO',
                    'descripcion' => 'Destino de Clasificacion hacia Ventanilla',
                    'user_id' => auth()->user()->id,
                    'codigo' => $paquete->CODIGO,
                ]);
            }
        }

        // Limpiar la selección
        $this->reset('paquetesSeleccionados');
    }

    private function getPackageIds()
    {
        return Package::where('ESTADO', 'CLASIFICACION')->pluck('id')->toArray();
    }

    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}

