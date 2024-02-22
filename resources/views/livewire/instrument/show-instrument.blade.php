<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Llistat de Instruments
        </h2>
    </x-slot>

    @if(request()->has('success') && request()->success)
    <div class="bg-green-200 text-green-800 py-2 px-4 mb-4 rounded">
        ¡El instrumento se ha eliminado correctamente!
    </div>
    @endif

    <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">       
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <div class="block text-right mb-6">
                            <a href="instrument/create" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-block">Nou instrument</a>
                        </div>                          
                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead>
                                <tr>
                                    
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-center">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-center">
                                        Icon
                                    </th>
                                    <th scope="col" width="200" class="px-6 py-3 bg-gray-50 text-center">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($intruments as $intrument)
                                <tr>   
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900 text-center">
                                        {{ $intrument->name }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900 text-center">
                                        <div class="mt-2 text-center">
                                            <img src="{{ asset('storage/imagenes/instruments/'.$intrument->icon) }}"
                                                alt="{{ $intrument->name }}" class="rounded-full"
                                                style="width: 50px; height: 50px;">
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <a href="{{ route('instrument.show', $intrument->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Editar
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