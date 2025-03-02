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

    <div class="container mx-auto px-2 py-1">
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
    <footer class="fixed bottom-0 left-0 z-20 w-full bg-white border-t border-gray-300 shadow-t-md dark:bg-gray-800 dark:border-gray-600 shadow-inner">
        <div class="flex justify-around items-center px-6 py-3">
            <!-- Botón Nou Instrument -->
            <a href="{{ route('instrument.create') }}"
                class="flex flex-col items-center text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 transition">
                    <svg width="32px" height="32px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools --> <title>ic_fluent_apps_add_in_24_regular</title> <desc>Created with Sketch.</desc> <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ic_fluent_apps_add_in_24_regular" fill="#0c6600" fill-rule="nonzero"> <path d="M10.5,3 C11.7426407,3 12.75,4.00735931 12.75,5.25 L12.75,11.25 L18.75,11.25 C19.9926407,11.25 21,12.2573593 21,13.5 L21,18.75 C21,19.9926407 19.9926407,21 18.75,21 L5.25,21 C4.00735931,21 3,19.9926407 3,18.75 L3,5.25 C3,4.00735931 4.00735931,3 5.25,3 L10.5,3 Z M11.25,12.75 L4.5,12.75 L4.5,18.75 C4.5,19.1642136 4.83578644,19.5 5.25,19.5 L11.249,19.5 L11.25,12.75 Z M18.75,12.75 L12.749,12.75 L12.749,19.5 L18.75,19.5 C19.1642136,19.5 19.5,19.1642136 19.5,18.75 L19.5,13.5 C19.5,13.0857864 19.1642136,12.75 18.75,12.75 Z M10.5,4.5 L5.25,4.5 C4.83578644,4.5 4.5,4.83578644 4.5,5.25 L4.5,11.25 L11.25,11.25 L11.25,5.25 C11.25,4.83578644 10.9142136,4.5 10.5,4.5 Z M17.8982294,2.00684662 L18,2 C18.3796958,2 18.693491,2.28215388 18.7431534,2.64822944 L18.75,2.75 L18.75,5.25 L21.25,5.25 C21.6296958,5.25 21.943491,5.53215388 21.9931534,5.89822944 L22,6 C22,6.37969577 21.7178461,6.69349096 21.3517706,6.74315338 L21.25,6.75 L18.75,6.75 L18.75,9.25 C18.75,9.62969577 18.4678461,9.94349096 18.1017706,9.99315338 L18,10 C17.6203042,10 17.306509,9.71784612 17.2568466,9.35177056 L17.25,9.25 L17.25,6.75 L14.75,6.75 C14.3703042,6.75 14.056509,6.46784612 14.0068466,6.10177056 L14,6 C14,5.62030423 14.2821539,5.30650904 14.6482294,5.25684662 L14.75,5.25 L17.25,5.25 L17.25,2.75 C17.25,2.37030423 17.5321539,2.05650904 17.8982294,2.00684662 Z" id="🎨-Color"> </path> </g> </g> </g></svg>
                <span class="text-xs mt-1 font-bold">{{ __('Nou instrument') }}</span>
            </a>
        </div>
    </footer>
    
</x-app-layout>

