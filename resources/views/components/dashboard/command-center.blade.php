@php
    $user = Auth::user();
    $inicioRango = now()->startOfDay();
    $inicioMes = now()->startOfMonth();
    $finMes = now()->endOfMonth();

    // 1. Próxima Actuación (Hero)
    $proximaActuacion = \App\Models\Actuacion::with(['tipo', 'tipoactuacion', 'contrato', 'lista.users'])
        ->where('fechaActuacion', '>=', $inicioRango)
        ->where('is_draft', false)
        ->orderBy('fechaActuacion', 'asc')
        ->first();

    $lista = $proximaActuacion?->lista;
    $listaId = $lista?->id;
    $totalConvocados = 0;
    $totalConfirmados = 0;
    $userDispState = 'disponible'; // Por defecto disponible
    $usuarioConvocado = false;

    if ($lista) {
        $totalConvocados = $lista->users->count();
        $totalConfirmados = $lista->users->where('pivot.disponible', '<>', 0)->count();

        $userPivot = $lista->users->where('id', $user->id)->first()?->pivot;
        if ($userPivot) {
            if ((int) $userPivot->disponible === 0) {
                $userDispState = 'no';
            } elseif (! empty($userPivot->duda)) {
                $userDispState = 'duda';
            } else {
                $userDispState = 'disponible';
                $usuarioConvocado = true;
            }
        }
    }

    $porcentajeQuorum = ($totalConvocados > 0) ? min(100, round(($totalConfirmados / $totalConvocados) * 100)) : 0;

    // 2. Actes dels pròxims 7 dies
    $fin7Dias = now()->addDays(7)->endOfDay();
    $proximos7Dias = \App\Models\Actuacion::with(['tipo', 'tipoactuacion', 'contrato', 'lista.users'])
        ->whereBetween('fechaActuacion', [$inicioRango, $fin7Dias])
        ->where('is_draft', false)
        ->orderBy('fechaActuacion', 'asc')
        ->get();

    // 3. Métrica de Asistencia y Convocatorias de Tipo Ensayo
    $yearActual = now()->year;

    // Consulta base de actuaciones de tipo ensayo (por flag 'tipoensayo' o por denominación)
    $filtroTipoEnsayo = function ($q) {
        $q->where('tipoensayo', true)
          ->orWhereRaw('LOWER(nombre) LIKE ?', ['%ensayo%'])
          ->orWhereRaw('LOWER(nombre) LIKE ?', ['%assaig%']);
    };

    // A) Ensayos celebrados hasta hoy en el año actual (base para el cálculo de asistencia)
    $queryEnsayosCelebrados = \App\Models\Actuacion::query()
        ->where('is_draft', false)
        ->where('fechaActuacion', '<=', now())
        ->whereYear('fechaActuacion', $yearActual)
        ->whereHas('tipoactuacion', $filtroTipoEnsayo);

    $totalEnsayosCelebrados = (clone $queryEnsayosCelebrados)->count();

    // Si no hay ensayos registrados en este año todavía, consultamos histórico global para no mostrar vacío
    $esHistorico = false;
    if ($totalEnsayosCelebrados === 0) {
        $totalHistoricos = \App\Models\Actuacion::query()
            ->where('is_draft', false)
            ->where('fechaActuacion', '<=', now())
            ->whereHas('tipoactuacion', $filtroTipoEnsayo)
            ->count();
        if ($totalHistoricos > 0) {
            $totalEnsayosCelebrados = $totalHistoricos;
            $esHistorico = true;
        }
    }

    // Ensayos a los que el músico asistió (disponible <> 0)
    $ensayosAsistidos = 0;
    if ($totalEnsayosCelebrados > 0) {
        $queryAsistencias = \Illuminate\Support\Facades\DB::table('listas')
            ->join('listas_user', 'listas.id', '=', 'listas_user.listas_id')
            ->join('actuacions', 'listas.actuacions_id', '=', 'actuacions.id')
            ->join('tipoactuacions', 'actuacions.tipoactuacions_id', '=', 'tipoactuacions.id')
            ->where('listas_user.user_id', $user->id)
            ->where('listas_user.disponible', '<>', 0)
            ->where('actuacions.is_draft', false)
            ->where('actuacions.fechaActuacion', '<=', now())
            ->where(function ($q) {
                $q->where('tipoactuacions.tipoensayo', true)
                  ->orWhereRaw('LOWER(tipoactuacions.nombre) LIKE ?', ['%ensayo%'])
                  ->orWhereRaw('LOWER(tipoactuacions.nombre) LIKE ?', ['%assaig%']);
            });

        if (! $esHistorico) {
            $queryAsistencias->whereYear('actuacions.fechaActuacion', $yearActual);
        }

        $ensayosAsistidos = $queryAsistencias->count();
        $asistenciaEnsayosPorcentaje = round(($ensayosAsistidos / $totalEnsayosCelebrados) * 100);
    } else {
        $asistenciaEnsayosPorcentaje = 100;
    }

    // B) Próximos ensayos futuros programados
    $proximosEnsayosCount = \App\Models\Actuacion::query()
        ->where('is_draft', false)
        ->where('fechaActuacion', '>=', now())
        ->whereHas('tipoactuacion', $filtroTipoEnsayo)
        ->count();

    // 4. Avisos / Comunicados de Dirección
    $avisosRecientes = collect();
    $totalAvisos = 0;
    try {
        if (class_exists(\App\Models\Announcement::class)) {
            $avisosQuery = \App\Models\Announcement::where('is_active', true)->latest();
            $totalAvisos = $avisosQuery->count();
            $avisosRecientes = $avisosQuery->take(3)->get();
        }
    } catch (\Throwable $e) {
        $avisosRecientes = collect();
    }

    // 5. Activitats de la Banda
    $proximasActividades = collect();
    try {
        if (class_exists(\App\Models\Actividad::class)) {
            $proximasActividades = \App\Models\Actividad::where('fecha', '>=', $inicioRango)
                ->orderBy('fecha', 'asc')
                ->take(3)
                ->get();
        }
    } catch (\Throwable $e) {
        $proximasActividades = collect();
    }

    // 6. Educands / Família (Solo si el usuario es padre/madre)
    $esPadre = false;
    $hijos = collect();
    try {
        if (method_exists($user, 'hijos')) {
            $hijos = $user->hijos()->with('instrument')->get();
            $esPadre = $hijos->isNotEmpty();
        }
    } catch (\Throwable $e) {
        $esPadre = false;
        $hijos = collect();
    }

    // Banda
    $bandName = function_exists('tenant_name') && function_exists('tenant') && tenant()
        ? tenant_name()
        : ($bandSetting?->nombre ?? config('app.banda', config('app.name', 'eBand')));

    // Saludo según la hora
    $hora = (int) now()->format('H');
    $saludo = match (true) {
        $hora >= 6 && $hora < 13 => 'Bon dia',
        $hora >= 13 && $hora < 20 => 'Bona vesprada',
        default => 'Bona nit',
    };
