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

            <div class="flex items-center gap-2">
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

    {{-- Alertas de Disponibilidad y Antelación --}}
    <div class="space-y-3 mb-6">
        @if ($usuarioDisponible && $antelacion->days <= $limiteAntelacion)
            <div class="bg-amber-50 border border-amber-200 rounded-3xl p-4 flex items-center gap-3 text-amber-900 text-xs shadow-sm">
                <span class="material-symbols-outlined text-amber-600 text-[20px] shrink-0">warning</span>
                <span>{{ __('No es pot canviar la disponibilitat amb pocs dies d\'antelació. Si tens una incidència greu, contacta amb la direcció.') }}</span>
            </div>
        @endif

        @if (!$usuarioDisponible)
            <div class="bg-rose-50 border border-rose-200 rounded-3xl p-4 flex items-center justify-between gap-3 text-rose-900 text-xs shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                        <span class="material-symbols-outlined text-[18px]">cancel</span>
                    </div>
                    <div>
                        <span class="font-bold text-sm block">{{ __('Has comunicat que NO estàs disponible per a aquesta actuació.') }}</span>
                        <p class="text-[11px] text-rose-700 mt-0.5">{{ __('La teua absència està registrada en el còmput de la plantilla.') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Layout Principal Master-Detail: 12 columnas en Desktop, 1 columna en Móvil --}}
    <div class="lg:grid lg:grid-cols-12 lg:gap-8 space-y-6 lg:space-y-0 pb-32">

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
                            <span id="musics_count" class="text-primary text-sm font-black">{{ $totalFilas }}</span> / {{ $actuacion->musicos > 0 ? $actuacion->musicos : '--' }} {{ __('músics') }}
                        </span>
                    </div>

                    @php
                        $porcentajeQuorum = ($actuacion->musicos > 0 && $totalFilas > 0) ? min(100, round(($totalFilas / $actuacion->musicos) * 100)) : 0;
                    @endphp
                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-primary to-cyan-500 h-2 rounded-full transition-all duration-500" style="width: {{ $porcentajeQuorum }}%"></div>
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
                <div class="p-4 sm:p-5 border-b border-indigo-50 flex items-center justify-between bg-surface-subtle">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[20px]">groups</span>
                        </div>
                        <div>
                            <h2 class="text-xs font-bold font-headline text-on-surface uppercase tracking-wider">
                                {{ __('Plantilla per Cordes') }}
                            </h2>
                            <p class="text-xs text-slate-500">
                                {{ __('Distribució d\'instruments i assignació de transport') }}
                            </p>
                        </div>
                    </div>

                    @livewire('preview-listas', ['id' => $actuacion->id])
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

    {{-- BOTONERA FIJA INFERIOR (Floating Glass Bento Command Bar) --}}
    <div id="driver-botonera"></div>
    <footer class="fixed bottom-0 left-0 right-0 z-30 bg-white/90 backdrop-blur-2xl border-t border-slate-200/80 py-3 px-4 shadow-glass">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
            
            {{-- Botón Volver --}}
            <a href="{{ route('actuacion.index') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-surface-subtle hover:bg-slate-100 text-slate-700 text-xs font-bold border border-indigo-100 transition">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
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
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-status-unavailable hover:bg-rose-600 text-white text-xs sm:text-sm font-bold shadow-md shadow-rose-500/20 transition-all active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">cancel</span>
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
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-status-available hover:bg-emerald-600 text-white text-xs sm:text-sm font-bold shadow-md shadow-emerald-500/20 transition-all active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
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
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-2xl bg-surface-subtle hover:bg-rose-50 text-slate-700 hover:text-rose-600 text-xs font-bold border border-slate-200 transition"
                            title="{{ __('Buidar convocatòria') }}">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                            <span class="hidden md:inline">{{ __('Buidar') }}</span>
                        </button>

                        {{-- Botón Avisar Seleccionados --}}
                        <button id="avisarMarcados" type="button" data-lista-id="{{ $lista->id }}"
                            onclick="enviarNotif({{ $lista->id }},'{{ json_encode($actuacion->descripcion) }}')"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-primary hover:bg-primary-dark text-white text-xs font-bold shadow-sm transition active:scale-95"
                            title="{{ __('Notificar a la plantilla convocada') }}">
                            <span class="material-symbols-outlined text-[16px]">campaign</span>
                            <span class="hidden md:inline">{{ __('Avisar') }}</span>
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
