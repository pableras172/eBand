@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $esPadre = $user->hijos()->exists();
    $hijos = $esPadre ? $user->hijos : collect();
    $usuarioActivo = session('usuarioActivo', $user); // ya debes tener esto en algún middleware o lógica previa

    //dd($usuarioActivo);

@endphp


@php

    $actuacion = \App\Models\Actuacion::join('listas', 'actuacions.id', '=', 'listas.actuacions_id')
        ->join('listas_user', 'listas.id', '=', 'listas_user.listas_id')
        ->where('listas_user.user_id', $usuarioActivo->id)
        ->where('actuacions.fechaActuacion', '>=', now())
        ->where('actuacions.fechaActuacion', '<=', now()->addDays(30))
        ->orderBy('actuacions.fechaActuacion', 'asc')
        ->select('actuacions.*', 'listas_user.disponible as disp', 'listas_user.user_id')
        ->get();

    $actuacionesBanda = App\Models\Actuacion::whereBetween('fechaActuacion', [now(), now()->addDays(7)])
        ->with('tipo')
        ->with('contrato')
        ->get();

      //dd($actuacion); 
@endphp
<div>
@if ($esPadre)
    <div class="bg-yellow-100 text-gray-800 text-sm p-2 mb-1 rounded flex items-center gap-2">
        {{-- Icono --}}
        <svg height="32px" width="32px" version="1.1" id="_x36_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#646363;" d="M468.125,128.73C304.284,99.474,234.069,0,234.069,0S163.847,99.474,0.013,128.73 c0,64.367-5.858,277.944,234.056,383.27C473.976,406.675,468.125,193.098,468.125,128.73z"></path> <path style="fill:#EAEEBE;" d="M234.069,466.88C63.977,384.073,43.61,240.378,41.255,161.786 c95.349-23.792,158.067-69.25,192.814-101.558c34.747,32.308,97.458,77.766,192.807,101.558 C424.528,240.378,404.155,384.073,234.069,466.88z"></path> <path style="fill:#F0C57B;" d="M410.284,169.867c-1.813,70.95-19.134,203.716-176.215,279.583 c-29.05-14.015-53.306-29.989-73.582-47.191c-27.411-23.173-47.513-48.568-62.293-74.285 c-33.346-58.164-39.32-118.025-40.346-158.106c88.156-21.531,145.384-63.78,176.221-92.92 c15.328,14.483,37.185,32.21,66.118,49.035c26.16,15.183,58.132,29.637,96.284,40.256 C400.981,167.525,405.6,168.725,410.284,169.867z"></path> <g> <path style="fill:#716363;" d="M234.069,76.947c-30.837,29.14-88.066,71.389-176.221,92.92 c0.613,23.74,3.007,54.442,11.742,87.595h164.48V76.947z"></path> <path style="opacity:0.26;fill:#F1891A;" d="M396.472,166.238c-38.152-10.618-70.124-25.073-96.284-40.256 c-28.934-16.825-50.79-34.552-66.118-49.035v180.515h164.506c8.748-33.153,11.103-63.841,11.709-87.595 C405.6,168.725,400.981,167.525,396.472,166.238z"></path> <path style="opacity:0.26;fill:#F1891A;" d="M69.589,257.462c6.012,22.824,15.011,46.8,28.604,70.512 c14.78,25.718,34.882,51.113,62.293,74.285c20.276,17.202,44.532,33.176,73.582,47.191V257.462H69.589z"></path> <path style="fill:#716363;" d="M234.069,449.449c104.49-50.468,147.133-126.108,164.506-191.988H234.069V449.449z"></path> </g> <path style="opacity:0.08;fill:#231815;" d="M234.069,0c0,0,70.215,99.474,234.056,128.73c0,64.367,5.851,277.944-234.056,383.27V0 z"></path> </g> </g></svg>
        
        {{-- Texto --}}
        <span>
            {{ __('Estàs veient la informació de:') }}
        </span>

        {{-- Selector de hijos --}}
        @if (Auth::user()->hijos && Auth::user()->hijos->count() > 0)
            <form method="GET" action="{{ route('dashboard') }}">
                <select name="hijo_id" class="ml-2 border-gray-300 rounded" onchange="this.form.submit()">
                    @foreach (Auth::user()->hijos as $hijo)
                        <option value="{{ $hijo->id }}" {{ $hijo->id == $usuarioActivo->id ? 'selected' : '' }}>
                            {{ $hijo->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        @else
            <strong>{{ $usuarioActivo->name }}</strong>
        @endif
    </div>
    
    @endif


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
                @foreach ($actuacion->where('disp', 1) as $actuacionu)               
                    
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
