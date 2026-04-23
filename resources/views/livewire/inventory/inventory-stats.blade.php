<div class="max-w-7xl mx-auto py-2 px-2 pb-24 sm:px-6 lg:px-8 space-y-6">
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl shadow-md">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-1">{{ __('Estadísticas') }}</h1>
                <p class="text-gray-600 dark:text-gray-300">{{ __('Distribución del valor del inventario por categoría') }}</p>
            </div>
        </div>
    </x-slot>

    <!-- Resumen general -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 dark:bg-gray-800">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{ __('Valor total del inventario') }}</h2>
            <span class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                €{{ number_format($stats['totalValue'], 2, ',', '.') }}
            </span>
        </div>

        @if (count($stats['categories']) === 0)
            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                {{ __('No hay items con valor registrado en el inventario.') }}
            </div>
        @else
            <!-- Gráfico global de distribución por categorías -->
            <div class="flex flex-col lg:flex-row items-center gap-8">
                <div class="w-full lg:w-64 h-64 flex-shrink-0">
                    <canvas id="chart-global"></canvas>
                </div>
                <div class="flex-1 w-full">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-3">
                        {{ __('Desglose por categoría') }}
                    </h3>
                    <div class="space-y-2">
                        @php
                            $paletteColors = ['#6366f1','#8b5cf6','#a78bfa','#c4b5fd','#ddd6fe','#ede9fe','#818cf8','#4f46e5','#7c3aed','#9333ea','#a21caf','#db2777'];
                        @endphp
                        @foreach ($stats['categories'] as $index => $category)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full flex-shrink-0"
                                        style="background-color: {{ $paletteColors[$index % 12] }}">
                                    </span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $category['nombre'] }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        €{{ number_format($category['totalValue'], 2, ',', '.') }}
                                    </span>
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300">
                                        {{ $category['percentage'] }}%
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Gráficos individuales por categoría -->
    @if (count($stats['categories']) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($stats['categories'] as $index => $category)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5 dark:bg-gray-800">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">{{ $category['nombre'] }}</h3>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 flex-shrink-0 ml-2">
                            {{ $category['percentage'] }}% {{ __('del total') }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        €{{ number_format($category['totalValue'], 2, ',', '.') }}
                    </p>

                    @if (count($category['items']) > 0)
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-40 h-40">
                                <canvas id="chart-category-{{ $category['id'] }}"></canvas>
                            </div>
                            <div class="w-full space-y-1">
                                @foreach ($category['items'] as $item)
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-600 dark:text-gray-400 truncate max-w-[60%]">{{ $item['nombre'] }}</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100 flex-shrink-0 ml-2">
                                            €{{ number_format($item['value'], 2, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center text-sm text-gray-400 py-4">{{ __('Sin items') }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <!-- Footer fijo con botón volver -->
    <footer
        class="fixed bottom-0 left-0 z-20 w-full border-t border-gray-300 bg-white shadow-md dark:border-gray-600 dark:bg-gray-800">
        <div class="mx-auto flex w-full max-w-5xl items-center gap-4 px-4 py-3">
            <a href="{{ url('/inventory') }}"
                class="flex flex-1 flex-col items-center text-gray-700 transition hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="text-xs mt-1 font-semibold">{{ __('Volver') }}</span>
            </a>
        </div>
    </footer>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const stats = @json($stats);
    const colors = ['#6366f1','#8b5cf6','#a78bfa','#c4b5fd','#ddd6fe','#ede9fe','#818cf8','#4f46e5','#7c3aed','#9333ea','#a21caf','#db2777'];

    const defaultOptions = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const value = context.parsed;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const pct = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return ' \u20ac' + value.toFixed(2).replace('.', ',') + ' (' + pct + '%)';
                    }
                }
            }
        },
        cutout: '65%',
    };

    // Gráfico global
    const globalLabels = stats.categories.map(c => c.nombre);
    const globalValues = stats.categories.map(c => c.totalValue);
    const globalColors = stats.categories.map((_, i) => colors[i % colors.length]);

    const globalCtx = document.getElementById('chart-global');
    if (globalCtx && globalValues.length > 0) {
        new Chart(globalCtx, {
            type: 'doughnut',
            data: {
                labels: globalLabels,
                datasets: [{
                    data: globalValues,
                    backgroundColor: globalColors,
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                ...defaultOptions,
                plugins: {
                    ...defaultOptions.plugins,
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                const label = context.label || '';
                                return ' ' + label + ': \u20ac' + value.toFixed(2).replace('.', ',') + ' (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // Gráficos por categoría
    stats.categories.forEach(function(category) {
        const ctx = document.getElementById('chart-category-' + category.id);
        if (!ctx || !category.items.length) { return; }

        const labels = category.items.map(i => i.nombre);
        const values = category.items.map(i => i.value);
        const itemColors = category.items.map((_, i) => colors[i % colors.length]);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: itemColors,
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: defaultOptions,
        });
    });
});
</script>
