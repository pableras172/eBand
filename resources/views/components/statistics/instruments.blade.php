@props(['userId'])

<div x-data="{
    userId: {{ $userId ?? 'null' }},
    stats: {
        totalMusicians: 0,
        instruments: []
    },
    loading: false,
    chart: null,
    palette: ['#4f46e5', '#0891b2', '#16a34a', '#ea580c', '#d946ef', '#eab308', '#f43f5e', '#14b8a6', '#8b5cf6', '#0ea5e9', '#84cc16', '#f97316'],
    
    async init() {
        await this.loadStats();
    },
    
    async loadStats() {
        this.loading = true;
        try {
            const response = await fetch('/api/instrument-musicians-stats');
            const data = await response.json();
            this.stats = {
                totalMusicians: data.total_musicians ?? 0,
                instruments: Array.isArray(data.instruments) ? data.instruments : []
            };
            this.renderChart();
        } catch (error) {
            console.error('Error cargando estadísticas de instrumentos:', error);
        } finally {
            this.loading = false;
        }
    },
    
    renderChart() {
        const ctx = this.$refs.instrumentsChart;
        if (!ctx) return;
        
        if (this.chart) {
            this.chart.destroy();
        }

        const labels = this.stats.instruments.map((instrument) => instrument.name);
        const data = this.stats.instruments.map((instrument) => instrument.musicians);
        const colors = this.stats.instruments.map((_, index) => this.palette[index % this.palette.length]);
        
        this.chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    spacing: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '62%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        borderRadius: 8,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed ?? 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value} {{ __('músics') }} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }
}" 


class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-24 bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-200 dark:border-gray-700">
    
    <!-- Título con icono -->
    <div class="flex items-center space-x-2 mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-2 rounded-lg">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.657-1.79 3-4 3s-4-1.343-4-3 1.79-3 4-3 4 1.343 4 3zm12-3c0 1.657-1.79 3-4 3s-4-1.343-4-3 1.79-3 4-3 4 1.343 4 3z" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Músics per instrument') }}</h3>
    </div>

    <div x-show="!loading" x-cloak class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-center">
            <div class="lg:col-span-3 flex justify-center">
                <div class="relative w-full max-w-[32rem] aspect-square">
                    <canvas x-ref="instrumentsChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <div class="text-5xl font-extrabold bg-gradient-to-r from-indigo-600 via-cyan-600 to-emerald-600 bg-clip-text text-transparent" x-text="stats.totalMusicians"></div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-2 tracking-wide uppercase">{{ __('Músics totals') }}</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                    <template x-for="(instrument, index) in stats.instruments" :key="instrument.id">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full" :style="`background-color: ${palette[index % palette.length]}`"></span>
                                <span class="text-sm text-gray-700 dark:text-gray-300" x-text="instrument.name"></span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="instrument.musicians"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Indicador de carga -->
    <div x-show="loading" class="flex items-center justify-center py-16">
        <div class="flex flex-col items-center space-y-4">
            <div class="relative">
                <div class="w-16 h-16 border-4 border-indigo-200 dark:border-indigo-900 rounded-full"></div>
                <div class="w-16 h-16 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin absolute top-0 left-0"></div>
            </div>
            <span class="text-gray-500 dark:text-gray-400 font-medium">{{ __('Cargando datos...') }}</span>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
</style>
