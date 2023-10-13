<div class="pt-24">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <!-- Columna Izquierda -->
        <div class="flex flex-col w-full md:w-2/5 justify-center items-center md:items-start text-center md:text-left">
            <p class="uppercase tracking-loose w-full">¿Estás buscando tu paquete?</p>
            <h1 class="my-4 text-5xl font-bold leading-tight">
                RASTREA TU CODIGO POSTAL
            </h1>
            <p class="leading-normal text-2xl mb-6">
                Este es un servicio de seguimiento de paquetería postal nacional de la Agencia Boliviana de Correos
            </p>
            <div class="w-full bg-white rounded p-4">
                <input type="text" wire:model.live="search"
                    class="w-full bg-gray-200 rounded-full py-2 px-4 mb-2 md:mb-0 text-black" placeholder="Buscar Paquete...">
                    @if ($search)
                    <div class="w-full bg-white rounded p-4 mt-4">
                        @foreach ($results as $result)
                            <div class="mb-4 text-black" tabindex="1">
                                @if ($result->ESTADO == "ENTREGADO")
                                    Su paquete <strong>{{ $result->CODIGO }}</strong> ha sido entregado!
                                @else
                                    Su paquete <strong>{{ $result->CODIGO }}</strong> se encuentra en 
                                    <strong>{{ $result->CUIDAD }}</strong>, en la ventanilla
                                    <strong>{{ $result->VENTANILLA }}</strong>
                                @endif
                            </div>
                            @if (!$loop->last)
                                <!-- Verifica si no es el último elemento -->
                                <div class="mb-4 border-b border-gray-300"></div>
                            @endif
                        @endforeach
                        @if ($results->count() == 0)
                            <p class="mb-4 text-black">No hay resultados para la búsqueda <b>"{{ $search }}"</b></p>
                        @endif
                    </div>
                @endif                
            </div>
        </div>
        <!-- Columna Derecha -->
        <div class="w-full md:w-3/5 py-6 text-center">
            <img class="w-2/3 md:w-1/2 mx-auto z-50" src="{{ asset('images/MONITO.png') }}" />
        </div>
    </div>
</div>