@endphp

<div class="flex flex-col w-full max-w-5xl mx-auto px-2 sm:px-4 py-4 gap-4 sm:gap-6 pb-28">

    {{-- 1. Neo-Bento Header Card: Greeting & Profile Chip --}}
    <section class="bg-gradient-to-br from-white via-white to-primary-light/50 border border-white/80 rounded-3xl p-4 sm:p-5 shadow-bento relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-36 h-36 bg-primary/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="flex items-center justify-between gap-3 relative z-10">
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="relative shrink-0">
                    <div class="w-14 h-14 rounded-2xl overflow-hidden shadow-md ring-2 ring-white bg-indigo-50">
                        <img class="w-full h-full object-cover" 
                             src="{{ $user->profile_photo_url }}" 
                             alt="{{ $user->name }}"
                             onerror="this.onerror=null;this.src='{{ asset('/imagenes/no-icon.png') }}';">
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-lg bg-amber-400 text-amber-950 flex items-center justify-center shadow-sm font-bold" title="{{ $user->instrument->name ?? 'Instrument' }}">
                        <span class="material-symbols-outlined text-[13px]">music_note</span>
                    </div>
                </div>
                <div class="flex flex-col min-w-0">
                    <div class="flex items-center gap-1.5">
                        <h1 class="font-headline text-xl sm:text-2xl font-extrabold text-on-surface truncate tracking-tight">
                            {{ $saludo }}, {{ explode(' ', $user->name)[0] }}!
                        </h1>
                        <span class="text-xl inline-block transform hover:rotate-12 transition-transform select-none">👋</span>
                    </div>
                    <p class="text-xs font-semibold text-slate-500 truncate flex items-center gap-1.5 mt-0.5">
                        <span class="text-primary font-bold">{{ $user->instrument->name ?? __('Músic') }}</span>
                        <span>·</span>
                        <span class="truncate">{{ $bandName }}</span>
                    </p>
                </div>
            </div>
            
            <a href="{{ route('profile.show') }}" 
               class="shrink-0 flex items-center gap-1.5 px-3 py-2 rounded-2xl bg-white border border-indigo-100 hover:border-primary/40 active:scale-95 transition-all text-slate-700 shadow-sm hover:shadow">
                <span class="material-symbols-outlined text-[17px] text-primary">badge</span>
                <span class="text-xs font-bold text-on-surface hidden sm:inline">{{ __('El meu perfil') }}</span>
            </a>
        </div>
    </section>

    {{-- 2. Asymmetric Neo-Bento Metrics Grid --}}
    <section class="grid grid-cols-12 gap-3 sm:gap-4">
        {{-- Bento Block 1: Asistencia Gauge a Ensayos (7 cols) --}}
        <div class="col-span-12 sm:col-span-7 bg-white rounded-3xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col justify-between relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="material-symbols-outlined text-status-available text-[20px] bg-status-available-subtle p-2 rounded-2xl">how_to_reg</span>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-status-available-subtle text-status-available">
                    {{ __('Assajos') }} {{ $yearActual }}
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-3">
                <span class="font-headline text-3xl sm:text-4xl font-extrabold text-on-surface tracking-tight">{{ $asistenciaEnsayosPorcentaje }}%</span>
                <div class="h-2 flex-1 bg-slate-100 rounded-full overflow-hidden self-center">
                    <div class="h-full bg-gradient-to-r from-emerald-400 to-status-available rounded-full transition-all duration-700" style="width: {{ $asistenciaEnsayosPorcentaje }}%"></div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-2 text-xs">
                <p class="font-semibold text-slate-500">{{ __('Assistència a assajos') }}</p>
                <span class="text-[11px] text-slate-400 font-medium">
                    @if ($totalEnsayosCelebrados > 0)
                        {{ $ensayosAsistidos }}/{{ $totalEnsayosCelebrados }} {{ __('assistits') }}
                    @else
                        {{ __('Sense assajos previs') }}
                    @endif
                </span>
            </div>
        </div>

        {{-- Bento Block 2: Próximos Ensayos Counter (5 cols) --}}
        <div class="col-span-12 sm:col-span-5 bg-gradient-to-br from-primary to-primary-dark rounded-3xl p-4 sm:p-5 shadow-bento-glow text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-3 -bottom-3 text-white/10 font-bold pointer-events-none">
                <span class="material-symbols-outlined text-[80px] leading-none">event_repeat</span>
            </div>
            <div class="flex items-center justify-between relative z-10">
                <span class="material-symbols-outlined text-[20px] text-cyan-200">event_repeat</span>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-white/20 text-white backdrop-blur-sm">
                    {{ __('Actius') }}
                </span>
            </div>
            <div class="mt-4 relative z-10">
                <span class="font-headline text-3xl sm:text-4xl font-extrabold text-white tracking-tight">{{ $proximosEnsayosCount }}</span>
                <p class="text-xs font-medium text-indigo-100 mt-1">{{ __('Pròxims assajos programats') }}</p>
            </div>
        </div>
    </section>

    {{-- 3. Bento Hero Module: Próxima Actuación --}}
    <section class="flex flex-col gap-2.5">
        <div class="flex items-center justify-between px-1">
            <div class="flex items-center gap-2">
                <div class="w-2.5 h-2.5 rounded-full bg-primary animate-pulse"></div>
                <h2 class="font-headline text-base sm:text-lg font-bold text-on-surface">
                    {{ __('Pròxima Convocatòria') }}
                </h2>
            </div>
            @if ($proximaActuacion)
                <a href="{{ route('listas.actuacion', ['actuacion_id' => $proximaActuacion->id]) }}" 
                   class="text-xs font-bold text-primary hover:text-primary-dark flex items-center gap-1 transition-colors">
                    <span>{{ __('Veure convocatòria') }}</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            @endif
        </div>

        @if ($proximaActuacion)
            @php
                $fechaCarbon = \Carbon\Carbon::parse($proximaActuacion->fechaActuacion);
                $imgUrl = \App\Models\Tipoactuacion::resolveIconUrl($proximaActuacion->tipoactuacion?->icon);
            @endphp
            <div class="bg-white rounded-3xl p-3.5 sm:p-4 border border-indigo-50 shadow-bento flex flex-col gap-3">
                {{-- Caja multimedia enmarcada --}}
                <div class="relative w-full h-40 sm:h-44 rounded-2xl overflow-hidden group bg-slate-900">
                    <img class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500 opacity-90" 
                         src="{{ $imgUrl }}" 
                         alt="{{ $proximaActuacion->descripcion }}"
                         onerror="this.onerror=null;this.src='{{ asset(\App\Models\Tipoactuacion::DEFAULT_ICON_PATH) }}';">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/30 to-transparent"></div>
                    
                    {{-- Badges superiores flotantes --}}
                    <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between pointer-events-none">
                        <div class="flex flex-wrap gap-1.5">
                            @if ($proximaActuacion->oficial == 1)
                                <span class="px-2.5 py-1 rounded-xl bg-status-unavailable text-white text-[11px] font-bold shadow-md flex items-center gap-1 backdrop-blur-sm">
                                    <span class="material-symbols-outlined text-[14px]">priority_high</span> {{ __('Obligatori') }}
                                </span>
                            @endif
                            <span class="px-2.5 py-1 rounded-xl bg-slate-900/80 backdrop-blur-md text-white text-[11px] font-semibold border border-white/10">
                                {{ $proximaActuacion->tipoactuacion?->nombre ?? __('Actuació') }}
                            </span>
                        </div>
                    </div>

                    {{-- Localidad inferior --}}
                    @if ($proximaActuacion->contrato?->poblacion)
                        <div class="absolute bottom-2.5 left-2.5 flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-white/95 backdrop-blur-md shadow-sm">
                            <span class="material-symbols-outlined text-primary text-[15px]">location_on</span>
                            <span class="text-xs font-bold text-on-surface">{{ $proximaActuacion->contrato->poblacion }}</span>
                        </div>
                    @endif
                </div>

                {{-- Detalles del evento y RSVP --}}
                <div class="px-1 flex flex-col gap-3">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1.5 text-primary font-bold text-xs">
                                <span class="material-symbols-outlined text-[16px]">schedule</span>
                                <span>{{ ucfirst($fechaCarbon->translatedFormat('l, d M Y · H:i')) }} h</span>
                            </div>
                            <h3 class="font-headline text-lg sm:text-xl font-extrabold text-on-surface mt-1 tracking-tight">
                                {{ $proximaActuacion->descripcion }}
                            </h3>
                            @if ($proximaActuacion->contrato?->descripcion)
                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">
                                    {{ $proximaActuacion->contrato->descripcion }}
                                </p>
                            @endif
                        </div>

                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $proximaActuacion->id]) }}" 
                           aria-label="{{ __('Veure convocatòria') }}" 
                           class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all active:scale-95 shrink-0 shadow-sm">
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </a>
                    </div>

                    {{-- Attendance Stats Pill / Quórum --}}
                    @if ($totalConvocados > 0)
                        <div class="p-3 rounded-2xl bg-surface-subtle border border-indigo-50/60 flex flex-col gap-1.5">
                            <div class="flex items-center justify-between text-xs">
                                <div class="flex items-center gap-1.5 text-slate-600 font-semibold">
                                    <span class="material-symbols-outlined text-primary text-[17px]">group</span>
                                    <span>{{ __('Quòrum de plantilla') }}</span>
                                </div>
                                <span class="text-xs text-primary font-extrabold">
                                    {{ $totalConfirmados }}/{{ $totalConvocados }} {{ __('confirmats') }}
                                </span>
                            </div>
                            <div class="w-full bg-slate-200/80 h-2 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-primary to-cyan-500 h-full rounded-full transition-all duration-500" style="width: {{ $porcentajeQuorum }}%"></div>
                            </div>
                        </div>
                    @endif

                    {{-- Gestión de Disponibilidad del Músico (Dudas y Bajas) --}}
                    @if ($listaId)
                        <div class="flex flex-col gap-2 pt-1 border-t border-indigo-50/80">
                            {{-- Si el usuario está marcado para asistir se muestra que está convocado --}}
                            @if ($usuarioConvocado)
                                <div id="banner-convocado" class="flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs font-bold shadow-sm">
                                    <span class="material-symbols-outlined text-[18px] text-status-available">verified</span>
                                    <span>{{ __('Estàs convocat') }}</span>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-2 bg-surface-subtle p-1.5 rounded-2xl" id="attendance-toggle-group">
                                {{-- Opción 1: Tinc Dubtes --}}
                                <button type="button" 
                                    id="btn-status-duda" 
                                    onclick="setBentoAttendance('duda', {{ $listaId }}, {{ $user->id }})"
                                    class="flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl text-xs font-bold transition-all active:scale-95 {{ $userDispState === 'duda' ? 'bg-status-pending text-white shadow-sm ring-2 ring-amber-300/40' : 'text-slate-600 hover:bg-white border border-transparent hover:border-amber-200' }}"
                                    title="{{ __('Notifica que no saps segur si podràs assistir') }}">
                                    <span class="material-symbols-outlined text-[17px]">help</span>
                                    <span>{{ __('Tinc dubtes') }}</span>
                                </button>

                                {{-- Opción 2: No puc anar --}}
                                <button type="button" 
                                    id="btn-status-no" 
                                    onclick="setBentoAttendance('no', {{ $listaId }}, {{ $user->id }})"
                                    class="flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl text-xs font-bold transition-all active:scale-95 {{ $userDispState === 'no' ? 'bg-status-unavailable text-white shadow-sm ring-2 ring-rose-300/40' : 'text-slate-600 hover:bg-white border border-transparent hover:border-rose-200' }}"
                                    title="{{ __('Comunica la teua baixa') }}">
                                    <span class="material-symbols-outlined text-[17px]">cancel</span>
                                    <span>{{ __('No puc assistir') }}</span>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-white rounded-3xl p-8 border border-indigo-50 shadow-bento text-center text-slate-500">
                <span class="material-symbols-outlined text-primary text-[36px] mb-2 block">event_available</span>
                <p class="font-bold text-on-surface text-sm">{{ __('No hi ha convocatòries imminents') }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ __('Consulta el calendari complet per a veure les pròximes dates.') }}</p>
                <a href="{{ route('actuacion.index') }}" class="inline-flex items-center gap-1 px-4 py-2 mt-4 rounded-2xl bg-indigo-50 text-primary text-xs font-bold hover:bg-primary hover:text-white transition-colors">
                    <span>{{ __('Obrir Calendari') }}</span>
                </a>
            </div>
        @endif
    </section>

    {{-- 4. Actes dels pròxims 7 dies --}}
    <section class="flex flex-col gap-2.5">
        <div class="flex items-center justify-between px-1">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">date_range</span>
                <h2 class="font-headline text-base sm:text-lg font-bold text-on-surface">
                    {{ __('Actes dels pròxims 7 dies') }}
                </h2>
            </div>
            <span class="text-xs text-primary font-bold">
                {{ $proximos7Dias->count() }} {{ trans_choice('{1} acte|[2,*] actes', $proximos7Dias->count()) }}
            </span>
        </div>

        @if ($proximos7Dias->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach ($proximos7Dias as $acto)
                    @php
                        $actoFecha = \Carbon\Carbon::parse($acto->fechaActuacion);
                        $actoIcon = \App\Models\Tipoactuacion::resolveIconUrl($acto->tipoactuacion?->icon);
                        $actoUserDisp = 'disponible';
                        if ($acto->lista) {
                            $p = $acto->lista->users->where('id', $user->id)->first()?->pivot;
                            if ($p) {
                                if ((int) $p->disponible === 0) {
                                    $actoUserDisp = 'no';
                                } elseif (! empty($p->duda)) {
                                    $actoUserDisp = 'duda';
                                } else {
                                    $actoUserDisp = 'disponible';
                                }
                            }
                        }
                    @endphp
                    <div class="bg-white rounded-3xl p-4 border border-indigo-50/80 shadow-bento hover:shadow-md transition-all flex flex-col justify-between gap-3 group">
                        <div class="flex items-start justify-between gap-2.5">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center shrink-0 overflow-hidden">
                                    <img src="{{ $actoIcon }}" alt="" class="w-7 h-7 object-contain" onerror="this.onerror=null;this.src='{{ asset(\App\Models\Tipoactuacion::DEFAULT_ICON_PATH) }}';">
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-xs font-bold text-primary">{{ ucfirst($actoFecha->translatedFormat('D, d M · H:i')) }} h</span>
                                        @if ($acto->oficial == 1)
                                            <span class="px-1.5 py-0.5 rounded-full bg-status-unavailable-subtle text-status-unavailable text-[10px] font-bold">{{ __('Obligatori') }}</span>
                                        @endif
                                    </div>
                                    <h3 class="text-sm font-extrabold text-on-surface truncate group-hover:text-primary transition-colors mt-0.5">
                                        {{ $acto->descripcion }}
                                    </h3>
                                    @if ($acto->contrato?->poblacion)
                                        <p class="text-xs text-slate-500 flex items-center gap-1 mt-0.5 truncate">
                                            <span class="material-symbols-outlined text-[14px] text-slate-400">location_on</span>
                                            <span>{{ $acto->contrato->poblacion }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('listas.actuacion', ['actuacion_id' => $acto->id]) }}" 
                               class="w-9 h-9 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all shrink-0 active:scale-95 shadow-sm"
                               title="{{ __('Veure convocatòria') }}">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>

                        {{-- Estado de disponibilidad pill / quick indicator --}}
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs">
                            <span class="text-slate-500 font-medium">{{ $acto->tipoactuacion?->nombre ?? __('Actuació') }}</span>
                            @if ($actoUserDisp === 'no')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-status-unavailable-subtle text-status-unavailable font-bold text-[11px]">
                                    <span class="material-symbols-outlined text-[14px]">cancel</span> {{ __('Baixa comunicada') }}
                                </span>
                            @elseif ($actoUserDisp === 'duda')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-status-pending-subtle text-status-pending font-bold text-[11px]">
                                    <span class="material-symbols-outlined text-[14px]">help</span> {{ __('Dubte comunicat') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-status-available-subtle text-status-available font-bold text-[11px]">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span> {{ __('Disponible') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl p-5 border border-indigo-50 shadow-bento text-center text-slate-400">
                <span class="material-symbols-outlined text-indigo-300 text-[28px] mb-1">calendar_today</span>
                <p class="text-xs font-semibold text-slate-500">{{ __('No hi ha actes programats per als pròxims 7 dies.') }}</p>
            </div>
        @endif
    </section>

    {{-- 5. Fila de dos columnas: Avisos (Izquierda) y Actividades (Derecha) --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        {{-- Columna Izquierda: Avisos i Comunicats --}}
        <div class="flex flex-col gap-2.5" id="dashboard-announcements">
            <div class="flex items-center justify-between px-1">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[20px]">campaign</span>
                    </div>
                    <h2 class="font-headline text-base sm:text-lg font-bold text-on-surface">
                        {{ __('Avisos i Comunicats') }}
                    </h2>
                </div>
                @if (Route::has('announcements.index'))
                    <a href="{{ route('announcements.index') }}" class="text-xs font-bold text-primary hover:text-primary-dark flex items-center gap-0.5">
                        <span>{{ __('Veure tots') }}</span>
                        @if ($totalAvisos > 0)
                            <span>({{ $totalAvisos }})</span>
                        @endif
                    </a>
                @endif
            </div>

            @if ($avisosRecientes->isNotEmpty())
                <div class="flex flex-col gap-3">
                    @foreach ($avisosRecientes as $aviso)
                        <div class="bg-white rounded-3xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col gap-2 hover:shadow-md transition-all">
                            <div class="flex items-start justify-between gap-2">
                                <span class="text-xs font-bold text-on-surface truncate">{{ $aviso->title ?? __('Direcció Musical') }}</span>
                                <span class="text-[11px] text-slate-400 shrink-0 font-medium">
                                    {{ $aviso->created_at ? $aviso->created_at->diffForHumans() : '' }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $aviso->content ?? $aviso->description }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-3xl p-6 border border-indigo-50 shadow-bento text-center text-slate-400">
                    <span class="material-symbols-outlined text-indigo-300 text-[28px] mb-1">mark_email_read</span>
                    <p class="text-xs font-semibold text-slate-500">{{ __('No hi ha avisos pendents.') }}</p>
                </div>
            @endif
        </div>

        {{-- Columna Derecha: Activitats Internes --}}
        <div class="flex flex-col gap-2.5" id="dashboard-activities">
            <div class="flex items-center justify-between px-1">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                        <span class="material-symbols-outlined text-[20px]">celebration</span>
                    </div>
                    <h2 class="font-headline text-base sm:text-lg font-bold text-on-surface">
                        {{ __('Activitats') }}
                    </h2>
                </div>
                @if (Route::has('actividades.index'))
                    <a href="{{ route('actividades.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                        {{ __('Veure totes') }}
                    </a>
                @endif
            </div>

            @if ($proximasActividades->isNotEmpty())
                <div class="flex flex-col gap-3">
                    @foreach ($proximasActividades as $actividad)
                        @php
                            $actFecha = $actividad->fecha ? \Carbon\Carbon::parse($actividad->fecha) : null;
                        @endphp
                        <a href="{{ route('actividades.show', $actividad->id) }}" 
                           class="bg-white rounded-3xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento hover:shadow-md transition-all flex items-start justify-between gap-3 group">
                            <div class="flex flex-col min-w-0">
                                <div class="flex items-center gap-2">
                                    @if ($actFecha)
                                        <span class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[15px]">event</span>
                                            <span>{{ ucfirst($actFecha->translatedFormat('d M · H:i')) }} h</span>
                                        </span>
                                    @endif
                                    @if ($actividad->es_de_pago)
                                        <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-200">
                                            {{ __('Pagament') }}
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">
                                            {{ __('Gratuïta') }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-sm font-extrabold text-on-surface truncate group-hover:text-primary transition-colors mt-1">
                                    {{ $actividad->titulo }}
                                </h3>
                                @if ($actividad->lugar)
                                    <p class="text-xs text-slate-500 flex items-center gap-1 mt-0.5 truncate">
                                        <span class="material-symbols-outlined text-[14px] text-slate-400">location_on</span>
                                        <span>{{ $actividad->lugar }}</span>
                                    </p>
                                @endif
                            </div>
                            <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all shrink-0">
                                <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-3xl p-6 border border-indigo-50 shadow-bento text-center text-slate-400">
                    <span class="material-symbols-outlined text-emerald-300 text-[28px] mb-1">celebration</span>
                    <p class="text-xs font-semibold text-slate-500">{{ __('No hi ha activitats programades.') }}</p>
                </div>
            @endif
        </div>
    </section>

    {{-- 6. Educands / Família (Aparece ÚNICAMENTE si el usuario es padre/madre) --}}
    @if ($esPadre && $hijos->isNotEmpty())
        <section class="flex flex-col gap-2.5">
            <div class="flex items-center justify-between px-1">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[20px]">family_restroom</span>
                    </div>
                    <h2 class="font-headline text-base sm:text-lg font-bold text-on-surface">
                        {{ __('Educands / Família') }}
                    </h2>
                </div>
                <span class="text-xs text-slate-400 font-medium">
                    {{ $hijos->count() }} {{ trans_choice('{1} fill/a registrat|[2,*] fills/es registrats', $hijos->count()) }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach ($hijos as $hijo)
                    <div class="p-4 bg-white rounded-3xl border border-indigo-50/80 shadow-bento flex items-center justify-between gap-3 hover:shadow-md transition-all">
                        <div class="flex items-center gap-3 min-w-0">
                            <img class="w-11 h-11 rounded-2xl object-cover ring-2 ring-indigo-50 shrink-0" 
                                 src="{{ $hijo->profile_photo_url }}" 
                                 alt="{{ $hijo->name }}"
                                 onerror="this.onerror=null;this.src='{{ asset('/imagenes/no-icon.png') }}';">
                            <div class="flex flex-col min-w-0">
                                <span class="text-xs font-bold text-on-surface truncate">{{ $hijo->name }}</span>
                                <span class="text-[11px] font-semibold text-primary truncate">{{ $hijo->instrument->name ?? __('Educand') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('actuaciones.usuario.anyo', [$hijo->id, date('Y')]) }}" 
                           title="{{ __('Veure convocatòries de ') . $hijo->name }}"
                           class="w-9 h-9 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all active:scale-95 shrink-0 shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">event_note</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- 7. Accesos Ràpids (Gestió i Músic) --}}
    <section class="flex flex-col gap-2.5">
        <div class="flex items-center justify-between px-1">
            <h2 class="font-headline text-base sm:text-lg font-bold text-on-surface">
                {{ __('Accesos ràpids') }}
            </h2>
            <span class="text-xs text-slate-400 font-medium">{{ __('Gestió i informació') }}</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            {{-- Card 1: Calendari d'Actuacions --}}
            <a href="{{ route('actuacion.index') }}" 
               class="flex items-center justify-between p-4 bg-white rounded-3xl border border-indigo-50/80 shadow-bento hover:shadow-md transition-all active:scale-[0.99] group">
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-primary text-white flex items-center justify-center shadow-md shadow-primary/20 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-[22px]">calendar_month</span>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-on-surface block leading-tight">{{ __('Calendari d\'Actes') }}</span>
                        <span class="text-[11px] text-slate-400 mt-0.5 block leading-tight">{{ __('Totes les actuacions i assajos') }}</span>
                    </div>
                </div>
                <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all shrink-0">
                    <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
                </div>
            </a>

            {{-- Card 2: Plantilla de Músics --}}
            <a href="{{ route('users.index') }}" 
               class="flex items-center justify-between p-4 bg-white rounded-3xl border border-indigo-50/80 shadow-bento hover:shadow-md transition-all active:scale-[0.99] group">
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-[22px]">groups</span>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-on-surface block leading-tight">{{ __('Músics i Plantilla') }}</span>
                        <span class="text-[11px] text-slate-400 mt-0.5 block leading-tight">{{ __('Directori de la banda') }}</span>
                    </div>
                </div>
                <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all shrink-0">
                    <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
                </div>
            </a>

            {{-- Card 3: Liquidacions / Bolos --}}
            @if (Route::has('payments.user') && $user)
                <a href="{{ route('payments.user', ['user' => $user->id]) }}" 
                   class="flex items-center justify-between p-4 bg-white rounded-3xl border border-indigo-50/80 shadow-bento hover:shadow-md transition-all active:scale-[0.99] group">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[22px]">payments</span>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-on-surface block leading-tight">{{ __('Liquidacions') }}</span>
                            <span class="text-[11px] text-slate-400 mt-0.5 block leading-tight">{{ __('Els meus bolos i dietes') }}</span>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all shrink-0">
                        <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
                    </div>
                </a>
            @endif
        </div>
    </section>

    {{-- 8. Mapa de Actuaciones (Mantenido del antiguo dashboard) --}}
    <section id="dashboard-map" class="bg-white rounded-3xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col gap-3">
        <div class="flex items-center justify-between px-1">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary shadow-sm">
                    <span class="material-symbols-outlined text-[22px]">map</span>
                </div>
                <div>
                    <h2 class="font-headline text-base sm:text-lg font-bold text-on-surface leading-tight">
                        {{ __('Mapa d\'Actuacions') }}
                    </h2>
                    <p class="text-[11px] text-slate-400 font-medium leading-tight">{{ __('Localització geogràfica de contractes i concerts') }}</p>
                </div>
            </div>
        </div>
        <div class="relative w-full min-h-[320px] rounded-2xl overflow-hidden isolate border border-slate-100 shadow-inner">
            <livewire:location-map :height="320" />
        </div>
    </section>

    {{-- 9. Bento Quote of the Week: High-Energy Violet & Cerulean Gradient --}}
    <section class="relative rounded-3xl p-4 sm:p-5 bg-gradient-to-r from-indigo-900 via-indigo-950 to-slate-900 text-white shadow-bento overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-cyan-500/20 rounded-full blur-xl pointer-events-none"></div>
        <div class="flex items-start gap-3.5 relative z-10">
            <div class="w-10 h-10 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-cyan-300 shrink-0 border border-white/15">
                <span class="material-symbols-outlined text-[20px]">format_quote</span>
            </div>
            <div class="flex flex-col min-w-0">
                <p class="text-xs sm:text-sm text-indigo-100 italic line-clamp-2 leading-relaxed">
                    "El ritme no és només tempo, és la respiració compartida de tota la banda."
                </p>
                <span class="text-[11px] text-cyan-300 font-bold mt-1">— Direcció Musical</span>
            </div>
        </div>
    </section>

</div>

{{-- SCRIPT PARA INTERACCIÓN DEL CONMUTADOR DE ASISTENCIA Y CARGA DEL MAPA --}}
<script>
    function setBentoAttendance(choice, listaId, userId) {
        const btnDuda = document.getElementById('btn-status-duda');
        const btnNo = document.getElementById('btn-status-no');
        const bannerConvocado = document.getElementById('banner-convocado');

        if (!btnDuda || !btnNo) return;

        // Si se pulsa el botón que ya estaba activo, se desmarca para volver a Disponible
        const yaEnDuda = btnDuda.classList.contains('bg-status-pending');
        const yaEnNo = btnNo.classList.contains('bg-status-unavailable');

        let targetEstado = choice;
        if (choice === 'duda' && yaEnDuda) {
            targetEstado = 'disponible';
        } else if (choice === 'no' && yaEnNo) {
            targetEstado = 'disponible';
        }

        // Estilos base neutros
        const baseDuda = "flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl text-xs font-bold text-slate-600 hover:bg-white border border-transparent hover:border-amber-200 transition-all active:scale-95";
        const baseNo = "flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl text-xs font-bold text-slate-600 hover:bg-white border border-transparent hover:border-rose-200 transition-all active:scale-95";

        btnDuda.className = baseDuda;
        btnNo.className = baseNo;

        // Feedback visual optimista
        if (targetEstado === 'duda') {
            btnDuda.className = "flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl text-xs font-bold bg-status-pending text-white shadow-sm ring-2 ring-amber-300/40 transition-all active:scale-95";
            if (bannerConvocado) bannerConvocado.style.display = 'none';
        } else if (targetEstado === 'no') {
            btnNo.className = "flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl text-xs font-bold bg-status-unavailable text-white shadow-sm ring-2 ring-rose-300/40 transition-all active:scale-95";
            if (bannerConvocado) bannerConvocado.style.display = 'none';
        } else {
            if (bannerConvocado) bannerConvocado.style.display = 'flex';
        }

        // Llamada AJAX para sincronizar con el backend de eBand
        fetch('/listauserdisp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: new URLSearchParams({
                lista_id: listaId,
                usuario_id: userId,
                estado: targetEstado
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errData => {
                    throw new Error(errData.message || 'Error del servidor (' + response.status + ')');
                });
            }
            return response.json();
        })
        .then(data => {
            if (typeof showToast === 'function') {
                showToast(data);
            }
        })
        .catch(err => {
            console.error('Error al actualizar disponibilidad:', err);
            if (typeof showToast === 'function') {
                showToast({ message: err.message || 'Error al actualitzar disponibilitat', alert_type: 'error' });
            }
        });
    }

    // Carga de ubicaciones en el mapa interactivo
    document.addEventListener('DOMContentLoaded', async () => {
        try {
            const res = await fetch('/api/ubicaciones-contratos');
            if (res.ok) {
                const data = await res.json();
                if (window.MapComponent && typeof window.MapComponent.setMunicipios === 'function') {
                    window.MapComponent.setMunicipios(data);
                }
            }
        } catch (err) {
            console.error('Error carregant ubicacions del mapa:', err);
        }
    });
</script>
