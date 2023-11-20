<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class VentanillaPackages extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        
        $packages = Package::where('ESTADO', 'VENTANILLA')
        ->when($this->search, function ($query) {
            $query->where('CODIGO', 'like', '%' . $this->search . '%')
                ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
            ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
            ->orWhere('PAIS', 'like', '%' . $this->search . '%')
            ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
            ->orWhere('ZONA', 'like', '%' . $this->search . '%')
            ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
            ->orWhere('PESO', 'like', '%' . $this->search . '%')
            ->orWhere('TIPO', 'like', '%' . $this->search . '%')
            ->orWhere('ADUANA', 'like', '%' . $this->search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(2);


        // $packages = $packages->map(function ($item) {
        //     return $item->only([
        //         'CODIGO',
        //         'DESTINATARIO',
        //         'TELEFONO',
        //         'PAIS',
        //         'CIUDAD',
        //         'ZONA',
        //         'VENTANILLA',
        //         'PESO',
        //         'TIPO',
        //         'ADUANA',
        //     ]);
        // });
        // Log::info(print_r($packages,true));
        /*

        ["
            '0'(
                'codig' => "CODIGO1"
                destin...
            ),
            '1'(
                ....
            )
        
        ]
        */
           /*where('CODIGO', 'like', '%' . $this->search . '%')
            ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
            ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
            ->orWhere('PAIS', 'like', '%' . $this->search . '%')
            ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
            ->orWhere('ZONA', 'like', '%' . $this->search . '%')
            ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
            ->orWhere('PESO', 'like', '%' . $this->search . '%')
            ->orWhere('TIPO', 'like', '%' . $this->search . '%')
            ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
            ->orWhere('created_at', 'like', '%' . $this->search . '%')*/
       
           // ->take(5)
            //->get();

            //Log::info(print_r($packages->count(),true));


        return view('livewire.ventanilla-packages', [
            'packages' => $packages,
        ]);
    }
}




