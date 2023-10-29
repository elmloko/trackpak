<?php

namespace App\Http\Controllers;

use App\Models\Package;
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
        $package = new Package();

        return view('package.create', compact('package'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Package::$rules);

        $package = Package::create($request->all());

        return redirect()->route('packages.index')
            ->with('success', 'Paquete Creado Con Exito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package = Package::find($id);

        return view('package.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::find($id);

        return view('package.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Package $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        // dd($request->all());
        request()->validate(Package::$rules);

        $package->update($request->all());

        return redirect()->route('packages.index')
            ->with('success', 'Paquete Actualizado Con Exito!');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $package = Package::find($id)->delete();

        return redirect()->route('packages.index')
            ->with('success', 'Paquete Eliminado Con Exito!');
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
        $packages = Package::paginate(20);

        return view('package.ventanilla', compact('packages'))
            ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }
    public function clasificacion()
    {
        $packages = Package::paginate(20);

        return view('package.clasificacion', compact('packages'))
            ->with('i', (request()->input('page', 1) - 1) * $packages->perPage());
    }
}
