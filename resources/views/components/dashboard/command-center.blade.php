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
    $convocadosCount = 0;
    $dudasCount = 0;
    $noDisponiblesCount = 0;
    $porcentajeConvocados = 0;
    $porcentajeDudas = 0;
    $porcentajeNoDisp = 0;
    $userDispState = 'vacio'; // Por defecto vacio (sin marcar)
    $usuarioConvocado = false;

    if ($lista) {
        $totalConvocados = $lista->users->count();
        $convocadosCount = $lista->users->filter(fn ($u) => (int) $u->pivot->disponible !== 0 && empty($u->pivot->duda))->count();
        $dudasCount = $lista->users->filter(fn ($u) => (int) $u->pivot->disponible !== 0 && ! empty($u->pivot->duda))->count();
        $noDisponiblesCount = $lista->users->filter(fn ($u) => (int) $u->pivot->disponible === 0)->count();

        if ($totalConvocados > 0) {
            $porcentajeConvocados = round(($convocadosCount / $totalConvocados) * 100);
            $porcentajeDudas = round(($dudasCount / $totalConvocados) * 100);
            $porcentajeNoDisp = round(($noDisponiblesCount / $totalConvocados) * 100);
        }

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

    $isAdmin = $user && $user->roles()->where('title', 'Admin')->exists();
    $limiteAntelacion = (int) (\App\Helpers\ConfigHelper::getConfigValue('diasantelacion') ?? 5);
    $fueraDePlazo = false;
    if ($proximaActuacion) {
        $diasRestantes = now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($proximaActuacion->fechaActuacion)->startOfDay(), false);
        $fueraDePlazo = ($diasRestantes <= $limiteAntelacion && ! $isAdmin);
    }

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
            if ($isAdmin) {
                // Admin: mantiene los últimos avisos para supervisión
                $avisosQuery = \App\Models\Announcement::where('is_active', true)->latest();
                $totalAvisos = $avisosQuery->count();
                $avisosRecientes = $avisosQuery->take(3)->get();
            } else {
                // Músico: filtra por vigencia activa (is_active, starts_at <= now, ends_at >= now o null) y destinatarios
                $avisosQuery = \App\Models\Announcement::query()
                    ->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
                    })
                    ->where(function ($q) {
                        $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
                    })
                    ->where(function ($q) use ($user) {
                        $q->where('applies_to_all', true);
                        if ($user && $user->instrument_id) {
                            $q->orWhereHas('instruments', function ($iq) use ($user) {
                                $iq->where('instruments.id', $user->instrument_id);
                            });
                        }
                    })
                    ->orderBy('created_at', 'desc');

                $totalAvisos = $avisosQuery->count();
                $avisosRecientes = $avisosQuery->get();
            }
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

    // 5b. Pròxim Concert / ConcertProgram
    $nextConcert = null;
    try {
        if (class_exists(\App\Models\ConcertProgram::class)) {
            $nextConcert = \App\Models\ConcertProgram::query()
                ->with('pieces')
                ->where('is_published', true)
                ->where('is_featured', true)
                ->whereDate('event_date', '>=', now()->toDateString())
                ->orderBy('event_date')
                ->orderBy('event_time')
                ->first();

            if (! $nextConcert) {
                $nextConcert = \App\Models\ConcertProgram::query()
                    ->with('pieces')
                    ->where('is_published', true)
                    ->whereDate('event_date', '>=', now()->toDateString())
                    ->orderBy('event_date')
                    ->orderBy('event_time')
                    ->first();
            }

            if (! $nextConcert) {
                $nextConcert = \App\Models\ConcertProgram::query()
                    ->with('pieces')
                    ->where('is_published', true)
                    ->orderByDesc('event_date')
                    ->orderByDesc('event_time')
                    ->first();
            }
        }
    } catch (\Throwable $e) {
        $nextConcert = null;
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
        $hora >= 6 && $hora < 13 => __('Bon dia'),
        $hora >= 13 && $hora < 20 => __('Bona vesprada'),
        default => __('Bona nit'),
    };
@endphp

