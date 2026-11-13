@php
    use Illuminate\Support\Facades\Auth;

    $authUser = Auth::user();
    $targetUser = $user ?? $authUser;
    $esPadre = $authUser->hijos()->exists();
    $hijos = $esPadre ? $authUser->hijos : collect();
    $usuarioActivo = session('usuarioActivo', $targetUser);
    $iconos = $iconos ?? [];

    $statsItems = isset($statsPorTipo) && $statsPorTipo->isNotEmpty()
        ? $statsPorTipo
        : collect($labels ?? [])->filter(fn($l) => $l !== 'Sin datos')->values()->map(function ($label, $idx) use ($data, $totalesBanda, $porcentajes, $iconos) {
            $userCount = $data[$idx] ?? 0;
            $bandCount = $totalesBanda[$idx] ?? $userCount;
            $pct = $porcentajes[$idx] ?? ($bandCount > 0 ? round(($userCount / $bandCount) * 100) : 0);
            return [
                'id' => null,
                'tipo' => $label,
                'icono' => $iconos[$idx] ?? null,
                'usuario' => $userCount,
                'banda' => $bandCount,
                'porcentaje' => $pct,
            ];
        });

    $totalAsistencias = $statsItems->sum('usuario');
    $totalBanda = $statsItems->sum('banda');
    $porcentajeGlobal = $totalBanda > 0 ? round(($totalAsistencias / $totalBanda) * 100) : 0;

    $sparklinePayload = $statsItems->map(function ($item) {
        return [
            'tipo' => $item['tipo'] ?? '',
            'usuario' => (int) ($item['usuario'] ?? 0),
            'banda' => (int) ($item['banda'] ?? 0),
            'porcentaje' => (int) ($item['porcentaje'] ?? 0),
        ];
    })->values()->all();
@endphp

