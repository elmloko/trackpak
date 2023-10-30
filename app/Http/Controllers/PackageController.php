<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Event;
use App\Exports\VentanillaExport;
use App\Exports\ClasificacionExport;
use App\Exports\PackageExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

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
            'action' => 'Creación de Paquete',
            'user_id' => auth()->user()->id,
            'codigo' => $package->CODIGO,
        ]);
        return redirect()->route('packages.index')
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
        'action' => 'Edición de Paquete',
        'user_id' => auth()->user()->id,
        'codigo' => $codigo, // Utiliza el código obtenido previamente
    ]);
    return redirect()->route('packages.index')
        ->with('success', 'Paquete Actualizado Con Éxito!');
}


    public function destroy($id)
    {
        $package = Package::find($id); // Encuentra el paquete
        $codigo = $package->CODIGO; // Obtiene el código antes de eliminar el paquete
        $package->delete(); // Elimina el paquete

        Event::create([
            'action' => 'Eliminación de Paquete',
            'user_id' => auth()->user()->id,
            'codigo' => $codigo, // Utiliza el código obtenido previamente
        ]);

        return redirect()->route('packages.index')
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
        return Excel::download(new VentanillaExport($packages), 'Ventanilla.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
    public function clasificacionexcel()
    {
        $packages = Package::where('ESTADO', 'CLASIFICACION')->get();
        return Excel::download(new ClasificacionExport($packages), 'Clasificacion.xlsx');
    }

    public function clasificacionpdf()
    {
        $packages = Package::where('ESTADO', 'CLASIFICACION')->get();
        return Excel::download(new ClasificacionExport($packages), 'Clasificacion.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
    public function excel()
    {
        return Excel::download(new PackageExport, 'Paquetes Ordinarios.xlsx');
    }

    public function pdf()
    {
        return Excel::download(new PackageExport, 'Paquetes Ordinarios.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
    public function delete($id)
    {
        $package = Package::find($id);

        if ($package) {
            Event::create([
                'action' => 'Baja de Paquete',
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
        // Recupera todos los elementos eliminados (soft deleted)
        $deleteadoPackages = Package::onlyTrashed()->paginate(20);
        return view('package.deleteado', compact('deleteadoPackages'));
    }
    public function restoring($id)
    {
        // Restaura el paquete con el ID dado
        $package = Package::withTrashed()->find($id);
        // Verifica si se encontró un paquete eliminado con ese ID
        if ($package) {
            Event::create([
                'action' => 'Alta de Paquete',
                'user_id' => auth()->user()->id,
                'codigo' => $package->CODIGO,
            ]);
            $package->update(['ESTADO' => 'VENTANILLA']);
            // Restaura el paquete
            $package->restore();
            return redirect()->route('packages.index')
                ->with('success', 'El paquete ha sido restaurado exitosamente');
        } else {
            return redirect()->route('packages.index')
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
                'action' => 'Correccion de Paquete en destino a Agencia Central',
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
        $paquetesRedirigidos = Package::where('redirigido', true)->get();

        return view('package.redirigidos', compact('paquetesRedirigidos'));
    }
    public function dirigido($id)
    {
        $package = Package::find($id);

        if ($package) {
            // Cambia el estado del paquete a "redirigido"
            $package->redirigido = false;

            Event::create([
                'action' => 'Paquete encaminado con exito a Regional',
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
                'action' => 'Paquete Registrado en Oficina Postal Regional(VENTANILLA)',
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

}
