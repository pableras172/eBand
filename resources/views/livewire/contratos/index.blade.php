<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Llistat de contrats
        </h2>
    </x-slot>

    @if (request()->has('success') && request()->success)
        <div class="bg-green-200 text-green-800 py-2 px-4 mb-4 rounded">
            S'ha creat el contracte!
        </div>
    @endif
    @if (request()->has('deletesuccess') && request()->success)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
            role="alert">
            <strong class="font-bold">¡Eliminado!</strong>
            <span class="block sm:inline">{{ 'Se ha eliminado el contrato.' }}</span>
        </div>
    @endif
    
    <div class="container mx-auto py-2 px-2 sm:px-6 lg:px-0">
        <div class="block mb-2">
            <div class="flex justify-end">
                <a href="{{ route('contratos.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Nou contracte</a>
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
                                        class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Població
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        Descripció
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        Data Inici
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        Data de Fi
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        Contacte
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Accions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($contratos as $contrato)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $contrato->poblacion }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $contrato->descripcion }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $contrato->fechainicio ? \Carbon\Carbon::parse($contrato->fechainicio)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $contrato->fechafin ? \Carbon\Carbon::parse($contrato->fechafin)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $contrato->contacto }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('contratos.edit', $contrato->id) }}"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-blue-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-2">
                                                Editar
                                            </a>          
                                            &nbsp;                      
                                            <a href="{{ route('actuacion.createtocontract', $contrato->id) }}"
                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-gray-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-2 mr-2">
                                                Actuacions
                                             </a>
                                             
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $contratos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
