<div class="max-w-7xl mx-auto py-4 px-2 pb-24 sm:px-6 lg:px-8 space-y-6">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.actividades.index') }}" class="hover:text-cyan-600 transition">{{ __('actividades.title') }}</a>
                    <span>/</span>
                    <span class="text-gray-700 font-medium">{{ __('actividades.dashboard_title') }}</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <span>{{ $actividad->icono }}</span> {{ $actividad->titulo }}
                </h1>
                <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mt-1">
                    <span>📅 {{ $actividad->fecha->translatedFormat('d M Y, H:i') }} h</span>
                    @if ($actividad->lugar)
                        <span>•</span>
                        <span>📍 {{ $actividad->lugar }}</span>
                    @endif
                    <span>•</span>
                    <span>⏰ {{ __('actividades.deadline') }}: {{ $actividad->fecha_limite_inscripcion->translatedFormat('d M Y, H:i') }} h</span>
                    @if ($actividad->notified_at)
                        <span>•</span>
                        <span class="text-indigo-600 font-medium">🔔 {{ __('actividades.notified_at', ['date' => $actividad->notified_at->translatedFormat('d M Y, H:i')]) }}</span>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button" wire:click="notificarOneSignal"
                    wire:confirm="{{ __('actividades.confirm_notify') }}"
                    title="{{ __('actividades.notify_onesignal') }}"
                    class="inline-flex items-center rounded-lg bg-indigo-600 px-3.5 py-2 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
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
    </x-slot>

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

    <!-- Bloque de Recuento de Platos / Opciones (Para el restaurante o proveedor) -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                    <span>🍽️</span> {{ __('actividades.metrics_provider_title') }}
                </h2>
                <p class="text-xs text-gray-500">{{ __('actividades.metrics_provider_sub') }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700">
                {{ $totalPersonasInscritas }} {{ __('actividades.total_inscriptions') }}
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @forelse ($recuentoOpciones as $rec)
                <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">
                            {{ $rec['titulo'] }}
                        </span>
                        <div class="text-2xl font-black text-gray-900">
                            {{ $rec['cantidad'] }} <span class="text-xs font-normal text-gray-500">{{ __('actividades.units') }}</span>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-t border-gray-200/60 flex items-center justify-between text-xs text-gray-600">
                        <span>{{ number_format($rec['precio'], 2, ',', '.') }} € / ud.</span>
                        <span class="font-semibold text-gray-900">{{ number_format($rec['importe'], 2, ',', '.') }} €</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-4 text-center text-xs text-gray-500">
                    {{ __('No hi ha opcions configurades.') }}
                </div>
            @endforelse
        </div>
    </div>

    <!-- Bloque de Balance Financiero -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1">{{ __('actividades.total_predicted') }}</span>
            <div class="text-2xl font-bold text-gray-900">
                {{ number_format($totalPrevisto, 2, ',', '.') }} €
            </div>
            <p class="text-xs text-gray-500 mt-1">{{ __('actividades.total_predicted_sub') }}</p>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600 block mb-1">{{ __('actividades.total_collected') }}</span>
            <div class="text-2xl font-bold text-emerald-700">
                {{ number_format($totalCobrado, 2, ',', '.') }} €
            </div>
            <p class="text-xs text-emerald-600/80 mt-1">
                @if ($totalPrevisto > 0)
                    {{ round(($totalCobrado / $totalPrevisto) * 100) }}% {{ __('recaudado') }}
                @else
                    0%
                @endif
            </p>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm border border-gray-100">
            <span class="text-xs font-semibold uppercase tracking-wider text-amber-600 block mb-1">{{ __('actividades.total_pending') }}</span>
            <div class="text-2xl font-bold text-amber-700">
                {{ number_format($totalPendiente, 2, ',', '.') }} €
            </div>
            <p class="text-xs text-amber-600/80 mt-1">{{ __('actividades.total_pending_sub') }}</p>
        </div>
    </div>

    <!-- Tabla Detallada de Inscritos -->
    <div class="rounded-2xl bg-white shadow-sm border border-gray-100 overflow-hidden space-y-4 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ __('actividades.nominal_list') }}</h2>
                <p class="text-xs text-gray-500">{{ __('actividades.nominal_list_sub') }}</p>
            </div>

            <div class="flex items-center gap-3">
                <input type="text" wire:model.live.debounce.300ms="searchInscritos" placeholder="{{ __('actividades.search_musician') }}"
                    class="rounded-lg border-gray-300 text-xs shadow-sm focus:border-cyan-500 focus:ring-cyan-500 w-48" />

                <select wire:model.live="filtroPago"
                    class="rounded-lg border-gray-300 text-xs shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                    <option value="">{{ __('actividades.status.all') }}</option>
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
                        <tr wire:key="inscrito-{{ $ins->id }}" class="hover:bg-gray-50/60 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-semibold text-sm text-gray-900">{{ $ins->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $ins->fecha_inscripcion->translatedFormat('d M Y, H:i') }}</div>
                            </td>

                            <td class="px-6 py-4">
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
                            </td>

                            <td class="px-6 py-4">
                                @if ($ins->observaciones_alergias)
                                    <div class="p-2 rounded-lg bg-amber-50 border border-amber-200 text-xs text-amber-900 max-w-xs">
                                        ⚠️ {{ $ins->observaciones_alergias }}
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">{{ __('actividades.no_allergies') }}</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-sm text-gray-900">
                                {{ number_format((float) $ins->total, 2, ',', '.') }} €
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($ins->pagado)
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

                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                                <button type="button" wire:click="eliminarInscripcion({{ $ins->id }})"
                                    wire:confirm="{{ __('actividades.confirm_cancel_registration', ['name' => $ins->user->name]) }}"
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

    <!-- Modal Registrar Pago -->
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
