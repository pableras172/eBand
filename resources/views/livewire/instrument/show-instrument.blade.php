<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Llistat de Instruments')}}
        </h2>       
    </x-slot>

    @if (request()->has('success') && request()->success)
        <div class="bg-green-200 text-green-800 py-2 px-4 mb-4 rounded">
            {{__('El instrumento se ha eliminado correctamente')}}
        </div>
    @endif

    <div class="container mx-auto px-4 py-2">
        <div class="block mb-2">
            <div class="flex justify-end">
                <a href="instrument/create"
                    class="bg-green-800 hover:bg-green-600 text-white font-bold py-2 px-4 rounded inline-block mr-2">{{__('Nou instrument')}}</a>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Nom')}}
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider ">
                                        {{__('Imatge')}}
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider ">
                                        {{__('Ordre')}}
                                    </th>
                                    <th scope="col"                                        
                                        class="px-4 py-2 bg-gray-50 text-center text-xs font-medium text-gray-500 uppercase tracking-wider ">
                                        {{__('Accions')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="instrumentTable">
                                @foreach ($intruments as $index => $intrument)
                                    <tr data-id="{{ $intrument->id }}" class="instrument-row">
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-center text-gray-900">
                                            {{ $intrument->name }}
                                        </td>
                            
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-center text-gray-900">
                                            <div class="mt-2 text-center">
                                                @if ($intrument->icon)
                                                    <!-- Si hay imagen, mostrarla -->
                                                    <img src="{{ asset('storage/imagenes/instruments/' . $intrument->icon) }}"
                                                         alt="{{ $intrument->name }}" 
                                                         class="rounded-full"
                                                         style="width: 50px; height: 50px;">
                                                @else
                                                    <!-- Mostrar icono predeterminado si no hay imagen -->
                                                    <x-nophoto w="40" h="40"/>
                                                @endif
                                            </div>
                                        </td>
                                        
                            
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-center text-gray-900">
                                            <span class="orden">{{ $intrument->orden }}</span>
                                        </td>
                            
                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-center">
                                            <div class="flex justify-center items-center space-x-1">
                                                                                                <!-- Botón de editar existente -->
                                            <a href="{{ route('instrument.show', $intrument->id) }}">
                                                <x-editar w="24" h="24" />
                                            </a>
                                            <!-- Botón subir -->
                                                <button class="move-up text-blue-600 hover:text-blue-900 px-1" title="Subir"><x-flechaup w="24" h="24" /></button>
                                                <!-- Botón bajar -->
                                                <button class="move-down text-blue-600 hover:text-blue-900 px-1" title="Bajar"><x-flechadown w="24" h="24" /></button>

                                            </div>
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

</x-app-layout>

