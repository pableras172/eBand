@props(['userId'])

<div x-data="{
    userId: {{ $userId }},
    currentYear: new Date().getFullYear(),
    selectedYear: new Date().getFullYear(),
    selectedTipo: '',
    tipos: [],
    stats: {
        total: 0,
        usuario: 0,
        porcentaje: 0
    },
    loading: false,
    chart: null,
    
    async init() {
        await this.loadTipos();
    },
    
    async loadTipos() {
        try {
            const response = await fetch('/api/tipoactuacions');
            this.tipos = await response.json();
            if (this.tipos.length > 0) {
                this.selectedTipo = this.tipos[0].id;
                await this.loadStats();
            }
        } catch (error) {
            console.error('Error cargando tipos:', error);
        }
    },
    
    async loadStats() {
        if (!this.selectedTipo) return;
        
        this.loading = true;
        try {
            const response = await fetch(`/api/user-stats?user_id=${this.userId}&year=${this.selectedYear}&tipo_id=${this.selectedTipo}`);
            this.stats = await response.json();
            this.renderChart();
        } catch (error) {
            console.error('Error cargando estadísticas:', error);
        } finally {
            this.loading = false;
        }
    },
    
    renderChart() {
        const ctx = document.getElementById('statsChart');
        if (!ctx) return;
        
        if (this.chart) {
            this.chart.destroy();
        }
        
        const participadas = this.stats.usuario;
        const noParticipadas = this.stats.total - this.stats.usuario;
        
        const gradient1 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradient1.addColorStop(0, 'rgba(99, 102, 241, 1)');
        gradient1.addColorStop(1, 'rgba(168, 85, 247, 1)');
        
        const gradient2 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradient2.addColorStop(0, 'rgba(229, 231, 235, 1)');
        gradient2.addColorStop(1, 'rgba(209, 213, 219, 1)');
        
        this.chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['{{ __('Actuacions participades') }}', '{{ __('No participades') }}'],
                datasets: [{
                    data: [participadas, noParticipadas],
                    backgroundColor: [gradient1, gradient2],
                    borderWidth: 0,
                    borderRadius: 8,
                    spacing: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '75%',
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
                                const value = context.parsed || 0;
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
    },
    
    get years() {
        return [this.currentYear, this.currentYear - 1, this.currentYear - 2];
    }
}" 
class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-200 dark:border-gray-700">
    
    <!-- Título con icono -->
    <div class="flex items-center space-x-2 mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-2 rounded-lg">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Estadístiques') }}</h3>
    </div>
    
    <!-- Selectores -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <!-- Selector de Año -->
        <div>
            <label for="year-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('Any') }}
            </label>
            <select 
                id="year-select"
                x-model="selectedYear"
                @change="loadStats()"
                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all">
                <template x-for="year in years" :key="year">
                    <option :value="year" x-text="year"></option>
                </template>
            </select>
        </div>
        
        <!-- Selector de Tipo de Actuación -->
        <div>
            <label for="tipo-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('Tipus de actuacio') }}
            </label>
            <select 
                id="tipo-select"
                x-model="selectedTipo"
                @change="loadStats()"
                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all">
                <template x-for="tipo in tipos" :key="tipo.id">
                    <option :value="tipo.id" x-text="tipo.nombre"></option>
                </template>
            </select>
        </div>
    </div>
    
    <!-- Widget de Estadísticas -->
    <div x-show="!loading" x-cloak class="space-y-6">
        <!-- Gráfico Circular y Estadísticas -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-center">
            <!-- Gráfico Donut -->
            <div class="lg:col-span-2 flex justify-center">
                <div class="relative w-56 h-56">
                    <canvas id="statsChart"></canvas>
                    <!-- Porcentaje central -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent" x-text="stats.porcentaje + '%'"></div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Participació') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Cards de Estadísticas -->
            <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Total de Actuaciones -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-5 border border-blue-200 dark:border-blue-800 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between mb-3">
                        <div class="bg-blue-100 dark:bg-blue-900/40 p-2.5 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ __('Total Actuacions') }}</div>
                        <div class="text-3xl font-bold text-blue-900 dark:text-blue-100" x-text="stats.total"></div>
                    </div>
                </div>
                
                <!-- Actuaciones del Usuario -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-5 border border-green-200 dark:border-green-800 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between mb-3">
                        <div class="bg-green-100 dark:bg-green-900/40 p-2.5 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <div class="text-sm font-medium text-green-600 dark:text-green-400">{{ __('Actuacions participades') }}</div>
                        <div class="text-3xl font-bold text-green-900 dark:text-green-100" x-text="stats.usuario"></div>
                    </div>
                </div>
                
                <!-- Leyenda del gráfico -->
                <div class="sm:col-span-2 bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Actuacions participades') }}</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="stats.usuario"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('No participades') }}</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-gray-100" x-text="stats.total - stats.usuario"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Barra de progreso -->
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Progress') }}</span>
                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    <span x-text="stats.usuario"></span> / <span x-text="stats.total"></span>
                </span>
            </div>
            <div class="relative w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                <div 
                    class="absolute top-0 left-0 h-full bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-600 rounded-full transition-all duration-1000 ease-out"
                    :style="`width: ${stats.porcentaje}%`">
                </div>
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>
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
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    .animate-shimmer {
        animation: shimmer 2s infinite;
    }
</style>
