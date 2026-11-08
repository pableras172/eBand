<div class="max-w-4xl mx-auto py-6 px-4 pb-28 sm:px-6 lg:px-8 space-y-6">
    <!-- Header de navegación y retorno -->
    <div class="flex items-center justify-between">
        <a href="{{ route('actividades.index') }}"
            class="inline-flex items-center text-xs font-semibold text-gray-500 hover:text-cyan-600 transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            {{ __('actividades.nav') }}
        </a>

        @can('admin')
            <a href="{{ route('admin.actividades.detail', $actividad) }}"
                class="inline-flex items-center text-xs font-semibold text-cyan-700 hover:text-cyan-800 bg-cyan-50 px-3 py-1.5 rounded-lg border border-cyan-200 transition">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ __('actividades.dashboard_title') }}
            </a>
        @endcan
    </div>

    @if (session()->has('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tarjeta Principal con Información del Evento -->
    <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div class="flex items-start gap-4">
                <span class="text-4xl p-3 bg-gray-50 rounded-2xl shadow-xs">{{ $actividad->icono }}</span>
                <div class="space-y-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                        {{ __('actividades.types.' . $actividad->tipo) }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">
                        {{ $actividad->titulo }}
                    </h1>
                </div>
            </div>

            @if ($miInscripcion)
                @if ($miInscripcion->asiste)
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 self-start">
                        <span>✓ {{ __('actividades.already_inscribed') }}</span>
                    </div>
                @else
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 self-start border border-slate-200">
                        <span>✗ {{ __('actividades.not_attending_badge') }}</span>
                    </div>
                @endif
            @endif
        </div>

        @if ($actividad->descripcion)
            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed bg-gray-50/50 p-5 rounded-2xl border border-gray-100">
                {!! str_contains($actividad->descripcion, '<') ? $actividad->descripcion : nl2br(e($actividad->descripcion)) !!}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-gray-100 text-sm">
            <div class="space-y-0.5">
                <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider block">{{ __('actividades.event_date') }}</span>
                <span class="font-bold text-gray-900">{{ $actividad->fecha->translatedFormat('d M Y, H:i') }} h</span>
            </div>

            @if ($actividad->lugar)
                <div class="space-y-0.5">
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider block">{{ __('actividades.place') }}</span>
                    <span class="font-medium text-gray-800">{{ $actividad->lugar }}</span>
                </div>
            @endif

            <div class="space-y-0.5">
                <span class="text-xs text-rose-500 font-semibold uppercase tracking-wider block">{{ __('actividades.deadline_label') }}</span>
                <span class="font-bold text-rose-600">{{ $actividad->fecha_limite_inscripcion->translatedFormat('d M Y, H:i') }} h</span>
            </div>
        </div>
    </div>

    <!-- CASO 1: EL MÚSICO ASISTE (Resumen e Instrucciones) -->
    @if ($miInscripcion && $miInscripcion->asiste && ! $cambiandoRespuesta)
        @if ($actividad->es_de_pago)
            <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-sm border border-emerald-100 space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span>🧾</span> {{ __('actividades.registration_summary') }}
                    </h2>
                    <span class="text-xs text-gray-500">
                        {{ __('actividades.registered_on') }} {{ $miInscripcion->fecha_inscripcion->translatedFormat('d M Y, H:i') }}
                    </span>
                </div>

                <!-- Desglose de opciones contratadas -->
                <div class="space-y-3">
                    @foreach ($miInscripcion->items as $item)
                        <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 border border-gray-100 text-sm">
                            <div class="flex items-center gap-3">
                                <span class="font-extrabold text-cyan-700 bg-cyan-100/70 px-2 py-0.5 rounded-md text-xs">
                                    {{ $item->cantidad }}x
                                </span>
                                <div>
                                    <span class="font-semibold text-gray-900">{{ $item->opcion->titulo ?? 'Opción' }}</span>
                                    @if ($item->opcion && $item->opcion->descripcion)
                                        <p class="text-xs text-gray-500">{{ $item->opcion->descripcion }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-bold text-gray-900">{{ number_format((float) $item->subtotal, 2, ',', '.') }} €</span>
                                <div class="text-[11px] text-gray-400">
                                    {{ number_format((float) $item->precio_unitario, 2, ',', '.') }} € / ud.
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total y Estado de Pago -->
                <div class="p-5 rounded-2xl bg-gradient-to-r from-gray-50 to-gray-100/60 border border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">{{ __('actividades.total_amount') }}</span>
                        <span class="text-3xl font-black text-gray-900">{{ number_format((float) $miInscripcion->total, 2, ',', '.') }} €</span>
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($miInscripcion->pagado)
                            <div class="px-4 py-2 rounded-xl bg-emerald-100 border border-emerald-300 text-emerald-800 text-xs font-bold flex items-center gap-1.5 shadow-xs">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ __('actividades.payment_status.pagado') }} {{ $miInscripcion->metodo_pago ? '('.strtoupper($miInscripcion->metodo_pago).')' : '' }}</span>
                            </div>
                        @else
                            <div class="px-4 py-2 rounded-xl bg-amber-100 border border-amber-300 text-amber-800 text-xs font-bold flex items-center gap-1.5 shadow-xs">
                                <span>⏳ {{ __('actividades.payment_status.pendiente') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Alergias u Observaciones registradas -->
                @if ($miInscripcion->observaciones_alergias)
                    <div class="p-4 rounded-xl bg-amber-50/70 border border-amber-200 text-xs text-amber-900 space-y-1">
                        <span class="font-bold uppercase tracking-wider block">{{ __('actividades.allergies_title') }}:</span>
                        <p class="leading-relaxed">{{ $miInscripcion->observaciones_alergias }}</p>
                    </div>
                @endif

                <!-- Instrucciones de Pago -->
                @if ($actividad->instrucciones_pago && ! $miInscripcion->pagado)
                    <div class="p-5 rounded-2xl bg-cyan-50/70 border border-cyan-200 text-xs text-cyan-900 space-y-2">
                        <div class="font-bold flex items-center gap-2 text-sm text-cyan-950">
                            <span>💳</span> {{ __('actividades.payment_instructions') }}:
                        </div>
                        <p class="whitespace-pre-line leading-relaxed text-cyan-900 font-medium">
                            {{ $actividad->instrucciones_pago }}
                        </p>
                    </div>
                @endif

                <!-- Botón para indicar que finalmente no va si está dentro del plazo y no ha pagado -->
                @if ($actividad->puedeInscribirse() && ! $miInscripcion->pagado)
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-500">{{ __('actividades.no_direct_edit_notice') }}</span>
                        <button type="button" wire:click="indicarNoVoy"
                            wire:confirm="{{ __('actividades.confirm_decline') }}"
                            class="text-xs font-semibold text-rose-600 hover:text-rose-800 transition flex items-center gap-1.5 py-1 px-2.5 rounded-lg border border-rose-200 hover:bg-rose-50">
                            <span>❌</span>
                            <span>{{ __('actividades.change_to_not_attending') }}</span>
                        </button>
                    </div>
                @else
                    <div class="text-xs text-gray-500 bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start gap-2">
                        <span class="text-base leading-none">ℹ️</span>
                        <span>
                            {{ __('actividades.no_direct_edit_notice') }}
                        </span>
                    </div>
                @endif
            </div>
        @else
            <!-- Tarjeta de Asistencia Confirmada para Actividad Individual sin Coste -->
            <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-sm border border-emerald-100 space-y-5 text-center sm:text-left">
                <div class="flex flex-col sm:flex-row items-center sm:items-start justify-between gap-4 border-b border-gray-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl text-emerald-700">
                            ✓
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">{{ __('actividades.attendance_confirmed_title') }}</h2>
                            <p class="text-xs text-gray-500">{{ __('actividades.registered_on') }} {{ $miInscripcion->fecha_inscripcion->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                        ✓ {{ __('actividades.confirmed_badge') }}
                    </span>
                </div>

                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ __('actividades.attendance_confirmed_sub') }}
                </p>

                @if ($actividad->puedeInscribirse())
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-end">
                        <button type="button" wire:click="indicarNoVoy"
                            wire:confirm="{{ __('actividades.confirm_decline') }}"
                            class="text-xs font-semibold text-rose-600 hover:text-rose-800 transition flex items-center gap-1.5 py-2 px-3 rounded-xl border border-rose-200 hover:bg-rose-50">
                            <span>❌</span>
                            <span>{{ __('actividades.change_opinion_decline') }}</span>
                        </button>
                    </div>
                @endif
            </div>
        @endif

    <!-- CASO 2: EL MÚSICO INDICÓ "NO VOY" -->
    @elseif ($miInscripcion && ! $miInscripcion->asiste && ! $cambiandoRespuesta)
        <div class="rounded-3xl bg-white p-8 shadow-sm border border-slate-200 text-center space-y-4">
            <span class="text-5xl block">🙅‍♂️</span>
            <h2 class="text-xl font-bold text-gray-900">{{ __('actividades.declined_card_title') }}</h2>
            <p class="text-xs text-gray-500 max-w-md mx-auto leading-relaxed">
                {{ __('actividades.declined_card_sub') }}
            </p>

            @if ($actividad->puedeInscribirse())
                <div class="pt-3">
                    <button type="button" wire:click="toggleCambiarRespuesta"
                        class="rounded-xl bg-cyan-600 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-cyan-500 transition">
                        {{ __('actividades.change_opinion_inscribe') }}
                    </button>
                </div>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 mt-2">
                    {{ __('actividades.status.plazo_finalizado') }}
                </span>
            @endif
        </div>

    <!-- CASO 3: FORMULARIO DE INSCRIPCIÓN (O CAMBIO DE RESPUESTA) -->
    @else
        @if (! $actividad->puedeInscribirse())
            <div class="rounded-3xl bg-white p-8 text-center shadow-sm border border-gray-100 space-y-3">
                <span class="text-5xl block">⏰</span>
                <h2 class="text-xl font-bold text-gray-900">{{ __('actividades.registration_closed') }}</h2>
                <p class="text-sm text-gray-600 max-w-md mx-auto">
                    {{ __('actividades.registration_closed_notice') }}
                </p>
            </div>
        @else
            @if ($actividad->es_de_pago)
                <!-- FORMULARIO DE INSCRIPCIÓN REACTIVO CON OPCIONES Y PRECIOS -->
                <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <span>📝</span> {{ __('actividades.registration_form') }}
                            </h2>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ __('actividades.registration_form_sub') }}
                            </p>
                        </div>

                        @if ($cambiandoRespuesta)
                            <button type="button" wire:click="toggleCambiarRespuesta"
                                class="text-xs font-semibold text-gray-500 hover:text-gray-800 transition">
                                {{ __('actividades.cancel') }}
                            </button>
                        @endif
                    </div>

                    @error('error')
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 font-medium">
                            {{ $message }}
                        </div>
                    @enderror

                    @error('cantidades')
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 font-medium">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Lista de opciones seleccionables -->
                    <div class="space-y-4">
                        @foreach ($actividad->opciones as $op)
                            @php
                                $qty = $cantidades[$op->id] ?? 0;
                                $subtotalOpcion = $qty * (float) $op->precio;
                            @endphp
                            <div wire:key="select-opcion-{{ $op->id }}"
                                class="p-4 rounded-2xl border transition {{ $qty > 0 ? 'border-cyan-400 bg-cyan-50/30' : 'border-gray-200 bg-gray-50/50' }} flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-base text-gray-900">{{ $op->titulo }}</span>
                                        <span class="text-xs font-semibold text-cyan-700 bg-cyan-100/70 px-2 py-0.5 rounded-full">
                                            {{ number_format((float) $op->precio, 2, ',', '.') }} €
                                        </span>
                                    </div>
                                    @if ($op->descripcion)
                                        <p class="text-xs text-gray-600">{{ $op->descripcion }}</p>
                                    @endif
                                </div>

                                <!-- Selector de Cantidad -->
                                <div class="flex items-center justify-between sm:justify-end gap-4">
                                    <div class="flex items-center border border-gray-300 rounded-xl bg-white shadow-xs overflow-hidden">
                                        <button type="button" wire:click="decrementarCantidad({{ $op->id }})"
                                            class="px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition font-bold disabled:opacity-40"
                                            {{ $qty <= 0 ? 'disabled' : '' }}>
                                            −
                                        </button>
                                        <span class="px-4 py-2 text-sm font-bold text-gray-900 min-w-[2.5rem] text-center">
                                            {{ $qty }}
                                        </span>
                                        <button type="button" wire:click="incrementarCantidad({{ $op->id }})"
                                            class="px-3 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition font-bold">
                                            +
                                        </button>
                                    </div>

                                    <div class="text-right min-w-[5rem]">
                                        <span class="text-xs text-gray-400 block font-medium">{{ __('Subtotal') }}</span>
                                        <span class="font-extrabold text-sm {{ $subtotalOpcion > 0 ? 'text-cyan-700' : 'text-gray-400' }}">
                                            {{ number_format($subtotalOpcion, 2, ',', '.') }} €
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Campo Alergias / Observaciones (Visible en comidas y cenas) -->
                    @if ($actividad->requiereAlergias())
                        <div class="pt-4 border-t border-gray-100 space-y-2">
                            <label for="observaciones_alergias" class="block text-sm font-semibold text-gray-900">
                                {{ __('actividades.allergies_title') }}
                            </label>
                            <p class="text-xs text-gray-500">
                                {{ __('actividades.allergies_sub') }}
                            </p>
                            <textarea id="observaciones_alergias" rows="3" wire:model="observaciones_alergias"
                                placeholder="{{ __('actividades.allergies_placeholder') }}"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm"></textarea>
                        </div>
                    @endif

                    <!-- Total Dinámico y Botones de Acción -->
                    <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">{{ __('actividades.total_amount') }}</span>
                            <span class="text-3xl font-black text-gray-900">
                                {{ number_format($totalCalculado, 2, ',', '.') }} €
                            </span>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            @if ($cambiandoRespuesta)
                                <button type="button" wire:click="toggleCambiarRespuesta"
                                    class="w-full sm:w-auto rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                                    {{ __('actividades.cancel') }}
                                </button>
                            @else
                                <button type="button" wire:click="indicarNoVoy"
                                    wire:confirm="{{ __('actividades.confirm_decline') }}"
                                    class="w-full sm:w-auto rounded-xl border border-rose-200 bg-rose-50 px-5 py-3 text-sm font-bold text-rose-700 hover:bg-rose-100 transition flex items-center justify-center gap-2">
                                    <span>❌</span>
                                    <span>{{ __('actividades.btn_not_attending') }}</span>
                                </button>
                            @endif

                            <button type="button" wire:click="inscribirme"
                                wire:loading.attr="disabled"
                                {{ $totalCalculado <= 0 ? 'disabled' : '' }}
                                class="w-full sm:w-auto rounded-xl bg-cyan-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-cyan-500 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ __('actividades.confirm_registration') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <!-- FORMULARIO SIMPLIFICADO: ACTIVIDAD INDIVIDUAL SIN PRECIO (SÍ / NO) -->
                <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <span>🎺</span> {{ __('actividades.attendance_confirmation_title') }}
                            </h2>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ __('actividades.attendance_confirmation_desc') }}
                            </p>
                        </div>

                        @if ($cambiandoRespuesta)
                            <button type="button" wire:click="toggleCambiarRespuesta"
                                class="text-xs font-semibold text-gray-500 hover:text-gray-800 transition">
                                {{ __('actividades.cancel') }}
                            </button>
                        @endif
                    </div>

                    @error('error')
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 font-medium">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="p-5 rounded-2xl bg-cyan-50/50 border border-cyan-100 flex items-center gap-3">
                        <span class="text-3xl">ℹ️</span>
                        <div class="text-xs text-cyan-900 leading-relaxed">
                            <span class="font-bold block text-sm mb-0.5">{{ __('actividades.free_individual_badge') }}</span>
                            <span>{{ __('Indica a continuación si vas a participar en este evento para que la dirección pueda organizar la asistencia.') }}</span>
                        </div>
                    </div>

                    <!-- Botones de Decisión Sí / No -->
                    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                        @if ($cambiandoRespuesta)
                            <button type="button" wire:click="toggleCambiarRespuesta"
                                class="w-full sm:w-auto rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                                {{ __('actividades.cancel') }}
                            </button>
                        @endif

                        <button type="button" wire:click="indicarNoVoy"
                            wire:confirm="{{ __('actividades.confirm_decline') }}"
                            class="w-full sm:w-auto rounded-xl border border-rose-200 bg-rose-50 px-6 py-3.5 text-sm font-bold text-rose-700 hover:bg-rose-100 transition flex items-center justify-center gap-2 cursor-pointer shadow-xs">
                            <span class="text-base">❌</span>
                            <span>{{ __('actividades.btn_not_attending') }}</span>
                        </button>

                        <button type="button" wire:click="inscribirme"
                            wire:loading.attr="disabled"
                            class="w-full sm:w-auto rounded-xl bg-cyan-600 px-7 py-3.5 text-sm font-bold text-white shadow-sm hover:bg-cyan-500 transition flex items-center justify-center gap-2 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ __('actividades.btn_confirm_attendance') }}</span>
                        </button>
                    </div>
                </div>
            @endif
        @endif
    @endif
</div>
