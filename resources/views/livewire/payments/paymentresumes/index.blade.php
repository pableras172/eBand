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
                        <x-ui.breadcrumbs.link active>{{ __('Resums de Liquidacions') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ __('Resums Generals de Liquidacions') }}
                        </h1>
                        <span class="inline-flex items-center rounded-xl bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100">
                            {{ $paymentresumes->total() }} {{ __('totals') }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Històric consolidat de tancaments de comptes, pagaments i repartiment de bolos') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @can('create', App\Models\Paymentresume::class)
                    <a wire:navigate href="{{ route('paymentresumes.create') }}"
                        class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>{{ __('Crear nou resum') }}</span>
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    {{-- BARRA DE ACCIÓN Y BÚSQUEDA (Neo-Bento Light) --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="w-full md:max-w-md relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input wire:model.live="search" type="text"
                    class="w-full pl-10 pr-4 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    placeholder="{{ __('Cercar per descripció de resum o creador...') }}" />
            </div>

            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <span class="hidden sm:inline">{{ __('Mostrant') }}</span>
                <span class="font-bold text-slate-800">{{ $paymentresumes->count() }}</span>
                <span>{{ __('de') }}</span>
                <span class="font-bold text-slate-800">{{ $paymentresumes->total() }}</span>
                <span>{{ __('resums') }}</span>
            </div>
        </div>
    </div>

    {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title">
            <span class="text-slate-900 font-headline font-bold">{{ __('Eliminar resum de liquidacions') }}</span>
        </x-slot>

        <x-slot name="content">
            <p class="text-slate-600 text-sm">
                {{ __('Segur que vols eliminar este resum de liquidacions consolidat?') }}
            </p>
            <p class="mt-2 text-xs text-rose-600 bg-rose-50 border border-rose-100 rounded-xl p-3">
                {{ __('Aquesta acció eliminarà el registre consolidat del resum.') }}
            </p>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-2xl transition"
                wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel·lar') }}
            </button>

            <button type="button" class="ml-3 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-2xl shadow-sm transition"
                wire:click="delete({{ $deletingPaymetresume }})" wire:loading.attr="disabled">
                {{ __('Eliminar definitivament') }}
            </button>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- LISTADO MÓVIL (TARJETAS NEO-BENTO) --}}
    <div class="space-y-3.5 md:hidden">
        @forelse ($paymentresumes as $paymetresume)
            <div wire:key="mobile-resume-{{ $paymetresume->id }}"
                class="rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento space-y-3 hover:border-indigo-100 transition">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <a wire:navigate href="{{ route('paymentresumes.edit', $paymetresume) }}"
                            class="text-sm font-extrabold text-slate-900 hover:text-indigo-600 transition block">
                            {{ $paymetresume->descripcion }}
                        </a>
                        <div class="flex items-center gap-2 mt-1 text-[11px] text-slate-500">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $paymetresume->user?->name ?? '-' }}
                            </span>
                            <span>•</span>
                            <span>{{ $paymetresume->created_at ? $paymetresume->created_at->format('d/m/Y') : '-' }}</span>
                        </div>
                    </div>

                    {{-- Badge Importe Total --}}
                    <div class="shrink-0 text-right">
                        <span class="text-xs font-black text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-xl px-2.5 py-1 block">
                            {{ number_format($paymetresume->total, 2, ',', '.') }} €
                        </span>
                    </div>
                </div>

                {{-- Métricas de Pagos --}}
                <div class="flex items-center justify-between pt-2.5 border-t border-indigo-50/70 text-xs text-slate-600">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                        <span class="font-bold text-slate-800">{{ $paymetresume->payments_count }}</span>
                        <span class="text-slate-500">{{ __('pagaments') }}</span>
                    </div>

                    <div class="flex items-center gap-1.5">
                        {{-- Botón PDF --}}
                        <a href="{{ route('pdf.paymentresume', $paymetresume) }}" target="_blank"
                            class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition"
                            title="{{ __('Descarregar PDF') }}">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </a>

                        {{-- Botón Detalle --}}
                        <a wire:navigate href="{{ route('paymentresumes.edit', $paymetresume) }}"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold transition">
                            <span>{{ __('Detall') }}</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        {{-- Botón Eliminar --}}
                        <button type="button" wire:click="confirmDeletion({{ $paymetresume->id }})"
                            class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 transition"
                            title="{{ __('Eliminar') }}">
                            <x-delete w="16" h="16" />
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-3xl border border-indigo-50/80 bg-white p-8 text-center shadow-bento space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 mx-auto flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800">{{ __('No s\'han trobat resums de liquidació.') }}</p>
                <p class="text-xs text-slate-500">{{ __('Utilitza el botó superior per crear un nou resum consolidat.') }}</p>
            </div>
        @endforelse
    </div>

    {{-- TABLA DESKTOP (NEO-BENTO LIGHT) --}}
    <div class="hidden md:block overflow-hidden rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
        <table class="min-w-full divide-y divide-indigo-50">
            <thead class="bg-[#F5F6FC]/80">
                <tr>
                    <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:text-indigo-600 transition"
                        wire:click="sortBy('descripcion')">
                        <div class="flex items-center gap-1.5">
                            <span>{{ __('Descripció del Resum') }}</span>
                            @if ($sortField === 'descripcion')
                                <span class="text-indigo-600">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                        {{ __('Músics / Pagaments') }}
                    </th>
                    <th scope="col" class="px-5 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">
                        {{ __('Total Liquidat') }}
                    </th>
                    <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:text-indigo-600 transition"
                        wire:click="sortBy('user_id')">
                        <div class="flex items-center gap-1.5">
                            <span>{{ __('Creat per') }}</span>
                            @if ($sortField === 'user_id')
                                <span class="text-indigo-600">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:text-indigo-600 transition"
                        wire:click="sortBy('created_at')">
                        <div class="flex items-center gap-1.5">
                            <span>{{ __('Data de creació') }}</span>
                            @if ($sortField === 'created_at')
                                <span class="text-indigo-600">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                        {{ __('Accions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-indigo-50/70">
                @forelse ($paymentresumes as $paymetresume)
                    <tr wire:key="desktop-resume-{{ $paymetresume->id }}" wire:loading.class.delay="opacity-75" class="hover:bg-[#F5F6FC]/60 transition-colors">
                        {{-- Descripción --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <a wire:navigate href="{{ route('paymentresumes.edit', $paymetresume) }}"
                                class="text-sm font-extrabold text-slate-900 hover:text-indigo-600 transition">
                                {{ $paymetresume->descripcion }}
                            </a>
                        </td>

                        {{-- Número de Pagos --}}
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200/60">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>{{ $paymetresume->payments_count }} {{ __('pagaments') }}</span>
                            </span>
                        </td>

                        {{-- Total Liquidado --}}
                        <td class="px-5 py-4 whitespace-nowrap text-right">
                            <span class="text-sm font-black text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-xl px-3 py-1">
                                {{ number_format($paymetresume->total, 2, ',', '.') }} €
                            </span>
                        </td>

                        {{-- Creador --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-[11px]">
                                    {{ strtoupper(substr($paymetresume->user?->name ?? 'U', 0, 2)) }}
                                </div>
                                <span class="text-xs font-semibold text-slate-700">
                                    {{ $paymetresume->user?->name ?? '-' }}
                                </span>
                            </div>
                        </td>

                        {{-- Fecha --}}
                        <td class="px-5 py-4 whitespace-nowrap text-xs text-slate-500">
                            {{ $paymetresume->created_at ? $paymetresume->created_at->format('d/m/Y H:i') : '-' }}
                        </td>

                        {{-- Acciones --}}
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Descargar PDF --}}
                                <a href="{{ route('pdf.paymentresume', $paymetresume) }}" target="_blank"
                                    class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200/60 transition active:scale-95"
                                    title="{{ __('Descarregar PDF') }}">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </a>

                                {{-- Editar / Ver Detalle --}}
                                <a wire:navigate href="{{ route('paymentresumes.edit', $paymetresume) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-xs transition active:scale-95"
                                    title="{{ __('Veure i editar detall') }}">
                                    <x-editar w="14" h="14" />
                                    <span>{{ __('Detall') }}</span>
                                </a>

                                {{-- Eliminar --}}
                                <button type="button" wire:click="confirmDeletion({{ $paymetresume->id }})"
                                    class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 transition active:scale-95"
                                    title="{{ __('Eliminar resum') }}">
                                    <x-delete w="16" h="16" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 mx-auto flex items-center justify-center mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span class="font-bold text-slate-700 block text-sm">{{ __('No s\'han trobat resums de liquidació.') }}</span>
                            <span class="text-slate-500">{{ __('Utilitza el botó superior per crear un nou resum consolidat.') }}</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($paymentresumes->hasPages())
            <div class="border-t border-indigo-50 px-5 py-3.5 bg-[#F5F6FC]/60">
                {{ $paymentresumes->links() }}
            </div>
        @endif
    </div>

</div>
