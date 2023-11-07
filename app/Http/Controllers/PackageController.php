<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Event;
use App\Exports\VentanillaExport;
use App\Exports\ClasificacionExport;
use App\Exports\PackageExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Class PackageController
 * @package App\Http\Controllers
 */
class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::paginate(20);

        return view('package.index', compact('packages'))
            ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        // Crear una instancia de Package
        $package = new Package();

        return view('package.create', compact('package'));
    }

    public function store(Request $request)
    {
        request()->validate(Package::$rules);

        $package = Package::create($request->all());
        Event::create([
            'action' => 'ADMITIDO',
            'descripcion' => 'Clasificacion del Paquete en Oficina Postal Regional',
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);
        Event::create([
            'action' => 'ADMISION',
            'descripcion' => 'Llegada de Paquete en Oficina Postal Regional',
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);
        return redirect()->route('packages.clasificacion')
            ->with('success', 'Paquete Creado Con Exito!');
    }

    public function show($id)
    {
        $package = Package::find($id);

        return view('package.show', compact('package'));
    }

    public function edit($id)
    {
        $package = Package::find($id);
        return view('package.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
{
    request()->validate(Package::$rules);

    // Obtener el código del paquete antes de la actualización
    $codigo = $package->CODIGO;

    $package->update($request->all());
    Event::create([
        'action' => 'ESTADO',
        'descripcion' => 'Edición de Paquete',
        'user_id' => auth()->user()->id,
        'codigo' => $codigo, // Utiliza el código obtenido previamente
    ]);
    return redirect()->route('packages.clasificacion')
        ->with('success', 'Paquete Actualizado Con Éxito!');
}
    public function destroy($id)
    {
        $package = Package::find($id); // Encuentra el paquete
        $codigo = $package->CODIGO; // Obtiene el código antes de eliminar el paquete
        $package->forceDelete(); // Elimina el paquete

        Event::create([
            'action' => 'ESTADO',
            'descripcion' => 'Eliminación de Paquete',
            'user_id' => auth()->user()->id,
            'codigo' => $codigo, // Utiliza el código obtenido previamente
        ]);

        return redirect()->route('packages.clasificacion')
            ->with('success', 'Paquete Eliminado Con Éxito!');
    }

    public function ventanillaexcel()
    {
        $packages = Package::where('ESTADO', 'VENTANILLA')->where('redirigido', 0)->get();
        return Excel::download(new VentanillaExport($packages), 'ventanilla.xlsx');
    }
    public function ventanillapdf()
    {
        $packages = Package::where('ESTADO', 'VENTANILLA')->where('redirigido', 0)->get();
        $pdf = PDF::loadView('package.pdf.ventanillapdf', ['packages' => $packages]);
        return $pdf->stream();
    }
    public function formularioentrega(Request $request, $id)
    {
        $package = Package::find($id);
        $pdf = PDF::loadView('package.pdf.formularioentrega', compact('package', 'request'));
        return $pdf->stream();
        // Descargar el PDF o mostrarlo en el navegador
        // return $pdf->download('formularioentrega.pdf');
    }
    public function abandono(Request $request, $id)
    {
        $package = Package::find($id);
        $pdf = PDF::loadView('package.pdf.abandono', compact('package', 'request'));
        return $pdf->stream();
        // Descargar el PDF o mostrarlo en el navegador
        // return $pdf->download('formularioentrega.pdf');
    }

    public function clasificacionexcel()
    {
        $packages = Package::where('ESTADO', 'CLASIFICACION')->get();
        return Excel::download(new ClasificacionExport($packages), 'Clasificacion.xlsx');
    }

    public function deleteadopdf()
    {
        $packages = Package::onlyTrashed()->get(); // Obtener registros eliminados
        $pdf = PDF::loadView('package.pdf.deleteadopdf', ['packages' => $packages]);
        return $pdf->stream();
    }
    public function redirigidospdf()
    {
        $packages = Package::where('ESTADO', 'REENCAMINADO')->get();
        $pdf = PDF::loadview('package.pdf.redirigidospdf',['packages'=>$packages]);
        return $pdf->stream();
    }
    public function clasificacionpdf()
    {
        $packages = Package::where('ESTADO', 'CLASIFICACION')->get();
        $pdf = PDF::loadview('package.pdf.clasificacionpdf',['packages'=>$packages]);
        return $pdf->stream();
    }
    public function excel()
    {
        return Excel::download(new PackageExport, 'Paquetes Ordinarios.xlsx');
    }

    public function packagesall()
    {
        $packages = Package::all();
        $pdf = PDF::loadview('package.pdf.packagesall',['packages'=>$packages]);
        return $pdf->stream();
    }
    public function delete($id)
    {
        $package = Package::find($id);

        if ($package) {
            Event::create([
                'action' => 'ENTREGADO',
                'descripcion' => 'Entrega de paquete en ventanilla en Oficina Postal Regional(ENTREGADO)',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            // Cambia el estado del paquete a "ENTREGADO"
            $package->estado = 'ENTREGADO';

            // Guarda el paquete actualizado
            $package->save();

            // Luego, elimina el paquete
            $package->delete();

            return back()->with('success', 'Paquete se dio de Baja y cambió su estado a ENTREGADO con éxito.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para dar de baja.');
        }
    }
    public function deleteado()
    {
        // $packages = Package::where('ESTADO', 'ENTREGADO')->paginate(20);
        $packages = Package::onlyTrashed()->paginate(20);
        return view('package.deleteado', compact('packages'));
    }
    public function restoring($id)
    {
        // Restaura el paquete con el ID dado
        $package = Package::withTrashed()->find($id);
        // Verifica si se encontró un paquete eliminado con ese ID
        if ($package) {
            Event::create([
                'action' => 'ESTADO',
                'descripcion' => 'Alta de Paquete',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            $package->update(['ESTADO' => 'VENTANILLA']);
            // Restaura el paquete
            $package->restore();
            return redirect()->route('packages.ventanilla')
                ->with('success', 'El paquete ha sido restaurado exitosamente');
        } else {
            return redirect()->route('packages.ventanilla')
                ->with('error', 'El paquete no pudo ser encontrado o restaurado');
        }
    }
    public function redirigir($id)
    {
        $package = Package::find($id);

        if ($package) {
            // Cambia el estado del paquete a "redirigido"
            $package->redirigido = true;
            Event::create([
                'action' => 'PRE-ENTREGA',
                'descripcion' => 'Correccion de Destino de paquete a Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);

            $package->estado = 'REENCAMINADO';

            // Obtén la fecha y hora actual y guárdala en el campo 'fecha_hora_redirigido'
            $package->date_redirigido = now();

            // Guarda el paquete actualizado
            $package->save();

            return back()->with('success', 'Paquete redirigido con éxito.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para redirigir.');
        }
    }
    public function redirigidos()
    {
        $package = Package::where('redirigido', true)->get();

        return view('package.redirigidos', compact('package'));
    }
    public function dirigido($id)
    {
        $package = Package::find($id);

        if ($package) {
            // Cambia el estado del paquete a "redirigido"
            $package->redirigido = false;

            Event::create([
                'action' => 'PRE-ENTREGA',
                'descripcion' => 'Paquete encaminado con exito a Oficina Postal Regional',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);

            $package->estado = 'VENTANILLA';

            // Obtén la fecha y hora actual y guárdala en el campo 'fecha_hora_redirigido'
            $package->date_redirigido = now();

            // Guarda el paquete actualizado
            $package->save();

            return back()->with('success', 'Paquete redirigido con éxito.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para redirigir.');
        }
    }
    public function ventanilla()
    {
        $packages = Package::paginate(10);

        return view('package.ventanilla', compact('packages'))
        ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }
    public function clasificacion()
    {
        $packages = Package::paginate(10);

        return view('package.clasificacion', compact('packages'))
            ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }

    public function buscarPaquete(Request $request)
    {
        $codigo = $request->input('codigo');
        $package = Package::where('CODIGO', $codigo)->first(); // Usar el nombre del modelo correctamente

        if ($package) {
            Event::create([
                'action' => 'EN ENTREGA',
                'descripcion' => 'Paquete Recibido en Oficina Postal Regional(VENTANILLA)',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            // Cambiar el estado del paquete a "VENTANILLA"
            $package->ESTADO = 'VENTANILLA';
            $package->save();

            return redirect()->back()->with('success', 'El paquete ha sido movido a VENTANILLA.');
        } else {
            return redirect()->back()->with('error', 'El paquete no se encuentra en clasificación.');
        }
    }
    public function buscarPaqueteCartero(Request $request)
    {
        $codigo = $request->input('codigo');
        $package = Package::where('CODIGO', $codigo)->first();

        if ($package) {
            if ($package->ESTADO === 'VENTANILLA') {
                Event::create([
                    'action' => 'EN ENTREGA',
                    'descripcion' => 'Paquete Destinado por envío con Cartero',
                    'user_id' => auth()->user()->id,
                    'codigo' => $package->CODIGO,
                ]);
                // Cambiar el estado del paquete a "CARTERO"
                $package->ESTADO = 'CARTERO';
                $package->save();

                return redirect()->back()->with('success', 'El paquete ha sido movido a Cartero.');
            } else {
                return redirect()->back()->with('error', 'El paquete no se encuentra en estado "VENTANILLA".');
            }
        } else {
            return redirect()->back()->with('error', 'El paquete no se encuentra en Clasificación.');
        }
    }

    public function carteros()
    {
        $packages = Package::paginate(10);

        return view('package.carteros', compact('packages'))
        ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }
    public function carteropdf()
    {
        $packages = Package::where('ESTADO', 'CARTERO')->get();
        $pdf = PDF::loadview('package.pdf.carteropdf',['packages'=>$packages]);
        return $pdf->stream();
    }
    public function inventariocartero()
    {
        $packages = Package::where('ESTADO', 'DOMICILIO')->paginate(20);
        return view('package.inventariocartero', compact('packages'));
    }
    public function deletecartero($id)
    {
        $package = Package::find($id);

        if ($package) {
            Event::create([
                'action' => 'ENTREGADO',
                'descripcion' => 'Entrega de paquete con Cartero(DOMICILIO)',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            // Cambia el estado del paquete a "ENTREGADO"
            $package->estado = 'DOMICILIO';

            // Guarda el paquete actualizado
            $package->save();

            // Luego, elimina el paquete
            $package->delete();

            return back()->with('success', 'Paquete se dio de Baja y cambió su estado a ENTREGADO con éxito.');
        } else {
            return back()->with('error', 'No se pudo encontrar el paquete para dar de baja.');
        }
    }
}
