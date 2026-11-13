<div x-data="{
    currentYear: new Date().getFullYear(),
    selectedYear: new Date().getFullYear(),
    years: [],
    stats: {
        total: 0,
        tipos: []
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
            const response = await fetch(`/api/tipo-actuacion-stats?year=${this.selectedYear}`);
            const data = await response.json();

            this.years = Array.isArray(data.years) && data.years.length > 0
                ? data.years
                : [this.currentYear, this.currentYear - 1, this.currentYear - 2];

            this.selectedYear = data.year ?? this.selectedYear;
            this.stats = {
                total: data.total ?? 0,
                tipos: Array.isArray(data.tipos) ? data.tipos : []
            };

            this.renderChart();
        } catch (error) {
            console.error('Error cargando estadísticas por tipo:', error);
        } finally {
            this.loading = false;
        }
    },
    
    renderChart() {
        const ctx = this.$refs.tiposChart;
        if (!ctx) return;
        
        if (this.chart) {
            this.chart.destroy();
        }

        const labels = this.stats.tipos.map((tipo) => tipo.name);
        const data = this.stats.tipos.map((tipo) => tipo.total);
        const colors = this.stats.tipos.map((_, index) => this.palette[index % this.palette.length]);
        
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
                                return `${label}: ${value} (${percentage}%)`;
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


class="max-w-6xl mx-auto space-y-6 bg-white shadow-bento rounded-3xl p-6 lg:p-8 border border-indigo-50/80">
    
    <!-- Título con icono -->
    <div class="flex items-center space-x-2 mb-6 pb-4 border-b border-indigo-50">
        <div class="w-9 h-9 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.657-1.79 3-4 3s-4-1.343-4-3 1.79-3 4-3 4 1.343 4 3zm12-3c0 1.657-1.79 3-4 3s-4-1.343-4-3 1.79-3 4-3 4 1.343 4 3z" />
            </svg>
        </div>
        <h3 class="text-base font-bold font-headline text-slate-900 uppercase tracking-wider">{{ __('Tipus d\'actuació per any') }}</h3>
    </div>

    <div>
        <label for="year-select-tipo" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
            {{ __('Any') }}
        </label>
        <select
            id="year-select-tipo"
            x-model="selectedYear"
            @change="loadStats()"
            class="w-full md:w-64 rounded-2xl border border-indigo-100 bg-[#F5F6FC] px-4 py-2.5 text-xs font-bold text-slate-800 shadow-xs focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all">
            <template x-for="year in years" :key="year">
                <option :value="year" x-text="year"></option>
            </template>
        </select>
    </div>

    <div x-show="!loading" x-cloak class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-center">
            <div class="lg:col-span-3 flex justify-center">
                <div class="relative w-full max-w-[28rem] aspect-square">
                    <canvas x-ref="tiposChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <div class="text-4xl sm:text-5xl font-extrabold text-slate-900" x-text="stats.total"></div>
                        <div class="text-xs text-slate-400 mt-1 tracking-wider uppercase font-bold">{{ __('Actuacions totals') }}</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 bg-[#F5F6FC] rounded-2xl p-4 border border-indigo-50/70">
                <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                    <template x-for="(tipo, index) in stats.tipos" :key="tipo.id">
                        <div class="flex items-center justify-between text-xs py-1 border-b border-indigo-50/80 last:border-0">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full" :style="`background-color: ${palette[index % palette.length]}`"></span>
                                <span class="text-slate-700 font-semibold" x-text="tipo.name"></span>
                            </div>
                            <span class="font-bold text-indigo-700 bg-white shadow-xs border border-indigo-100 px-2 py-0.5 rounded-md" x-text="tipo.percentage + '%' "></span>
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
