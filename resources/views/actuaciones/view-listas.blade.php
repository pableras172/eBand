<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('common.calendario_proximas') }}
        </h2>
    </x-slot>

    {{-- <div class="flex justify-center">
        <div class="p-4 w-full lg:w-1/2">
            <!-- Botones de acción -->
            <div class="p-2 text-gray-900 bg-white rounded-lg shadow-lg font-medium capitalize">
                <span class="px-2 py-1 cursor-pointer hover:bg-gray-200 hover:text-gray-700 text-sm rounded mb-5">
                    <i class="w-8 fas fa-stream p-2 bg-gray-200 rounded-full"></i>
                    <span class="mx-1">Tipus</span>
                </span>
                <span class="px-1 cursor-pointer hover:text-gray-700">
                    <i class="w-8 fas fa-calendar-alt p-2 bg-gray-200 rounded-full"></i>
                    <span class="mx-1">Afegir</span>
                </span>
                <span class="w-10 relative float-right mr-3 cursor-pointer hover:text-gray-700">
                    <span class="px-1 cursor-pointer hover:text-gray-700">
                        <i class="fas fa-search p-2 bg-gray-200 rounded-full"></i>
                    </span>
                </span>
            </div>
        </div>
    </div> --}}

    <!-- Actuaciones agrupadas por mes -->
    <div class="p-2">
        @foreach ($actuacionesPorMes as $mes => $actuacionesDelMes)
            <h2
                class="mb-2 mt-2 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl text-center">
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">{{ $mes }}</span>
            </h2>
            <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                @foreach ($actuacionesDelMes->sortBy('fechaActuacion') as $actuacion)
                    <div
                        class="relative flex flex-col shadow-md rounded-xl overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 max-w-sm">
                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}"
                            class="z-20 absolute h-full w-full top-0 left-0">&nbsp;</a>
                        <div class="h-auto overflow-hidden">
                            <div class="h-40 overflow-hidden relative">
                                <img src="{{ asset('storage/imagenes/tipoactuacion/' . $actuacion->tipoactuacion->icon) }}"
                                    alt="{{ $actuacion->tipoactuacion->nombre }}" class="object-cover w-full h-full">
                            </div>
                        </div>
                        <div class="bg-white py-4 px-3">
                            <h3 class="text-xl mb-2 font-medium">{{ $actuacion->descripcion }}</h3>
                            <h3 class="text-xl mb-2 font-medium">{{ __('Contracte') }}:
                                {{ $actuacion->contrato->poblacion }}</h3>
                            <div class="flex justify-between items-center">
                                <p class="text-base text-black-400">
                                    <i class="w-8 fas fa-calendar-alt p-2 bg-gray-200 rounded-full text-black"></i>
                                    {{ $actuacion->fechaActuacion }}
                                </p>
                                <div class="relative z-40 flex items-center gap-2">
                                    @can('admin')
                                        <a class="enviarNotificacion text-orange-600 hover:text-blue-500" href="#"
                                            alt="Notificar" data-actuacion-id="{{ $actuacion->id }}"
                                            data-actuacion-inf="{{ $actuacion->descripcion }}">
                                            <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M12.0196 2.91016C8.7096 2.91016 6.0196 5.60016 6.0196 8.91016V11.8002C6.0196 12.4102 5.7596 13.3402 5.4496 13.8602L4.2996 15.7702C3.5896 16.9502 4.0796 18.2602 5.3796 18.7002C9.6896 20.1402 14.3396 20.1402 18.6496 18.7002C19.8596 18.3002 20.3896 16.8702 19.7296 15.7702L18.5796 13.8602C18.2796 13.3402 18.0196 12.4102 18.0196 11.8002V8.91016C18.0196 5.61016 15.3196 2.91016 12.0196 2.91016Z"
                                                        stroke="#eba937" stroke-width="1.5" stroke-miterlimit="10"
                                                        stroke-linecap="round"></path>
                                                    <path
                                                        d="M13.8699 3.19994C13.5599 3.10994 13.2399 3.03994 12.9099 2.99994C11.9499 2.87994 11.0299 2.94994 10.1699 3.19994C10.4599 2.45994 11.1799 1.93994 12.0199 1.93994C12.8599 1.93994 13.5799 2.45994 13.8699 3.19994Z"
                                                        stroke="#eba937" stroke-width="1.5" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path opacity="0.4"
                                                        d="M15.0195 19.0601C15.0195 20.7101 13.6695 22.0601 12.0195 22.0601C11.1995 22.0601 10.4395 21.7201 9.89953 21.1801C9.35953 20.6401 9.01953 19.8801 9.01953 19.0601"
                                                        stroke="#eba937" stroke-width="1.5" stroke-miterlimit="10"></path>
                                                </g>
                                            </svg>
                                        </a>
                                    @endcan
                                    {{-- <a class="text-orange-600 hover:text-blue-500" href="" alt="Generar iCal">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                    </a>
                                    <a class="text-orange-600 hover:text-blue-500"
                                        href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}"
                                        alt="Més informació">
                                        <svg height="40" width="40" version="1.1" id="Layer_1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                                            xml:space="preserve" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path style="fill:#C6C5CA;"
                                                    d="M507.837,244.913c-1.147-1.312-28.596-32.502-72.998-63.93 c-59.487-42.105-121.329-64.362-178.84-64.362c-57.51,0-119.352,22.256-178.838,64.362c-44.402,31.428-71.852,62.618-72.998,63.93 c-5.549,6.35-5.549,15.824,0,22.174c1.147,1.312,28.596,32.502,72.998,63.93c59.487,42.105,121.329,64.362,178.838,64.362 c57.511,0,119.353-22.256,178.84-64.362c44.402-31.428,71.852-62.618,72.998-63.93C513.387,260.738,513.387,251.263,507.837,244.913 z">
                                                </path>
                                                <path style="fill:#E1E1E3;"
                                                    d="M255.999,116.62L255.999,116.62c-57.511,0-119.353,22.256-178.84,64.362 c-44.402,31.428-71.852,62.618-72.998,63.93c-5.549,6.35-5.549,15.824,0,22.174c1.147,1.312,28.596,32.502,72.998,63.93 c59.487,42.105,121.329,64.362,178.838,64.362l0,0V116.62H255.999z">
                                                </path>
                                                <path style="fill:#fad900;"
                                                    d="M255.999,160.759c-52.516,0-95.241,42.726-95.241,95.242s42.724,95.242,95.241,95.242 s95.242-42.726,95.242-95.242S308.516,160.759,255.999,160.759z">
                                                </path>
                                                <path style="fill:#a28125;"
                                                    d="M255.999,160.759L255.999,160.759c-52.516,0-95.242,42.726-95.242,95.242 s42.724,95.242,95.241,95.242l0,0V160.759H255.999z">
                                                </path>
                                                <path style="fill:#252426;"
                                                    d="M255.999,214.787c-22.724,0-41.212,18.488-41.212,41.212s18.488,41.212,41.212,41.212 s41.212-18.488,41.212-41.212S278.724,214.787,255.999,214.787z">
                                                </path>
                                                <path style="fill:#39383B;"
                                                    d="M255.999,214.787L255.999,214.787c-22.725,0-41.212,18.488-41.212,41.212 s18.488,41.212,41.212,41.212l0,0V214.787z">
                                                </path>
                                            </g>
                                        </svg>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    @can('admin')
    <script>
        var botonesNotificacion = document.querySelectorAll('.enviarNotificacion');

        // Agregar un event listener para el clic en el botón
        botonesNotificacion.addEventListener('click', function(boton) {
            boton.preventDefault();
            var listaId = boton.getAttribute('data-actuacion-id');
            var mensaje = boton.getAttribute('data-actuacion-inf');

            enviarNotif(listaId, mensaje);

        });

        function enviarNotif(idActua, detalle) {

            if (confirm('Seguro que quieres notificar a todos los usuarios de la actuación:' + detalle)) {

                $.ajax({
                    url: '/notificaractuacion',
                    method: 'POST',
                    data: {
                        id: idActua,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {

                    },
                    error: function(xhr, status, error) {

                    }
                });
            }

        }
    </script>
    @endcan
</x-app-layout>
