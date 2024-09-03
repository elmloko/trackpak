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
        $package = Package::withTrashed()->where('CODIGO', $this->selectedPackageCode)->first();

        if ($package) {
            $package->ESTADO = $this->estado;
            $package->OBSERVACIONES = $this->observaciones;

            // Aplica lógica según el estado
            if ($this->estado === 'REPARTIDO') {
                $package->save(); // Guarda primero los cambios
                $package->delete(); // Aplica soft delete después
            } elseif ($this->estado === 'RETORNO') {
                $package->save();
            } elseif ($this->estado === 'PRE-REZAGO') {
                $package->save();
            }
        } else {
            $internationalPackage = International::withTrashed()->where('CODIGO', $this->selectedPackageCode)->first();
            if ($internationalPackage) {
                $internationalPackage->ESTADO = $this->estado;
                $internationalPackage->OBSERVACIONES = $this->observaciones;

                // Aplica lógica según el estado
                if ($this->estado === 'REPARTIDO') {
                    $internationalPackage->save(); // Guarda primero los cambios
                    $internationalPackage->delete();
                } elseif ($this->estado === 'RETORNO') {
                    $internationalPackage->save();
                } elseif ($this->estado === 'PRE-REZAGO') {
                    $internationalPackage->save();
                }
            }
        }

        session()->flash('success', 'El paquete ha sido actualizado correctamente.');

        // Cierra el modal
        $this->dispatch('close-modal');
    }
}
