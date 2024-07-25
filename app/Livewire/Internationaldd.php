<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\International;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DdcImport;

class Internationaldd extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $selectAll = false;
    public $paquetesSeleccionados = [];
    public $selectedCity = '';
    public $file; // Agregar esta línea

    public function render()
    {
        $userRegional = auth()->user()->Regional;

        $international = International::where('ESTADO', 'VENTANILLA')
            ->when($this->search, function ($query) {
                $query->where('CODIGO', 'like', '%' . $this->search . '%')
                    ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
                    ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
                    ->orWhere('ZONA', 'like', $this->search . '%') 
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) use ($userRegional) {
                $query->where(function ($subQuery) {
                    $subQuery->where('VENTANILLA', 'DD');
                        // ->orWhere('VENTANILLA', 'DND');
                })
                ->where('CUIDAD', $userRegional);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

            return view('livewire.internationaldd', [
                'internationals' => $international,
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
        $paquetesSeleccionados = International::whereIn('id', $this->paquetesSeleccionados)
            ->when($this->selectedCity, function ($query) {
                $query->where('CUIDAD', $this->selectedCity);
            })
            ->get();
    
        // Determinar el formulario según una condición
        $formulario = ($paquetesSeleccionados->first()->ADUANA == 'SI') ? 'package.pdf.formularioentrega' : 'package.pdf.formularioentrega2';
    
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
        $pdf = PDF::loadView($formulario, ['packages' => $paquetesSeleccionados]);
    
        // Obtener el contenido del PDF
        $pdfContent = $pdf->output();
    
        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Formulario Certificado DD.pdf');
    }    

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        Excel::import(new DdcImport, $this->file->path());

        session()->flash('message', 'Archivo importado exitosamente.');
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
        return International::where('ESTADO', 'VENTANILLA')->pluck('id')->toArray();
    }
    // Restores paquetes
    private function resetSeleccion()
    {
        $this->selectAll = false;
        $this->paquetesSeleccionados = [];
    }
}
