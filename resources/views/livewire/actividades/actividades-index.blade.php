<div class="max-w-7xl mx-auto py-4 px-2 pb-28 sm:px-6 lg:px-8 space-y-6">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <span class="text-xl">🎉</span>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('actividades.title') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('actividades.title') }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">{{ __('actividades.subtitle') }}</p>
                </div>
            </div>
            @can('admin')
                <a href="{{ route('admin.actividades.index') }}"
                    class="inline-flex items-center rounded-2xl border border-indigo-100 bg-white px-3.5 py-2 text-xs font-bold text-indigo-700 shadow-xs hover:bg-indigo-50 transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ __('actividades.dashboard_title') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <!-- Pestañas / Filtro por tipo -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1">
        <button type="button" wire:click="$set('filtroTipo', '')"
            class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ $filtroTipo === '' ? 'bg-indigo-600 text-white shadow-bento-glow' : 'bg-white text-slate-700 hover:bg-slate-50 border border-indigo-50/80 shadow-xs' }}">
            {{ __('actividades.types.all') }}
        </button>
        <button type="button" wire:click="$set('filtroTipo', 'comida')"
            class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ $filtroTipo === 'comida' ? 'bg-indigo-600 text-white shadow-bento-glow' : 'bg-white text-slate-700 hover:bg-slate-50 border border-indigo-50/80 shadow-xs' }}">
            🍽️ {{ __('actividades.types.comida') }}
        </button>
        <button type="button" wire:click="$set('filtroTipo', 'cena')"
            class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ $filtroTipo === 'cena' ? 'bg-indigo-600 text-white shadow-bento-glow' : 'bg-white text-slate-700 hover:bg-slate-50 border border-indigo-50/80 shadow-xs' }}">
            🍷 {{ __('actividades.types.cena') }}
        </button>
        <button type="button" wire:click="$set('filtroTipo', 'concierto')"
            class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ $filtroTipo === 'concierto' ? 'bg-indigo-600 text-white shadow-bento-glow' : 'bg-white text-slate-700 hover:bg-slate-50 border border-indigo-50/80 shadow-xs' }}">
            🎺 {{ __('actividades.types.concierto') }}
        </button>
        <button type="button" wire:click="$set('filtroTipo', 'excursion')"
            class="px-4 py-2 rounded-2xl text-xs font-bold transition {{ $filtroTipo === 'excursion' ? 'bg-indigo-600 text-white shadow-bento-glow' : 'bg-white text-slate-700 hover:bg-slate-50 border border-indigo-50/80 shadow-xs' }}">
            🚌 {{ __('actividades.types.excursion') }}
        </button>
    </div>

    <!-- Grid de Actividades (Neo-Bento Violet) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($actividades as $act)
            @php
                $miInscripcion = $act->inscripciones->first();
                $puedeApuntarse = $act->puedeInscribirse();
            @endphp
            <div wire:key="card-actividad-{{ $act->id }}"
                class="rounded-3xl bg-white shadow-bento border border-indigo-50/80 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                <div class="p-6 space-y-4">
                    <div class="flex items-start justify-between gap-3">
                        <span class="text-3xl p-3 rounded-2xl bg-[#F5F6FC] border border-indigo-50 shadow-xs">{{ $act->icono }}</span>
                        <div class="flex flex-col items-end gap-1">
                            @if ($miInscripcion)
                                @if ($miInscripcion->asiste)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/70">
                                        ✓ {{ __('actividades.already_inscribed') }} @if($act->es_de_pago) ({{ number_format((float) $miInscripcion->total, 2, ',', '.') }} €) @endif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        ✗ {{ __('actividades.not_attending_badge') }}
                                    </span>
                                @endif
                            @elseif ($puedeApuntarse)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ __('actividades.status.abierta') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                    {{ __('actividades.status.plazo_finalizado') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold font-headline text-slate-900 leading-snug">{{ $act->titulo }}</h2>
                        @if ($act->descripcion)
                            <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ strip_tags($act->descripcion) }}</p>
                        @endif
                    </div>

                    <div class="space-y-2 text-xs text-slate-600 pt-2 border-t border-indigo-50">
                        <div class="flex items-center gap-2">
                            <span class="text-slate-400">📅</span>
                            <span class="font-bold text-slate-800">{{ $act->fecha->translatedFormat('l, d F Y') }}</span>
                            <span>{{ __('a les') }} {{ $act->fecha->format('H:i') }} h</span>
                        </div>

                        @if ($act->lugar)
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400">📍</span>
                                <span class="truncate">{{ $act->lugar }}</span>
                            </div>
                        @endif

                        <div class="flex items-center gap-2 text-rose-600 font-semibold">
                            <span>⏰</span>
                            <span>{{ __('actividades.deadline') }}: {{ $act->fecha_limite_inscripcion->translatedFormat('d M Y, H:i') }} h</span>
                        </div>
                    </div>

                    <!-- Muestra de opciones / Modalidad -->
                    <div class="pt-2 border-t border-indigo-50">
                        @if ($act->es_de_pago)
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1.5">
                                {{ __('actividades.options_available') }}:
                            </span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach ($act->opciones as $op)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs bg-[#F5F6FC] border border-indigo-100/70 text-slate-700">
                                        {{ $op->titulo }} <strong class="ml-1 text-slate-900">{{ number_format((float) $op->precio, 2, ',', '.') }} €</strong>
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <div class="flex items-center gap-1.5">
                                <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold bg-cyan-50 border border-cyan-200 text-cyan-800">
                                    🎺 {{ __('actividades.free_individual_badge') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="p-4 bg-[#F5F6FC]/70 border-t border-indigo-50 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-500">
                        @if ($act->es_de_pago)
                            {{ $act->opciones->count() }} {{ __('opcions') }}
                        @else
                            {{ __('actividades.modality_free_title') }}
                        @endif
                    </span>

                    <a href="{{ route('actividades.show', $act) }}"
                        class="inline-flex items-center rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow-sm hover:bg-indigo-700 transition">
                        @if ($miInscripcion)
                            {{ __('actividades.see_booking') }}
                        @elseif ($puedeApuntarse)
                            {{ __('actividades.inscribe') }}
                        @else
                            {{ __('actividades.see_details') }}
                        @endif
                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-indigo-50 shadow-bento">
                <span class="text-5xl block mb-2">🍽️</span>
                <p class="font-bold text-slate-900 text-base">{{ __('actividades.no_activities') }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ __('actividades.no_activities_sub') }}</p>
            </div>
        @endforelse
    </div>
</div>
