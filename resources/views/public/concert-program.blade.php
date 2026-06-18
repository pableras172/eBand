<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Programa de concert') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-b from-slate-100 to-white text-slate-900">
    <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-5 flex justify-end">
            <div class="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white p-1.5 shadow-sm">
                <a href="{{ route('concert-programs.poster') }}" class="inline-flex items-center rounded-md border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 sm:text-sm">
                    {{ __('Veure cartell A4') }}
                </a>

                <div class="inline-flex overflow-hidden rounded-md border border-slate-300">
                    <a href="/greeting/ca_VL" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold transition sm:text-sm {{ app()->getLocale() === 'ca_VL' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-50' }}">
                        <span class="fi fi-es-ct"></span>
                        <span>VAL</span>
                    </a>
                    <a href="/greeting/es" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold transition sm:text-sm {{ app()->getLocale() === 'es' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-50' }}">
                        <span class="fi fi-es"></span>
                        <span>CAS</span>
                    </a>
                </div>
            </div>
        </div>

        @if (! $program)
            <section class="rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                <h1 class="text-2xl font-bold">{{ __('Programa de concert') }}</h1>
                <p class="mt-3 text-slate-600">{{ __('Encara no hi ha cap programa publicat.') }}</p>
            </section>
        @else
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <header class="px-6 pb-2 pt-6 text-center sm:px-8">
                    <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">{{ $program->title }}</h1>
                </header>

                @if ($program->image_path)
                    <img src="{{ asset('storage/'.$program->image_path) }}" alt="Imagen del concierto" class="h-64 w-full object-cover sm:h-80">
                @endif

                <div class="space-y-6 p-6 sm:p-8">
                    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                        <div class="flex items-stretch">
                            <div class="hidden w-24 items-center justify-center bg-gradient-to-b from-cyan-100 to-blue-100 sm:flex">
                                <svg class="h-10 w-10 text-cyan-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.75 6-11a6 6 0 10-12 0c0 5.25 6 11 6 11z" />
                                    <circle cx="12" cy="10" r="2.2" />
                                </svg>
                            </div>
                            <div class="flex-1 p-4 sm:p-5">
                                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">{{ __('Ubicacio') }}</h2>
                                <p class="mt-2 text-base font-semibold text-slate-900">{{ $program->location }}</p>

                                <div class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                                    <p class="rounded-lg bg-slate-100 px-3 py-2"><span class="font-semibold">{{ __('Data') }}:</span> {{ optional($program->event_date)->format('d/m/Y') }}</p>
                                    <p class="rounded-lg bg-slate-100 px-3 py-2"><span class="font-semibold">{{ __('Hora') }}:</span> {{ substr((string) $program->event_time, 0, 5) }}</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    @if ($program->participants)
                        <section>
                            <h2 class="text-lg font-semibold">{{ __('Participants') }}</h2>
                            <p class="mt-2 whitespace-pre-line text-slate-700">{{ $program->participants }}</p>
                        </section>
                    @endif

                    <section>
                        <div class="mb-4 overflow-hidden rounded-xl border border-slate-200 bg-white">
                            <div class="flex items-stretch">
                                <div class="hidden w-24 items-center justify-center bg-gradient-to-b from-emerald-100 to-teal-100 sm:flex">
                                    <svg class="h-10 w-10 text-emerald-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l11-2v13" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 18a3 3 0 11-6 0 3 3 0 016 0zm11-2a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 p-4 sm:p-5">
                                    <h2 class="text-xl font-bold">{{ __('Repertori') }}</h2>
                                </div>
                            </div>
                        </div>

                        <ul class="mt-4 space-y-3">
                            @foreach ($program->pieces as $piece)
                                <li class="rounded-xl border border-slate-200 p-4">
                                    <div class="flex items-start gap-3">
                                        <span class="mt-0.5 text-cyan-700">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l11-2v13" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 18a3 3 0 11-6 0 3 3 0 016 0zm11-2a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </span>
                                        <div class="min-w-0">
                                            <h3 class="text-lg font-semibold">{{ $piece->title }}</h3>
                                    @if ($piece->author)
                                        <div class="mt-1 flex items-center gap-2">
                                            <x-composer class="flex-shrink-0" w="20" h="20" />
                                            <p class="text-sm text-slate-600">{{ __('Autor') }}: {{ $piece->author }}</p>
                                        </div>
                                    @endif
                                    @if ($piece->details)
                                    <hr class="my-2 border-slate-200">
                                        <p class="mt-2 text-sm text-slate-700">{{ $piece->details }}</p>
                                    @endif
                                    @if ($piece->url)
                                    <hr class="my-2 border-slate-200">
                                    <div class="mt-1 flex items-center gap-2">
                                        <x-reprod class="flex-shrink-0" w="20" h="20" />
                                        <p class="mt-2 text-sm text-slate-700">{{ $piece->url }}</p>
                                    </div>
                                    @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>

                    @php
                        $logos = array_filter([
                            $program->logo_1_path,
                            $program->logo_2_path,
                            $program->logo_3_path,
                        ]);
                    @endphp

                    @if (count($logos) > 0)
                        <section class="text-center">
                            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">{{ __('Col-laboren') }}</h2>
                            <div class="mt-3 flex w-full flex-wrap items-center justify-evenly gap-4">
                                @foreach ($logos as $logo)
                                    <img src="{{ asset('storage/'.$logo) }}" alt="Logo colaborador" class="h-14 w-auto object-contain">
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>
                
            </section>
        @endif
    </main>
        <footer class="mt-6">
            <div class="mx-auto max-w-4xl px-4 py-6 text-center">
                <a href="https://eband.app/?utm_source=site&utm_medium=footer&utm_campaign=eband_link" aria-label="Visita eBand.app" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-3 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 px-4 py-2 shadow-lg transform transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.333 0-4 1.333-4 4s2.667 4 4 4 4-1.333 4-4-2.667-4-4-4z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                    </svg>
                    <span class="font-semibold text-white">{{ __('Descobreix eBand.app') }}</span>
                    <svg class="h-4 w-4 text-white opacity-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>

                <p class="mt-3 text-xs text-slate-600">
                    {{ __('Gestió i organització de bandes i xarangas. Prova la nostra app per més funcionalitats i gestió fàcil.') }}
                </p>
            </div>
        </footer>
</body>
</html>
