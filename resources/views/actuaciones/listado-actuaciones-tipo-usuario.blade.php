@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $esPadre = $user->hijos()->exists();
    $hijos = $esPadre ? $user->hijos : collect();
    $usuarioActivo = session('usuarioActivo', $user); // ya debes tener esto en algún middleware o lógica previa

@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 leading-tight">
            {{ __('Actuaciones') }} - {{ $user->name }}
        </h2>

        @if ($esPadre)
            <div class="bg-yellow-100 text-gray-800 text-sm p-2 mb-1 rounded flex items-center gap-2">
                {{-- Icono --}}
                <svg height="32px" width="32px" version="1.1" id="_x36_" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
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

                {{-- Texto --}}
                <span>
                    {{ __('Estàs veient la informació de:') }}
                </span>

                @if (Auth::user()->hijos && Auth::user()->hijos->count() > 0)
                    <form method="GET" id="hijoForm">
                        <select name="hijo_id" class="ml-2 border-gray-300 rounded"
                            onchange="window.location.href = '/actuaciones/' + this.value + '/{{ date('Y') }}' + '?hijo_id=' + this.value">

                            @foreach (Auth::user()->hijos as $hijo)
                                <option value="{{ $hijo->id }}"
                                    {{ $hijo->id == $usuarioActivo->id ? 'selected' : '' }}>
                                    {{ $hijo->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif

            </div>

        @endif

        <details class="p-2 group" close>
            <summary>{{ __('informacion') }}</summary>
            <p class="mt-1 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                {{ __('info_listados') }}
            </p>
            <div class="flex items-center mt-1 mb-2 text-gray-500 w-full">
                <div class="mr-2 px-2 py-2 text-sm"><x-disponible w="24" h="24" />{{ __('Has marcat no disponible') }}
                </div>
                <div class="mr-2 px-2 py-2  text-sm"><x-coche w="24" h="24" />{{ __('Has agafat el cotxe') }}</div>
                <div class="mr-2 px-2 py-2  text-sm"><x-euro w="24" h="24" />{{ __('Actuació pagada') }}</div>
            </div>
        </details>
    </x-slot>

    <div class="bg-white border border-gray-200 divide-y divide-gray-200  m-2">
        <details class="p-2 group" @isset($filtrotipo) open @else close @endisset>
            <summary class="flex items-center justify-between cursor-pointer">
                <h5 class="text-base font-medium text-gray-900">
                    {{ __('Filtrar actuacions per tipus') }}:
                </h5>
                @isset($filtrotipo)
                    <a href="{{ route('actuaciones.usuario.anyo', [$usuarioActivo->id, $year]) }}">
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
            @foreach ($tiposActuacion as $tipoId => $tipoNombre)
                <a href="{{ route('actuaciones.usuario.listatipo', ['user' => $usuarioActivo->id, 'year' => $year, 'type' => $tipoId]) }}"
                    class="text-sm font-medium text-gray-900 truncate dark:text-white">
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
                    <a href="{{ route('actuaciones.usuario.anyo', [$usuarioActivo->id, $year]) }}">
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
                <a
                    href="{{ route('actuaciones.usuario.poblacion', ['user' => $usuarioActivo->id, 'year' => $year, 'poblacion' => $poblacion]) }}">
                    <span class="bg-gray-200 px-2 py-1 rounded-md mr-2">{{ $poblacion }}</span>
                </a>
            @endforeach

        </details>

    </div>

    <div class="mx-auto mt-2 p-2">
        <div class="p-4 bg-white rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold leading-none text-gray-900 dark:text-white">
                    {{ __('Listado de actuaciones del año: ') }}</h3>
                <div class="relative">
                    <select id="yearSelect"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-8 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        @for ($i = date('Y') - 2; $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
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

        <div class="max-w-xl mx-auto mt-6 p-4 bg-white shadow-md rounded-lg">
            <canvas id="actuacionesChart"></canvas>
        </div>




    </div>
    <x-subscription-info />
    <script>
        document.getElementById('yearSelect').addEventListener('change', function() {
            var year = this.value;
            window.location.href = "/actuaciones/" + {{ $usuarioActivo->id }} + "/" + year;
        });

        // Obtener datos del backend
        const labels = @json($labels);
        const data = @json($data);

        // Generar colores aleatorios para cada barra
        const backgroundColors = labels.map(() => {
            const r = Math.floor(Math.random() * 256);
            const g = Math.floor(Math.random() * 256);
            const b = Math.floor(Math.random() * 256);
            return `rgba(${r}, ${g}, ${b}, 0.6)`;
        });

        const borderColors = backgroundColors.map(color => color.replace('0.6', '1'));

        // Configurar el gráfico
        const ctx = document.getElementById('actuacionesChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Número de actuaciones',
                    data: data,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Actuaciones por tipo en ' + document.getElementById('yearSelect').value
                    }
                }
            }
        });
    </script>
</x-app-layout>
