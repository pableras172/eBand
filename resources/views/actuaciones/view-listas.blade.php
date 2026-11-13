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

    <div class="space-y-6 pb-28">
        {{-- Módulo de Filtros y Búsqueda (Neo-Bento Violet) --}}
        <div class="bg-white border border-indigo-50 shadow-bento rounded-3xl p-4 lg:p-5">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 border-b border-indigo-50 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[20px]">filter_list</span>
                    </div>
                    <div>
                        <h2 class="text-xs font-bold text-on-surface uppercase tracking-wider">
                            {{ __('Filtres del Calendari') }}
                        </h2>
                        <p class="text-xs text-slate-500">
                            {{ __('Filtra per tipus, data o localitat de l\'esdeveniment') }}
                        </p>
                    </div>
                </div>

                {{-- Filtro por Fecha --}}
                <form action="{{ route('actuaciones-fecha') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <label for="fecha" class="text-xs font-semibold text-slate-600">
                        {{ __('Des de:') }}
                    </label>
                    <input type="date" id="fecha" name="fecha" 
                        value="{{ request('fecha', $filtroFecha ?? '') }}"
                        onchange="if(this.value) this.form.submit()"
                        class="bg-surface-subtle border border-indigo-100 text-on-surface text-xs rounded-xl px-3 py-2 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"
                        min="{{ now()->subMonths(3)->format('Y-m-d') }}"
                        max="{{ now()->format('Y-m-d') }}">
                    <button type="submit" class="inline-flex items-center px-3.5 py-2 bg-primary hover:bg-primary-dark text-white text-xs font-bold rounded-xl shadow-sm transition-colors">
                        {{ __('Filtrar') }}
                    </button>
                    @if(isset($filtroFecha) || isset($filtrotipo) || isset($filtropobla))
                        <a href="{{ route('actuacion.index') }}" class="inline-flex items-center px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">
                            {{ __('Netejar tots') }}
                        </a>
                    @endif
                </form>
            </div>

            {{-- Chips de Filtrado por Tipo --}}
            <div class="pt-4 space-y-3">
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

                {{-- Chips de Filtrado por Población --}}
                @if(isset($poblaciones) && count($poblaciones) > 0)
                    <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-indigo-50">
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
                                } catch (\Throwable $e) {}
                            }

                            $fechaAct = \Carbon\Carbon::parse($actuacion->fechaActuacion);
                            $esHoy = $fechaAct->isToday();
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

                                    {{-- Estado Asistencia personal --}}
                                    @if ($estaEnLista)
                                        @if ($noDisponible)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-xs font-bold bg-status-unavailable text-white shadow-sm">
                                                <span class="material-symbols-outlined text-[14px]">cancel</span>
                                                {{ __('No assistisc') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-xs font-bold bg-status-available text-white shadow-sm">
                                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                                {{ __('Confirmant') }}
                                                @if ($pivot && (int) $pivot->coche === 1)
                                                    <span>🚗</span>
                                                @endif
                                            </span>
                                        @endif
                                    @endif
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
                            <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between space-y-3">
                                <div>
                                    <h3 class="text-base font-bold font-headline text-on-surface group-hover:text-primary transition-colors line-clamp-2">
                                        {{ $actuacion->descripcion }}
                                    </h3>
                                    @if ($actuacion->contrato?->descripcion)
                                        <p class="text-xs text-slate-500 mt-1 line-clamp-1">
                                            {{ $actuacion->contrato->descripcion }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Quórum de músicos requeridos --}}
                                @if ($actuacion->musicos > 0)
                                    <div class="bg-surface-subtle rounded-2xl p-3 space-y-1.5 border border-indigo-50/60">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-600 font-semibold flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-primary text-[16px]">groups</span>
                                                {{ __('Convocatòria plantilla') }}
                                            </span>
                                            <span class="font-extrabold text-primary">
                                                {{ $actuacion->musicos }} {{ __('músics') }}
                                            </span>
                                        </div>
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
                                        <span>{{ __('Convocatòria') }}</span>
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
