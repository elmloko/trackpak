<div class="pt-24">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <!-- Columna Izquierda -->
        <div class="flex flex-col w-full md:w-2/5 justify-center items-center md:items-start text-center md:text-left">
            <p class="uppercase tracking-loose w-full">¿Estás buscando tu paquete?</p>
            <h1 class="my-4 text-5xl font-bold leading-tight">
                RASTREA TU CODIGO POSTAL
            </h1>
            <p class="leading-normal text-2xl mb-6">
                Este es un servicio de seguimiento de codigo rastreo postales a nivel nacional de la Agencia Boliviana de Correos
            </p>

            <!-- Modificar el formulario de búsqueda con los estilos deseados -->
            <form method="GET" action="{{ route('search') }}" class="w-full">
                @csrf
                <div class="flex items-center">
                    <div class="w-full p-4">
                        <label for="codigo" class="sr-only">Ingresa tu código postal</label>
                        <input type="text" id="codigo" name="codigo" wire:model.live="search" placeholder="Ingresa tu código postal"
                            class="w-full py-3 px-4 mx-3 border rounded-full text-black" style="width: 100%;">
            
                        @if ($search)
                            <div class="bg-white rounded p-4 mt-4">
                                @forelse ($results as $result)
                                    <div class="mb-4 text-black" tabindex="1">
                                        @if ($result->ESTADO == 'ENTREGADO')
                                            Su paquete <strong>{{ $result->CODIGO }}</strong> ha sido entregado!
                                        @elseif ($result->ESTADO == 'CLASIFICACION')
                                            Su paquete <strong>{{ $result->CODIGO }}</strong> está en proceso de Distribución.
                                        @elseif ($result->ESTADO == 'VENTANILLA')
                                            Su paquete <strong>{{ $result->CODIGO }}</strong> se encuentra en
                                            <strong>{{ $result->CUIDAD }}</strong>, en la ventanilla
                                            <strong>{{ $result->VENTANILLA }}</strong>
                                            @if ($result->ADUANA == 'SI')
                                                envío observado por <strong>ADUANA NACIONAL</strong>
                                            @endif
                                        @else
                                            Su paquete <strong>{{ $result->CODIGO }}</strong> tiene un estado no reconocido.
                                        @endif
                                    </div>
                                    @if (!$loop->last)
                                        <!-- Verifica si no es el último elemento -->
                                        <div class="mb-4 border-b border-gray-300"></div>
                                    @endif
                                @empty
                                    <p class="mb-4 text-black">No hay resultados para la búsqueda
                                        <b>"{{ $search }}"</b>
                                    </p>
                                @endforelse
                            </div>
                        @endif
                    </div>
                    <button type="submit"
                        class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full mt-4 lg:mt-0 py-3 px-8 shadow opacity-75 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out"
                        {{ $search ? '' : 'disabled' }}>Buscar Eventos</button>
                </div>
            </form>

            {{-- <form method="GET" action="{{ route('search') }}" class="w-full">
                @csrf
                <div class="flex items-center">
                    <input type="text" name="codigo" placeholder="Ingresa tu código postal"
                        class="w-full py-3 px-4 mx-3 border rounded-full text-black" style="width: 100%;">
                    <button type="submit"
                        class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full mt-4 lg:mt-0 py-3 px-8 shadow opacity-75 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">Buscar</button>
                </div>
            </form> --}}
            
            {{-- <div class="w-full bg-white rounded p-4">
                <input type="text" wire:model.live="search"
                    class="w-full bg-gray-200 rounded-full py-2 px-4 mb-2 md:mb-0 text-black"
                    placeholder="Buscar Paquete...">
                @if ($search)
                    <div class="w-full bg-white rounded p-4 mt-4">
                        @foreach ($results as $result)
                            <div class="mb-4 text-black" tabindex="1">
                                @if ($result->ESTADO == 'ENTREGADO')
                                    Su paquete <strong>{{ $result->CODIGO }}</strong> ha sido entregado!
                                @elseif ($result->ESTADO == 'CLASIFICACION')
                                    Su paquete <strong>{{ $result->CODIGO }}</strong> está en proceso de Distribución.
                                @elseif ($result->ESTADO == 'VENTANILLA')
                                    Su paquete <strong>{{ $result->CODIGO }}</strong> se encuentra en
                                    <strong>{{ $result->CUIDAD }}</strong>, en la ventanilla
                                    <strong>{{ $result->VENTANILLA }}</strong>
                                    @if ($result->ADUANA == 'SI')
                                        envío observado por <strong>ADUANA NACIONAL</strong>
                                    @endif
                                @else
                                    Su paquete <strong>{{ $result->CODIGO }}</strong> tiene un estado no reconocido.
                                @endif
                            </div>
                            @if (!$loop->last)
                                <!-- Verifica si no es el último elemento -->
                                <div class="mb-4 border-b border-gray-300"></div>
                            @endif
                        @endforeach
                        @if ($results->count() == 0)
                            <p class="mb-4 text-black">No hay resultados para la búsqueda <b>"{{ $search }}"</b>
                            </p>
                        @endif
                    </div>
                @endif
            </div> --}}
        </div>
        <!-- Columna Derecha -->
        <div class="w-full md:w-3/5 py-6 text-center">
            <img class="w-2/3 md:w-1/2 mx-auto z-50" src="{{ asset('images/MONITO.png') }}" />
        </div>
    </div>
</div>
