<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Afegir actuació a {{ $contrato->descripcion }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-10 px-4 sm:px-8 lg:px-32">
        <!-- Formulario -->
        <form action="{{ route('actuacion.store') }}" method="POST" class="max-w-lg mx-auto">
            @csrf
            <div class="mb-4">
                <label for="fechaActuacion" class="block text-sm font-medium text-gray-700">Fecha de Actuación</label>
                <input type="date" id="fechaActuacion" name="fechaActuacion" required
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3" required
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>

            <div class="mb-4">
                <label for="tipoactuacions_id" class="block text-sm font-medium text-gray-700">Tipo de Actuación</label>
                <select id="tipoactuacions_id" name="tipoactuacions_id" required
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <!-- Iterar sobre las opciones del select -->
                    @foreach ($tipoActuacion as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="coches" class="block text-sm font-medium text-gray-700">Número de Coches</label>
                    <input type="number" id="coches" name="coches"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="preciocoche" class="block text-sm font-medium text-gray-700">Precio por Coche</label>
                    <input type="number" id="preciocoche" name="preciocoche" step="0.01"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="musicos" class="block text-sm font-medium text-gray-700">Número de Músicos</label>
                    <input type="number" id="musicos" name="musicos"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="preciomusico" class="block text-sm font-medium text-gray-700">Precio por Músico</label>
                    <input type="number" id="preciomusico" name="preciomusico" step="0.01"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
            </div>

            <div class="mb-4">
                <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
                <textarea id="observaciones" name="observaciones" rows="3"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>
            <div class="mb-4">
                <label for="pagado" class="block text-sm font-medium text-gray-700">Pagado</label>
                <input type="checkbox" id="pagado" name="pagado"
                    class="mt-1 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                    {{ old('pagado') ? 'checked' : '' }}>
            </div>            
            <input type="hidden" id="contratos_id" name="contratos_id" value="{{ $contrato->id }}" />
            <div class="flex justify-center">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-gray-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Guardar</button>
            </div>
        </form>

        <!-- Grid de actuaciones -->
        <div class="mt-8">
            <h2 class="text-lg font-semibold mb-4">Actuaciones del Contrato</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($actuaciones as $actuacion)
                    <div class="bg-gray-100 p-4 rounded-md">
                        <p><span class="font-semibold">Fecha:</span> {{ $actuacion->fechaActuacion }}</p>
                        <p><span class="font-semibold">Descripción:</span> {{ $actuacion->descripcion }}</p>
                        <!-- Otros campos de actuaciones aquí -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
