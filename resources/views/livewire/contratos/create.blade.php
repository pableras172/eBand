<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Actuación
        </h2>
    </x-slot>

    <div class="container mx-auto py-10 px-4 sm:px-0">
        <form method="post" class="max-w-lg mx-auto" action="{{ route('actuacion.store') }}">
            @csrf
            <div class="mb-4">
                <label for="fechaActuacion" class="block text-sm font-medium text-gray-700">Fecha de Actuación</label>
                <input type="date" id="fechaActuacion" name="fechaActuacion"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ old('fechaActuacion') }}" required>
            </div>
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3" required
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('descripcion') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="coches" class="block text-sm font-medium text-gray-700">Coches</label>
                    <input type="number" id="coches" name="coches" min="0"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        value="{{ old('coches') }}">
                </div>
                <div>
                    <label for="preciocoche" class="block text-sm font-medium text-gray-700">Precio por Coche</label>
                    <input type="number" id="preciocoche" name="preciocoche" min="0" step="0.01"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        value="{{ old('preciocoche') }}">
                </div>
                <div>
                    <label for="musicos" class="block text-sm font-medium text-gray-700">Músicos</label>
                    <input type="number" id="musicos" name="musicos" min="0"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        value="{{ old('musicos') }}">
                </div>
                <div>
                    <label for="preciomusico" class="block text-sm font-medium text-gray-700">Precio por Músico</label>
                    <input type="number" id="preciomusico" name="preciomusico" min="0" step="0.01"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        value="{{ old('preciomusico') }}">
                </div>
            </div>
            <div class="mb-4">
                <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
                <textarea id="observaciones" name="observaciones" rows="3"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('observaciones') }}</textarea>
            </div>
            <input type="hidden" name="contratos_id" value="{{ $contrato->id }}">
            <div class="flex justify-center">
                <button type="submit" id="submitBtn"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-gray-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Guardar</button>
            </div>
        </form>
    </div> 
       
</x-app-layout>
