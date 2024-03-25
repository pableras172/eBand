<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Calendario de la banda - Próximas actuaciones
        </h2>
    </x-slot>

    <div class="flex justify-center">
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
    </div>

    <!-- Actuaciones agrupadas por mes -->
    <div class="p-2">
        @foreach ($actuacionesPorMes as $mes => $actuacionesDelMes)
        <h2 class="mb-2 mt-2 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl text-center"><span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">{{ $mes }}</span></h2>
        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                @foreach ($actuacionesDelMes->sortBy('fechaActuacion') as $actuacion)
                    <div class="relative flex flex-col shadow-md rounded-xl overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 max-w-sm">
                        <a href="" class="z-20 absolute h-full w-full top-0 left-0">&nbsp;</a>
                        <div class="h-auto overflow-hidden">
                            <div class="h-44 overflow-hidden relative">
                                <img src="{{ asset('storage/imagenes/actuacions/'.$actuacion->icon) }}" alt="{{ $actuacion->descripcion }}">
                            </div>
                        </div>
                        <div class="bg-white py-4 px-3">
                            <h3 class="text-xl mb-2 font-medium">{{ $actuacion->descripcion }}</h3>
                            <h3 class="text-xl mb-2 font-medium">Contrato: {{ $actuacion->contrato->poblacion }}</h3>
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-400">
                                    <i class="w-8 fas fa-calendar-alt p-2 bg-gray-200 rounded-full text-black"></i> {{ $actuacion->fechaActuacion }}
                                </p>
                                <div class="relative z-40 flex items-center gap-2">
                                    <a class="text-orange-600 hover:text-blue-500" href="" alt="Generar iCal">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                    </a>
                                    <a class="text-orange-600 hover:text-blue-500" href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}" alt="Més informació">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white hover:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.1 4H5c-.5 0-.9.4-.9.9V9c0 .5.4.9.9.9h4c.5 0 .9-.4.9-.9V5c0-.5-.4-.9-.9-.9Zm10 0H15c-.5 0-.9.4-.9.9V9c0 .5.4.9.9.9h4c.5 0 .9-.4.9-.9V5c0-.5-.4-.9-.9-.9Zm-10 10H5c-.5 0-.9.4-.9.9V19c0 .5.4.9.9.9h4c.5 0 .9-.4.9-.9v-4c0-.5-.4-.9-.9-.9Zm10 0H15c-.5 0-.9.4-.9.9V19c0 .5.4.9.9.9h4c.5 0 .9-.4.9-.9v-4c0-.5-.4-.9-.9-.9Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</x-app-layout>
