@php
use App\Helpers\ConfigHelper;
@endphp

<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $actuacion->descripcion }}
        </h2>


        <style>
            .scrollbar  -w-2::-webkit-scrollbar {
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

    @if (ConfigHelper::getConfigValue('enableusermessages') === 'true')
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
        
    @endif
        
        
        
        <div style="height: 175px">

        </div>
        <footer class="fixed bottom-0 left-0 z-20 w-full bg-white border-t border-gray-300 shadow dark:bg-gray-800 dark:border-gray-600">
            @can('admin')
                <div class="flex justify-around items-center mt-2 mb-2 border-b border-gray-300 p-1 bg-gray-100">
                    <div class="flex items-center space-x-2">
                        <!-- Icono -->
                        <svg width="32px" height="32px" viewBox="0 0 28 28" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools --> <title>ic_fluent_people_community_28_regular</title> <desc>Created with Sketch.</desc> <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ic_fluent_people_community_28_regular" fill="#00878a" fill-rule="nonzero"> <path d="M17.25,18 C18.4926407,18 19.5,19.0073593 19.5,20.25 L19.5,21.7519766 L19.4921156,21.8604403 C19.1813607,23.9866441 17.2715225,25.0090369 14.0667905,25.0090369 C10.8736123,25.0090369 8.93330141,23.9983408 8.51446278,21.8965776 L8.5,21.75 L8.5,20.25 C8.5,19.0073593 9.50735931,18 10.75,18 L17.25,18 Z M17.25,19.5 L10.75,19.5 C10.3357864,19.5 10,19.8357864 10,20.25 L10,21.670373 C10.2797902,22.870787 11.550626,23.5090369 14.0667905,23.5090369 C16.582858,23.5090369 17.7966388,22.8777026 18,21.6931543 L18,20.25 C18,19.8357864 17.6642136,19.5 17.25,19.5 Z M18.2435553,11.9989081 L23.75,12 C24.9926407,12 26,13.0073593 26,14.25 L26,15.7519766 L25.9921156,15.8604403 C25.6813607,17.9866441 23.7715225,19.0090369 20.5667905,19.0090369 L20.2519278,19.0056708 L20.2519278,19.0056708 C19.9568992,18.2920884 19.4151086,17.7078172 18.7333573,17.3574924 C19.2481703,17.4584023 19.8580822,17.5090369 20.5667905,17.5090369 C23.082858,17.5090369 24.2966388,16.8777026 24.5,15.6931543 L24.5,14.25 C24.5,13.8357864 24.1642136,13.5 23.75,13.5 L18.5,13.5 C18.5,12.9736388 18.4096286,12.468385 18.2435553,11.9989081 Z M4.25,12 L9.75644465,11.9989081 C9.61805027,12.3901389 9.53222663,12.8062147 9.50746303,13.2386463 L9.5,13.5 L4.25,13.5 C3.83578644,13.5 3.5,13.8357864 3.5,14.25 L3.5,15.670373 C3.77979024,16.870787 5.05062598,17.5090369 7.5667905,17.5090369 C8.18886171,17.5090369 8.73132757,17.4704451 9.1985991,17.3944422 C8.5478391,17.7478373 8.03195873,18.3174175 7.74634871,19.0065739 L7.5667905,19.0090369 C4.37361228,19.0090369 2.43330141,17.9983408 2.01446278,15.8965776 L2,15.75 L2,14.25 C2,13.0073593 3.00735931,12 4.25,12 Z M14,10 C15.9329966,10 17.5,11.5670034 17.5,13.5 C17.5,15.4329966 15.9329966,17 14,17 C12.0670034,17 10.5,15.4329966 10.5,13.5 C10.5,11.5670034 12.0670034,10 14,10 Z M14,11.5 C12.8954305,11.5 12,12.3954305 12,13.5 C12,14.6045695 12.8954305,15.5 14,15.5 C15.1045695,15.5 16,14.6045695 16,13.5 C16,12.3954305 15.1045695,11.5 14,11.5 Z M20.5,4 C22.4329966,4 24,5.56700338 24,7.5 C24,9.43299662 22.4329966,11 20.5,11 C18.5670034,11 17,9.43299662 17,7.5 C17,5.56700338 18.5670034,4 20.5,4 Z M7.5,4 C9.43299662,4 11,5.56700338 11,7.5 C11,9.43299662 9.43299662,11 7.5,11 C5.56700338,11 4,9.43299662 4,7.5 C4,5.56700338 5.56700338,4 7.5,4 Z M20.5,5.5 C19.3954305,5.5 18.5,6.3954305 18.5,7.5 C18.5,8.6045695 19.3954305,9.5 20.5,9.5 C21.6045695,9.5 22.5,8.6045695 22.5,7.5 C22.5,6.3954305 21.6045695,5.5 20.5,5.5 Z M7.5,5.5 C6.3954305,5.5 5.5,6.3954305 5.5,7.5 C5.5,8.6045695 6.3954305,9.5 7.5,9.5 C8.6045695,9.5 9.5,8.6045695 9.5,7.5 C9.5,6.3954305 8.6045695,5.5 7.5,5.5 Z" id="🎨-Color"> </path> </g> </g> </g></svg>                    
                        <!-- Texto -->
                        <span class="font-bold">{{ $totalFilas }}</span>
                        <span>de</span>
                        <span class="font-bold">{{ $actuacion->musicos }}</span>
                    </div>
                    

                    <div class="flex items-center space-x-2">
                       <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15.7993 3C17.2899 3 18.5894 4.01393 18.9518 5.45974L19.337 7H20.25C20.6297 7 20.9435 7.28215 20.9932 7.64823L21 7.75C21 8.1297 20.7178 8.44349 20.3518 8.49315L20.25 8.5H19.714L19.922 9.3265C20.5708 9.72128 21.0041 10.435 21.0041 11.25V19.7468C21.0041 20.7133 20.2206 21.4968 19.2541 21.4968H17.75C16.7835 21.4968 16 20.7133 16 19.7468L15.999 18.5H8.004L8.00408 19.7468C8.00408 20.7133 7.22058 21.4968 6.25408 21.4968H4.75C3.7835 21.4968 3 20.7133 3 19.7468V11.25C3 10.4352 3.43316 9.72148 4.08177 9.32666L4.289 8.5H3.75C3.3703 8.5 3.05651 8.21785 3.00685 7.85177L3 7.75C3 7.3703 3.28215 7.05651 3.64823 7.00685L3.75 7H4.663L5.04898 5.46176C5.41068 4.01497 6.71062 3 8.20194 3H15.7993ZM6.504 18.5H4.499L4.5 19.7468C4.5 19.8848 4.61193 19.9968 4.75 19.9968H6.25408C6.39215 19.9968 6.50408 19.8848 6.50408 19.7468L6.504 18.5ZM19.504 18.5H17.499L17.5 19.7468C17.5 19.8848 17.6119 19.9968 17.75 19.9968H19.2541C19.3922 19.9968 19.5041 19.8848 19.5041 19.7468L19.504 18.5ZM18.7541 10.5H5.25C4.83579 10.5 4.5 10.8358 4.5 11.25V17H19.5041V11.25C19.5041 10.8358 19.1683 10.5 18.7541 10.5ZM10.249 14H13.7507C14.165 14 14.5007 14.3358 14.5007 14.75C14.5007 15.1297 14.2186 15.4435 13.8525 15.4932L13.7507 15.5H10.249C9.83478 15.5 9.49899 15.1642 9.49899 14.75C9.49899 14.3703 9.78115 14.0565 10.1472 14.0068L10.249 14H13.7507H10.249ZM17 12C17.5522 12 17.9999 12.4477 17.9999 13C17.9999 13.5522 17.5522 13.9999 17 13.9999C16.4477 13.9999 16 13.5522 16 13C16 12.4477 16.4477 12 17 12ZM6.99997 12C7.55225 12 7.99995 12.4477 7.99995 13C7.99995 13.5522 7.55225 13.9999 6.99997 13.9999C6.4477 13.9999 6 13.5522 6 13C6 12.4477 6.4477 12 6.99997 12ZM15.7993 4.5H8.20194C7.39892 4.5 6.69895 5.04652 6.50419 5.82556L5.71058 9H18.2929L17.4968 5.82448C17.3017 5.04596 16.6019 4.5 15.7993 4.5Z" fill="#710909"></path> </g></svg>
                        <span id="coches_count" style="font-weight: bold">{{ $cochesCount }}</span>
                        <span>de</span>
                        <span id="coches_total" style="font-weight: bold">{{ $actuacion->coches }}</span>
                    </div>
                </div>
            @endcan
            <div class="flex justify-around items-center py-3">
                    
                    @livewire('preview-listas', ['id' => $actuacion->id])
                                <!-- Botón Volver al Listado -->
                    <a href="{{ route('actuacion.index') }}"
                                class="flex flex-col items-center text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition">
                                <svg width="32px" height="32px" viewBox="0 0 28 28" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools --> <title>ic_fluent_home_28_regular</title> <desc>Created with Sketch.</desc> <g id="🔍-System-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ic_fluent_home_28_regular" fill="#8c8c8c" fill-rule="nonzero"> <path d="M12.5919,3.49635 C13.4146,2.83625 14.5854,2.83625 15.4081,3.49635 L23.1581,9.71468 C23.6903,10.1417 24,10.7872 24,11.4696 L24,22.75 C24,23.9926 22.9926,25 21.75,25 L18.75,25 C17.5074,25 16.5,23.9926 16.5,22.75 L16.5,16.75 C16.5,16.3358 16.1642,16 15.75,16 L12.25,16 C11.8358,16 11.5,16.3358 11.5,16.75 L11.5,22.75 C11.5,23.9926 10.4926,25 9.25,25 L6.25,25 C5.00736,25 4,23.9926 4,22.75 L4,11.4696 C4,10.7872 4.30967,10.1417 4.84191,9.71468 L12.5919,3.49635 Z M14.4694,4.6663 C14.1951,4.44627 13.8049,4.44627 13.5306,4.6663 L5.78064,10.8846 C5.60322,11.027 5.5,11.2421 5.5,11.4696 L5.5,22.75 C5.5,23.1642 5.83579,23.5 6.25,23.5 L9.25,23.5 C9.66421,23.5 10,23.1642 10,22.75 L10,16.75 C10,15.5074 11.0074,14.5 12.25,14.5 L15.75,14.5 C16.9926,14.5 18,15.5074 18,16.75 L18,22.75 C18,23.1642 18.3358,23.5 18.75,23.5 L21.75,23.5 C22.1642,23.5 22.5,23.1642 22.5,22.75 L22.5,11.4696 C22.5,11.2421 22.3968,11.027 22.2194,10.8846 L14.4694,4.6663 Z" id="🎨-Color"> </path> </g> </g> </g></svg>
                                <span class="text-xs mt-1">{{ __('Inici') }}</span>
                    </a>
                @can('admin')
                    @if (Carbon\Carbon::parse($actuacion->fechaActuacion)->isToday() || Carbon\Carbon::parse($actuacion->fechaActuacion)->isFuture())
                        
                        <!-- Botón Vaciar Lista -->
                        <a id="cleanListaButton" href="#" data-lista-id="{{ $lista->id }}"
                            class="flex flex-col items-center text-gray-700 hover:text-red-600 dark:text-gray-300 dark:hover:text-red-400 transition">
                            <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5.75024 2C5.33603 2 5.00024 2.33579 5.00024 2.75V14.2505C5.00024 15.4932 6.0076 16.5005 7.25024 16.5005H9.5V19.5C9.5 20.8807 10.6193 22 12 22C13.3807 22 14.5 20.8807 14.5 19.5V16.5005H16.7502C17.9929 16.5005 19.0002 15.4932 19.0002 14.2505V2.75C19.0002 2.33579 18.6645 2 18.2502 2H5.75024ZM6.50024 11.0003V3.5H12.5V5.25154C12.5 5.66576 12.8358 6.00154 13.25 6.00154C13.6642 6.00154 14 5.66576 14 5.25154V3.5H15V6.25112C15 6.66534 15.3358 7.00112 15.75 7.00112C16.1642 7.00112 16.5 6.66534 16.5 6.25112V3.5H17.5002V11.0003H6.50024ZM6.50024 14.2505V12.5003H17.5002V14.2505C17.5002 14.6647 17.1645 15.0005 16.7502 15.0005H13.75C13.3358 15.0005 13 15.3363 13 15.7505V19.5C13 20.0523 12.5523 20.5 12 20.5C11.4477 20.5 11 20.0523 11 19.5V15.7505C11 15.3363 10.6642 15.0005 10.25 15.0005H7.25024C6.83603 15.0005 6.50024 14.6647 6.50024 14.2505Z" fill="#691111"></path> </g></svg>
                            <span class="text-xs mt-1">{{ __('Buidar') }}</span>
                        </a>
        
                        <!-- Botón Avisar Seleccionados -->
                        <a id="avisarMarcados" href="#" data-lista-id="{{ $lista->id }}" onclick="enviarNotif({{ $lista->id }},'{{ json_encode($actuacion->descripcion) }}')"
                            class="flex flex-col items-center text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 transition">
                            <svg width="32px" height="32px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools --> <title>ic_fluent_comment_resolve_24_regular</title> <desc>Created with Sketch.</desc> <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ic_fluent_comment_resolve_24_regular" fill="#075a36" fill-rule="nonzero"> <path d="M12.0225923,2.99879075 C11.7257502,3.46221691 11.4861106,3.96580034 11.3136354,4.49957906 L5.25,4.5 C4.28350169,4.5 3.5,5.28350169 3.5,6.25 L3.5,14.75 C3.5,15.7164983 4.28350169,16.5 5.25,16.5 L7.49878573,16.5 L7.49985739,20.2505702 L12.5135149,16.5 L18.75,16.5 C19.7164983,16.5 20.5,15.7164983 20.5,14.75 L20.5010736,12.2672297 C21.0520148,11.9799518 21.5566422,11.6160435 22.0008195,11.1896412 L22,14.75 C22,16.5449254 20.5449254,18 18.75,18 L13.0124851,18 L7.99868152,21.7506795 C7.44585139,22.1641649 6.66249789,22.0512036 6.2490125,21.4983735 C6.08735764,21.2822409 6,21.0195912 6,20.7499063 L5.99921427,18 L5.25,18 C3.45507456,18 2,16.5449254 2,14.75 L2,6.25 C2,4.45507456 3.45507456,3 5.25,3 L12.0225923,2.99879075 Z M17.5,1 C20.5375661,1 23,3.46243388 23,6.5 C23,9.53756612 20.5375661,12 17.5,12 C14.4624339,12 12,9.53756612 12,6.5 C12,3.46243388 14.4624339,1 17.5,1 Z M20.1464558,4.14642633 L16.0541062,8.23877585 L14.9000091,6.69997972 C14.7343237,6.47906582 14.420923,6.4342943 14.2000091,6.59997972 C13.9790952,6.76566515 13.9343237,7.07906582 14.1000091,7.29997972 L15.6000091,9.29997972 C15.782574,9.54339946 16.1384079,9.5686878 16.3535625,9.35353311 L20.8535625,4.85353311 C21.0488247,4.65827097 21.0488247,4.34168848 20.8535625,4.14642633 C20.6583004,3.95116419 20.3417179,3.95116419 20.1464558,4.14642633 Z" id="🎨-Color"> </path> </g> </g> </g></svg>
                            <span class="text-xs mt-1">{{ __('Avisar') }}</span>
                        </a>
        
                    @endif
                @endcan
        

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
