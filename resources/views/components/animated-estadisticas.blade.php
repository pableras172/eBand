@php
    $user = Auth::user();
    $usuarioActivo = session('usuarioActivo', $user);
@endphp

<div class="flex flex-col items-center space-y-2">

    <!-- Contenedor del carrusel de estadísticas -->
    <div class="overflow-hidden w-full max-w-sm sm:max-w-2xl mx-auto relative px-2 sm:px-4">
        <div class="flex transition-transform duration-500 ease-in-out" id="carouselContainer" style="width: 200%;">
            <!-- Card para estadísticas de ensayos -->
            <div class="w-1/2 px-1 sm:px-2">
                <div id="statCardEnsayo" class="bg-white rounded-lg sm:rounded-xl shadow-lg border border-gray-200 p-4 sm:p-6 transition-all hover:shadow-xl">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <div class="flex items-center space-x-1.5 sm:space-x-2">
                            <div class="bg-blue-100 p-1.5 sm:p-2 rounded-lg">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm font-medium text-gray-600">{{ __("Ensayos") }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-2 sm:space-y-3">
                        <div id="percentEnsayo" class="text-3xl sm:text-4xl font-bold text-gray-900">--%</div>
                        <div id="descriptionEnsayo" class="flex items-center flex-wrap gap-1 sm:gap-2 text-xs sm:text-sm">
                            <span class="text-gray-600">{{ __("Cargando datos...") }}</span>
                        </div>
                        <div class="mt-3 sm:mt-4 h-12 sm:h-16">
                            <canvas id="actuacionesChartEnsayo"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card para estadísticas de conciertos -->
            <div class="w-1/2 px-1 sm:px-2">
                <div id="statCardConcierto" class="bg-white rounded-lg sm:rounded-xl shadow-lg border border-gray-200 p-4 sm:p-6 transition-all hover:shadow-xl">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <div class="flex items-center space-x-1.5 sm:space-x-2">
                            <div class="bg-purple-100 p-1.5 sm:p-2 rounded-lg">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm font-medium text-gray-600">{{ __("Conciertos") }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-2 sm:space-y-3">
                        <div id="percentConcierto" class="text-3xl sm:text-4xl font-bold text-gray-900">--%</div>
                        <div id="descriptionConcierto" class="flex items-center flex-wrap gap-1 sm:gap-2 text-xs sm:text-sm">
                            <span class="text-gray-600">{{ __("Cargando datos...") }}</span>
                        </div>
                        <div class="mt-3 sm:mt-4 h-12 sm:h-16">
                            <canvas id="actuacionesChartConcierto"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Indicadores de navegación -->
        <div class="flex justify-center gap-2 mt-3 sm:mt-4">
            <button class="carousel-indicator w-2 h-2 rounded-full bg-blue-600 transition-all" data-index="0"></button>
            <button class="carousel-indicator w-2 h-2 rounded-full bg-gray-300 transition-all" data-index="1"></button>
        </div>
    </div>

    <x-lottie class="w-48 h-32 sm:w-72 sm:h-48" path="{{ asset('storage/animaciones/estadisticas.json') }}"
        loop="true" autoplay="true" />

    <div class="flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
        </svg>

        <a href="{{ route('actuaciones.usuario.anyo', [$usuarioActivo->id, date('Y')]) }}"
            class="text-sm sm:text-base font-semibold hover:underline">
            {{ __('Les meves actuacions') }}
        </a>
    </div>
</div>