<div class="flex flex-col w-full max-w-5xl mx-auto px-2 sm:px-4 py-4 gap-4 sm:gap-6 pb-28">

    {{-- 1. Neo-Bento Header Card: Greeting & Profile Chip --}}
    <section class="bg-gradient-to-br from-white via-white to-primary-light/50 border border-white/80 rounded-xl p-4 sm:p-5 shadow-bento relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-36 h-36 bg-primary/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="flex items-center justify-between gap-3 relative z-10">
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="relative shrink-0">
                    <div class="w-14 h-14 rounded-xl overflow-hidden shadow-md ring-2 ring-white bg-indigo-50">
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
               class="shrink-0 flex items-center gap-1.5 px-3 py-2 rounded-xl bg-white border border-indigo-100 hover:border-primary/40 active:scale-95 transition-all text-slate-700 shadow-sm hover:shadow">
                <span class="material-symbols-outlined text-[17px] text-primary">badge</span>
                <span class="text-xs font-bold text-on-surface hidden sm:inline">{{ __('El meu perfil') }}</span>
            </a>
        </div>
    </section>

    {{-- 2. Asymmetric Neo-Bento Metrics Grid --}}
    <section class="grid grid-cols-12 gap-3 sm:gap-4">
        {{-- Bento Block 1: Asistencia Gauge a Ensayos (7 cols) --}}
        <div class="col-span-12 sm:col-span-7 bg-white rounded-xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col justify-between relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="material-symbols-outlined text-status-available text-[20px] bg-status-available-subtle p-2 rounded-xl">how_to_reg</span>
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
        <div class="col-span-12 sm:col-span-5 bg-gradient-to-br from-primary to-primary-dark rounded-xl p-4 sm:p-5 shadow-bento-glow text-white flex flex-col justify-between relative overflow-hidden">
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
    <section class="bg-white rounded-xl p-3.5 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col gap-3.5">
        {{-- Card Header --}}
        <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-2.5 h-2.5 rounded-full bg-primary animate-pulse"></div>
                <h2 class="font-headline text-sm sm:text-base font-bold text-on-surface">
                    {{ __('Pròxima Actuació') }}
                </h2>
            </div>
            @if ($proximaActuacion)
                <a href="{{ route('listas.actuacion', ['actuacion_id' => $proximaActuacion->id]) }}" 
                   class="text-xs font-bold text-primary hover:text-primary-dark flex items-center gap-1 transition-colors">
                    <span>{{ __('Veure actuació') }}</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            @endif
        </div>

        @if ($proximaActuacion)
            @php
                $fechaCarbon = \Carbon\Carbon::parse($proximaActuacion->fechaActuacion);
                $imgUrl = \App\Models\Tipoactuacion::resolveIconUrl($proximaActuacion->tipoactuacion?->icon);
            @endphp
            {{-- Contenido de Próxima Actuación --}}
            <div class="flex flex-col gap-3">
                {{-- Caja multimedia enmarcada --}}
                <div class="relative w-full h-40 sm:h-44 rounded-lg overflow-hidden group bg-slate-900">
                    <img class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500 opacity-90" 
                         src="{{ $imgUrl }}" 
                         alt="{{ $proximaActuacion->descripcion }}"
                         onerror="this.onerror=null;this.src='{{ asset(\App\Models\Tipoactuacion::DEFAULT_ICON_PATH) }}';">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/30 to-transparent"></div>
                    
                    {{-- Badges superiores flotantes --}}
                    <div class="absolute top-2.5 left-2.5 right-2.5 flex items-center justify-between pointer-events-none">
                        <div class="flex flex-wrap gap-1.5">
                            @if ($proximaActuacion->oficial == 1)
                                <span class="px-2.5 py-1 rounded-lg bg-status-unavailable text-white text-[11px] font-bold shadow-md flex items-center gap-1 backdrop-blur-sm">
                                    <span class="material-symbols-outlined text-[14px]">priority_high</span> {{ __('Obligatori') }}
                                </span>
                            @endif
                            <span class="px-2.5 py-1 rounded-lg bg-slate-900/80 backdrop-blur-md text-white text-[11px] font-semibold border border-white/10">
                                {{ $proximaActuacion->tipoactuacion?->nombre ?? __('Actuació') }}
                            </span>
                        </div>
                    </div>

                    {{-- Localidad inferior --}}
                    @if ($proximaActuacion->contrato?->poblacion)
                        <div class="absolute bottom-2.5 left-2.5 flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/95 backdrop-blur-md shadow-sm">
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
                           aria-label="{{ __('Veure actuació') }}" 
                           class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all active:scale-95 shrink-0 shadow-sm">
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </a>
                    </div>

                    {{-- Attendance Stats Pill / Músics (Solo visible para administradores) --}}
                    @if ($isAdmin && $totalConvocados > 0)
                        <div class="p-3.5 rounded-lg bg-surface-subtle border border-indigo-50/70 flex flex-col gap-2.5">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1.5">
                                <div class="flex items-center gap-1.5 text-slate-700 font-bold text-xs">
                                    <span class="material-symbols-outlined text-primary text-[18px]">groups</span>
                                    <span>{{ __('Músics:') }}</span>
                                </div>
                                <div class="flex items-center flex-wrap gap-x-3 gap-y-1 text-xs">
                                    <span class="font-bold text-emerald-700 flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span>{{ __('Convocats') }} ({{ $convocadosCount }})</span>
                                    </span>
                                    <span class="font-bold text-amber-700 flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        <span>{{ __('Té dubtes') }} ({{ $dudasCount }})</span>
                                    </span>
                                    <span class="font-bold text-rose-700 flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                        <span>{{ __('No disponible') }} ({{ $noDisponiblesCount }})</span>
                                    </span>
                                </div>
                            </div>
                            <div class="w-full bg-slate-200/80 h-2.5 rounded-full overflow-hidden flex">
                                <div class="bg-emerald-500 h-full transition-all duration-500" style="width: {{ $porcentajeConvocados }}%" title="{{ __('Convocats') }}: {{ $convocadosCount }}"></div>
                                <div class="bg-amber-400 h-full transition-all duration-500" style="width: {{ $porcentajeDudas }}%" title="{{ __('Té dubtes') }}: {{ $dudasCount }}"></div>
                                <div class="bg-rose-500 h-full transition-all duration-500" style="width: {{ $porcentajeNoDisp }}%" title="{{ __('No disponible') }}: {{ $noDisponiblesCount }}"></div>
                            </div>
                        </div>
                    @endif

                    {{-- Gestión de Disponibilidad del Músico (Dudas y Bajas) --}}
                    @if ($user)
                        <div class="flex flex-col gap-2 pt-1 border-t border-indigo-50/80">
                            @if ($usuarioConvocado)
                                {{-- Músico CONVOCADO por la dirección: NO puede indicar que no asiste ni dudas --}}
                                <div id="banner-convocado" class="flex items-center gap-2 px-3.5 py-2 rounded-lg bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs font-bold shadow-sm">
                                    <span class="material-symbols-outlined text-[18px] text-status-available">verified</span>
                                    <div class="flex flex-col">
                                        <span>{{ __('Estàs convocat') }}</span>
                                        <span class="text-[10.5px] font-medium text-emerald-700">{{ __('Assistència confirmada per la direcció') }}</span>
                                    </div>
                                </div>
                            @elseif ($fueraDePlazo)
                                {{-- Fuera de plazo por antelación --}}
                                <div class="px-3.5 py-2 rounded-lg bg-amber-50/80 border border-amber-200/80 text-amber-900 text-xs flex items-center gap-2">
                                    <span class="material-symbols-outlined text-amber-600 text-[18px] shrink-0">lock_clock</span>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-[11px]">{{ __('Termini de canvi tancat') }}</span>
                                        <span class="text-[10px] text-amber-700">{{ __('Menys de :dias dies d\'antelació. Contacta amb la junta.', ['dias' => $limiteAntelacion]) }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="grid grid-cols-2 gap-2 bg-surface-subtle p-1.5 rounded-lg" id="attendance-toggle-group">
                                    {{-- Opción 1: Tinc Dubtes --}}
                                    <button type="button" 
                                        id="btn-status-duda" 
                                        onclick="setBentoAttendance('duda', {{ $listaId ? $listaId : 'null' }}, {{ $user->id }}, {{ $proximaActuacion->id }})"
                                        class="flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-md text-xs font-bold transition-all active:scale-95 {{ $userDispState === 'duda' ? 'bg-status-pending text-white shadow-sm ring-2 ring-amber-300/40' : 'text-slate-600 hover:bg-white border border-transparent hover:border-amber-200' }}"
                                        title="{{ __('Notifica que no saps segur si podràs assistir') }}">
                                        <span class="material-symbols-outlined text-[17px]">help</span>
                                        <span>{{ __('Tinc dubtes') }}</span>
                                    </button>

                                    {{-- Opción 2: No puc anar --}}
                                    <button type="button" 
                                        id="btn-status-no" 
                                        onclick="setBentoAttendance('no', {{ $listaId ? $listaId : 'null' }}, {{ $user->id }}, {{ $proximaActuacion->id }})"
                                        class="flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-md text-xs font-bold transition-all active:scale-95 {{ $userDispState === 'no' ? 'bg-status-unavailable text-white shadow-sm ring-2 ring-rose-300/40' : 'text-slate-600 hover:bg-white border border-transparent hover:border-rose-200' }}"
                                        title="{{ __('Comunica la teua baixa') }}">
                                        <span class="material-symbols-outlined text-[17px]">cancel</span>
                                        <span>{{ __('No puc assistir') }}</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="py-6 text-center text-slate-500">
                <span class="material-symbols-outlined text-primary text-[36px] mb-2 block">event_available</span>
                <p class="font-bold text-on-surface text-sm">{{ __('No hi ha actuacions imminents') }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ __('Consulta el calendari complet per a veure les pròximes dates.') }}</p>
                <a href="{{ route('actuacion.index') }}" class="inline-flex items-center gap-1 px-4 py-2 mt-4 rounded-xl bg-indigo-50 text-primary text-xs font-bold hover:bg-primary hover:text-white transition-colors">
                    <span>{{ __('Obrir Calendari') }}</span>
                </a>
            </div>
        @endif
    </section>

    {{-- 4. Actes dels pròxims 7 dies --}}
    <section class="bg-white rounded-xl p-3.5 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col gap-3.5">
        {{-- Card Header --}}
        <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">date_range</span>
                <h2 class="font-headline text-sm sm:text-base font-bold text-on-surface">
                    {{ __('Actes dels pròxims 7 dies') }}
                </h2>
            </div>
            <span class="text-xs px-2.5 py-0.5 rounded-full bg-primary-light text-primary font-bold">
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
                    <div class="bg-slate-50/80 hover:bg-white rounded-xl p-3.5 border border-slate-200/70 hover:border-indigo-100 hover:shadow-xs transition-all flex flex-col justify-between gap-3 group">
                        <div class="flex items-start justify-between gap-2.5">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-11 h-11 rounded-lg bg-white border border-indigo-100 flex items-center justify-center shrink-0 overflow-hidden shadow-2xs">
                                    <img src="{{ $actoIcon }}" alt="" class="w-6 h-6 object-contain" onerror="this.onerror=null;this.src='{{ asset(\App\Models\Tipoactuacion::DEFAULT_ICON_PATH) }}';">
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
                               class="w-8 h-8 rounded-lg bg-white border border-indigo-100 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all shrink-0 active:scale-95 shadow-2xs"
                               title="{{ __('Veure actuació') }}">
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>

                        {{-- Estado de disponibilidad pill / quick indicator --}}
                        <div class="flex items-center justify-between pt-2 border-t border-slate-200/60 text-xs">
                            <span class="text-slate-500 font-medium">{{ $acto->tipoactuacion?->nombre ?? __('Actuació') }}</span>
                            @if ($actoUserDisp === 'no')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-status-unavailable-subtle text-status-unavailable font-bold text-[10.5px]">
                                    <span class="material-symbols-outlined text-[13px]">cancel</span> {{ __('Baixa comunicada') }}
                                </span>
                            @elseif ($actoUserDisp === 'duda')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-status-pending-subtle text-status-pending font-bold text-[10.5px]">
                                    <span class="material-symbols-outlined text-[13px]">help</span> {{ __('Dubte comunicat') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-status-available-subtle text-status-available font-bold text-[10.5px]">
                                    <span class="material-symbols-outlined text-[13px]">check_circle</span> {{ __('Disponible') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-6 text-center text-slate-400">
                <span class="material-symbols-outlined text-indigo-300 text-[28px] mb-1">calendar_today</span>
                <p class="text-xs font-semibold text-slate-500">{{ __('No hi ha actes programats per als pròxims 7 dies.') }}</p>
            </div>
        @endif
    </section>

    {{-- Módulo: Pròxim Concert / ConcertProgram (Antes de Avisos y Comunicaciones) --}}
    @if ($nextConcert)
        @php
            $concertFecha = \Carbon\Carbon::parse($nextConcert->event_date);
            $concertHora = substr((string) $nextConcert->event_time, 0, 5);
        @endphp
        <section class="bg-white rounded-xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento hover:shadow-md transition-all flex flex-col gap-3.5 relative overflow-hidden" id="dashboard-nextconcert">
            {{-- Card Header --}}
            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">queue_music</span>
                    </div>
                    <h2 class="font-headline text-sm sm:text-base font-bold text-on-surface">
                        {{ __('Próximo concierto') }}
                    </h2>
                </div>

                @if (Route::has('concert-programs.public'))
                    <a href="{{ route('concert-programs.public') }}" class="text-xs font-bold text-primary hover:text-primary-dark flex items-center gap-1 transition-colors">
                        <span>{{ __('Veure programa') }}</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                @endif
            </div>

            {{-- Encabezado del concierto: Título, insignias, fecha y lugar --}}
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                <div class="flex flex-col min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        @if ($nextConcert->is_featured)
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200/80 text-[10.5px] font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">star</span>
                                <span>{{ __('Destacat') }}</span>
                            </span>
                        @endif

                        <span class="px-2.5 py-0.5 rounded-full bg-indigo-50 text-primary border border-indigo-100 text-[10.5px] font-bold flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">event</span>
                            <span>{{ ucfirst($concertFecha->translatedFormat('l, d M Y')) }} · {{ $concertHora }} h</span>
                        </span>
                    </div>

                    <h3 class="font-headline text-base sm:text-lg font-extrabold text-on-surface tracking-tight">
                        {{ $nextConcert->title }}
                    </h3>

                    @if ($nextConcert->location)
                        <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                            <span class="material-symbols-outlined text-[15px] text-primary shrink-0">location_on</span>
                            <span>{{ $nextConcert->location }}</span>
                        </p>
                    @endif

                    @if ($nextConcert->participants)
                        <p class="text-xs text-slate-400 mt-1 line-clamp-2 italic">
                            {{ $nextConcert->participants }}
                        </p>
                    @endif
                </div>

                {{-- Botones de acceso al programa público y cartel --}}
                <div class="flex items-center gap-2 shrink-0 self-start">
                    @if (Route::has('concert-programs.public'))
                        <a href="{{ route('concert-programs.public') }}" 
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-primary text-white text-xs font-bold hover:bg-primary-dark transition-all shadow-sm active:scale-95">
                            <span class="material-symbols-outlined text-[16px]">menu_book</span>
                            <span>{{ __('Programa') }}</span>
                        </a>
                    @endif
                    @if (Route::has('concert-programs.poster'))
                        <a href="{{ route('concert-programs.poster') }}" 
                           target="_blank" 
                           class="inline-flex items-center gap-1 px-3 py-2 rounded-xl bg-slate-50 border border-slate-200/80 text-slate-700 text-xs font-bold hover:bg-slate-100 transition-all shadow-2xs active:scale-95" 
                           title="{{ __('Veure cartell') }}">
                            <span class="material-symbols-outlined text-[16px] text-slate-500">picture_as_pdf</span>
                            <span class="hidden sm:inline">{{ __('Cartell') }}</span>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Repertorio de obras --}}
            @if ($nextConcert->pieces->isNotEmpty())
                <div class="bg-surface-subtle p-3.5 rounded-xl border border-indigo-50/70 flex flex-col gap-2.5">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-700 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-primary text-[17px]">queue_music</span>
                            <span>{{ __('Repertori') }}</span>
                        </span>
                        <span class="text-[11px] font-semibold text-slate-400">
                            {{ $nextConcert->pieces->count() }} {{ trans_choice('{1} obra|[2,*] obres', $nextConcert->pieces->count()) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        @foreach ($nextConcert->pieces->take(4) as $piece)
                            <div class="flex items-start gap-2 p-2.5 rounded-lg bg-white border border-slate-100/90 shadow-2xs">
                                <span class="w-5 h-5 rounded-md bg-indigo-50 text-primary font-bold text-[11px] flex items-center justify-center shrink-0 mt-0.5">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="flex flex-col min-w-0">
                                    <span class="font-bold text-on-surface truncate">{{ $piece->title }}</span>
                                    @if ($piece->author)
                                        <span class="text-[11px] text-slate-400 truncate">{{ $piece->author }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($nextConcert->pieces->count() > 4)
                        <div class="pt-1 text-center">
                            <a href="{{ route('concert-programs.public') }}" class="text-[11px] font-bold text-primary hover:underline">
                                {{ __('+ :count obres més en el programa complet', ['count' => $nextConcert->pieces->count() - 4]) }}
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </section>
    @endif

    {{-- 5. Fila de dos columnas: Avisos (Izquierda) y Actividades (Derecha) --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        {{-- Columna Izquierda: Avisos i Comunicats --}}
        <div class="bg-white rounded-xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col gap-3.5 h-full" id="dashboard-announcements" x-data="{ 
            activeIndex: 0, 
            total: {{ $avisosRecientes->count() }},
            modalAviso: null,
            next() {
                if (this.total > 0) {
                    this.activeIndex = (this.activeIndex + 1) % this.total;
                }
            },
            prev() {
                if (this.total > 0) {
                    this.activeIndex = (this.activeIndex - 1 + this.total) % this.total;
                }
            }
        }">
            {{-- Card Header --}}
            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">campaign</span>
                    </div>
                    <h2 class="font-headline text-sm sm:text-base font-bold text-on-surface">
                        {{ __('Avisos i Comunicats') }}
                    </h2>
                </div>

                @if ($isAdmin)
                    {{-- Solo visible para administradores para evitar 403 a músicos --}}
                    @if (Route::has('announcements.index'))
                        <a href="{{ route('announcements.index') }}" class="text-xs font-bold text-primary hover:text-primary-dark flex items-center gap-0.5">
                            <span>{{ __('Veure tots') }}</span>
                            @if ($totalAvisos > 0)
                                <span>({{ $totalAvisos }})</span>
                            @endif
                        </a>
                    @endif
                @else
                    {{-- Para músicos: navegador entre avisos si hay más de uno --}}
                    @if ($avisosRecientes->count() > 1)
                        <div class="flex items-center gap-1.5">
                            <span class="text-[11px] font-bold text-slate-500 bg-indigo-50/70 border border-indigo-100/80 px-2 py-0.5 rounded-full tabular-nums">
                                <span x-text="activeIndex + 1"></span> / {{ $avisosRecientes->count() }}
                            </span>
                            <div class="flex items-center gap-1">
                                <button type="button" 
                                        @click="prev()"
                                        class="w-7 h-7 rounded-lg bg-white border border-indigo-100 hover:bg-primary hover:text-white hover:border-primary text-slate-600 flex items-center justify-center transition-all shadow-2xs active:scale-95" 
                                        aria-label="{{ __('Anterior') }}">
                                    <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                                </button>
                                <button type="button" 
                                        @click="next()"
                                        class="w-7 h-7 rounded-lg bg-white border border-indigo-100 hover:bg-primary hover:text-white hover:border-primary text-slate-600 flex items-center justify-center transition-all shadow-2xs active:scale-95" 
                                        aria-label="{{ __('Següent') }}">
                                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                </button>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            @if ($isAdmin)
                {{-- VISTA ADMINISTRADOR (Se mantiene como estaba) --}}
                @if ($avisosRecientes->isNotEmpty())
                    <div class="flex flex-col gap-2.5">
                        @foreach ($avisosRecientes as $aviso)
                            <div class="bg-slate-50/80 rounded-xl p-3 sm:p-3.5 border border-slate-200/70 hover:border-indigo-100 flex flex-col gap-1.5 transition-all">
                                <div class="flex items-start justify-between gap-2">
                                    <span class="text-xs font-bold text-on-surface truncate">{{ $aviso->title ?? __('Direcció Musical') }}</span>
                                    <span class="text-[11px] text-slate-400 shrink-0 font-medium">
                                        {{ $aviso->created_at ? $aviso->created_at->diffForHumans() : '' }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                    {{ $aviso->body ?? $aviso->content ?? $aviso->description }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-6 text-center text-slate-400">
                        <span class="material-symbols-outlined text-indigo-300 text-[28px] mb-1">mark_email_read</span>
                        <p class="text-xs font-semibold text-slate-500">{{ __('No hi ha avisos pendents.') }}</p>
                    </div>
                @endif
            @else
                {{-- VISTA MÚSICO: CADA TARJETA ES INDEPENDIENTE, SE AJUSTA AL ESPACIO Y SE NAVEGA ENTRE ELLAS --}}
                @if ($avisosRecientes->isNotEmpty())
                    <div class="relative w-full flex flex-col gap-2">
                        @foreach ($avisosRecientes as $index => $aviso)
                            <div x-show="activeIndex === {{ $index }}"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="w-full bg-slate-50/80 rounded-xl p-3.5 sm:p-4 border border-slate-200/70 hover:border-indigo-100 transition-all flex flex-col justify-between gap-3 relative group min-h-[175px]">
                                
                                <div class="flex flex-col gap-2">
                                    {{-- Estado activo y vigencia temporal --}}
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-[10.5px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span>{{ __('Vigent') }}</span>
                                        </span>

                                        <span class="text-[10.5px] text-slate-400 font-medium flex items-center gap-1 truncate" title="{{ __('Data de publicació') }}">
                                            <span class="material-symbols-outlined text-[13px] text-slate-400">schedule</span>
                                            @if ($aviso->ends_at)
                                                <span>{{ __('Fins al :data', ['data' => $aviso->ends_at->translatedFormat('d M Y')]) }}</span>
                                            @else
                                                <span>{{ $aviso->created_at ? $aviso->created_at->translatedFormat('d M Y') : '' }}</span>
                                            @endif
                                        </span>
                                    </div>

                                    {{-- Título --}}
                                    <h3 class="font-headline text-sm font-extrabold text-on-surface line-clamp-2 leading-snug group-hover:text-primary transition-colors">
                                        {{ $aviso->title ?? __('Direcció Musical') }}
                                    </h3>

                                    {{-- Contenido --}}
                                    <p class="text-xs text-slate-600 line-clamp-4 leading-relaxed whitespace-pre-line">
                                        {{ $aviso->body ?? $aviso->content }}
                                    </p>
                                </div>

                                {{-- Pie de tarjeta: acción para leer completo si es extenso o tiene enlace --}}
                                <div class="flex items-center justify-between pt-2.5 border-t border-slate-200/70 text-xs mt-auto">
                                    <span class="text-[11px] text-slate-400">
                                        {{ $aviso->created_at ? $aviso->created_at->diffForHumans() : '' }}
                                    </span>
                                    
                                    <button type="button" 
                                            @click="modalAviso = {{ json_encode([
                                                'title' => $aviso->title ?? __('Direcció Musical'),
                                                'body' => $aviso->body ?? $aviso->content,
                                                'date' => $aviso->created_at ? $aviso->created_at->translatedFormat('d M Y · H:i') : '',
                                                'ends_at' => $aviso->ends_at ? $aviso->ends_at->translatedFormat('d M Y') : null,
                                                'url' => $aviso->redirect_url ?? null
                                            ]) }}"
                                            class="inline-flex items-center gap-1 text-primary hover:text-primary-dark font-bold text-xs transition-colors">
                                        <span>{{ __('Llegir avís') }}</span>
                                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        {{-- Indicadores visuales de puntos (dots) para navegación rápida si hay varios avisos --}}
                        @if ($avisosRecientes->count() > 1)
                            <div class="flex items-center justify-center gap-1.5 pt-1">
                                @for ($i = 0; $i < $avisosRecientes->count(); $i++)
                                    <button type="button" 
                                            @click="activeIndex = {{ $i }}"
                                            class="h-1.5 rounded-full transition-all duration-300"
                                            :class="activeIndex === {{ $i }} ? 'w-5 bg-primary' : 'w-1.5 bg-slate-200 hover:bg-slate-300'"
                                            aria-label="{{ __('Avís') }} {{ $i + 1 }}">
                                    </button>
                                @endfor
                            </div>
                        @endif
                    </div>

                    {{-- Modal Alpine para lectura completa de avisos en Músicos --}}
                    <div x-show="modalAviso" 
                         x-cloak
                         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
                         @keydown.escape.window="modalAviso = null">
                        <div class="bg-white rounded-2xl max-w-lg w-full p-5 sm:p-6 shadow-2xl border border-indigo-50 flex flex-col gap-4 relative animate-in fade-in zoom-in-95 duration-200"
                             @click.outside="modalAviso = null">
                            
                            {{-- Header modal --}}
                            <div class="flex items-start justify-between gap-3 pb-3 border-b border-slate-100">
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-[11px] font-bold w-fit">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>{{ __('Vigent') }}</span>
                                        <template x-if="modalAviso?.ends_at">
                                            <span class="text-slate-400 font-normal"> · {{ __('Fins al') }} <span x-text="modalAviso?.ends_at"></span></span>
                                        </template>
                                    </span>
                                    <h3 class="font-headline text-lg font-extrabold text-on-surface" x-text="modalAviso?.title"></h3>
                                </div>
                                <button type="button" 
                                        @click="modalAviso = null"
                                        class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors shrink-0"
                                        aria-label="{{ __('Tancar') }}">
                                    <span class="material-symbols-outlined text-[18px]">close</span>
                                </button>
                            </div>

                            {{-- Cuerpo del modal --}}
                            <div class="max-h-[60vh] overflow-y-auto pr-1 text-sm text-slate-700 leading-relaxed whitespace-pre-line" x-text="modalAviso?.body"></div>

                            {{-- Footer modal --}}
                            <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
                                <span class="text-slate-400" x-text="modalAviso?.date"></span>
                                <div class="flex items-center gap-2">
                                    <template x-if="modalAviso?.url">
                                        <a :href="modalAviso?.url" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-indigo-50 text-primary font-bold hover:bg-primary hover:text-white transition-colors">
                                            <span>{{ __('Més info') }}</span>
                                            <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                        </a>
                                    </template>
                                    <button type="button" 
                                            @click="modalAviso = null"
                                            class="px-4 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition-colors">
                                        {{ __('Tancar') }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-xl p-6 border border-indigo-50 shadow-bento text-center text-slate-400">
                        <span class="material-symbols-outlined text-indigo-300 text-[28px] mb-1">mark_email_read</span>
                        <p class="text-xs font-semibold text-slate-500">{{ __('No hi ha avisos pendents.') }}</p>
                    </div>
                @endif
            @endif
        </div>

        {{-- Columna Derecha: Activitats Internes --}}
        <div class="bg-white rounded-xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col gap-3.5 h-full" id="dashboard-activities">
            {{-- Card Header --}}
            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                        <span class="material-symbols-outlined text-[18px]">celebration</span>
                    </div>
                    <h2 class="font-headline text-sm sm:text-base font-bold text-on-surface">
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
                <div class="flex flex-col gap-2.5">
                    @foreach ($proximasActividades as $actividad)
                        @php
                            $actFecha = $actividad->fecha ? \Carbon\Carbon::parse($actividad->fecha) : null;
                        @endphp
                        <a href="{{ route('actividades.show', $actividad->id) }}" 
                           class="bg-slate-50/80 hover:bg-slate-100/90 rounded-xl p-3 sm:p-3.5 border border-slate-200/70 hover:border-indigo-100 transition-all flex items-start justify-between gap-3 group">
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
                            <div class="w-8 h-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all shrink-0 shadow-2xs">
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="py-6 text-center text-slate-400">
                    <span class="material-symbols-outlined text-emerald-300 text-[28px] mb-1">celebration</span>
                    <p class="text-xs font-semibold text-slate-500">{{ __('No hi ha activitats programades.') }}</p>
                </div>
            @endif
        </div>
    </section>

    {{-- 6. Educands / Família (Aparece ÚNICAMENTE si el usuario es padre/madre) --}}
    @if ($esPadre && $hijos->isNotEmpty())
        <section class="bg-white rounded-xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col gap-3.5">
            {{-- Card Header --}}
            <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">family_restroom</span>
                    </div>
                    <h2 class="font-headline text-sm sm:text-base font-bold text-on-surface">
                        {{ __('Educands / Família') }}
                    </h2>
                </div>
                <span class="text-xs text-slate-400 font-medium">
                    {{ $hijos->count() }} {{ trans_choice('{1} fill/a registrat|[2,*] fills/es registrats', $hijos->count()) }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach ($hijos as $hijo)
                    <div class="p-3.5 bg-slate-50/80 hover:bg-white rounded-xl border border-slate-200/70 hover:border-indigo-100 flex items-center justify-between gap-3 hover:shadow-xs transition-all">
                        <div class="flex items-center gap-3 min-w-0">
                            <img class="w-10 h-10 rounded-lg object-cover ring-2 ring-indigo-50 shrink-0" 
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
                           class="w-8 h-8 rounded-lg bg-white border border-indigo-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all active:scale-95 shrink-0 shadow-2xs">
                            <span class="material-symbols-outlined text-[16px]">event_note</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- 7. Accessos Ràpids (Gestió i Músic) --}}
    <section class="bg-white rounded-xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col gap-3.5">
        {{-- Card Header --}}
        <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">apps</span>
                <h2 class="font-headline text-sm sm:text-base font-bold text-on-surface">
                    {{ __('Accessos ràpids') }}
                </h2>
            </div>
            <span class="text-xs text-slate-400 font-medium">{{ __('Gestió i informació') }}</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 @can('admin') lg:grid-cols-3 @else lg:grid-cols-2 @endcan gap-3">
            {{-- Card 1: Calendari d'Actuacions (Lo ven Todos) --}}
            <a href="{{ route('actuacion.index') }}" 
               class="flex items-center justify-between p-3.5 bg-slate-50/80 hover:bg-white rounded-xl border border-slate-200/70 hover:border-indigo-100 hover:shadow-xs transition-all active:scale-[0.99] group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary text-white flex items-center justify-center shadow-md shadow-primary/20 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-on-surface block leading-tight">{{ __('Calendari d\'Actes') }}</span>
                        <span class="text-[11px] text-slate-400 mt-0.5 block leading-tight">{{ __('Totes les actuacions i assajos') }}</span>
                    </div>
                </div>
                <div class="w-8 h-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all shrink-0 shadow-2xs">
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </div>
            </a>

            {{-- Card 2: Plantilla de Músics (Solo Administradores) --}}
            @can('admin')
                <a href="{{ route('users.index') }}" 
                   class="flex items-center justify-between p-3.5 bg-slate-50/80 hover:bg-white rounded-xl border border-slate-200/70 hover:border-indigo-100 hover:shadow-xs transition-all active:scale-[0.99] group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[20px]">groups</span>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-on-surface block leading-tight">{{ __('Músics i Plantilla') }}</span>
                            <span class="text-[11px] text-slate-400 mt-0.5 block leading-tight">{{ __('Directori de la banda') }}</span>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all shrink-0 shadow-2xs">
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </div>
                </a>
            @endcan

            {{-- Card 3: Liquidacions / Bolos (Lo ven Todos) --}}
            @php
                $rutaLiquidaciones = route('actuacion.index');
                if (Gate::allows('admin') && Route::has('payments.index')) {
                    $rutaLiquidaciones = route('payments.index');
                } elseif ($user && Route::has('payments.user')) {
                    $rutaLiquidaciones = route('payments.user', ['user' => $user->id]);
                }
            @endphp
            <a href="{{ $rutaLiquidaciones }}" 
               class="flex items-center justify-between p-3.5 bg-slate-50/80 hover:bg-white rounded-xl border border-slate-200/70 hover:border-indigo-100 hover:shadow-xs transition-all active:scale-[0.99] group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-[20px]">payments</span>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-on-surface block leading-tight">{{ __('Liquidacions') }}</span>
                        <span class="text-[11px] text-slate-400 mt-0.5 block leading-tight">{{ __('Els meus bolos i dietes') }}</span>
                    </div>
                </div>
                <div class="w-8 h-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all shrink-0 shadow-2xs">
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </div>
            </a>
        </div>
    </section>

    {{-- 8. Mapa de Actuaciones (Mantenido del antiguo dashboard) --}}
    <section id="dashboard-map" class="bg-white rounded-xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col gap-3.5">
        {{-- Card Header --}}
        <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary shadow-2xs">
                    <span class="material-symbols-outlined text-[18px]">map</span>
                </div>
                <div>
                    <h2 class="font-headline text-sm sm:text-base font-bold text-on-surface leading-tight">
                        {{ __('Mapa d\'Actuacions') }}
                    </h2>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 font-medium leading-tight hidden sm:block">{{ __('Localització de contractes i concerts') }}</p>
        </div>
        <div class="relative w-full min-h-[320px] rounded-lg overflow-hidden isolate border border-slate-100 shadow-inner">
            <livewire:location-map :height="320" />
        </div>
    </section>

    {{-- 9. Bento Quote of the Week: High-Energy Violet & Cerulean Gradient --}}
    <section class="relative rounded-xl p-4 sm:p-5 bg-gradient-to-r from-indigo-900 via-indigo-950 to-slate-900 text-white shadow-bento overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-cyan-500/20 rounded-full blur-xl pointer-events-none"></div>
        <div class="flex items-start gap-3.5 relative z-10">
            <div class="w-10 h-10 rounded-lg bg-white/10 backdrop-blur-md flex items-center justify-center text-cyan-300 shrink-0 border border-white/15">
                <span class="material-symbols-outlined text-[20px]">format_quote</span>
            </div>
            <div class="flex flex-col min-w-0">
                <p class="text-xs sm:text-sm text-indigo-100 italic line-clamp-2 leading-relaxed">
                    "{{ __('El ritme no és només tempo, és la respiració compartida de tota la banda.') }}"
                </p>
                <span class="text-[11px] text-cyan-300 font-bold mt-1">— {{ __('Direcció Musical') }}</span>
            </div>
        </div>
    </section>

</div>

{{-- Overlay de Carga Difuminado (Backdrop Blur) para la Home --}}
<div id="home-loading-overlay" 
     class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-slate-900/40 backdrop-blur-md transition-all duration-300 opacity-0 pointer-events-none"
     aria-hidden="true">
    <div class="bg-white rounded-xl p-6 shadow-2xl border border-indigo-50 flex flex-col items-center gap-3.5 max-w-xs mx-4 text-center transform scale-95 transition-transform duration-300">
        <div class="relative w-12 h-12 flex items-center justify-center">
            <div class="absolute inset-0 rounded-full border-4 border-indigo-100"></div>
            <div class="absolute inset-0 rounded-full border-4 border-primary border-t-transparent animate-spin"></div>
            <span class="material-symbols-outlined text-primary text-[22px]">event_repeat</span>
        </div>
        <div>
            <p class="text-sm font-bold text-slate-800">
                {{ __('Actualitzant disponibilitat...') }}
            </p>
            <p class="text-xs text-slate-500 mt-0.5">
                {{ __('Sincronitzant amb la plantilla de la banda') }}
            </p>
        </div>
    </div>
</div>

{{-- SCRIPT PARA INTERACCIÓN DEL CONMUTADOR DE ASISTENCIA Y CARGA DEL MAPA --}}
<script>
    function showHomeLoading(show) {
        const overlay = document.getElementById('home-loading-overlay');
        if (!overlay) return;
        if (show) {
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
            const box = overlay.firstElementChild;
            if (box) {
                box.classList.remove('scale-95');
                box.classList.add('scale-100');
            }
        } else {
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            const box = overlay.firstElementChild;
            if (box) {
                box.classList.remove('scale-100');
                box.classList.add('scale-95');
            }
        }
    }

    function setBentoAttendance(choice, listaId, userId, actuacionId) {
        showHomeLoading(true);

        const payload = {
            usuario_id: userId,
            estado: choice
        };
        if (listaId) payload.lista_id = listaId;
        if (actuacionId) payload.actuacion_id = actuacionId;

        // Llamada AJAX para sincronizar con el backend de eBand
        fetch('/listauserdisp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: new URLSearchParams(payload)
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
            setTimeout(() => {
                location.reload();
            }, 250);
        })
        .catch(err => {
            showHomeLoading(false);
            console.error('Error al actualizar disponibilidad:', err);
            if (typeof showToast === 'function') {
                showToast({ message: err.message || "{{ __('Error al actualitzar disponibilitat') }}", alert_type: 'error' });
            } else {
                alert(err.message || "{{ __('Error al actualitzar disponibilitat') }}");
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
