@php
    use App\Helpers\ConfigHelper;
    $fechaActuacion = Carbon\Carbon::parse($actuacion->fechaActuacion);
    $nombreDia = ucfirst($fechaActuacion->translatedFormat('l'));
    $fechaFormateada = $fechaActuacion->format('d/m/Y');
    $horaFormateada = $fechaActuacion->format('H:i');
    $limiteAntelacion = (int) (ConfigHelper::getConfigValue('diasantelacion') ?? 5);

    $currentUser = auth()->user();
    $diasRestantes = (int) now()->startOfDay()->diffInDays($fechaActuacion->startOfDay(), false);
    $fueraDePlazo = ($diasRestantes <= $limiteAntelacion) && !$currentUser?->can('admin');

    $currentUserRel = $lista ? $lista->users()->where('users.id', $currentUser?->id)->first() : null;
    $usuarioConvocado = false;
    $userDispState = 'vacio';

    if ($currentUserRel) {
        $pivot = $currentUserRel->pivot;
        if ((int) $pivot->disponible === 0) {
            $userDispState = 'no';
        } elseif (!empty($pivot->duda)) {
            $userDispState = 'duda';
        } elseif ((int) $pivot->disponible === 1) {
            $usuarioConvocado = true;
            $userDispState = 'convocado';
        }
    }

    // Métricas del quórum de plantilla
    $dudasCount = $lista ? \App\Models\ListasUser::where('listas_id', $lista->id)->where('duda', 1)->count() : 0;
    $noDisponiblesCount = $lista ? \App\Models\ListasUser::where('listas_id', $lista->id)->where('disponible', 0)->count() : 0;
    $convocadosCount = $lista ? \App\Models\ListasUser::where('listas_id', $lista->id)->where('disponible', 1)->where(function($q) { $q->whereNull('duda')->orWhere('duda', 0); })->count() : 0;
    $baseMusicos = $actuacion->musicos > 0 ? $actuacion->musicos : max(1, $convocadosCount + $dudasCount + $noDisponiblesCount);
    $porcentajeConvocados = min(100, round(($convocadosCount / $baseMusicos) * 100));
    $porcentajeDudas = min(100 - $porcentajeConvocados, round(($dudasCount / $baseMusicos) * 100));
    $porcentajeNoDisp = min(100 - $porcentajeConvocados - $porcentajeDudas, round(($noDisponiblesCount / $baseMusicos) * 100));
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
                
                <div class="flex items-center gap-2.5 mt-1.5 flex-wrap">
                    @if ($actuacion->oficial == 1)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-xl text-xs font-bold bg-status-unavailable text-white shadow-sm">
                            <span class="material-symbols-outlined text-[13px]">priority_high</span>
                            {{ __('Acte Oficial') }}
                        </span>
                    @endif
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-xl text-xs font-bold bg-indigo-50 text-primary border border-indigo-100">
                        {{ $actuacion->tipoactuacion?->nombre ?? __('Actuació') }}
                    </span>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold font-headline text-on-surface tracking-tight">
                        {{ $actuacion->descripcion }}
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                @can('admin')
                    @if (Carbon\Carbon::parse($actuacion->fechaActuacion)->isToday() || Carbon\Carbon::parse($actuacion->fechaActuacion)->isFuture())
                        <button id="cleanListaButton" type="button" data-lista-id="{{ $lista->id }}"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-2xl bg-white hover:bg-rose-50 text-slate-700 hover:text-rose-600 text-xs font-bold border border-slate-200 shadow-sm transition active:scale-95"
                            title="{{ __('Buidar convocatòria') }}">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                            <span class="hidden sm:inline">{{ __('Buidar') }}</span>
                        </button>

                        <button id="avisarMarcados" type="button" data-lista-id="{{ $lista->id }}"
                            onclick="enviarNotif({{ $lista->id }},'{{ json_encode($actuacion->descripcion) }}')"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-primary hover:bg-primary-dark text-white text-xs font-bold shadow-sm transition active:scale-95"
                            title="{{ __('Notificar a la plantilla convocada') }}">
                            <span class="material-symbols-outlined text-[16px]">campaign</span>
                            <span class="hidden sm:inline">{{ __('Avisar') }}</span>
                        </button>
                    @endif
                @endcan

                <a href="{{ route('actuacion.index') }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold border border-slate-200 shadow-sm transition">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>{{ __('Tornar al calendari') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Overlay de Carga para cambios AJAX --}}
    <div id="pageLoadingOverlay"
        class="hidden fixed inset-0 z-[100] bg-black/40 backdrop-blur-sm flex items-center justify-center px-4"
        aria-live="polite" aria-atomic="true">
        <div class="bg-white rounded-3xl shadow-2xl px-6 py-5 text-center max-w-xs w-full border border-indigo-50">
            <div class="mx-auto mb-3 h-10 w-10 border-4 border-indigo-100 border-t-primary rounded-full animate-spin"></div>
            <p id="pageLoadingMessage" class="text-xs font-bold text-slate-700">
                {{ __('Actualitzant disponibilitat...') }}
            </p>
        </div>
    </div>

    {{-- Layout Principal Master-Detail: 12 columnas en Desktop, 1 columna en Móvil --}}
    <div class="lg:grid lg:grid-cols-12 lg:gap-8 space-y-6 lg:space-y-0 pb-24 lg:pb-12">

        {{-- COLUMNA IZQUIERDA (5 columnas): Datos del Evento, Quórum, Mapa y Observaciones --}}
        <div class="lg:col-span-5 space-y-6" id="driver-detalles">
            
            {{-- Tarjeta de Convocatoria y Métricas Clave --}}
            <div class="bg-white border border-indigo-50 shadow-bento rounded-3xl p-5 space-y-5">
                <div class="flex items-center justify-between border-b border-indigo-50 pb-3.5">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        {{ __('Dades de la Convocatòria') }}
                    </span>
                    @if ($actuacion->calendar)
                        <a href="/descargarCalendario/{{ $actuacion->id }}" id="downloadCalendar" data-lista-id="{{ $actuacion->id }}"
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-primary hover:text-primary-dark bg-indigo-50 px-3 py-1.5 rounded-xl transition">
                            <span class="material-symbols-outlined text-[16px]">calendar_add_on</span>
                            <span>{{ __('Afegir al calendari') }}</span>
                        </a>
                    @endif
                </div>

                {{-- Horario y Ubicación --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-surface-subtle border border-indigo-50/60 rounded-2xl p-3.5 flex flex-col justify-between">
                        <span class="text-xs text-slate-500 font-semibold flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-primary text-[17px]">schedule</span>
                            {{ __('Data i Hora') }}
                        </span>
                        <div class="mt-2">
                            <div class="text-sm font-bold text-on-surface">{{ $nombreDia }}</div>
                            <div class="text-xs text-primary font-bold">{{ $fechaFormateada }} · {{ $horaFormateada }} h</div>
                        </div>
                    </div>

                    <div class="bg-surface-subtle border border-indigo-50/60 rounded-2xl p-3.5 flex flex-col justify-between">
                        <span class="text-xs text-slate-500 font-semibold flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-cyan-600 text-[17px]">location_on</span>
                            {{ __('Localitat') }}
                        </span>
                        <div class="mt-2">
                            <div class="text-sm font-bold text-on-surface truncate">{{ $actuacion->contrato?->poblacion ?? __('No especificada') }}</div>
                            <div class="text-xs text-slate-500 truncate">{{ $actuacion->contrato?->descripcion ?? '' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Métricas de Quórum en Vivo --}}
                <div class="bg-surface-subtle border border-indigo-50/60 rounded-2xl p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-600 flex items-center gap-2">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px]">verified</span>
                            {{ __('Quòrum de Plantilla') }}
                        </span>
                        <span class="text-xs font-extrabold text-on-surface">
                            <span id="musics_count" class="text-primary text-sm font-black">{{ $convocadosCount }}</span> / {{ $actuacion->musicos > 0 ? $actuacion->musicos : '--' }} {{ __('músics') }}
                        </span>
                    </div>

                    {{-- Desglose Convocats, Té dubtes, No disponible --}}
                    <div class="flex items-center gap-2 text-[11px] font-bold text-slate-500 flex-wrap">
                        <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            {{ __('Convocats') }} ({{ $convocadosCount }})
                        </span>
                        <span class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                            {{ __('Té dubtes') }} ({{ $dudasCount }})
                        </span>
                        <span class="inline-flex items-center gap-1 text-rose-700 bg-rose-50 px-2 py-0.5 rounded-lg border border-rose-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            {{ __('No disponible') }} ({{ $noDisponiblesCount }})
                        </span>
                    </div>

                    {{-- Barra visual tricolor --}}
                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden flex">
                        <div class="bg-emerald-500 h-full transition-all duration-500" style="width: {{ $porcentajeConvocados }}%" title="{{ __('Convocats') }}: {{ $convocadosCount }}"></div>
                        <div class="bg-amber-400 h-full transition-all duration-500" style="width: {{ $porcentajeDudas }}%" title="{{ __('Té dubtes') }}: {{ $dudasCount }}"></div>
                        <div class="bg-rose-500 h-full transition-all duration-500" style="width: {{ $porcentajeNoDisp }}%" title="{{ __('No disponible') }}: {{ $noDisponiblesCount }}"></div>
                    </div>

                    <div class="flex items-center justify-between pt-1 border-t border-indigo-50 text-xs">
                        <span class="text-slate-500 flex items-center gap-1.5 font-semibold">
                            <span>🚗</span>
                            {{ __('Vehicles confirmats:') }}
                        </span>
                        <span class="font-extrabold text-on-surface">
                            <span id="coches_count" class="text-amber-600">{{ $cochesCount }}</span> / <span id="coches_total">{{ $actuacion->coches > 0 ? $actuacion->coches : '--' }}</span>
                        </span>
                    </div>
                </div>

                {{-- Observaciones de Dirección --}}
                @if ($actuacion->observaciones)
                    <div class="bg-indigo-50/60 border border-indigo-100 rounded-2xl p-4">
                        <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-1 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">info</span>
                            {{ __('Indicacions de la Direcció') }}
                        </h4>
                        <p class="text-xs text-slate-700 whitespace-pre-line leading-relaxed">
                            {{ $actuacion->observaciones }}
                        </p>
                    </div>
                @endif

                {{-- Disponibilidad del Músico (Dudas y No disponible) --}}
                @auth
                    <div class="pt-3 border-t border-indigo-50 space-y-2.5" id="driver-botonera">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-600 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-primary text-[17px]">how_to_reg</span>
                                {{ __('La teua disponibilitat') }}
                            </span>
                            @if ($userDispState === 'duda')
                                <span class="px-2 py-0.5 rounded-lg text-[10.5px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    {{ __('Dubte comunicat') }}
                                </span>
                            @elseif ($userDispState === 'no')
                                <span class="px-2 py-0.5 rounded-lg text-[10.5px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                    {{ __('Baixa comunicada') }}
                                </span>
                            @elseif ($usuarioConvocado)
                                <span class="px-2 py-0.5 rounded-lg text-[10.5px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    {{ __('Convocat') }}
                                </span>
                            @endif
                        </div>

                        @if ($usuarioConvocado)
                            {{-- Músico CONVOCADO por la dirección: NO puede indicar que no asiste ni dudas --}}
                            <div class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold shadow-xs">
                                <span class="material-symbols-outlined text-[20px] text-status-available shrink-0">verified</span>
                                <div class="flex flex-col">
                                    <span class="text-xs">{{ __('Estàs convocat') }}</span>
                                    <span class="text-[10.5px] font-medium text-emerald-700">{{ __('Assistència confirmada per la direcció. No pots marcar baixa ni dubte.') }}</span>
                                </div>
                            </div>
                        @elseif ($fueraDePlazo)
                            {{-- Fuera de plazo por antelación --}}
                            <div class="px-3.5 py-2.5 rounded-2xl bg-amber-50/90 border border-amber-200 text-amber-900 text-xs flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-amber-600 text-[20px] shrink-0">lock_clock</span>
                                <div class="flex flex-col">
                                    <span class="font-bold text-xs">{{ __('Termini de canvi tancat') }}</span>
                                    <span class="text-[10.5px] text-amber-800">{{ __('Menys de :dias dies d\'antelació. Contacta amb direcció.', ['dias' => $limiteAntelacion]) }}</span>
                                </div>
                            </div>
                        @else
                            {{-- Botones interactivos de Duda y No asistencia --}}
                            <div class="grid grid-cols-2 gap-2.5 bg-surface-subtle p-2 rounded-2xl border border-indigo-50/80">
                                <button type="button" 
                                    id="btn-detalles-duda" 
                                    onclick="setDetallesAttendance('duda', {{ $lista->id }}, {{ auth()->id() }}, {{ $actuacion->id }})"
                                    class="flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl text-xs font-bold transition-all active:scale-95 {{ $userDispState === 'duda' ? 'bg-status-pending text-white shadow-sm ring-2 ring-amber-300/40' : 'bg-white hover:bg-amber-50/50 text-slate-700 border border-slate-200 hover:border-amber-300' }}"
                                    title="{{ __('Notifica que no saps segur si podràs assistir') }}">
                                    <span class="material-symbols-outlined text-[17px]">help</span>
                                    <span>{{ __('Tinc dubtes') }}</span>
                                </button>

                                <button type="button" 
                                    id="btn-detalles-no" 
                                    onclick="setDetallesAttendance('no', {{ $lista->id }}, {{ auth()->id() }}, {{ $actuacion->id }})"
                                    class="flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl text-xs font-bold transition-all active:scale-95 {{ $userDispState === 'no' ? 'bg-status-unavailable text-white shadow-sm ring-2 ring-rose-300/40' : 'bg-white hover:bg-rose-50/50 text-slate-700 border border-slate-200 hover:border-rose-300' }}"
                                    title="{{ __('Comunica la teua baixa') }}">
                                    <span class="material-symbols-outlined text-[17px]">cancel</span>
                                    <span>{{ __('No puc assistir') }}</span>
                                </button>
                            </div>

                            @if ($userDispState === 'duda')
                                <p class="text-[11px] text-amber-700 leading-tight">
                                    {{ __('Has marcat que tens dubtes. Pots tornar a prémer el botó per a anul·lar-ho i restablir la disponibilitat.') }}
                                </p>
                            @elseif ($userDispState === 'no')
                                <p class="text-[11px] text-rose-700 leading-tight">
                                    {{ __('Has marcat que no pots assistir. Pots tornar a prémer el botó per a anul·lar la baixa i restablir la disponibilitat.') }}
                                </p>
                            @endif
                        @endif
                    </div>
                @endauth
            </div>

            {{-- Tarjeta de Localización / Mapa --}}
            <div class="bg-white border border-indigo-50 shadow-bento rounded-3xl p-5 space-y-3">
                <div class="flex items-center justify-between border-b border-indigo-50 pb-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">map</span>
                        {{ __('Ubicació i Punt de Trobada') }}
                    </span>
                    <span class="text-xs font-extrabold text-primary">
                        {{ $actuacion->contrato?->poblacion }}
                    </span>
                </div>

                <div class="rounded-2xl overflow-hidden border border-slate-200">
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
                    <div class="bg-white border border-rose-100 shadow-bento rounded-3xl p-5 space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h3 class="text-xs font-bold text-rose-600 uppercase tracking-wider flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                {{ __('Músics No Disponibles') }}
                            </h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                {{ $usuariosNoDisponibles->count() }}
                            </span>
                        </div>

                        <ul class="divide-y divide-slate-100 max-h-56 overflow-y-auto pr-1">
                            @foreach($usuariosNoDisponibles as $userNoDisp)
                                <li class="py-2 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2.5">
                                        <img src="{{ asset($userNoDisp->profile_photo_url) }}" alt="{{ $userNoDisp->name }}" class="h-7 w-7 rounded-full object-cover border border-slate-200">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800">{{ $userNoDisp->name }}</span>
                                            <span class="text-[11px] text-slate-400">{{ optional($userNoDisp->instrument)->name ?? __('Sense instrument') }}</span>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-lg border border-rose-100">
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
            <div id="driver-componentes" class="bg-white border border-indigo-50 shadow-bento rounded-3xl overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-indigo-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-surface-subtle">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[20px]">groups</span>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-xs font-bold font-headline text-on-surface uppercase tracking-wider truncate">
                                {{ __('Plantilla per Cordes') }}
                            </h2>
                            <p class="text-xs text-slate-500 truncate">
                                {{ __('Distribució d\'instruments i assignació de transport') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                        @livewire('preview-listas', ['id' => $actuacion->id])
                    </div>
                </div>

                {{-- Acordeón / Secciones de Cuerdas --}}
                <div class="divide-y divide-slate-100">
                    @foreach ($usuarios->groupBy('instrument_id') as $instrumento => $usuariosDelInstrumento)
                        @php
                            $nombreInstrumento = $usuariosDelInstrumento->first()->instrument->name ?? __('Sense instrument');
                            $totalInstrumento = $usuariosDelInstrumento->count();
                        @endphp
                        <div>
                            {{-- Cabecera de la Cuerda / Instrumento --}}
                            <div class="flex items-center justify-between px-4 py-3 bg-slate-50/70 border-b border-slate-100">
                                <div class="flex items-center gap-2.5">
                                    <img class="w-8 h-8 rounded-xl object-contain bg-white p-1 border border-slate-200 shadow-sm"
                                        src="{{ \App\Models\Instrument::resolveIconUrl($usuariosDelInstrumento->first()?->instrument?->icon) }}"
                                        onerror="this.onerror=null;this.src='{{ asset(\App\Models\Instrument::DEFAULT_ICON_PATH) }}';"
                                        alt="{{ $nombreInstrumento }}">
                                    <h3 class="text-xs font-bold text-on-surface uppercase tracking-wider">
                                        {{ $nombreInstrumento }}
                                    </h3>
                                    <span class="text-[11px] font-bold text-primary bg-indigo-50 px-2 py-0.5 rounded-full border border-indigo-100">
                                        {{ $totalInstrumento }}
                                    </span>
                                </div>

                                @can('admin')
                                    <button type="button" id="f_{{ $nombreInstrumento }}"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-bold shadow-sm transition"
                                        onclick="mostrarForasters(this)"
                                        data-instrument-name="{{ $nombreInstrumento }}"
                                        title="{{ __('Mostrar/Ocultar reforços') }}">
                                        <span class="material-symbols-outlined text-[15px] text-primary">visibility</span>
                                        <span>{{ __('Reforços') }}</span>
                                    </button>
                                @endcan
                            </div>

                            {{-- Lista de Músicos del Instrumento --}}
                            <ul class="divide-y divide-slate-100">
                                @foreach ($usuariosDelInstrumento->sortBy('name')->sortBy('forastero') as $user)
                                    @cannot('admin')
                                        @if ($user->forastero)
                                            @continue
                                        @endif
                                    @endcannot

                                    @php
                                        $esUsuarioActual = Auth::check() && (Auth::user()->id == $user->id || Auth::user()->hijos->contains($user->id));
                                    @endphp

                                    <li class="@if ($user->forastero) forastero {{ $user->instrument->name }} @endif px-4 py-3 flex items-center justify-between transition-colors {{ $esUsuarioActual ? 'bg-indigo-50/40 border-l-4 border-primary' : 'hover:bg-slate-50' }}"
                                        @if ($user->forastero) style="display: none;" @endif>

                                        {{-- Info del Músico --}}
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <img src="{{ asset($user->profile_photo_url) }}" alt="{{ $user->name }}"
                                                    class="h-9 w-9 rounded-2xl object-cover border {{ $esUsuarioActual ? 'border-primary ring-2 ring-primary/20' : 'border-slate-200' }}">
                                                @if (!$user->disponible)
                                                    <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-rose-500 border-2 border-white flex items-center justify-center text-white text-[9px] font-bold" title="{{ __('No disponible') }}">✕</span>
                                                @endif
                                            </div>

                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs font-bold {{ $esUsuarioActual ? 'text-primary' : 'text-on-surface' }}">
                                                        {{ $user->name }}
                                                    </span>
                                                    @if ($user->forastero)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-lg text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                            {{ __('common.llogat') }}
                                                        </span>
                                                    @endif
                                                    @if ($esUsuarioActual)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-lg text-[10px] font-bold bg-indigo-100 text-indigo-700">
                                                            {{ __('Tu') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5">
                                                    @if ($user->coche)
                                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold">
                                                            <span>🚗</span> {{ __('Cotxe') }}
                                                        </span>
                                                    @endif
                                                    @if ($user->furgona)
                                                        <span class="inline-flex items-center gap-1 text-blue-600 font-semibold">
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
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                            ✓ {{ __('Convocat') }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-xl text-xs font-medium bg-slate-100 text-slate-500">
                                                            {{ __('Reserva') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endcannot

                                            @can('admin')
                                                <div class="flex items-center gap-3">
                                                    {{-- Toggle Furgona --}}
                                                    @if ($user->tienefurgo)
                                                        <label class="flex items-center gap-1.5 cursor-pointer text-xs text-slate-600">
                                                            <input type="checkbox"
                                                                data-lista-id="{{ $lista->id }}"
                                                                data-usuario-id="{{ $user->id }}" 
                                                                data-furgo="1"
                                                                onclick="setCoche(this)"
                                                                class="rounded-lg border-slate-300 text-primary focus:ring-primary h-4 w-4"
                                                                {{ $user->furgona ? 'checked' : '' }} />
                                                            <span class="text-[11px]">🚐</span>
                                                        </label>
                                                    @endif

                                                    {{-- Toggle Coche --}}
                                                    @if ($user->tienecoche)
                                                        <label class="flex items-center gap-1.5 cursor-pointer text-xs text-slate-600">
                                                            <input type="checkbox"
                                                                data-lista-id="{{ $lista->id }}"
                                                                data-usuario-id="{{ $user->id }}"
                                                                onclick="setCoche(this)"
                                                                class="rounded-lg border-slate-300 text-primary focus:ring-primary h-4 w-4"
                                                                {{ $user->coche ? 'checked' : '' }} />
                                                            <span class="text-[11px]">🚗</span>
                                                        </label>
                                                    @endif

                                                    {{-- Checkbox Selección de Plantilla --}}
                                                    <input type="checkbox" data-lista-id="{{ $lista->id }}"
                                                        data-usuario-id="{{ $user->id }}"
                                                        data-usuario-percent="{{ $user->porcentaje }}"
                                                        class="js-selection-checkbox rounded-lg border-slate-300 text-primary focus:ring-primary h-5 w-5 transition cursor-pointer"
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
                <div class="bg-white border border-indigo-50 shadow-bento rounded-3xl overflow-hidden" id="messages-section">
                    <div class="p-4 border-b border-indigo-50 flex items-center justify-between bg-surface-subtle">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-[18px]">forum</span>
                            </div>
                            <h3 class="text-xs font-bold font-headline text-on-surface uppercase tracking-wider">
                                {{ __('common.comentariosactuacion') }}
                            </h3>
                        </div>
                        <span class="text-xs font-semibold text-slate-500">
                            {{ $actuacion->comments->count() }} {{ __('missatges') }}
                        </span>
                    </div>

                    {{-- Contenedor de Mensajes --}}
                    <div id="messages" class="p-4 max-h-80 overflow-y-auto space-y-3 bg-[#F5F6FC]/60">
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
                                            alt="{{ $comment->user->name }}" class="w-6 h-6 rounded-full object-cover border border-slate-200 mb-1">
                                    @endif

                                    <div class="flex flex-col space-y-1 text-xs max-w-sm {{ $esPropio ? 'items-end' : 'items-start' }}">
                                        <div class="px-3.5 py-2 rounded-2xl shadow-sm {{ $esPropio ? 'bg-primary text-white rounded-br-none' : 'bg-white text-slate-800 border border-slate-200/80 rounded-bl-none' }}">
                                            @if(!$esPropio)
                                                <div class="text-[11px] font-bold text-primary mb-0.5">
                                                    {{ $comment->user->name ?? __('Músic') }}
                                                </div>
                                            @endif
                                            <p class="leading-relaxed text-xs">{{ $comment->comment }}</p>
                                        </div>
                                        <span class="text-[10px] text-slate-400 px-1">
                                            {{ $comment->created_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>

                                    @if ($esPropio)
                                        <img src="{{ auth()->user()->profile_photo_path ?? asset('/imagenes/no-icon.png') }}"
                                            alt="Tu" class="w-6 h-6 rounded-full object-cover border border-primary mb-1">
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-6 text-slate-400 text-xs font-medium">
                                    {{ __('No hi ha comentaris encara. Comparteix qualsevol dubte sobre l\'actuació.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Formulario para Enviar Comentarios --}}
                    <div class="p-3 bg-white border-t border-indigo-50">
                        <div class="relative flex items-center">
                            <input type="text" id="commentInput" maxlength="200" minlength="5"
                                placeholder="{{ __('Escriu el teu comentari...') }}"
                                class="w-full bg-surface-subtle border border-indigo-100 text-on-surface text-xs rounded-xl pl-3 pr-12 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"
                                oninput="updateCharacterCount()">
                            <button id="sendComment" type="button"
                                class="absolute right-1.5 p-1.5 rounded-lg bg-primary hover:bg-primary-dark text-white transition disabled:opacity-50">
                                <span class="material-symbols-outlined text-[16px]">send</span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between mt-1.5 px-1 text-[11px] text-slate-400">
                            <span>{{ __('Sé respectuós amb els companys de la banda.') }}</span>
                            <span id="charCount">0 / 200 caràcters</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </div>

    {{-- SCRIPTS DE COMPORTAMIENTO --}}
    <script>
        let availabilityUpdateInProgress = false;

        function setPageLoadingState(isLoading, message = '{{ __('Actualitzant disponibilitat...') }}') {
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

        function setDetallesAttendance(estado, listaId, usuarioId, actuacionId) {
            if (availabilityUpdateInProgress) return;

            availabilityUpdateInProgress = true;
            setPageLoadingState(true, '{{ __('Actualitzant disponibilitat...') }}');

            $.ajax({
                url: '/listauserdisp',
                method: 'POST',
                data: {
                    lista_id: listaId,
                    usuario_id: usuarioId,
                    actuacion_id: actuacionId,
                    estado: estado,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (typeof showToast === 'function') {
                        showToast(response);
                    }
                    location.reload();
                },
                error: function(xhr, status, error) {
                    let message = xhr.responseJSON?.message || '{{ __('Error al comunicar la disponibilitat.') }}';
                    if (typeof showToast === 'function') {
                        showToast(message);
                    } else {
                        alert(message);
                    }
                    availabilityUpdateInProgress = false;
                    setPageLoadingState(false);
                }
            });
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
            if (confirm('{{ __('Segur que vols notificar als usuaris convocats d\'aquesta actuació?') }}')) {
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
                            alert(response.message || '{{ __('Notificació enviada correctament.') }}');
                        }
                    },
                    error: function(xhr, status, error) {
                        if (typeof showToast === 'function') {
                            showToast(xhr.responseJSON);
                        } else {
                            alert('{{ __('Error enviant la notificació.') }}');
                        }
                    }
                });
            }
        }

        @can('admin')
            var cleanListaButton = document.getElementById('cleanListaButton');
            if (cleanListaButton) {
                cleanListaButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    var listaId = cleanListaButton.getAttribute('data-lista-id');

                    if (confirm("{{ __('Segur que vols buidar tota la convocatòria d\'aquesta llista?') }}")) {
                        fetch(`/listauserclean/${listaId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('{{ __('Error al buidar la llista.') }}');
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('{{ __('Error al buidar la llista.') }}');
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
                                        <div class="px-3.5 py-2 rounded-2xl bg-primary text-white rounded-br-none shadow-sm">
                                            <p class="leading-relaxed text-xs">${data.comment}</p>
                                        </div>
                                        <span class="text-[10px] text-slate-400 px-1">${data.created_at}</span>
                                    </div>
                                    <img src="{{ auth()->user()->profile_photo_path ?? asset('/imagenes/no-icon.png') }}" 
                                        alt="Tu" class="w-6 h-6 rounded-full object-cover border border-primary mb-1">
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
