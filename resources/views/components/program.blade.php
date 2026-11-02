@php
    use App\Models\ConcertProgram;
    use Carbon\Carbon;

    $nextConcert = ConcertProgram::query()
        ->with('pieces')
        ->where('is_published', true)
        ->where('is_featured', true)
        ->orderBy('event_date')
        ->orderBy('event_time')
        ->first();

    if (! $nextConcert) {
        $nextConcert = ConcertProgram::query()
            ->with('pieces')
            ->where('is_published', true)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->first();
    }

    if (! $nextConcert) {
        $nextConcert = ConcertProgram::query()
            ->with('pieces')
            ->where('is_published', true)
            ->orderByDesc('event_date')
            ->orderByDesc('event_time')
            ->first();
    }
@endphp

<div class="w-full mx-auto bg-white shadow-l rounded-lg p-4 mt-1 mb-1">
    <div class="flex items-center justify-center gap-2 mb-3">
        <x-concert w="24" h="24" />
        <h3 class="text-lg font-semibold text-gray-800">{{ __('Proximo concierto') }}</h3>
    </div>
    <hr class="mb-3">

    @if ($nextConcert)
        <div class="rounded-lg bg-cyan-50 p-3">
            <h4 class="text-base font-bold text-gray-900">{{ $nextConcert->title }}</h4>

            <div class="mt-2 grid grid-cols-1 gap-2 text-sm text-gray-700 sm:grid-cols-2">
                <p class="inline-flex items-center gap-2">
                    <svg class="h-4 w-4 text-cyan-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-semibold">{{ __('Fecha') }}:</span>
                    {{ Carbon::parse($nextConcert->event_date)->format('d/m/Y') }}
                </p>
                <p class="inline-flex items-center gap-2">
                    <svg class="h-4 w-4 text-cyan-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-semibold">{{ __('Hora') }}:</span>
                    {{ substr((string) $nextConcert->event_time, 0, 5) }}
                </p>
            </div>

            <div class="mt-3">
                <p class="inline-flex items-center gap-2 text-sm font-semibold text-gray-800">
                    <svg class="h-4 w-4 text-cyan-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l11-2v13" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 18a3 3 0 11-6 0 3 3 0 016 0zm11-2a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ __('Repertorio') }}
                </p>
                @if ($nextConcert->pieces->count() > 0)
                    <ul class="mt-1 space-y-1 text-sm text-gray-700">
                        @foreach ($nextConcert->pieces as $piece)
                            <li class="flex items-start gap-2">
                                <svg class="mt-0.5 h-4 w-4 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l11-2v13" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18a3 3 0 11-6 0 3 3 0 016 0" />
                                </svg>
                                <span>
                                    {{ $piece->title }}
                                    @if ($piece->author)
                                        <span class="text-gray-500"> - {{ $piece->author }}</span>
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-1 text-sm text-gray-600">{{ __('Sin repertorio definido') }}</p>
                @endif
            </div>

            <div class="mt-4 border-t border-cyan-100 pt-3 text-right">
                <a href="{{ route('concert-programs.public') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-cyan-700 hover:text-cyan-900">
                    <span>{{ __('Ver programa publico') }}</span>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h4m0 0v4m0-4l-8 8" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 5h6M5 5v14h14v-6" />
                    </svg>
                </a>
            </div>
        </div>
    @else
        <div class="rounded-lg bg-gray-100 p-3 text-center">
            <p class="text-sm text-gray-600">{{ __('Nada a la vista') }}</p>
            <p class="text-base font-semibold text-gray-800">{{ __('No hay conciertos publicados') }}</p>
        </div>
    @endif
</div>
