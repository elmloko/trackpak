<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\Bag;
use Livewire\WithPagination;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class ClasificacionPackages extends Component
{
    use WithPagination;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $findespacho = false;
    public $numeroSacaFormatado = 1; // Inicializamos el número de saca en 1
    public $numeroDespachoFormatado = '001'; // Inicializamos el número de despacho en 001

    public function render()
    {
        $packages = Package::where('ESTADO', 'CLASIFICACION')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('PAIS', 'like', '%' . $this->search . '%')
                    ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
                    ->orWhere('TIPO', 'like', '%' . $this->search . '%')
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
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
        // Incrementar el número de sacas solo cuando se hace clic en "Despachar"
        $this->numeroSacaFormatado++;

        // Obtener el estado actual del checkbox "Finalizar despacho"
        $findespacho = $this->findespacho;

        // Reiniciar el número de sacas y el número de despacho si se marca el checkbox "Finalizar despacho"
        if ($findespacho) {
            $this->numeroSacaFormatado = 1;
            $this->numeroDespachoFormatado = 1;
        } else {
            // Incrementar el número de despacho solo si el checkbox no está marcado
            $this->numeroDespachoFormatado++;
        }

        // Formatear el número de despacho
        $nuevoNumeroDespachoFormatado = str_pad($this->numeroDespachoFormatado, 3, '0', STR_PAD_LEFT);

        // Calcular el número de saca actualizado
        $numeroSacaFormatado = str_pad($this->numeroSacaFormatado, 3, '0', STR_PAD_LEFT);

        // Obtener los paquetes seleccionados y actualizar su estado
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)
            ->where('ESTADO', 'CLASIFICACION')
            ->get();

        // Iterar sobre los paquetes seleccionados y realizar acciones
        foreach ($paquetesSeleccionados as $paquete) {
            // Procesar el paquete utilizando la función auxiliar
            $this->procesarPaquete($paquete, $nuevoNumeroDespachoFormatado, $numeroSacaFormatado);

            // Actualizar el estado del paquete
            $paquete->ESTADO = 'DESPACHADO';
            $paquete->save();
        }

        // Restablecer la selección
        $this->resetSeleccion();

        // Generar y descargar el PDF con los paquetes seleccionados
        return $this->generarYDescargarPDF($paquetesSeleccionados);
    }

    protected function procesarPaquete($paquete, $nuevoNumeroDespachoFormatado, $numeroSacaFormatado)
    {
        // Calcular el código de despacho
        $codigoDespacho = $nuevoNumeroDespachoFormatado . '/' . $numeroSacaFormatado;

        // Obtener los paquetes seleccionados y actualizar su estado
        $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)
        ->where('ESTADO', 'CLASIFICACION')
        ->get();
        // Contar el número de paquetes seleccionados
        $numeroPaquetesSeleccionados = count($paquetesSeleccionados);
        // Crear un evento para el despacho
        Event::create([
            'action' => 'DESPACHO',
            'descripcion' => 'Destino de Clasificacion hacia Ventanilla',
            'user_id' => auth()->user()->id,
            'codigo' => $codigoDespacho,
        ]);

        // Obtener la ciudad del paquete
        $ciudad = $paquete->CUIDAD;

        // Crear o actualizar la bolsa de despacho
        Bag::updateOrCreate(
            [
                'OFDESTINO' => $ciudad, // Actualizar OFDESTINO con la ciudad del paquete
                'NRODESPACHO' => $codigoDespacho,
            ],
            [
                'PAQUETES' => $numeroPaquetesSeleccionados,
                'OFCAMBIO' => auth()->user()->Regional,
                'ESTADO' => 'APERTURA',
                'ano_creacion' => now()->year, // Asignando el año actual como valor para 'ano_creacion'
            ]
        );
    }

    protected function generarYDescargarPDF($paquetesSeleccionados)
    {
        $pdf = PDF::loadView('package.pdf.despachopdf', ['packages' => $paquetesSeleccionados]);
        $pdfContent = $pdf->output();

        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho_Clasificacion.pdf');
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

    public function contarPaquetesSeleccionados()
    {
        return count($this->paquetesSeleccionados);
    }
}
