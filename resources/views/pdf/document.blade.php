<html>
<head>
    <x-slot name="title">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $actuacion->descripcion }}
        </h2>
        <div class="flex items-center mt-2 mb-4 text-gray-500 w-full">
            <x-ubicacion w="16" h="16" />
            <span class="mr-4">{{ $actuacion->contrato->poblacion }}</span>
            <!-- Icono de calendario -->
            <x-calendario w="16" h="16" />
            <!-- Fecha de la actuación -->
            <span class="mr-4">{{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}</span>
            <!-- Icono de usuarios -->
            @if ($actuacion->musicos > 0)
                <x-musicos w="16" h="16" />
                <!-- Número de músicos -->
                <span class="mr-4">{{ $actuacion->musicos }}</span>
            @endif
            @if ($actuacion->coches > 0)
                <x-coche w="16" h="16" />
                <span class="mr-4">{{ $actuacion->coches }}</span>
            @endif
        </div>
    </x-slot>
</head>
<body>
    <x-slot name="content">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
            @foreach ($usuarios->groupBy('instrument_id') as $instrumento => $usuariosDelInstrumento)
                <details class="p-2 group" open>
                    <summary class="flex items-center justify-between cursor-pointer">
                        <h5 class="text-lg font-medium text-gray-900">
                            {{ $usuariosDelInstrumento->first()->instrument->name }}
                            ({{ $usuariosDelInstrumento->where('seleccionado', true)->count() }})
                        </h5>
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
                    </summary class="flex items-center justify-between cursor-pointer">

                    <ul class="divide-y divide-gray-200">
                        @foreach ($usuariosDelInstrumento->sortBy('name')->sortBy('forastero') as $user)
                            @if (!$user->seleccionado)
                                @continue
                            @endif
                            <li class="@if ($user->forastero) forastero {{ $user->instrument->name }} @endif p-3 flex justify-between items-center user-card "
                                style="@if (Auth::user()->id == $user->id) background-color: #ffbd59; @endif">

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
                                </div>

                                <div>
                                    <div class="flex items-center">
                                        <input style="float: left;margin-right: 15px;" type="checkbox"
                                            data-lista-id="{{ $lista->id }}"
                                            data-usuario-id="{{ $user->id }}"
                                            {{ $user->seleccionado ? 'checked' : '' }} disabled>

                                        @if ($user->coche)
                                            <x-coche w="24" h="24" />
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </details>
            @endforeach
        </div>
    </x-slot>
</body>
</html>