<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Toastr options
    |--------------------------------------------------------------------------
    |
    | Here you can specify the options that will be passed to the toastr.js
    | library. These settings ensure a smooth user experience.
    |
    */

    'options' => [
        'closeButton'       => true, // Muestra un botón para cerrar la notificación.
        'progressBar'       => true, // Muestra una barra de progreso para el tiempo de visualización.
        'positionClass'     => 'toast-bottom-right', // Posición de la notificación en la pantalla.
        'timeOut'           => 10000, // Duración antes de que la notificación se cierre automáticamente (5 segundos).
        'extendedTimeOut'   => 2000, // Tiempo extra cuando el usuario interactúa con la notificación.
        'showDuration'      => 300, // Duración de la animación de aparición (en milisegundos).
        'hideDuration'      => 1000, // Duración de la animación de desaparición (en milisegundos).
        'showMethod'        => 'fadeIn', // Método de animación al mostrar la notificación.
        'hideMethod'        => 'fadeOut', // Método de animación al ocultar la notificación.
        'newestOnTop'       => true, // Muestra las notificaciones nuevas en la parte superior.
        'preventDuplicates' => false, // Evita que se muestren notificaciones duplicadas.
        'tapToDismiss'      => true, // Permite cerrar la notificación al hacer clic en ella.
    ],

];
