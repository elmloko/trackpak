<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
        Tracking BO - AGBC
    </title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <style>
        .gradient {
            background: rgb(52, 68, 124);
            background: linear-gradient(90deg, rgba(52, 68, 124, 1) 35%, rgba(185, 156, 70, 1) 70%);
        }
    </style>
</head>

<body class="leading-normal tracking-normal text-white gradient" style="font-family: 'Source Sans Pro', sans-serif;">
    <meta name="csrf-token" content="{{csrf_token() }}">
    @csrf 
    <!--Nav-->
    <nav id="header" class="fixed w-full z-30 top-0 text-white">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
            <div class="pl-4 flex items-center">
                <a class="toggleColour text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl"
                    href="https://correos.gob.bo/">
                    <span class="flex items-center">
                        <img src="{{ asset('images/AGBClogo.png') }}" alt="TrackingBO" width="60" height="30"
                            class="mr-2">
                        TrackingBO
                    </span>
                </a>
            </div>
            <div class="block lg:hidden pr-4">
                <button id="nav-toggle"
                    class="flex items-center p-1 text-pink-800 hover:text-gray-900 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                    <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                    </svg>
                </button>
            </div>
            <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden mt-2 lg:mt-0 bg-white lg:bg-transparent text-black p-4 lg:p-0 z-20"
                id="nav-content">
                <ul class="list-reset lg:flex justify-end flex-1 items-center">
                    <li class="mr-3">
                        <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4"
                            href="https://correos.gob.bo/about/">Quienes Somos</a>
                    </li>
                    <li class="mr-3">
                        <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4"
                            href="https://correos.gob.bo/services/">Nuestros Servicios</a>
                    </li>
                    <li class="mr-3">
                        <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4"
                            href="https://correos.gob.bo/contact-us/">Contactanos</a>
                    </li>
                </ul>
                <button id="navAction"
                    class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full mt-4 lg:mt-0 py-4 px-8 shadow opacity-75 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out"
                    onclick="@auth window.location='{{ url('/dashboard') }}'; @else window.location='{{ route('login') }}'; @endauth">
                    @auth
                        Ir al Dashboard
                    @else
                        Iniciar Sesión
                    @endauth
                </button>
            </div>
        </div>
        <hr class="border-b border-gray-100 opacity-25 my-0 py-0" />
    </nav>
    <!--Hero-->
    <div class="pt-24">
        <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
            <!-- Left Col -->
            <div
                class="flex flex-col w-full md:w-2/5 justify-center items-center md:items-start text-center md:text-left">
                <p class="uppercase tracking-loose w-full">¿Estás buscando tu paquete?</p>
                <h1 class="my-4 text-5xl font-bold leading-tight">
                    RASTREA TU PAQUETE NACIONAL
                </h1>
                <p class="leading-normal text-2xl mb-8">
                    Un servicio de seguimiento de paquetería postal de la Agencia Boliviana de Correos
                </p>
                <div class="w-full flex flex-col md:flex-row items-center justify-center">
                    <input type="text" id="" class="w-full bg-gray-200 rounded-full py-2 px-4 mb-2 md:mb-0"
                        placeholder="Buscar Paquete...">
                </div>
                <ul id="showlist" tabindex="1" class="list-group"></ul>
            </div>
            <!-- Right Col -->
            <div class="w-full md:w-3/5 py-6 text-center">
                <img class="w-2/3 md:w-1/2 mx-auto z-50" src="{{ asset('images/MONITO.png') }}" />
            </div>
        </div>
    </div>
    <div class="relative -mt-12 lg:-mt-24">
        <svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
                    <path
                        d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496"
                        opacity="0.100000001"></path>
                    <path
                        d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
                        opacity="0.100000001"></path>
                    <path
                        d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z"
                        id="Path-4" opacity="0.200000003"></path>
                </g>
                <g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
                    <path
                        d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z">
                    </path>
                </g>
            </g>
        </svg>
    </div>
    <section class="bg-white border-b py-8">
        <div class="container max-w-5xl mx-auto m-8">
            <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
                Enviar y Recoger Paquetes con la Agencia Boliviana de Correos: Simple y Rápido
            </h2>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-full opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="flex flex-wrap">
                <div class="w-5/6 sm:w-1/2 p-6">
                    <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
                        Envia tus paquetes en nuestras oficinas
                    </h3>
                    <p class="text-gray-600 mb-8 text-justify">
                        Envía tus paquetes en la Agencia Boliviana de Correos de manera sencilla. Visita nuestras
                        oficinas cercanas, empaca bien tu paquete y proporciona la dirección del destinatario. ¡Así de
                        fácil es enviar tus paquetes con la Agencia Boliviana de Correos!
                    <p class="text-black mt-4 font-bold">Requerimientos para el envío de paquetes:</p>
                    <br />
                    <ul class="text-black font-bold">
                        <li class="mb-2">
                            - Fotocopia de Carnet de identidad.
                        </li>
                        <li class="mb-2">
                            - Paquete abierto con el embalaje nesesario.
                        </li>
                        <li class="mb-2">
                            - Paquete Rotulado con datos personales y destino.
                        </li>
                        <li class="mb-2">
                            - Fotocopia de pasaporte (para personas extranjeras).
                        </li>
                    </ul>
                    </p>
                </div>
                <div class="w-full sm:w-1/2 p-6">
                    <img class="w-2/3 md:w-1/2 mx-auto z-50" src="{{ asset('images/enviar.png') }}" />
                </div>
            </div>
            <div class="flex flex-wrap flex-col-reverse sm:flex-row">
                <div class="w-full sm:w-1/2 p-6 mt-6">
                    <img class="w-2/3 md:w-1/2 mx-auto z-50" src="{{ asset('images/recibir.png') }}" />
                </div>
                <div class="w-full sm:w-1/2 p-6 mt-6">
                    <div class="align-middle">
                        <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
                            Recoje tus paquetes en nuestras oficinas
                        </h3>
                        <p class="text-gray-600 mb-8 text-justify">
                            Para recoger paquetes en la Agencia Boliviana de Correos, sigue estos pasos simples: ve a
                            nuestras oficinas cuando recibas un aviso, lleva una identificación válida y el código de
                            rastreo, y nuestro personal te ayudará a recoger tu paquete de forma segura. ¡Es conveniente
                            y rápido!
                            <br />
                        <p class="text-black mt-4 font-bold">Requerimientos para recojer tus paquetes:</p>
                        <br />
                        <ul class="text-black font-bold">
                            <li class="mb-2">
                                - Carnet de identidad / Pasaporte.
                            </li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="bg-white border-b py-8">
        <div class="container mx-auto flex flex-wrap pt-4 pb-12">
            <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
                Title
            </h2>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-full opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="w-full md:w-1/3 p-6 flex flex-col flex-grow flex-shrink">
                <div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden shadow">
                    <a href="#" class="flex flex-wrap no-underline hover:no-underline">
                        <p class="w-full text-gray-600 text-xs md:text-sm px-6">
                            xGETTING STARTED
                        </p>
                        <div class="w-full font-bold text-xl text-gray-800 px-6">
                            Lorem ipsum dolor sit amet.
                        </div>
                        <p class="text-gray-800 text-base px-6 mb-5">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at ipsum eu nunc commodo
                            posuere et sit amet ligula.
                        </p>
                    </a>
                </div>
                <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
                    <div class="flex items-center justify-start">
                        <button
                            class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                            Action
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-6 flex flex-col flex-grow flex-shrink">
                <div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden shadow">
                    <a href="#" class="flex flex-wrap no-underline hover:no-underline">
                        <p class="w-full text-gray-600 text-xs md:text-sm px-6">
                            xGETTING STARTED
                        </p>
                        <div class="w-full font-bold text-xl text-gray-800 px-6">
                            Lorem ipsum dolor sit amet.
                        </div>
                        <p class="text-gray-800 text-base px-6 mb-5">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at ipsum eu nunc commodo
                            posuere et sit amet ligula.
                        </p>
                    </a>
                </div>
                <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
                    <div class="flex items-center justify-center">
                        <button
                            class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                            Action
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-6 flex flex-col flex-grow flex-shrink">
                <div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden shadow">
                    <a href="#" class="flex flex-wrap no-underline hover:no-underline">
                        <p class="w-full text-gray-600 text-xs md:text-sm px-6">
                            xGETTING STARTED
                        </p>
                        <div class="w-full font-bold text-xl text-gray-800 px-6">
                            Lorem ipsum dolor sit amet.
                        </div>
                        <p class="text-gray-800 text-base px-6 mb-5">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at ipsum eu nunc commodo
                            posuere et sit amet ligula.
                        </p>
                    </a>
                </div>
                <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
                    <div class="flex items-center justify-end">
                        <button
                            class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                            Action
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="bg-gray-100 py-8">
        <div class="container mx-auto px-2 pt-4 pb-12 text-gray-800">
            <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
                Sabes lo que puedes y lo que no puedes enviar por el servicio postal?
            </h2>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-full opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="flex flex-col sm:flex-row justify-center pt-12 my-12 sm:my-4">
                <div class="flex flex-col w-5/6 lg:w-1/4 mx-auto lg:mx-0 rounded-none lg:rounded-l-lg bg-white mt-4">
                    <div class="flex-1 bg-white text-gray-600 rounded-t rounded-b-none overflow-hidden shadow">
                        <div class="p-8 text-3xl font-bold text-center border-b-4">
                            Mercancia Volátil Peligrosa
                        </div>
                        <ul class="w-full text-center text-sm">
                            <li class="border-b py-4">EXPLOSIVOS</li>
                            <li class="border-b py-4">GASES COMPRIMIDOS</li>
                            <li class="border-b py-4">LIQUIDOS INFLAMABLES</li>
                            <li class="border-b py-4">SUSTANCIAS COMBURENTES</li>
                            <li class="border-b py-4">SUSTANCIAS TOXICAS</li>
                            <li class="border-b py-4">MATERIALES RADIOACTIVOS</li>
                        </ul>
                    </div>
                    <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
                        <div class="w-full pt-6 text-3xl text-gray-600 font-bold text-center">
                            <div>NO</div>
                            <div class="text-base">Articulos Peligrosos</div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col w-5/6 lg:w-1/3 mx-auto lg:mx-0 rounded-lg bg-white mt-4 sm:-mt-6 shadow-lg z-10">
                    <div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden shadow">
                        <div class="w-full p-8 text-3xl font-bold text-center">Mercancia Permitida</div>
                        <div class="h-1 w-full gradient my-0 py-0 rounded-t"></div>
                        <ul class="w-full text-center text-base font-bold">
                            <li class="border-b py-4">ROPA</li>
                            <li class="border-b py-4">DOCUMENTOS CARTAS</li>
                            <li class="border-b py-4">APARATOS ELECTRONICOS</li>
                            <li class="border-b py-4">COSMETICOS</li>
                            <li class="border-b py-4">ARTICULOS PARA EL HOGAR</li>
                            <li class="border-b py-4">TODO LO QUE SE LE OCURRA</li>
                        </ul>
                    </div>
                    <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
                        <div class="w-full pt-6 text-3xl text-gray-600 font-bold text-center">
                            <div>SI</div>
                            <div class="text-base">Articulos Permitidos</div>
                        </div>
                        <div class="flex items-center justify-center">
                            <a href="https://www.upu.int/UPU/media/upu/files/UPU/outreachAndCampaigns/Dangerous%20Goods%20Campaign/UPU_Flyer_es_web.pdf"
                                class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                                Consulte Aquí
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col w-5/6 lg:w-1/4 mx-auto lg:mx-0 rounded-none lg:rounded-l-lg bg-white mt-4">
                    <div class="flex-1 bg-white text-gray-600 rounded-t rounded-b-none overflow-hidden shadow">
                        <div class="p-8 text-3xl font-bold text-center border-b-4">
                            Mercancia Peligrosa Prohibida
                        </div>
                        <ul class="w-full text-center text-sm">
                            <li class="border-b py-4">MEDICAMENTOS</li>
                            <li class="border-b py-4">ESTRUPEFACIENTES</li>
                            <li class="border-b py-4">ANIMALES EN GENERAL</li>
                            <li class="border-b py-4">DINERO</li>
                            <li class="border-b py-4">BATERIAS ELECTRICAS</li>
                            <li class="border-b py-4">ALIMENTOS PERECEDEROS</li>
                        </ul>
                    </div>
                    <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
                        <div class="w-full pt-6 text-3xl text-gray-600 font-bold text-center">
                            <div>NO</div>
                            <div class="text-base">Articulos Prohibidos</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Change the colour #f8fafc to match the previous section colour -->
    <svg class="wave-top" viewBox="0 0 1439 147" version="1.1" xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g transform="translate(-1.000000, -14.000000)" fill-rule="nonzero">
                <g class="wave" fill="#f8fafc">
                    <path
                        d="M1440,84 C1383.555,64.3 1342.555,51.3 1317,45 C1259.5,30.824 1206.707,25.526 1169,22 C1129.711,18.326 1044.426,18.475 980,22 C954.25,23.409 922.25,26.742 884,32 C845.122,37.787 818.455,42.121 804,45 C776.833,50.41 728.136,61.77 713,65 C660.023,76.309 621.544,87.729 584,94 C517.525,105.104 484.525,106.438 429,108 C379.49,106.484 342.823,104.484 319,102 C278.571,97.783 231.737,88.736 205,84 C154.629,75.076 86.296,57.743 0,32 L0,0 L1440,0 L1440,84 Z">
                    </path>
                </g>
                <g transform="translate(1.000000, 15.000000)" fill="#FFFFFF">
                    <g
                        transform="translate(719.500000, 68.500000) rotate(-180.000000) translate(-719.500000, -68.500000) ">
                        <path
                            d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496"
                            opacity="0.100000001"></path>
                        <path
                            d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
                            opacity="0.100000001"></path>
                        <path
                            d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z"
                            opacity="0.200000003"></path>
                    </g>
                </g>
            </g>
        </g>
    </svg>
    <section class="container mx-auto text-center py-6 mb-12">
        <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-white">
            ¡Te invitamos a visitar nuestra página web en la Agencia Boliviana de Correos!
        </h2>
        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-white w-1/6 opacity-25 my-0 py-0 rounded-t"></div>
        </div>
        <h3 class="my-4 text-3xl leading-tight">
            En nuestro sitio, encontrarás toda la información que necesitas sobre nuestros servicios postales. Explora
            sobre nuestra institucion, horarios de atención, ubicaciones de oficinas, y más.¡Descubre lo que la Agencia
            Boliviana de Correos tiene para ofrecerte en línea hoy mismo!
        </h3>
        <br>
        <a href="https://correos.gob.bo/" class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
            Visitame!
        </a>        
    </section>
    <!--Footer-->
    <footer class="bg-white">
        <div class="container mx-auto px-8">
            <div class="w-full flex flex-col md:flex-row py-6">
                <div class="flex-1 mb-6 text-black mr-4"> <!-- Margen derecho agregado -->
                    <div class="w-full mb-4 flex flex-col items-center justify-center">
                        <img src="{{ asset('images/AGBCazul.png') }}" alt="TrackingBO"
                            class="max-w-full max-h-full mb-2">
                        <img src="{{ asset('images/LOGO-BOLIVIA.png') }}" alt="TrackingBO"
                            class="max-w-full max-h-full">
                    </div>
                </div>

                <div class="flex-1 ml-4"> <!-- Margen izquierdo agregado -->
                    <p class="uppercase text-gray-500 md:mb-6">Preguntas Frecuentes</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#"
                                class="no-underline hover:underline text-gray-800 hover:text-pink-500">FAQ</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#"
                                class="no-underline hover:underline text-gray-800 hover:text-pink-500">Help</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#"
                                class="no-underline hover:underline text-gray-800 hover:text-pink-500">Support</a>
                        </li>
                    </ul>
                </div>

                <div class="flex-1">
                    <p class="uppercase text-gray-500 md:mb-6">Enlaces Externos</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.aduana.gob.bo/aduana7/"
                                class="no-underline hover:underline text-gray-800 hover:text-blue-500">Aduana Nacional
                                de Bolivia</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.oopp.gob.bo/"
                                class="no-underline hover:underline text-gray-800 hover:text-blue-500">Ministerio de
                                Obras Públicas, Servicio y Vivienda</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.upu.int/en/Home"
                                class="no-underline hover:underline text-gray-800 hover:text-blue-500">Union Postal
                                Universal</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.upu.int/en/Home"
                                class="no-underline hover:underline text-gray-800 hover:text-blue-500">Unión Postal de
                                las Américas, España y Portugal</a>
                        </li>
                    </ul>
                </div>
                <div class="flex-1">
                    <p class="uppercase text-gray-500 md:mb-6">Redes Sociales</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.facebook.com/agbc.oficial"
                                class="no-underline hover:underline text-gray-800 hover:text-blue-500">Facebook</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://twitter.com/AGBC_oficial"
                                class="no-underline hover:underline text-gray-800 hover:text-blue-500">Twitter</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.instagram.com/agenciabolivianadecorreos.of/"
                                class="no-underline hover:underline text-gray-800 hover:text-blue-500">Instagram</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.instagram.com/agenciabolivianadecorreos.of/"
                                class="no-underline hover:underline text-gray-800 hover:text-blue-500">Tiktok</a>
                        </li>
                    </ul>
                </div>
                <div class="flex-1">
                    <p class="uppercase text-gray-500 md:mb-6">SOBRE NOSOTROS</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/about/"
                                class="no-underline hover:underline text-gray-800 hover:text-pink-500">Quienes
                                Somos</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/services/"
                                class="no-underline hover:underline text-gray-800 hover:text-pink-500">Nuestros
                                Servicios</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/contact-us/"
                                class="no-underline hover:underline text-gray-800 hover:text-pink-500">Contactanos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- jQuery if you need it
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  -->
    <script>
        var scrollpos = window.scrollY;
        var header = document.getElementById("header");
        var navcontent = document.getElementById("nav-content");
        var navaction = document.getElementById("navAction");
        var brandname = document.getElementById("brandname");
        var toToggle = document.querySelectorAll(".toggleColour");

        document.addEventListener("scroll", function() {
            /*Apply classes for slide in bar*/
            scrollpos = window.scrollY;

            if (scrollpos > 10) {
                header.classList.add("bg-white");
                navaction.classList.remove("bg-white");
                navaction.classList.add("gradient");
                navaction.classList.remove("text-gray-800");
                navaction.classList.add("text-white");
                //Use to switch toggleColour colours
                for (var i = 0; i < toToggle.length; i++) {
                    toToggle[i].classList.add("text-gray-800");
                    toToggle[i].classList.remove("text-white");
                }
                header.classList.add("shadow");
                navcontent.classList.remove("bg-gray-100");
                navcontent.classList.add("bg-white");
            } else {
                header.classList.remove("bg-white");
                navaction.classList.remove("gradient");
                navaction.classList.add("bg-white");
                navaction.classList.remove("text-white");
                navaction.classList.add("text-gray-800");
                //Use to switch toggleColour colours
                for (var i = 0; i < toToggle.length; i++) {
                    toToggle[i].classList.add("text-white");
                    toToggle[i].classList.remove("text-gray-800");
                }

                header.classList.remove("shadow");
                navcontent.classList.remove("bg-white");
                navcontent.classList.add("bg-gray-100");
            }
        });
    </script>
    <script>
        /*Toggle dropdown list*/
        /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

        var navMenuDiv = document.getElementById("nav-content");
        var navMenu = document.getElementById("nav-toggle");

        document.onclick = check;

        function check(e) {
            var target = (e && e.target) || (event && event.srcElement);

            //Nav Menu
            if (!checkParent(target, navMenuDiv)) {
                // click NOT on the menu
                if (checkParent(target, navMenu)) {
                    // click on the link
                    if (navMenuDiv.classList.contains("hidden")) {
                        navMenuDiv.classList.remove("hidden");
                    } else {
                        navMenuDiv.classList.add("hidden");
                    }
                } else {
                    // click both outside link and outside menu, hide menu
                    navMenuDiv.classList.add("hidden");
                }
            }
        }

        function checkParent(t, elm) {
            while (t.parentNode) {
                if (t == elm) {
                    return true;
                }
                t = t.parentNode;
            }
            return false;
        }
    </script>
</body>

</html>
