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
            <div class="w-full flex flex-col md:flex-row items-center justify-center text-black">
                <input type="text" wire:model.live="search"
                    class="w-full bg-gray-200 rounded-full py-2 px-4 mb-2 md:mb-0" placeholder="Buscar Paquete...">
            </div>
            <ul id="showlist" tabindex="1" class="list-group">
                @if ($search)
                    @foreach ($packages as $package)
                        <li>{{$package->CODIGO}}</li>
                        <li>{{$package->DESTINATARIO}}</li>
                    @endforeach
                    @if ($packages->count() == 0)
                        <p>No hay resultados para la búsqueda <b>"{{$search}}"</b></p>
                    @endif
                @endif
            </ul>
        </div>
        <!-- Right Col -->
        <div class="w-full md:w-3/5 py-6 text-center">
            <img class="w-2/3 md:w-1/2 mx-auto z-50" src="{{ asset('images/MONITO.png') }}" />
        </div>
    </div>
</div>