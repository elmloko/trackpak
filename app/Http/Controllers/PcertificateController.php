<?php

namespace App\Http\Controllers;

use App\Models\Pcertificate;
use App\Exports\PcertificateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

/**
 * Class PcertificateController
 * @package App\Http\Controllers
 */
class PcertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pcertificates = Pcertificate::paginate(20);

        return view('pcertificate.index', compact('pcertificates'))
            ->with('i', (request()->input('page', 1) - 1) * $pcertificates->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pcertificate = new Pcertificate();
        return view('pcertificate.create', compact('pcertificate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Pcertificate::$rules);

        $pcertificate = Pcertificate::create($request->all());

        return redirect()->route('pcertificates.index')
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
        $pcertificate = Pcertificate::find($id);

        return view('pcertificate.show', compact('pcertificate'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pcertificate = Pcertificate::find($id);

        return view('pcertificate.edit', compact('pcertificate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Pcertificate $pcertificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pcertificate $pcertificate)
    {
        request()->validate(Pcertificate::$rules);

        $pcertificate->update($request->all());

        return redirect()->route('pcertificates.index')
            ->with('success', 'Paquete Actualizado Con Exito!');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pcertificate = Pcertificate::find($id)->delete();

        return redirect()->route('pcertificates.index')
            ->with('success', 'Paquete Eliminado Con Exito!');
    }
    public function excel()
    {
        return Excel::download(new PcertificateExport, 'Paquetes Certificados.xlsx');
    }

    public function pdf()
    {
        return Excel::download(new PcertificateExport, 'Paquetes Certificados.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    } 
    public function delete($id)
{
    $pcertificate = Pcertificate::find($id);

    if (!$pcertificate) {
        return back()->with('error', 'El Certificado Postal no pudo ser encontrado o dado de baja');
    }

    // Cambia el estado del certificado de ALMACEN a ENTREGADO
    $pcertificate->update(['ESTADO' => 'ENTREGADO']);

    // Elimina el Certificado Postal
    $pcertificate->delete();

    return back()->with('success', 'Certificado Postal dado de Baja y Estado Cambiado a ENTREGADO exitosamente');
}

    public function deleteado()
    {
        // Recupera todos los elementos eliminados (soft deleted)
        $deleteadoPackages = Pcertificate::onlyTrashed()->paginate(20);

        return view('pcertificate.deleteado', compact('deleteadoPackages'));
    }
    public function restoring($id)
    {
        // Restaura el paquete con el ID dado
        $pcertificate = Pcertificate::withTrashed()->find($id);
        // Verifica si se encontró un paquete eliminado con ese ID
        if ($pcertificate) {
            $pcertificate->update(['ESTADO' => 'ALMACEN']);
            // Restaura el paquete
            $pcertificate->restore();
            return redirect()->route('pcertificates.index')
                ->with('success', 'El paquete ha sido restaurado exitosamente');
        } else {
            return redirect()->route('pcertificates.index')
                ->with('error', 'El paquete no pudo ser encontrado o restaurado');
        }
    }
}
