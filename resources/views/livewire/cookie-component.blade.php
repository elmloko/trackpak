<div>
    @if ($showBar)
        <div class="fixed bottom-0 left-0 w-full px-4 py-12 bg-gray-700 text-white">
            <div class="flex items-center gap-4">
                <div class="w-3/12"></div>
                <div class="flex-1">
                    <p>Al acceder y utilizar nuestra página web, aceptas la responsabilidad exclusiva del uso adecuado de los códigos de rastreo de tus envíos. Garantizamos la confidencialidad de tu información personal y los detalles de paquetería. Utilizamos cookies para mejorar tu experiencia, y cualquier cambio en la política será efectivo al ser publicado.</p>
                </div>
                <div class="w-3/12">
                    <button wire:click="aceptarCookie" class="w-full px-3 py-2 bg-blue-700 border-white hover:bg-blue-800">Aceptar Cookies</button>
                </div>
            </div>
        </div>
    @endif
</div>