<x-app-layout>
    {{-- HEADER Y BREADCRUMBS --}}
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('actuacion.index') }}">{{ __('Actuacions') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ $targetUser->name }} ({{ $year }})</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2.5 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ __('Actuacions de') }} {{ $targetUser->name }}
                        </h1>
                        <span class="inline-flex items-center rounded-xl bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100">
                            {{ $actuaciones->count() }} {{ __('actuacions') }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Historial d\'assistència, serveis realitzats i estadístiques per tipus') }}
                    </p>
                </div>
            </div>

            {{-- Selector de Año y Selector de Hijo (si aplica) --}}
            <div class="flex flex-wrap items-center gap-2.5">
                {{-- Selector de Año --}}
                <div class="flex items-center gap-1.5 bg-white border border-indigo-100/80 rounded-2xl px-3 py-1.5 shadow-xs">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Any') }}:</span>
                    <select id="yearSelect"
                        class="border-0 bg-transparent py-1 pl-1 pr-7 text-xs font-bold text-indigo-700 focus:ring-0 focus:outline-none cursor-pointer">
                        @for ($i = date('Y') - 3; $i <= date('Y') + 1; $i++)
                            <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Selector de Hijo / Perfil activo --}}
                @if ($esPadre && $hijos->count() > 0)
                    <div class="flex items-center gap-1.5 bg-indigo-50 border border-indigo-100 rounded-2xl px-3 py-1.5 shadow-xs">
                        <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <select onchange="window.location.href = '/actuaciones/' + this.value + '/{{ $year }}?hijo_id=' + this.value"
                            class="border-0 bg-transparent py-1 pl-1 pr-7 text-xs font-bold text-indigo-800 focus:ring-0 focus:outline-none cursor-pointer">
                            <option value="{{ $authUser->id }}" {{ $authUser->id == $usuarioActivo->id ? 'selected' : '' }}>
                                {{ $authUser->name }} ({{ __('Jo') }})
                            </option>
                            @foreach ($hijos as $hijo)
                                <option value="{{ $hijo->id }}" {{ $hijo->id == $usuarioActivo->id ? 'selected' : '' }}>
                                    {{ $hijo->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto py-5 px-3 sm:px-6 lg:px-8 space-y-6 pb-32">
        {{-- TARJETA DE LEYENDA Y RESUMEN RÁPIDO --}}
        <div class="rounded-3xl border border-indigo-50/80 bg-white p-4 sm:p-5 shadow-bento space-y-3">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-indigo-50/70 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">{{ __('Llegenda d\'assistència i serveis') }}</span>
                </div>
                <span class="text-[11px] text-slate-400">
                    {{ __('Mostrant exercici anual') }} <strong class="text-indigo-600">{{ $year }}</strong>
                </span>
            </div>

            <div class="flex flex-wrap items-center gap-2.5 text-xs font-semibold">
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-50 px-2.5 py-1 text-emerald-700 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ __('Disponible / Assistix') }}</span>
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-rose-50 px-2.5 py-1 text-rose-700 border border-rose-200">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <span>{{ __('No disponible / Baixa') }}</span>
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-amber-50 px-2.5 py-1 text-amber-700 border border-amber-200">
                    <span>🚗</span>
                    <span>{{ __('Aporta cotxe') }}</span>
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-violet-50 px-2.5 py-1 text-violet-700 border border-violet-200">
                    <span>💶</span>
                    <span>{{ __('Liquidada / Pagada') }}</span>
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-50 px-2.5 py-1 text-indigo-700 border border-indigo-200">
                    <span>⭐</span>
                    <span>{{ __('Acte Oficial') }}</span>
                </span>
            </div>
        </div>

        {{-- RESUMEN ESTADÍSTICO POR TIPO (CARDS BENTO CON SPARKLINE) --}}
        @if ($statsItems->isNotEmpty())
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3 px-1">
                    <div>
                        <h3 class="text-sm font-bold font-headline text-slate-800 uppercase tracking-wider">
                            {{ __('Assistència per tipus d\'acte') }} ({{ $year }})
                        </h3>
                        <p class="text-[11px] text-slate-400">
                            {{ __('Percentatge calculat sobre el total d\'actes de cada tipus programats per la banda') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2 self-start sm:self-auto">
                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 border border-indigo-100">
                            <span>{{ __('Total assistències') }}:</span>
                            <strong class="text-indigo-900 font-extrabold">{{ $totalAsistencias }}</strong>
                            <span class="text-indigo-400 font-medium">/ {{ $totalBanda }}</span>
                            <span class="rounded-lg bg-indigo-600 text-white px-1.5 py-0.5 text-[10px] font-black">{{ $porcentajeGlobal }}%</span>
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                    @foreach ($statsItems as $index => $stat)
                        @php
                            $tipoId = $stat['id'] ?? null;
                            $tipoNombre = $stat['tipo'] ?? '-';
                            $tipoIcono = $stat['icono'] ?? null;
                            $userCount = $stat['usuario'] ?? 0;
                            $bandCount = $stat['banda'] ?? 0;
                            $pct = $stat['porcentaje'] ?? 0;
                            $isActive = isset($filtrotipo) && request()->route('type') == $tipoId;

                            // Colores según porcentaje
                            if ($pct >= 80) {
                                $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                $progressClass = 'bg-emerald-500';
                            } elseif ($pct >= 50) {
                                $badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                                $progressClass = 'bg-indigo-600';
                            } else {
                                $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                $progressClass = 'bg-amber-500';
                            }
                        @endphp
                        <div class="relative group rounded-3xl border {{ $isActive ? 'border-indigo-500 ring-2 ring-indigo-500/20 bg-indigo-50/20' : 'border-indigo-50/80 bg-white hover:border-indigo-200' }} p-4 sm:p-5 shadow-bento space-y-3 transition">
                            {{-- Cabecera de la tarjeta: Icono + Nombre + Badge % --}}
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="w-9 h-9 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
                                        @if ($tipoIcono)
                                            <img class="w-5 h-5 object-contain rounded-lg"
                                                src="{{ \App\Models\Tipoactuacion::resolveIconUrl($tipoIcono) }}"
                                                onerror="this.onerror=null;this.src='{{ asset(\App\Models\Tipoactuacion::DEFAULT_ICON_PATH) }}';"
                                                alt="{{ $tipoNombre }}">
                                        @else
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        @if ($tipoId)
                                            <a href="{{ route('actuaciones.usuario.listatipo', ['user' => $usuarioActivo->id, 'year' => $year, 'type' => $tipoId]) }}"
                                                class="text-xs font-bold text-slate-800 hover:text-indigo-600 transition truncate block"
                                                title="{{ $tipoNombre }}">
                                                {{ $tipoNombre }}
                                            </a>
                                        @else
                                            <span class="text-xs font-bold text-slate-800 truncate block" title="{{ $tipoNombre }}">
                                                {{ $tipoNombre }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-black border {{ $badgeClass }}">
                                    {{ $pct }}%
                                </span>
                            </div>

                            {{-- Cifras de asistencia: Usuario / Banda --}}
                            <div class="pt-1">
                                <div class="flex items-baseline justify-between">
                                    <div>
                                        <span class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900">{{ $userCount }}</span>
                                        <span class="text-xs font-bold text-slate-400 ml-1">/ {{ $bandCount }} {{ __('actes') }}</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                        {{ $userCount }} {{ __('assistits') }}
                                    </span>
                                </div>

                                {{-- Barra de progreso del tipo --}}
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden mt-2">
                                    <div class="h-full rounded-full transition-all duration-500 {{ $progressClass }}"
                                        style="width: {{ min(100, $pct) }}%"></div>
                                </div>
                                <div class="flex justify-between items-center text-[10px] text-slate-400 mt-1">
                                    <span>{{ __('Assistència') }}</span>
                                    <span>{{ $pct }}% {{ __('del total') }}</span>
                                </div>
                            </div>

                            {{-- Mini sparkline chart --}}
                            <div class="h-9 w-full pt-1">
                                <canvas id="miniChart-{{ $index }}"></canvas>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- FILTROS DE TIPUS I POBLACIÓ (NEO-BENTO) --}}
        <div class="rounded-3xl border border-indigo-50/80 bg-white p-4 sm:p-5 shadow-bento space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-indigo-50/70 pb-3">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">{{ __('Filtrar actuacions') }}</span>
                </div>

                @if (isset($filtrotipo) || isset($filtropobla))
                    <a href="{{ route('actuaciones.usuario.anyo', [$usuarioActivo->id, $year]) }}"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700 border border-rose-200 hover:bg-rose-100 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>{{ __('Netejar filtres') }}</span>
                    </a>
                @endif
            </div>

            {{-- Filtro por tipo --}}
            @if ($tiposActuacion->isNotEmpty())
                <div class="space-y-1.5">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500">{{ __('Per tipus d\'actuació') }}:</span>
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('actuaciones.usuario.anyo', [$usuarioActivo->id, $year]) }}"
                            class="rounded-xl px-3 py-1.5 text-xs font-bold transition {{ !isset($filtrotipo) ? 'bg-indigo-600 text-white shadow-xs' : 'bg-[#F5F6FC] text-slate-600 hover:bg-indigo-50 hover:text-indigo-700' }}">
                            {{ __('Tots els tipus') }}
                        </a>
                        @foreach ($tiposActuacion as $tipoId => $tipoNombre)
                            <a href="{{ route('actuaciones.usuario.listatipo', ['user' => $usuarioActivo->id, 'year' => $year, 'type' => $tipoId]) }}"
                                class="rounded-xl px-3 py-1.5 text-xs font-bold transition {{ isset($filtrotipo) && request()->route('type') == $tipoId ? 'bg-indigo-600 text-white shadow-xs' : 'bg-[#F5F6FC] text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 border border-indigo-50' }}">
                                {{ $tipoNombre }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Filtro por población --}}
            @if ($poblaciones->isNotEmpty())
                <div class="space-y-1.5 pt-2 border-t border-indigo-50/60">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500">{{ __('Per població') }}:</span>
                    <div class="flex flex-wrap items-center gap-2">
                        @foreach ($poblaciones as $poblacion)
                            <a href="{{ route('actuaciones.usuario.poblacion', ['user' => $usuarioActivo->id, 'year' => $year, 'poblacion' => $poblacion]) }}"
                                class="inline-flex items-center gap-1 rounded-xl px-3 py-1.5 text-xs font-bold transition {{ isset($filtropobla) && request()->route('poblacion') == $poblacion ? 'bg-indigo-600 text-white shadow-xs' : 'bg-[#F5F6FC] text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 border border-indigo-50' }}">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $poblacion }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- LISTADO DE ACTUACIONES (VISTA MÓVIL md:hidden) --}}
        <div class="md:hidden space-y-3">
            @forelse ($actuaciones as $actuacion)
                @php
                    $act = $actuacion->actuacion;
                    $pivot = $actuacion->pivot;
                    $iconUrl = \App\Models\Tipoactuacion::resolveIconUrl($act->tipoactuacion?->icon);
                @endphp
                <div class="rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento space-y-3 transition hover:border-indigo-100">
                    {{-- Fila superior: Fecha + Tipo --}}
                    <div class="flex items-center justify-between gap-2 border-b border-indigo-50/70 pb-2.5">
                        <div class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-50/80 px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100/70">
                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($act->fechaActuacion)->format('d/m/Y') }}</span>
                        </div>

                        <div class="inline-flex items-center gap-1.5 rounded-xl bg-[#F5F6FC] px-2.5 py-1 text-xs font-bold text-slate-700 border border-indigo-50">
                            <img class="w-4 h-4 object-contain rounded-full"
                                src="{{ $iconUrl }}"
                                onerror="this.onerror=null;this.src='{{ asset(\App\Models\Tipoactuacion::DEFAULT_ICON_PATH) }}';"
                                alt="{{ $act->tipoactuacion?->nombre }}">
                            <span>{{ $act->tipoactuacion?->nombre ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Título y Población --}}
                    <div>
                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $act->id]) }}"
                            class="block text-sm font-bold text-slate-900 hover:text-indigo-600 transition leading-snug">
                            {{ $act->descripcion }}
                        </a>
                        @if ($actuacion->poblacion)
                            <div class="flex items-center gap-1 text-[11px] text-slate-500 mt-1">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $actuacion->poblacion }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Badges de Estado y Asistencia --}}
                    <div class="flex flex-wrap items-center gap-1.5 pt-1">
                        @if ($act->oficial)
                            <span class="rounded-xl bg-indigo-50 px-2 py-0.5 text-[10px] font-bold text-indigo-700 border border-indigo-200">
                                ⭐ {{ __('Oficial') }}
                            </span>
                        @endif

                        @if ($pivot && $pivot->disponible)
                            <span class="rounded-xl bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700 border border-emerald-200">
                                {{ __('Disponible') }}
                            </span>
                        @else
                            <span class="rounded-xl bg-rose-50 px-2 py-0.5 text-[10px] font-bold text-rose-700 border border-rose-200">
                                {{ __('No disponible') }}
                            </span>
                        @endif

                        @if ($pivot && $pivot->coche)
                            <span class="rounded-xl bg-amber-50 px-2 py-0.5 text-[10px] font-bold text-amber-700 border border-amber-200">
                                🚗 {{ __('Cotxe') }}
                            </span>
                        @endif

                        @if ($pivot && $pivot->pagada)
                            <span class="rounded-xl bg-violet-50 px-2 py-0.5 text-[10px] font-bold text-violet-700 border border-violet-200">
                                💶 {{ __('Pagada') }}
                            </span>
                        @endif
                    </div>

                    {{-- Botón de acción --}}
                    <div class="flex justify-end pt-2 border-t border-indigo-50/60">
                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $act->id]) }}"
                            class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-50 px-3.5 py-1.5 text-xs font-bold text-indigo-700 border border-indigo-100 hover:bg-indigo-100 transition active:scale-95">
                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>{{ __('Veure llista') }}</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-indigo-50/80 bg-white p-8 text-center shadow-bento">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="mt-4 text-sm font-bold text-slate-800">{{ __('Sense actuacions') }}</p>
                    <p class="mt-1 text-xs text-slate-500">{{ __('No s\'han trobat actuacions per a este músic en l\'any seleccionat.') }}</p>
                </div>
            @endforelse
        </div>

        {{-- TABLA DE ESCRITORIO (hidden md:block) --}}
        <div class="hidden md:block overflow-hidden rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-indigo-50">
                    <thead>
                        <tr class="bg-[#EEF1FA]/60">
                            <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ __('Data') }}
                            </th>
                            <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ __('Actuació') }}
                            </th>
                            <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ __('Tipus') }}
                            </th>
                            <th scope="col" class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ __('Estat / Assistència') }}
                            </th>
                            <th scope="col" class="px-5 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ __('Accions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-indigo-50/70 bg-white">
                        @forelse ($actuaciones as $actuacion)
                            @php
                                $act = $actuacion->actuacion;
                                $pivot = $actuacion->pivot;
                                $iconUrl = \App\Models\Tipoactuacion::resolveIconUrl($act->tipoactuacion?->icon);
                            @endphp
                            <tr class="group hover:bg-indigo-50/40 transition">
                                {{-- Fecha --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-50/80 px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100/70">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($act->fechaActuacion)->format('d/m/Y') }}
                                    </div>
                                </td>

                                {{-- Actuación y Población --}}
                                <td class="px-5 py-4">
                                    <div class="flex flex-col">
                                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $act->id]) }}"
                                            class="text-xs font-bold text-slate-900 hover:text-indigo-600 transition">
                                            {{ $act->descripcion }}
                                        </a>
                                        @if ($actuacion->poblacion)
                                            <span class="inline-flex items-center gap-1 text-[11px] text-slate-400 mt-0.5">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $actuacion->poblacion }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Tipo --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2 rounded-xl bg-[#F5F6FC] px-2.5 py-1 text-xs font-bold text-slate-700 border border-indigo-50">
                                        <img class="w-4 h-4 object-contain rounded-full"
                                            src="{{ $iconUrl }}"
                                            onerror="this.onerror=null;this.src='{{ asset(\App\Models\Tipoactuacion::DEFAULT_ICON_PATH) }}';"
                                            alt="{{ $act->tipoactuacion?->nombre }}">
                                        <span>{{ $act->tipoactuacion?->nombre ?? '-' }}</span>
                                    </div>
                                </td>

                                {{-- Estado y Asistencia --}}
                                <td class="px-5 py-4 whitespace-nowrap text-center">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        @if ($act->oficial)
                                            <span class="rounded-xl bg-indigo-50 px-2 py-0.5 text-[10px] font-bold text-indigo-700 border border-indigo-200" title="{{ __('Acte oficial') }}">
                                                ⭐
                                            </span>
                                        @endif

                                        @if ($pivot && $pivot->disponible)
                                            <span class="rounded-xl bg-emerald-50 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700 border border-emerald-200">
                                                {{ __('Disponible') }}
                                            </span>
                                        @else
                                            <span class="rounded-xl bg-rose-50 px-2.5 py-0.5 text-[11px] font-bold text-rose-700 border border-rose-200">
                                                {{ __('No disponible') }}
                                            </span>
                                        @endif

                                        @if ($pivot && $pivot->coche)
                                            <span class="rounded-xl bg-amber-50 px-2 py-0.5 text-[10px] font-bold text-amber-700 border border-amber-200" title="{{ __('Aporta vehicle') }}">
                                                🚗
                                            </span>
                                        @endif

                                        @if ($pivot && $pivot->pagada)
                                            <span class="rounded-xl bg-violet-50 px-2 py-0.5 text-[10px] font-bold text-violet-700 border border-violet-200" title="{{ __('Actuació pagada') }}">
                                                💶
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Acciones --}}
                                <td class="px-5 py-4 whitespace-nowrap text-right text-xs font-medium">
                                    <a href="{{ route('listas.actuacion', ['actuacion_id' => $act->id]) }}"
                                        class="inline-flex items-center gap-1 rounded-xl bg-indigo-50 px-3 py-1.5 text-xs font-bold text-indigo-700 border border-indigo-100 hover:bg-indigo-100 transition shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span>{{ __('Llista') }}</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-xs">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 mx-auto flex items-center justify-center mb-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-bold text-slate-700 block text-sm">{{ __('Sense actuacions') }}</span>
                                    <span class="text-slate-500">{{ __('No s\'han trobat actuacions per a este músic en l\'any seleccionat.') }}</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <x-subscription-info />
    </div>

    {{-- CHART.JS SPARKLINE GRAPHS --}}
    <script>
        document.getElementById('yearSelect')?.addEventListener('change', function() {
            var year = this.value;
            window.location.href = "/actuaciones/" + {{ $usuarioActivo->id }} + "/" + year;
        });

        const sparklineData = @json($sparklinePayload);

        const colors = [
            { bg: 'rgba(79, 70, 229, 0.25)', border: 'rgb(79, 70, 229)' },   // Indigo
            { bg: 'rgba(6, 182, 212, 0.25)', border: 'rgb(6, 182, 212)' },    // Cyan
            { bg: 'rgba(16, 185, 129, 0.25)', border: 'rgb(16, 185, 129)' },  // Emerald
            { bg: 'rgba(245, 158, 11, 0.25)', border: 'rgb(245, 158, 11)' },  // Amber
            { bg: 'rgba(139, 92, 246, 0.25)', border: 'rgb(139, 92, 246)' },  // Violet
            { bg: 'rgba(244, 63, 94, 0.25)', border: 'rgb(244, 63, 94)' },    // Rose
            { bg: 'rgba(59, 130, 246, 0.25)', border: 'rgb(59, 130, 246)' },   // Blue
        ];

        sparklineData.forEach((item, index) => {
            const canvas = document.getElementById(`miniChart-${index}`);
            if (canvas && typeof Chart !== 'undefined') {
                const ctx = canvas.getContext('2d');
                const color = colors[index % colors.length];

                const count = item.usuario || 0;
                const totalBanda = item.banda || count;
                const pct = item.porcentaje || 0;

                const trendData = [
                    Math.round(count * 0.2),
                    Math.round(count * 0.4),
                    Math.round(count * 0.3),
                    Math.round(count * 0.7),
                    Math.round(count * 0.8),
                    count
                ];

                const gradient = ctx.createLinearGradient(0, 0, 0, 36);
                gradient.addColorStop(0, color.bg);
                gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['', '', '', '', '', ''],
                        datasets: [{
                            data: trendData,
                            backgroundColor: gradient,
                            borderColor: color.border,
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: color.border,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                enabled: true,
                                callbacks: {
                                    label: function() { 
                                        return `${item.tipo}: ${count} / ${totalBanda} (${pct}%)`; 
                                    }
                                }
                            }
                        },
                        scales: {
                            x: { display: false },
                            y: { display: false, beginAtZero: true }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
