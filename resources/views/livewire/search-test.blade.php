<div class="pt-24">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <!-- Columna Izquierda -->
        <div class="flex flex-col w-full md:w-2/5 justify-center items-center md:items-start text-center md:text-left">
            <p class="uppercase tracking-loose w-full">¿Estás buscando tu paquete?</p>
            <h1 class="my-4 text-5xl font-bold leading-tight">
                RASTREA TU CODIGO
            </h1>
            <p class="leading-normal text-2xl mb-6">
                Este es un servicio de seguimiento de codigo rastreo postales a nivel internacional / nacional de la
                Agencia Boliviana de Correos
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
                <br>
                <div>
                    <label for="captcha" class="leading-normal text-2xl mb-6">Verificación de seguridad:</label>
                    <br>
                    <input type="text" name="captcha"
                        class="w-1/8 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400 text-black"
                        placeholder="Ingrese el texto del captcha">
                    <div class="flex items-center space-x-3">
                        <div id="captcha-img" class="border rounded text-black">{!! captcha_img('flat') !!}</div>
                        {{-- <button type="button" id="refresh-captcha"
                            class="text-sm px-3 py-2 border rounded bg-gray-200 hover:bg-gray-300 transition text-black">
                            <i class="fa fa-refresh mr-1"></i>Recargar
                        </button> --}}
                    </div>
                    @error('captcha')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>
            </form>
        </div>
        <!-- Columna Derecha -->
        <div class="w-full md:w-3/5 py-6 text-center">
            <img class="w-2/3 md:w-1/2 mx-auto z-50" src="{{ asset('images/MONITO.png') }}" />
        </div>
    </div>
</div>
<script>
    document.getElementById('refresh-captcha').addEventListener('click', function() {
        fetch('/captcha-refresh')
            .then(res => res.json())
            .then(data => {
                document.querySelector('span').innerHTML = data.captcha;
            });
    });
</script>
{{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}
