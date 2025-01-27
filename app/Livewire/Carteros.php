<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\International; // Importa el modelo International
use Livewire\WithPagination;
use App\Models\Event;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;

class Carteros extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $selectedPackageCode;
    public $estado;
    public $observaciones;
    public $firma;
    public $foto;

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
        // Verifica que el estado no está vacío
        if (empty($this->estado)) {
            session()->flash('error', 'Debe seleccionar un estado.');
            return;
        }

        // Verifica que la observación no esté vacía solo si el estado no es REPARTIDO
        if ($this->estado !== 'REPARTIDO' && empty($this->observaciones)) {
            session()->flash('error', 'Debe seleccionar una observación.');
            return;
        }

        // Busca el paquete con SoftDeletes
        $package = Package::withTrashed()->where('CODIGO', $this->selectedPackageCode)->first();

        if ($package) {
            // Actualiza los campos
            $package->ESTADO = $this->estado;

            // Solo actualizar OBSERVACIONES si el estado no es REPARTIDO
            if ($this->estado !== 'REPARTIDO') {
                $package->OBSERVACIONES = $this->observaciones;
            }

            // Guardar la firma si existe
            if (!empty($this->firma)) {
                $package->firma = $this->firma;
            }

            // Guardar la foto en base64 si existe
            if (!empty($this->foto)) {
                $package->foto = $this->foto; // Asigna el valor base64 al campo `foto`
            }

            // Aplica lógica según el estado
            if ($this->estado === 'REPARTIDO') {
                $package->save(); // Guarda primero los cambios
                $package->delete(); // Aplica soft delete después

                // Crear evento para REPARTIDO
                Event::create([
                    'action' => 'ENTREGADO',
                    'descripcion' => 'Entrega de paquete con Cartero',
                    'user_id' => auth()->user()->id,
                    'codigo' => $package->CODIGO,
                ]);
            } else {
                $package->save();
            }

            // Crear eventos adicionales según el estado
            if ($this->estado === 'RETORNO') {
                Event::create([
                    'action' => 'RETORNO',
                    'descripcion' => 'El Cartero Intento de Entrega por Cartero',
                    'user_id' => auth()->user()->id,
                    'codigo' => $package->CODIGO,
                ]);
                // Datos para el PDF
                $data = [
                    'package' => $package,
                    'user' => auth()->user()->name,
                    'estado' => $this->estado,
                    'observaciones' => $this->observaciones,
                    'fecha' => now()->format('Y-m-d H:i:s'),
                ];

                // Crear el PDF usando la vista 'paquetes.pdf.cn15'
                $pdf = PDF::loadView('package.pdf.cn15', compact('data'));

                // Descargar el archivo PDF
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->output();
                }, 'CN15.pdf');
                toastr()->success("SE NOTIFICÓ A ENCARGADO DE VENTANILLA");
            } elseif ($this->estado === 'PRE-REZAGO') {
                Event::create([
                    'action' => 'PRE-REZAGO',
                    'descripcion' => 'El Cartero devolvió el paquete a Ventanilla y Ingresó a Almacén',
                    'user_id' => auth()->user()->id,
                    'codigo' => $package->CODIGO,
                ]);
                toastr()->success("SE NOTIFICÓ A ENCARGADO DE REGIONAL");
            }
        } else {
            $internationalPackage = International::withTrashed()->where('CODIGO', $this->selectedPackageCode)->first();
            if ($internationalPackage) {
                $internationalPackage->ESTADO = $this->estado;

                // Solo actualizar OBSERVACIONES si el estado no es REPARTIDO
                if ($this->estado !== 'REPARTIDO') {
                    $internationalPackage->OBSERVACIONES = $this->observaciones;
                }

                // Guardar la firma si existe
                if (!empty($this->firma)) {
                    $internationalPackage->firma = $this->firma; // Asigna la firma al campo correspondiente
                }

                // Guardar la foto en base64 si existe
                if (!empty($this->foto)) {
                    $internationalPackage->foto = $this->foto; // Asigna la foto en base64 al campo correspondiente
                }

                if ($this->estado === 'REPARTIDO') {
                    $internationalPackage->save(); // Guarda primero los cambios
                    $internationalPackage->delete(); // Aplica soft delete después

                    // Crear evento para REPARTIDO
                    Event::create([
                        'action' => 'ENTREGADO',
                        'descripcion' => 'Entrega de paquete con Cartero',
                        'user_id' => auth()->user()->id,
                        'codigo' => $internationalPackage->CODIGO,
                    ]);
                } else {
                    $internationalPackage->save();
                }

                // Crear eventos adicionales según el estado
                if ($this->estado === 'RETORNO') {
                    Event::create([
                        'action' => 'DEVUELTO',
                        'descripcion' => 'El Cartero devolvió el paquete a Ventanilla',
                        'user_id' => auth()->user()->id,
                        'codigo' => $internationalPackage->CODIGO,
                    ]);
                    // Datos para el PDF
                    $data = [
                        'package' => $package,
                        'user' => auth()->user()->name,
                        'estado' => $this->estado,
                        'observaciones' => $this->observaciones,
                        'fecha' => now()->format('Y-m-d H:i:s'),
                    ];

                    // Crear el PDF usando la vista 'paquetes.pdf.cn15'
                    $pdf = PDF::loadView('package.pdf.cn15', compact('data'));

                    // Descargar el archivo PDF
                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'CN15.pdf');
                    toastr()->success("SE NOTIFICÓ A ENCARGADO DE VENTANILLA");
                } elseif ($this->estado === 'PRE-REZAGO') {
                    Event::create([
                        'action' => 'PRE-REZAGO',
                        'descripcion' => 'El Cartero devolvió el paquete a Ventanilla y Ingresó a Almacén',
                        'user_id' => auth()->user()->id,
                        'codigo' => $internationalPackage->CODIGO,
                    ]);
                    toastr()->success("SE NOTIFICÓ A ENCARGADO DE REGIONAL");
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
