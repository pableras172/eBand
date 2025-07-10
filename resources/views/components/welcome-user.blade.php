<div class="bg-gray-100 min-h-screen flex flex-col items-center">
    <div class="w-full  bg-white p-2 rounded-lg shadow-md text-center mt-1">
        {{-- Avatar del usuario --}}
        <div class="relative w-20 h-20 mx-auto mb-3">
            {{-- Avatar del usuario --}}
            <img class="w-full h-full rounded-full object-cover border-4 border-blue-500"
                src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />

            {{-- Badge con icono del instrumento --}}

            <div
                class="absolute bottom-0 right-0 w-6 h-6 bg-white rounded-full border-2 border-blue-500 flex items-center justify-center">
                @if (isset(Auth::user()->instrument))
                    <img src="{{ asset('storage/imagenes/instruments/' . Auth::user()->instrument->icon) }}"
                        alt="{{ Auth::user()->instrument }}" class="w-4 h-4">
                @else
                    <svg class="w-4 h-4" version="1.1" id="_x36_" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                        fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <path style="fill:#646363;"
                                    d="M468.125,128.73C304.284,99.474,234.069,0,234.069,0S163.847,99.474,0.013,128.73 c0,64.367-5.858,277.944,234.056,383.27C473.976,406.675,468.125,193.098,468.125,128.73z">
                                </path>
                                <path style="fill:#EAEEBE;"
                                    d="M234.069,466.88C63.977,384.073,43.61,240.378,41.255,161.786 c95.349-23.792,158.067-69.25,192.814-101.558c34.747,32.308,97.458,77.766,192.807,101.558 C424.528,240.378,404.155,384.073,234.069,466.88z">
                                </path>
                                <path style="fill:#F0C57B;"
                                    d="M410.284,169.867c-1.813,70.95-19.134,203.716-176.215,279.583 c-29.05-14.015-53.306-29.989-73.582-47.191c-27.411-23.173-47.513-48.568-62.293-74.285 c-33.346-58.164-39.32-118.025-40.346-158.106c88.156-21.531,145.384-63.78,176.221-92.92 c15.328,14.483,37.185,32.21,66.118,49.035c26.16,15.183,58.132,29.637,96.284,40.256 C400.981,167.525,405.6,168.725,410.284,169.867z">
                                </path>
                                <g>
                                    <path style="fill:#716363;"
                                        d="M234.069,76.947c-30.837,29.14-88.066,71.389-176.221,92.92 c0.613,23.74,3.007,54.442,11.742,87.595h164.48V76.947z">
                                    </path>
                                    <path style="opacity:0.26;fill:#F1891A;"
                                        d="M396.472,166.238c-38.152-10.618-70.124-25.073-96.284-40.256 c-28.934-16.825-50.79-34.552-66.118-49.035v180.515h164.506c8.748-33.153,11.103-63.841,11.709-87.595 C405.6,168.725,400.981,167.525,396.472,166.238z">
                                    </path>
                                    <path style="opacity:0.26;fill:#F1891A;"
                                        d="M69.589,257.462c6.012,22.824,15.011,46.8,28.604,70.512 c14.78,25.718,34.882,51.113,62.293,74.285c20.276,17.202,44.532,33.176,73.582,47.191V257.462H69.589z">
                                    </path>
                                    <path style="fill:#716363;"
                                        d="M234.069,449.449c104.49-50.468,147.133-126.108,164.506-191.988H234.069V449.449z">
                                    </path>
                                </g>
                                <path style="opacity:0.08;fill:#231815;"
                                    d="M234.069,0c0,0,70.215,99.474,234.056,128.73c0,64.367,5.851,277.944-234.056,383.27V0 z">
                                </path>
                            </g>
                        </g>
                    </svg>
                @endif
            </div>
        </div>

        {{-- Mensaje de bienvenida --}}
        <h1 class="text-xl font-bold text-gray-800">¡{{ __('Hola') }}, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600 mt-1">{{ __('Nos alegra tenerte de vuelta') }}</p>

        <a href="{{ route('profile.show') }}"
            class="mt-2 flex justify-center items-center text-gray-600 text-sm font-medium hover:text-gray-800 transition">
            {{-- Icono de perfil (SVG) --}}
            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                    <title>ic_fluent_contact_card_24_regular</title>
                    <desc>Created with Sketch.</desc>
                    <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="ic_fluent_contact_card_24_regular" fill="#012f5b" fill-rule="nonzero">
                            <path
                                d="M19.75,4 C20.9926407,4 22,5.00735931 22,6.25 L22,17.754591 C22,18.9972317 20.9926407,20.004591 19.75,20.004591 L4.25,20.004591 C3.00735931,20.004591 2,18.9972317 2,17.754591 L2,6.25 C2,5.00735931 3.00735931,4 4.25,4 L19.75,4 Z M19.75,5.5 L4.25,5.5 C3.83578644,5.5 3.5,5.83578644 3.5,6.25 L3.5,17.754591 C3.5,18.1688046 3.83578644,18.504591 4.25,18.504591 L19.75,18.504591 C20.1642136,18.504591 20.5,18.1688046 20.5,17.754591 L20.5,6.25 C20.5,5.83578644 20.1642136,5.5 19.75,5.5 Z M9.75,12.5 C10.1642136,12.5 10.5,12.8357864 10.5,13.25 L10.5,13.7427321 L10.4921036,13.8512782 C10.3293159,14.964219 9.39767421,15.5009403 7.99995063,15.5009403 C6.60213369,15.5009403 5.67047899,14.9636623 5.50787101,13.8501298 L5.5,13.7417575 L5.5,13.25 C5.5,12.8357864 5.83578644,12.5 6.25,12.5 L9.75,12.5 Z M13.2522936,12.9961404 L17.75,12.9961404 C18.1642136,12.9961404 18.5,13.3319269 18.5,13.7461404 C18.5,14.1258362 18.2178461,14.4396314 17.8517706,14.4892938 L17.75,14.4961404 L13.2522936,14.4961404 C12.83808,14.4961404 12.5022936,14.160354 12.5022936,13.7461404 C12.5022936,13.3664447 12.7844475,13.0526495 13.150523,13.002987 L13.2522936,12.9961404 L17.75,12.9961404 L13.2522936,12.9961404 Z M8,8.50218109 C8.82841293,8.50218109 9.4999743,9.17374246 9.4999743,10.0021554 C9.4999743,10.8305683 8.82841293,11.5021297 8,11.5021297 C7.17158707,11.5021297 6.5000257,10.8305683 6.5000257,10.0021554 C6.5000257,9.17374246 7.17158707,8.50218109 8,8.50218109 Z M13.2522936,9.5 L17.75,9.5 C18.1642136,9.5 18.5,9.83578644 18.5,10.25 C18.5,10.6296958 18.2178461,10.943491 17.8517706,10.9931534 L17.75,11 L13.2522936,11 C12.83808,11 12.5022936,10.6642136 12.5022936,10.25 C12.5022936,9.87030423 12.7844475,9.55650904 13.150523,9.50684662 L13.2522936,9.5 L17.75,9.5 L13.2522936,9.5 Z"
                                id="🎨-Color"> </path>
                        </g>
                    </g>
                </g>
            </svg>
            {{ __('auth.miperfil') }}
        </a>
    </div>

    <div class="w-full  mx-auto bg-white shadow-l rounded-lg p-4 mt-1 mb-1 flex justify-center items-center">
        @include('components.carousel-mensajes')
    </div>
    @php
        $user = Auth::user();
        $esPadre = $user->hijos()->exists();
    @endphp

    <div class="w-full  mx-auto bg-white shadow-l rounded-lg p-4 mt-1 mb-1 flex justify-center items-center">
        @if ($esPadre)
            @include('components.proxima-actuacion-padres')
        @else
            @include('components.proxima-actuacion')
        @endif
    </div>
    <div class="w-full  mx-auto bg-white shadow-l rounded-lg p-4 mt-1 mb-1 flex justify-center items-center">
        <x-animated-estadisticas />
    </div>
    
    <x-subscription-info />

