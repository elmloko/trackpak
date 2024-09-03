<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International; // Importa el modelo International
use Livewire\WithPagination;

class Carteros extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedPackageCode;
    public $estado;
    public $observaciones;

    public function render()
    {
        $userRegional = auth()->user()->Regional;
        $userasignado = auth()->user()->name;

        // Define las columnas que deben ser seleccionadas en ambas consultas
        $columns = [
            'CODIGO',
            'DESTINATARIO',
            'TELEFONO',
            'ADUANA',
            'created_at',
            'ESTADO',
            'usercartero',
            'PESO',
            'TIPO'
        ];

        // Consulta para obtener paquetes de la tabla Package
        $packages = Package::select($columns)
            ->where('ESTADO', 'CARTERO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->where('usercartero', $userasignado)
            ->orderBy('created_at', 'desc');

        // Consulta para obtener paquetes de la tabla International
        $internationalPackages = International::select($columns)
            ->where('ESTADO', 'CARTERO')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->where('usercartero', $userasignado)
            ->orderBy('created_at', 'desc');

        // Une ambos conjuntos de resultados
        $packages = $packages->union($internationalPackages)->paginate(10);

        return view('livewire.carteros', [
            'packages' => $packages,
        ]);
    }
    public function openModal($codigo)
    {
        $package = Package::withTrashed()->where('CODIGO', $codigo)->first();
        if ($package) {
            $this->selectedPackageCode = $codigo;
            $this->estado = $package->ESTADO;
            $this->observaciones = $package->OBSERVACIONES;
        } else {
            $internationalPackage = International::withTrashed()->where('CODIGO', $codigo)->first();
            if ($internationalPackage) {
                $this->selectedPackageCode = $codigo;
                $this->estado = $internationalPackage->ESTADO;
                $this->observaciones = $internationalPackage->OBSERVACIONES;
            }
        }

        $this->dispatch('show-modal');
    }

    public function saveChanges()
    {
        // Verifica que las propiedades de estado y observaciones no están vacías
        if (empty($this->estado) || empty($this->observaciones)) {
            session()->flash('error', 'Debe seleccionar un estado y una observación.');
            return;
        }

        // Busca el paquete con SoftDeletes
        $package = Package::withTrashed()->where('CODIGO', $this->selectedPackageCode)->first();

        if ($package) {
            // Actualiza los campos
            $package->ESTADO = $this->estado;
            $package->OBSERVACIONES = $this->observaciones;

            // Aplica lógica según el estado
            if ($this->estado === 'REPARTIDO') {
                $package->save(); // Guarda primero los cambios
                $package->delete(); // Aplica soft delete después
            } else {
                $package->save();
            }
        } else {
            $internationalPackage = International::withTrashed()->where('CODIGO', $this->selectedPackageCode)->first();
            if ($internationalPackage) {
                $internationalPackage->ESTADO = $this->estado;
                $internationalPackage->OBSERVACIONES = $this->observaciones;

                if ($this->estado === 'REPARTIDO') {
                    $internationalPackage->save(); // Guarda primero los cambios
                    $internationalPackage->delete(); // Aplica soft delete después
                } else {
                    $internationalPackage->save();
                }
            } else {
                session()->flash('error', 'Paquete no encontrado.');
                return;
            }
        }

        session()->flash('success', 'El paquete ha sido actualizado correctamente.');

        // Cierra el modal
        $this->dispatch('close-modal');
    }
}
