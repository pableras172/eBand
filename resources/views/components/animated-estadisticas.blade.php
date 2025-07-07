@php
    $user = Auth::user();
    $usuarioActivo = session('usuarioActivo', $user);
@endphp

<div class="flex flex-col items-center space-y-2">

    <!-- Contenedor del carrusel de gráficos -->
    <div class="overflow-hidden w-full max-w-xl mx-auto relative">
        <div class="flex transition-transform duration-500 ease-in-out" id="carouselContainer" style="width: 200%;">
            <!-- Panel para la gráfica de tipo ensayo -->
            <div
                class="w-1/2 p-2 bg-white shadow-md rounded-lg flex justify-center items-center border border-gray-200 cursor-pointer transition-transform hover:shadow-md relative overflow-hidden max-w-xs mx-auto">
                <canvas id="actuacionesChartEnsayo" style="max-width: 220px; max-height: 220px;"></canvas>
                <div>
                    <p id="labelensayo"></p>
                </div>
            </div>
            <!-- Panel para la gráfica de tipo concierto (inicialmente oculto) -->
            <div
                class="w-1/2 p-2 bg-white shadow-md rounded-lg flex justify-center items-center border border-gray-200 cursor-pointer transition-transform hover:shadow-md relative overflow-hidden max-w-xs mx-auto">
                <canvas id="actuacionesChartConcierto" style="max-width: 220px; max-height: 220px;"></canvas>
                <p id="labelconcierto"></p>
            </div>
        </div>
    </div>

    <x-lottie style="width: 300px; height: 200px;" path="{{ asset('storage/animaciones/estadisticas.json') }}"
        loop="true" autoplay="true" />

    <div class="flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
        </svg>

        <a href="{{ route('actuaciones.usuario.anyo', [$usuarioActivo->id, date('Y')]) }}"
            class="font-semibold hover:underline">
            {{ __('Les meves actuacions') }}
        </a>
    </div>
</div>

<script>
    const translations = {
        asistencia: @json(__('Has asistido al'))
    };

    document.addEventListener("DOMContentLoaded", function() {
        const userId = {{ $usuarioActivo->id }};        
        const year = new Date().getFullYear();
        let currentIndex = 0;

        function fetchAndRenderChart(tipo, canvasId) {
            fetch(`/actuaciones/${userId}/${year}/e/${tipo}`)
                .then(response => response.json())
                .then(data => {
                    const tit = tipo == 'ensayo' ? 'Porcentaje de ensayos de en  ':
                        'Porcentaje de conciertos en ';
                    const labels = data.labels;
                    const dataset = data.data;
                    const backgroundColors = labels.map(() =>
                        `rgba(${Math.random()*256}, ${Math.random()*256}, ${Math.random()*256}, 0.6)`);
                    const borderColors = backgroundColors.map(color => color.replace('0.6', '1'));

                    const ctx = document.getElementById(canvasId).getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Número de actuaciones',
                                data: dataset,
                                backgroundColor: backgroundColors,
                                borderColor: borderColors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                title: {
                                    display: true,
                                    text: `${tit} ${year}`
                                }
                            }
                        }
                    });

                    let percent = data.percentages[1] || 0;
                    let mensaje = percent < 50 ?
                        `${translations.asistencia} ${percent}% ❗` :
                        `${translations.asistencia} ${percent}% ✅`;
                    
                    let label = document.getElementById("label" + tipo);
                    label.textContent = mensaje;
                })
                .catch(error => console.error(`Error al obtener datos de ${tipo}:`, error));
        }

        fetchAndRenderChart("ensayo", "actuacionesChartEnsayo");
        fetchAndRenderChart("concierto", "actuacionesChartConcierto");

        // Manejo del deslizamiento
        let startX = 0;
        let endX = 0;
        const carouselContainer = document.getElementById("carouselContainer");

        carouselContainer.addEventListener("touchstart", (e) => startX = e.touches[0].clientX);
        carouselContainer.addEventListener("touchend", (e) => {
            endX = e.changedTouches[0].clientX;
            handleSwipe();
        });

        function handleSwipe() {
            if (startX - endX > 50 && currentIndex === 0) {
                currentIndex = 1;
            } else if (endX - startX > 50 && currentIndex === 1) {
                currentIndex = 0;
            }
            carouselContainer.style.transform = `translateX(-${currentIndex * 50}%)`;
        }
    });
</script>