</div>

<footer class="bg-white dark:bg-gray-900">
    <div class="container flex flex-col items-center justify-between p-6 mx-auto space-y-4 sm:space-y-0 sm:flex-row">
        <a href="/">
            <img style="width: 75px;" src="{{ URL::to('/') }}/imagenes/logo.png" />
        </a>

        <p class="text-sm text-gray-600 dark:text-gray-300">© Copyright 2025.</p>

        <div class="flex -mx-2">

            <a href="#"
                class="mx-2 text-gray-600 transition-colors duration-300 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400"
                aria-label="Facebook">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2.00195 12.002C2.00312 16.9214 5.58036 21.1101 10.439 21.881V14.892H7.90195V12.002H10.442V9.80204C10.3284 8.75958 10.6845 7.72064 11.4136 6.96698C12.1427 6.21332 13.1693 5.82306 14.215 5.90204C14.9655 5.91417 15.7141 5.98101 16.455 6.10205V8.56104H15.191C14.7558 8.50405 14.3183 8.64777 14.0017 8.95171C13.6851 9.25566 13.5237 9.68693 13.563 10.124V12.002H16.334L15.891 14.893H13.563V21.881C18.8174 21.0506 22.502 16.2518 21.9475 10.9611C21.3929 5.67041 16.7932 1.73997 11.4808 2.01722C6.16831 2.29447 2.0028 6.68235 2.00195 12.002Z">
                    </path>
                </svg>
            </a>
            <a href="#"
                class="mx-2 text-gray-600 transition-colors duration-300 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400"
                aria-label="Instagram">
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81V16.18C2 19.83 4.17 22 7.81 22H16.18C19.82 22 21.99 19.83 21.99 16.19V7.81C22 4.17 19.83 2 16.19 2ZM12 15.88C9.86 15.88 8.12 14.14 8.12 12C8.12 9.86 9.86 8.12 12 8.12C14.14 8.12 15.88 9.86 15.88 12C15.88 14.14 14.14 15.88 12 15.88ZM17.92 6.88C17.87 7 17.8 7.11 17.71 7.21C17.61 7.3 17.5 7.37 17.38 7.42C17.26 7.47 17.13 7.5 17 7.5C16.73 7.5 16.48 7.4 16.29 7.21C16.2 7.11 16.13 7 16.08 6.88C16.03 6.76 16 6.63 16 6.5C16 6.37 16.03 6.24 16.08 6.12C16.13 5.99 16.2 5.89 16.29 5.79C16.52 5.56 16.87 5.45 17.19 5.52C17.26 5.53 17.32 5.55 17.38 5.58C17.44 5.6 17.5 5.63 17.56 5.67C17.61 5.7 17.66 5.75 17.71 5.79C17.8 5.89 17.87 5.99 17.92 6.12C17.97 6.24 18 6.37 18 6.5C18 6.63 17.97 6.76 17.92 6.88Z"
                            fill="#4a4f54"></path>
                    </g>
                </svg>
            </a>

        </div>
    </div>
</footer>
