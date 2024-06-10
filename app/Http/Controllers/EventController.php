<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Package;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Client;

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
    
        // Realiza la consulta a la base de datos para obtener los paquetes
        $packages = Package::where('CODIGO', $codigo)
            ->take(5)
            ->withTrashed()
            ->get();
    
        // Realiza la consulta a la base de datos para obtener los eventos
        $event = Event::where('codigo', $codigo)
            ->where('action', '!=', 'ESTADO')
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Consumir la API para autenticación y obtener el token JWT
        $client = new Client(['base_uri' => 'http://localhost:5254/']);
        $response = $client->post('api/Autenticacion/Validar', [
            'json' => [
                'correo' => 'Correos',
                'clave' => 'AGBClp2020'
            ]
        ]);
        $body = json_decode($response->getBody());
        $token = $body->token;
    
        // Usar el token JWT para hacer la búsqueda en la otra API
        $response = $client->post('api/O_MAIL_OBJECTS/buscar', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
            'json' => [
                'id' => $codigo // Utilizando el valor del código
            ]
        ]);
    
        // Decodificar y obtener los resultados de la búsqueda
        $results = json_decode($response->getBody());
    
        // Puedes devolver los resultados a tu vista junto con los paquetes y eventos
        return view('search', compact('results', 'packages', 'event', 'codigo'));
    }
    
    public function eventspdf()
    {
        $events = Event::orderByDesc('created_at')->get();
        $pdf = PDF::loadview('event.pdf.eventspdf', ['events' => $events]);
        return $pdf->stream();
    }
}
