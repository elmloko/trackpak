<?php

namespace App\Listeners;

use App\Events\PaqueteBaja;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogPaqueteBaja
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaqueteBaja $event): void
    {
        $action = "Baja de Paquete"; // Personaliza el tipo de acción
        $user = $event->user;
    
    Event::create([
        'action' => $action,
        'user_id' => $user->id,
    ]);
    }
}
