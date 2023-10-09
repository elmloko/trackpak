<div class="pt-24">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <!-- Left Col -->
        <div class="flex flex-col w-full md:w-2/5 justify-center items-center md:items-start text-center md:text-left">
            <p class="uppercase tracking-loose w-full">¿Estás buscando tu paquete?</p>
            <h1 class="my-4 text-5xl font-bold leading-tight">
                RASTREA TU PAQUETE NACIONAL
            </h1>
            <p class="leading-normal text-2xl mb-8">
                Un servicio de seguimiento de paquetería postal de la Agencia Boliviana de Correos
            </p>
            <div class="w-full bg-white rounded p-4">
                <input type="text" wire:model.live="search"
                    class="w-full bg-gray-200 rounded-full py-2 px-4 mb-2 md:mb-0 text-black" placeholder="Buscar Paquete...">
                @if ($search)
                    <div class="w-full bg-white rounded p-4 mt-4">
                        @foreach ($results as $results)
                            <div class="mb-4 text-black" tabindex="1">
                                Su paquete <strong>{{ $results->CODIGO }}</strong> se encuentra en 
                                <strong>{{ $results->CUIDAD }}</strong> en la ventanilla
                                <strong>{{ $results->VENTANILLA }}</strong>
                            </div>
                            @if (!$loop->last)
                                <!-- Verifica si no es el último elemento -->
                                <div class="mb-4 border-b border-gray-300"></div>
                            @endif
                        @endforeach
                        @if ($results->count() == 0)
                            <p>No hay resultados para la búsqueda <b>"{{ $search }}"</b></p>
                        @endif
                    </div>
                @endif
            </div>
            <!-- Right Col -->
            <div class="w-full md:w-3/5 py-6 text-center">
                <img class="w-2/3 md:w-1/2 mx-auto z-50" src="{{ asset('images/MONITO.png') }}" />
            </div>
        </div>
    </div>