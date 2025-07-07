<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar tipus d\'actuació') }}
        </h2>
    </x-slot>
    <div class="max-w-xl mx-auto mt-1 p-4 bg-white shadow-md rounded-lg">
        <!-- Formulario de edición -->
        <form method="POST" action="{{ route('tipoactuacion.update', $tipoactuacion) }}" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">{{__('Nom')}}</label>
                <input type="text" name="nombre" id="nombre"
                    class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('nombre', $tipoactuacion->nombre) }}" required>
                @error('nombre')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Icono -->
            <div class="flex items-center space-x-4">
                <!-- Vista previa del icono actual -->
                <div class="w-full">
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">{{__('Imatge')}}</label>
                    <input type="file" name="icon" id="icon"
                        class="w-full border border-gray-300 rounded-md shadow-sm p-2 cursor-pointer file:bg-blue-100 file:text-blue-700 file:rounded-md file:border-0 file:py-2 file:px-3 hover:file:bg-blue-200"
                        accept="image/*" value="{{ old('icon', $tipoactuacion->icon) }}">
                    @error('icon')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-shrink-0">
                    @if ($tipoactuacion->icon)
                        <img src="{{ asset('storage/imagenes/tipoactuacion/' . $tipoactuacion->icon) }}"
                            alt="Icono actual" class="w-16 h-16 rounded-full border">
                    @else
                        <x-nophoto w="40" h="40" />
                    @endif
                </div>

                <!-- Campo para subir nuevo icono -->

            </div>

            <div>
                <label for="tipoactuacion" class="block text-sm font-medium text-gray-700 mb-1">{{__('Tipus de actuacio')}}</label>
                <select name="tipoactuacion" id="tipoactuacion" class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
                    <option value="" disabled selected>Selecciona un tipo</option>
                    <option value="ensayo" @selected($tipoactuacion->tipoensayo)>{{__('Es de tipo de ensayo')}}</option>
                    <option value="concierto" @selected($tipoactuacion->tipoconcierto)>{{__('Es de tipo de concierto')}}</option>
                </select>
                
                <p class="text-xs text-gray-500 mt-1">ℹ️{{__('ayuda_tipos')}}</p>
            </div>
            
            <!-- Botones -->
            <div class="flex items-center justify-between pt-4">
                <button type="submit"
                    class="bg-green-600 text-white font-bold py-2 px-4 rounded-md hover:bg-green-700 transition">
                    Guardar
                </button>
                <a href="{{ route('tipoactuacion.index') }}" class="text-gray-600 hover:underline text-sm">
                    ← Volver al listado
                </a>
            </div>
        </form>
    </div>
    <footer
        class="fixed bottom-0 left-0 z-20 w-full bg-white border-t border-gray-300 shadow-t-md dark:bg-gray-800 dark:border-gray-600">
        <div class="flex justify-center items-center py-3">
            <!-- Botón Eliminar -->
            <form action="{{ route('tipoactuacion.destroy', $tipoactuacion) }}" method="post"
                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este tipo de actuación?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="flex flex-col items-center text-gray-700 hover:text-red-600 dark:text-gray-300 dark:hover:text-red-400 transition">
                    <svg width="32px" height="32px" viewBox="0 0 48 48" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                            <title>ic_fluent_delete_48_regular</title>
                            <desc>Created with Sketch.</desc>
                            <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
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
        </div>
    </footer>

</x-app-layout>
