<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-slate-100 py-2 sm:py-4">
        <x-dashboard.command-center />
    </div>

    <livewire:announcement.announcement-popup />
    @php
        $driverSteps = [
            ['element' => '#dashboard-messages', 'popover' => ['title' => __('Mensajes'), 'description' => __('Aquí verás los mensajes recientes de la dirección y compañeros.'), 'position' => 'bottom']],
            ['element' => '#dashboard-planning', 'popover' => ['title' => __('Planificación'), 'description' => __('Accede a la planificación y próximas actuaciones.'), 'position' => 'bottom']],
            ['element' => '#dashboard-nextconcert', 'popover' => ['title' => __('Próximo concierto'), 'description' => __('Detalles del siguiente concierto programado.'), 'position' => 'right']],
            ['element' => '#dashboard-activities', 'popover' => ['title' => __('actividades.title'), 'description' => __('actividades.subtitle'), 'position' => 'bottom']],
            ['element' => '#dashboard-stats', 'popover' => ['title' => __('Estadísticas'), 'description' => __('Visualiza estadísticas de asistencia y actividad.'), 'position' => 'left']],
            ['element' => '#dashboard-announcements', 'popover' => ['title' => __('Anuncios'), 'description' => __('Anuncios importantes y avisos.'), 'position' => 'top']],
            ['element' => '#dashboard-funfacts', 'popover' => ['title' => __('Datos curiosos'), 'description' => __('Curiosidades y datos interesantes sobre la banda.'), 'position' => 'top']],
            ['element' => '#dashboard-map', 'popover' => ['title' => __('Mapas'), 'description' => __('Mapa con localizaciones de actuaciones.'), 'position' => 'top']],
        ];
    @endphp

    <script>
        // Auto-start the driver tour once per user (per browser) using localStorage flag
        (function () {
            const STORAGE_KEY = 'eband_driver_tour_shown_v1';
            try {
                if (localStorage.getItem(STORAGE_KEY)) return;
            } catch (e) {
                // localStorage might be unavailable; abort silently
                return;
            }

            const driverSteps = @json($driverSteps);

            function tryStart() {
                if (window.startDriverTour && typeof window.startDriverTour === 'function') {
                    try {
                        window.startDriverTour(driverSteps);
                        localStorage.setItem(STORAGE_KEY, '1');
                    } catch (err) {
                        console.error('Error starting driver tour:', err);
                    }
                } else {
                    // Retry a few times in case scripts load later
                    setTimeout(tryStart, 500);
                }
            }

            document.addEventListener('DOMContentLoaded', tryStart);
        })();
    </script>
    
</x-app-layout>
