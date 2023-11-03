<div>
    @if ($showBar)
        <div class="flex items-center absolute bottom-0 left-0 gap-4 w-full px-4 py-12 bg-gray-700 text-while">
            <div class="w-3/12"></div>
            <div class="flex-1">
                <p>texto laaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaargo</p>
            </div>
            <div class="w-3/12">
                <button wire:click="aceptarCookie" class="w-full px-3 py-2 bg-blue-700 border-white hover:bg-blue-800">Aceptar Cookies</button>
            </div>
        </div>
    @endif
</div>
