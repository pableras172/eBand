<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <x-ui.breadcrumbs>
                    <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                    <x-ui.breadcrumbs.separator />
                    <x-ui.breadcrumbs.link active>{{ __('common.calendario') }}</x-ui.breadcrumbs.link>
                </x-ui.breadcrumbs>
                <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-on-surface tracking-tight mt-1">
                    {{ __('common.calendario_proximas') }}
                </h1>
                <p class="text-xs font-medium text-slate-500">
                    {{ __('Gestió d\'actuacions, assajos i convocatòries de la banda') }}
                </p>
            </div>
        </div>
    </x-slot>

    @php
        $hayFiltrosActivos = (request('fecha') || isset($filtroFecha) || isset($filtrotipo) || isset($filtropobla));
    @endphp

    <div class="space-y-6 pb-28">
        {{-- Módulo de Filtros y Búsqueda (Neo-Bento Violet Colapsable) --}}
        <div class="bg-white border border-indigo-50 shadow-bento rounded-3xl p-4 lg:p-5 transition-all"
             x-data="{ openFilters: {{ $hayFiltrosActivos ? 'true' : 'false' }} }">
            
            {{-- Encabezado compacto del card de filtros --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary flex-shrink-0">
                        <span class="material-symbols-outlined text-[20px]">filter_list</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-xs sm:text-sm font-bold text-on-surface uppercase tracking-wider">
                                {{ __('Filtres del Calendari') }}
                            </h2>
                            @if ($hayFiltrosActivos)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    {{ __('Filtres actius') }}
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500">
                            {{ __('Filtra per tipus, data o localitat de l\'esdeveniment') }}
                        </p>
                    </div>
                </div>

                {{-- Acciones de la barra de filtros: Botón Limpiar (destacado) y Botón Plegar/Desplegar --}}
                <div class="flex items-center gap-2 self-end sm:self-auto">
                    @if ($hayFiltrosActivos)
                        <a href="{{ route('actuacion.index') }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300 border border-rose-200 dark:border-rose-900/60 text-xs font-bold rounded-xl transition-all shadow-xs active:scale-95"
                           title="{{ __('Restablir tots els filtres') }}">
                            <span class="material-symbols-outlined text-[16px]">clear_all</span>
                            <span>{{ __('Netejar tots') }}</span>
                        </a>
                    @endif

                    <button type="button" 
                            @click="openFilters = !openFilters" 
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-indigo-100 bg-surface-subtle hover:bg-indigo-50/70 text-slate-700 text-xs font-bold transition-all shadow-xs active:scale-95">
                        <span class="material-symbols-outlined text-[18px] text-primary transition-transform duration-200" 
                              :class="openFilters ? 'rotate-180' : ''">
                            keyboard_arrow_down
                        </span>
                        <span x-text="openFilters ? '{{ __('Amagar filtres') }}' : '{{ __('Desplegar filtres') }}'"></span>
                    </button>
                </div>
            </div>

            {{-- Contenido desplegable de los Filtros --}}
            <div x-show="openFilters" 
                 x-collapse
                 style="{{ $hayFiltrosActivos ? '' : 'display: none;' }}"
                 class="pt-4 mt-3 border-t border-indigo-50 space-y-4">
                
                {{-- Filtro por Fecha --}}
                <div class="flex flex-wrap items-center justify-between gap-3 bg-surface-subtle p-3 rounded-2xl border border-indigo-50/60">
                    <form action="{{ route('actuaciones-fecha') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
                        <label for="fecha" class="text-xs font-semibold text-slate-600">
                            {{ __('Des de:') }}
                        </label>
                        <input type="date" id="fecha" name="fecha" 
                            value="{{ request('fecha', $filtroFecha ?? '') }}"
                            onchange="if(this.value) this.form.submit()"
                            class="bg-white border border-indigo-100 text-on-surface text-xs rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition shadow-xs"
                            min="{{ now()->subMonths(3)->format('Y-m-d') }}"
                            max="{{ now()->format('Y-m-d') }}">
                        <button type="submit" class="inline-flex items-center px-3.5 py-1.5 bg-primary hover:bg-primary-dark text-white text-xs font-bold rounded-xl shadow-xs transition-colors">
                            {{ __('Filtrar') }}
                        </button>
                    </form>

                    @if(isset($filtroFecha))
                        <span class="text-xs text-slate-500 font-medium">
                            {{ __('Mostrant actes des de:') }} <strong class="text-primary">{{ \Carbon\Carbon::parse($filtroFecha)->format('d/m/Y') }}</strong>
                        </span>
                    @endif
                </div>

                {{-- Chips de Filtrado por Tipo --}}
                <div class="space-y-1.5">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold text-slate-400 mr-2 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            {{ __('Tipus:') }}
                        </span>
                        <a href="{{ route('actuacion.index') }}" 
                            class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ !isset($filtrotipo) ? 'bg-primary text-white shadow-sm' : 'bg-surface-subtle text-slate-600 hover:bg-indigo-50 border border-indigo-100/60' }}">
                            {{ __('Tots els tipus') }}
                        </a>
                        @foreach ($tiposActuacion as $tipo)
                            @php
                                $isSelected = isset($filtrotipo) && $filtrotipo == $tipo->id;
                            @endphp
                            <a href="{{ route('actuaciones-tipo', ['tipoactuacion' => $tipo->id]) }}"
                                class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $isSelected ? 'bg-primary text-white shadow-sm font-bold' : 'bg-surface-subtle text-slate-600 hover:bg-indigo-50 border border-indigo-100/60' }}">
                                {{ $tipo->nombre }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Chips de Filtrado por Población --}}
                @if(isset($poblaciones) && count($poblaciones) > 0)
                    <div class="space-y-1.5 pt-2 border-t border-indigo-50/70">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-bold text-slate-400 mr-2 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                                {{ __('Població:') }}
                            </span>
                            <a href="{{ route('actuacion.index') }}" 
                                class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ !isset($filtropobla) ? 'bg-cyan-600 text-white shadow-sm' : 'bg-surface-subtle text-slate-600 hover:bg-cyan-50 border border-cyan-100/60' }}">
                                {{ __('Totes les poblacions') }}
                            </a>
                            @foreach ($poblaciones as $poblacion)
                                @php
                                    $isPoblaSelected = isset($filtropobla) && $filtropobla == $poblacion;
                                @endphp
                                <a href="{{ route('actuaciones-poblacion', ['poblacion' => $poblacion]) }}"
                                    class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ $isPoblaSelected ? 'bg-cyan-600 text-white shadow-sm font-bold' : 'bg-surface-subtle text-slate-600 hover:bg-cyan-50 border border-cyan-100/60' }}">
                                    {{ $poblacion }}
                                </a>
                            @endforeach
                        </div>
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
                <div class="flex items-center justify-between sticky top-16 z-10 bg-[#F5F6FC]/95 backdrop-blur-md py-3 px-1 border-b border-indigo-100/70">
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-7 bg-primary rounded-full"></div>
                        <h2 class="text-xl lg:text-2xl font-extrabold font-headline text-on-surface tracking-tight">
                            {{ $mesFormateado }}
                        </h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-primary border border-indigo-100">
                            {{ $actuacionesDelMes->count() }} {{ $actuacionesDelMes->count() === 1 ? __('acte') : __('actes') }}
                        </span>
                    </div>
                </div>

                {{-- Grid de Actuaciones (1 col móvil, 2 cols tablet, 3 cols desktop xl) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach ($actuacionesDelMes->sortBy('fechaActuacion') as $actuacion)
                        @php
                            $lista = $actuacion->lista;
                            $listaId = $lista?->id;
                            $totalConvocados = 0;
                            $convocadosCount = 0;
                            $dudasCount = 0;
                            $noDisponiblesCount = 0;
                            $porcentajeConvocados = 0;
                            $porcentajeDudas = 0;
                            $porcentajeNoDisp = 0;
                            $userDispState = 'vacio';
                            $usuarioConvocado = false;
                            $currentUser = auth()->user();

                            if ($lista && $lista->relationLoaded('users')) {
                                $totalConvocados = $lista->users->count();
                                $convocadosCount = $lista->users->filter(fn ($u) => (int) $u->pivot->disponible !== 0 && empty($u->pivot->duda))->count();
                                $dudasCount = $lista->users->filter(fn ($u) => (int) $u->pivot->disponible !== 0 && ! empty($u->pivot->duda))->count();
                                $noDisponiblesCount = $lista->users->filter(fn ($u) => (int) $u->pivot->disponible === 0)->count();

                                if ($totalConvocados > 0) {
                                    $porcentajeConvocados = round(($convocadosCount / $totalConvocados) * 100);
                                    $porcentajeDudas = round(($dudasCount / $totalConvocados) * 100);
                                    $porcentajeNoDisp = round(($noDisponiblesCount / $totalConvocados) * 100);
                                }

                                if ($currentUser) {
                                    $userPivot = $lista->users->where('id', $currentUser->id)->first()?->pivot;
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
                            }

                            $fechaAct = \Carbon\Carbon::parse($actuacion->fechaActuacion);
                            $esHoy = $fechaAct->isToday();
                            $limiteAntelacion = (int) (\App\Helpers\ConfigHelper::getConfigValue('diasantelacion') ?? 5);
                            $isAdmin = $currentUser && $currentUser->roles()->where('title', 'Admin')->exists();
                            $diasRestantes = now()->startOfDay()->diffInDays($fechaAct->startOfDay(), false);
                            $fueraDePlazo = ($diasRestantes <= $limiteAntelacion && ! $isAdmin);
                        @endphp

                        <div @if($loop->first && $loop->parent->first) id="driver-actuacion-first" @endif 
                            class="group relative flex flex-col bg-white border border-indigo-50/80 rounded-3xl overflow-hidden shadow-bento hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            
                            {{-- Banner visual con imagen / icono --}}
                            <div class="relative h-44 overflow-hidden bg-slate-900">
                                <img src="{{ \App\Models\Tipoactuacion::resolveIconUrl($actuacion->tipoactuacion?->icon) }}"
                                    onerror="this.onerror=null;this.src='{{ asset(\App\Models\Tipoactuacion::DEFAULT_ICON_PATH) }}';"
                                    alt="{{ $actuacion->tipoactuacion?->nombre ?? 'Actuació' }}" 
                                    class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-500 opacity-90">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/30 to-transparent"></div>

                                {{-- Badges superiores flotantes --}}
                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none">
                                    <div class="flex items-center gap-1.5">
                                        @if ($actuacion->oficial == 1)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-xs font-bold bg-status-unavailable text-white shadow-md backdrop-blur-sm">
                                                <span class="material-symbols-outlined text-[13px]">priority_high</span>
                                                {{ __('Acte Oficial') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-semibold bg-slate-900/80 text-white backdrop-blur-sm border border-white/10">
                                                {{ $actuacion->tipoactuacion?->nombre ?? __('Actuació') }}
                                            </span>
                                        @endif

                                        @can('admin')
                                            @if ($actuacion->is_draft)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-amber-400 text-amber-950 shadow-sm">
                                                    {{ __('Esborrany') }}
                                                </span>
                                            @endif
                                        @endcan
                                    </div>
                                </div>

                                {{-- Fecha y Hora sobre el degradado inferior del banner --}}
                                <div class="absolute bottom-3 left-3 right-3 flex items-end justify-between pointer-events-none">
                                    <div class="flex items-center gap-2">
                                        <div class="px-2.5 py-1 rounded-xl bg-primary text-white font-bold text-xs uppercase tracking-wider shadow-md">
                                            {{ $fechaAct->translatedFormat('D d M') }}
                                        </div>
                                        <div class="text-xs font-bold text-white bg-slate-900/80 px-2.5 py-1 rounded-xl border border-white/10 backdrop-blur-sm">
                                            {{ $fechaAct->format('H:i') }} h
                                        </div>
                                    </div>
                                    @if($actuacion->contrato?->poblacion)
                                        <div class="text-xs font-semibold text-slate-800 flex items-center gap-1 bg-white/95 px-2.5 py-1 rounded-xl shadow-sm">
                                            <span class="material-symbols-outlined text-primary text-[15px]">location_on</span>
                                            <span class="truncate max-w-[120px]">{{ $actuacion->contrato->poblacion }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Cuerpo de la tarjeta --}}
                            <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between space-y-3.5">
                                <div class="space-y-1">
                                    <h3 class="text-base font-bold font-headline text-on-surface group-hover:text-primary transition-colors line-clamp-2">
                                        {{ $actuacion->descripcion }}
                                    </h3>
                                    @if ($actuacion->contrato?->descripcion)
                                        <p class="text-xs text-slate-500 line-clamp-1">
                                            {{ $actuacion->contrato->descripcion }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Quórum de plantilla (Convocados, Dudas, No disponible) --}}
                                @if ($totalConvocados > 0)
                                    <div class="p-3 rounded-2xl bg-surface-subtle border border-indigo-50/70 flex flex-col gap-2">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 text-xs">
                                            <div class="flex items-center gap-1.5 text-slate-700 font-bold">
                                                <span class="material-symbols-outlined text-primary text-[17px]">groups</span>
                                                <span>{{ __('Quòrum de plantilla') }}</span>
                                            </div>
                                            <div class="flex items-center flex-wrap gap-x-2.5 gap-y-1 text-[11px]">
                                                <span class="font-bold text-emerald-700 flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    <span>{{ __('Convocats') }} ({{ $convocadosCount }})</span>
                                                </span>
                                                <span class="font-bold text-amber-700 flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                    <span>{{ __('Té dubtes') }} ({{ $dudasCount }})</span>
                                                </span>
                                                <span class="font-bold text-rose-700 flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    <span>{{ __('No disponible') }} ({{ $noDisponiblesCount }})</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="w-full bg-slate-200/80 h-2 rounded-full overflow-hidden flex">
                                            <div class="bg-emerald-500 h-full transition-all duration-500" style="width: {{ $porcentajeConvocados }}%" title="{{ __('Convocats') }}: {{ $convocadosCount }}"></div>
                                            <div class="bg-amber-400 h-full transition-all duration-500" style="width: {{ $porcentajeDudas }}%" title="{{ __('Té dubtes') }}: {{ $dudasCount }}"></div>
                                            <div class="bg-rose-500 h-full transition-all duration-500" style="width: {{ $porcentajeNoDisp }}%" title="{{ __('No disponible') }}: {{ $noDisponiblesCount }}"></div>
                                        </div>
                                    </div>
                                @elseif ($actuacion->musicos > 0)
                                    <div class="bg-surface-subtle rounded-2xl p-2.5 space-y-1 border border-indigo-50/60">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-600 font-semibold flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-primary text-[16px]">groups</span>
                                                {{ __('Plantilla prevista') }}
                                            </span>
                                            <span class="font-extrabold text-primary">
                                                {{ $actuacion->musicos }} {{ __('músics') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                {{-- Gestión de Disponibilidad rápida (Dudas y No Disponible) --}}
                                @if ($currentUser)
                                    <div class="flex flex-col gap-1.5 pt-1 border-t border-indigo-50/70">
                                        @if ($usuarioConvocado)
                                            {{-- Músico CONVOCADO por la dirección: NO puede indicar que no asiste ni dudas --}}
                                            <div id="banner-convocado-{{ $actuacion->id }}" 
                                                 class="flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold shadow-xs">
                                                <span class="material-symbols-outlined text-[18px] text-status-available">verified</span>
                                                <div class="flex flex-col">
                                                    <span>{{ __('Estàs convocat') }}</span>
                                                    <span class="text-[10.5px] font-medium text-emerald-700">{{ __('Assistència confirmada per la direcció') }}</span>
                                                </div>
                                            </div>
                                        @elseif ($fueraDePlazo)
                                            {{-- Fuera de plazo por antelación --}}
                                            <div class="px-3 py-2 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-amber-900 text-xs flex items-center gap-2">
                                                <span class="material-symbols-outlined text-amber-600 text-[18px] shrink-0">lock_clock</span>
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-[11px]">{{ __('Termini de canvi tancat') }}</span>
                                                    <span class="text-[10px] text-amber-700">{{ __('Menys de :dias dies d\'antelació. Contacta amb direcció.', ['dias' => $limiteAntelacion]) }}</span>
                                                </div>
                                            </div>
                                        @else
                                            {{-- Botones interactivos de Duda y No asistencia --}}
                                            <div class="grid grid-cols-2 gap-2 bg-surface-subtle p-1.5 rounded-2xl">
                                                <button type="button" 
                                                    id="btn-status-duda-{{ $actuacion->id }}" 
                                                    onclick="setCalendarAttendance('duda', {{ $listaId ? $listaId : 'null' }}, {{ $currentUser->id }}, {{ $actuacion->id }})"
                                                    class="flex items-center justify-center gap-1 py-2 px-2.5 rounded-xl text-xs font-bold transition-all active:scale-95 {{ $userDispState === 'duda' ? 'bg-status-pending text-white shadow-sm ring-2 ring-amber-300/40' : 'text-slate-600 hover:bg-white border border-transparent hover:border-amber-200' }}"
                                                    title="{{ __('Notifica que no saps segur si podràs assistir') }}">
                                                    <span class="material-symbols-outlined text-[16px]">help</span>
                                                    <span class="truncate">{{ __('Tinc dubtes') }}</span>
                                                </button>

                                                <button type="button" 
                                                    id="btn-status-no-{{ $actuacion->id }}" 
                                                    onclick="setCalendarAttendance('no', {{ $listaId ? $listaId : 'null' }}, {{ $currentUser->id }}, {{ $actuacion->id }})"
                                                    class="flex items-center justify-center gap-1 py-2 px-2.5 rounded-xl text-xs font-bold transition-all active:scale-95 {{ $userDispState === 'no' ? 'bg-status-unavailable text-white shadow-sm ring-2 ring-rose-300/40' : 'text-slate-600 hover:bg-white border border-transparent hover:border-rose-200' }}"
                                                    title="{{ __('Comunica la teua baixa') }}">
                                                    <span class="material-symbols-outlined text-[16px]">cancel</span>
                                                    <span class="truncate">{{ __('No puc assistir') }}</span>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                {{-- Pie con acciones --}}
                                <div class="pt-3 border-t border-indigo-50 flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        @if ($actuacion->comments()->count() > 0)
                                            <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}#messages"
                                                class="inline-flex items-center gap-1 text-xs font-bold text-primary bg-indigo-50 px-2.5 py-1 rounded-xl">
                                                <span class="material-symbols-outlined text-[15px]">forum</span>
                                                {{ $actuacion->comments()->count() }}
                                            </a>
                                        @endif

                                        @can('admin')
                                            @if ($esHoy || $fechaAct->isFuture())
                                                <button type="button" 
                                                    class="enviarNotificacion text-slate-400 hover:text-amber-500 p-1.5 rounded-xl hover:bg-indigo-50 transition"
                                                    title="{{ __('Notificar al grup') }}"
                                                    data-actuacion-id="{{ $actuacion->id }}"
                                                    data-actuacion-inf="{{ $actuacion->descripcion }}">
                                                    <span class="material-symbols-outlined text-[18px]">campaign</span>
                                                </button>
                                            @endif
                                            <a href="{{ route('actuacion.edit', ['actuacion' => $actuacion]) }}" 
                                                class="text-slate-400 hover:text-primary p-1.5 rounded-xl hover:bg-indigo-50 transition"
                                                title="{{ __('Editar actuació') }}">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                            </a>
                                        @endcan
                                    </div>

                                    <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}"
                                        class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-xl bg-primary hover:bg-primary-dark text-white text-xs font-bold shadow-sm transition active:scale-95">
                                        <span>{{ __('Veure detalls') }}</span>
                                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white border border-indigo-50 shadow-bento rounded-3xl p-12 text-center max-w-xl mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-primary mx-auto flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[32px]">event_busy</span>
                </div>
                <h3 class="text-lg font-bold font-headline text-on-surface mb-1">
                    {{ __('No hi ha actuacions programades') }}
                </h3>
                <p class="text-xs text-slate-500 mb-6">
                    {{ __('No s\'han trobat esdeveniments amb els criteris seleccionats.') }}
                </p>
                <a href="{{ route('actuacion.index') }}" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-xs font-bold rounded-2xl shadow-sm transition">
                    {{ __('Veure totes les actuacions') }}
                </a>
            </div>
        @endforelse
    </div>

    <x-subscription-info />

    {{-- Overlay de Carga Difuminado (Backdrop Blur) para Disponibilidad --}}
    <div id="calendar-loading-overlay" 
         class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-slate-900/40 backdrop-blur-md transition-all duration-300 opacity-0 pointer-events-none"
         aria-hidden="true">
        <div class="bg-white rounded-3xl p-6 shadow-2xl border border-indigo-50 flex flex-col items-center gap-3.5 max-w-xs mx-4 text-center transform scale-95 transition-transform duration-300">
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

    {{-- SCRIPT PARA GESTIÓN DE DISPONIBILIDAD DESDE EL CALENDARIO --}}
    <script>
        function showCalendarLoading(show) {
            const overlay = document.getElementById('calendar-loading-overlay');
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

        function setCalendarAttendance(choice, listaId, userId, actuacionId) {
            showCalendarLoading(true);

            const payload = {
                usuario_id: userId,
                actuacion_id: actuacionId,
                estado: choice
            };
            if (listaId) {
                payload.lista_id = listaId;
            }

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
                showCalendarLoading(false);
                console.error('Error al actualitzar disponibilitat:', err);
                if (typeof showToast === 'function') {
                    showToast({ message: err.message || 'Error al actualitzar disponibilitat', alert_type: 'error' });
                } else {
                    alert(err.message || 'Error al actualitzar disponibilitat');
                }
            });
        }
    </script>

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
