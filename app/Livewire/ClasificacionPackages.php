<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
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

        // Obtener la ciudad de origen
        $ciudadOrigen = auth()->user()->Regional;
        // Obtener la ciudad de destino
        $ciudadDestino = $paquetesSeleccionados->first()->CUIDAD;

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

        // Generar una respuesta con el contenido del PDF para descargar
        return response()->streamDownload(function () use ($pdfContent) {
            echo $pdfContent;
        }, 'Despacho_Clasificacion.pdf');
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
}
// <?php

// namespace App\Livewire;

// use Livewire\Component;
// use App\Models\Package;
// use App\Models\Bag;
// use App\Models\PackagesHasBag;
// use Livewire\WithPagination;
// use App\Models\Event;
// use Barryvdh\DomPDF\Facade\Pdf;

// class ClasificacionPackages extends Component
// {
//     use WithPagination;

//     public $search = '';
//     public $selectAll = false;
//     public $paquetesSeleccionados = [];
//     public $selectedCity = '';
//     public $findespacho = false;
//     public $lastBag;

//     public function render()
//     {
//         $userasignado = auth()->user()->name;
//         $packages = Package::where('ESTADO', 'CLASIFICACION')
//             ->when($this->search, function ($query) {
//                 $query->where('CODIGO', 'like', '%' . $this->search . '%')
//                     ->orWhere('DESTINATARIO', 'like', '%' . $this->search . '%')
//                     ->orWhere('TELEFONO', 'like', '%' . $this->search . '%')
//                     ->orWhere('PAIS', 'like', '%' . $this->search . '%')
//                     ->orWhere('CUIDAD', 'like', '%' . $this->search . '%')
//                     ->orWhere('VENTANILLA', 'like', '%' . $this->search . '%')
//                     ->orWhere('TIPO', 'like', '%' . $this->search . '%')
//                     ->orWhere('ADUANA', 'like', '%' . $this->search . '%')
//                     ->orWhere('created_at', 'like', '%' . $this->search . '%');
//             })
//             ->when($this->selectedCity, function ($query) {
//                 $query->where('CUIDAD', $this->selectedCity);
//             })
//             // ->where('CUIDAD', 'LA PAZ')
//             // ->where('usercartero', $userasignado)
//             ->orderBy('created_at', 'desc')
//             ->paginate(200);

//         // Recuperar el último registro de bolsa
//         $this->lastBag = Bag::latest()->first();

//         return view('livewire.clasificacion-packages', [
//             'packages' => $packages,
//             'lastBag' => $this->lastBag, // Pasar el último registro de bolsa a la vista
//         ]);
//     }

//     public function toggleSelectAll()
//     {
//         if ($this->selectAll) {
//             $this->paquetesSeleccionados = $this->getPackageIds();
//         } else {
//             $this->paquetesSeleccionados = [];
//         }
//     }

//     public function toggleSelectSingle($packageId)
//     {
//         if (in_array($packageId, $this->paquetesSeleccionados)) {
//             $this->paquetesSeleccionados = array_diff($this->paquetesSeleccionados, [$packageId]);
//         } else {
//             $this->paquetesSeleccionados[] = $packageId;
//         }
//     }

//     public function cambiarEstado()
//     {

//         // Obtener el último registro de bolsa
//         $lastBag = Bag::latest()->first();

//         // Determinar el valor de NRODESPACHO
//         $nroDespacho = '';

//         if ($lastBag) {
//             if ($lastBag->FIN == 'F') {
//                 // Incrementar el número de despacho si el último registro tiene FIN = 'F'
//                 $nroDespacho = str_pad($lastBag->NRODESPACHO + 1, 4, '0', STR_PAD_LEFT);
//             } else {
//                 // Mantener el número de despacho si el último registro tiene FIN = 'N'
//                 $nroDespacho = str_pad($lastBag->NRODESPACHO, 4, '0', STR_PAD_LEFT);
//             }
//         } else {
//             // Si no hay registros anteriores, iniciar con '0000'
//             $nroDespacho = '0001';
//         }

//         // Determinar el valor de NROSACA
//         $nroSaca = '';

//         if ($lastBag) {
//             if ($lastBag->FIN == 'F') {
//                 // Reiniciar el número de saca si el último registro tiene FIN = 'F'
//                 $nroSaca = '0001';
//             } else {
//                 // Incrementar el número de saca si el último registro tiene FIN = 'N'
//                 $nroSaca = str_pad($lastBag->NROSACA + 1, 4, '0', STR_PAD_LEFT);
//             }
//         } else {
//             // Si no hay registros anteriores, iniciar con '0000'
//             $nroSaca = '0001';
//         }

//         // Obtener los paquetes seleccionados y actualizar su estado
//         $paquetesSeleccionados = Package::whereIn('id', $this->paquetesSeleccionados)
//             ->when($this->selectedCity, function ($query) {
//                 $query->where('CUIDAD', $this->selectedCity);
//             })
//             ->get();

