<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tipus de actuació
        </h2>
    </x-slot>

    @if (request()->has('success') && request()->success)
        <div class="bg-green-200 text-green-800 py-2 px-4 mb-4 rounded">
            ¡Actuació creada correctament!
        </div>
    @endif

    <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="mx-4 sm:mx-auto"> <!-- Agregamos el margen a ambos lados -->
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                        class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <div class="block text-right mb-6">
                                <a href="tipoactuacion/create"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-block">{{ __('Afegir') }}</a>
                            </div>
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-4 py-2 bg-gray-50">
                                            {{ __('Nom') }}
                                        </th>
                                        <th scope="col" class="px-4 py-2 bg-gray-50">
                                            {{ __('Imatge') }}
                                        </th>
                                        <th scope="col"  class="px-4 py-2 bg-gray-50">
                                            {{ __('Accions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($tipoactuacions as $tipoactuacion)
                                        <tr>
                                            <td
                                                class="px-4 py-1 whitespace-nowrap text-sm text-gray-900">
                                                {{ $tipoactuacion->nombre }}
                                            </td>
                                            <td
                                                class="px-4 py-1  text-center">
                                                <div class="mt-2 text-center">
                                                    <img src="{{ asset('storage/imagenes/tipoactuacion/' . $tipoactuacion->icon) }}"
                                                        alt="{{ $tipoactuacion->nombre }}" class="rounded-full"
                                                        style="width: 50px; height: 50px;">
                                                </div>
                                            </td>

                                            <td class="px-4 py-1 whitespace-nowrap text-sm font-medium text-center">
                                                <a href="{{ route('tipoactuacion.edit', $tipoactuacion->id) }}"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    {{ __('Editar') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
