<div class="max-w-7xl mx-auto py-4 px-2 pb-24 sm:px-6 lg:px-8 space-y-6">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <span>🎉</span> {{ __('actividades.title') }}
                </h1>
                <p class="text-sm text-gray-600">{{ __('actividades.subtitle') }}</p>
            </div>
            @can('admin')
                <a href="{{ route('admin.actividades.index') }}"
                    class="inline-flex items-center rounded-lg border border-cyan-300 bg-cyan-50 px-3.5 py-2 text-xs font-semibold text-cyan-800 shadow-sm hover:bg-cyan-100 transition">
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
            class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ $filtroTipo === '' ? 'bg-cyan-600 text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
            {{ __('actividades.types.all') }}
        </button>
        <button type="button" wire:click="$set('filtroTipo', 'comida')"
            class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ $filtroTipo === 'comida' ? 'bg-cyan-600 text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
            🍽️ {{ __('actividades.types.comida') }}
        </button>
        <button type="button" wire:click="$set('filtroTipo', 'cena')"
            class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ $filtroTipo === 'cena' ? 'bg-cyan-600 text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
            🍷 {{ __('actividades.types.cena') }}
        </button>
        <button type="button" wire:click="$set('filtroTipo', 'excursion')"
            class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ $filtroTipo === 'excursion' ? 'bg-cyan-600 text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200' }}">
            🚌 {{ __('actividades.types.excursion') }}
        </button>
    </div>

    <!-- Grid de Actividades -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($actividades as $act)
            @php
                $miInscripcion = $act->inscripciones->first();
                $puedeApuntarse = $act->puedeInscribirse();
            @endphp
            <div wire:key="card-actividad-{{ $act->id }}"
                class="rounded-2xl bg-white shadow-sm border border-gray-100 hover:shadow-md transition flex flex-col justify-between overflow-hidden">
                <div class="p-6 space-y-4">
                    <div class="flex items-start justify-between gap-3">
                        <span class="text-3xl p-3 rounded-2xl bg-gray-50 shadow-xs">{{ $act->icono }}</span>
                        <div class="flex flex-col items-end gap-1">
                            @if ($miInscripcion)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                    ✓ {{ __('actividades.already_inscribed') }} ({{ number_format((float) $miInscripcion->total, 2, ',', '.') }} €)
                                </span>
                            @elseif ($puedeApuntarse)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-800">
                                    {{ __('actividades.status.abierta') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                    {{ __('actividades.status.plazo_finalizado') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-gray-900 leading-snug">{{ $act->titulo }}</h2>
                        @if ($act->descripcion)
                            <p class="text-xs text-gray-600 line-clamp-2 mt-1">{{ $act->descripcion }}</p>
                        @endif
                    </div>

                    <div class="space-y-2 text-xs text-gray-600 pt-2 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-400">📅</span>
                            <span class="font-medium text-gray-900">{{ $act->fecha->translatedFormat('l, d F Y') }}</span>
                            <span>{{ __('a les') }} {{ $act->fecha->format('H:i') }} h</span>
                        </div>

                        @if ($act->lugar)
                            <div class="flex items-center gap-2">
                                <span class="text-gray-400">📍</span>
                                <span class="truncate">{{ $act->lugar }}</span>
                            </div>
                        @endif

                        <div class="flex items-center gap-2 text-rose-600">
                            <span>⏰</span>
                            <span>{{ __('actividades.deadline') }}: {{ $act->fecha_limite_inscripcion->translatedFormat('d M Y, H:i') }} h</span>
                        </div>
                    </div>

                    <!-- Muestra de opciones -->
                    <div class="pt-2 border-t border-gray-100">
                        <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider block mb-1.5">
                            {{ __('actividades.options_available') }}:
                        </span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($act->opciones as $op)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs bg-gray-50 border border-gray-200 text-gray-700">
                                    {{ $op->titulo }} <strong class="ml-1 text-gray-900">{{ number_format((float) $op->precio, 2, ',', '.') }} €</strong>
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gray-50/70 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs text-gray-500">
                        {{ $act->opciones->count() }} {{ __('opcions') }}
                    </span>

                    <a href="{{ route('actividades.show', $act) }}"
                        class="inline-flex items-center rounded-lg bg-cyan-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-cyan-500 transition">
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
            <div class="col-span-full py-16 text-center">
                <span class="text-5xl block mb-2">🍽️</span>
                <p class="font-bold text-gray-900 text-base">{{ __('actividades.no_activities') }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ __('actividades.no_activities_sub') }}</p>
            </div>
        @endforelse
    </div>
</div>
