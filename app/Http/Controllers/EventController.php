<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Package;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Class EventController
 * @package App\Http\Controllers
 */
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::paginate();

        return view('event.index', compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * $events->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $event = new Event();
        return view('event.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Event::$rules);

        $event = Event::create($request->all());

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);

        return view('event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);

        return view('event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Event $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        request()->validate(Event::$rules);

        $event->update($request->all());

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $event = Event::find($id)->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully');
    }
    public function search(Request $request)
    {
        $codigo = $request->input('codigo');
        // Recupera todos los campos de la tabla 'packages'
        $packages = Package::where('CODIGO', $codigo)
        ->take(5)
        ->withTrashed()
        ->get(); // Cambiado de 'first' a 'get' para obtener una colección

// Resto del código...

        // Realiza la lógica para buscar eventos basados en el código postal
        $event = Event::where('codigo', $codigo)
            ->where('action', '!=', 'ESTADO')
            ->orderBy('created_at', 'desc')
            ->get();

            return view('search', compact('packages', 'event', 'codigo'));
    }
    public function eventspdf()
    {
        $events = Event::orderByDesc('created_at')->get();
        $pdf = PDF::loadview('event.pdf.eventspdf', ['events' => $events]);
        return $pdf->stream();
    }
}
