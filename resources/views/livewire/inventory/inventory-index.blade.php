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
                        <x-ui.breadcrumbs.link active>{{ __('Inventari') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ $isAdmin ? __('Inventari i Equipament') : __('El meu Material i Equipament') }}
                    </h1>
                </div>
            </div>

            @if ($isAdmin)
                <div class="flex flex-wrap items-center gap-2">
                    {{-- Exportar Excel --}}
                    <a href="{{ route('inventory.export.excel', ['year' => $selectedYear]) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-2xl bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 border border-slate-200 hover:border-emerald-200 text-xs font-bold shadow-xs transition"
                        title="{{ __('Exportar a Excel') }}">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="hidden sm:inline">{{ __('Excel') }}</span>
                    </a>

                    {{-- Exportar PDF --}}
                    <a href="{{ route('inventory.export.pdf', ['year' => $selectedYear]) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-2xl bg-white hover:bg-rose-50 text-slate-700 hover:text-rose-700 border border-slate-200 hover:border-rose-200 text-xs font-bold shadow-xs transition"
                        title="{{ __('Exportar a PDF') }}">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <span class="hidden sm:inline">{{ __('PDF') }}</span>
                    </a>

                    {{-- Estadísticas --}}
                    <a href="{{ route('inventory.stats') }}"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-2xl bg-white hover:bg-amber-50 text-slate-700 hover:text-amber-700 border border-slate-200 hover:border-amber-200 text-xs font-bold shadow-xs transition"
                        title="{{ __('Estadístiques de valoració') }}">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        </svg>
                        <span class="hidden sm:inline">{{ __('Estadístiques') }}</span>
                    </a>

                    {{-- Afegir material --}}
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
            @endif
        </div>
    </x-slot>

    {{-- Notificación Flash --}}
    @if (session()->has('message'))
        <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('message') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 ml-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    @endif

    {{-- CASO 1: USUARIO SIN NINGÚN MATERIAL ASIGNADO --}}
    @if (! $isAdmin && ! $hasAssignedItems)
        <div class="bg-white border border-indigo-50/80 rounded-3xl p-8 lg:p-12 shadow-bento text-center max-w-xl mx-auto my-6">
            <div class="w-16 h-16 rounded-3xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 mx-auto mb-4 shadow-xs">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h3 class="text-lg lg:text-xl font-bold font-headline text-slate-900">{{ __('No tens cap material assignat') }}</h3>
            <p class="text-xs text-slate-500 mt-2 max-w-md mx-auto leading-relaxed">
                {{ __('Actualment no tens cap instrument o equipament de la banda assignat al teu nom. Quan l\'administració t\'assigne material, apareixerà ací automàticament.') }}
            </p>
            <div class="mt-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>{{ __('Tornar a l\'Inici') }}</span>
                </a>
            </div>
        </div>
    @else
        {{-- FILTROS DE INVENTARIO (Neo-Bento Violet) --}}
        <div class="bg-white border border-indigo-50/80 rounded-3xl p-5 lg:p-6 shadow-bento space-y-4">
            @unless($isAdmin)
                <div class="rounded-2xl border border-indigo-100 bg-indigo-50/60 px-3.5 py-2.5 text-xs text-indigo-900 flex items-center gap-2">
                    <span class="text-indigo-600 font-bold">ℹ️</span>
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
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ __('Nom, model o marca...') }}"
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
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">{{ __('Any') }}</label>
                        @if ($search || $selectedCategory || $selectedState || $selectedYear)
                            <button type="button" wire:click="resetFilters" class="text-[11px] font-semibold text-indigo-600 hover:text-indigo-800 transition">
                                {{ __('Netejar filtres') }}
                            </button>
                        @endif
                    </div>
                    <select wire:model.live="selectedYear"
                        class="w-full px-3 py-2 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">{{ __('Tots els anys') }}</option>
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
                            @if ($isAdmin)
                                <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">{{ __('Valor') }}</th>
                            @endif
                            <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">{{ __('Estat') }}</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Responsables') }}</th>
                            <th class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Accions') }}</th>
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
                                <td class="px-4 py-3.5 whitespace-nowrap text-sm font-bold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <span>{{ $item->nombre }}</span>
                                        @if ($item->year)
                                            <span class="text-[11px] font-normal text-slate-400">({{ $item->year }})</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-xs text-slate-500 hidden md:table-cell">
                                    {{ $item->category?->nombre ?? '-' }}
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-xs text-slate-800 font-bold">
                                    {{ $item->cantidad }} u.
                                </td>
                                @if ($isAdmin)
                                    <td class="px-4 py-3.5 whitespace-nowrap text-xs text-amber-600 font-bold hidden md:table-cell">
                                        {{ number_format($item->valor_total, 2, ',', '.') }} €
                                    </td>
                                @endif
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
                                    @if ($isAdmin)
                                        @if ($item->responsables->count() > 0)
                                            <span class="font-bold text-slate-800">{{ $item->responsables->pluck('name')->join(', ') }}</span>
                                        @else
                                            <span class="text-slate-400 italic">{{ __('Sense assignar') }}</span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[11px]">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                            {{ __('Assignat a tu') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-1.5" onclick="event.stopPropagation()">
                                        {{-- Ver detalles --}}
                                        @can('view', $item)
                                            <a href="{{ route('inventory.show', $item) }}"
                                                class="p-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition"
                                                title="{{ __('Veure detalls') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        {{-- Editar (solo admin) --}}
                                        @can('update', $item)
                                            <a href="{{ route('inventory.edit', $item) }}"
                                                class="p-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-100 shadow-xs transition"
                                                title="{{ __('Editar') }}">
                                                <x-editar w="16" h="16" />
                                            </a>
                                        @endcan

                                        {{-- Eliminar (solo admin) --}}
                                        @can('delete', $item)
                                            <button type="button" wire:click="confirmDelete({{ $item->id }})"
                                                class="p-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 shadow-xs transition"
                                                title="{{ __('Eliminar') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 7 : 6 }}" class="px-6 py-12 text-center text-slate-500">
                                    <p class="font-bold text-slate-800 text-base">{{ __('No s\'han trobat elements en l\'inventari') }}</p>
                                    <p class="text-xs mt-1">
                                        @if ($isAdmin)
                                            {{ __('Comprova els filtres de cerca o afig nou material.') }}
                                        @else
                                            {{ __('No coincideix cap dels teus materials assignats amb aquests filtres.') }}
                                        @endif
                                    </p>
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
    @endif

    {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN (Solo Administradores) --}}
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

                    <x-danger-button wire:click="deleteItem" wire:loading.attr="disabled">
                        {{ __('Eliminar definitivament') }}
                    </x-danger-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>
