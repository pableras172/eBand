@if (!empty($errores))
    <div class="mb-4 p-3 bg-yellow-100 border border-yellow-400 text-yellow-800 rounded text-sm">
        <strong>{{ __('Importación finalizada. Errores encontrados:') }} {{ count($errores) }}</strong>
        <ul class="mt-2 list-disc list-inside space-y-1">
            @foreach ($errores as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($mensajeExito)
    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-800 rounded">
        {{ $mensajeExito }}
    </div>
@endif


<div class="mt-10 max-w-xl mx-auto bg-white border border-gray-300 rounded-lg p-6 shadow-sm">

    <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">
        {{ __('Importar actuaciones desde Excel') }}
    </h3>

    <form wire:submit.prevent="importar" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Selecciona el archivo Excel') }}
            </label>
            <input type="file" wire:model="excel" accept=".xlsx,.xls"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('excel')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-center">
            <button type="submit" wire:loading.attr="disabled"
                class="inline-flex items-center px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                <span wire:loading.remove>{{ __('Importar') }}</span>
                <span wire:loading>{{ __('Importando...') }}</span>
            </button>
        </div>

    </form>
</div>
