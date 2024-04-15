<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar tipus d\'actuació') }}
        </h2>
    </x-slot>
    <div class="bg-gray-100 dark:bg-gray-900">
        <div class="px-2 py-4">
            <!-- Formulario de eliminación -->
            <form action="{{ route('tipoactuacion.destroy', $tipoactuacion) }}" method="post"
                onsubmit="return confirm('¿Estás seguro de que deseas eliminar el tipo de actuacuón?')">
                @csrf
                @method('DELETE')
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-fondobotonrojo hover:bg-fondobotonrojo-800 text-white font-bold py-2 px-4 rounded">
                        <!-- Cambiamos el texto por un ícono de papelera -->
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Formulario de edición -->
            <form method="post" action="{{ route('tipoactuacion.update', $tipoactuacion) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent shadow sm:rounded-lg">
                    <div class="p-2 lg:p-4">
                        <table class="w-full">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    {{ __('Nom') }}
                                </th>
                                <td class="px-4 py-2">
                                    <input type="text" name="nombre" value="{{ old('nombre', $tipoactuacion->nombre) }}"
                                        class="form-input rounded-md shadow-sm" />
                                    @error('nombre')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </td>
                            </tr>
                            
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                    {{ __('Imatge') }}
                                </th>
                                <td class="px-4 py-2">
                                    @if($tipoactuacion->icon)
                                        <img src="{{ asset('storage/imagenes/tipoactuacion/'.$tipoactuacion->icon) }}" style="height: 50px;width:100px;">
                                    @endif
                                    <input type="file" class="form-control" name="icon" @error('icon') is-invalid @enderror>
                            
                                    @error('icon')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </td>
                            </tr>
                            
                        </table>
                    </div>

                    <div class="text-center py-2">
                        <!-- Botón de guardar -->
                        <x-button>
                            {{ __('Guardar') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
