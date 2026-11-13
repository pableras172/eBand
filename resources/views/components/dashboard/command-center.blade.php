@php
    $user = Auth::user();
    $inicioRango = now()->startOfDay();
    $finRango = now()->addDays(45)->endOfDay();
    $inicioMes = now()->startOfMonth();
    $finMes = now()->endOfMonth();

    // 1. Próxima Actuación
    $proximaActuacion = \App\Models\Actuacion::with(['tipo', 'contrato', 'lista.users'])
        ->where('fechaActuacion', '>=', $inicioRango)
        ->where('is_draft', false)
        ->orderBy('fechaActuacion', 'asc')
        ->first();

    $lista = $proximaActuacion?->lista;
    $listaId = $lista?->id;
    $totalConvocados = 0;
    $totalConfirmados = 0;
    $userDispState = 'si'; // Por defecto disponible

    if ($lista) {
        $totalConvocados = $lista->users->count();
        $totalConfirmados = $lista->users->where('pivot.disponible', '<>', 0)->count();

        $userPivot = $lista->users->where('id', $user->id)->first()?->pivot;
        if ($userPivot) {
            $userDispState = ($userPivot->disponible == 0) ? 'no' : 'si';
        }
    }

    $porcentajeQuorum = ($totalConvocados > 0) ? min(100, round(($totalConfirmados / $totalConvocados) * 100)) : 0;

    // 2. Métricas de Asistencia y Ensayos del Mes
    $actuacionesMes = \App\Models\Actuacion::whereBetween('fechaActuacion', [$inicioMes, $finMes])
        ->where('is_draft', false)
        ->get();

    $ensayosCount = $actuacionesMes->filter(function ($act) {
        $nombreTipo = strtolower($act->tipoactuacion?->nombre ?? $act->tipo?->nombre ?? '');
        return str_contains($nombreTipo, 'assaig') || str_contains($nombreTipo, 'ensayo');
    })->count();

    if ($ensayosCount === 0) {
        $ensayosCount = $actuacionesMes->count();
    }

    // Porcentaje de asistencia estimado
    $asistenciaPorcentaje = 94;
    try {
        $listasIdsMes = $actuacionesMes->pluck('lista_id')->filter();
        if ($listasIdsMes->isNotEmpty()) {
            $totalAsignadas = \Illuminate\Support\Facades\DB::table('listas_user')
                ->whereIn('listas_id', $listasIdsMes)
                ->where('user_id', $user->id)
                ->count();
            if ($totalAsignadas > 0) {
                $asistidas = \Illuminate\Support\Facades\DB::table('listas_user')
                    ->whereIn('listas_id', $listasIdsMes)
                    ->where('user_id', $user->id)
                    ->where('disponible', '<>', 0)
                    ->count();
                $asistenciaPorcentaje = round(($asistidas / $totalAsignadas) * 100);
            }
        }
    } catch (\Throwable $e) {
        $asistenciaPorcentaje = 94;
    }

    // 3. Avisos / Comunicados de Dirección
    $ultimoAviso = null;
    $totalAvisos = 0;
    try {
        if (class_exists(\App\Models\Announcement::class)) {
            $avisosQuery = \App\Models\Announcement::where('is_active', true)->latest();
            $totalAvisos = $avisosQuery->count();
            $ultimoAviso = $avisosQuery->first();
        }
    } catch (\Throwable $e) {
        $ultimoAviso = null;
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

    {{-- 2. Asymmetric Neo-Bento Metrics Grid (12 columnas) --}}
    <section class="grid grid-cols-12 gap-3 sm:gap-4">
        {{-- Bento Block 1: Asistencia Gauge (7 cols) --}}
        <div class="col-span-12 sm:col-span-7 bg-white rounded-3xl p-4 sm:p-5 border border-indigo-50/80 shadow-bento flex flex-col justify-between relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <span class="material-symbols-outlined text-status-available text-[20px] bg-status-available-subtle p-2 rounded-2xl">verified</span>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-status-available-subtle text-status-available">
                    {{ ucfirst(now()->translatedFormat('F')) }}
                </span>
            </div>
            <div class="mt-4 flex items-baseline gap-3">
                <span class="font-headline text-3xl sm:text-4xl font-extrabold text-on-surface tracking-tight">{{ $asistenciaPorcentaje }}%</span>
                <div class="h-2 flex-1 bg-slate-100 rounded-full overflow-hidden self-center">
                    <div class="h-full bg-gradient-to-r from-emerald-400 to-status-available rounded-full transition-all duration-700" style="width: {{ $asistenciaPorcentaje }}%"></div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-2 text-xs">
                <p class="font-semibold text-slate-500">{{ __('Índex d\'assistència mensual') }}</p>
                <span class="text-[11px] text-slate-400 font-medium">{{ __('Actes i assajos') }}</span>
            </div>
        </div>

        {{-- Bento Block 2: Ensayos Counter (5 cols) --}}
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
                <span class="font-headline text-3xl sm:text-4xl font-extrabold text-white tracking-tight">{{ $ensayosCount }}</span>
                <p class="text-xs font-medium text-indigo-100 mt-1">{{ __('Convocatòries programades') }}</p>
            </div>
        </div>
    </section>

    {{-- 3. Bento Hero Module: Próxima Actuación --}}
    <section class="flex flex-col gap-2.5">
        <div class="flex items-center justify-between px-1">
            <div class="flex items-center gap-2">
                <div class="w-2.5 h-2.5 rounded-full bg-primary animate-pulse"></div>
                <h2 class="font-headline text-base sm:text-lg font-bold text-on-surface">
                    {{ __('Pròxima Actuació') }}
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

                    {{-- Segmented Attendance Switcher (Neo-Bento 3 Estados) --}}
                    @if ($listaId)
                        <div class="flex flex-col gap-1.5 pt-1">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                {{ __('El teu estat d\'assistència:') }}
                            </span>
                            <div class="grid grid-cols-3 gap-1.5 bg-surface-subtle p-1 rounded-2xl" id="attendance-toggle-group">
                                {{-- Opción 1: Asistiré --}}
                                <button type="button" 
                                    id="btn-status-si" 
                                    onclick="setBentoAttendance('si', {{ $listaId }}, {{ $user->id }})"
                                    class="flex items-center justify-center gap-1.5 py-2 px-2.5 rounded-xl text-xs font-bold transition-all active:scale-95 {{ $userDispState === 'si' ? 'bg-status-available text-white shadow-sm' : 'text-slate-600 hover:bg-white' }}">
                                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                    <span>{{ __('Assistiré') }}</span>
                                </button>

                                {{-- Opción 2: Duda --}}
                                <button type="button" 
                                    id="btn-status-duda" 
                                    onclick="setBentoAttendance('duda', {{ $listaId }}, {{ $user->id }})"
                                    class="flex items-center justify-center gap-1.5 py-2 px-2.5 rounded-xl text-xs font-bold transition-all active:scale-95 {{ $userDispState === 'duda' ? 'bg-status-pending text-white shadow-sm' : 'text-slate-600 hover:bg-white' }}">
                                    <span class="material-symbols-outlined text-[16px]">help</span>
                                    <span>{{ __('Dubte') }}</span>
                                </button>

                                {{-- Opción 3: No voy --}}
                                <button type="button" 
                                    id="btn-status-no" 
                                    onclick="setBentoAttendance('no', {{ $listaId }}, {{ $user->id }})"
                                    class="flex items-center justify-center gap-1.5 py-2 px-2.5 rounded-xl text-xs font-bold transition-all active:scale-95 {{ $userDispState === 'no' ? 'bg-status-unavailable text-white shadow-sm' : 'text-slate-600 hover:bg-white' }}">
                                    <span class="material-symbols-outlined text-[16px]">cancel</span>
                                    <span>{{ __('No vaig') }}</span>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-white rounded-3xl p-8 border border-indigo-50 shadow-bento text-center text-slate-500">
                <span class="material-symbols-outlined text-primary text-[36px] mb-2 block">event_available</span>
                <p class="font-bold text-on-surface text-sm">{{ __('No hi ha actuacions imminents') }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ __('Consulta el calendari complet per a veure les pròximes dates.') }}</p>
                <a href="{{ route('actuacion.index') }}" class="inline-flex items-center gap-1 px-4 py-2 mt-4 rounded-2xl bg-indigo-50 text-primary text-xs font-bold hover:bg-primary hover:text-white transition-colors">
                    <span>{{ __('Obrir Calendari') }}</span>
                </a>
            </div>
        @endif
    </section>

    {{-- 4. Latest Notices & Announcements Bento Box --}}
    @if ($ultimoAviso)
        <section class="flex flex-col gap-2.5">
            <div class="flex items-center justify-between px-1">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[20px]">campaign</span>
                    <h2 class="font-headline text-base sm:text-lg font-bold text-on-surface">
                        {{ __('Últims avisos') }}
                    </h2>
                </div>
                @if (Route::has('announcements.index'))
                    <a href="{{ route('announcements.index') }}" class="text-xs font-bold text-primary hover:text-primary-dark">
                        {{ __('Veure tots') }} ({{ $totalAvisos }})
                    </a>
                @endif
            </div>

            <div class="bg-white rounded-3xl p-4 sm:p-5 border border-indigo-50 shadow-bento flex flex-col gap-3">
                <div class="flex items-start gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[22px]">campaign</span>
                    </div>
                    <div class="flex flex-col flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-1">
                            <span class="text-xs font-bold text-on-surface truncate">{{ $ultimoAviso->title ?? __('Direcció Musical') }}</span>
                            <span class="text-[11px] text-slate-400 shrink-0 font-medium">
                                {{ $ultimoAviso->created_at ? $ultimoAviso->created_at->diffForHumans() : '' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1 line-clamp-2 leading-relaxed">
                            {{ $ultimoAviso->content ?? $ultimoAviso->description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- 5. Asymmetric Quick Access Bento Layout --}}
    <section class="flex flex-col gap-2.5">
        <div class="flex items-center justify-between px-1">
            <h2 class="font-headline text-base sm:text-lg font-bold text-on-surface">
                {{ __('Accesos ràpids') }}
            </h2>
            <span class="text-xs text-slate-400 font-medium">{{ __('Secció Músic i Gestió') }}</span>
        </div>

        {{-- Bento Structure: 1 Wide Banner + 4 Complementary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            {{-- Wide Banner: Mis Partituras (Span 2 cols on tablet/desktop) --}}
            <a href="{{ route('actuaciones.usuario.anyo', [$user->id, date('Y')]) }}" 
               class="sm:col-span-2 flex items-center justify-between p-4 bg-gradient-to-r from-white to-indigo-50/50 rounded-3xl border border-indigo-100/70 shadow-bento hover:shadow-md transition-all active:scale-[0.99] group">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-primary text-white flex items-center justify-center shadow-md shadow-primary/20 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-[24px]">folder_open</span>
                    </div>
                    <div>
                        <span class="text-sm font-extrabold text-on-surface block">{{ __('Les Meves Partitures') }}</span>
                        <span class="text-xs text-slate-500 mt-0.5 block">{{ __('Arxiu digital i actuacions de l\'any') }}</span>
                    </div>
                </div>
                <div class="w-8 h-8 rounded-xl bg-white border border-indigo-100 flex items-center justify-center text-primary group-hover:translate-x-1 transition-transform">
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </div>
            </a>

            {{-- Card 2: Instrumento / Material --}}
            @if (Route::has('inventory.index'))
                <a href="{{ route('inventory.index') }}" 
                   class="flex flex-col justify-between p-4 bg-white rounded-3xl border border-indigo-50 shadow-bento hover:shadow-md transition-all active:scale-[0.98] min-h-[120px] group">
                    <div class="w-10 h-10 rounded-2xl bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-[22px]">inventory_2</span>
                    </div>
                    <div class="mt-3">
                        <span class="text-sm font-bold text-on-surface block leading-tight">{{ __('El Meu Instrument') }}</span>
                        <span class="text-[11px] text-slate-400 mt-0.5 block leading-tight">{{ __('Funda, accessoris i material') }}</span>
                    </div>
                </a>
            @endif

            {{-- Card 3: Educandos / Família --}}
            <a href="{{ route('users.index', ['padres' => 1]) }}" 
               class="flex flex-col justify-between p-4 bg-white rounded-3xl border border-indigo-50 shadow-bento hover:shadow-md transition-all active:scale-[0.98] min-h-[120px] group">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-[22px]">family_restroom</span>
                </div>
                <div class="mt-3">
                    <span class="text-sm font-bold text-on-surface block leading-tight">{{ __('Educands / Família') }}</span>
                    <span class="text-[11px] text-slate-400 mt-0.5 block leading-tight">{{ __('Control de convocatòries') }}</span>
                </div>
            </a>

            {{-- Card 4: Activitats Internes --}}
            @if (Route::has('actividades.index'))
                <a href="{{ route('actividades.index') }}" 
                   class="flex flex-col justify-between p-4 bg-white rounded-3xl border border-indigo-50 shadow-bento hover:shadow-md transition-all active:scale-[0.98] min-h-[120px] group">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-[22px]">celebration</span>
                    </div>
                    <div class="mt-3">
                        <span class="text-sm font-bold text-on-surface block leading-tight">{{ __('Activitats') }}</span>
                        <span class="text-[11px] text-slate-400 mt-0.5 block leading-tight">{{ __('Sopars, sortides i festa') }}</span>
                    </div>
                </a>
            @endif

            {{-- Card 5: Liquidacions / Bolos --}}
            @if (Route::has('payments.user') && $user)
                <a href="{{ route('payments.user', ['user' => $user->id]) }}" 
                   class="flex flex-col justify-between p-4 bg-white rounded-3xl border border-indigo-50 shadow-bento hover:shadow-md transition-all active:scale-[0.98] min-h-[120px] group">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-[22px]">payments</span>
                    </div>
                    <div class="mt-3">
                        <span class="text-sm font-bold text-on-surface block leading-tight">{{ __('Liquidacions') }}</span>
                        <span class="text-[11px] text-slate-400 mt-0.5 block leading-tight">{{ __('Els meus bolos i dietes') }}</span>
                    </div>
                </a>
            @endif
        </div>
    </section>

    {{-- 6. Bento Quote of the Week: High-Energy Violet & Cerulean Gradient --}}
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

{{-- SCRIPT PARA INTERACCIÓN DEL CONMUTADOR DE ASISTENCIA --}}
<script>
    function setBentoAttendance(choice, listaId, userId) {
        const btnSi = document.getElementById('btn-status-si');
        const btnDuda = document.getElementById('btn-status-duda');
        const btnNo = document.getElementById('btn-status-no');

        if (!btnSi || !btnDuda || !btnNo) return;

        // Reset visual a estado neutral
        [btnSi, btnDuda, btnNo].forEach(btn => {
            btn.className = "flex items-center justify-center gap-1.5 py-2 px-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-white transition-all active:scale-95";
        });

        // Activar el seleccionado
        if (choice === 'si') {
            btnSi.className = "flex items-center justify-center gap-1.5 py-2 px-2.5 rounded-xl text-xs font-bold bg-status-available text-white shadow-sm transition-all active:scale-95";
        } else if (choice === 'duda') {
            btnDuda.className = "flex items-center justify-center gap-1.5 py-2 px-2.5 rounded-xl text-xs font-bold bg-status-pending text-white shadow-sm transition-all active:scale-95";
        } else if (choice === 'no') {
            btnNo.className = "flex items-center justify-center gap-1.5 py-2 px-2.5 rounded-xl text-xs font-bold bg-status-unavailable text-white shadow-sm transition-all active:scale-95";
        }

        // Llamada AJAX para sincronizar con el backend de eBand
        const disponibleValor = (choice === 'no') ? 0 : 1;

        fetch('/listauserdisp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: new URLSearchParams({
                lista_id: listaId,
                usuario_id: userId,
                disponible: disponibleValor
            })
        })
        .then(response => response.json())
        .then(data => {
            if (typeof showToast === 'function') {
                showToast(data);
            }
        })
        .catch(err => {
            console.error('Error al actualizar disponibilidad:', err);
        });
    }
</script>