<script>
    const translations = {
        asistencia: @json(__('Has asistido al')),
        deTotal: @json(__('de')),
        actuaciones: @json(__('actuaciones'))
    };

    document.addEventListener("DOMContentLoaded", function() {
        const userId = {{ $usuarioActivo->id }};        
        const year = new Date().getFullYear();
        let currentIndex = 0;

        function fetchAndRenderChart(tipo, canvasId) {
            fetch(`/actuaciones/${userId}/${year}/e/${tipo}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.labels;
                    const dataset = data.data;
                    const percent = data.percentages[1] || 0;
                    const total = dataset.reduce((a, b) => a + b, 0);
                    const asistidos = dataset[1] || 0;

                    // Actualizar porcentaje principal
                    const percentElement = document.getElementById(`percent${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`);
                    percentElement.textContent = `${percent}%`;
                    percentElement.className = percent >= 50 ? 
                        'text-4xl font-bold text-green-600' : 
                        'text-4xl font-bold text-red-600';

                    // Actualizar descripción con icono
                    const descriptionElement = document.getElementById(`description${tipo.charAt(0).toUpperCase() + tipo.slice(1)}`);
                    const iconSize = window.innerWidth < 640 ? 'w-4 h-4' : 'w-5 h-5';
                    const icon = percent >= 50 ? 
                        `<svg class="${iconSize} text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>` :
                        `<svg class="${iconSize} text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>`;
                    
                    const color = percent >= 50 ? 'text-green-600' : 'text-red-600';
                    descriptionElement.innerHTML = `
                        <span class="${color} font-semibold">${asistidos} ${translations.deTotal} ${total}</span>
                        <span class="text-gray-600">${translations.actuaciones}</span>
                        ${icon}
                    `;

                    // Crear mini gráfico de línea
                    const ctx = document.getElementById(canvasId).getContext('2d');
                    
                    // Generar colores degradados
                    const gradient = ctx.createLinearGradient(0, 0, 0, 60);
                    if (percent >= 50) {
                        gradient.addColorStop(0, 'rgba(34, 197, 94, 0.3)');
                        gradient.addColorStop(1, 'rgba(34, 197, 94, 0.0)');
                    } else {
                        gradient.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
                        gradient.addColorStop(1, 'rgba(239, 68, 68, 0.0)');
                    }

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: dataset,
                                backgroundColor: gradient,
                                borderColor: percent >= 50 ? 'rgb(34, 197, 94)' : 'rgb(239, 68, 68)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 0,
                                pointHoverRadius: 4,
                                pointHoverBackgroundColor: percent >= 50 ? 'rgb(34, 197, 94)' : 'rgb(239, 68, 68)',
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                    callbacks: {
                                        label: function(context) {
                                            return `${labels[context.dataIndex]}: ${context.parsed.y}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    display: false
                                },
                                y: {
                                    display: false,
                                    beginAtZero: true
                                }
                            },
                            interaction: {
                                mode: 'nearest',
                                axis: 'x',
                                intersect: false
                            }
                        }
                    });
                })
                .catch(error => console.error(`Error al obtener datos de ${tipo}:`, error));
        }

        fetchAndRenderChart("ensayo", "actuacionesChartEnsayo");
        fetchAndRenderChart("concierto", "actuacionesChartConcierto");

        // Manejo del deslizamiento táctil
        let startX = 0;
        let endX = 0;
        const carouselContainer = document.getElementById("carouselContainer");
        const indicators = document.querySelectorAll(".carousel-indicator");

        function updateCarousel() {
            carouselContainer.style.transform = `translateX(-${currentIndex * 50}%)`;
            indicators.forEach((indicator, index) => {
                if (index === currentIndex) {
                    indicator.classList.add('bg-blue-600', 'w-6');
                    indicator.classList.remove('bg-gray-300', 'w-2');
                } else {
                    indicator.classList.remove('bg-blue-600', 'w-6');
                    indicator.classList.add('bg-gray-300', 'w-2');
                }
            });
        }

        // Touch events
        carouselContainer.addEventListener("touchstart", (e) => startX = e.touches[0].clientX);
        carouselContainer.addEventListener("touchend", (e) => {
            endX = e.changedTouches[0].clientX;
            if (startX - endX > 50 && currentIndex === 0) {
                currentIndex = 1;
            } else if (endX - startX > 50 && currentIndex === 1) {
                currentIndex = 0;
            }
            updateCarousel();
        });

        // Click en indicadores
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentIndex = index;
                updateCarousel();
            });
        });
    });
</script>