//         foreach ($paquetesSeleccionados as $paquete) {
//             if ($paquete) {
//                 $paquete->ESTADO = 'DESPACHO';
//                 $paquete->datedespachoclasificacion = now()->toDateTimeString();
//                 $paquete->save();
//             }

//             Event::create([
//                 'action' => 'DESPACHO',
//                 'descripcion' => 'Destino de Clasificacion hacia Ventanilla',
//                 'user_id' => auth()->user()->id,
//                 'codigo' => $paquete->CODIGO,
//             ]);
//         }

//         // Determinar el valor de FIN
//         $finValue = $this->findespacho ? 'F' : 'N';

//         // Definir las siglas
//         $siglasOrigen = [
//             'LA PAZ' => 'BOLPA',
//             'COCHABAMBA' => 'BOCBA',
//             'SANTA CRUZ' => 'BOSCA',
//             'POTOSI' => 'BOPTA',
//             'ORURO' => 'BOORA',
//             'BENI' => 'BOBNA',
//             'TARIJA' => 'BOTJA',
//             'SUCRE' => 'BOSRA',
//             'PANDO' => 'BOPNA',
//         ];

//         $siglasDestino = [
//             'POTOSI' => 'BOPTA',
//             'ORURO' => 'BOORA',
//             'BENI' => 'BOBNA',
//             'LA PAZ' => 'BOLPA',
//             'COCHABAMBA' => 'BOCBA',
//             'SANTA CRUZ' => 'BOSCA',
//             'TARIJA' => 'BOTJA',
//             'SUCRE' => 'BOSRA',
//             'PANDO' => 'BOPNA',
//         ];

//         // Obtener la ciudad de origen
//         $ciudadOrigen = auth()->user()->Regional;

//         // Obtener la ciudad de destino
//         $ciudadDestino = $paquetesSeleccionados->first()->CUIDAD;

//         // Transformar las siglas
//         $siglasOrigen = $siglasOrigen[$ciudadOrigen];
//         $siglasDestino = $siglasDestino[$ciudadDestino];

//         $pesoTotal = $paquetesSeleccionados->sum('PESO');

//         // Convertir el peso total a un entero manteniendo los ceros
//         $pesoEntero = str_pad(str_replace('.', '', $pesoTotal), 4, '0', STR_PAD_LEFT);

//         $marbete = $siglasOrigen . $siglasDestino . 'B' . 'UN' . substr(date('Y'), 3, 1) . $nroDespacho;
//         $receptaculo = $siglasOrigen . $siglasDestino . 'B' . 'UN' . substr(date('Y'), 3, 1) . $nroDespacho . $nroSaca . $pesoEntero;

//         // Crear la nueva bolsa
//         $bag = Bag::create([
//             'NRODESPACHO' => $nroDespacho,
//             'NROSACA' => $nroSaca,
//             'ESTADO' => 'APERTURA',
//             'ano_creacion' => date('Y'),
//             'created_at' => now(),
//             'PAQUETES' => $paquetesSeleccionados->count(),
//             'PESO' => $paquetesSeleccionados->sum('PESO'),
//             'OFCAMBIO' => auth()->user()->Regional,
//             'OFDESTINO' => $paquetesSeleccionados->first()->CUIDAD,
//             'FIN' => $finValue,
//             'OFCAM108' => $siglasOrigen,
//             'OFDES108' => $siglasDestino,
//             'MARBETE' => $marbete,
//             'RECEPTACULO' => $receptaculo,
//             'TIPO' => 'U',
//             'T' => '0',
//             'userbags' => auth()->user()->name,
//         ]);
//         Event::create([
//             'action' => 'APERTURA',
//             'descripcion' => 'Saca creada y llevada a Expedicion, Despacho ' . $bag->MARBETE . ' e Impreso CN33',
//             'user_id' => auth()->user()->id,
//             'codigo' => $bag->RECEPTACULO,
//         ]);

//         // Vincular los paquetes seleccionados con la bolsa
//         foreach ($paquetesSeleccionados as $paquete) {
//             // Crear la relación en la tabla pivote 'packages_has_bags'
//             PackagesHasBag::create([
//                 'bags_id' => $bag->id,  // Usar el id de la bolsa creada
//                 'packages_id' => $paquete->id,
//             ]);
//         }

//         // Restablecer la selección
//         $this->resetSeleccion();

//         // Generar el PDF con los paquetes seleccionados
//         $pdf = PDF::loadView('package.pdf.despachopdf', ['packages' => $paquetesSeleccionados, 'bag' => $bag]);
//         $pdfContent = $pdf->output();

//         // Generar una respuesta con el contenido del PDF para descargar
//         return response()->streamDownload(function () use ($pdfContent) {
//             echo $pdfContent;
//         }, 'Despacho_Clasificacion.pdf');
//     }

//     private function getPackageIds()
//     {
//         return Package::where('ESTADO', 'CLASIFICACION')->pluck('id')->toArray();
//     }

//     // Restaurar selección
//     private function resetSeleccion()
//     {
//         $this->selectAll = false;
//         $this->paquetesSeleccionados = [];
//     }
// }