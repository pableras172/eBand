<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tipus de actuacio') }}
        </h2>
    </x-slot>

    @if (request()->has('success') && request()->success)
        <div class="bg-green-200 text-green-800 py-2 px-4 mb-1 rounded">
            {{ request()->success }}
        </div>
    @endif

    @if (request()->has('error') && request()->error)
        <div class="bg-green-200 text-green-800 py-2 px-4 mb-4 rounded">
            {{ request()->error }}
        </div>
    @endif

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-2 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.657-1.79 3-4 3s-4-1.343-4-3 1.79-3 4-3 4 1.343 4 3zm12-3c0 1.657-1.79 3-4 3s-4-1.343-4-3 1.79-3 4-3 4 1.343 4 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Tipus d\'actuació') }}</h3>
            </div>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('Nom') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('Imatge') }}
                        </th>
                        <th scope="col" class="hidden sm:table-cell px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('Accions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach ($tipoactuacions as $tipoactuacion)
                        <tr class="hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors cursor-pointer"
                            onclick="window.location='{{ route('tipoactuacion.show', $tipoactuacion->id) }}'">
                            <td class="px-6 py-3 text-sm text-gray-900 dark:text-gray-100">
                                <div class="flex items-center gap-2">
                                    @if ($tipoactuacion->tipoensayo)
                                        <x-atril w="24" h="24" />
                                    @endif
                                    @if ($tipoactuacion->tipoconcierto)
                                        <x-concert w="24" h="24" />
                                    @endif
                                    <span class="font-medium">{{ $tipoactuacion->nombre }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-center">
                                @if ($tipoactuacion->icon)
                                    <img src="{{ asset('storage/imagenes/tipoactuacion/' . $tipoactuacion->icon) }}"
                                        alt="{{ $tipoactuacion->nombre }}"
                                        class="w-10 h-10 rounded-full object-cover mx-auto">
                                @else
                                    <div class="flex justify-center">
                                        <x-nophoto w="40" h="40" />
                                    </div>
                                @endif
                            </td>
                            <td class="hidden sm:table-cell px-6 py-3 text-center">
                                <a href="{{ route('tipoactuacion.show', $tipoactuacion->id) }}"
                                   onclick="event.stopPropagation()"
                                   class="inline-flex items-center justify-center">
                                    <x-editar w="24" h="24" />
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <x-statistics.tipoactuaciones />
    
    <footer
        class="fixed bottom-0 left-0 z-20 w-full bg-white border-t border-gray-300 shadow-inner dark:bg-gray-800 dark:border-gray-600">
        <div class="flex justify-center items-center py-3">
            <!-- Botón Afegir -->
            <a href="{{ route('tipoactuacion.create') }}"
                class="flex flex-col items-center text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 transition">
                <svg width="32px" height="32px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                        <title>ic_fluent_apps_add_in_24_regular</title>
                        <desc>Created with Sketch.</desc>
                        <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="ic_fluent_apps_add_in_24_regular" fill="#0c6600" fill-rule="nonzero">
                                <path
                                    d="M10.5,3 C11.7426407,3 12.75,4.00735931 12.75,5.25 L12.75,11.25 L18.75,11.25 C19.9926407,11.25 21,12.2573593 21,13.5 L21,18.75 C21,19.9926407 19.9926407,21 18.75,21 L5.25,21 C4.00735931,21 3,19.9926407 3,18.75 L3,5.25 C3,4.00735931 4.00735931,3 5.25,3 L10.5,3 Z M11.25,12.75 L4.5,12.75 L4.5,18.75 C4.5,19.1642136 4.83578644,19.5 5.25,19.5 L11.249,19.5 L11.25,12.75 Z M18.75,12.75 L12.749,12.75 L12.749,19.5 L18.75,19.5 C19.1642136,19.5 19.5,19.1642136 19.5,18.75 L19.5,13.5 C19.5,13.0857864 19.1642136,12.75 18.75,12.75 Z M10.5,4.5 L5.25,4.5 C4.83578644,4.5 4.5,4.83578644 4.5,5.25 L4.5,11.25 L11.25,11.25 L11.25,5.25 C11.25,4.83578644 10.9142136,4.5 10.5,4.5 Z M17.8982294,2.00684662 L18,2 C18.3796958,2 18.693491,2.28215388 18.7431534,2.64822944 L18.75,2.75 L18.75,5.25 L21.25,5.25 C21.6296958,5.25 21.943491,5.53215388 21.9931534,5.89822944 L22,6 C22,6.37969577 21.7178461,6.69349096 21.3517706,6.74315338 L21.25,6.75 L18.75,6.75 L18.75,9.25 C18.75,9.62969577 18.4678461,9.94349096 18.1017706,9.99315338 L18,10 C17.6203042,10 17.306509,9.71784612 17.2568466,9.35177056 L17.25,9.25 L17.25,6.75 L14.75,6.75 C14.3703042,6.75 14.056509,6.46784612 14.0068466,6.10177056 L14,6 C14,5.62030423 14.2821539,5.30650904 14.6482294,5.25684662 L14.75,5.25 L17.25,5.25 L17.25,2.75 C17.25,2.37030423 17.5321539,2.05650904 17.8982294,2.00684662 Z"
                                    id="🎨-Color"> </path>
                            </g>
                        </g>
                    </g>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Afegir') }}</span>
            </a>
        </div>
    </footer>


</x-app-layout>
