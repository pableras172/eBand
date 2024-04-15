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

    <div>
        <div class="container mx-auto py-2 px-2 sm:px-6 lg:px-0">        
            <div class="block mb-2">
                <div class="flex justify-end">
            <a href="instrument/create"
                class="bg-green-800 hover:bg-green-600 text-white font-bold py-2 px-4 rounded inline-block mr-2">{{__('Nou instrument')}}</a>
                </div>
        </div>
    </div>

       
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                            {{__('Nom')}}
                                        </th>
                                        <th scope="col" class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                            {{__('Imatge')}}
                                        </th>
                                        <th scope="col" width="200" class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                            {{__('Accions')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($intruments as $intrument)
                                        <tr>
                                            <td
                                                class="px-4 py-2 whitespace-nowrap text-sm text-center text-gray-900 text-center">
                                                {{ $intrument->name }}
                                            </td>

                                            <td
                                                class="px-4 py-2 whitespace-nowrap text-sm text-center text-gray-900 text-center">
                                                <div class="mt-2 text-center">
                                                    <img src="{{ asset('storage/imagenes/instruments/' . $intrument->icon) }}"
                                                        alt="{{ $intrument->name }}" class="rounded-full"
                                                        style="width: 50px; height: 50px;">
                                                </div>
                                            </td>

                                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-center">
                                                <a href="{{ route('instrument.show', $intrument->id) }}"
                                                    class="bg-fondobotonazul hover:bg-fondobotonazul-400 text-white font-bold py-2 px-4 rounded">
                                                    {{__('Editar')}}
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

</x-app-layout>
