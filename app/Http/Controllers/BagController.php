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
        request()->validate(Bag::$rules);

        $bag = Bag::create($request->all());

        return redirect()->route('bags.index')
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
            'descripcion' => 'Saca Generada por el Receptaculo ' . $bag->MARBETE . ' e Impreso CN35',
            'user_id' => auth()->user()->id,
            'codigo' => $bag->RECEPTACULO,
        ]);

        // Genera el PDF
        $pdf = PDF::loadView('bag.pdf.cn35', compact('bag'));

        return $pdf->stream('CN35.pdf', ['Attachment' => false]);

        return redirect()->route('bags.index')
            ->with('success', 'Despacho cerrado con exito!');
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
            'OBSERVACIONESG' => $request->input('OBSERVACIONESG'),
            'fecha_exp' => now(),
            'ESTADO' => 'TRASPORTADO',
            'userbags' => auth()->user()->name,
        ]);

        // Calcula la suma de los campos PESOC y PAQUETES
        $sum = Bag::where('MARBETE', $marbete)
            ->select(
                DB::raw('SUM(PESOF) as sum_pesoc'),
                DB::raw('COUNT(ID) as sum_paquetes'),
                DB::raw('SUM(PAQUETES) + SUM(PAQUETESR) + SUM(PAQUETESM) as sum_totalpaquetes'),
                DB::raw('SUM(PESOF) + SUM(PESOR) + SUM(PESOM) as sum_totalpeso'),
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
    // public function returnExpedition($id, Request $request)
    // {
    //     $bag = Bag::find($id);

    //     // Verifica si la bolsa existe
    //     if (!$bag) {
    //         return redirect()->route('bags.index')
    //             ->with('success', 'El despacho no se pudo cerrar');
    //     }

    //     // Obtén el valor del campo MARVETE
    //     $marbete = $bag->MARBETE;

    //     // Actualiza los campos adicionales en los registros que tengan el mismo valor en el campo MARVETE
    //     Bag::where('MARBETE', $marbete)->update([
    //         'TRASPORTE' => $request->input('TRASPORTE'),
    //         'HORARIO' => $request->input('HORARIO'),
    //         'OBSERVACIONESG' => $request->input('OBSERVACIONESG'),
    //         'fecha_exp' => now(),
    //         'ESTADO' => 'TRASPORTADO',
    //     ]);

    //     // Calcula la suma de los campos PESOC y PAQUETES
    //     $sum = Bag::where('MARBETE', $marbete)
    //         ->select(
    //             DB::raw('SUM(PESOF) as sum_pesoc'),
    //             DB::raw('COUNT(ID) as sum_paquetes'),
    //             DB::raw('SUM(PAQUETES) + SUM(PAQUETESR) + SUM(PAQUETESM) as sum_totalpaquetes'),
    //             DB::raw('SUM(PESOF) + SUM(PESOR) + SUM(PESOM) as sum_totalpeso'),
    //             DB::raw('COUNT(ID) + SUM(SACAR) + SUM(SACAM) as sum_totalsaca'),
    //         )
    //         ->first();

    //     Event::create([
    //         'action' => 'PROCESADO',
    //         'descripcion' => 'Saca Generada Marbete ' . $bag->RECEPTACULO . ' y Lista para Expedicion',
    //         'user_id' => auth()->user()->id,
    //         'codigo' => $bag->MARBETE,
    //     ]);

    //     Event::create([
    //         'action' => 'CIERRE',
    //         'descripcion' => 'Saca Generada por el Receptaculo ' . $bag->MARBETE . ' e Impreso',
    //         'user_id' => auth()->user()->id,
    //         'codigo' => $bag->RECEPTACULO,
    //     ]);

    //     // Obtén todos los registros de la tabla bags con el mismo valor en el campo MARBETE
    //     $bags = Bag::where('MARBETE', $marbete)->get();

    //     // Genera el PDF
    //     $pdf = PDF::loadView('bag.pdf.cn38', compact('bags', 'sum'));

    //     // Guarda o descarga el PDF según tus necesidades
    //     // $pdf->save(storage_path('nombre_del_archivo.pdf'));
    //     // o
    //     // return $pdf->download('nombre_del_archivo.pdf');

    //     // Puedes usar la vista que has proporcionado en tu pregunta como plantilla para el PDF
    //     return $pdf->stream('CN38.pdf', ['Attachment' => false]);
    // }
    public function avisoExpedition($id, Request $request)
    {
        // En primer lugar, obtenemos la instancia de la bolsa que estamos actualizando.
        $bag = Bag::find($id);

        // Verificar si la bolsa existe.
        if (!$bag) {
            return redirect()->route('bags.bagsclose')->with('error', 'La bolsa no existe.');
        }

        // Recuperar los valores enviados desde el formulario.
        $sacar = $request->input('SACAR');
        $sacam = $request->input('SACAM');
        $pesor = $request->input('PESOR');
        $pesom = $request->input('PESOM');
        $paquetesr = $request->input('PAQUETESR');
        $paquetesm = $request->input('PAQUETESM');

        // Actualizar los campos correspondientes en la instancia de la bolsa.
        $bag->SACAR = $sacar;
        $bag->SACAM = $sacam;
        $bag->PESOR = $pesor;
        $bag->PESOM = $pesom;
        $bag->PAQUETESR = $paquetesr;
        $bag->PAQUETESM = $paquetesm;

        // Guardar los cambios en la base de datos.
        $bag->save();

        $bag->update([
            'T' => '1',
        ]);

        Event::create([
            'action' => 'COMPROBADO',
            'descripcion' => 'Despacho verificado CN31 y sacas añadidas al despacho, listo para Trasporte',
            'user_id' => auth()->user()->id,
            'codigo' => $bag->MARBETE,
        ]);

        $sum = Bag::where('ESTADO', 'CIERRE')
            ->select(
                'MARBETE',
                DB::raw('SUM(PESOF) as sum_pesoc'),
                DB::raw('SUM(PAQUETES) as sum_paquetes'),
                DB::raw('SUM(CASE WHEN TIPO = "U" THEN 1 ELSE 0 END) as sum_tipo'),
                DB::raw('SUM(NROSACA + SACAR + SACAM) as sum_total'),
                DB::raw('SUM(PAQUETES) + SUM(PAQUETESR) + SUM(PAQUETESM) as sum_totalpaquetes'),
                DB::raw('SUM(PESOF) + SUM(PESOR) + SUM(PESOM) as sum_totalpeso'),
            )
            ->groupBy('MARBETE')
            ->get();

        // Generar el PDF con los datos sumados
        $pdf = PDF::loadView('bag.pdf.cn31', compact('bag', 'sum'));

        // Devolver el PDF al navegador para su visualización
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
                        'descripcion' => 'Despacho '. $bag->MARBETE .' añadido en oficina de cambio y procesado para su entrega',
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
}
