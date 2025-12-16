<x-app-layout>
    <x-slot name="header">
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active>{{ __('common.calendario') }}</x-ui.breadcrumbs.link>
        </x-ui.breadcrumbs>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('common.calendario_proximas') }}
        </h2>
    </x-slot>

    <div class="bg-white border border-gray-200 divide-y divide-gray-200  m-2">
        <details class="p-2 group" @isset($filtrotipo) open @else close @endisset>
            <summary class="flex items-center justify-between cursor-pointer">
                <h5 class="text-lg font-medium text-gray-900">
                    {{ __('Filtrar actuacions per tipus') }}: @isset($filtrotipo)
                        {{ $tiposActuacion[0]->nombre }}
                    @endisset
                </h5>
                @isset($filtrotipo)
                    <a href="{{ route('actuacion.index') }}">
                        <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M15 15L21 21M21 15L15 21M10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L17 11"
                                    stroke="#b2843e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </a>
                @else
                    <span class="relative flex-shrink-0 ml-1.5 w-5 h-5">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 w-5 h-5 opacity-100 group-open:opacity-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 w-5 h-5 opacity-0 group-open:opacity-100" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                @endisset

            </summary>
            @foreach ($tiposActuacion as $tipo)
                <a href="{{ route('actuaciones-tipo', ['tipoactuacion' => $tipo->id]) }}"><span
                        class="bg-gray-200 px-2 py-1 rounded-md mr-2">{{ $tipo->nombre }}</span></a>
            @endforeach
        </details>

        <details class="p-2 group" @isset($filtropobla) open @else close @endisset>
            <summary class="flex items-center justify-between cursor-pointer">
                <h5 class="text-lg font-medium text-gray-900">
                    {{ __('Filtrar actuacions per població') }}: @isset($filtropobla)
                        {{ $poblaciones[0] }}
                    @endisset
                </h5>
                @isset($filtropobla)
                    <a href="{{ route('actuacion.index') }}">
                        <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M15 15L21 21M21 15L15 21M10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L17 11"
                                    stroke="#b2843e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </a>
                @else
                    <span class="relative flex-shrink-0 ml-1.5 w-5 h-5">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 w-5 h-5 opacity-100 group-open:opacity-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute inset-0 w-5 h-5 opacity-0 group-open:opacity-100" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                @endisset
            </summary>

            @foreach ($poblaciones as $poblacion)
                <a href="{{ route('actuaciones-poblacion', ['poblacion' => $poblacion]) }}"><span
                        class="bg-gray-200 px-2 py-1 rounded-md mr-2">{{ $poblacion }}</span></a>
            @endforeach

        </details>



    </div>


    <!-- Actuaciones agrupadas por mes -->
    <div class="p-2">
        @foreach ($actuacionesPorMes as $mes => $actuacionesDelMes)
            <div class="w-full bg-white border-b border-gray-300 p-2">
                <h2
                    class="mb-1 mt-2 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-2xl text-center">
                    @php
                        $fechaCarbon = \Carbon\Carbon::createFromFormat('m/Y', $mes);
                        $mesFormateado = ucfirst($fechaCarbon->translatedFormat('F Y'));
                    @endphp
                    <div class="flex justify-center items-center space-x-2">
                        <span class="text-zinc-950">
                            {{ __($mesFormateado) }}
                        </span>
                        <span class="text-zinc-950 text-sm" style="color: darkgray;">
                            ({{ $actuacionesDelMes->count() }} {{ strtolower(__('eventos')) }})
                        </span>
                    </div>
                </h2>
            </div>



            <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                @foreach ($actuacionesDelMes->sortBy('fechaActuacion') as $actuacion)
                    @php
                        $cardBorderClass = 'border border-transparent';
                        $estaEnLista = false;
                        $noDisponible = false;
                        $pivot = null;

                        if (auth()->check()) {
                            try {
                                $listaId = $actuacion->lista_id ?? (optional($actuacion->lista)->id ?? null);

                                if ($listaId) {
                                    $pivot = \Illuminate\Support\Facades\DB::table('listas_user')
                                        ->where('listas_id', $listaId)
                                        ->where('user_id', auth()->id())
                                        ->first();

                                    if ($pivot) {
                                        $estaEnLista = true;

                                        if (isset($pivot->disponible)) {
                                            $noDisponible = (int) $pivot->disponible === 0;
                                        } elseif (isset($pivot->asiste)) {
                                            $noDisponible = (int) $pivot->asiste === 0;
                                        } elseif (isset($pivot->estado)) {
                                            $estado = strtolower((string) $pivot->estado);
                                            $noDisponible = in_array(
                                                $estado,
                                                ['no', '0', 'nd', 'ausente', 'no_disponible', 'no disponible'],
                                                true,
                                            );
                                        }

                                        $cardBorderClass = $noDisponible
                                            ? 'border-2 border-red-500'
                                            : 'border-2 border-green-500';
                                    }
                                }
                            } catch (\Throwable $e) {
                                \Illuminate\Support\Facades\Log::error(
                                    'Error comprobando pertenencia/estado en lista (view-listas)',
                                    [
                                        'actuacion_id' => $actuacion->id ?? null,
                                        'user_id' => auth()->id(),
                                        'message' => $e->getMessage(),
                                    ],
                                );
                            }
                        }
                    @endphp

                    <div
                        class="relative flex flex-col shadow-md rounded-xl overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 max-w-sm {{ $cardBorderClass }}">
                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}"
                            class="z-20 absolute h-full w-full top-0 left-0">&nbsp;</a>


                        <div class="h-auto overflow-hidden">
                            <div class="h-40 overflow-hidden relative">
                                <img src="{{ asset('storage/imagenes/tipoactuacion/' . $actuacion->tipoactuacion->icon) }}"
                                    alt="{{ $actuacion->tipoactuacion->nombre }}" class="object-cover w-full h-full">
                            </div>
                        </div>
                        <div class="bg-white py-4 px-3">
                            <h3 class="text-l mb-2 font-medium">{{ $actuacion->descripcion }}</h3>

                            <div class="flex items-center justify-between">
                                <h2 class="text-l mb-2 font-medium" style="color: darkgray;">
                                    {{ $actuacion->contrato->descripcion }}
                                </h2>

                                @if ($estaEnLista)
                                    <div class="flex items-center ml-2">
                                        @if ($noDisponible)
                                            {{-- No disponible --}}
                                            <x-disponible w="24" h="24" />
                                        @else
                                            {{-- Está en la lista --}}
                                            <x-verificado w="24" h="24" />
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <hr class="p-2">
                            <div class="flex items-center mb-2">
                                <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                    viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"
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
                                {{ $actuacion->contrato->poblacion }}
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center mb-1">
                                    <svg width="26px" height="26px" viewBox="0 0 1024 1024" class="icon"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
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
                                            <path
                                                d="M546.156 724.31h66.597v66.598h-66.597zM404.239 468.427h66.598v66.597h-66.598z"
                                                fill="#228E9D"></path>
                                            <path d="M404.239 596.369h66.598v66.597h-66.598z" fill="#B12800"></path>
                                            <path
                                                d="M404.239 724.31h66.598v66.598h-66.598zM262.323 596.369h66.598v66.597h-66.598z"
                                                fill="#228E9D"></path>
                                            <path d="M262.323 724.31h66.598v66.598h-66.598z" fill="#B12800"></path>
                                        </g>
                                    </svg>

                                    @php
                                        $fechaActuacion = Carbon\Carbon::parse($actuacion->fechaActuacion);
                                        $nombreDia = ucfirst($fechaActuacion->translatedFormat('l')); // Nombre del día con la primera letra en mayúscula
                                        $fechaFormateada = $fechaActuacion->format('d/m/Y');
                                    @endphp

                                    <p class="text-base text-black-400">
                                        {{ $nombreDia }} ({{ $fechaFormateada }})
                                    </p>
                                </div>

                                <div class="relative z-40 flex items-center gap-2">
                                    @if ($actuacion->comments()->count() > 0)
                                        <div>
                                            <a
                                                href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}#messages">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-7 w-7 mr-2 text-blue-600 animate-bounce"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                    @can('admin')
                                        @if (Carbon\Carbon::parse($actuacion->fechaActuacion)->isToday() ||
                                                Carbon\Carbon::parse($actuacion->fechaActuacion)->isFuture())
                                            <a class="enviarNotificacion text-orange-600 hover:text-blue-500"
                                                href="#" alt="Notificar" data-actuacion-id="{{ $actuacion->id }}"
                                                data-actuacion-inf="{{ $actuacion->descripcion }}">
                                                <x-aviso w="32" h="32" />
                                            </a>
                                        @endif
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    <x-subscription-info />

    @can('admin')
        <script>
            var botonesNotificacion = document.querySelectorAll('.enviarNotificacion');

            // Iterar sobre cada botón y agregar el event listener
            botonesNotificacion.forEach(function(boton) {
                boton.addEventListener('click', function(event) {
                    event.preventDefault();
                    var listaId = boton.getAttribute('data-actuacion-id');
                    var mensaje = boton.getAttribute('data-actuacion-inf');

                    enviarNotif(listaId, mensaje);
                });
            });

            function enviarNotif(idActua, detalle) {

                if (confirm('{{ __('common.notificargrupo') }}' + detalle)) {

                    $.ajax({
                        url: '/notificaractuacion',
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
        </script>
    @endcan
</x-app-layout>
