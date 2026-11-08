<div class="w-full mx-auto rounded-xl bg-white p-4 shadow-sm border border-gray-100">
    <div class="mb-4 flex items-center justify-between border-b border-gray-100 pb-3">
        <div class="flex items-center gap-2">
            <div class="rounded-lg bg-cyan-100 p-2 text-cyan-700">
                <span class="text-lg leading-none">🎉</span>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ __('actividades.title') }}</h3>
                <p class="text-xs text-gray-500">{{ __('actividades.subtitle') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if ($actividades->isNotEmpty())
                <span class="rounded-full bg-cyan-50 px-2.5 py-0.5 text-xs font-semibold text-cyan-700">
                    {{ $actividades->count() }}
                </span>
            @endif
            <a href="{{ route('actividades.index') }}"
                class="inline-flex items-center text-xs font-semibold text-cyan-600 hover:text-cyan-800 transition">
                <span>{{ __('Ver todas') }}</span>
                <svg class="w-3.5 h-3.5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

    @if ($actividades->isEmpty())
        <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50/50 p-6 text-center text-xs text-gray-500">
            <span class="text-3xl block mb-1">🍽️</span>
            <p class="font-medium text-gray-700">{{ __('actividades.no_activities') }}</p>
            <p class="text-gray-400 mt-0.5">{{ __('actividades.no_activities_sub') }}</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach ($actividades as $act)
                @php
                    $miInscripcion = $act->inscripciones->first();
                    $puedeApuntarse = $act->puedeInscribirse();
                @endphp
                <div class="rounded-xl border border-gray-200/80 bg-gradient-to-b from-white to-gray-50/40 p-4 shadow-2xs hover:shadow-sm hover:border-cyan-300 transition flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex items-start justify-between gap-2">
                            <span class="text-2xl p-1.5 rounded-lg bg-gray-50 border border-gray-100">{{ $act->icono }}</span>
                            @if ($miInscripcion)
                                @if ($miInscripcion->asiste)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        ✓ {{ __('actividades.already_inscribed') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        ✗ {{ __('actividades.not_attending_badge') }}
                                    </span>
                                @endif
                            @elseif ($puedeApuntarse)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-cyan-100 text-cyan-800">
                                    {{ __('actividades.status.abierta') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-gray-100 text-gray-600">
                                    {{ __('actividades.status.plazo_finalizado') }}
                                </span>
                            @endif
                        </div>

                        <div>
                            <h4 class="font-bold text-sm text-gray-900 line-clamp-1">{{ $act->titulo }}</h4>
                            <div class="text-xs text-gray-500 mt-1 flex flex-col gap-0.5">
                                <span class="flex items-center gap-1">
                                    <span>📅</span>
                                    <span>{{ $act->fecha->translatedFormat('d M Y, H:i') }} h</span>
                                </span>
                                @if ($act->lugar)
                                    <span class="flex items-center gap-1 truncate text-gray-600">
                                        <span>📍</span>
                                        <span class="truncate">{{ $act->lugar }}</span>
                                    </span>
                                @endif
                                <span class="flex items-center gap-1 text-rose-500 text-[11px]">
                                    <span>⏰</span>
                                    <span>{{ __('actividades.deadline') }}: {{ $act->fecha_limite_inscripcion->translatedFormat('d M, H:i') }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-700">
                            @if ($miInscripcion && $miInscripcion->asiste)
                                @if ($act->es_de_pago)
                                    <span class="text-emerald-700 font-bold">{{ number_format((float) $miInscripcion->total, 2, ',', '.') }} €</span>
                                @else
                                    <span class="text-emerald-700 font-bold">✓ {{ __('actividades.confirmed_badge') }}</span>
                                @endif
                            @elseif ($miInscripcion && ! $miInscripcion->asiste)
                                <span class="text-slate-500 font-medium italic">{{ __('actividades.not_attending_badge') }}</span>
                            @else
                                @if ($act->es_de_pago)
                                    {{ $act->opciones->count() }} {{ __('opcions') }}
                                @else
                                    <span class="text-cyan-700 font-medium">{{ __('actividades.free_individual_badge') }}</span>
                                @endif
                            @endif
                        </span>

                        <a href="{{ route('actividades.show', $act) }}"
                            class="inline-flex items-center rounded-lg bg-cyan-600 px-3 py-1.5 text-xs font-semibold text-white shadow-2xs hover:bg-cyan-500 transition">
                            @if ($miInscripcion)
                                {{ __('actividades.see_booking') }}
                            @elseif ($puedeApuntarse)
                                {{ __('actividades.inscribe') }}
                            @else
                                {{ __('actividades.see_details') }}
                            @endif
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
