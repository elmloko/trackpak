<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Tracking BO - AGBC</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <style>
        .gradient {
            background: rgb(52, 68, 124);
            background: linear-gradient(90deg, rgba(52, 68, 124, 1) 35%, rgba(185, 156, 70, 1) 70%);
        }

        .main {
            width: 100%;
            height: auto;
            display: grid;
            place-items: center;
            padding: 50px 0;
        }

        .main {
            font-size: 29px;
            color: rgba(91, 14, 216, 0.767);
            position: relative;
            margin-bottom: 100px;
            font-weight: 500;
        }

        .containerbox {
            width: 80%;
            margin: 0 auto;
            position: relative;
        }

        .containerbox ul {
            list-style: none;
        }

        .containerbox ul::after {
            content: " ";
            position: absolute;
            width: 2px;
            height: 100%;
            left: 50%;
            top: 0;
            transform: translateX(-50%);
            background: linear-gradient(to bottom, rgba(52, 68, 124, 1) 35%, rgba(185, 156, 70, 1));
        }

        .containerbox ul li {
            width: 48%;
            padding: 15px 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.218);
            position: relative;
            margin-bottom: 30px;
            z-index: 99;
        }

        .containerbox ul li:nth-child(4) {
            margin-bottom: 0;
        }

        .containerbox ul li .circle {
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: rgb(136, 159, 243);
            top: 0;
            display: grid;
            place-items: center;
        }

        .containerbox ul li .circle::after {
            content: ' ';
            width: 12px;
            height: 12px;
            background-color: rgba(52, 68, 124, 1);
            border-radius: 50%;
        }

        ul li:nth-child(odd) .circle {
            transform: translate(50%, -50%);
            right: -30px;
        }

        ul li:nth-child(even) .circle {
            transform: translate(-50%, -50%);
            left: -30px;
        }

        ul li .date {
            position: absolute;
            width: 130px;
            height: 33px;
            background-image: linear-gradient(to right, rgba(52, 68, 124, 1) 25%, rgba(185, 156, 70, 1));
            border-radius: 15px;
            top: -45px;
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 13px;
            box-shadow: 1px 2px 12px rgba(0, 0, 0, 0.318);
        }

        .containerbox ul li:nth-child(odd) {
            float: left;
            clear: right;
            text-align: right;
            transform: translateX(-30px);
        }

        ul li:nth-child(odd) .date {
            right: 20px;
        }

        .containerbox ul li:nth-child(even) {
            float: right;
            clear: left;
            transform: translateX(30px);
        }

        /* Estilos específicos para .timeline */
        .timeline {
            list-style: none;
            padding: 0;
        }

        .timeline li {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline h3 {
            font-size: 24px;
            color: rgba(52, 68, 124, 1);
            font-weight: 500;
        }

        .timeline h3::after {
            content: " ";
            position: absolute;
            width: 50%;
            height: 3px;
            left: 50%;
            bottom: -5px;
            transform: translateX(-50%);
            background: linear-gradient(to right, rgba(52, 68, 124, 1) 35%, rgba(185, 156, 70, 1));
        }

        .timeline ul::after {
            content: " ";
            position: absolute;
            width: 2px;
            height: 100%;
            left: 50%;
            top: 0;
            transform: translateX(-50%);
            background: linear-gradient(to bottom, rgba(52, 68, 124, 1) 35%, rgba(185, 156, 70, 1));
        }

        @media only screen and (min-width:798px) and (max-width: 1100px) {
            .container {
                width: 80%;
            }
        }

        @media only screen and (max-width: 798px) {
            .container {
                width: 70%;
                transform: translateX(20px);
            }

            .container ul::after {
                left: -40px;
            }

            .container ul li {
                width: 100%;
                float: none;
                clear: none;
                margin-bottom: 80px;
            }

            .container ul li .circle {
                left: -40px;
                transform: translate(-50%, -50%);
            }

            .container ul li .date {
                left: 20px;
            }

            .container ul li:nth-child(odd) {
                transform: translateX(0px);
                text-align: left;
            }

            .container ul li:nth-child(even) {
                transform: translateX(0px);
            }
        }

        @media only screen and (max-width: 550px) {
            .container {
                width: 80%;
            }

            .container ul::after {
                left: -20px;
            }

            .container ul li .circle {
                left: -20px;
            }
        }
    </style>
    @livewireStyles
</head>

<body class="leading-normal tracking-normal text-white gradient" style="font-family: 'Source Sans Pro', sans-serif;">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @csrf
    <!-- Nav -->
    <nav id="header" class="fixed w-full z-30 top-0 text-white">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
            <div class="pl-4 flex items-center">
                <a class="toggleColour text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl"
                    href="/">
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
                    <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                    </svg>
                </button>
            </div>
            <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 bg-white lg:bg-transparent text-black p-4 lg:p-0 z-20"
                id="nav-content">
                <ul class="list-reset lg:flex justify-end flex-1 items-center">
                    <li class="mr-3">
                        <a class="inline-block py-2 px-4 text-black font-bold no-underline" href="#">Inicio</a>
                    </li>
                    <li class="mr-3">
                        <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4"
                            href="#">Nosotros</a>
                    </li>
                    <li class="mr-3">
                        <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4"
                            href="#">Servicios</a>
                    </li>
                    <li class="mr-3">
                        <a class="inline-block text-black no-underline hover:text-gray-800 hover:text-underline py-2 px-4"
                            href="#">Contacto</a>
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
            <hr class="border-b border-gray-100 opacity-25 my-0 py-0" />
        </div>
        <hr class="border-b border-gray-100 opacity-25 my-0 py-0" />

    </nav>

    <!-- Hero -->
    <div class="relative -mt-12 lg:-mt-24">
        <svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink">
            <!-- Resto del código del héroe -->
        </svg>
    </div>

    <!-- Sección de eventos -->
    <section class="bg-white border-b py-8 text-center"> <!-- Añade "text-center" para centrar -->
        <div class="container mx-auto flex flex-wrap pt-4 pb-12">
            <div class="w-full">
                <h3 class="font-bold text-3xl text-black mb-10">Últimos Eventos</h3>

            </div>
            <div class="main">
                <div class="containerbox">
                    <ul class="timeline">
                        @foreach ($event as $evento)
                            <li class="text-black">
                                <h3 class="heading">{{ $evento->action }}</h3>
                                <span class="date ">{{ $evento->codigo }}</span>
                                <span class="description">{{ $evento->descripcion }}</span><br>
                                <span class="created-at">{{ $evento->created_at }}</span>
                                <!-- Haz que los cuadrados de la línea de tiempo sean más grandes -->
                                <span class="circle" style="width: 30px; height: 30px;"></span>
                            </li>
                        @endforeach
                    </ul>
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
    <!--Footer-->
    <footer class="bg-white gradient">
        <div class="container mx-auto px-8">
            <div class="w-full flex flex-col md:flex-row py-6">
                <div class="flex-1 mb-6 text-black mr-4"> <!-- Margen derecho agregado -->
                    <div class="w-full mb-4 flex flex-col items-center justify-center">
                        <img src="{{ asset('images/LOGOcen.png') }}" alt="TrackingBO"
                            class="max-w-full max-h-full mb-2">
                        <img src="{{ asset('images/LOGO-BOLIVIA-BLANCO.png') }}" alt="TrackingBO"
                            class="max-w-full max-h-full">
                    </div>
                </div>

                <div class="flex-1"> <!-- Margen izquierdo agregado -->
                    <p class="uppercase text-while-500 md:mb-6">Preguntas Frecuentes</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">FAQ</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Help</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Support</a>
                        </li>
                    </ul>
                </div>

                <div class="flex-1">
                    <p class="uppercase text-while-500 md:mb-6">Enlaces Externos</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.aduana.gob.bo/aduana7/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Aduana Nacional
                                de Bolivia</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.oopp.gob.bo/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Ministerio de
                                Obras Públicas, Servicio y Vivienda</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.upu.int/en/Home"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Union Postal
                                Universal</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.upu.int/en/Home"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Unión Postal de
                                las Américas, España y Portugal</a>
                        </li>
                    </ul>
                </div>
                <div class="flex-1">
                    <p class="uppercase text-while-500 md:mb-6">Redes Sociales</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.facebook.com/agbc.oficial"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Facebook</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://twitter.com/AGBC_oficial"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Twitter</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.instagram.com/agenciabolivianadecorreos.of/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Instagram</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://www.instagram.com/agenciabolivianadecorreos.of/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Tiktok</a>
                        </li>
                    </ul>
                </div>
                <div class="flex-1">
                    <p class="uppercase text-while-500 md:mb-6">SOBRE NOSOTROS</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/about/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Quienes
                                Somos</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/services/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Nuestros
                                Servicios</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/contact-us/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Contactanos</a>
                        </li>
                    </ul>
                </div>
                <div class="flex-1">
                    <p class="uppercase text-while-500 md:mb-6">NUESTROS SERVICIOS</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/ems/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Envió de
                                Mensajería Urgente</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/sp/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Servicio
                                Prioritario</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/eca/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Envíos de
                                Correspondencia Agrupada</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/eca/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Mi
                                Encomienda</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/filatelia/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Servicio de
                                Filatelia</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/casillas/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Servicio de
                                Casillas</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/construccion/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Tracking Postal
                                Internacional</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="https://correos.gob.bo/construccion/"
                                class="no-underline hover:underline text-while-800 hover:text-blue-500">Calculadora
                                Postal</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <div class="footer-content">
                <hr class="line-divider text-black">
                <p class="mb-2 text-lg text-while">#EstamosSaliendoAdelante #RumboalBicentenario</p>
                <p class="mb-2 text-lg text-while">&copy; {{ date('Y') }} Todos los derechos reservados - Agencia
                    Boliviana de Correos</p>
                <p class="text-lg text-while">Contacto: (591-2) 2152423 - Av. Mariscal Santa Cruz Esq. C. Oruro Edif.
                    Telecomunicaciones - agbc@correos.gob.bo</p>
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
    @livewireScripts
    @livewire('livewire-ui-modal')
</body>

</html>
