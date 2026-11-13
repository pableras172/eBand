<div class="max-w-7xl mx-auto space-y-6 px-3 py-4 pb-28 sm:px-4 lg:px-6">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('inventory.index') }}">{{ __('Inventari') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ $item->nombre }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ $item->nombre }}
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('inventory.index') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-bold shadow-xs transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Tornar') }}</span>
                </a>

                @can('update', $item)
                    <a href="{{ route('inventory.edit', $item) }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                        <x-editar w="15" h="15" />
                        <span>{{ __('Editar') }}</span>
                    </a>
                @endcan

                @can('delete', $item)
                    <button type="button" wire:click="confirmDelete"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 text-xs font-bold shadow-xs transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>{{ __('Eliminar') }}</span>
                    </button>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Tarjeta: Identificación del elemento -->
        <div class="bg-white border border-indigo-50/80 rounded-3xl p-5 lg:p-6 shadow-bento">
            <div class="flex items-center justify-between pb-4 border-b border-indigo-50">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Identificació') }}</h2>
                        <p class="text-base font-extrabold text-slate-900">{{ $item->nombre }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Categoria') }}</p>
                    <p class="text-sm font-bold text-slate-900">{{ $item->category?->nombre ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Any de registre') }}</p>
                    <p class="text-sm font-bold text-slate-900">{{ $item->year ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Quantitat') }}</p>
                    <p class="text-sm font-bold text-slate-900">{{ $item->cantidad }} u.</p>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Estat') }}</p>
                    @php
                        $badgeColor = match($item->estado) {
                            'nuevo' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                            'usado' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                            'desperfectos' => 'bg-amber-50 text-amber-800 border-amber-200',
                            default => 'bg-rose-50 text-rose-800 border-rose-200',
                        };
                    @endphp
                    <span class="px-2.5 py-0.5 inline-flex text-xs font-bold rounded-full border {{ $badgeColor }}">
                        {{ ucfirst($item->estado) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Datos económicos (Solo administradores) -->
        @if ($isAdmin)
            <div class="bg-white border border-indigo-50/80 rounded-3xl p-5 lg:p-6 shadow-bento">
                <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50">
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Dades econòmiques (Administració)') }}</h2>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 pt-4">
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Valor Unitari') }}</p>
                        <p class="text-sm font-semibold text-slate-800">{{ number_format($item->valor_unitario, 2, ',', '.') }} €</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Valor Total') }}</p>
                        <p class="text-sm font-extrabold text-amber-600">{{ number_format($item->valor_total, 2, ',', '.') }} €</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Depreciació anual') }}</p>
                        <p class="text-sm font-semibold text-slate-800">{{ number_format($item->depreciation_rate, 2, ',', '.') }}%</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Valor Residual') }}</p>
                        <p class="text-sm font-bold text-emerald-600">{{ number_format($item->valor_residual, 2, ',', '.') }} €</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Data de compra') }}</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $item->purchase_date?->format('d/m/Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Grid: Responsables y Observaciones -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Responsables -->
            <div class="bg-white border border-indigo-50/80 rounded-3xl p-5 lg:p-6 shadow-bento">
                <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50">
                    <span class="w-8 h-8 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Persones Responsables') }}</h2>
                </div>

                <div class="pt-4">
                    @if ($item->responsables->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach ($item->responsables as $responsable)
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-2xl bg-indigo-50 border border-indigo-100 text-xs font-bold text-indigo-900 shadow-2xs">
                                    <div class="w-5 h-5 rounded-full bg-indigo-200 text-indigo-700 flex items-center justify-center text-[10px]">
                                        {{ mb_substr($responsable->name, 0, 1) }}
                                    </div>
                                    <span>{{ $responsable->name }}</span>
                                    @if ($responsable->id === auth()->id())
                                        <span class="px-1.5 py-0.2 rounded-md bg-emerald-100 text-emerald-800 text-[10px]">{{ __('Tu') }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-400 italic">{{ __('Material sense cap responsable assignat actualment.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Observaciones -->
            <div class="bg-white border border-indigo-50/80 rounded-3xl p-5 lg:p-6 shadow-bento">
                <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50">
                    <span class="w-8 h-8 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </span>
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Observacions') }}</h2>
                </div>

                <div class="pt-4">
                    <p class="text-xs text-slate-700 whitespace-pre-line leading-relaxed">
                        {{ $item->observaciones ?: __('Sense observacions registrades.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Historial de Movimientos -->
        <div class="bg-white border border-indigo-50/80 rounded-3xl p-5 lg:p-6 shadow-bento">
            <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50">
                <span class="w-8 h-8 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Historial de moviments') }}</h2>
            </div>

            <div class="overflow-x-auto pt-4">
                <table class="min-w-full divide-y divide-indigo-50">
                    <thead class="bg-[#EEF1FA]/60">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Data') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Tipus') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Usuari') }}</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Descripció') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-indigo-50/70">
                        @forelse ($item->movements as $movement)
                            <tr class="hover:bg-indigo-50/20 transition">
                                <td class="px-4 py-3 text-xs text-slate-600 whitespace-nowrap">{{ $movement->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 text-xs whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                        {{ ucfirst($movement->tipo) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-slate-700 font-semibold">{{ $movement->user?->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-xs text-slate-600">{{ $movement->descripcion }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-xs text-slate-400 italic">
                                    {{ __('No hi ha moviments registrats per a aquest material.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
    @if ($isAdmin)
        <x-dialog-modal wire:model.live="confirmingDeletion">
            <x-slot name="title">
                <div class="flex items-center gap-2 text-rose-600 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>{{ __('Eliminar material de l\'inventari') }}</span>
                </div>
            </x-slot>

            <x-slot name="content">
                <p class="text-sm text-slate-600">
                    {{ __('Estàs segur que vols eliminar aquest element de l\'inventari? S\'eliminaran també els registres de moviments i assignacions vinculades. Aquesta acció no es pot desfer.') }}
                </p>
            </x-slot>

            <x-slot name="footer">
                <div class="flex items-center justify-end gap-3">
                    <x-secondary-button wire:click="cancelDelete">
                        {{ __('Cancel·lar') }}
                    </x-secondary-button>

                    <x-danger-button wire:click="delete" wire:loading.attr="disabled">
                        {{ __('Eliminar definitivament') }}
                    </x-danger-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>
