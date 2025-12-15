@php

    $actuacion = \App\Models\Actuacion::join('listas', 'actuacions.id', '=', 'listas.actuacions_id')
        ->join('listas_user', 'listas.id', '=', 'listas_user.listas_id')
        ->where('listas_user.user_id', session('usuarioActivo')->id)
        ->where('actuacions.fechaActuacion', '>=', now()) // Desde hoy
        ->where('actuacions.fechaActuacion', '<=', now()->addDays(30)) // Hasta 30 días
        ->orderBy('actuacions.fechaActuacion', 'asc')
        ->select('actuacions.*', 'listas_user.disponible as disp', 'listas_user.user_id')
        ->get(); // <- AÑADIR ESTO;
    //->first()

    $actuacionesBanda = App\Models\Actuacion::whereBetween('fechaActuacion', [now(), now()->addDays(7)])
        ->with('tipo')
        ->with('contrato')
        ->get();


@endphp
<div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-animated-calendar />
        </div>
        {{-- Columna izquierda: Próxima actuación --}}
        <div class="text-left bg-blue-100 p-3 rounded-lg">
            <h2 class="text-sm text-gray-600">{{ __('Tu próxima actuación') }}</h2>
            @php
                use Carbon\Carbon;
            @endphp

            @if ($actuacion->count() > 0)
                @foreach ($actuacion as $actuacionu)
                    @if ($actuacionu && $actuacionu->disp)
                    <div class="flex items-center justify-between border-b border-gray-200 py-2">
                        <p class="text-sm text-gray-600 mt-2">
                            {{ Carbon::parse($actuacionu->fechaActuacion)->format('d/m/Y') }}
                        </p>
                        <p class="text-l font-semibold text-gray-800 mt-2">
                            {{ $actuacionu->descripcion }}
                        </p>
                        
                            <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacionu->id]) }}">
                                <svg width="32px" height="32px" viewBox="0 0 24 24" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                        <title>ic_fluent_arrow_forward_24_regular</title>
                                        <desc>Created with Sketch.</desc>
                                        <g id="🔍-System-Icons" stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <g id="ic_fluent_arrow_forward_24_regular" fill="#b06d36"
                                                fill-rule="nonzero">
                                                <path
                                                    d="M14.6470979,6.30372605 L14.7197247,6.21961512 C14.9860188,5.95337607 15.402685,5.92921307 15.6962739,6.14709787 L15.7803849,6.21972471 L20.7769976,11.21737 C21.0430885,11.4835159 21.0673924,11.8999028 20.8498298,12.1934928 L20.777305,12.2776129 L15.7806923,17.2810585 C15.4879993,17.5741518 15.0131257,17.5744763 14.7200324,17.2817833 C14.453584,17.0156987 14.4290932,16.5990517 14.646747,16.3052914 L14.7193077,16.2211234 L18.4301989,12.504 L3.75019891,12.504946 C3.37050315,12.504946 3.05670795,12.2227922 3.00704553,11.8567166 L3.00019891,11.754946 C3.00019891,11.3752503 3.28235279,11.0614551 3.64842835,11.0117927 L3.75019891,11.004946 L18.4431989,11.004 L14.7196151,7.28027529 C14.4533761,7.01398122 14.4292131,6.59731504 14.6470979,6.30372605 L14.7197247,6.21961512 L14.6470979,6.30372605 Z"
                                                    id="🎨-Color"> </path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </div>
                    @endif
                @endforeach
            @else
                <p class="text-sm text-gray-600 mt-2">📅 {{ __('Nada a la vista') }}</p>
                <p class="text-l font-semibold text-gray-800 mt-2">
                    🎶 {{ __('No hay actuaciones') }}
                </p>
            @endif
        </div>


    </div>
    <div class="grid grid-cols-1 gap-4 mt-2">
        {{-- Columna izquierda: Próxima actuación --}}
        <div class="text-left bg-yellow-100 p-3 rounded-lg">
            <h2 class="text-sm text-gray-600">{{ __('En los próximos 7 días') }}</h2>

            @if ($actuacionesBanda->count() > 0)
                @foreach ($actuacionesBanda as $actuacionb)
                    @php
                        $fecha = $actuacionb->fechaActuacion;
                    @endphp
                    <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacionb->id]) }}">
                        <p class="text-m font-semibold text-gray-800 mt-2">
                            {{ $fecha ? Carbon::parse($fecha)->format('d/m/Y') : 'Sin fecha' }} -
                            {{ $actuacionb->descripcion }} - {{ $actuacionb->contrato->poblacion }} ➡</p>
                    </a>
                @endforeach
            @else
                <p class="text-m font-semibold text-gray-800 mt-2">{{ __('No hay actuaciones') }}</p>
            @endif

            <div class="flex justify-end">
                <svg width="32px" height="32px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    fill="#b06d36">
                    <g id="SVGRepo_iconCarrier">
                        <path d="M14.6470979,6.30372605 L14.7197247,6.21961512 C14.9860188,5.95337607 15.402685,5.92921307
                            15.6962739,6.14709787 L15.7803849,6.21972471 L20.7769976,11.21737 C21.0430885,11.4835159 21.0673924,11.8999028
                            20.8498298,12.1934928 L20.777305,12.2776129 L15.7806923,17.2810585 C15.4879993,17.5741518 15.0131257,17.5744763
                            14.7200324,17.2817833 C14.453584,17.0156987 14.4290932,16.5990517 14.646747,16.3052914 L14.7193077,16.2211234
                            L18.4301989,12.504 L3.75019891,12.504946 C3.37050315,12.504946 3.05670795,12.2227922 3.00704553,11.8567166
                            L3.00019891,11.754946 C3.00019891,11.3752503 3.28235279,11.0614551 3.64842835,11.0117927 L3.75019891,11.004946
                            L18.4431989,11.004 L14.7196151,7.28027529 C14.4533761,7.01398122 14.4292131,6.59731504 14.6470979,6.30372605
                            L14.7197247,6.21961512 L14.6470979,6.30372605 Z"></path>
                    </g>
                </svg>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 gap-4 mt-2">
        <div class="text-left bg-red-200 p-3 rounded-lg">
            <h2 class="text-sm text-gray-600">{{ __('No disponble per a') }}</h2>            
            @if ($actuacion->count() > 0)
                @foreach ($actuacion->where('disp', false) as $actuacionu)  
                <div class="flex items-center justify-between border-b border-gray-200 py-2">                
                        <p class="text-sm text-gray-600 mt-2">
                            📅 {{ Carbon::parse($actuacionu->fechaActuacion)->format('d/m/Y') }}
                        </p>
                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacionu->id]) }}">
                            <p class="text-l font-semibold text-gray-800 mt-2 flex items-center space-x-2 truncate">
                                <x-disponible w="24" h="24" />
                                <span class="truncate">{{ $actuacionu->descripcion }}</span>
                            </p>
                        </a>
                    </div>
                @endforeach
            @else
                <p class="text-sm text-gray-600 mt-2">📅 {{ __('Nada a la vista') }}</p>
                <p class="text-l font-semibold text-gray-800 mt-2">
                    ✔ {{ __('Parece que estas disponible para todo') }}
                </p>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <hr>
        <a href="{{ route('actuacion.index') }}"
            class="mt-2 flex justify-center items-center text-gray-600 text-sm font-medium hover:text-gray-800 transition">
            {{-- Icono de perfil (SVG) --}}
            <x-calendario w="24" h="24" />
            {{ __('common.calendario') }}
        </a>
    </div>

</div>
