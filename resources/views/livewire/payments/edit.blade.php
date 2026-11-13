<div class="mx-auto max-w-7xl space-y-6 px-2 py-4 sm:px-4 lg:px-6 pb-28">

    {{-- HEADER Y BREADCRUMBS --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        @can('admin')
                            <x-ui.breadcrumbs.link href="{{ route('payments.index') }}">{{ __('Liquidacions') }}</x-ui.breadcrumbs.link>
                        @endcan
                        @cannot('admin')
                            <x-ui.breadcrumbs.link href="{{ route('payments.user', [Auth::user()->id]) }}">{{ __('Les Meues Liquidacions') }}</x-ui.breadcrumbs.link>
                        @endcannot
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Detall del Pagament') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-3 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ $payment->descripcion }}
                        </h1>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Liquidació econòmica individualitzada de concerts, actuacions i desplaçaments') }}
                    </p>
                </div>
            </div>

            {{-- BADGE DE ESTADO --}}
            <div class="flex items-center">
                @if ($pendiente)
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold shadow-xs">
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>✓ {{ __('Liquidat i confirmat') }}</span>
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold shadow-xs">
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <span>⏳ {{ __('Pendent de confirmació') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    {{-- NOTIFICACIONES Y TOASTS --}}
    <x-ui.toast timeout=5000 on="saved">{{ __('common.pagocreado') }}</x-ui.toast>
    <x-ui.toast timeout=5000 on="confirmed">{{ __('S\'ha confirmat la liquidació correctament.') }}</x-ui.toast>
    <x-ui.toast timeout=5000 on="notconfirmed">{{ __('La liquidació s\'ha marcat com a pendent.') }}</x-ui.toast>
    <x-ui.toast timeout=5000 on="incidencia-resuelta">{{ __('Incidència resolta i total recalculat correctament.') }}</x-ui.toast>
    <x-ui.toast timeout=5000 on="user-porcentaje-updated">{{ __('S\'ha actualitzat el percentatge del músic i recalculat la liquidació.') }}</x-ui.toast>
    <x-ui.toast timeout=5000 color="red" on="errorobservaciones">{{ __('Has d\'indicar una observació o motiu de desconformitat.') }}</x-ui.toast>
    <x-ui.toast timeout=5000 on="email-sent">{{ __('Email amb el detall enviat correctament.') }}</x-ui.toast>
    <x-ui.toast timeout=5000 color="red" on="email-error">{{ __('Error en enviar el correu electrònic.') }}</x-ui.toast>

    {{-- OVERLAY DE CARGA DIFUMINADO (BACKDROP BLUR) AL CONFIRMAR O INDICAR INCIDENCIA --}}
    <div wire:loading.flex wire:target="confirm,noConfirmar,resolverIncidencia,saveUserPorcentaje"
         class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-slate-900/40 backdrop-blur-md transition-all duration-300"
         style="display: none;"
         aria-hidden="true">
        <div class="bg-white rounded-3xl p-6 shadow-2xl border border-indigo-50 flex flex-col items-center gap-3.5 max-w-xs mx-4 text-center transform scale-100 transition-transform duration-300">
            <div class="relative w-12 h-12 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-4 border-indigo-100"></div>
                <div class="absolute inset-0 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin"></div>
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-800">
                    {{ __('Actualitzant liquidació...') }}
                </p>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ __('Processant l\'estat de conformitat del pagament') }}
                </p>
            </div>
        </div>
    </div>

    {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title">
            <span class="text-slate-900 font-headline">{{ __('Eliminar registre de liquidació') }}</span>
        </x-slot>

        <x-slot name="content">
            <p class="text-slate-600 text-sm">
                {{ __('Estàs segur que vols eliminar aquest registre de liquidació complet?') }}
            </p>
            <p class="mt-2 rounded-2xl bg-[#F5F6FC] border border-indigo-100 px-3 py-2 text-xs font-bold text-rose-600">
                {{ $payment->descripcion }}
            </p>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-2xl transition"
                wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel·lar') }}
            </button>

            <button type="button" class="ml-3 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-2xl shadow-sm transition"
                wire:click="delete({{ $payment->id }})" wire:loading.attr="disabled">
                {{ __('Eliminar definitivament') }}
            </button>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- TARJETA RESUMEN NEO-BENTO (DATOS PRINCIPALES) --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-5 sm:p-6 shadow-bento space-y-6">

        {{-- RESUMEN MÉTRICAS SUPERIORES (KPIs) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            {{-- Músico --}}
            <div class="p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-100/80 text-indigo-700 flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr($payment->user->name ?? 'M', 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 block">{{ __('Músic beneficiari') }}</span>
                    <span class="text-sm font-extrabold text-slate-900 block truncate">{{ $payment->user->name }}</span>
                </div>
            </div>

            {{-- Fecha de Pago --}}
            <div class="p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100/80 text-amber-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 block">{{ __('Data de liquidació') }}</span>
                    <span class="text-sm font-extrabold text-slate-900 block">
                        {{ \Carbon\Carbon::parse($payment->fechaPago)->format('d/m/Y') }}
                    </span>
                </div>
            </div>

            {{-- Periodo --}}
            <div class="p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100/80 text-blue-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 block">{{ __('Període d\'actuacions') }}</span>
                    <span class="text-xs font-bold text-slate-800 block">
                        {{ $payment->fechaInicio ? \Carbon\Carbon::parse($payment->fechaInicio)->format('d/m/Y') : '-' }} 
                        <span class="text-slate-400">→</span> 
                        {{ $payment->fechaFin ? \Carbon\Carbon::parse($payment->fechaFin)->format('d/m/Y') : '-' }}
                    </span>
                </div>
            </div>

            {{-- Total Liquidado (Sin label cache) --}}
            <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-700 text-white shadow-md shadow-indigo-600/20 flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-indigo-200 block">{{ __('Total a cobrar') }}</span>
                    <span class="text-2xl font-black font-headline tracking-tight block">
                        {{ number_format((float) ($form->totalPago ?: $payment->totalPago), 2, ',', '.') }} €
                    </span>
                </div>
                <div class="text-right flex items-center justify-end gap-1.5">
                    <span class="inline-flex px-2.5 py-1 rounded-xl bg-white/20 text-xs font-black text-white">
                        {{ $form->porcentaje ?: ($payment->user->porcentaje ?? 100) }}%
                    </span>
                    @can('admin')
                        <button type="button" wire:click="openUserPorcentajeModal"
                            class="p-1 rounded-xl bg-white/20 hover:bg-white/30 text-white transition active:scale-95"
                            title="{{ __('Modificar percentatge del músic i recalcular') }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                    @endcan
                </div>
            </div>

        </div>

        {{-- FORMULARIO DE OBSERVACIONES Y NOTAS --}}
        <div class="pt-2 border-t border-indigo-50">
            <label for="observaciones" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                {{ __('Observacions / Motiu de disconformitat') }}
            </label>
            <textarea
                wire:model="form.observaciones"
                id="observaciones"
                rows="2"
                class="w-full text-xs bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition p-3.5"
                placeholder="{{ __('Afegeix ací qualsevol aclariment o incidència sobre este pagament...') }}"
            ></textarea>
            @error('form.observaciones')
                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- BARRA DE ACCIONES --}}
        <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-indigo-50">
            <div class="flex flex-wrap items-center gap-2.5">
                {{-- Botón Enviar Email --}}
                <button type="button" wire:click="print" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold border border-slate-200/60 shadow-xs transition active:scale-95">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>{{ __('Enviar per Correu') }}</span>
                </button>

                {{-- Confirmar o Desconformar con Loading --}}
                @if (!$pendiente)
                    <button type="button" wire:click="confirm" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition active:scale-95 disabled:opacity-75">
                        <svg wire:loading.remove wire:target="confirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <svg wire:loading wire:target="confirm" class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>{{ __('Confirmar liquidació (Conforme)') }}</span>
                    </button>
                @else
                    <button type="button" wire:click="noConfirmar" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold shadow-md shadow-amber-500/20 transition active:scale-95 disabled:opacity-75">
                        <svg wire:loading.remove wire:target="noConfirmar" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <svg wire:loading wire:target="noConfirmar" class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>{{ __('Indicar incidència / No conforme') }}</span>
                    </button>
                @endif
                {{-- Botón Admin: Resolver Incidencia y Recalcular --}}
                @can('admin')
                    @if (!$pendiente || !empty($payment->observaciones))
                        <button type="button" wire:click="resolverIncidencia" wire:loading.attr="disabled"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-2xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold border border-indigo-200/60 transition active:scale-95 disabled:opacity-75"
                            title="{{ __('Recalcular la suma d\'actuacions i marcar la incidència com a resolta') }}">
                            <svg wire:loading.remove wire:target="resolverIncidencia" class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <svg wire:loading wire:target="resolverIncidencia" class="w-4 h-4 animate-spin text-indigo-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>{{ __('Resoldre incidència i recalcular') }}</span>
                        </button>
                    @endif
                @endcan
            </div>

            {{-- Botón Eliminar (Solo Admin) --}}
            @can('admin')
                <button type="button" wire:click="confirmDeletion({{ $payment->id }})"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold border border-rose-200/60 transition active:scale-95"
                    title="{{ __('Eliminar registre') }}">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>{{ __('Eliminar') }}</span>
                </button>
            @endcan
        </div>

    </div>

    {{-- MODAL MODIFICAR PORCENTAJE DEL MÚSICO --}}
    <x-ui.modal wire:model="showingUserPorcentajeModal">
        <div class="overflow-hidden rounded-3xl border border-indigo-50 bg-white text-slate-900 shadow-2xl">
            <form class="w-full mb-0" wire:submit.prevent="saveUserPorcentaje">
                <div class="p-6 space-y-4">
                    <div class="border-b border-indigo-50 pb-3">
                        <h3 class="text-base font-bold font-headline text-slate-900">
                            {{ __('Modificar percentatge del músic') }}
                        </h3>
                        <p class="text-xs text-slate-600 font-semibold mt-1">
                            {{ $payment->user->name }}
                        </p>
                        <p class="text-xs text-slate-500 mt-1">
                            {{ __('En guardar, s\'actualitzarà el percentatge de la fitxa del músic i es recalcularan automàticament les actuacions d\'esta liquidació.') }}
                        </p>
                    </div>

                    <div>
                        <label for="userPorcentaje" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Percentatge de liquidació (%)') }}
                        </label>
                        <div class="relative max-w-xs">
                            <input type="number" step="0.5" min="0" max="100" wire:model="userPorcentaje" id="userPorcentaje"
                                class="w-full text-sm font-extrabold bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 p-3 pr-10 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500" />
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400 font-bold text-sm">
                                %
                            </span>
                        </div>
                        @error('userPorcentaje')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-2 border-t border-indigo-50 bg-[#F5F6FC]/60 p-4">
                    <button type="button" wire:click="closeUserPorcentajeModal" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-2xl transition">
                        {{ __('Cancel·lar') }}
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-2xl shadow-md shadow-indigo-600/20 transition">
                        {{ __('Guardar i recalcular liquidació') }}
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>

    {{-- DESGLOSE DE ACTUACIONES (LIVEWIRE COMPONENT) --}}
    <div class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <h2 class="text-base font-extrabold font-headline text-slate-900">
                {{ __('Desglossament d\'actuacions incloses') }}
            </h2>
            <span class="text-xs text-slate-500">
                {{ __('Detall de bolos, dietes de quilometratge i transport') }}
            </span>
        </div>

        <livewire:payment.payment-listas-users-detail :payment="$payment" />
    </div>

</div>
