<div class="max-w-7xl mx-auto space-y-6 px-2 py-4 pb-28 sm:px-4 lg:px-6">
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
                        <x-ui.breadcrumbs.link active>{{ __('Inventari') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('Inventari i Equipament') }}
                    </h1>
                </div>
            </div>

            @can('create', App\Models\InventoryItem::class)
                <a href="{{ route('inventory.create') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>{{ __('Afegir nou material') }}</span>
                </a>
            @endcan
        </div>
    </x-slot>

    <div>
        {{-- FILTROS DE INVENTARIO (Neo-Bento Violet) --}}
        <div class="bg-white border border-indigo-50/80 rounded-3xl p-5 lg:p-6 shadow-bento mb-6 space-y-4">
            @unless($isAdmin)
                <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 px-3.5 py-2.5 text-xs text-indigo-900 flex items-center gap-2">
                    <span>ℹ️</span>
                    <span>{{ __('Mostrant únicament el material i instruments que tens assignats actualment.') }}</span>
                </div>
            @endunless

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                <!-- Búsqueda -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">{{ __('Cercar') }}</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" wire:model.live="search" placeholder="{{ __('Nom, model o marca...') }}"
                            class="w-full pl-9 pr-3 py-2 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">{{ __('Categoria') }}</label>
                    <select wire:model.live="selectedCategory"
                        class="w-full px-3 py-2 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('Totes les categories') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">{{ __('Estat') }}</label>
                    <select wire:model.live="selectedState"
                        class="w-full px-3 py-2 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('Tots els estats') }}</option>
                        @foreach ($states as $state)
                            <option value="{{ $state }}">{{ ucfirst($state) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Año -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">{{ __('Any') }}</label>
                    <select wire:model.live="selectedYear"
                        class="w-full px-3 py-2 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- TABLA DE INVENTARIO (Neo-Bento Violet) --}}
        <div class="overflow-hidden rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-indigo-50">
                    <thead class="bg-[#EEF1FA]/60">
                        <tr>
                            <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Material / Element') }}</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">{{ __('Categoria') }}</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Quantitat') }}</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">{{ __('Valor') }}</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">{{ __('Estat') }}</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Responsables') }}</th>
                            <th class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">{{ __('Accions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-indigo-50/70">
                        @forelse ($items as $item)
                            @php
                                $rowUrl = auth()->user()->can('view', $item)
                                    ? route('inventory.show', $item)
                                    : (auth()->user()->can('update', $item)
                                        ? route('inventory.edit', $item)
                                        : null);
                            @endphp
                            <tr
                                @if ($rowUrl)
                                    class="cursor-pointer hover:bg-indigo-50/30 transition-colors"
                                    role="link"
                                    tabindex="0"
                                    onclick="window.location='{{ $rowUrl }}'"
                                    onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); window.location='{{ $rowUrl }}'; }"
                                @else
                                    class="hover:bg-indigo-50/30 transition-colors"
                                @endif>
                                <td class="px-4 py-3.5 whitespace-nowrap text-sm font-bold text-slate-900">{{ $item->nombre }}</td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-xs text-slate-500 hidden md:table-cell">{{ $item->category->nombre }}</td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-xs text-slate-800 font-bold">{{ $item->cantidad }} u.</td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-xs text-amber-600 font-bold hidden md:table-cell">
                                    {{ number_format($item->valor_total, 2, ',', '.') }} €
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap hidden md:table-cell">
                                    @php
                                        $badgeColor = match($item->estado) {
                                            'nuevo' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                            'usado' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                            'desperfectos' => 'bg-amber-50 text-amber-800 border-amber-200',
                                            default => 'bg-rose-50 text-rose-800 border-rose-200',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-0.5 inline-flex text-[11px] font-bold rounded-full border {{ $badgeColor }}">
                                        {{ ucfirst($item->estado) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3.5 text-xs text-slate-600">
                                    @if ($item->responsables->count() > 0)
                                        <span class="font-bold text-slate-800">{{ $item->responsables->pluck('name')->join(', ') }}</span>
                                    @else
                                        <span class="text-slate-400 italic">{{ __('Sense assignar') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-center hidden md:table-cell">
                                    <div class="flex items-center justify-center gap-2">
                                        @can('view', $item)
                                            <a href="{{ route('inventory.show', $item) }}" onclick="event.stopPropagation()"
                                                class="p-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition" title="{{ __('Veure') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('update', $item)
                                            <a href="{{ route('inventory.edit', $item) }}" onclick="event.stopPropagation()"
                                                class="p-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-100 shadow-xs transition" title="{{ __('Editar') }}">
                                                <x-editar w="16" h="16" />
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                    <p class="font-bold text-slate-800 text-base">{{ __('No s\'han trobat elements en l\'inventari') }}</p>
                                    <p class="text-xs mt-1">{{ __('Comprova els filtres de cerca o afig nou material.') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($items->hasPages())
                <div class="border-t border-indigo-50 px-4 py-3 bg-[#F5F6FC]/60">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- BARRA INFERIOR DE ACCIONES RÁPIDAS (Neo-Bento Violet) --}}
    <footer class="fixed bottom-0 left-0 right-0 z-20 bg-white/90 backdrop-blur-2xl border-t border-indigo-100/80 py-2.5 px-4 shadow-glass">
        <div class="mx-auto flex w-full max-w-5xl items-center justify-around gap-4">
            <!-- Exportar Excel -->
            <a href="{{ route('inventory.export.excel', ['year' => $selectedYear]) }}"
                class="flex flex-col items-center text-slate-500 hover:text-emerald-600 transition">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-[11px] mt-1 font-bold">{{ __('Excel') }}</span>
            </a>

            <!-- Exportar PDF -->
            <a href="{{ route('inventory.export.pdf', ['year' => $selectedYear]) }}"
                class="flex flex-col items-center text-slate-500 hover:text-rose-600 transition">
                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <span class="text-[11px] mt-1 font-bold">{{ __('PDF') }}</span>
            </a>

            <!-- Estadísticas (solo admin) -->
            @if ($isAdmin)
                <a href="{{ url('/inventory/stats') }}"
                    class="flex flex-col items-center text-slate-500 hover:text-amber-600 transition">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    </svg>
                    <span class="text-[11px] mt-1 font-bold">{{ __('Estadístiques') }}</span>
                </a>
            @endif

            <!-- Crear Item (solo admin) -->
            @can('create', App\Models\InventoryItem::class)
                <a href="{{ route('inventory.create') }}"
                    class="flex flex-col items-center text-indigo-600 hover:text-indigo-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-[11px] mt-1 font-bold">{{ __('Afegir') }}</span>
                </a>
            @endcan
        </div>
    </footer>
</div>
</div>
