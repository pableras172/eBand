<div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8 space-y-6">
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl shadow-md">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $item->nombre }}</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-0.5">{{ __('Detalle de Item') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Sección: Identificación -->
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-2 rounded-lg">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Identificación') }}</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 dark:divide-gray-700">
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Categoría') }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $item->category?->nombre ?? '-' }}</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Año') }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $item->year }}</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Estado') }}</p>
                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold
                        {{ $item->estado === 'nuevo' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
                          ($item->estado === 'usado' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' :
                          ($item->estado === 'desperfectos' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' :
                          'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400')) }}">
                        {{ ucfirst($item->estado) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Sección: Datos económicos -->
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-2 rounded-lg">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Datos económicos') }}</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 dark:divide-gray-700">
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Cantidad') }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $item->cantidad }}</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Valor Unitario') }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">€{{ number_format($item->valor_unitario, 2, ',', '.') }}</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Valor Total') }}</p>
                    <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">€{{ number_format($item->valor_total, 2, ',', '.') }}</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Depreciación anual') }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ number_format($item->depreciation_rate, 2, ',', '.') }}%</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Valor Residual') }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">€{{ number_format($item->valor_residual, 2, ',', '.') }}</p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Fecha de compra') }}</p>
                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $item->purchase_date?->format('d/m/Y') ?? '-' }}</p>
            </div>
        </div>

        <!-- Sección: Responsables y Observaciones -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-2 rounded-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Responsables') }}</h2>
                </div>
                <div class="px-6 py-4">
                    @if ($item->responsables->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach ($item->responsables as $responsable)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $responsable->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400 italic dark:text-gray-500">{{ __('Sin asignar') }}</p>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-br from-yellow-400 to-orange-500 p-2 rounded-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Observaciones') }}</h2>
                </div>
                <div class="px-6 py-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $item->observaciones ?: '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Sección: Histórico de movimientos -->
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="bg-gradient-to-br from-gray-500 to-gray-700 p-2 rounded-lg">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Histórico de movimientos') }}</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Fecha') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Tipo') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Usuario') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Descripción') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($item->movements as $movement)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-3 text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ $movement->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600 dark:text-gray-300">{{ ucfirst($movement->tipo) }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $movement->user?->name ?? '-' }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $movement->descripcion }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-sm text-gray-400 dark:text-gray-500 text-center italic">{{ __('No hay movimientos registrados') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Acciones -->
        <div class="flex justify-between items-center">
            <a href="{{ route('inventory.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Volver') }}
            </a>
            @can('update', $item)
                <a href="{{ route('inventory.edit', $item) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg text-sm font-medium hover:from-indigo-600 hover:to-purple-700 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Editar') }}
                </a>
            @endcan
        </div>

    </div>
</div>
