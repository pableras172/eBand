<x-app-layout>
    {{-- HEADER Y BREADCRUMBS --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Programes de concert') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ __('Programes de concert') }}
                        </h1>
                        <span class="inline-flex items-center rounded-xl bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100">
                            {{ $programs->total() }} {{ __('totals') }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Gestió de programes de mà digitals, cartells i repertori d\'actuacions') }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <form action="{{ route('concert-programs.download-qr') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-2xl border border-indigo-100 bg-white px-3.5 py-2.5 text-xs font-bold text-indigo-700 hover:bg-indigo-50 shadow-xs transition active:scale-95"
                        title="{{ __('Descarregar imatge QR del programa públic') }}">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        <span>{{ __('Descarregar QR públic') }}</span>
                    </button>
                </form>

                <a href="{{ route('concert-programs.create') }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>{{ __('Nou programa') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 pb-28">
        <div class="mx-auto max-w-6xl px-3 sm:px-6 lg:px-8 space-y-4">

            {{-- ALERTAS FLASH --}}
            @if (session('success_message'))
                <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-semibold text-emerald-800 shadow-xs">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success_message') }}</span>
                </div>
            @endif

            @if (session('error_message'))
                <div class="flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs font-semibold text-rose-800 shadow-xs">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>{{ session('error_message') }}</span>
                </div>
            @endif

            {{-- BANNER DE ACCESO PÚBLICO AL PROGRAMA (RESPONSIVE CON BREAK-ALL PARA NO BLOQUEAR SCROLL MÓVIL) --}}
            <div class="rounded-3xl border border-indigo-100 bg-indigo-50/60 p-4 sm:p-5 shadow-bento flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-start sm:items-center gap-3 min-w-0 flex-1">
                    <div class="w-9 h-9 rounded-xl bg-white text-indigo-600 flex items-center justify-center font-bold text-base shadow-xs shrink-0">
                        🎺
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-xs font-bold text-indigo-950 block">
                            {{ __('URL pública per al codi QR:') }}
                        </span>
                        <a href="{{ route('concert-programs.public') }}"
                            target="_blank" rel="noopener"
                            class="text-xs font-semibold text-indigo-700 hover:text-indigo-900 underline block break-all mt-0.5">
                            {{ route('concert-programs.public') }}
                        </a>
                    </div>
                </div>

                <div class="shrink-0">
                    <a href="{{ route('concert-programs.public') }}" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-200/60 shadow-xs transition active:scale-95">
                        <span>{{ __('Obrir pàgina pública') }}</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- LISTADO MÓVIL (TARJETAS NEO-BENTO) --}}
            <div class="space-y-3.5 md:hidden">
                @forelse ($programs as $program)
                    <div class="rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento space-y-3.5 hover:border-indigo-100 transition">
                        {{-- Cabecera de la tarjeta --}}
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('concert-programs.edit', $program) }}"
                                    class="text-sm font-extrabold text-slate-900 hover:text-indigo-600 transition block leading-snug">
                                    {{ $program->title }}
                                </a>

                                <div class="flex flex-wrap items-center gap-1.5 mt-1.5">
                                    @if ($program->is_published)
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-emerald-50 border border-emerald-200 px-2 py-0.5 text-[11px] font-bold text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>{{ __('Publicat') }}</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-slate-100 border border-slate-200 px-2 py-0.5 text-[11px] font-bold text-slate-600">
                                            <span>{{ __('Borrador') }}</span>
                                        </span>
                                    @endif

                                    @if ($program->is_featured)
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-amber-50 border border-amber-200 px-2 py-0.5 text-[11px] font-bold text-amber-800">
                                            <span>⭐ {{ __('Destacat') }}</span>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Píldora de obras --}}
                            <div class="shrink-0 text-right">
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-xl px-2.5 py-1">
                                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.657-1.79 3-4 3s-4-1.343-4-3 1.79-3 4-3 4 1.343 4 3zm12-3c0 1.657-1.79 3-4 3s-4-1.343-4-3 1.79-3 4-3 4 1.343 4 3z" />
                                    </svg>
                                    <span>{{ $program->pieces_count }} {{ __('obres') }}</span>
                                </span>
                            </div>
                        </div>

                        {{-- Información del evento --}}
                        <div class="space-y-1.5 text-xs text-slate-600 pt-2 border-t border-indigo-50/70">
                            {{-- Fecha y hora --}}
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-semibold text-slate-800">
                                    {{ optional($program->event_date)->format('d/m/Y') }}
                                    @if ($program->event_time)
                                        <span class="text-slate-400">·</span> {{ substr((string) $program->event_time, 0, 5) }}h
                                    @endif
                                </span>
                            </div>

                            {{-- Ubicación --}}
                            @if ($program->location)
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="truncate text-slate-600">{{ $program->location }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Fila de Acciones Móvil --}}
                        <div class="flex items-center justify-between pt-3 border-t border-indigo-50/70">
                            <div class="flex items-center gap-2">
                                {{-- Cartel A4 --}}
                                <a href="{{ route('concert-programs.poster.preview', $program) }}" target="_blank" rel="noopener"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-cyan-50 hover:bg-cyan-100 text-cyan-800 text-xs font-bold border border-cyan-200/60 transition active:scale-95">
                                    <svg class="w-3.5 h-3.5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    <span>{{ __('Cartell A4') }}</span>
                                </a>

                                {{-- Editar --}}
                                <a href="{{ route('concert-programs.edit', $program) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold border border-indigo-200/60 transition active:scale-95">
                                    <x-editar w="14" h="14" />
                                    <span>{{ __('Editar') }}</span>
                                </a>
                            </div>

                            {{-- Eliminar --}}
                            <form action="{{ route('concert-programs.destroy', $program) }}" method="POST"
                                onsubmit="return confirm('{{ __('Segur que vols eliminar este programa de concert?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 transition active:scale-95"
                                    title="{{ __('Eliminar programa') }}">
                                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-indigo-50/80 bg-white p-8 text-center shadow-bento space-y-2">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 mx-auto flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">{{ __('Encara no hi ha programes de concert.') }}</p>
                        <p class="text-xs text-slate-500">{{ __('Utilitza el botó superior per crear el primer programa de mà digital.') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- TABLA DESKTOP (NEO-BENTO LIGHT CON OVERFLOW-X-AUTO) --}}
            <div class="hidden md:block overflow-x-auto rounded-3xl bg-white border border-indigo-50/80 shadow-bento">
                <table class="w-full min-w-[760px] divide-y divide-indigo-50">
                    <thead class="bg-[#F5F6FC]/80">
                        <tr>
                            <th class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">{{ __('Títol del concert') }}</th>
                            <th class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">{{ __('Data i hora') }}</th>
                            <th class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">{{ __('Ubicació') }}</th>
                            <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-500">{{ __('Estat') }}</th>
                            <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-500">{{ __('Repertori') }}</th>
                            <th class="px-5 py-3.5 text-right text-xs font-bold uppercase tracking-wider text-slate-500 w-60">{{ __('Accions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-indigo-50/70 bg-white">
                        @forelse ($programs as $program)
                            <tr class="hover:bg-[#F5F6FC]/60 transition-colors">
                                {{-- Título --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <a href="{{ route('concert-programs.edit', $program) }}"
                                        class="text-sm font-extrabold text-slate-900 hover:text-indigo-600 transition block">
                                        {{ $program->title }}
                                    </a>
                                </td>

                                {{-- Fecha y Hora --}}
                                <td class="px-5 py-4 whitespace-nowrap text-xs text-slate-700">
                                    <span class="font-bold text-slate-800 block">
                                        {{ optional($program->event_date)->format('d/m/Y') }}
                                    </span>
                                    <span class="text-slate-400 block mt-0.5">
                                        {{ substr((string) $program->event_time, 0, 5) }}h
                                    </span>
                                </td>

                                {{-- Ubicación --}}
                                <td class="px-5 py-4 whitespace-nowrap text-xs text-slate-600">
                                    {{ $program->location ?: '-' }}
                                </td>

                                {{-- Estado --}}
                                <td class="px-5 py-4 whitespace-nowrap text-center">
                                    @if ($program->is_published)
                                        <span class="inline-flex items-center gap-1 rounded-xl bg-emerald-50 border border-emerald-200 px-2.5 py-1 text-xs font-bold text-emerald-800 shadow-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>{{ __('Publicat') }}</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-xl bg-slate-100 border border-slate-200 px-2.5 py-1 text-xs font-bold text-slate-600">
                                            <span>{{ __('Borrador') }}</span>
                                        </span>
                                    @endif

                                    @if ($program->is_featured)
                                        <span class="ml-1 inline-flex items-center rounded-xl bg-amber-50 border border-amber-200 px-2.5 py-1 text-xs font-bold text-amber-800 shadow-xs">
                                            ⭐ {{ __('Destacat') }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Obras --}}
                                <td class="px-5 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100">
                                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.657-1.79 3-4 3s-4-1.343-4-3 1.79-3 4-3 4 1.343 4 3zm12-3c0 1.657-1.79 3-4 3s-4-1.343-4-3 1.79-3 4-3 4 1.343 4 3z" />
                                        </svg>
                                        <span>{{ $program->pieces_count }} {{ __('obres') }}</span>
                                    </span>
                                </td>

                                {{-- Acciones --}}
                                <td class="px-5 py-4 whitespace-nowrap text-right w-60">
                                    <div class="flex items-center justify-end gap-1.5">
                                        {{-- Cartel A4 --}}
                                        <a href="{{ route('concert-programs.poster.preview', $program) }}" target="_blank" rel="noopener"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-cyan-50 hover:bg-cyan-100 text-cyan-800 text-xs font-bold border border-cyan-200/60 shadow-xs transition active:scale-95"
                                            title="{{ __('Generar Cartell A4 per a impressió') }}">
                                            <svg class="w-3.5 h-3.5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            <span>{{ __('Cartell A4') }}</span>
                                        </a>

                                        {{-- Editar --}}
                                        <a href="{{ route('concert-programs.edit', $program) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold border border-indigo-200/60 transition active:scale-95"
                                            title="{{ __('Editar programa') }}">
                                            <x-editar w="14" h="14" />
                                            <span>{{ __('Editar') }}</span>
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('concert-programs.destroy', $program) }}" method="POST" class="inline"
                                            onsubmit="return confirm('{{ __('Segur que vols eliminar este programa de concert?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 transition active:scale-95"
                                                title="{{ __('Eliminar programa') }}">
                                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center text-slate-400 text-xs">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 mx-auto flex items-center justify-center mb-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                        </svg>
                                    </div>
                                    <span class="font-bold text-slate-700 block text-sm">{{ __('Encara no hi ha programes de concert.') }}</span>
                                    <span class="text-slate-500">{{ __('Utilitza el botó superior per crear el primer programa de mà digital.') }}</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($programs->hasPages())
                <div class="mt-4">
                    {{ $programs->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
