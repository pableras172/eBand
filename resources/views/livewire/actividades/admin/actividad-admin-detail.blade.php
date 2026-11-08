<div class="max-w-7xl mx-auto py-4 px-2 pb-24 sm:px-6 lg:px-8 space-y-6">
    <x-slot name="header">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                <a href="{{ route('admin.actividades.index') }}" class="hover:text-cyan-600 transition">{{ __('actividades.title') }}</a>
                <span>/</span>
                <span class="text-gray-700 font-medium">{{ __('actividades.dashboard_title') }}</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <span>{{ $actividad->icono }}</span> {{ $actividad->titulo }}
            </h1>
        </div>
    </x-slot>

    <!-- Barra de acciones y metadatos dentro del componente Livewire -->
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="space-y-1">
            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                <span class="flex items-center gap-1 font-semibold text-gray-800">
                    <span>📅</span> {{ $actividad->fecha->translatedFormat('d M Y, H:i') }} h
                </span>
                @if ($actividad->lugar)
                    <span>•</span>
                    <span class="flex items-center gap-1">
                        <span>📍</span> {{ $actividad->lugar }}
                    </span>
                @endif
                <span>•</span>
                <span class="flex items-center gap-1 text-rose-600 font-medium">
                    <span>⏰</span> {{ __('actividades.deadline') }}: {{ $actividad->fecha_limite_inscripcion->translatedFormat('d M Y, H:i') }} h
                </span>
                @if ($actividad->notified_at)
                    <span>•</span>
                    <span class="text-indigo-600 font-medium">🔔 {{ __('actividades.notified_at', ['date' => $actividad->notified_at->translatedFormat('d M Y, H:i')]) }}</span>
                @endif
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button type="button" wire:click="openCreateInscripcionModal"
                class="inline-flex items-center rounded-lg bg-cyan-600 px-3.5 py-2 text-xs font-semibold text-white shadow-sm hover:bg-cyan-500 transition cursor-pointer">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                {{ __('actividades.register_member_or_guest') }}
            </button>

            <button type="button" wire:click="notificarOneSignal"
                wire:confirm="{{ __('actividades.confirm_notify') }}"
                title="{{ __('actividades.notify_onesignal') }}"
                class="inline-flex items-center rounded-lg bg-indigo-600 px-3.5 py-2 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 transition cursor-pointer">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                {{ __('actividades.notify_onesignal') }}
            </button>

            <a href="{{ route('actividades.show', $actividad) }}" target="_blank"
                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                {{ __('actividades.view_as_musician') }}
            </a>

            <a href="{{ route('admin.actividades.export', $actividad) }}"
                class="inline-flex items-center rounded-lg bg-emerald-600 px-3.5 py-2 text-xs font-semibold text-white shadow-sm hover:bg-emerald-500 transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ __('actividades.export_excel') }}
            </a>

            <a href="{{ route('admin.actividades.edit', $actividad) }}"
                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                {{ __('Editar') }}
            </a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($actividad->es_de_pago)
        <!-- Bloque de Recuento de Platos / Opciones (Para el restaurante o proveedor) -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div>
                    <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <span>🍽️</span> {{ __('actividades.metrics_provider_title') }}
                    </h2>
                    <p class="text-xs text-gray-500">{{ __('actividades.metrics_provider_sub') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700">
                        {{ $totalPersonasInscritas }} {{ __('actividades.total_inscriptions') }}
                    </span>
                    @if ($totalNoAsisten > 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700">
                            {{ $totalNoAsisten }} {{ __('actividades.total_not_attending') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @forelse ($recuentoOpciones as $rec)
                    <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">
                                {{ $rec['titulo'] }}
                            </span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-black text-gray-900">{{ $rec['cantidad'] }}</span>
                                <span class="text-xs text-gray-500 font-medium">{{ __('actividades.units') }}</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-200/80 flex items-center justify-between text-xs text-gray-600">
                            <span>{{ number_format((float) $rec['precio'], 2, ',', '.') }} € / ud.</span>
                            <span class="font-bold text-gray-800">{{ number_format((float) $rec['importe'], 2, ',', '.') }} €</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-6 text-sm text-gray-500">
                        {{ __('No hay opciones configuradas.') }}
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Métricas Financieras y de Cobro -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-1">
                    {{ __('actividades.total_predicted') }}
                </span>
                <div class="text-2xl font-black text-gray-900">
                    {{ number_format((float) $totalPrevisto, 2, ',', '.') }} €
                </div>
                <p class="text-[11px] text-gray-500 mt-1">{{ __('actividades.total_predicted_sub') }}</p>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm border border-emerald-100 bg-emerald-50/30">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 block mb-1">
                    {{ __('actividades.total_collected') }}
                </span>
                <div class="text-2xl font-black text-emerald-700">
                    {{ number_format((float) $totalCobrado, 2, ',', '.') }} €
                </div>
                <p class="text-[11px] text-emerald-600 mt-1">
                    @if ($totalPrevisto > 0)
                        {{ number_format(($totalCobrado / $totalPrevisto) * 100, 1) }}% cobrado
                    @else
                        0%
                    @endif
                </p>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm border border-amber-100 bg-amber-50/30">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600 block mb-1">
                    {{ __('actividades.total_pending') }}
                </span>
                <div class="text-2xl font-black text-amber-700">
                    {{ number_format((float) $totalPendiente, 2, ',', '.') }} €
                </div>
                <p class="text-[11px] text-amber-600 mt-1">{{ __('actividades.total_pending_sub') }}</p>
            </div>
        </div>
    @else
        <!-- Bloque de Métricas de Asistencia para Actividades Individuales / Sin Precio -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-emerald-100 bg-emerald-50/20 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 block mb-1">
                        ✓ {{ __('actividades.total_confirmed_attending') }}
                    </span>
                    <div class="text-3xl font-black text-emerald-800">
                        {{ $totalPersonasInscritas }}
                    </div>
                    <p class="text-xs text-emerald-600 mt-1">{{ __('Músicos que han confirmado asistencia.') }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">
                    🎺
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm border border-rose-100 bg-rose-50/20 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-700 block mb-1">
                        ✗ {{ __('actividades.total_declined_attending') }}
                    </span>
                    <div class="text-3xl font-black text-rose-800">
                        {{ $totalNoAsisten }}
                    </div>
                    <p class="text-xs text-rose-600 mt-1">{{ __('Músicos que han indicado que no acudirán.') }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center text-3xl">
                    🙅‍♂️
                </div>
            </div>
        </div>
    @endif

    <!-- Tabla Detallada de Inscritos -->
    <div class="rounded-2xl bg-white shadow-sm border border-gray-100 overflow-hidden space-y-4 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ __('actividades.nominal_list') }}</h2>
                <p class="text-xs text-gray-500">{{ __('actividades.nominal_list_sub') }}</p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button" wire:click="openCreateInscripcionModal"
                    class="inline-flex items-center rounded-lg bg-cyan-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-cyan-500 transition cursor-pointer">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    {{ __('actividades.register_member_or_guest') }}
                </button>

                <input type="text" wire:model.live.debounce.300ms="searchInscritos" placeholder="{{ __('actividades.search_musician') }}"
                    class="rounded-lg border-gray-300 text-xs shadow-sm focus:border-cyan-500 focus:ring-cyan-500 w-44" />

                <select wire:model.live="filtroPago"
                    class="rounded-lg border-gray-300 text-xs shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                    <option value="">{{ __('actividades.status.all') }}</option>
                    <option value="asiste">{{ __('actividades.filter_attending') }}</option>
                    <option value="no_asiste">{{ __('actividades.filter_not_attending') }}</option>
                    <option value="pendiente">{{ __('actividades.only_pending') }}</option>
                    <option value="pagado">{{ __('actividades.only_paid') }}</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto -mx-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('actividades.musician') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('actividades.selected_options') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('actividades.allergies_notes') }}</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Total') }}</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Estado') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($inscritos as $ins)
                        <tr wire:key="inscrito-{{ $ins->id }}" class="hover:bg-gray-50/60 transition {{ !$ins->asiste ? 'bg-slate-50/50 opacity-80' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-sm {{ $ins->asiste ? 'text-gray-900' : 'text-gray-600 line-through decoration-rose-400' }}">{{ $ins->nombre_completo }}</span>
                                    @if (!$ins->asiste)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                            ✗ {{ __('actividades.not_attending_badge') }}
                                        </span>
                                    @elseif (!$ins->user_id)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ __('actividades.external_or_no_account') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 flex items-center gap-2 mt-0.5">
                                    <span>{{ $ins->fecha_inscripcion->translatedFormat('d M Y, H:i') }}</span>
                                    @if ($ins->user && $ins->user->email)
                                        <span>•</span>
                                        <span class="text-gray-400">{{ $ins->user->email }}</span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @if ($ins->asiste)
                                    @if ($actividad->es_de_pago)
                                        <div class="space-y-1">
                                            @foreach ($ins->items as $item)
                                                <div class="text-xs text-gray-800 flex items-center gap-1.5">
                                                    <span class="inline-flex items-center justify-center font-bold px-1.5 py-0.5 rounded-sm bg-gray-100 text-gray-700">
                                                        {{ $item->cantidad }}x
                                                    </span>
                                                    <span>{{ $item->opcion->titulo ?? 'Opción' }}</span>
                                                    <span class="text-gray-400">({{ number_format((float) $item->subtotal, 2, ',', '.') }} €)</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-800 border border-cyan-200">
                                            🎺 {{ __('actividades.free_individual_badge') }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-xs text-rose-600 font-semibold italic">
                                        {{ __('actividades.not_attending_badge') }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if ($ins->asiste && $ins->observaciones_alergias)
                                    <div class="p-2 rounded-lg bg-amber-50 border border-amber-200 text-xs text-amber-900 max-w-xs">
                                        ⚠️ {{ $ins->observaciones_alergias }}
                                    </div>
                                @elseif (!$ins->asiste)
                                    <span class="text-xs text-gray-400 italic">-</span>
                                @else
                                    <span class="text-xs text-gray-400 italic">{{ __('actividades.no_allergies') }}</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-sm {{ $ins->asiste ? 'text-gray-900' : 'text-gray-400' }}">
                                @if ($actividad->es_de_pago)
                                    {{ number_format((float) $ins->total, 2, ',', '.') }} €
                                @else
                                    <span class="text-gray-400 font-normal">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if (!$ins->asiste)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                        {{ __('actividades.not_attending_badge') }}
                                    </span>
                                @elseif (! $actividad->es_de_pago)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        ✓ {{ __('actividades.confirmed_badge') }}
                                    </span>
                                @elseif ($ins->pagado)
                                    <button type="button" wire:click="marcarPendiente({{ $ins->id }})"
                                        title="{{ __('Pulsar para desmarcar') }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 hover:bg-emerald-200 transition">
                                        <span>✓ {{ __('actividades.payment_status.pagado') }}</span>
                                        @if ($ins->metodo_pago)
                                            <span class="text-[10px] uppercase opacity-75">({{ $ins->metodo_pago }})</span>
                                        @endif
                                    </button>
                                @else
                                    <button type="button" wire:click="openPaymentModal({{ $ins->id }})"
                                        title="{{ __('Pulsar para registrar el cobro') }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 hover:bg-amber-200 transition">
                                        <span>⏳ {{ __('actividades.payment_status.pendiente_short') }}</span>
                                    </button>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs space-x-2">
                                <button type="button" wire:click="openEditInscripcionModal({{ $ins->id }})"
                                    class="text-cyan-600 hover:text-cyan-800 font-medium transition">
                                    {{ __('Editar') }}
                                </button>
                                <button type="button" wire:click="eliminarInscripcion({{ $ins->id }})"
                                    wire:confirm="{{ __('actividades.confirm_cancel_registration', ['name' => $ins->nombre_completo]) }}"
                                    class="text-rose-500 hover:text-rose-700 font-medium transition">
                                    {{ __('actividades.cancel_registration') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-xs text-gray-500">
                                {{ __('No hi ha inscripcions registrades.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Registrar / Editar Inscripción (Admin) -->
    @if ($showingInscripcionModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-xl space-y-5 border border-gray-100 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">
                            {{ $editingInscripcionId ? __('actividades.edit_registration') : __('actividades.register_member_or_guest') }}
                        </h3>
                        <p class="text-xs text-gray-500">{{ __('actividades.register_member_or_guest_sub') }}</p>
                    </div>
                    <button type="button" wire:click="$set('showingInscripcionModal', false)" class="text-gray-400 hover:text-gray-600">
                        ✕
                    </button>
                </div>

                <!-- Tipo de Asistente -->
                <div class="space-y-3">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-700">{{ __('actividades.attendee_type') }}</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2.5 p-3 rounded-xl border {{ $tipoAsistente === 'miembro' ? 'border-cyan-500 bg-cyan-50/40 text-cyan-900 font-semibold ring-1 ring-cyan-500' : 'border-gray-200 hover:bg-gray-50 text-gray-700' }} cursor-pointer text-xs transition">
                            <input type="radio" wire:model.live="tipoAsistente" value="miembro" class="text-cyan-600 focus:ring-cyan-500" />
                            <span>👥 {{ __('actividades.band_member') }}</span>
                        </label>
                        <label class="flex items-center gap-2.5 p-3 rounded-xl border {{ $tipoAsistente === 'manual' ? 'border-cyan-500 bg-cyan-50/40 text-cyan-900 font-semibold ring-1 ring-cyan-500' : 'border-gray-200 hover:bg-gray-50 text-gray-700' }} cursor-pointer text-xs transition">
                            <input type="radio" wire:model.live="tipoAsistente" value="manual" class="text-cyan-600 focus:ring-cyan-500" />
                            <span>👤 {{ __('actividades.external_or_no_account') }}</span>
                        </label>
                    </div>

                    @if ($tipoAsistente === 'miembro')
                        <div class="mt-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">{{ __('actividades.select_member') }}</label>
                            <select wire:model="selectedUserId" class="w-full rounded-lg border-gray-300 text-xs shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                <option value="">{{ __('actividades.select_member_placeholder') }}</option>
                                @foreach ($usuariosDisponibles as $usr)
                                    <option value="{{ $usr->id }}">{{ $usr->name }} ({{ $usr->email }})</option>
                                @endforeach
                            </select>
                            @error('selectedUserId') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    @else
                        <div class="mt-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">{{ __('actividades.guest_name_label') }}</label>
                            <input type="text" wire:model="nombreManual" placeholder="{{ __('actividades.guest_name_placeholder') }}"
                                class="w-full rounded-lg border-gray-300 text-xs shadow-sm focus:border-cyan-500 focus:ring-cyan-500" />
                            @error('nombreManual') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    @endif
                </div>

                @if ($actividad->es_de_pago)
                    <!-- Selección de Menús / Opciones con Cantidades -->
                    <div class="space-y-3 pt-3 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-700">{{ __('actividades.selected_options') }}</label>
                            <span class="text-xs font-bold text-cyan-700">{{ number_format($totalCalculado, 2, ',', '.') }} €</span>
                        </div>

                        <div class="space-y-2">
                            @foreach ($actividad->opciones as $opc)
                                <div class="flex items-center justify-between p-3 rounded-xl border border-gray-200 bg-gray-50/50">
                                    <div class="pr-2">
                                        <div class="text-xs font-bold text-gray-900">{{ $opc->titulo }}</div>
                                        <div class="text-[11px] text-gray-500">{{ number_format((float) $opc->precio, 2, ',', '.') }} € / ud.</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button" wire:click="decrementarCantidad({{ $opc->id }})"
                                            class="w-7 h-7 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 flex items-center justify-center font-bold text-sm">
                                            -
                                        </button>
                                        <input type="number" wire:model.live="cantidades.{{ $opc->id }}" min="0"
                                            class="w-14 text-center rounded-lg border-gray-300 text-xs py-1 font-bold focus:border-cyan-500 focus:ring-cyan-500" />
                                        <button type="button" wire:click="incrementarCantidad({{ $opc->id }})"
                                            class="w-7 h-7 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 flex items-center justify-center font-bold text-sm">
                                            +
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('cantidades') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Alergias y Observaciones -->
                    <div class="space-y-2 pt-3 border-t border-gray-100">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-700">{{ __('actividades.allergies_notes') }}</label>
                        <textarea wire:model="observaciones_alergias" rows="2" placeholder="{{ __('actividades.allergies_placeholder') }}"
                            class="w-full rounded-lg border-gray-300 text-xs shadow-sm focus:border-cyan-500 focus:ring-cyan-500"></textarea>
                    </div>

                    <!-- Estado del Pago Inicial -->
                    <div class="space-y-3 pt-3 border-t border-gray-100">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model.live="marcarPagado" class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500" />
                            <span class="text-xs font-semibold text-gray-800">{{ __('actividades.mark_paid_now') }}</span>
                        </label>

                        @if ($marcarPagado)
                            <div class="p-3 rounded-xl bg-gray-50 border border-gray-200 space-y-2">
                                <label class="block text-[11px] font-semibold text-gray-600 uppercase">{{ __('actividades.payment_method_used') }}</label>
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <label class="flex items-center gap-1.5 p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" wire:model="metodoPago" value="efectivo" class="text-cyan-600 focus:ring-cyan-500" />
                                        <span>💶 {{ __('actividades.payment_methods.efectivo') }}</span>
                                    </label>
                                    <label class="flex items-center gap-1.5 p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" wire:model="metodoPago" value="bizum" class="text-cyan-600 focus:ring-cyan-500" />
                                        <span>📱 {{ __('actividades.payment_methods.bizum') }}</span>
                                    </label>
                                    <label class="flex items-center gap-1.5 p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" wire:model="metodoPago" value="transferencia" class="text-cyan-600 focus:ring-cyan-500" />
                                        <span>🏦 {{ __('actividades.payment_methods.transferencia') }}</span>
                                    </label>
                                    <label class="flex items-center gap-1.5 p-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" wire:model="metodoPago" value="otro" class="text-cyan-600 focus:ring-cyan-500" />
                                        <span>{{ __('actividades.payment_methods.otro') }}</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="text-xs text-gray-500">
                            {{ __('Total') }}: <span class="text-sm font-bold text-gray-900">{{ number_format($totalCalculado, 2, ',', '.') }} €</span>
                        </div>

                        <div class="flex gap-2">
                            <button type="button" wire:click="$set('showingInscripcionModal', false)"
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                {{ __('actividades.cancel') }}
                            </button>
                            <button type="button" wire:click="guardarInscripcion"
                                class="rounded-lg bg-cyan-600 px-4 py-2 text-xs font-semibold text-white hover:bg-cyan-500 shadow-sm transition">
                                {{ __('actividades.save_changes') }}
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Modalidad Individual Sin Precio: Confirmación Directa -->
                    <div class="pt-3 border-t border-gray-100 space-y-3">
                        <div class="p-4 rounded-xl bg-cyan-50/70 border border-cyan-200 text-xs text-cyan-900 flex items-start gap-3">
                            <span class="text-xl">🎺</span>
                            <div class="space-y-1">
                                <span class="font-bold block text-sm">{{ __('actividades.free_individual_badge') }}</span>
                                <p>{{ __('Al guardar, el asistente quedará registrado en la lista de confirmados (asistencia: Sí) sin coste.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-2">
                            <button type="button" wire:click="$set('showingInscripcionModal', false)"
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                {{ __('actividades.cancel') }}
                            </button>
                            <button type="button" wire:click="guardarInscripcion"
                                class="rounded-lg bg-cyan-600 px-5 py-2 text-xs font-semibold text-white hover:bg-cyan-500 shadow-sm transition">
                                {{ __('actividades.save_changes') }}
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Modal Registrar Pago Rápido -->
    @if ($showingPaymentModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl space-y-4 border border-gray-100">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-900">{{ __('actividades.record_payment') }}</h3>
                    <button type="button" wire:click="$set('showingPaymentModal', false)" class="text-gray-400 hover:text-gray-600">
                        ✕
                    </button>
                </div>

                <div class="space-y-3">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-700">{{ __('actividades.payment_method_used') }}</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 p-2.5 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer text-sm">
                            <input type="radio" wire:model="modalMetodoPago" value="bizum" class="text-cyan-600 focus:ring-cyan-500" />
                            <span>📱 {{ __('actividades.payment_methods.bizum') }}</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer text-sm">
                            <input type="radio" wire:model="modalMetodoPago" value="efectivo" class="text-cyan-600 focus:ring-cyan-500" />
                            <span>💶 {{ __('actividades.payment_methods.efectivo') }}</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer text-sm">
                            <input type="radio" wire:model="modalMetodoPago" value="transferencia" class="text-cyan-600 focus:ring-cyan-500" />
                            <span>🏦 {{ __('actividades.payment_methods.transferencia') }}</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer text-sm">
                            <input type="radio" wire:model="modalMetodoPago" value="otro" class="text-cyan-600 focus:ring-cyan-500" />
                            <span>{{ __('actividades.payment_methods.otro') }}</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t border-gray-100">
                    <button type="button" wire:click="$set('showingPaymentModal', false)"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                        {{ __('actividades.cancel') }}
                    </button>
                    <button type="button" wire:click="guardarPago"
                        class="rounded-lg bg-cyan-600 px-4 py-2 text-xs font-semibold text-white hover:bg-cyan-500 shadow-sm">
                        {{ __('actividades.mark_as_paid') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
