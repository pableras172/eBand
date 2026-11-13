<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <x-ui.breadcrumbs>
                    <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                    <x-ui.breadcrumbs.separator />
                    <x-ui.breadcrumbs.link active>{{ __('common.calendario') }}</x-ui.breadcrumbs.link>
                </x-ui.breadcrumbs>
                <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-white tracking-tight mt-1">
                    {{ __('common.calendario_proximas') }}
                </h1>
                <p class="text-sm text-slate-400">
                    {{ __('Gestió d\'actuacions, assajos i convocatòries de la banda') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 pb-12">
        {{-- Módulo de Filtros y Búsqueda (Dark Command Center) --}}
        <div class="bg-[#111827] border border-slate-800/80 rounded-2xl p-4 lg:p-5 shadow-lg backdrop-blur-sm">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 border-b border-slate-800/80 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-white uppercase tracking-wider">
                            {{ __('Filtres del Calendari') }}
                        </h2>
                        <p class="text-xs text-slate-400">
                            {{ __('Filtra per tipus, data o localitat de l\'esdeveniment') }}
                        </p>
                    </div>
                </div>

                {{-- Filtro por Fecha --}}
                <form action="{{ route('actuaciones-fecha') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <label for="fecha" class="text-xs font-medium text-slate-300">
                        {{ __('Des de:') }}
                    </label>
                    <input type="date" id="fecha" name="fecha" 
                        value="{{ request('fecha', $filtroFecha ?? '') }}"
                        onchange="if(this.value) this.form.submit()"
                        class="bg-[#0B1120] border border-slate-700 text-slate-200 text-xs rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        min="{{ now()->subMonths(3)->format('Y-m-d') }}"
                        max="{{ now()->format('Y-m-d') }}">
                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl shadow-md transition-colors">
                        {{ __('Filtrar') }}
                    </button>
                    @if(isset($filtroFecha) || isset($filtrotipo) || isset($filtropobla))
                        <a href="{{ route('actuacion.index') }}" class="inline-flex items-center px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold rounded-xl border border-slate-700 transition-colors">
                            {{ __('Netejar tots') }}
                        </a>
                    @endif
                </form>
            </div>

            {{-- Chips de Filtrado por Tipo --}}
            <div class="pt-4 space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-semibold text-slate-400 mr-2 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                        {{ __('Tipus:') }}
                    </span>
                    <a href="{{ route('actuacion.index') }}" 
                        class="px-3 py-1.5 rounded-full text-xs font-medium transition {{ !isset($filtrotipo) ? 'bg-blue-600 text-white shadow-md shadow-blue-900/30 font-semibold' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700 border border-slate-700/60' }}">
                        {{ __('Tots els tipus') }}
                    </a>
                    @foreach ($tiposActuacion as $tipo)
                        @php
                            $isSelected = isset($filtrotipo) && $filtrotipo == $tipo->id;
                        @endphp
                        <a href="{{ route('actuaciones-tipo', ['tipoactuacion' => $tipo->id]) }}"
                            class="px-3 py-1.5 rounded-full text-xs font-medium transition {{ $isSelected ? 'bg-blue-600 text-white shadow-md shadow-blue-900/30 font-semibold' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700 border border-slate-700/60' }}">
                            {{ $tipo->nombre }}
                        </a>
                    @endforeach
                </div>

                {{-- Chips de Filtrado por Población (si hay disponibles) --}}
                @if(isset($poblaciones) && count($poblaciones) > 0)
                    <div class="flex flex-wrap items-center gap-2 pt-1 border-t border-slate-800/60">
                        <span class="text-xs font-semibold text-slate-400 mr-2 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                            {{ __('Població:') }}
                        </span>
                        <a href="{{ route('actuacion.index') }}" 
                            class="px-3 py-1.5 rounded-full text-xs font-medium transition {{ !isset($filtropobla) ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30 font-semibold' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700 border border-slate-700/60' }}">
                            {{ __('Totes les poblacions') }}
                        </a>
                        @foreach ($poblaciones as $poblacion)
                            @php
                                $isPoblaSelected = isset($filtropobla) && $filtropobla == $poblacion;
                            @endphp
                            <a href="{{ route('actuaciones-poblacion', ['poblacion' => $poblacion]) }}"
                                class="px-3 py-1.5 rounded-full text-xs font-medium transition {{ $isPoblaSelected ? 'bg-amber-500/30 text-amber-200 border border-amber-500/40 font-semibold' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700 border border-slate-700/60' }}">
                                {{ $poblacion }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Convocatorias agrupadas por Mes --}}
        @forelse ($actuacionesPorMes as $mes => $actuacionesDelMes)
            @php
                $fechaCarbon = \Carbon\Carbon::createFromFormat('m/Y', $mes);
                $mesFormateado = ucfirst($fechaCarbon->translatedFormat('F Y'));
            @endphp
            <div class="space-y-4">
                {{-- Encabezado de Mes Sticky --}}
                <div class="flex items-center justify-between sticky top-16 z-10 bg-[#0B1120]/90 backdrop-blur-md py-3 px-1 border-b border-slate-800">
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-7 bg-blue-600 rounded-full"></div>
                        <h2 class="text-xl lg:text-2xl font-bold font-headline text-white tracking-tight">
                            {{ $mesFormateado }}
                        </h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                            {{ $actuacionesDelMes->count() }} {{ $actuacionesDelMes->count() === 1 ? __('acte') : __('actes') }}
                        </span>
                    </div>
                </div>

                {{-- Grid de Actuaciones (1 col móvil, 2 cols tablet, 3 cols desktop xl) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach ($actuacionesDelMes->sortBy('fechaActuacion') as $actuacion)
                        @php
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
                                                    true
                                                );
                                            }
                                        }
                                    }
                                } catch (\Throwable $e) {
                                    // Ignore quietly in view
                                }
                            }

                            $fechaAct = \Carbon\Carbon::parse($actuacion->fechaActuacion);
                            $esHoy = $fechaAct->isToday();
                            $esPasada = $fechaAct->isPast() && !$esHoy;
                        @endphp

                        <div @if($loop->first && $loop->parent->first) id="driver-actuacion-first" @endif 
                            class="group relative flex flex-col bg-[#111827] border {{ $actuacion->oficial == 1 ? 'border-amber-500/40 hover:border-amber-500' : 'border-slate-800 hover:border-slate-700' }} rounded-2xl overflow-hidden shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-900/10">
                            
                            {{-- Banner visual con imagen / icono representativo --}}
                            <div class="relative h-44 overflow-hidden bg-slate-900">
                                <img src="{{ \App\Models\Tipoactuacion::resolveIconUrl($actuacion->tipoactuacion?->icon) }}"
                                    onerror="this.onerror=null;this.src='{{ asset(\App\Models\Tipoactuacion::DEFAULT_ICON_PATH) }}';"
                                    alt="{{ $actuacion->tipoactuacion?->nombre ?? 'Actuació' }}" 
                                    class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-500 opacity-80 group-hover:opacity-90">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-[#111827] via-[#111827]/40 to-transparent"></div>

                                {{-- Badges superiores flotantes --}}
                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none">
                                    <div class="flex items-center gap-1.5">
                                        @if ($actuacion->oficial == 1)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/90 text-slate-950 shadow-md backdrop-blur-sm">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ __('Acte Oficial') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-900/80 text-slate-200 border border-slate-700/80 backdrop-blur-sm">
                                                {{ $actuacion->tipoactuacion?->nombre ?? __('Actuació') }}
                                            </span>
                                        @endif

                                        @can('admin')
                                            @if ($actuacion->is_draft)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-500/20 text-yellow-300 border border-yellow-500/30">
                                                    {{ __('Esborrany') }}
                                                </span>
                                            @endif
                                        @endcan
                                    </div>

                                    {{-- Estado Asistencia personal --}}
                                    @if ($estaEnLista)
                                        @if ($noDisponible)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/40 backdrop-blur-md">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                                {{ __('No assistisc') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 backdrop-blur-md">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                                {{ __('Confirmant') }}
                                                @if ($pivot && (int) $pivot->coche === 1)
                                                    <span title="{{ __('Aportes cotxe') }}">🚗</span>
                                                @endif
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                {{-- Fecha y Hora sobre el degradado inferior del banner --}}
                                <div class="absolute bottom-3 left-3 right-3 flex items-end justify-between pointer-events-none">
                                    <div class="flex items-center gap-2">
                                        <div class="px-2.5 py-1 rounded-lg bg-blue-600/90 text-white font-bold text-xs uppercase tracking-wider backdrop-blur-sm shadow-md">
                                            {{ $fechaAct->translatedFormat('D d M') }}
                                        </div>
                                        <div class="text-xs font-semibold text-slate-200 bg-slate-900/80 px-2 py-1 rounded-lg border border-slate-700/60 backdrop-blur-sm">
                                            {{ $fechaAct->format('H:i') }} h
                                        </div>
                                    </div>
                                    @if($actuacion->contrato?->poblacion)
                                        <div class="text-xs font-medium text-slate-300 flex items-center gap-1 bg-slate-900/80 px-2 py-1 rounded-lg border border-slate-700/60">
                                            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="truncate max-w-[120px]">{{ $actuacion->contrato->poblacion }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Cuerpo de la tarjeta --}}
                            <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                                <div>
                                    <h3 class="text-base font-bold font-headline text-white group-hover:text-blue-400 transition-colors line-clamp-2">
                                        {{ $actuacion->descripcion }}
                                    </h3>
                                    @if ($actuacion->contrato?->descripcion)
                                        <p class="text-xs text-slate-400 mt-1 line-clamp-1">
                                            {{ $actuacion->contrato->descripcion }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Barra de quórum / métrica de músicos requeridos --}}
                                @if ($actuacion->musicos > 0)
                                    <div class="bg-slate-900/60 border border-slate-800 rounded-xl p-2.5 space-y-1.5">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-400 font-medium flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                {{ __('Convocatòria plantilla') }}
                                            </span>
                                            <span class="font-bold text-slate-200">
                                                {{ $actuacion->musicos }} {{ __('músics') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                {{-- Pie con acciones --}}
                                <div class="pt-2 border-t border-slate-800 flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        {{-- Enlace a Comentarios --}}
                                        @if ($actuacion->comments()->count() > 0)
                                            <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}#messages"
                                                class="inline-flex items-center gap-1 text-xs font-semibold text-blue-400 hover:text-blue-300 bg-blue-600/10 px-2 py-1 rounded-lg border border-blue-500/20">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                </svg>
                                                {{ $actuacion->comments()->count() }}
                                            </a>
                                        @endif

                                        {{-- Opciones de Administrador --}}
                                        @can('admin')
                                            @if ($esHoy || $fechaAct->isFuture())
                                                <button type="button" 
                                                    class="enviarNotificacion text-slate-400 hover:text-amber-400 p-1.5 rounded-lg hover:bg-slate-800 transition"
                                                    title="{{ __('Notificar al grup') }}"
                                                    data-actuacion-id="{{ $actuacion->id }}"
                                                    data-actuacion-inf="{{ $actuacion->descripcion }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                                    </svg>
                                                </button>
                                            @endif
                                            <a href="{{ route('actuacion.edit', ['actuacion' => $actuacion]) }}" 
                                                class="text-slate-400 hover:text-blue-400 p-1.5 rounded-lg hover:bg-slate-800 transition"
                                                title="{{ __('Editar actuació') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        @endcan
                                    </div>

                                    {{-- Botón Principal: Ver Detalle y Asistencia --}}
                                    <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold transition-all shadow-md hover:shadow-blue-900/30">
                                        <span>{{ __('Convocatòria') }}</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-[#111827] border border-slate-800 rounded-2xl p-12 text-center max-w-xl mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-blue-600/10 border border-blue-500/20 text-blue-400 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold font-headline text-white mb-1">
                    {{ __('No hi ha actuacions programades') }}
                </h3>
                <p class="text-sm text-slate-400 mb-6">
                    {{ __('No s\'han trobat esdeveniments amb els criteris seleccionats.') }}
                </p>
                <a href="{{ route('actuacion.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-xl shadow-lg transition">
                    {{ __('Veure totes les actuacions') }}
                </a>
            </div>
        @endforelse
    </div>

    <x-subscription-info />

    @can('admin')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var botonesNotificacion = document.querySelectorAll('.enviarNotificacion');
                botonesNotificacion.forEach(function(boton) {
                    boton.addEventListener('click', function(event) {
                        event.preventDefault();
                        var listaId = boton.getAttribute('data-actuacion-id');
                        var mensaje = boton.getAttribute('data-actuacion-inf');
                        enviarNotif(listaId, mensaje);
                    });
                });
            });

            function enviarNotif(idActua, detalle) {
                if (confirm('{{ __('common.notificargrupo') }} ' + detalle)) {
                    $.ajax({
                        url: '/notificaractuacion',
                        method: 'POST',
                        data: {
                            id: idActua,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (typeof showToast === 'function') {
                                showToast(response);
                            } else {
                                alert(response.message || 'Notificació enviada');
                            }
                        },
                        error: function(xhr, status, error) {
                            if (typeof showToast === 'function') {
                                showToast(xhr.responseJSON);
                            } else {
                                alert('Error enviant la notificació');
                            }
                        }
                    });
                }
            }
        </script>
    @endcan

    @php
        $driverSteps = [
            ['element' => '#fecha', 'popover' => ['title' => __('Filtrar'), 'description' => __('Usa els filtres per afinar la llista d\'actuacions.'), 'position' => 'bottom']],
            ['element' => '#driver-actuacion-first', 'popover' => ['title' => __('Actuació'), 'description' => __('Fes clic per veure els detalls i la convocatòria de l\'acte.'), 'position' => 'right']],
        ];
    @endphp

    <script>
        (function () {
            const STORAGE_KEY = 'eband_driver_tour_shown_actuaciones_v1';
            try {
                if (localStorage.getItem(STORAGE_KEY)) return;
            } catch (e) {
                return;
            }

            const driverSteps = @json($driverSteps);

            function tryStart() {
                if (window.startDriverTour && typeof window.startDriverTour === 'function') {
                    try {
                        window.startDriverTour(driverSteps);
                        localStorage.setItem(STORAGE_KEY, '1');
                    } catch (err) {
                        console.error('Error starting driver tour:', err);
                    }
                } else {
                    setTimeout(tryStart, 500);
                }
            }

            document.addEventListener('DOMContentLoaded', tryStart);
        })();
    </script>
</x-app-layout>
