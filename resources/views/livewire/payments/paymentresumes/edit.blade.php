<div class="mx-auto max-w-7xl space-y-6 px-2 py-4 sm:px-4 lg:px-6 pb-28">

    {{-- HEADER Y BREADCRUMBS --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('paymentresumes.index') }}">{{ __('Resums de Liquidacions') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Detall del Resum') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ $paymetresume->descripcion }}
                        </h1>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Resum consolidat de liquidacions individuals per a músics de la banda') }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                {{-- Botón Descargar PDF --}}
                <a href="{{ route('pdf.paymentresume', $paymetresume) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold border border-slate-200/60 shadow-xs transition active:scale-95">
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span>{{ __('Descarregar PDF') }}</span>
                </a>

                {{-- Botón Enviar Email --}}
                <button type="button" wire:click="print" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold border border-indigo-200/60 shadow-xs transition active:scale-95 disabled:opacity-75">
                    <svg wire:loading.remove wire:target="print" class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <svg wire:loading wire:target="print" class="w-4 h-4 animate-spin text-indigo-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>{{ __('Enviar per Correu') }}</span>
                </button>
            </div>
        </div>
    </x-slot>

    {{-- TOASTS DE NOTIFICACIÓN --}}
    <x-ui.toast timeout=5000 on="saved">{{ __('Resum desat correctament.') }}</x-ui.toast>
    <x-ui.toast timeout=5000 on="email-sent">{{ __('Email amb el resum enviat correctament.') }}</x-ui.toast>
    <x-ui.toast timeout=5000 color="red" on="email-error">{{ __('Error en enviar el correu electrònic.') }}</x-ui.toast>

    {{-- TARJETA RESUMEN NEO-BENTO (KPIs Y EDICIÓN) --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-5 sm:p-6 shadow-bento space-y-6">

        {{-- RESUMEN MÉTRICAS SUPERIORES (KPIs) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Creador --}}
            <div class="p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-100/80 text-indigo-700 flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr($paymetresume->user?->name ?? 'U', 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 block">{{ __('Creat per') }}</span>
                    <span class="text-sm font-extrabold text-slate-900 block truncate">{{ $paymetresume->user?->name ?? '-' }}</span>
                </div>
            </div>

            {{-- Data de Creació --}}
            <div class="p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100/80 text-amber-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 block">{{ __('Data del resum') }}</span>
                    <span class="text-sm font-extrabold text-slate-900 block">
                        {{ $paymetresume->created_at ? $paymetresume->created_at->format('d/m/Y H:i') : '-' }}
                    </span>
                </div>
            </div>

            {{-- Total Músicos / Pagos --}}
            <div class="p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100/80 text-blue-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 block">{{ __('Pagaments inclosos') }}</span>
                    <span class="text-sm font-extrabold text-slate-900 block">
                        {{ $paymetresume->payments->count() }} {{ __('liquidacions') }}
                    </span>
                </div>
            </div>

            {{-- Total Consolidat --}}
            <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-700 text-white shadow-md shadow-indigo-600/20 flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-indigo-200 block">{{ __('Total consolidat') }}</span>
                    <span class="text-2xl font-black font-headline tracking-tight block">
                        {{ number_format($paymetresume->total, 2, ',', '.') }} €
                    </span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

        </div>

        {{-- FORMULARIO DE EDICIÓN DE DESCRIPCIÓN --}}
        <form wire:submit.prevent="save" class="pt-2 border-t border-indigo-50">
            <div class="flex flex-col sm:flex-row items-end gap-3">
                <div class="w-full flex-1">
                    <label for="descripcion" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('Descripció del Resum') }}
                    </label>
                    <input type="text"
                        wire:model="form.descripcion"
                        id="descripcion"
                        class="w-full text-xs bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition p-3"
                        placeholder="{{ __('Ex: Liquidació Festes Patronals 2026...') }}" />
                    @error('form.descripcion')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ __('Guardar canvis') }}</span>
                </button>
            </div>
        </form>

    </div>

    {{-- DESGLOSE DE PAGOS INDIVIDUALES (SUBCOMPONENTE LIVEWIRE) --}}
    <div class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <div>
                <h2 class="text-base font-extrabold font-headline text-slate-900">
                    {{ __('Desglossament de pagaments individuals') }}
                </h2>
                <p class="text-xs text-slate-500">
                    {{ __('Selecciona qualsevol pagament per consultar el seu desglossament d\'actuacions, dietes i quilometratge') }}
                </p>
            </div>
        </div>

        <livewire:paymentresume.paymentresume-payments-detail :paymetresume="$paymetresume" />
    </div>

</div>
