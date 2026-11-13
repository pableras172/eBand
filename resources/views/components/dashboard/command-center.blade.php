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

    // 2. Métricas del Músico
    $actuacionesMes = \App\Models\Actuacion::whereBetween('fechaActuacion', [$inicioMes, $finMes])
        ->where('is_draft', false)
        ->count();

    $misActuacionesMes = \App\Models\Actuacion::join('listas', 'actuacions.id', '=', 'listas.actuacions_id')
        ->join('listas_user', 'listas.id', '=', 'listas_user.listas_id')
        ->where('listas_user.user_id', $user->id)
        ->whereBetween('actuacions.fechaActuacion', [$inicioMes, $finMes])
        ->where('listas_user.disponible', '<>', 0)
        ->count();

    $porcentajeAsistencia = $actuacionesMes > 0 ? round(($misActuacionesMes / $actuacionesMes) * 100) : 100;

    // 3. Último Aviso
    $ultimoAviso = \App\Models\Announcement::where('is_active', true)
        ->latest('starts_at')
        ->first();
@endphp

<div class="flex flex-col w-full px-4 sm:px-6 lg:px-8 py-4 sm:py-6 gap-6 max-w-7xl mx-auto">
    {{-- Saludo y Módulo de Perfil --}}
    <section class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-2">
        <div class="flex items-center gap-4 min-w-0">
            <div class="relative shrink-0">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full overflow-hidden ring-2 ring-blue-500/40 shadow-lg shadow-blue-900/40 bg-slate-800">
                    <img class="w-full h-full object-cover"
                         src="{{ $user->profile_photo_url }}"
                         alt="{{ $user->name }}" />
                </div>
                <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-amber-500 text-slate-950 font-bold flex items-center justify-center shadow-md ring-2 ring-[#0B1120]" title="{{ $user->instrument->name ?? '' }}">
                    @if (isset($user->instrument) && $user->instrument->icon)
                        <img src="{{ \App\Models\Instrument::resolveIconUrl($user->instrument->icon) }}"
                             onerror="this.onerror=null;this.src='{{ asset(\App\Models\Instrument::DEFAULT_ICON_PATH) }}';"
                             class="w-3.5 h-3.5 rounded-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-[14px]">music_note</span>
                    @endif
                </div>
            </div>

            <div class="flex flex-col min-w-0">
                <div class="flex items-center gap-2">
                    <h1 class="font-headline text-xl sm:text-2xl font-bold text-white tracking-tight truncate">
                        ¡{{ __('Hola') }}, {{ $user->name }}!
                    </h1>
                    <span class="text-xl inline-block animate-bounce">👋</span>
                </div>
                <p class="font-body text-xs sm:text-sm text-slate-400 truncate">
                    {{ $user->instrument->name ?? __('Músic') }} · {{ function_exists('tenant_name') && function_exists('tenant') && tenant() ? tenant_name() : ($bandSetting?->nombre ?? config('app.banda', 'eBand')) }}
                </p>
            </div>
        </div>

        <a href="{{ route('profile.show') }}"
           class="shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-slate-900/90 border border-slate-700/80 hover:border-blue-400 hover:bg-slate-800 active:scale-95 transition-all text-slate-200 text-xs font-semibold shadow-sm">
            <span class="material-symbols-outlined text-[16px] text-blue-400">badge</span>
            <span>{{ __('auth.miperfil') }}</span>
        </a>
    </section>

    {{-- Bento Grid Responsivo (Móvil: 1 columna, Desktop: 3 columnas) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Columna 1 & 2: Hero "Próxima Actuación" --}}
        <div class="lg:col-span-2 flex flex-col gap-6">
            <x-ui.card variant="hero" :padded="false" class="overflow-hidden">
                @if ($proximaActuacion)
                    {{-- Cabecera con imagen y degradado --}}
                    <div class="relative w-full h-40 sm:h-48 bg-slate-950 overflow-hidden">
                        <img class="w-full h-full object-cover scale-105 filter brightness-90 contrast-105"
                             src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=1200&q=80"
                             alt="{{ $proximaActuacion->descripcion }}" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent"></div>

                        {{-- Badges flotantes superiores --}}
                        <div class="absolute top-3 left-3 flex flex-wrap gap-2">
                            <x-badge-status status="priority" size="sm">
                                <span class="material-symbols-outlined text-[13px]">priority_high</span>
                                {{ __('Obligatori') }}
                            </x-badge-status>

                            @if ($proximaActuacion->tipo)
                                <span class="px-2.5 py-0.5 rounded-full bg-slate-950/80 backdrop-blur-md text-slate-200 text-[11px] font-semibold border border-slate-700/60">
                                    {{ $proximaActuacion->tipo->nombre }}
                                </span>
                            @endif
                        </div>

                        {{-- Localidad inferior --}}
                        @if ($proximaActuacion->contrato?->poblacion)
                            <div class="absolute bottom-3 left-3 flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-950/85 backdrop-blur-md border border-slate-700/60 shadow-md">
                                <span class="material-symbols-outlined text-blue-400 text-[15px]">location_on</span>
                                <span class="text-xs font-semibold text-slate-200">{{ $proximaActuacion->contrato->poblacion }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Cuerpo de la tarjeta --}}
                    <div class="p-5 sm:p-6 flex flex-col gap-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex flex-col min-w-0">
                                <div class="flex items-center gap-1.5 text-blue-400 font-semibold text-xs sm:text-sm">
                                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                                    <span>{{ \Carbon\Carbon::parse($proximaActuacion->fechaActuacion)->translatedFormat('l, d M Y · H:i') }}h</span>
                                </div>
                                <h2 class="font-headline text-lg sm:text-2xl font-bold text-white mt-1 truncate">
                                    {{ $proximaActuacion->descripcion }}
                                </h2>
                                @if ($proximaActuacion->observaciones)
                                    <p class="text-xs sm:text-sm text-slate-400 line-clamp-2 mt-0.5">
                                        {{ $proximaActuacion->observaciones }}
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('listas.actuacion', ['actuacion_id' => $proximaActuacion->id]) }}"
                               aria-label="{{ __('Ver detalles de la actuación') }}"
                               class="w-11 h-11 rounded-full bg-blue-600/20 border border-blue-500/40 flex items-center justify-center text-blue-400 hover:bg-blue-600 hover:text-white transition-all active:scale-95 shrink-0 shadow-lg shadow-blue-900/30">
                                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                            </a>
                        </div>

                        {{-- Quórum de confirmados --}}
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-950/70 border border-slate-800/80">
                            <div class="flex items-center gap-2 text-slate-300 text-xs sm:text-sm">
                                <span class="material-symbols-outlined text-slate-400 text-[18px]">groups</span>
                                <span>{{ __('Quòrum de corda i metall') }}</span>
                            </div>
                            <span class="text-xs font-bold text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-full border border-emerald-500/20">
                                {{ $totalConfirmados }}/{{ $totalConvocados }} {{ __('Músics confirmats') }}
                            </span>
                        </div>

                        {{-- Conmutador de Asistencia Reactivo --}}
                        @if ($listaId)
                            <div class="flex flex-col gap-2 pt-1">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    {{ __('El teu estat d\'assistència:') }}
                                </span>
                                <div class="grid grid-cols-3 gap-2 bg-slate-950/90 p-1.5 rounded-xl border border-slate-800 text-center" id="attendance-toggle-group">
                                    {{-- Asistiré --}}
                                    <button type="button"
                                            id="btn-status-si"
                                            onclick="updateAttendance({{ $listaId }}, {{ $user->id }}, 1)"
                                            class="flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-lg text-xs sm:text-sm font-semibold transition-all active:scale-95 {{ $userDispState === 'si' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-950/60 border border-emerald-400/40' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900' }}">
                                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                        <span>{{ __('Assistiré') }}</span>
                                    </button>

                                    {{-- Duda --}}
                                    <button type="button"
                                            id="btn-status-duda"
                                            onclick="updateAttendance({{ $listaId }}, {{ $user->id }}, 'duda')"
                                            class="flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-lg text-xs sm:text-sm font-semibold transition-all active:scale-95 {{ $userDispState === 'duda' ? 'bg-amber-600 text-white shadow-lg shadow-amber-950/60 border border-amber-400/40' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900' }}">
                                        <span class="material-symbols-outlined text-[16px]">help</span>
                                        <span>{{ __('Dubte') }}</span>
                                    </button>

                                    {{-- No voy --}}
                                    <button type="button"
                                            id="btn-status-no"
                                            onclick="updateAttendance({{ $listaId }}, {{ $user->id }}, 0)"
                                            class="flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-lg text-xs sm:text-sm font-semibold transition-all active:scale-95 {{ $userDispState === 'no' ? 'bg-rose-600 text-white shadow-lg shadow-rose-950/60 border border-rose-400/40' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900' }}">
                                        <span class="material-symbols-outlined text-[16px]">cancel</span>
                                        <span>{{ __('No vaig') }}</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="p-8 text-center flex flex-col items-center justify-center gap-3">
                        <div class="w-14 h-14 rounded-full bg-slate-800/80 flex items-center justify-center text-slate-500">
                            <span class="material-symbols-outlined text-[28px]">event_available</span>
                        </div>
                        <h3 class="font-headline text-lg font-bold text-white">{{ __('Cap actuació propera') }}</h3>
                        <p class="text-sm text-slate-400 max-w-sm">{{ __('Actualment no tens actuacions programades per als propers dies.') }}</p>
                    </div>
                @endif
            </x-ui.card>
        </div>

        {{-- Columna 3: Barra de Mando de Métricas & Avisos --}}
        <div class="flex flex-col gap-6">
            {{-- Command Center Metric Cards --}}
            <div class="grid grid-cols-2 gap-3">
                {{-- Métrica 1: Asistencia Mensual --}}
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-4 flex flex-col justify-between shadow-lg shadow-black/20">
                    <div class="flex items-center gap-1.5 text-emerald-400 mb-2">
                        <span class="material-symbols-outlined text-[18px]">verified</span>
                        <span class="text-[11px] font-bold uppercase tracking-wider">{{ __('Este mes') }}</span>
                    </div>
                    <div>
                        <span class="font-headline text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                            {{ $porcentajeAsistencia }}%
                        </span>
                        <p class="text-xs text-slate-400 mt-0.5">{{ __('Assistència') }}</p>
                    </div>
                </div>

                {{-- Métrica 2: Actuaciones / Ensayos Activos --}}
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-4 flex flex-col justify-between shadow-lg shadow-black/20">
                    <div class="flex items-center gap-1.5 text-blue-400 mb-2">
                        <span class="material-symbols-outlined text-[18px]">event_repeat</span>
                        <span class="text-[11px] font-bold uppercase tracking-wider">{{ __('Actius') }}</span>
                    </div>
                    <div>
                        <span class="font-headline text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                            {{ $actuacionesMes }}
                        </span>
                        <p class="text-xs text-slate-400 mt-0.5">{{ __('Actuacions') }}</p>
                    </div>
                </div>
            </div>

            {{-- Últimos Avisos de Dirección --}}
            <x-ui.card variant="default" :padded="false" class="p-5 flex flex-col gap-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-800/80">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-400 text-[20px]">campaign</span>
                        <h3 class="font-headline text-sm font-bold text-white">{{ __('Últims avisos') }}</h3>
                    </div>
                    @if (Route::has('announcements.index'))
                        <a href="{{ route('announcements.index') }}" class="text-[11px] font-semibold text-blue-400 hover:underline">
                            {{ __('Veure tots') }}
                        </a>
                    @endif
                </div>

                @if ($ultimoAviso)
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs font-bold text-white truncate">{{ $ultimoAviso->title }}</span>
                            <span class="text-[10px] text-slate-500 shrink-0">{{ $ultimoAviso->created_at?->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-slate-300 line-clamp-3 leading-relaxed">
                            {{ strip_tags($ultimoAviso->body) }}
                        </p>
                        @if ($ultimoAviso->redirect_url)
                            <a href="{{ $ultimoAviso->redirect_url }}"
                               target="_blank"
                               class="inline-flex items-center gap-1 text-xs font-bold text-amber-400 hover:text-amber-300 mt-1">
                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                {{ __('Més informació') }}
                            </a>
                        @endif
                    </div>
                @else
                    <div class="flex items-center gap-2 text-slate-500 text-xs py-2">
                        <span class="material-symbols-outlined text-[18px]">notifications_paused</span>
                        <span>{{ __('Sense avisos recents de direcció') }}</span>
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>

    {{-- Rejilla de Accesos Rápidos (3 cols móvil, 6 cols desktop) --}}
    <section class="flex flex-col gap-3 pt-2">
        <h3 class="font-headline text-sm font-bold text-slate-400 uppercase tracking-wider">
            {{ __('Accessos ràpids') }}
        </h3>
        <div class="grid grid-cols-3 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            {{-- Acceso 1: Calendario --}}
            <a href="{{ route('actuacion.index') }}"
               class="flex flex-col items-center text-center p-3 sm:p-4 bg-slate-900/90 border border-slate-800 hover:border-blue-500/50 rounded-xl shadow-md hover:bg-slate-800/80 transition-all active:scale-[0.98] group">
                <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 flex items-center justify-center text-blue-400 mb-2 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                </div>
                <span class="font-semibold text-xs text-white truncate w-full">{{ __('Calendari') }}</span>
                <span class="text-[10px] text-slate-400 mt-0.5 truncate w-full">{{ __('Tots els actes') }}</span>
            </a>

            {{-- Acceso 2: Mis Partituras / Actuaciones del año --}}
            <a href="{{ route('actuaciones.usuario.anyo', [$user->id, date('Y')]) }}"
               class="flex flex-col items-center text-center p-3 sm:p-4 bg-slate-900/90 border border-slate-800 hover:border-blue-500/50 rounded-xl shadow-md hover:bg-slate-800/80 transition-all active:scale-[0.98] group">
                <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 flex items-center justify-center text-blue-400 mb-2 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[20px]">folder_open</span>
                </div>
                <span class="font-semibold text-xs text-white truncate w-full">{{ __('Partitures') }}</span>
                <span class="text-[10px] text-slate-400 mt-0.5 truncate w-full">{{ __('Arxiu digital') }}</span>
            </a>

            {{-- Acceso 3: Mi Inventario / Instrumento --}}
            @if (Route::has('inventory.index'))
                <a href="{{ route('inventory.index') }}"
                   class="flex flex-col items-center text-center p-3 sm:p-4 bg-slate-900/90 border border-slate-800 hover:border-blue-500/50 rounded-xl shadow-md hover:bg-slate-800/80 transition-all active:scale-[0.98] group">
                    <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 flex items-center justify-center text-blue-400 mb-2 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[20px]">inventory_2</span>
                    </div>
                    <span class="font-semibold text-xs text-white truncate w-full">{{ __('Material') }}</span>
                    <span class="text-[10px] text-slate-400 mt-0.5 truncate w-full">{{ __('Instrument i funda') }}</span>
                </a>
            @endif

            {{-- Acceso 4: Directorio Músicos --}}
            @if (Route::has('users.index'))
                <a href="{{ route('users.index') }}"
                   class="flex flex-col items-center text-center p-3 sm:p-4 bg-slate-900/90 border border-slate-800 hover:border-blue-500/50 rounded-xl shadow-md hover:bg-slate-800/80 transition-all active:scale-[0.98] group">
                    <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 flex items-center justify-center text-blue-400 mb-2 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[20px]">groups</span>
                    </div>
                    <span class="font-semibold text-xs text-white truncate w-full">{{ __('Músics') }}</span>
                    <span class="text-[10px] text-slate-400 mt-0.5 truncate w-full">{{ __('Directori per corda') }}</span>
                </a>
            @endif

            {{-- Acceso 5: Actividades Internas --}}
            @if (Route::has('actividades.index'))
                <a href="{{ route('actividades.index') }}"
                   class="flex flex-col items-center text-center p-3 sm:p-4 bg-slate-900/90 border border-slate-800 hover:border-blue-500/50 rounded-xl shadow-md hover:bg-slate-800/80 transition-all active:scale-[0.98] group">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/15 border border-emerald-500/20 flex items-center justify-center text-emerald-400 mb-2 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[20px]">celebration</span>
                    </div>
                    <span class="font-semibold text-xs text-white truncate w-full">{{ __('Activitats') }}</span>
                    <span class="text-[10px] text-slate-400 mt-0.5 truncate w-full">{{ __('Sopars i sortides') }}</span>
                </a>
            @endif

            {{-- Acceso 6: Liquidaciones / Pagos --}}
            @if (Route::has('payments.user'))
                <a href="{{ route('payments.user') }}"
                   class="flex flex-col items-center text-center p-3 sm:p-4 bg-slate-900/90 border border-slate-800 hover:border-blue-500/50 rounded-xl shadow-md hover:bg-slate-800/80 transition-all active:scale-[0.98] group">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/15 border border-amber-500/20 flex items-center justify-center text-amber-400 mb-2 group-hover:bg-amber-600 group-hover:text-slate-950 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">payments</span>
                    </div>
                    <span class="font-semibold text-xs text-white truncate w-full">{{ __('Liquidacions') }}</span>
                    <span class="text-[10px] text-slate-400 mt-0.5 truncate w-full">{{ __('Els meus bolos') }}</span>
                </a>
            @endif
        </div>
    </section>

    {{-- Cita Musical Inspiradora --}}
    <section class="bg-gradient-to-r from-blue-950/40 via-slate-900/80 to-amber-950/30 border border-slate-800/90 rounded-2xl p-4 sm:p-5 flex items-center gap-4 shadow-md">
        <div class="w-10 h-10 rounded-full bg-amber-500/15 border border-amber-500/25 flex items-center justify-center text-amber-400 shrink-0 shadow-sm">
            <span class="material-symbols-outlined text-[20px]">format_quote</span>
        </div>
        <div class="flex flex-col min-w-0">
            <p class="text-xs sm:text-sm text-slate-200 italic line-clamp-2">
                "El ritme no és només tempo, és la respiració compartida de tota la banda."
            </p>
            <span class="text-[11px] text-slate-400 font-semibold mt-0.5">— Direcció Musical</span>
        </div>
    </section>
</div>

<script>
function updateAttendance(listaId, userId, estado) {
    const btnSi = document.getElementById('btn-status-si');
    const btnDuda = document.getElementById('btn-status-duda');
    const btnNo = document.getElementById('btn-status-no');

    // Reset styles
    const defaultClasses = "flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-lg text-xs sm:text-sm font-semibold transition-all active:scale-95 text-slate-400 hover:text-slate-200 hover:bg-slate-900";
    if (btnSi) btnSi.className = defaultClasses;
    if (btnDuda) btnDuda.className = defaultClasses;
    if (btnNo) btnNo.className = defaultClasses;

    // Active visual state
    if (estado === 1 && btnSi) {
        btnSi.className = "flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-lg text-xs sm:text-sm font-semibold transition-all active:scale-95 bg-emerald-600 text-white shadow-lg shadow-emerald-950/60 border border-emerald-400/40";
    } else if (estado === 'duda' && btnDuda) {
        btnDuda.className = "flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-lg text-xs sm:text-sm font-semibold transition-all active:scale-95 bg-amber-600 text-white shadow-lg shadow-amber-950/60 border border-amber-400/40";
    } else if (estado === 0 && btnNo) {
        btnNo.className = "flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-lg text-xs sm:text-sm font-semibold transition-all active:scale-95 bg-rose-600 text-white shadow-lg shadow-rose-950/60 border border-rose-400/40";
    }

    // Backend sync: estado 1 => disponible = 1; estado 0 o 'duda' => disponible = 0 / toggle
    const backendDisponible = (estado === 1) ? 1 : 0;

    fetch('/listauserdisp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            lista_id: listaId,
            usuario_id: userId,
            disponible: backendDisponible
        })
    })
    .then(res => res.json())
    .then(data => {
        if (typeof showToast === 'function' && data.message) {
            showToast(data);
        }
    })
    .catch(err => {
        console.error('Error al actualizar disponibilidad:', err);
    });
}
</script>
