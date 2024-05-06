<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 leading-tight">
            {{ __('Actuaciones') }} - {{ $user->name }}
        </h2>
        <details class="p-2 group"  close>
            <summary>{{__('informacion')}}</summary>
            <p class="mt-1 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                {{__('info_listados')}}
            </p>
            <div class="flex items-center mt-1 mb-2 text-gray-500 w-full">
                <div class="mr-2 px-2 py-2 text-sm"><x-disponible w="24" h="24" />{{ __('Has marcat no disponible') }}</div>
                <div class="mr-2 px-2 py-2  text-sm"><x-coche w="24" h="24" />{{ __('Has agafat el cotxe') }}</div>
                <div class="mr-2 px-2 py-2  text-sm"><x-euro w="24" h="24" />{{ __('Actuació pagada') }}</div>
            </div>
        </details>
    </x-slot>

    <div class="bg-white border border-gray-200 divide-y divide-gray-200  m-2">
        <details class="p-2 group"  @isset($filtrotipo) open @else close @endisset>
            <summary class="flex items-center justify-between cursor-pointer">
                <h5 class="text-base font-medium text-gray-900">
                    {{ __('Filtrar actuacions per tipus') }}:                     
                </h5>
                @isset($filtrotipo)                
                    <a href="{{ route('actuaciones.usuario.anyo', [$user->id, $year]) }}" >
                        <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 15L21 21M21 15L15 21M10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L17 11" stroke="#b2843e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
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
            @foreach ($tiposActuacion as $tipoId => $tipoNombre)
                <a href="{{ route('actuaciones.usuario.listatipo', ['user' => $user->id, 'year' => $year, 'type' => $tipoId]) }}" class="text-sm font-medium text-gray-900 truncate dark:text-white">
                    <span class="bg-gray-200 px-2 py-1 rounded-md mr-2">{{ $tipoNombre }} </span>
                </a>      
            @endforeach

        </details>

        <details class="p-2 group" @isset($filtropobla) open @else close @endisset>
            <summary class="flex items-center justify-between cursor-pointer">
                <h5 class="text-base font-medium text-gray-900">
                    {{ __('Filtrar actuacions per població') }}:
                </h5>
                @isset($filtropobla)                
                <a href="{{ route('actuaciones.usuario.anyo', [$user->id, $year]) }}" >
                    <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 15L21 21M21 15L15 21M10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L17 11" stroke="#b2843e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
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
                <a href="{{ route('actuaciones.usuario.poblacion',  ['user' => $user->id, 'year' => $year, 'poblacion' => $poblacion]) }}">
                    <span class="bg-gray-200 px-2 py-1 rounded-md mr-2">{{ $poblacion }}</span>
                </a>
            @endforeach
            
        </details>

    </div>

    <div class="max-w-2xl mx-auto mt-2">
        <div class="p-4 max-w-md bg-white rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold leading-none text-gray-900 dark:text-white">
                    {{ __('Listado de actuaciones del año: ') }}</h3>
                    <div class="relative">
                        <select id="yearSelect" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-8 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            @for ($i = date('Y') - 2; $i <= date('Y'); $i++)
                                <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                            <option value="{{ $year+1 }}">{{ $i }}</option>
                        </select>                       
                    </div>  
            </div>
            <hr>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($actuaciones as $actuacion)
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full"
                                        src="{{ asset('storage/imagenes/tipoactuacion/' . $actuacion->actuacion->tipoactuacion->icon) }}"
                                        alt="Tipo de actuación">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->actuacion->id]) }}"
                                            class="">{{ $actuacion->actuacion->descripcion }}</a>
                                    </p>
                                    <div class="flex items-center">
                                        @if (!$actuacion->pivot->disponible)
                                            <x-disponible w="24" h="24" />
                                        @endif

                                        @if ($actuacion->pivot->coche)
                                            <x-coche w="24" h="24" />
                                        @endif

                                        @if ($actuacion->pivot->pagada)
                                            <x-euro w="24" h="24" />
                                        @endif
                                    </div>

                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($actuacion->actuacion->fechaActuacion)->format('d/m/Y') }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('yearSelect').addEventListener('change', function() {
            var year = this.value;
            window.location.href = "/actuaciones/" + {{ $user->id }} + "/" + year;
        });
    </script>
</x-app-layout>
