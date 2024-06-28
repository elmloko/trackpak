<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\Event;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class BagController extends Controller
{

    public function index()
    {
        return view('bag.index');
    }

    public function create()
    {
        $bag = new Bag();
        return view('bag.create', compact('bag'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'NRODESPACHO' => 'required|numeric',
            'OFDESTINO' => 'required|string',
        ]);

        // Formatear el campo NRODESPACHO con ceros a la izquierda
        $nroDespacho = str_pad($request->input('NRODESPACHO'), 4, '0', STR_PAD_LEFT);

        // Definir las siglas de origen y destino
        $siglas = [
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

        // Obtener la ciudad de origen y destino
        $ciudadOrigen = auth()->user()->Regional;
        $ciudadDestino = $request->input('OFDESTINO');

        // Verificar si la ciudad de origen y destino existen en las siglas
        if (!isset($siglas[$ciudadOrigen]) || !isset($siglas[$ciudadDestino])) {
            return redirect()->back()->withErrors('Ciudad de origen o destino no válidas.');
        }

        // Transformar las siglas
        $siglasOrigen = $siglas[$ciudadOrigen];
        $siglasDestino = $siglas[$ciudadDestino];

        $marbete = $siglasOrigen . $siglasDestino . 'B' . 'UN' . substr(date('Y'), 3, 1) . $nroDespacho;

        // Crear la nueva instancia de Bag y guardar en la base de datos
        $bag = new Bag([
            'NRODESPACHO' => $nroDespacho,
            'OFCAMBIO' => $ciudadOrigen,
            'OFDESTINO' => $ciudadDestino,
            'ESTADO' => 'APERTURA',
            'T' => '0',
            'userbags' => auth()->user()->name,
            'ano_creacion' => date('Y'),
            'created_at' => now(),
            'OFCAM108' => $siglasOrigen,
            'OFDES108' => $siglasDestino,
            'MARBETE' => $marbete,
            'first' => '1',
        ]);

        $bag->save();

        return redirect()->route('bags.bagsclose')
            ->with('success', 'Bag created successfully.');
    }

    public function show($id)
    {
        // Obtener la bolsa según el ID
        $bag = Bag::findOrFail($id);

        // Pasar el ID de la bolsa a la vista
        return view('bag.show', ['bagId' => $id]);
    }
    public function edit($id)
    {
        $bag = Bag::find($id);

        return view('bag.edit', compact('bag'));
    }

    public function update(Request $request, Bag $bag)
    {
        request()->validate(Bag::$rules);

        $bag->update($request->all());

        return redirect()->route('bags.index')
            ->with('success', 'Bag updated successfully');
    }

    public function destroy($id)
    {
        $bag = Bag::find($id)->delete();

        return redirect()->route('bags.index')
            ->with('success', 'Bag deleted successfully');
    }
    public function closeExpedition($id, Request $request)
    {
        $bag = Bag::find($id);

        // Verifica si la bolsa existe
        if (!$bag) {
            return redirect()->route('bags.index')
                ->with('success', 'El despacho no se pudo cerrar');
        }
        // Actualiza los campos adicionales
        $bag->update([
            'PESOF' => $request->input('PESOF'),
            'ITINERARIO' => $request->input('ITINERARIO'),
            'OBSERVACIONES' => $request->input('OBSERVACIONES'),
            'ESTADO' => 'CIERRE',
            'userbags' => auth()->user()->name,
        ]);
        Event::create([
            'action' => 'PROCESADO',
            'descripcion' => 'Saca Generada Marbete ' . $bag->RECEPTACULO . ' y Lista para Expedicion',
            'user_id' => auth()->user()->id,
            'codigo' => $bag->MARBETE,
        ]);

        Event::create([
            'action' => 'CIERRE',
            'descripcion' => 'Saca Generada por el Receptaculo ' . $bag->MARBETE . ' .',
            'user_id' => auth()->user()->id,
            'codigo' => $bag->RECEPTACULO,
        ]);
        return redirect()->route('bags.index')->with('success', 'Despacho cerrado con éxito!');

    }

    public function goExpedition($id, Request $request)
    {
        $bag = Bag::find($id);

        // Verifica si la bolsa existe
        if (!$bag) {
            return redirect()->route('bags.index')
                ->with('success', 'El despacho no se pudo cerrar');
        }

        // Obtén el valor del campo MARVETE
        $marbete = $bag->MARBETE;

        // Actualiza los campos adicionales en los registros que tengan el mismo valor en el campo MARVETE
        Bag::where('MARBETE', $marbete)->update([
            'TRASPORTE' => $request->input('TRASPORTE'),
            'HORARIO' => $request->input('HORARIO'),
            'OBSERVACIONES' => $request->input('OBSERVACIONES'),
            'fecha_exp' => now(),
            'ESTADO' => 'TRASPORTADO',
            'userbags' => auth()->user()->name,
        ]);

        // Calcula la suma de los campos PESOC y PAQUETES
        $sum = Bag::where('MARBETE', $marbete)
            ->select(
                DB::raw('SUM(PESOF) as sum_pesoc'),
                DB::raw('COUNT(ID) as sum_paquetes'),
                DB::raw('SUM(PAQUETES) as sum_totalpaquetes'),
                DB::raw('SUM(PESOF) as sum_totalpeso'),
                DB::raw('COUNT(ID) + SUM(SACAR) + SUM(SACAM) as sum_totalsaca'),
            )
            ->first();

        // Obtén todos los registros de la tabla bags con el mismo valor en el campo MARBETE
        $bags = Bag::where('MARBETE', $marbete)->get();

        Event::create([
            'action' => 'TRASPORTADO',
            'descripcion' => 'Despacho en camino Oficina Destino CN38 y entregado a Trasporte de Cambio',
            'user_id' => auth()->user()->id,
            'codigo' => $bag->MARBETE,
        ]);

        // Genera el PDF
        $pdf = PDF::loadView('bag.pdf.cn38', compact('bags', 'sum'));

        // Guarda o descarga el PDF según tus necesidades
        // $pdf->save(storage_path('nombre_del_archivo.pdf'));
        // o
        // return $pdf->download('nombre_del_archivo.pdf');

        // Puedes usar la vista que has proporcionado en tu pregunta como plantilla para el PDF
        return $pdf->stream('CN38.pdf', ['Attachment' => false]);
    }

    public function avisoExpedition($id, Request $request)
    {
        // En primer lugar, obtenemos la instancia de la bolsa que estamos actualizando.
        $bag = Bag::find($id);

        // Verificar si la bolsa existe.
        if (!$bag) {
            return redirect()->route('bags.bagsclose')->with('error', 'La bolsa no existe.');
        }

        // Obtén el valor del campo MARVETE
        $marbete = $bag->MARBETE;

        // Actualiza los campos adicionales en los registros que tengan el mismo valor en el campo MARVETE
        Bag::where('MARBETE', $marbete)->update([
            'ITINERARIO' => $request->input('ITINERARIO'),
            'OBSERVACIONES' => $request->input('OBSERVACIONES'),
        ]);

        // Recuperar los valores enviados desde el formulario.
        $sacau = $request->input('SACAU');
        $sacar = $request->input('SACAR');
        $sacam = $request->input('SACAM');
        $pesou = $request->input('PESOU');
        $pesor = $request->input('PESOR');
        $pesom = $request->input('PESOM');
        $paquetesu = $request->input('PAQUETESU');
        $paquetesr = $request->input('PAQUETESR');
        $paquetesm = $request->input('PAQUETESM');

        // Actualizar los campos correspondientes en la instancia de la bolsa.
        $bag->SACAU = $sacau;
        $bag->SACAR = $sacar;
        $bag->SACAM = $sacam;
        $bag->PESOU = $pesou;
        $bag->PESOR = $pesor;
        $bag->PESOM = $pesom;
        $bag->PAQUETESU = $paquetesu;
        $bag->PAQUETESR = $paquetesr;
        $bag->PAQUETESM = $paquetesm;

        // Guardar los cambios en la base de datos.
        $bag->save();

        // Obtener el número total de registros que se deben generar.
        $totalSacas = $sacar + $sacam + $sacau;

        // Crear nuevos registros duplicados para SACAR, SACAM y SACAU
        for ($i = 0; $i < $totalSacas; $i++) {
            $duplicateRecord = $bag->replicate();
            $duplicateRecord->NROSACA = sprintf("%04d", $i + 1);
            $duplicateRecord->TIPO = $i < $sacar ? 'R' : ($i < $sacar + $sacam ? 'M' : 'U');
            $duplicateRecord->userbags = auth()->user()->name; // Asignar el nombre del usuario actual
            $duplicateRecord->first = '0';

            // Establecer T=0 solo para el primer registro original
            if ($i == 0) {
                $duplicateRecord->T = '1';
                $duplicateRecord->first = '1';
            } else {
                // Mantener T como está para los registros duplicados
                $duplicateRecord->T = $bag->T;
            }
            // Si es el último registro duplicado, establecer FIN = F
            if ($i == $totalSacas - 1) {
                $duplicateRecord->FIN = 'F';
            } else {
                $duplicateRecord->FIN = 'N';
            }

            // Guardar el registro duplicado
            $duplicateRecord->save();
        }

        $bag->delete();

        // Código restante para generar el PDF y devolver la respuesta
        $bag->update([
            'T' => '1',
        ]);

        $sum = $sacau + $sacar + $sacam;
        $sum1 = $pesou + $pesor + $pesom;
        $sum2 = $paquetesu + $paquetesr + $paquetesm;

        Event::create([
            'action' => 'COMPROBADO',
            'descripcion' => 'Despacho verificado CN31 y sacas añadidas al despacho, listo para Trasporte',
            'user_id' => auth()->user()->id,
            'codigo' => $bag->MARBETE,
        ]);

        $pdf = PDF::loadView('bag.pdf.cn31', compact('bag', 'sum' ,'sum1','sum2'));

        return $pdf->stream('CN31.pdf');
    }

    public function bagsadd(Request $request)
    {
        $codigo = $request->input('codigo');
        $bag = Bag::where('RECEPTACULO', $codigo)->first();

        if ($bag) {
            // Verificar que el estado del paquete sea 'TRASPORTADO'
            if ($bag->ESTADO === 'TRASPORTADO') {
                // Verificar que el destino sea igual a la regional del usuario
                if (auth()->user()->Regional == $bag->OFDESTINO) {
                    // Cambiar el estado del paquete a "EXPEDICION"
                    Event::create([
                        'action' => 'RECIBIDO',
                        'descripcion' => 'Despacho ' . $bag->MARBETE . ' añadido en oficina de cambio y procesado para su entrega',
                        'user_id' => auth()->user()->id,
                        'codigo' => $bag->RECEPTACULO,
                    ]);
                    $bag->ESTADO = 'EXPEDICION';
                    $bag->userbags = auth()->user()->name;
                    $bag->save();
                    return redirect()->back()->with('success', 'Paquete se movió a Ventanilla con éxito y cambió su estado a EXPEDICION.');
                } else {
                    return redirect()->back()->with('error', 'El paquete no está destinado a la regional del usuario.');
                }
            } else {
                return redirect()->back()->with('error', 'El estado del paquete no es TRASPORTADO.');
            }
        } else {
            return redirect()->back()->with('error', 'No se pudo encontrar el paquete.');
        }
    }

    public function showExpedition(Request $request, $id)
    {
        foreach ($request->PAQUETES as $bagId => $paquetes) {
            $bag = Bag::findOrFail($bagId);

            // Calcula el valor del receptáculo
            $receptaculo = $bag->MARBETE . $bag->NROSACA . str_pad(str_replace('.', '',  $request->PESOF[$bagId]), 4, '0', STR_PAD_LEFT);

            $bag->update([
                'PAQUETES' => $paquetes,
                'PESOF' => $request->PESOF[$bagId],
                'PESO' => $request->PESOF[$bagId],
                'RECEPTACULO' => $receptaculo,
                'T' => '2', // Agrega el valor calculado de receptáculo
                'FIN' => 'N',
            ]);
        }

        $bag->update(['FIN' => 'F']);
        // Obtiene los datos actualizados de las bolsas
        $bags = Bag::whereIn('id', array_keys($request->PAQUETES))->get();

        $sum = Bag::where('ESTADO', 'CIERRE')
            ->select(
                'MARBETE',
                DB::raw('SUM(PESOF) as sum_pesoc'),
                DB::raw('SUM(PAQUETES) as sum_paquetes'),
                DB::raw('SUM(CASE WHEN TIPO = "U" THEN 1 ELSE 0 END) as sum_tipo'),
                DB::raw('SUM(CASE WHEN TIPO = "R" THEN 1 ELSE 0 END) as sum_tipor'),
                DB::raw('SUM(CASE WHEN TIPO = "M" THEN 1 ELSE 0 END) as sum_tipom'),
                DB::raw('SUM(NROSACA + SACAR + SACAM) as sum_total'),
                DB::raw('SUM(PAQUETES) + SUM(PAQUETESR) + SUM(PAQUETESM) as sum_totalpaquetes'),
                DB::raw('SUM(PESOF) + SUM(PESOR) + SUM(PESOM) as sum_totalpeso'),
                DB::raw('SUM(PAQUETESR) as sum_paqueter'),
                DB::raw('SUM(PAQUETESM) as sum_paquetem'),
                DB::raw('SUM(PESOM) as sum_pesom'),
                DB::raw('SUM(PESOR) as sum_pesor'),
            )
            ->groupBy('MARBETE')
            ->get();

        $pdf = PDF::loadView('bag.pdf.cn35', compact('bags'));

        return $pdf->stream('CN35.pdf');
    }

    public function bagsclose()
    {
        return view('bag.bagsclose');
    }
    public function bagstrans()
    {
        return view('bag.bagstrans');
    }
    public function bagsopen()
    {
        return view('bag.bagsopen');
    }
    public function bagsall()
    {
        return view('bag.bagsall');
    }
}
