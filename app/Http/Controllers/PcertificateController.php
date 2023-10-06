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
        $pcertificates = Pcertificate::paginate();

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
        $pcertificate = Pcertificate::find($id)->delete();

        return back()->with('success', 'Paquete se dio de Baja Con Exito!');
    }
}
