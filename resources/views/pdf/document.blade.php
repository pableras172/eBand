<html>
<head>
    
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $actuacion->descripcion }}
        </h2>
        <div class="flex items-center mt-2 mb-4 text-gray-500 w-full">
           
            <span class="mr-4">{{ $actuacion->contrato->poblacion }}</span>
            <!-- Icono de calendario -->
           
            <!-- Fecha de la actuación -->
            <span class="mr-4">{{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}</span>
            <!-- Icono de usuarios -->
            @if ($actuacion->musicos > 0)
               
                <!-- Número de músicos -->
                <span class="mr-4">{{ $actuacion->musicos }}</span>
            @endif
            @if ($actuacion->coches > 0)
                
                <span class="mr-4">{{ $actuacion->coches }}</span>
            @endif
        </div>
  
</head>
<body>
    
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
            @foreach ($usuarios->groupBy('instrument_id') as $instrumento => $usuariosDelInstrumento)
                <details class="p-2 group" open>
                    <summary class="flex items-center justify-between cursor-pointer">
                        <h5 class="text-lg font-medium text-gray-900">
                            {{ $usuariosDelInstrumento->first()->instrument->name }}
                            ({{ $usuariosDelInstrumento->where('seleccionado', true)->count() }})
                        </h5>
                       
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
                                            Coche
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </details>
            @endforeach
        </div>
  
</body>
</html>