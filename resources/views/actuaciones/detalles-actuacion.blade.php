<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $actuacion->descripcion }}
        </h2>


        <style>
            .scrollbar-w-2::-webkit-scrollbar {
                width: 0.25rem;
                height: 0.25rem;
            }

            .scrollbar-track-blue-lighter::-webkit-scrollbar-track {
                --bg-opacity: 1;
                background-color: #f7fafc;
                background-color: rgba(247, 250, 252, var(--bg-opacity));
            }

            .scrollbar-thumb-blue::-webkit-scrollbar-thumb {
                --bg-opacity: 1;
                background-color: #edf2f7;
                background-color: rgba(237, 242, 247, var(--bg-opacity));
            }

            .scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
                border-radius: 0.25rem;
            }
        </style>


        <div class="flex items-center justify-center mt-2 mb-4 text-gray-500 w-full">
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
            @php
                $fechaActuacion = Carbon\Carbon::parse($actuacion->fechaActuacion);
                $nombreDia = ucfirst($fechaActuacion->translatedFormat('l')); // Nombre del día con la primera letra en mayúscula
                $fechaFormateada = $fechaActuacion->format('d/m/Y');
            @endphp

            <p class="text-lg font-bold text-zinc-950">
                {{ $nombreDia }} ({{ $fechaFormateada }})
            </p>

        </div>
        <div class="flex items-center justify-between mt-2 mb-4 text-gray-500 w-full">
            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" width="16px" height="16px" viewBox="0 0 64 64"
                enable-background="new 0 0 64 64" xml:space="preserve" fill="#000000" transform="rotate(0)">
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
            @if ($actuacion->musicos > 0)
                <!-- Número de músicos -->
                <span class="mr-4">{{ $actuacion->musicos }}</span>
            @else
                <span class="mr-4">--</span>
            @endif

            <svg id="anyadirCoche" width="32px" height="32px" viewBox="0 0 1024 1024" class="icon" version="1.1"
                xmlns="http://www.w3.org/2000/svg" fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M200.8 353.9c-8 0-14.5-6.5-14.5-14.5v-60.9c0-8 6.5-14.5 14.5-14.5s14.5 6.5 14.5 14.5v60.9c0 8-6.5 14.5-14.5 14.5z"
                        fill="#A4A9AD"></path>
                    <path d="M200.8 263.9c-8 0-14.5 6.5-14.5 14.5v25.5h29v-25.5c0-8-6.5-14.5-14.5-14.5z" fill="">
                    </path>
                    <path
                        d="M597.5 353.9c-8 0-14.5-6.5-14.5-14.5v-60.9c0-8 6.5-14.5 14.5-14.5s14.5 6.5 14.5 14.5v60.9c0 8-6.4 14.5-14.5 14.5z"
                        fill="#A4A9AD"></path>
                    <path d="M597.5 263.9c-8 0-14.5 6.5-14.5 14.5v25.5h29v-25.5c0-8-6.4-14.5-14.5-14.5z" fill="">
                    </path>
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
                    <path d="M877.2 612.3h-15.9c-3.7 0-6.8-3-6.8-6.7V572c0-3.7 3-6.7 6.8-6.7h15.9v47z" fill="#FFFFFF">
                    </path>
                    <path d="M104.5 565.3l-8 47h60.3v-47z" fill="#FFB819"></path>
                    <path d="M145.9 612.3h15.9c3.7 0 6.7-3 6.7-6.7V572c0-3.7-3-6.7-6.7-6.7h-15.9v47z" fill="#FFFFFF">
                    </path>
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
            @if ($actuacion->coches > 0)
                <span class="mr-4">{{ $actuacion->coches }}</span>
            @else
                <span class="mr-4">--</span>
            @endif
        </div>

        <hr>
        <p class="text-center mt-2 mb-2">{{ $actuacion->observaciones }}</p>
        @if ($actuacion->calendar)
            <hr>
            <div data-lista-id="{{ $actuacion->id }}" class="flex justify-center items-center mt-2">
                <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M6.96006 2C7.37758 2 7.71605 2.30996 7.71605 2.69231V4.08883C8.38663 4.07692 9.13829 4.07692 9.98402 4.07692H14.016C14.8617 4.07692 15.6134 4.07692 16.284 4.08883V2.69231C16.284 2.30996 16.6224 2 17.0399 2C17.4575 2 17.7959 2.30996 17.7959 2.69231V4.15008C19.2468 4.25647 20.1992 4.51758 20.899 5.15838C21.5987 5.79917 21.8838 6.67139 22 8V9H2V8C2.11618 6.67139 2.4013 5.79917 3.10104 5.15838C3.80079 4.51758 4.75323 4.25647 6.20406 4.15008V2.69231C6.20406 2.30996 6.54253 2 6.96006 2Z"
                            fill="#eeb759"></path>
                        <path opacity="0.5"
                            d="M22 14V12C22 11.161 21.9873 9.66527 21.9744 9H2.00586C1.99296 9.66527 2.00564 11.161 2.00564 12V14C2.00564 17.7712 2.00564 19.6569 3.17688 20.8284C4.34813 22 6.23321 22 10.0034 22H14.0023C17.7724 22 19.6575 22 20.8288 20.8284C22 19.6569 22 17.7712 22 14Z"
                            fill="#eeb759"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M16 13.25C16.4142 13.25 16.75 13.5858 16.75 14V15.25L18 15.25C18.4142 15.25 18.75 15.5858 18.75 16C18.75 16.4142 18.4142 16.75 18 16.75H16.75L16.75 18C16.75 18.4142 16.4142 18.75 16 18.75C15.5858 18.75 15.25 18.4142 15.25 18L15.25 16.75L14 16.75C13.5858 16.75 13.25 16.4142 13.25 16C13.25 15.5858 13.5858 15.25 14 15.25H15.25L15.25 14C15.25 13.5858 15.5858 13.25 16 13.25Z"
                            fill="#eeb759"></path>
                    </g>
                </svg>
                <a href="/descargarCalendario/{{ $actuacion->id }}"><span
                        class="mr-4">{{ __('Añadir a mi calendario') }}</span></a>
            </div>
        @endif
    </x-slot>


    @if ($usuarioDisponible)
        <div class="flex justify-center mt-4 mb-4">
            <a id="btnodisponible" href="" data-lista-id="{{ $lista->id }}"
                data-usuario-id="{{ Auth::user()->id }}" data-disponible="0"
                data-antelacion="{{ $antelacion->days }}" onclick="gestionarDisponibilidad(event,this)"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                aria-label="Comunicar no disponible">
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
            <a id="btnodisponible" href="" data-lista-id="{{ $lista->id }}"
                data-usuario-id="{{ Auth::user()->id }}" data-disponible="1"
                onclick="gestionarDisponibilidad(event,this)"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-green-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                aria-label="Comunicar no disponible">
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
                                            <div class="ml-2"><x-disponible w="24" h="24" /></div>
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
    <!-- component flex-1 p-4 w-full max-w-2xl mx-auto justify-between flex flex-col bg-white rounded-lg shadow-lg -->
    <div class="max-w-md lg:max-w-lg mx-auto px-2 my-4 bg-white rounded-lg shadow-lg">
        <div class="w-full bg-white border-b border-gray-300 p-2 shadow-sm rounded-t-lg">
            <h2
                class="mb-1 mt-2 text-2xl font-extrabold text-gray-900 text-center flex items-center justify-center gap-3">
                <!-- Icono de comentarios -->
                <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path fill-rule="evenodd" clip-rule="evenodd" fill="#394240" d="M60,0H4C1.789,0,0,1.789,0,4v40c0,2.211,1.789,4,4,4h8v12 c0,1.617,0.973,3.078,2.469,3.695C14.965,63.902,15.484,64,16,64c1.039,0,2.062-0.406,2.828-1.172L33.656,48H60 c2.211,0,4-1.789,4-4V4C64,1.789,62.211,0,60,0z M56,40H32c-1.023,0-2.047,0.391-2.828,1.172L20,50.344V44c0-2.211-1.789-4-4-4H8V8 h48V40z"></path> <path fill-rule="evenodd" clip-rule="evenodd" fill="#ffc46c" d="M56,40H32c-1.023,0-2.047,0.391-2.828,1.172L20,50.344V44 c0-2.211-1.789-4-4-4H8V8h48V40z"></path> </g> </g></svg>

                <!-- Texto del encabezado -->
                <span class="text-zinc-950">
                    {{__('common.comentariosactuacion')}}
                </span>
            </h2>
        </div>

        <div id="messages"
            class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
            <div id="commentsContainer"
                class="chat-container space-y-4 p-4 bg-gray-100 rounded-lg max-h-96 overflow-y-auto">
                <!-- Recorremos los comentarios -->
                @forelse ($actuacion->comments as $comment)
                    @if($comment->eliminado  || $comment->inadecuado)
                        @continue
                    @endif
                    <!-- Determinar si el comentario es del usuario actual -->
                    @php
                        $esPropio = auth()->id() === $comment->user_id;
                    @endphp

                    <div class="chat-message">
                        <div class="flex items-end {{ $esPropio ? 'justify-end' : '' }}">
                            <!-- Imagen del usuario -->
                            @if (!$esPropio)
                                <img src="{{ $comment->user->profile_photo_url ?? asset('/imagenes/no-icon.png') }}"
                                    alt="{{ $comment->user->name }}" class="w-6 h-6 rounded-full mr-2">
                            @endif

                            <!-- Burbuja del comentario -->
                            <div class="flex flex-col space-y-1 text-xs max-w-xs mx-2 {{ $esPropio ? 'items-end' : 'items-start' }}">
                                <div class="
                                    px-4 py-2 rounded-lg 
                                    {{ $esPropio ? 'rounded-br-none' : 'rounded-bl-none' }}
                                    {{ $comment->inadecuado ? 'bg-red-600 text-white' : ($esPropio ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-800') }}
                                ">
                                    <strong class="text-sm">{{ $comment->user->name ?? 'Usuario desconocido' }}</strong><br>
                                    {{ $comment->comment }}
                                </div>
                                <span class="text-gray-500 text-[10px]">
                                    {{ $comment->created_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            

                            <!-- Imagen del usuario (si el comentario es propio) -->
                            @if ($esPropio)
                                <img src="{{ auth()->user()->profile_photo_path ?? asset('/imagenes/no-icon.png') }}"
                                    alt="Mi perfil" class="w-6 h-6 rounded-full ml-2">
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center">No hay comentarios todavía. ¡Sé el primero en
                        comentar! 🎉</p>
                @endforelse
            </div>

            <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
                <div class="relative flex">
                    <!-- Input del comentario -->
                    <input type="text" id="commentInput" maxlength="200" minlength="5"
                        placeholder="{{ __('Envia tu comentario') }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-700"
                        oninput="updateCharacterCount()">

                    <!-- Contador de caracteres -->

                    <div class="absolute right-0 items-center inset-y-0 sm:flex">
                        <button id="sendComment" type="button"
                            class="inline-flex items-center justify-center rounded-lg px-4 py-3 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="h-6 w-6 ml-2 transform rotate-90">
                                <path
                                    d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
                <p id="charCount" class="text-right text-sm text-gray-500 mt-1">
                    0 / 200 caracteres
                </p>
                <hr class="mt-4 mb-4" />
                <div class="mt-2 text-xs text-gray-500">
                    <p>⚠️ {{ __('Por favor, sigue estas normas al comentar:') }}</p>
                    <ul class="list-disc list-inside text-gray-400">
                        <li>✅ {{ __('Sé respetuoso con los demás.') }}</li>
                        <li>🚫 {{ __('No uses lenguaje ofensivo o insultos.') }}</li>
                        <li>💡 {{ __('Aporta valor con tu comentario.') }}</li>
                        <li>❌ {{ __('No publiques spam o contenido irrelevante.') }}</li>
                    </ul>
                </div>
            </div>
        </div>

        @can('admin')
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                @livewire('preview-listas', ['id' => $actuacion->id])
            </div>
        @endcan
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
                    @if (Carbon\Carbon::parse($actuacion->fechaActuacion)->isToday() ||
                            Carbon\Carbon::parse($actuacion->fechaActuacion)->isFuture())
                        <a id="cleanListaButton" href="#" data-lista-id="{{ $lista->id }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mr-4">
                            {{ __('Buidar llista') }}
                        </a>
                        <a id="avisarMarcados" href="#" data-lista-id="{{ $lista->id }}"
                            onclick="enviarNotif({{ $lista->id }},'{{ json_encode($actuacion->descripcion) }}')"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-green-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mr-4">
                            {{ __('Avisar seleccionats') }}
                        </a>
                    @endif
                @endcan
                <a href="{{ route('actuacion.index') }}"
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

            function gestionarDisponibilidad(evemt, componente) {

                event.preventDefault();

                var listaId = componente.getAttribute('data-lista-id');
                var usuarioId = componente.getAttribute('data-usuario-id');
                var disponible = componente.getAttribute('data-disponible');
                var antelacion = parseInt(componente.getAttribute('data-antelacion'));

                // Verificar si se puede cambiar la disponibilidad
                if (disponible == 0 && antelacion <= 2) {
                    alert('No se puede cambiar la disponibilidad con pocos días de antelación.');
                    return;
                }

                // Enviar la solicitud AJAX
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
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        let message = xhr.responseJSON?.message || 'Error al comunicar disponibilidad.';
                        showToast(message);
                        //showToast(message);
                    }
                });
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

            $('#downloadCalendar').click(function() {
                var idActua = $(this).data('lista-id'); // Modificado para usar jQuery
                $.ajax({
                    url: '/descargarCalendario/' + idActua,
                    method: 'GET',
                    /* data: {
                         id: idActua,                   
                     },*/
                    success: function(response) {
                        showToast(response);
                    },
                    error: function(xhr, status, error) {
                        showToast(xhr.responseJSON);
                    }
                });
            });
        </script>


        <script>
            const el = document.getElementById('messages')
            el.scrollTop = el.scrollHeight
        </script>

        <script>
            document.getElementById('sendComment').addEventListener('click', function() {
                let input = document.getElementById('commentInput');
                let commentText = input.value.trim();

                if (commentText.length === 0) {
                    showToast({
                        alert_type: 'warning',
                        message: "{{ __('El comentario no puede estar vacío.') }}"
                    });
                    return;
                }

                if (commentText.length < 5) {
                    showToast({
                        alert_type: 'warning',
                        message: "{{ __('El comentario debe tener al menos 5 caracteres.') }}"
                    });
                    return;
                }

                if (commentText.length > 200) {
                    showToast({
                        alert_type: 'warning',
                        message: "{{ __('Máximo 200 caracteres.') }}"
                    });
                    return;
                }

                // Desactivar botón mientras se envía el comentario
                this.disabled = true;

                fetch("{{ route('comments.add') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            comment: commentText,
                            actuacion_id: {{ $actuacion->id }}
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Agregar nuevo comentario al contenedor sin recargar
                            let commentHTML = `
                                <div class="chat-message">
                                    <div class="flex items-end justify-end">
                                        <div class="flex flex-col space-y-1 text-xs max-w-xs mx-2 items-end">
                                            <div class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                                <strong class="text-sm">{{ auth()->user()->name }}</strong><br>
                                                ${data.comment}
                                            </div>
                                            <span class="text-gray-500 text-[10px]">${data.created_at}</span>
                                        </div>
                                        <img src="{{ auth()->user()->profile_photo_path ?? asset('/imagenes/no-icon.png') }}" 
                                            alt="Mi perfil" class="w-6 h-6 rounded-full ml-2">
                                    </div>
                                </div>
                            `;

                            document.getElementById('commentsContainer').innerHTML += commentHTML;
                            input.value = ''; // Limpiar input
                            updateCharacterCount();

                            let messagesDiv = document.getElementById('messages');
                            messagesDiv.scrollTop = messagesDiv.scrollHeight;
                            
                        } else {
                            showToast({
                                alert_type: 'error',
                                message: "{{ __('Error al enviar el comentario.') }}"
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        showToast({
                            alert_type: 'error',
                            message: "Hubo un problema al procesar tu comentario."
                        });
                    })
                    .finally(() => this.disabled = false); // Rehabilitar botón
            });

            function updateCharacterCount() {
                let input = document.getElementById('commentInput');
                let counter = document.getElementById('charCount');
                let maxLength = input.maxLength;

                counter.textContent = `${input.value.length} / ${maxLength} caracteres`;

                if (input.value.length >= maxLength) {
                    input.classList.add("border-red-500");
                } else {
                    input.classList.remove("border-red-500");
                }
            }
        </script>



</x-app-layout>
