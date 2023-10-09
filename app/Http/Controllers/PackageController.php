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
        $package = Package::find($id)->delete();

        return back()->with('success', 'Paquete se dio de Baja Con Exito!');
    }
    public function deleted()
    {
        // Recupera todos los elementos eliminados (soft deleted)
        $deletedPackages = Package::onlyTrashed()->paginate();

        return view('package.deleted', compact('deletedPackages'));
    }
    public function restoring($id)
    {
        // Restaura el paquete con el ID dado
        $package = Package::withTrashed()->findOrFail($id);
        $package->restore();

        return redirect()->route('package.index')->with('success', 'Paquete se restauró con éxito.');
    }

}
