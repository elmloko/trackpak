<div class="pt-24">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <!-- Columna Izquierda -->
        <div class="flex flex-col w-full md:w-2/5 justify-center items-center md:items-start text-center md:text-left">
            <p class="uppercase tracking-loose w-full">¿Estás buscando tu paquete?</p>
            <h1 class="my-4 text-5xl font-bold leading-tight">
                RASTREA TU CODIGO
            </h1>
            <p class="leading-normal text-2xl mb-6">
                Este es un servicio de seguimiento de codigo rastreo postales a nivel internacional / nacional de la Agencia Boliviana de Correos
            </p>
            <form method="GET" action="{{ route('search') }}" class="w-full">
                @csrf
                <div class="flex items-center">
                    <input type="text" name="codigo" placeholder="Ingresa tu código de rastreo"
                        class="w-full py-3 px-4 mx-3 border rounded-full text-black" style="width: 100%;"
                        pattern=".{13,13}" required title="El código de rastreo debe tener 13 dígitos">
                        <button type="submit"
                    class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full mt-4 lg:mt-0 py-3 px-8 shadow opacity-75 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">Buscar</button>
                </div>
                <div class="mt-4">
                    <div class="g-recaptcha flex justify-center mt-4" data-sitekey="6LcJRHQpAAAAABKCk7seFIHEImEUo2Q31tPLpSjX"></div>
                </div>
            </form>
        </div>
        <!-- Columna Derecha -->
        <div class="w-full md:w-3/5 py-6 text-center">
            <img class="w-2/3 md:w-1/2 mx-auto z-50" src="{{ asset('images/MONITO.png') }}" />
        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
