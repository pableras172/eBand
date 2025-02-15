<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Llistat de Instruments
        </h2>
    </x-slot>

    <div>
        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="block mb-8">
                <a href="{{ route('instrument.create') }}" class="bg-green-800 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Nou intrument</a>
            </div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                <tr>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Icon
                                    </th>
                                    <th scope="col" width="200" class="px-6 py-3 bg-gray-50">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($intruments as $intrument)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900">
                                            {{ $intrument->id }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900">
                                            {{ $intrument->name }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900">
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/imagenes/instruments/'.$intrument->icon) }}" alt="{{ $intrument->name }}" class="rounded-full" style="width: 50px; height: 50px;">
                                            </div>                                                
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('instrument.show', $intrument->id) }}" >
                                                <span class="material-symbols-outlined">
                                                    edit
                                                </span>
                                            </a>                                            
                                            <form class="inline-block" action="{{ route('instrument.destroy', $intrument->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <span class="material-symbols-outlined">delete</span>
                                                <!--input type="submit" class="text-red-600 hover:text-red-900 mb-2 mr-2" value="Delete"-->
                                            </form>
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
