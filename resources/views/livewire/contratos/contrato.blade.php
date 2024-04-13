<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nou contracte
        </h2>
    </x-slot>

    <div class="container mx-auto py-10 px-4 sm:px-0">

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">¡Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif


        <form method="post" class="max-w-lg mx-auto"
            action="{{ isset($contrato) ? route('contratos.update', $contrato->id) : route('contratos.store') }}">
            @csrf
            @if (isset($contrato))
                @method('PUT')
            @endif
            <div class="mb-4">
                <label for="poblacion" class="block text-sm font-medium text-gray-700">Población</label>
                <input type="text" id="poblacion" name="poblacion"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ isset($contrato) ? $contrato->poblacion : old('poblacion') }}" required>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="fechainicio" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                    <input type="date" id="fechainicio" name="fechainicio"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        value="{{ isset($contrato) ? $contrato->fechainicio : old('fechainicio') }}" required>
                </div>
                <div>
                    <label for="fechafin" class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                    <input type="date" id="fechafin" name="fechafin"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        value="{{ isset($contrato) ? $contrato->fechafin : old('fechafin') }}" required>
                </div>
            </div>
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3" required
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ isset($contrato) ? $contrato->descripcion : old('descripcion') }}</textarea>
            </div>
            <div class="mb-4">
                <label for="contacto" class="block text-sm font-medium text-gray-700">Contacto</label>
                <input type="text" id="contacto" name="contacto" required
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ isset($contrato) ? $contrato->contacto : old('contacto') }}">
            </div>
            <div class="mb-4">
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="text" id="telefono" name="telefono"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ isset($contrato) ? $contrato->telefono : old('telefono') }}">
            </div>
            <div class="mb-4">
                <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" id="correo" name="correo"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ isset($contrato) ? $contrato->correo : old('correo') }}">
            </div>
            <div class="mb-4">
                <label for="anyo" class="block text-sm font-medium text-gray-700">Año</label>
                <input type="number" id="anyo" name="anyo"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ isset($contrato) ? $contrato->anyo : old('anyo') }}">
            </div>
            <div class="mb-4">
                <label for="dnicontacto" class="block text-sm font-medium text-gray-700">DNI del Contacto</label>
                <input type="text" id="dnicontacto" name="dnicontacto"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ isset($contrato) ? $contrato->dnicontacto : old('dnicontacto') }}">
            </div>
            <div class="mb-4">
                <label for="observacions" class="block text-sm font-medium text-gray-700">Observaciones</label>
                <textarea id="observacions" name="observacions" rows="3"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ isset($contrato) ? $contrato->observacions : old('observacions') }}</textarea>
            </div>
            <div class="flex justify-center">
                <button type="submit" id="submitBtn"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-gray-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2">Guardar</button>
            </div>
        </form>



    </div>
    </div>
    <div style="height: 75px">

    </div>
    <footer
        class="fixed bottom-0 left-0 z-20 w-full p-2 bg-white border-t border-black-800 shadow md:flex md:items-center md:justify-between md:p-6 dark:bg-gray-800 dark:border-gray-600">
        <div class="flex justify-center">
            @if (isset($contrato))
            <form action="{{ route('contratos.destroy', $contrato) }}" method="post"
                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este contrato? Se eliminaran las actuaciones y las listas relacionadas.')">
                @csrf
                @method('DELETE')
                <div class="block text-right">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        Eliminar
                    </button>
                </div>
            </form>
            @endif

            <a href="{{ route('contratos.index') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-blue-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition  ml-2">
                Cancelar
            </a>
        </div>
    </footer>
</x-app-layout>
