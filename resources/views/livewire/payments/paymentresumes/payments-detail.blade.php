<div class="space-y-4">

    {{-- BARRA DE ACCIÓN Y BÚSQUEDA NEO-BENTO --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="w-full sm:max-w-md relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input
                    wire:model.live="detailPaymentsSearch"
                    type="text"
                    placeholder="{{ __('Cercar per músic o concepte de liquidació...') }}"
                    class="w-full pl-10 pr-4 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                />
            </div>

            <div class="flex items-center justify-between sm:justify-end gap-3">
                <span class="text-xs text-slate-500 font-medium">
                    <strong class="text-slate-800">{{ $detailPayments->total() }}</strong> {{ __('pagaments en este resum') }}
                </span>

                @can('create', App\Models\Payment::class)
                    <button type="button" wire:click="newPayment"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold border border-indigo-200/60 transition active:scale-95">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>{{ __('Afegir pagament') }}</span>
                    </button>
                @endcan
            </div>
        </div>
    </div>

    {{-- MODAL CREAR / EDITAR PAGO MANUAL (NEO-BENTO) --}}
    <x-ui.modal wire:model="showingModal">
        <div class="overflow-hidden rounded-3xl border border-indigo-50 bg-white text-slate-900 shadow-2xl">
            <form class="w-full mb-0" wire:submit.prevent="save">
                <div class="p-6 space-y-4">
                    <div class="border-b border-indigo-50 pb-3">
                        <h3 class="text-base font-bold font-headline text-slate-900">
                            {{ $payment ? __('Editar liquidació individual') : __('Afegir liquidació individual') }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ __('Dades de la liquidació econòmica associada a este resum') }}
                        </p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label for="modal-descripcion" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                {{ __('Descripció') }}
                            </label>
                            <input type="text"
                                wire:model="form.descripcion"
                                id="modal-descripcion"
                                class="w-full text-xs bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 p-3"
                                placeholder="{{ __('Ex: Liquidació Actuacions Festes Patronals') }}" />
                            @error('form.descripcion')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label for="modal-fechaPago" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Data de pagament') }}
                                </label>
                                <input type="datetime-local"
                                    wire:model="form.fechaPago"
                                    id="modal-fechaPago"
                                    class="w-full text-xs bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 p-2.5 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500" />
                                @error('form.fechaPago')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="modal-fechaInicio" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Data d\'inici') }}
                                </label>
                                <input type="datetime-local"
                                    wire:model="form.fechaInicio"
                                    id="modal-fechaInicio"
                                    class="w-full text-xs bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 p-2.5 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500" />
                                @error('form.fechaInicio')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="modal-fechaFin" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                {{ __('Data de finalització') }}
                            </label>
                            <input type="datetime-local"
                                wire:model="form.fechaFin"
                                id="modal-fechaFin"
                                class="w-full text-xs bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 p-2.5 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500" />
                            @error('form.fechaFin')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2.5 border-t border-indigo-50 bg-[#F5F6FC]/60 p-4">
                    <button type="button" wire:click="closeModal"
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-2xl transition">
                        {{ __('Cancel·lar') }}
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-2xl shadow-md shadow-indigo-600/20 transition">
                        {{ __('Guardar') }}
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>

    {{-- MODAL CONFIRMAR ELIMINACIÓN DE PAGO --}}
    <x-ui.modal.confirm wire:model="confirmingPaymentDeletion">
        <x-slot name="title">
            <span class="text-slate-900 font-headline font-bold">{{ __('Eliminar liquidació del resum') }}</span>
        </x-slot>

        <x-slot name="content">
            <p class="text-slate-600 text-sm">
                {{ __('Segur que vols eliminar este registre de liquidació individual?') }}
            </p>
            <p class="mt-2 text-xs text-rose-600 bg-rose-50 border border-rose-100 rounded-xl p-3">
                {{ __('Aquesta acció traurà el pagament del resum consolidat.') }}
            </p>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-2xl transition"
                wire:click="$toggle('confirmingPaymentDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel·lar') }}
            </button>

            <button type="button" class="ml-3 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-2xl shadow-sm transition"
                wire:click="deletePayment({{ $deletingPayment }})" wire:loading.attr="disabled">
                {{ __('Eliminar definitivament') }}
            </button>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- LISTA MÓVIL (TARJETAS NEO-BENTO) --}}
    <div class="space-y-3 md:hidden">
        @forelse ($detailPayments as $payment)
            <div wire:key="mobile-payment-{{ $payment->id }}"
                class="rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento space-y-3 hover:border-indigo-100 transition">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-indigo-100/80 text-indigo-700 flex items-center justify-center font-bold text-xs shrink-0">
                            {{ strtoupper(substr($payment->user->name ?? 'M', 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <span class="text-sm font-extrabold text-slate-900 block truncate">
                                {{ $payment->user->name ?? '-' }}
                            </span>
                            <span class="text-[11px] text-slate-500 block truncate">
                                {{ $payment->descripcion }}
                            </span>
                        </div>
                    </div>

                    {{-- Total a cobrar --}}
                    <div class="shrink-0 text-right">
                        <span class="text-xs font-black text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-xl px-2.5 py-1 block">
                            {{ number_format($payment->totalPago, 2, ',', '.') }} €
                        </span>
                    </div>
                </div>

                {{-- Badges de Estado y Actuaciones --}}
                <div class="flex items-center justify-between text-xs pt-2 border-t border-indigo-50/70">
                    <div class="flex items-center gap-2">
                        {{-- Badge Actuaciones --}}
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-bold">
                            <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>{{ $payment->listas_users_count ?? $payment->listasUsers->count() }} {{ __('bolos') }}</span>
                        </span>

                        {{-- Badge Estado --}}
                        @if ($payment->confirmadausuaroi)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-emerald-50 text-emerald-700 text-[11px] font-bold border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>{{ __('Conforme') }}</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-amber-50 text-amber-700 text-[11px] font-bold border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                <span>{{ __('Pendent') }}</span>
                            </span>
                        @endif
                    </div>

                    {{-- Botón a Detalle de Pago y Actuaciones --}}
                    <div class="flex items-center gap-1.5">
                        <a wire:navigate href="{{ route('payments.edit', $payment) }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition active:scale-95">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>{{ __('Veure actuacions') }}</span>
                        </a>

                        @can('delete', $payment)
                            <button type="button" wire:click="confirmPaymentDeletion({{ $payment->id }})"
                                class="p-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100/80 transition active:scale-95"
                                title="{{ __('Eliminar') }}">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-3xl border border-indigo-50/80 bg-white p-8 text-center shadow-bento space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 mx-auto flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">{{ __('No hi ha pagaments en este resum.') }}</p>
                <p class="text-xs text-slate-500">{{ __('No s\'ha trobat cap liquidació amb el filtre especificat.') }}</p>
            </div>
        @endforelse
    </div>

    {{-- TABLA DESKTOP (NEO-BENTO LIGHT) CON OVERFLOW-X-AUTO --}}
    <div class="hidden md:block overflow-x-auto rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
        <table class="w-full min-w-[760px] divide-y divide-indigo-50">
            <thead class="bg-[#F5F6FC]/80">
                <tr>
                    <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                        {{ __('Músic / Beneficiari') }}
                    </th>
                    <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:text-indigo-600 transition"
                        wire:click="sortBy('descripcion')">
                        <div class="flex items-center gap-1.5">
                            <span>{{ __('Concepte de liquidació') }}</span>
                            @if ($detailPaymentsSortField === 'descripcion')
                                <span class="text-indigo-600">{{ $detailPaymentsSortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                        {{ __('Actuacions') }}
                    </th>
                    <th scope="col" class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                        {{ __('Estat') }}
                    </th>
                    <th scope="col" class="px-5 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:text-indigo-600 transition"
                        wire:click="sortBy('totalPago')">
                        <div class="flex items-center justify-end gap-1.5">
                            <span>{{ __('Total a cobrar') }}</span>
                            @if ($detailPaymentsSortField === 'totalPago')
                                <span class="text-indigo-600">{{ $detailPaymentsSortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-5 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider w-56">
                        {{ __('Accions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-indigo-50/70">
                @forelse ($detailPayments as $payment)
                    <tr wire:key="desktop-payment-{{ $payment->id }}" wire:loading.class.delay="opacity-75" class="hover:bg-[#F5F6FC]/60 transition-colors">
                        {{-- Músico --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($payment->user->name ?? 'M', 0, 2)) }}
                                </div>
                                <div>
                                    <span class="text-sm font-extrabold text-slate-900 block">
                                        {{ $payment->user->name ?? '-' }}
                                    </span>
                                    <span class="text-[11px] text-slate-400 block">
                                        {{ $payment->user->instrument->nombre ?? ($payment->user->email ?? '') }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        {{-- Descripción --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-xs font-bold text-slate-800 block">
                                {{ $payment->descripcion }}
                            </span>
                            @if ($payment->fechaInicio || $payment->fechaFin)
                                <span class="text-[11px] text-slate-400 block mt-0.5">
                                    {{ $payment->fechaInicio ? \Carbon\Carbon::parse($payment->fechaInicio)->format('d/m/Y') : '' }}
                                    @if ($payment->fechaFin) → {{ \Carbon\Carbon::parse($payment->fechaFin)->format('d/m/Y') }} @endif
                                </span>
                            @endif
                        </td>

                        {{-- Número de Actuaciones --}}
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200/60">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span>{{ $payment->listas_users_count ?? $payment->listasUsers->count() }} {{ __('bolos') }}</span>
                            </span>
                        </td>

                        {{-- Estado --}}
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            @if ($payment->confirmadausuaroi)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/60">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span>{{ __('Conforme') }}</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200/60">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    <span>{{ __('Pendent') }}</span>
                                </span>
                            @endif
                        </td>

                        {{-- Total Pago --}}
                        <td class="px-5 py-4 whitespace-nowrap text-right">
                            <span class="text-sm font-black text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-xl px-3 py-1">
                                {{ number_format($payment->totalPago, 2, ',', '.') }} €
                            </span>
                        </td>

                        {{-- Acciones --}}
                        <td class="px-5 py-4 whitespace-nowrap text-right w-56">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Enlace directo al detalle del pago y sus actuaciones --}}
                                <a wire:navigate href="{{ route('payments.edit', $payment) }}"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs transition active:scale-95 shrink-0"
                                    title="{{ __('Veure liquidació i desglossament d\'actuacions') }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>{{ __('Veure actuacions') }}</span>
                                </a>

                                @can('delete', $payment)
                                    <button type="button" wire:click="confirmPaymentDeletion({{ $payment->id }})"
                                        class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100/80 transition active:scale-95 shrink-0"
                                        title="{{ __('Eliminar pagament') }}">
                                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 mx-auto flex items-center justify-center mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <span class="font-bold text-slate-700 block text-sm">{{ __('No hi ha pagaments en este resum.') }}</span>
                            <span class="text-slate-500">{{ __('No s\'ha trobat cap liquidació amb el filtre especificat.') }}</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($detailPayments->hasPages())
            <div class="border-t border-indigo-50 px-5 py-3.5 bg-[#F5F6FC]/60">
                {{ $detailPayments->links() }}
            </div>
        @endif
    </div>

</div>
