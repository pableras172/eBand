<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $actuacion->descripcion }}
        </h2>
        <div class="flex items-center mt-2 mb-4 text-gray-500 w-full">
            <!-- Icono de calendario -->
            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                width="16px" height="16px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"
                fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <g>
                        <g>
                            <g>
                                <path fill="#506C7F"
                                    d="M50,2c-0.553,0-1,0.447-1,1v1v2v4c0,0.553,0.447,1,1,1s1-0.447,1-1V6V4V3C51,2.447,50.553,2,50,2z">
                                </path>
                                <path fill="#506C7F"
                                    d="M14,2c-0.553,0-1,0.447-1,1v1v2v4c0,0.553,0.447,1,1,1s1-0.447,1-1V6V4V3C15,2.447,14.553,2,14,2z">
                                </path>
                            </g>
                            <path fill="#F9EBB2" d="M62,60c0,1.104-0.896,2-2,2H4c-1.104,0-2-0.896-2-2V17h60V60z"></path>
                            <path fill="#F76D57"
                                d="M62,15H2V8c0-1.104,0.896-2,2-2h7v4c0,1.657,1.343,3,3,3s3-1.343,3-3V6h30v4c0,1.657,1.343,3,3,3 s3-1.343,3-3V6h7c1.104,0,2,0.896,2,2V15z">
                            </path>
                            <g>
                                <path fill="#394240"
                                    d="M11,54h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C10,53.553,10.447,54,11,54z M12,49h4v3h-4V49z">
                                </path>
                                <path fill="#394240"
                                    d="M23,54h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C22,53.553,22.447,54,23,54z M24,49h4v3h-4V49z">
                                </path>
                                <path fill="#394240"
                                    d="M35,54h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C34,53.553,34.447,54,35,54z M36,49h4v3h-4V49z">
                                </path>
                                <path fill="#394240"
                                    d="M11,43h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C10,42.553,10.447,43,11,43z M12,38h4v3h-4V38z">
                                </path>
                                <path fill="#394240"
                                    d="M23,43h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C22,42.553,22.447,43,23,43z M24,38h4v3h-4V38z">
                                </path>
                                <path fill="#394240"
                                    d="M35,43h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C34,42.553,34.447,43,35,43z M36,38h4v3h-4V38z">
                                </path>
                                <path fill="#394240"
                                    d="M47,43h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C46,42.553,46.447,43,47,43z M48,38h4v3h-4V38z">
                                </path>
                                <path fill="#394240"
                                    d="M11,32h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C10,31.553,10.447,32,11,32z M12,27h4v3h-4V27z">
                                </path>
                                <path fill="#394240"
                                    d="M23,32h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C22,31.553,22.447,32,23,32z M24,27h4v3h-4V27z">
                                </path>
                                <path fill="#394240"
                                    d="M35,32h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C34,31.553,34.447,32,35,32z M36,27h4v3h-4V27z">
                                </path>
                                <path fill="#394240"
                                    d="M47,32h6c0.553,0,1-0.447,1-1v-5c0-0.553-0.447-1-1-1h-6c-0.553,0-1,0.447-1,1v5 C46,31.553,46.447,32,47,32z M48,27h4v3h-4V27z">
                                </path>
                                <path fill="#394240"
                                    d="M60,4h-7V3c0-1.657-1.343-3-3-3s-3,1.343-3,3v1H17V3c0-1.657-1.343-3-3-3s-3,1.343-3,3v1H4 C1.789,4,0,5.789,0,8v52c0,2.211,1.789,4,4,4h56c2.211,0,4-1.789,4-4V8C64,5.789,62.211,4,60,4z M49,3c0-0.553,0.447-1,1-1 s1,0.447,1,1v7c0,0.553-0.447,1-1,1s-1-0.447-1-1V3z M13,3c0-0.553,0.447-1,1-1s1,0.447,1,1v7c0,0.553-0.447,1-1,1s-1-0.447-1-1 V3z M62,60c0,1.104-0.896,2-2,2H4c-1.104,0-2-0.896-2-2V17h60V60z M62,15H2V8c0-1.104,0.896-2,2-2h7v4c0,1.657,1.343,3,3,3 s3-1.343,3-3V6h30v4c0,1.657,1.343,3,3,3s3-1.343,3-3V6h7c1.104,0,2,0.896,2,2V15z">
                                </path>
                            </g>
                        </g>
                        <g>
                            <rect x="12" y="27" fill="#B4CCB9" width="4" height="3"></rect>
                            <rect x="24" y="27" fill="#B4CCB9" width="4" height="3"></rect>
                            <rect x="36" y="27" fill="#B4CCB9" width="4" height="3"></rect>
                            <rect x="48" y="27" fill="#B4CCB9" width="4" height="3"></rect>
                            <rect x="12" y="38" fill="#B4CCB9" width="4" height="3"></rect>
                            <rect x="24" y="38" fill="#B4CCB9" width="4" height="3"></rect>
                            <rect x="36" y="38" fill="#B4CCB9" width="4" height="3"></rect>
                            <rect x="48" y="38" fill="#B4CCB9" width="4" height="3"></rect>
                            <rect x="12" y="49" fill="#B4CCB9" width="4" height="3"></rect>
                            <rect x="24" y="49" fill="#B4CCB9" width="4" height="3"></rect>
                            <rect x="36" y="49" fill="#B4CCB9" width="4" height="3"></rect>
                        </g>
                    </g>
                </g>
            </svg>
            <!-- Fecha de la actuación -->
            <span class="mr-4"
                style="margin: auto;">{{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}</span>
            <!-- Icono de usuarios -->
            <svg width="16px" height="16px" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" version="1.1"
                fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path style="fill:#427794;stroke:#2A424F"
                        d="M 22,43 C 18,48 6.5,45 4.2,56 2,62 2,81 14,79 13,64 12,57 12,57 c 0,0 1,14 2,21 9,4 24,4 35,-1 0,-8 -1,-13 0,-18 0,-5 0,19 0,19 0,0 6,2 8,-5 3,-10 5,-24 -9,-28 -9,-1 -7,-2 -8,-2 -2,0 -18,0 -18,0 z">
                    </path>
                    <path style="fill:#C29B82;stroke:#693311"
                        d="m 23,38 c 0,0 1,3 -1,5 3,4 11,8 18,0 -1,-2 -1,-2 -1,-5 0,0 -16,0 -16,0 z"></path>
                    <path style="fill:#CDA68E;stroke:#693311" d="M 31,42 C 17,42 7.6,4.8 31,4.2 55,4.1 44,42 31,42 z">
                    </path>
                    <path style="fill:#553932;stroke:#311710"
                        d="M 17,26 C 14,16 14,3.2 31,2.4 44,3.1 49,15 44,26 44,21 45,19 43,16 39,15 33,16 28,11 27,15 15,13 17,26 z">
                    </path>
                    <path style="fill:#5F3E20;stroke:#311710"
                        d="m 45,65 c 5,-8 0,-25 3,-31 3,-10 7,-16 16,-16 10,0 16,8 20,17 1,2 0,6 2,11 1,4 -1,8 -1,10 0,5 -1,3 2,9 -5,13 -34,10 -42,0 z">
                    </path>
                    <path style="fill:#D8933B;stroke:#2A424F"
                        d="m 58,60 c -5,5 -18,3 -20,13 -2,6 -1,25 11,24 -1,-16 -3,-23 -3,-23 0,0 2,15 3,21 9,5 23,5 35,-1 0,-6 -1,-13 0,-18 1,-5 0,20 0,20 0,0 7,1 9,-6 2,-9 4,-22 -7,-25 -9,-3 -10,-5 -12,-5 -1,0 -16,0 -16,0 z">
                    </path>
                    <path style="fill:#DEB89F;stroke:#693311"
                        d="m 58,54 c 0,0 1,3 0,7 3,3 10,8 16,0 -1,-4 -1,-4 -1,-7 0,0 -15,0 -15,0 z"></path>
                    <path style="fill:#DBBFA8;stroke:#693311" d="M 66,59 C 52,59 43,21 66,20 86,21 79,59 66,59 z">
                    </path>
                    <path style="fill:#5F3E20"
                        d="m 63,27 c -3,5 -7,8 -12,9 -4,1 2,-17 13,-17 5,0 13,3 15,15 -6,1 -14,-5 -16,-7"></path>
                </g>
            </svg>
            <!-- Número de músicos -->
            <span style="margin: auto;">{{ $actuacion->musicos }}</span>
        </div>
        <hr>
        <p class="text-center mt-2 mb-2">{{ $actuacion->observaciones }}</p>
    </x-slot>

    @cannot('admin')
        @if ($usuarioDisponible)
            <div class="flex justify-center mt-4 mb-4">
                <a id="btnodisponible" href="" onclick="nodisponible(this)" data-lista-id="{{ $lista->id }}"
                    data-usuario-id="{{ Auth::user()->id }}" data-disponible="0"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    Comunicar no disponible
                </a>
            </div>
        @else
            <div class="flex justify-center mt-4 mb-4">
                <a id="btnodisponible" href="" onclick="nodisponible(this)" data-lista-id="{{ $lista->id }}"
                    data-usuario-id="{{ Auth::user()->id }}" data-disponible="1"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-green-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    Comunicar disponible
                </a>
            </div>
        @endif
    @endcannot

    <div class="bg-gray-100">
        <div class="max-w-sm mx-auto my-10">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="divide-y divide-gray-200">
                    @foreach ($usuarios->groupBy('instrument_id') as $instrumento => $usuariosDelInstrumento)
                        <div class="flex items-center justify-between bg-gray-200">
                            <h2 class="px-3 py-2 font-medium flex-grow">
                                {{ $usuariosDelInstrumento->first()->instrument->name }}
                            </h2>
                            <img class="w-10 h-10 rounded-full px-1 py-1"
                                src="{{ asset('storage/imagenes/instruments/' . $usuariosDelInstrumento->first()->instrument->icon) }}">
                        </div>


                        <ul class="divide-y divide-gray-200">
                            @foreach ($usuariosDelInstrumento->sortBy('name') as $user)
                                <li class="p-3 flex justify-between items-center user-card"
                                    @if (Auth::user()->id == $user->id) style="background-color: #ffbd59;" @endif>
                                    <div class="flex items-center">
                                        <img src="{{ asset($user->profile_photo_url) }}" alt="{{ $user->name }}"
                                            class="h-10 w-10 rounded-full">
                                        <span class="ml-3 font-medium">{{ $user->name }}</span>
                                        @if (!$user->disponible)
                                            <span class="ml-3 font-medium">{{ __(' - (No disponile)') }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($user->coche)
                                            @cannot('admin')
                                                <svg id="anyadirCoche" width="32px" height="32px"
                                                    viewBox="0 0 1024 1024" class="icon" version="1.1"
                                                    xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M200.8 353.9c-8 0-14.5-6.5-14.5-14.5v-60.9c0-8 6.5-14.5 14.5-14.5s14.5 6.5 14.5 14.5v60.9c0 8-6.5 14.5-14.5 14.5z"
                                                            fill="#A4A9AD"></path>
                                                        <path
                                                            d="M200.8 263.9c-8 0-14.5 6.5-14.5 14.5v25.5h29v-25.5c0-8-6.5-14.5-14.5-14.5z"
                                                            fill=""></path>
                                                        <path
                                                            d="M597.5 353.9c-8 0-14.5-6.5-14.5-14.5v-60.9c0-8 6.5-14.5 14.5-14.5s14.5 6.5 14.5 14.5v60.9c0 8-6.4 14.5-14.5 14.5z"
                                                            fill="#A4A9AD"></path>
                                                        <path
                                                            d="M597.5 263.9c-8 0-14.5 6.5-14.5 14.5v25.5h29v-25.5c0-8-6.4-14.5-14.5-14.5z"
                                                            fill=""></path>
                                                        <path
                                                            d="M635.3 287.2H163c-8 0-14.5-6.5-14.5-14.5s6.5-14.5 14.5-14.5h472.3c8 0 14.5 6.5 14.5 14.5s-6.5 14.5-14.5 14.5z"
                                                            fill="#A4A9AD"></path>
                                                        <path d="M839.9 390h29v91.6h-29z" fill="#333E48"></path>
                                                        <path
                                                            d="M840 390v29.2c4.6 1.6 9.4 2.4 14.5 2.4s10-0.9 14.5-2.4V390h-29z"
                                                            fill=""></path>
                                                        <path
                                                            d="M854.5 377.1m-29.7 0a29.7 29.7 0 1 0 59.4 0 29.7 29.7 0 1 0-59.4 0Z"
                                                            fill="#A4A9AD"></path>
                                                        <path
                                                            d="M901.7 478H693.1l-20.3-119.7C669.7 340 652 325 633.4 325H179c-18.6 0-36.3 15-39.4 33.3L92.8 634.2c-3.1 18.3 9.5 33.3 28.1 33.3h780.8c18.6 0 33.8-15.2 33.8-33.8v-122c0-18.5-15.2-33.7-33.8-33.7z"
                                                            fill="#cc0000"></path>
                                                        <path d="M866.2 565.3h69.3v47h-69.3z" fill="#FFB819"></path>
                                                        <path
                                                            d="M877.2 612.3h-15.9c-3.7 0-6.8-3-6.8-6.7V572c0-3.7 3-6.7 6.8-6.7h15.9v47z"
                                                            fill="#FFFFFF"></path>
                                                        <path d="M104.5 565.3l-8 47h60.3v-47z" fill="#FFB819"></path>
                                                        <path
                                                            d="M145.9 612.3h15.9c3.7 0 6.7-3 6.7-6.7V572c0-3.7-3-6.7-6.7-6.7h-15.9v47z"
                                                            fill="#FFFFFF"></path>
                                                        <path
                                                            d="M403.6 667.5c0-65.6-53.2-118.8-118.8-118.8S166 601.9 166 667.5h237.6z"
                                                            fill=""></path>
                                                        <path
                                                            d="M284.8 667.5m-97.5 0a97.5 97.5 0 1 0 195 0 97.5 97.5 0 1 0-195 0Z"
                                                            fill="#333E48"></path>
                                                        <path
                                                            d="M284.8 667.5m-49.4 0a49.4 49.4 0 1 0 98.8 0 49.4 49.4 0 1 0-98.8 0Z"
                                                            fill="#A4A9AD"></path>
                                                        <path
                                                            d="M832.6 667.5c0-65.6-53.2-118.8-118.8-118.8S595 601.9 595 667.5h237.6z"
                                                            fill=""></path>
                                                        <path
                                                            d="M713.8 667.5m-97.5 0a97.5 97.5 0 1 0 195 0 97.5 97.5 0 1 0-195 0Z"
                                                            fill="#333E48"></path>
                                                        <path
                                                            d="M713.8 667.5m-49.4 0a49.4 49.4 0 1 0 98.8 0 49.4 49.4 0 1 0-98.8 0Z"
                                                            fill="#A4A9AD"></path>
                                                        <path
                                                            d="M961.3 659.6c0 9.9-8.1 18-18 18h-40.5c-9.9 0-18-8.1-18-18v-29.2c0-9.9 8.1-18 18-18h40.5c9.9 0 18 8.1 18 18v29.2zM139.3 659.6c0 9.9-8.1 18-18 18H80.8c-9.9 0-18-8.1-18-18v-29.2c0-9.9 8.1-18 18-18h40.5c9.9 0 18 8.1 18 18v29.2z"
                                                            fill="#A4A9AD"></path>
                                                        <path
                                                            d="M458.5 379.2c0-8.5 7-15.5 15.5-15.5h126.9c8.5 0 15.5 7 15.5 15.5v69.9c0 8.5-7 15.5-15.5 15.5h-127c-8.5 0-15.5-7-15.5-15.5v-69.9zM199.7 378.9c1.4-8.4 9.6-15.3 18.1-15.3h138.5c8.5 0 15.5 7 15.5 15.5V449c0 8.5-7 15.5-15.5 15.5H200.7c-8.5 0-14.3-6.9-12.9-15.3l11.9-70.3z"
                                                            fill="#333E48"></path>
                                                        <path
                                                            d="M524.5 518.7H472c-8 0-14.5-6.5-14.5-14.5s6.5-14.5 14.5-14.5h52.5c8 0 14.5 6.5 14.5 14.5s-6.5 14.5-14.5 14.5zM242.1 518.7h-52.5c-8 0-14.5-6.5-14.5-14.5s6.5-14.5 14.5-14.5h52.5c8 0 14.5 6.5 14.5 14.5s-6.5 14.5-14.5 14.5z"
                                                            fill="#00B3E3"></path>
                                                        <path
                                                            d="M600.9 363.7h-127c-8.5 0-15.5 7-15.5 15.5v17.3c0-8.5 7-15.5 15.5-15.5h126.9c8.5 0 15.5 7 15.5 15.5v-17.3c0-8.6-6.9-15.5-15.4-15.5zM356.2 363.7H217.8c-8.5 0-16.6 6.9-18.1 15.3l-2.8 16.5c1.8-8 9.7-14.4 17.9-14.4h141.5c8.5 0 15.5 7 15.5 15.5v-17.3c-0.1-8.7-7-15.6-15.6-15.6z"
                                                            fill=""></path>
                                                    </g>
                                                </svg>
                                            @endcan
                                        @endif

                                        @cannot('admin')
                                            <input style="float: left;margin-right: 15px;" type="checkbox"
                                                data-lista-id="{{ $lista->id }}"
                                                data-usuario-id="{{ $user->id }}"
                                                {{ $user->seleccionado ? 'checked' : '' }} disabled>
                                        @endcan

                                        @can('admin')
                                            <input style="float: left;margin-right: 15px;" type="checkbox"
                                                data-lista-id="{{ $lista->id }}"
                                                data-usuario-id="{{ $user->id }}"
                                                data-usuario-percent="{{ $user->porcentaje }}"
                                                {{ $user->seleccionado ? 'checked' : '' }}
                                                onchange="actualizarSeleccion(this)">

                                            <label for="toggle-example"
                                                class="flex items-center cursor-pointer relative mb-4">
                                                <input id="toggle-example" type="checkbox"
                                                    data-lista-id="{{ $lista->id }}"
                                                    data-usuario-id="{{ $user->id }}" onclick="setCoche(this)"
                                                    class="appearance-none w-10 focus:outline-none checked:bg-blue-300 h-5 bg-gray-300 rounded-full before:inline-block before:rounded-full before:bg-blue-500 before:h-4 before:w-4 checked:before:translate-x-full shadow-inner transition-all duration-300 before:ml-0.5"
                                                    {{ $user->coche ? 'checked' : '' }} /> <!-- Corrección aquí -->
                                                <span class="ml-3 text-gray-900 text-sm font-medium">Coche</span>
                                            </label>


                                            {{-- <label for="toggle-example" class="flex items-center cursor-pointer relative mb-4">
                                                <input type="checkbox" id="toggle-example" class="sr-only">
                                                <div class="toggle-bg bg-gray-200 border-2 border-gray-200 h-6 w-11 rounded-full"></div>
                                                <span class="ml-3 text-gray-900 text-sm font-medium">Toggle me</span>
                                            </label> --}}
                                        @endcan
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div style="height: 150px">

    </div>
    <footer
        class="fixed bottom-0 left-0 z-20 w-full p-4 bg-white border-t border-gray-200 shadow md:flex md:items-center md:justify-between md:p-6 dark:bg-gray-800 dark:border-gray-600">
        @can('admin')
            <div>{{ __('Musics Seleccionats:') }}&nbsp;<span id="musics_count" style="font-weight: bold">{{ $totalFilas }}</span> de <span id="musics_count" style="font-weight: bold">{{ $actuacion->musicos }}</span></div>
            <div>{{ __('Cotxes Seleccionats:') }}&nbsp;<span id="coches_count" style="font-weight: bold">{{ $cochesCount }}</span> de <span id="musics_count" style="font-weight: bold">{{ $actuacion->coches }}</span></div>
            <div class="flex justify-center mt-4 mb-4">
                <a href="#"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    {{ __('Buidar llista') }}
                </a>
            </div>
        @endcan
        <div class="flex justify-center mt-4 mb-4">
            <a href="{{ route('actuacion.index') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-blue-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                {{ __('Tornar al llistat') }}
            </a>
        </div>
    </footer>

    <script>
        function actualizarSeleccion(checkbox) {
            var listaId = checkbox.getAttribute('data-lista-id');
            var usuarioId = checkbox.getAttribute('data-usuario-id');

            // Realizar una llamada AJAX para insertar o eliminar el registro según el estado del checkbox
            if (checkbox.checked) {
                // Lógica para insertar el registro en la base de datos
                $.ajax({
                    url: '/listauser',
                    method: 'POST',
                    data: {
                        lista_id: listaId,
                        usuario_id: usuarioId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var numFilas = response.total_filas;
                        var numElementosConCoche = response.coches_count;
                        updateContadores(numFilas, numElementosConCoche);

                    },
                    error: function(xhr, status, error) {
                        // Manejar errores si es necesario
                    }
                });
            } else {
                // Lógica para eliminar el registro de la base de datos
                $.ajax({
                    url: '/listauser/' + listaId + '/' + usuarioId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        updateContadores(numFilas, numElementosConCoche);
                    },
                    error: function(xhr, status, error) {
                        // Manejar errores si es necesario
                    }
                });
            }
        }

        function setCoche(componente) {
            var listaId = componente.getAttribute('data-lista-id');
            var usuarioId = componente.getAttribute('data-usuario-id');


            $.ajax({
                url: '/listausercar',
                method: 'POST',
                data: {
                    lista_id: listaId,
                    usuario_id: usuarioId,
                    estado: componente.checked ? 1 : 0,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var numFilas = response.total_filas;
                    var numElementosConCoche = response.coches_count;
                    updateContadores(numFilas, numElementosConCoche);
                },
                error: function(xhr, status, error) {
                    componente.checked=false;
                }
            });

        }

        function nodisponible(componente) {
            var listaId = componente.getAttribute('data-lista-id');
            var usuarioId = componente.getAttribute('data-usuario-id');
            var disponible = componente.getAttribute('data-disponible');


            $.ajax({
                url: '/listauserdisp',
                method: 'POST',
                data: {
                    lista_id: listaId,
                    usuario_id: usuarioId,
                    disponible: disponible == 1 ? 1 : 0,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                },
                error: function(xhr, status, error) {

                }
            });

        }

        function updateContadores(musics, cotxes) {
            $('#musics_count').text(musics);
            $('#coches_count').text(cotxes);
        }
    </script>


</x-app-layout>
