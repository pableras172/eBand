@php
    use App\Helpers\ConfigHelper;
    $fechaActuacion = Carbon\Carbon::parse($actuacion->fechaActuacion);
    $nombreDia = ucfirst($fechaActuacion->translatedFormat('l'));
    $fechaFormateada = $fechaActuacion->format('d/m/Y');
    $horaFormateada = $fechaActuacion->format('H:i');
    $limiteAntelacion = ConfigHelper::getConfigValue('diasantelacion') ?? 5;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <x-ui.breadcrumbs>
                    <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                    <x-ui.breadcrumbs.separator />
                    <x-ui.breadcrumbs.link href="{{ route('actuacion.index') }}">{{ __('common.calendario') }}</x-ui.breadcrumbs.link>
                    <x-ui.breadcrumbs.separator />
                    <x-ui.breadcrumbs.link active>{{ __('Convocatòria') }}</x-ui.breadcrumbs.link>
                </x-ui.breadcrumbs>
                
                <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                    @if ($actuacion->oficial == 1)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                            {{ __('Acte Oficial') }}
                        </span>
                    @endif
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-300 border border-blue-500/20">
                        {{ $actuacion->tipoactuacion?->nombre ?? __('Actuació') }}
                    </span>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold font-headline text-white tracking-tight">
                        {{ $actuacion->descripcion }}
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('actuacion.index') }}" 
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold border border-slate-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Tornar al calendari') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Overlay de Carga para cambios AJAX --}}
    <div id="pageLoadingOverlay"
        class="hidden fixed inset-0 z-[100] bg-black/60 backdrop-blur-md flex items-center justify-center px-4"
        aria-live="polite" aria-atomic="true">
        <div class="bg-[#111827] border border-slate-800 rounded-2xl shadow-2xl px-6 py-5 text-center max-w-xs w-full">
            <div class="mx-auto mb-3 h-10 w-10 border-4 border-slate-700 border-t-blue-500 rounded-full animate-spin"></div>
            <p id="pageLoadingMessage" class="text-sm font-semibold text-slate-200">
                {{ __('Actualitzant disponibilitat...') }}
            </p>
        </div>
    </div>

    {{-- Alertas de Disponibilidad y Antelación --}}
    <div class="space-y-4 mb-6">
        @if ($usuarioDisponible && $antelacion->days <= $limiteAntelacion)
            <div class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-4 flex items-center gap-3 text-amber-200 text-sm">
                <svg class="w-5 h-5 flex-shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ __('No es pot canviar la disponibilitat amb pocs dies d\'antelació. Si tens una incidència greu, contacta amb la direcció.') }}</span>
            </div>
        @endif

        @if (!$usuarioDisponible)
            <div class="bg-rose-500/10 border border-rose-500/30 rounded-2xl p-4 flex items-center justify-between gap-3 text-rose-200 text-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-rose-500/20 flex items-center justify-center text-rose-400 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold">{{ __('Has comunicat que NO estàs disponible per a aquesta actuació.') }}</span>
                        <p class="text-xs text-rose-300/80">{{ __('La teua absència està registrada en el còmput de la plantilla.') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Layout Principal Master-Detail: 12 columnas en Desktop, 1 columna en Móvil --}}
    <div class="lg:grid lg:grid-cols-12 lg:gap-8 space-y-6 lg:space-y-0 pb-28">

        {{-- COLUMNA IZQUIERDA (5 columnas): Datos del Evento, Quórum, Mapa y Observaciones --}}
        <div class="lg:col-span-5 space-y-6" id="driver-detalles">
            
            {{-- Tarjeta de Convocatoria y Métricas Clave --}}
            <div class="bg-[#111827] border border-slate-800 rounded-2xl p-5 shadow-xl space-y-5">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        {{ __('Dades de la Convocatòria') }}
                    </span>
                    @if ($actuacion->calendar)
                        <a href="/descargarCalendario/{{ $actuacion->id }}" id="downloadCalendar" data-lista-id="{{ $actuacion->id }}"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-400 hover:text-amber-300 bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ __('Afegir al calendari') }}</span>
                        </a>
                    @endif
                </div>

                {{-- Horario y Ubicación --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-[#0B1120] border border-slate-800/80 rounded-xl p-3.5 flex flex-col justify-between">
                        <span class="text-xs text-slate-400 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ __('Data i Hora') }}
                        </span>
                        <div class="mt-2">
                            <div class="text-sm font-bold text-white">{{ $nombreDia }}</div>
                            <div class="text-xs text-blue-400 font-semibold">{{ $fechaFormateada }} · {{ $horaFormateada }} h</div>
                        </div>
                    </div>

                    <div class="bg-[#0B1120] border border-slate-800/80 rounded-xl p-3.5 flex flex-col justify-between">
                        <span class="text-xs text-slate-400 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ __('Localitat') }}
                        </span>
                        <div class="mt-2">
                            <div class="text-sm font-bold text-white truncate">{{ $actuacion->contrato?->poblacion ?? __('No especificada') }}</div>
                            <div class="text-xs text-slate-400 truncate">{{ $actuacion->contrato?->descripcion ?? '' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Métricas de Quórum en Vivo --}}
                <div class="bg-[#0B1120] border border-slate-800/80 rounded-xl p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-300 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            {{ __('Quòrum de Plantilla') }}
                        </span>
                        <span class="text-xs font-bold text-slate-200">
                            <span id="musics_count" class="text-blue-400 text-sm font-extrabold">{{ $totalFilas }}</span> / {{ $actuacion->musicos > 0 ? $actuacion->musicos : '--' }} {{ __('músics') }}
                        </span>
                    </div>

                    @php
                        $porcentajeQuorum = ($actuacion->musicos > 0 && $totalFilas > 0) ? min(100, round(($totalFilas / $actuacion->musicos) * 100)) : 0;
                    @endphp
                    <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $porcentajeQuorum }}%"></div>
                    </div>

                    <div class="flex items-center justify-between pt-1 border-t border-slate-800/60 text-xs">
                        <span class="text-slate-400 flex items-center gap-1.5">
                            <span>🚗</span>
                            {{ __('Vehicles confirmats:') }}
                        </span>
                        <span class="font-bold text-slate-200">
                            <span id="coches_count" class="text-amber-400">{{ $cochesCount }}</span> / <span id="coches_total">{{ $actuacion->coches > 0 ? $actuacion->coches : '--' }}</span>
                        </span>
                    </div>
                </div>

                {{-- Observaciones de Dirección --}}
                @if ($actuacion->observaciones)
                    <div class="bg-blue-600/5 border border-blue-500/20 rounded-xl p-4">
                        <h4 class="text-xs font-bold text-blue-300 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('Indicacions de la Direcció') }}
                        </h4>
                        <p class="text-xs text-slate-300 whitespace-pre-line leading-relaxed">
                            {{ $actuacion->observaciones }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- Tarjeta de Localización / Mapa --}}
            <div class="bg-[#111827] border border-slate-800 rounded-2xl p-5 shadow-xl space-y-3">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        {{ __('Ubicació i Punt de Trobada') }}
                    </span>
                    <span class="text-xs font-bold text-slate-300">
                        {{ $actuacion->contrato?->poblacion }}
                    </span>
                </div>

                <div class="rounded-xl overflow-hidden border border-slate-800">
                    <input type="hidden" id="latitude" name="latitude" value="{{ $actuacion->contrato?->latitude }}">
                    <input type="hidden" id="longitude" name="longitude" value="{{ $actuacion->contrato?->longitude }}">
                    <input type="hidden" id="poblacion" name="poblacion" value="{{ $actuacion->contrato?->poblacion }}">
                    <input type="hidden" id="descripcion" name="descripcion" value="{{ $actuacion->descripcion }}">
                    <livewire:location-map :height="180" />
                </div>
            </div>

            {{-- Tarjeta de Músicos No Disponibles (Admin) --}}
            @can('admin')
                @if(isset($usuariosNoDisponibles) && $usuariosNoDisponibles->count() > 0)
                    <div class="bg-[#111827] border border-rose-900/30 rounded-2xl p-5 shadow-xl space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                            <h3 class="text-xs font-bold text-rose-400 uppercase tracking-wider flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                {{ __('Músics No Disponibles') }}
                            </h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                                {{ $usuariosNoDisponibles->count() }}
                            </span>
                        </div>

                        <ul class="divide-y divide-slate-800/80 max-h-56 overflow-y-auto pr-1">
                            @foreach($usuariosNoDisponibles as $userNoDisp)
                                <li class="py-2.5 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2.5">
                                        <img src="{{ asset($userNoDisp->profile_photo_url) }}" alt="{{ $userNoDisp->name }}" class="h-7 w-7 rounded-full object-cover border border-slate-700">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-slate-200">{{ $userNoDisp->name }}</span>
                                            <span class="text-[11px] text-slate-400">{{ optional($userNoDisp->instrument)->name ?? __('Sense instrument') }}</span>
                                        </div>
                                    </div>
                                    <span class="text-[11px] font-semibold text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded-md border border-rose-500/20">
                                        {{ __('Baixa') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endcan

        </div>

        {{-- COLUMNA DERECHA (7 columnas): Roster por Cuerdas y Tablón de Comentarios --}}
        <div class="lg:col-span-7 space-y-6">
            
            {{-- Panel de la Plantilla de Músicos / Cuerdas --}}
            <div id="driver-componentes" class="bg-[#111827] border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
                <div class="p-4 lg:p-5 border-b border-slate-800 flex items-center justify-between bg-slate-900/40">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-600/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold font-headline text-white uppercase tracking-wider">
                                {{ __('Plantilla per Cordes') }}
                            </h2>
                            <p class="text-xs text-slate-400">
                                {{ __('Distribució d\'instruments i assignació de transport') }}
                            </p>
                        </div>
                    </div>

                    @livewire('preview-listas', ['id' => $actuacion->id])
                </div>

                {{-- Acordeón / Secciones de Cuerdas --}}
                <div class="divide-y divide-slate-800">
                    @foreach ($usuarios->groupBy('instrument_id') as $instrumento => $usuariosDelInstrumento)
                        @php
                            $nombreInstrumento = $usuariosDelInstrumento->first()->instrument->name ?? __('Sense instrument');
                            $totalInstrumento = $usuariosDelInstrumento->count();
                        @endphp
                        <div class="bg-[#0B1120]/40">
                            {{-- Cabecera de la Cuerda / Instrumento --}}
                            <div class="flex items-center justify-between px-4 py-3 bg-[#111827]/80 border-b border-slate-800/80">
                                <div class="flex items-center gap-2.5">
                                    <img class="w-8 h-8 rounded-lg object-contain bg-slate-900 p-1 border border-slate-700/80"
                                        src="{{ \App\Models\Instrument::resolveIconUrl($usuariosDelInstrumento->first()?->instrument?->icon) }}"
                                        onerror="this.onerror=null;this.src='{{ asset(\App\Models\Instrument::DEFAULT_ICON_PATH) }}';"
                                        alt="{{ $nombreInstrumento }}">
                                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                                        {{ $nombreInstrumento }}
                                    </h3>
                                    <span class="text-[11px] font-semibold text-slate-400 bg-slate-800 px-2 py-0.5 rounded-full border border-slate-700">
                                        {{ $totalInstrumento }}
                                    </span>
                                </div>

                                @can('admin')
                                    <button type="button" id="f_{{ $nombreInstrumento }}"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs font-semibold transition"
                                        onclick="mostrarForasters(this)"
                                        data-instrument-name="{{ $nombreInstrumento }}"
                                        title="{{ __('Mostrar/Ocultar reforços') }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>{{ __('Reforços') }}</span>
                                    </button>
                                @endcan
                            </div>

                            {{-- Lista de Músicos del Instrumento --}}
                            <ul class="divide-y divide-slate-800/60">
                                @foreach ($usuariosDelInstrumento->sortBy('name')->sortBy('forastero') as $user)
                                    @cannot('admin')
                                        @if ($user->forastero)
                                            @continue
                                        @endif
                                    @endcannot

                                    @php
                                        $esUsuarioActual = Auth::check() && (Auth::user()->id == $user->id || Auth::user()->hijos->contains($user->id));
                                    @endphp

                                    <li class="@if ($user->forastero) forastero {{ $user->instrument->name }} @endif px-4 py-3 flex items-center justify-between transition-colors {{ $esUsuarioActual ? 'bg-amber-500/10 border-l-4 border-amber-400' : 'hover:bg-slate-900/50' }}"
                                        @if ($user->forastero) style="display: none;" @endif>

                                        {{-- Info del Músico --}}
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <img src="{{ asset($user->profile_photo_url) }}" alt="{{ $user->name }}"
                                                    class="h-9 w-9 rounded-full object-cover border {{ $esUsuarioActual ? 'border-amber-400' : 'border-slate-700' }}">
                                                @if (!$user->disponible)
                                                    <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-rose-600 border-2 border-[#111827] flex items-center justify-center text-white text-[9px] font-bold" title="{{ __('No disponible') }}">✕</span>
                                                @endif
                                            </div>

                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs font-bold {{ $esUsuarioActual ? 'text-amber-300' : 'text-slate-100' }}">
                                                        {{ $user->name }}
                                                    </span>
                                                    @if ($user->forastero)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                                            {{ __('common.llogat') }}
                                                        </span>
                                                    @endif
                                                    @if ($esUsuarioActual)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-blue-500/20 text-blue-300">
                                                            {{ __('Tu') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-[11px] text-slate-400 flex items-center gap-2 mt-0.5">
                                                    @if ($user->coche)
                                                        <span class="inline-flex items-center gap-1 text-emerald-400">
                                                            <span>🚗</span> {{ __('Cotxe') }}
                                                        </span>
                                                    @endif
                                                    @if ($user->furgona)
                                                        <span class="inline-flex items-center gap-1 text-blue-400">
                                                            <span>🚐</span> {{ __('Furgona') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Controles y Badges de Selección / Coche --}}
                                        <div class="flex items-center gap-3">
                                            @cannot('admin')
                                                <div class="flex items-center gap-2">
                                                    @if ($user->seleccionado)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                                            ✓ {{ __('Convocat') }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">
                                                            {{ __('Reserva') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endcannot

                                            @can('admin')
                                                <div class="flex items-center gap-3">
                                                    {{-- Toggle Furgona --}}
                                                    @if ($user->tienefurgo)
                                                        <label class="flex items-center gap-1.5 cursor-pointer text-xs text-slate-300">
                                                            <input type="checkbox"
                                                                data-lista-id="{{ $lista->id }}"
                                                                data-usuario-id="{{ $user->id }}" 
                                                                data-furgo="1"
                                                                onclick="setCoche(this)"
                                                                class="rounded bg-slate-800 border-slate-700 text-blue-600 focus:ring-0 focus:ring-offset-0 h-4 w-4"
                                                                {{ $user->furgona ? 'checked' : '' }} />
                                                            <span class="text-[11px] text-slate-400">🚐</span>
                                                        </label>
                                                    @endif

                                                    {{-- Toggle Coche --}}
                                                    @if ($user->tienecoche)
                                                        <label class="flex items-center gap-1.5 cursor-pointer text-xs text-slate-300">
                                                            <input type="checkbox"
                                                                data-lista-id="{{ $lista->id }}"
                                                                data-usuario-id="{{ $user->id }}"
                                                                onclick="setCoche(this)"
                                                                class="rounded bg-slate-800 border-slate-700 text-amber-500 focus:ring-0 focus:ring-offset-0 h-4 w-4"
                                                                {{ $user->coche ? 'checked' : '' }} />
                                                            <span class="text-[11px] text-slate-400">🚗</span>
                                                        </label>
                                                    @endif

                                                    {{-- Checkbox Selección de Plantilla --}}
                                                    <input type="checkbox" data-lista-id="{{ $lista->id }}"
                                                        data-usuario-id="{{ $user->id }}"
                                                        data-usuario-percent="{{ $user->porcentaje }}"
                                                        class="js-selection-checkbox rounded bg-slate-800 border-slate-700 text-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-[#111827] h-5 w-5 transition cursor-pointer"
                                                        {{ $user->seleccionado ? 'checked' : '' }} 
                                                        title="{{ __('Convocar músic') }}" />
                                                </div>
                                            @endcan
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Sección de Comentarios y Chat del Ensayo/Actuación --}}
            @if (ConfigHelper::getConfigValue('enableusermessages') === 'true')
                <div class="bg-[#111827] border border-slate-800 rounded-2xl shadow-xl overflow-hidden" id="messages-section">
                    <div class="p-4 border-b border-slate-800 flex items-center justify-between bg-slate-900/40">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-blue-600/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <h3 class="text-xs font-bold font-headline text-white uppercase tracking-wider">
                                {{ __('common.comentariosactuacion') }}
                            </h3>
                        </div>
                        <span class="text-xs text-slate-400">
                            {{ $actuacion->comments->count() }} {{ __('missatges') }}
                        </span>
                    </div>

                    {{-- Contenedor de Mensajes --}}
                    <div id="messages" class="p-4 max-h-80 overflow-y-auto space-y-3 bg-[#0B1120]/60">
                        <div id="commentsContainer" class="space-y-3">
                            @forelse ($actuacion->comments as $comment)
                                @if ($comment->eliminado || $comment->inadecuado)
                                    @continue
                                @endif
                                @php
                                    $esPropio = auth()->id() === $comment->user_id;
                                @endphp
                                <div class="chat-message flex {{ $esPropio ? 'justify-end' : 'justify-start' }} items-end gap-2">
                                    @if (!$esPropio)
                                        <img src="{{ $comment->user->profile_photo_url ?? asset('/imagenes/no-icon.png') }}"
                                            alt="{{ $comment->user->name }}" class="w-6 h-6 rounded-full object-cover border border-slate-700 mb-1">
                                    @endif

                                    <div class="flex flex-col space-y-1 text-xs max-w-sm {{ $esPropio ? 'items-end' : 'items-start' }}">
                                        <div class="px-3.5 py-2 rounded-2xl {{ $esPropio ? 'bg-blue-600 text-white rounded-br-none' : 'bg-slate-800 text-slate-200 border border-slate-700/80 rounded-bl-none' }}">
                                            @if(!$esPropio)
                                                <div class="text-[11px] font-bold text-amber-300 mb-0.5">
                                                    {{ $comment->user->name ?? __('Músic') }}
                                                </div>
                                            @endif
                                            <p class="leading-relaxed text-xs">{{ $comment->comment }}</p>
                                        </div>
                                        <span class="text-[10px] text-slate-500 px-1">
                                            {{ $comment->created_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>

                                    @if ($esPropio)
                                        <img src="{{ auth()->user()->profile_photo_path ?? asset('/imagenes/no-icon.png') }}"
                                            alt="Tu" class="w-6 h-6 rounded-full object-cover border border-blue-500 mb-1">
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-6 text-slate-500 text-xs">
                                    {{ __('No hi ha comentaris encara. Comparteix qualsevol dubte sobre l\'actuació.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Formulario para Enviar Comentarios --}}
                    <div class="p-3 bg-[#111827] border-t border-slate-800">
                        <div class="relative flex items-center">
                            <input type="text" id="commentInput" maxlength="200" minlength="5"
                                placeholder="{{ __('Escriu el teu comentari...') }}"
                                class="w-full bg-[#0B1120] border border-slate-700 text-slate-200 text-xs rounded-xl pl-3 pr-12 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                oninput="updateCharacterCount()">
                            <button id="sendComment" type="button"
                                class="absolute right-1.5 p-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white transition disabled:opacity-50">
                                <svg class="w-4 h-4 transform rotate-90" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center justify-between mt-1.5 px-1 text-[11px] text-slate-500">
                            <span>{{ __('Sé respectuós amb els companys de la banda.') }}</span>
                            <span id="charCount">0 / 200 caràcters</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </div>

    {{-- BOTONERA FIJA INFERIOR (Dark Command Bar) --}}
    <div id="driver-botonera"></div>
    <footer class="fixed bottom-0 left-0 right-0 z-30 bg-[#0B1120]/95 backdrop-blur-xl border-t border-slate-800 py-3 px-4 shadow-2xl">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
            
            {{-- Botón Volver --}}
            <a href="{{ route('actuacion.index') }}"
                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold border border-slate-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="hidden sm:inline">{{ __('Tornar') }}</span>
            </a>

            {{-- Conmutador de Asistencia Táctil Principal --}}
            <div class="flex-1 max-w-md">
                @if ($usuarioDisponible)
                    <button id="btnodisponible" type="button"
                        data-lista-id="{{ $lista->id }}"
                        data-usuario-id="{{ Auth::user()->id }}" 
                        data-disponible="0"
                        data-usuario-seleccionado="{{ $usuarioSeleccionado ? 1 : 0 }}"
                        data-antelacion="{{ $antelacion->days }}" 
                        onclick="gestionarDisponibilidad(event,this)"
                        data-limite-antelacion="{{ $limiteAntelacion }}"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs sm:text-sm font-bold shadow-lg shadow-rose-900/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>{{ __('No puc assistir (Comunica Baixa)') }}</span>
                    </button>
                @else
                    <button id="btnodisponible" type="button"
                        data-lista-id="{{ $lista->id }}"
                        data-usuario-id="{{ Auth::user()->id }}" 
                        data-disponible="1"
                        data-usuario-seleccionado="{{ $usuarioSeleccionado ? 1 : 0 }}"
                        data-antelacion="{{ $antelacion->days }}" 
                        onclick="gestionarDisponibilidad(event,this)"
                        data-limite-antelacion="{{ $limiteAntelacion }}"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs sm:text-sm font-bold shadow-lg shadow-emerald-900/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ __('Ara sí puc assistir (Confirmar)') }}</span>
                    </button>
                @endif
            </div>

            {{-- Acciones de Administración --}}
            @can('admin')
                <div class="flex items-center gap-2">
                    @if (Carbon\Carbon::parse($actuacion->fechaActuacion)->isToday() || Carbon\Carbon::parse($actuacion->fechaActuacion)->isFuture())
                        {{-- Botón Vaciar Lista --}}
                        <button id="cleanListaButton" type="button" data-lista-id="{{ $lista->id }}"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-800 hover:bg-rose-900/40 text-slate-300 hover:text-rose-300 text-xs font-semibold border border-slate-700 transition"
                            title="{{ __('Buidar convocatòria') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span class="hidden md:inline">{{ __('Buidar') }}</span>
                        </button>

                        {{-- Botón Avisar Seleccionados --}}
                        <button id="avisarMarcados" type="button" data-lista-id="{{ $lista->id }}"
                            onclick="enviarNotif({{ $lista->id }},'{{ json_encode($actuacion->descripcion) }}')"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow-md transition"
                            title="{{ __('Notificar a la plantilla convocada') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="hidden md:inline">{{ __('Avisar convocats') }}</span>
                        </button>
                    @endif
                </div>
            @endcan

        </div>
    </footer>

    {{-- SCRIPTS DE COMPORTAMIENTO --}}
    <script>
        let availabilityUpdateInProgress = false;

        function setPageLoadingState(isLoading, message = 'Actualitzant disponibilitat...') {
            const overlay = document.getElementById('pageLoadingOverlay');
            const messageElement = document.getElementById('pageLoadingMessage');

            if (!overlay) return;

            if (messageElement) {
                messageElement.textContent = message;
            }

            if (isLoading) {
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function actualizarSeleccion(checkbox) {
            var listaId = checkbox.getAttribute('data-lista-id');
            var usuarioId = checkbox.getAttribute('data-usuario-id');

            if (checkbox.checked) {
                $.ajax({
                    url: '/listauser',
                    method: 'POST',
                    data: {
                        lista_id: listaId,
                        usuario_id: usuarioId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        updateContadores(response.total_filas, response.coches_count);
                    },
                    error: function(xhr, status, error) {
                        checkbox.checked = false;
                    }
                });
            } else {
                $.ajax({
                    url: '/listauser/' + listaId + '/' + usuarioId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        updateContadores(response.total_filas, response.coches_count);
                    },
                    error: function(xhr, status, error) {
                        checkbox.checked = true;
                    }
                });
            }
        }

        document.addEventListener('change', function(event) {
            const selectionCheckbox = event.target.closest('.js-selection-checkbox');
            if (selectionCheckbox) {
                actualizarSeleccion(selectionCheckbox);
            }
        });

        function setCoche(componente) {
            var listaId = componente.getAttribute('data-lista-id');
            var usuarioId = componente.getAttribute('data-usuario-id');
            var furgo = componente.getAttribute('data-furgo');

            $.ajax({
                url: '/listausercar',
                method: 'POST',
                data: {
                    lista_id: listaId,
                    usuario_id: usuarioId,
                    estado: componente.checked ? 1 : 0,
                    furgo: furgo,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    updateContadores(response.total_filas, response.coches_count);
                },
                error: function(xhr, status, error) {
                    componente.checked = !componente.checked;
                }
            });
        }

        function updateContadores(musics, cotxes) {
            if ($('#musics_count').length) $('#musics_count').text(musics);
            if ($('#coches_count').length) $('#coches_count').text(cotxes);
        }

        function enviarNotif(idActua, detalle) {
            if (confirm('Segur que vols notificar als usuaris convocats d\'aquesta actuació?')) {
                $.ajax({
                    url: '/notificaractuacionlista',
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
                            alert('Error enviant notificació');
                        }
                    }
                });
            }
        }

        function gestionarDisponibilidad(event, componente) {
            event.preventDefault();

            if (availabilityUpdateInProgress) return;

            availabilityUpdateInProgress = true;
            setPageLoadingState(true);

            componente.disabled = true;

            var listaId = componente.getAttribute('data-lista-id');
            var usuarioId = componente.getAttribute('data-usuario-id');
            var disponible = componente.getAttribute('data-disponible');
            var usuarioSeleccionado = parseInt(componente.getAttribute('data-usuario-seleccionado') ?? 0);
            var antelacion = parseInt(componente.getAttribute('data-antelacion'));
            var limiteAntelacion = parseInt(componente.getAttribute('data-limite-antelacion') ?? 3);

            if (disponible == 0 && usuarioSeleccionado === 1) {
                alert('Si ja estàs a la llista de convocats no pots marcar que no estàs disponible. Contacta amb la direcció.');
                availabilityUpdateInProgress = false;
                setPageLoadingState(false);
                componente.disabled = false;
                return;
            }

            if (disponible == 0 && antelacion <= limiteAntelacion) {
                alert('No es pot canviar la disponibilitat amb tan pocs dies d\'antelació.');
                availabilityUpdateInProgress = false;
                setPageLoadingState(false);
                componente.disabled = false;
                return;
            }

            $.ajax({
                url: '/listauserdisp',
                method: 'POST',
                data: {
                    lista_id: listaId,
                    usuario_id: usuarioId,
                    disponible: disponible == 1 ? 1 : 0,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (typeof showToast === 'function') {
                        showToast(response);
                    }
                    location.reload();
                },
                error: function(xhr, status, error) {
                    let message = xhr.responseJSON?.message || 'Error al comunicar disponibilitat.';
                    if (typeof showToast === 'function') {
                        showToast(message);
                    } else {
                        alert(message);
                    }
                    availabilityUpdateInProgress = false;
                    setPageLoadingState(false);
                    componente.disabled = false;
                }
            });
        }

        @can('admin')
            var cleanListaButton = document.getElementById('cleanListaButton');
            if (cleanListaButton) {
                cleanListaButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    var listaId = cleanListaButton.getAttribute('data-lista-id');

                    if (confirm("Segur que vols buidar tota la convocatòria d'aquesta llista?")) {
                        fetch(`/listauserclean/${listaId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Error al buidar la llista');
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al buidar la llista');
                        });
                    }
                });
            }
        @endcan

        function mostrarForasters(button) {
            const instrumentName = button.getAttribute('data-instrument-name');
            const elementsToShowHide = document.querySelectorAll(`.forastero.${instrumentName}`);
            elementsToShowHide.forEach(element => {
                if (element.style.display === 'none') {
                    element.style.display = 'flex';
                } else {
                    element.style.display = 'none';
                }
            });
        }

        @if (ConfigHelper::getConfigValue('enableusermessages') === 'true')
            const messagesContainer = document.getElementById('messages');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            const sendCommentBtn = document.getElementById('sendComment');
            if (sendCommentBtn) {
                sendCommentBtn.addEventListener('click', function() {
                    let input = document.getElementById('commentInput');
                    let commentText = input.value.trim();

                    if (commentText.length === 0) {
                        alert("{{ __('El comentari no pot estar buit.') }}");
                        return;
                    }

                    if (commentText.length < 5) {
                        alert("{{ __('El comentari ha de tindre almenys 5 caràcters.') }}");
                        return;
                    }

                    if (commentText.length > 200) {
                        alert("{{ __('Màxim 200 caràcters.') }}");
                        return;
                    }

                    this.disabled = true;

                    fetch("{{ route('comments.add') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            comment: commentText,
                            actuacion_id: {{ $actuacion->id }}
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let commentHTML = `
                                <div class="chat-message flex justify-end items-end gap-2">
                                    <div class="flex flex-col space-y-1 text-xs max-w-sm items-end">
                                        <div class="px-3.5 py-2 rounded-2xl bg-blue-600 text-white rounded-br-none">
                                            <p class="leading-relaxed text-xs">${data.comment}</p>
                                        </div>
                                        <span class="text-[10px] text-slate-500 px-1">${data.created_at}</span>
                                    </div>
                                    <img src="{{ auth()->user()->profile_photo_path ?? asset('/imagenes/no-icon.png') }}" 
                                        alt="Tu" class="w-6 h-6 rounded-full object-cover border border-blue-500 mb-1">
                                </div>
                            `;

                            document.getElementById('commentsContainer').innerHTML += commentHTML;
                            input.value = '';
                            updateCharacterCount();

                            let messagesDiv = document.getElementById('messages');
                            if (messagesDiv) {
                                messagesDiv.scrollTop = messagesDiv.scrollHeight;
                            }
                        } else {
                            alert("{{ __('Error enviant el comentari.') }}");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Problema processant el comentari.");
                    })
                    .finally(() => this.disabled = false);
                });
            }

            function updateCharacterCount() {
                let input = document.getElementById('commentInput');
                let counter = document.getElementById('charCount');
                if (!input || !counter) return;
                let maxLength = input.maxLength;
                counter.textContent = `${input.value.length} / ${maxLength} caràcters`;
            }
        @endif

        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('poblacion');
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const descripcion = document.getElementById('descripcion');

            if (latInput && lngInput && latInput.value && lngInput.value) {
                if (window.MapComponent) {
                    window.MapComponent.setMunicipios([{
                        nombre: input ? input.value : '',
                        coords: [parseFloat(latInput.value), parseFloat(lngInput.value)],
                        texto: descripcion ? descripcion.value : ''
                    }]);
                }
            }

            @php
                $driverSteps = [
                    ['element' => '#driver-detalles', 'popover' => ['title' => __('Detalls'), 'description' => __('Data, horari, mapa i quòrum de convocatòria.'), 'position' => 'bottom']],
                    ['element' => '#driver-componentes', 'popover' => ['title' => __('Plantilla'), 'description' => __('Músics convocats per corda i assignació de transport.'), 'position' => 'top']],
                    ['element' => '#driver-botonera', 'popover' => ['title' => __('Disponibilitat'), 'description' => __('Comunica si pots o no pots assistir a aquesta actuació.'), 'position' => 'top']]
                ];
            @endphp

            const STORAGE_KEY = 'eband_driver_tour_shown_detail_actuaciones_v1';
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

            tryStart();
        });
    </script>
</x-app-layout>
