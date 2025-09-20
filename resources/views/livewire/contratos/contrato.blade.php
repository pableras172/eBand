<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nou contracte') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-10 px-4 sm:px-0">

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">{{ __('Error') }}</strong>
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
                <label for="poblacion" class="block text-sm font-medium text-gray-700">{{ __('Población') }}</label>
                <input type="text" id="poblacion" name="poblacion"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ isset($contrato) ? $contrato->poblacion : old('poblacion') }}" required>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="fechainicio"
                        class="block text-sm font-medium text-gray-700">{{ __('Data Inici') }}</label>
                    <input type="date" id="fechainicio" name="fechainicio"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        value="{{ isset($contrato) ? $contrato->fechainicio : old('fechainicio') }}" required>
                </div>
                <div>
                    <label for="fechafin" class="block text-sm font-medium text-gray-700">{{ __('Data de Fi') }}</label>
                    <input type="date" id="fechafin" name="fechafin"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        value="{{ isset($contrato) ? $contrato->fechafin : old('fechafin') }}" required>
                </div>
            </div>
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">{{ __('Descripció') }}</label>
                <textarea id="descripcion" name="descripcion" rows="3" required
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ isset($contrato) ? $contrato->descripcion : old('descripcion') }}</textarea>
            </div>
            <div class="mb-4">
                <label for="contacto" class="block text-sm font-medium text-gray-700">{{ __('Contacte') }}</label>
                <input type="text" id="contacto" name="contacto" required
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ isset($contrato) ? $contrato->contacto : old('contacto') }}">
            </div>
            <div class="mb-4">
                <label for="telefono" class="block text-sm font-medium text-gray-700">{{ __('Telefon') }}</label>
                <input type="text" id="telefono" name="telefono"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ isset($contrato) ? $contrato->telefono : old('telefono') }}">
            </div>
            <div class="mb-4">
                <label for="correo" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                <input type="email" id="correo" name="correo"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ isset($contrato) ? $contrato->correo : old('correo') }}">
            </div>
            <div class="mb-4">
                <label for="anyo" class="block text-sm font-medium text-gray-700">{{ __('Any') }}</label>
                <input type="number" id="anyo" name="anyo"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ old('anyo', isset($contrato) ? $contrato->anyo : date('Y')) }}" min="1900"
                    max="2100" required>

            </div>
            <div class="mb-4">
                <label for="dnicontacto"
                    class="block text-sm font-medium text-gray-700">{{ __('DNI del Contacto') }}</label>
                <input type="text" id="dnicontacto" name="dnicontacto"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    value="{{ isset($contrato) ? $contrato->dnicontacto : old('dnicontacto') }}">
            </div>
            <div class="mb-4">
                <label for="observacions"
                    class="block text-sm font-medium text-gray-700">{{ __('Observacions') }}</label>
                <textarea id="observacions" name="observacions" rows="3"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ isset($contrato) ? $contrato->observacions : old('observacions') }}</textarea>
            </div>
            <div class="flex justify-center">
                <button type="submit" id="submitBtn"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-green-800 hover:bg-green-600 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2">Guardar</button>
            </div>
        </form>
        @if (isset($contrato))
            @livewire('actuaciones.importar-excel', ['contratoId' => $contrato->id])
        @endif
    </div>

    </div>
    <div style="height: 75px">

    </div>

    <footer
        class="fixed bottom-0 left-0 z-20 w-full bg-white border-t border-gray-300 shadow-t-md dark:bg-gray-800 dark:border-gray-600">
        <div class="flex justify-around items-center space-x-4 py-3">
            @if (isset($contrato))
                <!-- Botón Eliminar Contrato -->
                <form action="{{ route('contratos.destroy', $contrato) }}" method="post"
                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este contrato? Se eliminarán las actuaciones y las listas relacionadas.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex flex-col items-center text-gray-700 hover:text-red-600 dark:text-gray-300 dark:hover:text-red-400 transition">
                        <svg width="32px" height="32px" viewBox="0 0 48 48" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                <title>ic_fluent_delete_48_regular</title>
                                <desc>Created with Sketch.</desc>
                                <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none"
                                    fill-rule="evenodd">
                                    <g id="ic_fluent_delete_48_regular" fill="#610000" fill-rule="nonzero">
                                        <path
                                            d="M24,7.25 C27.1017853,7.25 29.629937,9.70601719 29.7458479,12.7794443 L29.75,13 L37,13 C37.6903559,13 38.25,13.5596441 38.25,14.25 C38.25,14.8972087 37.7581253,15.4295339 37.1278052,15.4935464 L37,15.5 L35.909,15.5 L34.2058308,38.0698451 C34.0385226,40.2866784 32.1910211,42 29.9678833,42 L18.0321167,42 C15.8089789,42 13.9614774,40.2866784 13.7941692,38.0698451 L12.09,15.5 L11,15.5 C10.3527913,15.5 9.8204661,15.0081253 9.75645361,14.3778052 L9.75,14.25 C9.75,13.6027913 10.2418747,13.0704661 10.8721948,13.0064536 L11,13 L18.25,13 C18.25,9.82436269 20.8243627,7.25 24,7.25 Z M33.4021054,15.5 L14.5978946,15.5 L16.2870795,37.8817009 C16.3559711,38.7945146 17.116707,39.5 18.0321167,39.5 L29.9678833,39.5 C30.883293,39.5 31.6440289,38.7945146 31.7129205,37.8817009 L33.4021054,15.5 Z M27.25,20.75 C27.8972087,20.75 28.4295339,21.2418747 28.4935464,21.8721948 L28.5,22 L28.5,33 C28.5,33.6903559 27.9403559,34.25 27.25,34.25 C26.6027913,34.25 26.0704661,33.7581253 26.0064536,33.1278052 L26,33 L26,22 C26,21.3096441 26.5596441,20.75 27.25,20.75 Z M20.75,20.75 C21.3972087,20.75 21.9295339,21.2418747 21.9935464,21.8721948 L22,22 L22,33 C22,33.6903559 21.4403559,34.25 20.75,34.25 C20.1027913,34.25 19.5704661,33.7581253 19.5064536,33.1278052 L19.5,33 L19.5,22 C19.5,21.3096441 20.0596441,20.75 20.75,20.75 Z M24,9.75 C22.2669685,9.75 20.8507541,11.1064548 20.7551448,12.8155761 L20.75,13 L27.25,13 C27.25,11.2050746 25.7949254,9.75 24,9.75 Z"
                                            id="🎨-Color"> </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <span class="text-xs mt-1 font-bold text-red-600">{{ __('Eliminar') }}</span>
                    </button>
                </form>
            @endif

            <!-- Botón Cancelar -->
            <a href="{{ route('contratos.index') }}"
                class="flex flex-col items-center text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition">
                <svg width="32px" height="32px" viewBox="0 0 28 28" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M8 6.75C8 6.33579 8.33578 6 8.75 6H15.75C18.0865 6 20.0117 6.78107 21.25 8.01578C22.4814 9.2436 23 10.8763 23 12.5C23 14.1237 22.4814 15.7564 21.25 16.9842C20.0117 18.2189 18.0865 19 15.75 19H7.56066L10.7803 22.2197C11.0732 22.5126 11.0732 22.9874 10.7803 23.2803C10.4874 23.5732 10.0126 23.5732 9.71967 23.2803L5.21967 18.7803C5.07902 18.6397 5 18.4489 5 18.25C5 18.0511 5.07902 17.8603 5.21967 17.7197L9.71967 13.2197C10.0126 12.9268 10.4874 12.9268 10.7803 13.2197C11.0732 13.5126 11.0732 13.9874 10.7803 14.2803L7.56066 17.5H15.75C17.7385 17.5 19.1758 16.8436 20.1 15.922C21.0311 14.9936 21.5 13.7513 21.5 12.5C21.5 11.2487 21.0311 10.0064 20.1 9.07797C19.1758 8.15643 17.7385 7.5 15.75 7.5H8.75C8.33578 7.5 8 7.16421 8 6.75Z"
                            fill="#7f7834"></path>
                    </g>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Volver') }}</span>
            </a>
        </div>
    </footer>

</x-app-layout>
