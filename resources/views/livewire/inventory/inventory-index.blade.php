<div class="max-w-7xl mx-auto py-2 px-2 pb-24 sm:px-6 lg:px-8 space-y-4">
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl shadow-md">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-1">{{ __('Inventario') }}</h1>
                <p class="text-gray-600 dark:text-gray-300">{{ __('Gestión de items y equipamiento') }}</p>
            </div>
        </div>
    </x-slot>

    <div>
        <!-- Filtros -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-4">
            @unless($isAdmin)
                <div class="mb-4 rounded-md border border-blue-100 bg-blue-50 px-3 py-2 text-sm text-blue-700">
                    {{ __('Mostrando únicamente los items que tienes asignados.') }}
                </div>
            @endunless

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Búsqueda -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Buscar') }}</label>
                    <input type="text" wire:model.live="search" placeholder="{{ __('Nombre u observaciones') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Categoría') }}</label>
                    <select wire:model.live="selectedCategory"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">{{ __('Todas') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Estado') }}</label>
                    <select wire:model.live="selectedState"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">{{ __('Todos') }}</option>
                        @foreach ($states as $state)
                            <option value="{{ $state }}">{{ ucfirst($state) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Año -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Año') }}</label>
                    <select wire:model.live="selectedYear"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabla de items -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nombre') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">{{ __('Categoría') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Cantidad') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">{{ __('Valor Total') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">{{ __('Estado') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Responsables') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
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
                                    class="cursor-pointer hover:bg-gray-50"
                                    role="link"
                                    tabindex="0"
                                    onclick="window.location='{{ $rowUrl }}'"
                                    onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); window.location='{{ $rowUrl }}'; }"
                                @else
                                    class="hover:bg-gray-50"
                                @endif>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">{{ $item->category->nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->cantidad }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold hidden md:table-cell">
                                    €{{ number_format($item->valor_total, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->estado === 'nuevo' ? 'bg-green-100 text-green-800' : ($item->estado === 'usado' ? 'bg-blue-100 text-blue-800' : ($item->estado === 'desperfectos' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($item->estado) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if ($item->responsables->count() > 0)
                                        <span class="text-xs">{{ $item->responsables->pluck('name')->join(', ') }}</span>
                                    @else
                                        <span class="text-gray-400 italic">{{ __('Sin asignar') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium hidden md:table-cell">
                                    <div class="flex items-center gap-3">
                                        @can('view', $item)
                                            <a href="{{ route('inventory.show', $item) }}" onclick="event.stopPropagation()" class="text-gray-700 hover:text-gray-900">{{ __('Ver') }}</a>
                                        @endcan

                                        @can('update', $item)
                                            <a href="{{ route('inventory.edit', $item) }}" onclick="event.stopPropagation()" class="text-indigo-600 hover:text-indigo-900">{{ __('Editar') }}</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ __('No hay items en el inventario') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4">
                {{ $items->links() }}
            </div>
        </div>
    </div>
    <footer
        class="fixed bottom-0 left-0 z-20 w-full border-t border-gray-300 bg-white shadow-md dark:border-gray-600 dark:bg-gray-800">
        <div class="mx-auto flex w-full max-w-5xl items-center gap-4 px-4 py-3">
            <!-- Exportar Excel -->
            <a href="{{ route('inventory.export.excel', ['year' => $selectedYear]) }}"
                class="flex flex-1 flex-col items-center text-gray-700 transition hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20a2,2 0 0,0 2,2H18a2,2 0 0,0 2,-2V8L14,2M18,20H6V4h7V9h5V20Z" />
                    <path d="M16,11H15V15h1V11m-3,0H12V15h1V11M10,11H9V15h1V11" fill="#10b981" />
                </svg>
                <span class="text-xs mt-1 font-semibold">{{ __('Excel') }}</span>
            </a>

            <!-- Exportar PDF -->
            <a href="{{ route('inventory.export.pdf', ['year' => $selectedYear]) }}"
                class="flex flex-1 flex-col items-center text-gray-700 transition hover:text-red-600 dark:text-gray-300 dark:hover:text-red-400">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20a2,2 0 0,0 2,2H18a2,2 0 0,0 2,-2V8L14,2M18,20H6V4h7V9h5V20M8,15.5C8,14.12 8.88,13 10,13C11.12,13 12,14.12 12,15.5C12,16.88 11.12,18 10,18C8.88,18 8,16.88 8,15.5M14,13H16V18H14V13Z" fill="#ef4444" />
                </svg>
                <span class="text-xs mt-1 font-semibold">{{ __('PDF') }}</span>
            </a>

            <!-- Estadísticas (solo admin) -->
            @if ($isAdmin)
                <a href="{{ url('/inventory/stats') }}"
                    class="flex flex-1 flex-col items-center text-gray-700 transition hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    <span class="text-xs mt-1 font-semibold">{{ __('Estadísticas') }}</span>
                </a>
            @endif

            <!-- Crear Item (solo admin) -->
            @can('create', App\Models\InventoryItem::class)
                <a href="{{ route('inventory.create') }}"
                    class="flex flex-1 flex-col items-center text-gray-700 transition hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
                    </svg>
                    <span class="text-xs mt-1 font-semibold">{{ __('Crear') }}</span>
                </a>
            @endcan
        </div>
    </footer>
</div>
