<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar información del instrumento
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <!-- Formulario de eliminación -->
                        <form action="{{ route('instrument.destroy', $instrument) }}" method="post"
                            onsubmit="return confirm('¿Estás seguro de que deseas eliminar este instrumento?')">
                            @csrf
                            @method('DELETE')
                            <div class="block text-right">
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                    <!-- Cambiamos el texto por un ícono de papelera -->
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                      </svg>
                                </button>
                            </div>
                        </form>

                        <form method="post" action="{{ route('instrument.update', $instrument->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="max-w-md mx-auto">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div
                                        class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                                <tr class="border-b">
                                                    <th scope="col"
                                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Nombre
                                                    </th>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200">
                                                        <input type="text" name="name" value="{{ $instrument->name }}"
                                                            class="form-input rounded-md shadow-sm mt-1" />
                                                        @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="border-b">
                                                    <th scope="col"
                                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Orden
                                                    </th>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200">
                                                        <input type="text" name="orden" value="{{ $instrument->orden }}"
                                                            class="form-input rounded-md shadow-sm mt-1 block" />
                                                        @error('orden')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="border-b">
                                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Icon
                                                    </th>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-white divide-y divide-gray-200">
                                                        @if($instrument->icon)
                                                            <img src="{{ asset('storage/imagenes/instruments/'.$instrument->icon) }}" style="height: 50px;width:100px;">
                                                        @endif
                                                        <input type="file" class="form-control" name="icon" @error('icon') is-invalid @enderror>
                                                
                                                        @error('icon')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                
                                            </table>
                                        </div>

                                        <div class = "text-center" style="margin-top: 15px;">
                                            <!-- Botón de guardar -->
                                            <x-button class="ms-4 ">
                                                {{ __('Guardar') }}
                                            </x-button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>                        
                    </div>
                </div>              
            </div>
        </div>       
    </div>
    <!-- Botón para regresar a la lista -->
    <div class="block text-center">
        <a href="{{ route('instrument.index') }}"
            class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded">Volver a la
            lista</a>
    </div>
</x-app-layout>