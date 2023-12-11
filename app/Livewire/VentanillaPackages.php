<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use App\Models\Event;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class VentanillaPackages extends Component
{
    use WithPagination;

    public $search = '';

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
                    ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->where('CUIDAD', $userRegional)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.ventanilla-packages', [
            'packages' => $packages,
        ]);
    }

    // public function reencaminar($packageId)
    // {
    //     $package = Package::find($packageId);

    //     if ($package) {
    //         // Cambia el estado del paquete a "redirigido"
    //         $package->redirigido = true;
    //         Event::create([
    //             'action' => 'PRE-ENTREGA',
    //             'descripcion' => 'Correccion de Destino de paquete a Oficina Postal Regional',
    //             'user_id' => auth()->user()->id,
    //             'codigo' => $package->CODIGO,
    //         ]);

    //         $package->estado = 'REENCAMINADO';
    //         $package->date_redirigido = now();
    //         $package->save();

    //         // Emitir evento para abrir el modal
    //         $this->emit('abrirModal', [
    //             'codigo' => $package->CODIGO,
    //             'destinatario' => $package->DESTINATARIO,
    //             'cuidad' => $package->CUIDAD,
    //             'ventanilla' => $package->VENTANILLA,
    //         ]);

    //         return back()->with('success', 'Paquete se dio de Reencamino con éxito y cambió su estado a REENCAMINADO.');
    //     } else {
    //         return back()->with('error', 'No se pudo encontrar el paquete para redirigir.');
    //     }
    // }
}
