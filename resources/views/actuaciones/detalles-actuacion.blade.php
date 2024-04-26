<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $actuacion->descripcion }}
        </h2>
        <div class="flex items-center mt-2 mb-4 text-gray-500 w-full">
            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                width="16px" height="16px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"
                fill="#000000" transform="rotate(0)">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <g>
                        <path fill="#eeb759"
                            d="M32,52.789l-12-18C18.5,32,16,28.031,16,24c0-8.836,7.164-16,16-16s16,7.164,16,16 c0,4.031-2.055,8-4,10.789L32,52.789z">
                        </path>
                        <g>
                            <path fill="#394240"
                                d="M32,0C18.746,0,8,10.746,8,24c0,5.219,1.711,10.008,4.555,13.93c0.051,0.094,0.059,0.199,0.117,0.289 l16,24C29.414,63.332,30.664,64,32,64s2.586-0.668,3.328-1.781l16-24c0.059-0.09,0.066-0.195,0.117-0.289 C54.289,34.008,56,29.219,56,24C56,10.746,45.254,0,32,0z M44,34.789l-12,18l-12-18C18.5,32,16,28.031,16,24 c0-8.836,7.164-16,16-16s16,7.164,16,16C48,28.031,45.945,32,44,34.789z">
                            </path>
                            <circle fill="#394240" cx="32" cy="24" r="8"></circle>
                        </g>
                    </g>
                </g>
            </svg>
            <span class="mr-4">{{ $actuacion->contrato->poblacion }}</span>
            <!-- Icono de calendario -->
            <svg width="26px" height="26px" viewBox="0 0 1024 1024" class="icon" version="1.1"
                xmlns="http://www.w3.org/2000/svg" fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M182.067 383.79h664.916v473.911H182.067z" fill="#FCE3C3"></path>
                    <path
                        d="M846.983 857.701H170.007V401.632h676.976v456.069zM189.428 838.28h638.134V421.053H189.428V838.28z"
                        fill="#ffc46c"></path>
                    <path
                        d="M850.483 861.201H166.507V398.132h683.977v463.069z m-676.976-7h669.977V405.132H173.507v449.069z m657.555-12.421H185.929V417.553h645.134V841.78z m-638.133-7h631.134V424.553H192.929V834.78z"
                        fill="#ffc46c"></path>
                    <path d="M179.718 273.282h657.556v138.061H179.718z" fill="#ffc46c"></path>
                    <path
                        d="M840.774 414.844H176.219V269.782h664.556v145.062z m-657.555-7h650.556V276.782H183.219v131.062z"
                        fill="#ffc46c"></path>
                    <path
                        d="M846.983 421.053H170.007V263.572h676.976v157.481z m-657.555-19.421h638.134V282.994H189.428v118.638z"
                        fill="#ffc46c"></path>
                    <path
                        d="M850.483 424.553H166.507v-164.48h683.977v164.48z m-676.976-7h669.977v-150.48H173.507v150.48z m657.555-12.421H185.929V279.494h645.134v125.638z m-638.133-7h631.134V286.494H192.929v111.638z"
                        fill="#ffc46c"></path>
                    <path d="M672.215 190.225h63.426v162.87h-63.426z" fill="#ED8F27"></path>
                    <path
                        d="M745.351 362.806h-82.847V180.514h82.847v182.292z m-63.426-19.421h44.005v-143.45h-44.005v143.45z"
                        fill="#ffc46c"></path>
                    <path d="M281.351 190.225h63.426v162.87h-63.426z" fill="#ED8F27"></path>
                    <path
                        d="M354.487 362.806H271.64V180.514h82.847v182.292z m-63.426-19.421h44.005v-143.45h-44.005v143.45z"
                        fill="#ffc46c"></path>
                    <path d="M688.071 468.427h66.597v66.597h-66.597z" fill="#B12800"></path>
                    <path
                        d="M688.071 596.369h66.597v66.597h-66.597zM688.071 724.31h66.597v66.598h-66.597zM546.156 468.427h66.597v66.597h-66.597z"
                        fill="#228E9D"></path>
                    <path d="M546.156 596.369h66.597v66.597h-66.597z" fill="#B12800"></path>
                    <path d="M546.156 724.31h66.597v66.598h-66.597zM404.239 468.427h66.598v66.597h-66.598z"
                        fill="#228E9D"></path>
                    <path d="M404.239 596.369h66.598v66.597h-66.598z" fill="#B12800"></path>
                    <path d="M404.239 724.31h66.598v66.598h-66.598zM262.323 596.369h66.598v66.597h-66.598z"
                        fill="#228E9D"></path>
                    <path d="M262.323 724.31h66.598v66.598h-66.598z" fill="#B12800"></path>
                </g>
            </svg>
            <!-- Fecha de la actuación -->
            <span class="mr-4">{{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}</span>
            <!-- Icono de usuarios -->
            @if ($actuacion->musicos > 0)
                <svg width="16px" height="16px" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                    version="1.1" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path style="fill:#427794;stroke:#2A424F"
                            d="M 22,43 C 18,48 6.5,45 4.2,56 2,62 2,81 14,79 13,64 12,57 12,57 c 0,0 1,14 2,21 9,4 24,4 35,-1 0,-8 -1,-13 0,-18 0,-5 0,19 0,19 0,0 6,2 8,-5 3,-10 5,-24 -9,-28 -9,-1 -7,-2 -8,-2 -2,0 -18,0 -18,0 z">
                        </path>
                        <path style="fill:#C29B82;stroke:#693311"
                            d="m 23,38 c 0,0 1,3 -1,5 3,4 11,8 18,0 -1,-2 -1,-2 -1,-5 0,0 -16,0 -16,0 z"></path>
                        <path style="fill:#CDA68E;stroke:#693311"
                            d="M 31,42 C 17,42 7.6,4.8 31,4.2 55,4.1 44,42 31,42 z">
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
                <span class="mr-4">{{ $actuacion->musicos }}</span>
            @endif
            @if ($actuacion->coches > 0)
                <svg id="anyadirCoche" width="32px" height="32px" viewBox="0 0 1024 1024" class="icon"
                    version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M200.8 353.9c-8 0-14.5-6.5-14.5-14.5v-60.9c0-8 6.5-14.5 14.5-14.5s14.5 6.5 14.5 14.5v60.9c0 8-6.5 14.5-14.5 14.5z"
                            fill="#A4A9AD"></path>
                        <path d="M200.8 263.9c-8 0-14.5 6.5-14.5 14.5v25.5h29v-25.5c0-8-6.5-14.5-14.5-14.5z"
                            fill=""></path>
                        <path
                            d="M597.5 353.9c-8 0-14.5-6.5-14.5-14.5v-60.9c0-8 6.5-14.5 14.5-14.5s14.5 6.5 14.5 14.5v60.9c0 8-6.4 14.5-14.5 14.5z"
                            fill="#A4A9AD"></path>
                        <path d="M597.5 263.9c-8 0-14.5 6.5-14.5 14.5v25.5h29v-25.5c0-8-6.4-14.5-14.5-14.5z"
                            fill=""></path>
                        <path
                            d="M635.3 287.2H163c-8 0-14.5-6.5-14.5-14.5s6.5-14.5 14.5-14.5h472.3c8 0 14.5 6.5 14.5 14.5s-6.5 14.5-14.5 14.5z"
                            fill="#A4A9AD"></path>
                        <path d="M839.9 390h29v91.6h-29z" fill="#333E48"></path>
                        <path d="M840 390v29.2c4.6 1.6 9.4 2.4 14.5 2.4s10-0.9 14.5-2.4V390h-29z" fill=""></path>
                        <path d="M854.5 377.1m-29.7 0a29.7 29.7 0 1 0 59.4 0 29.7 29.7 0 1 0-59.4 0Z" fill="#A4A9AD">
                        </path>
                        <path
                            d="M901.7 478H693.1l-20.3-119.7C669.7 340 652 325 633.4 325H179c-18.6 0-36.3 15-39.4 33.3L92.8 634.2c-3.1 18.3 9.5 33.3 28.1 33.3h780.8c18.6 0 33.8-15.2 33.8-33.8v-122c0-18.5-15.2-33.7-33.8-33.7z"
                            fill="#cc0000"></path>
                        <path d="M866.2 565.3h69.3v47h-69.3z" fill="#FFB819"></path>
                        <path d="M877.2 612.3h-15.9c-3.7 0-6.8-3-6.8-6.7V572c0-3.7 3-6.7 6.8-6.7h15.9v47z"
                            fill="#FFFFFF"></path>
                        <path d="M104.5 565.3l-8 47h60.3v-47z" fill="#FFB819"></path>
                        <path d="M145.9 612.3h15.9c3.7 0 6.7-3 6.7-6.7V572c0-3.7-3-6.7-6.7-6.7h-15.9v47z"
                            fill="#FFFFFF"></path>
                        <path d="M403.6 667.5c0-65.6-53.2-118.8-118.8-118.8S166 601.9 166 667.5h237.6z" fill="">
                        </path>
                        <path d="M284.8 667.5m-97.5 0a97.5 97.5 0 1 0 195 0 97.5 97.5 0 1 0-195 0Z" fill="#333E48">
                        </path>
                        <path d="M284.8 667.5m-49.4 0a49.4 49.4 0 1 0 98.8 0 49.4 49.4 0 1 0-98.8 0Z" fill="#A4A9AD">
                        </path>
                        <path d="M832.6 667.5c0-65.6-53.2-118.8-118.8-118.8S595 601.9 595 667.5h237.6z" fill="">
                        </path>
                        <path d="M713.8 667.5m-97.5 0a97.5 97.5 0 1 0 195 0 97.5 97.5 0 1 0-195 0Z" fill="#333E48">
                        </path>
                        <path d="M713.8 667.5m-49.4 0a49.4 49.4 0 1 0 98.8 0 49.4 49.4 0 1 0-98.8 0Z" fill="#A4A9AD">
                        </path>
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
                <span class="mr-4">{{ $actuacion->coches }}</span>
            @endif
        </div>

        <hr>
        <p class="text-center mt-2 mb-2">{{ $actuacion->observaciones }}</p>
    </x-slot>


    @if ($usuarioDisponible)
        <div class="flex justify-center mt-4 mb-4">
            <a id="btnodisponible" href=""
                @if ($antelacion->days > 2) onclick="nodisponible(this)" @else onclick="alert('{{ __('No se puede cambiar la disponibilidad con pocos dias de antelación.') }}')" @endif
                data-lista-id="{{ $lista->id }}" data-usuario-id="{{ Auth::user()->id }}" data-disponible="0"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                {{ __('Comunicar no disponible') }}
            </a>
        </div>
        @if ($antelacion->days <= 2)
            <div class="flex justify-center mt-4 mb-4">
                {{ __('No se puede cambiar la disponibilidad con pocos dias de antelación.') }}
            </div>
        @endif
    @else
        <div class="flex justify-center mt-2 mb-2">
            <a id="btnodisponible" href="" onclick="nodisponible(this)" data-lista-id="{{ $lista->id }}"
                data-usuario-id="{{ Auth::user()->id }}" data-disponible="1"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-green-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                {{ __('Comunicar disponible') }}
            </a>
        </div>
    @endif


    <div class="bg-gray-100">
        <div class="max-w-md lg:max-w-lg mx-auto px-2 my-4">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="divide-y divide-gray-200">
                    @foreach ($usuarios->groupBy('instrument_id') as $instrumento => $usuariosDelInstrumento)
                        <div class="flex items-center justify-between bg-fondoclaro">
                            <h2 class="px-3 py-2 font-medium flex-grow">
                                {{ $usuariosDelInstrumento->first()->instrument->name }}
                            </h2>
                            @can('admin')
                                <button type="button" id="f_{{ $usuariosDelInstrumento->first()->instrument->name }}"
                                    class="ml-3 mr-3 bg-fondobotonnaranja text-white p-2 rounded leading-none flex items-center justify-center"
                                    onclick="mostrarForasters(this)"
                                    data-instrument-name="{{ $usuariosDelInstrumento->first()->instrument->name }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            @endcan
                            <img class="w-10 h-10 rounded-full px-1 py-1"
                                src="{{ asset('storage/imagenes/instruments/' . $usuariosDelInstrumento->first()->instrument->icon) }}">
                        </div>


                        <ul class="divide-y divide-gray-200">
                            @foreach ($usuariosDelInstrumento->sortBy('name')->sortBy('forastero') as $user)
                                @cannot('admin')
                                    @if ($user->forastero)
                                        @continue
                                    @endif
                                @endcannot
                                <li class="@if ($user->forastero) forastero {{ $user->instrument->name }} @endif p-3 flex justify-between items-center user-card "
                                    style="@if (Auth::user()->id == $user->id) background-color: #ffbd59; @endif
                                    @if ($user->forastero) display: none; {{ $user->instrument->name }} @endif">

                                    <div class="flex items-center">
                                        <img src="{{ asset($user->profile_photo_url) }}" alt="{{ $user->name }}"
                                            class="h-10 w-10 rounded-full">
                                        <span class="ml-2 font-medium flex items-center">
                                            {{ $user->name }}
                                            @if ($user->forastero)
                                                <button type="button"
                                                    class="ml-2 mr-2 font-medium bg-fondobotonnaranja text-white p-2 rounded leading-none flex items-center">
                                                    {{ __('common.llogat') }}
                                                </button>
                                            @endif
                                        </span>
                                        @if (!$user->disponible)
                                            <span class="ml-3 font-medium">{{ __(' - (No disponile)') }}</span>
                                        @endif
                                    </div>
                                    <div>


                                        @cannot('admin')
                                            <div class="flex items-center">
                                                <input style="float: left;margin-right: 15px;" type="checkbox"
                                                    data-lista-id="{{ $lista->id }}"
                                                    data-usuario-id="{{ $user->id }}"
                                                    {{ $user->seleccionado ? 'checked' : '' }} disabled>

                                                @if ($user->coche)
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
                                                @endif
                                            </div>
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
                                                    {{ $user->coche ? 'checked' : '' }} />
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
    <div style="height: 175px">

    </div>
    <footer
        class="fixed bottom-0 left-0 z-20 w-full p-2 bg-white border-t border-black-800 shadow md:flex md:items-center md:justify-between md:p-6 dark:bg-gray-800 dark:border-gray-600">
        @can('admin')
            <div class="flex justify-center items-center mt-2 mb-2">
                <div>
                    {{ __('Musics Seleccionats:') }}&nbsp;
                    <span id="musics_count" style="font-weight: bold">{{ $totalFilas }}</span>
                    de
                    <span id="musics_total" style="font-weight: bold">{{ $actuacion->musicos }}</span>
                </div>
            </div>
            <div class="flex justify-center items-center mb-2">
                <div>
                    {{ __('Cotxes Seleccionats:') }}&nbsp;
                    <span id="coches_count" style="font-weight: bold">{{ $cochesCount }}</span>
                    de
                    <span id="coches_total" style="font-weight: bold">{{ $actuacion->coches }}</span>
                </div>
            </div>
        @endcan
        <div class="flex justify-center mt-2 mb-2">
            @can('admin')
                @if(Carbon\Carbon::parse($actuacion->fechaActuacion)->isToday() || Carbon\Carbon::parse($actuacion->fechaActuacion)->isFuture())
                    <a id="cleanListaButton" href="#" data-lista-id="{{ $lista->id }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mr-4">
                        {{ __('Buidar llista') }}
                    </a>
                    <a id="avisarMarcados" href="#" data-lista-id="{{ $lista->id }}"
                        onclick="enviarNotif({{ $lista->id }},'{{ $actuacion->descripcion }}')"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-green-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mr-4">
                        {{ __('Avisar seleccionats') }}
                    </a>
                @endif
            @endcan
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-fondobotonazul hover:bg-fondobotonazul-100 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
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
                        updateContadores(response.total_filas, response.coches_count);
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
                    componente.checked = false;
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
                    showToast(response);                                           
                },
                error: function(xhr, status, error) {
                    showToast(xhr.responseJSON);
                }
            });

        }

        function updateContadores(musics, cotxes) {
            $('#musics_count').text(musics);
            $('#coches_count').text(cotxes);
        }

        function enviarNotif(idActua, detalle) {

            if (confirm('Seguro que quieres notificar a los usuarios marcados de la actuación: ' + detalle)) {

                $.ajax({
                    url: '/notificaractuacionlista',
                    method: 'POST',
                    data: {
                        id: idActua,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showToast(response);                                           
                    },
                    error: function(xhr, status, error) {
                        showToast(xhr.responseJSON);
                    }
                });
            }

        }



        @can('admin')
            // Obtener el botón "Buidar llista" por su identificador
            var cleanListaButton = document.getElementById('cleanListaButton');

            // Agregar un event listener para el clic en el botón
            cleanListaButton.addEventListener('click', function(event) {
                // Prevenir el comportamiento predeterminado del enlace
                event.preventDefault();

                // Obtener el listaId de los atributos de datos del botón
                var listaId = cleanListaButton.getAttribute('data-lista-id');

                // Confirmar con el usuario antes de realizar la acción
                if (confirm("¿Estás seguro de que quieres limpiar la lista?")) {
                    // Enviar una solicitud DELETE a la ruta correspondiente
                    fetch(`/listauserclean/${listaId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error al limpiar la lista');
                            }
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Manejar errores si es necesario
                        });
                }
            });
        @endcan

        function mostrarForasters(button) {
            // Obtenemos el valor del atributo data-instrument-name del botón
            const instrumentName = button.getAttribute('data-instrument-name');

            // Seleccionamos todos los elementos <li> con la clase correspondiente al instrumento
            const elementsToShowHide = document.querySelectorAll(`.forastero.${instrumentName}`);

            // Iteramos sobre los elementos para mostrarlos u ocultarlos
            elementsToShowHide.forEach(element => {
                // Si el elemento está visible, lo ocultamos; si está oculto, lo mostramos
                if (element.style.display === 'none') {
                    element.style.display = 'flex';
                } else {
                    element.style.display = 'none';
                }
            });
        }
    </script>

</x-app-layout>
