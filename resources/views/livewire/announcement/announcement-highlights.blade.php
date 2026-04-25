<div class="w-full mx-auto rounded-lg bg-white p-4 shadow-l">
    <div class="mb-3 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="rounded-lg bg-cyan-100 p-2">
                <svg class="h-5 w-5 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5a2 2 0 114 0v1.465a1 1 0 00.293.707l1.535 1.535A2 2 0 0117.414 12H8.586a2 2 0 01-1.414-3.414l1.535-1.535A1 1 0 009 7.465V5a2 2 0 012-2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17h6m-6 3h6" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">{{ __('Últimos anuncios') }}</h3>
        </div>
        @if ($announcements->isNotEmpty())
            <span class="rounded-full bg-cyan-50 px-2.5 py-1 text-xs font-semibold text-cyan-700">
                {{ $announcements->count() }}
            </span>
        @endif
    </div>

    @if ($announcements->isEmpty())
        <div class="rounded-md border border-dashed border-gray-300 bg-gray-50 px-4 py-6 text-center text-sm text-gray-500">
            {{ __('No hay anuncios disponibles en este momento.') }}
        </div>
    @else
        {{-- Carrusel --}}
        <div class="relative overflow-hidden">
            <div class="flex transition-transform duration-500 ease-in-out"
                 id="announcementCarouselTrack"
                 style="width: {{ $announcements->count() * 100 }}%">
                @foreach ($announcements as $announcement)
                    <div style="width: {{ round(100 / $announcements->count(), 6) }}%" class="px-1">
                        <button type="button"
                                wire:click="openAnnouncement({{ $announcement->id }})"
                                class="group w-full overflow-hidden rounded-xl border border-cyan-100 text-left shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                            <div class="bg-gradient-to-r from-cyan-600 to-teal-500 px-4 py-3">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="line-clamp-2 text-sm font-bold leading-snug text-white">
                                        {{ $announcement->title }}
                                    </p>
                                    <span class="shrink-0 rounded bg-white/20 px-1.5 py-0.5 text-xs text-white">
                                        {{ optional($announcement->created_at)->format('d/m') }}
                                    </span>
                                </div>
                            </div>
                            <div class="bg-white px-4 py-3">
                                <p class="line-clamp-3 text-xs leading-relaxed text-gray-600">
                                    {{ \Illuminate\Support\Str::limit(strip_tags((string) $announcement->body), 130) }}
                                </p>
                                <div class="mt-3 flex items-center gap-1.5 text-cyan-600">
                                    <span class="relative flex h-2 w-2 shrink-0">
                                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-75"></span>
                                        <span class="relative inline-flex h-2 w-2 rounded-full bg-cyan-500"></span>
                                    </span>
                                    <span class="text-xs font-semibold">{{ __('Pulsa para leer') }}</span>
                                    <svg class="h-3 w-3 transition-transform group-hover:translate-x-1"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Indicadores --}}
        @if ($announcements->count() > 1)
            <div class="mt-3 flex justify-center gap-2">
                @foreach ($announcements as $announcement)
                    <button class="ann-carousel-dot h-2 rounded-full transition-all {{ $loop->first ? 'w-5 bg-cyan-600' : 'w-2 bg-gray-300' }}"
                            data-index="{{ $loop->index }}"></button>
                @endforeach
            </div>
        @endif
    @endif
</div>

@if ($announcements->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const totalCards = @json($announcements->count());
            if (totalCards <= 1) {
                return;
            }

            let currentIndex = 0;
            const track = document.getElementById('announcementCarouselTrack');
            const dots = document.querySelectorAll('.ann-carousel-dot');
            const step = 100 / totalCards;

            function updateCarousel() {
                track.style.transform = `translateX(-${currentIndex * step}%)`;
                dots.forEach(function (dot, i) {
                    if (i === currentIndex) {
                        dot.classList.add('bg-cyan-600', 'w-5');
                        dot.classList.remove('bg-gray-300', 'w-2');
                    } else {
                        dot.classList.remove('bg-cyan-600', 'w-5');
                        dot.classList.add('bg-gray-300', 'w-2');
                    }
                });
            }

            let startX = 0;
            track.addEventListener('touchstart', function (e) {
                startX = e.touches[0].clientX;
            });
            track.addEventListener('touchend', function (e) {
                const diff = startX - e.changedTouches[0].clientX;
                if (diff > 50 && currentIndex < totalCards - 1) {
                    currentIndex++;
                } else if (diff < -50 && currentIndex > 0) {
                    currentIndex--;
                }
                updateCarousel();
            });

            dots.forEach(function (dot, i) {
                dot.addEventListener('click', function () {
                    currentIndex = i;
                    updateCarousel();
                });
            });

            setInterval(function () {
                currentIndex = (currentIndex + 1) % totalCards;
                updateCarousel();
            }, 5000);
        });
    </script>
@endif
