<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RegistrosExport;
use Maatwebsite\Excel\Facades\Excel;

class ClasificacionPackages extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';
    public $showModal = false;
    public $codigoManifiesto;

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

        // Obtener el último número de manifiesto registrado
        $ultimoManifiesto = Package::whereNotNull('manifiesto')
            ->latest('manifiesto')
            ->value('manifiesto');

        // Extraer el número y generar el siguiente manifiesto
        $nuevoManifiesto = $ultimoManifiesto
            ? 'A' . str_pad((int)substr($ultimoManifiesto, 1) + 1, 7, '0', STR_PAD_LEFT)
            : 'A0000001';

        foreach ($paquetesSeleccionados as $paquete) {
            if ($paquete) {
                $paquete->ESTADO = 'DESPACHO';
                $paquete->datedespachoclasificacion = now()->toDateTimeString();
                // Asignar el mismo manifiesto a todos los paquetes seleccionados
                $paquete->manifiesto = $nuevoManifiesto;
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
        $ventanilla = $paquetesSeleccionados->first()->VENTANILLA ?? 'Desconocida';
        $cuidad = $paquetesSeleccionados->first()->CUIDAD ?? 'Desconocida';

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

        toastr()->success("SE NOTIFICÓ A REGIONAL. {$cuidad}{$ventanilla}");

        // Emitimos un evento para refrescar la página
        $this->redirect('/packages/clasificacion');

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
    // Abre el modal
    public function abrirModal()
    {
        $this->showModal = true;
    }

    // Cierra el modal
    public function cerrarModal()
    {
        $this->showModal = false;
        $this->codigoManifiesto = '';
    }

    // Generar PDF usando el código de Manifiesto ingresado
    public function generarPDF()
    {
        // Validamos que se haya ingresado un manifiesto
        if (!$this->codigoManifiesto) {
            session()->flash('error', 'Por favor ingrese un código de Manifiesto.');
            return;
        }

        // Buscamos paquetes con ese manifiesto
        $paquetesSeleccionados = Package::withTrashed()
            ->where('manifiesto', $this->codigoManifiesto)
            ->get();


        if ($paquetesSeleccionados->isEmpty()) {
            session()->flash('error', 'No se encontraron paquetes con ese código de Manifiesto.');
            return;
        }

        // Obtener la ciudad de origen y destino del primer paquete
        $ciudadOrigen  = auth()->user()->Regional;
        $ciudadDestino = $paquetesSeleccionados->first()->CUIDAD ?? 'Desconocida';

        // Mapas de siglas
        $siglasOrigenMap = [
            'LA PAZ'        => 'BOLPA',
            'COCHABAMBA'    => 'BOCBA',
            'SANTA CRUZ'    => 'BOSCA',
            'POTOSI'        => 'BOPTA',
            'ORURO'         => 'BOORA',
            'BENI'          => 'BOBNA',
            'TARIJA'        => 'BOTJA',
            'SUCRE'         => 'BOSRA',
            'PANDO'         => 'BOPNA',
        ];
        $siglasDestinoMap = [
            'POTOSI'        => 'BOPTA',
            'ORURO'         => 'BOORA',
            'BENI'          => 'BOBNA',
            'LA PAZ'        => 'BOLPA',
            'COCHABAMBA'    => 'BOCBA',
            'SANTA CRUZ'    => 'BOSCA',
            'TARIJA'        => 'BOTJA',
            'SUCRE'         => 'BOSRA',
            'PANDO'         => 'BOPNA',
        ];

        $siglasOrigen  = $siglasOrigenMap[$ciudadOrigen] ?? 'SIGLA DESCONOCIDA';
        $siglasDestino = $siglasDestinoMap[$ciudadDestino] ?? 'SIGLA DESCONOCIDA';

        // Año del primer paquete despachado
        $anioPaquete = optional($paquetesSeleccionados->first()->created_at)->format('Y');

        // Creamos el PDF
        $pdf = Pdf::loadView('package.pdf.despachopdf', [
            'packages'      => $paquetesSeleccionados,
            'siglasOrigen'  => $siglasOrigen,
            'siglasDestino' => $siglasDestino,
            'ciudadOrigen'  => $ciudadOrigen,
            'ciudadDestino' => $ciudadDestino,
            'anioPaquete'   => $anioPaquete
        ]);

        $pdfContent = $pdf->output();

        // Cerramos el modal
        $this->cerrarModal();

        // Retornamos la descarga
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Manifiesto_' . $this->codigoManifiesto . '.pdf');
    }
    public function exportExcel()
    {
        return Excel::download(new RegistrosExport($this->search, $this->selectedCity), 'Clasificacion Registros.xlsx');
    }
}
