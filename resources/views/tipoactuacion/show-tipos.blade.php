<x-app-layout>
    {{-- HEADER Y BREADCRUMBS --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Tipus d\'actuació') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ __('Tipus d\'actuació') }}
                        </h1>
                        <span class="inline-flex items-center rounded-xl bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100">
                            {{ $tipoactuacions->count() }} {{ __('totals') }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Configuració de categories d\'actuacions, assajos, concerts i cercaviles') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('tipoactuacion.create') }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>{{ __('Nou tipus') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    {{-- ALERTAS FLASH --}}
    @if (request()->has('success') && request()->success)
        <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 rounded-2xl text-xs font-semibold shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ request()->success }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 rounded-2xl text-xs font-semibold shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (request()->has('error') && request()->error)
        <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-800 py-3 px-4 rounded-2xl text-xs font-semibold shadow-xs">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ request()->error }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 space-y-6 pb-28">

        {{-- LISTADO MÓVIL (TARJETAS NEO-BENTO) --}}
        <div class="space-y-3 md:hidden">
            @forelse ($tipoactuacions as $tipoactuacion)
                <div class="rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento space-y-3 hover:border-indigo-100 transition cursor-pointer"
                    onclick="window.location='{{ route('tipoactuacion.show', $tipoactuacion->id) }}'">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            {{-- Icono / Avatar --}}
                            <div class="w-12 h-12 rounded-2xl bg-[#F5F6FC] border border-indigo-100/70 flex items-center justify-center shrink-0 overflow-hidden shadow-xs">
                                @if ($tipoactuacion->icon)
                                    <img src="{{ asset('storage/imagenes/tipoactuacion/' . $tipoactuacion->icon) }}"
                                        alt="{{ $tipoactuacion->nombre }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <x-nophoto w="32" h="32" />
                                @endif
                            </div>

                            <div class="min-w-0">
                                <span class="text-sm font-extrabold text-slate-900 block truncate">
                                    {{ $tipoactuacion->nombre }}
                                </span>
                                <div class="flex items-center gap-2 mt-1">
                                    @if ($tipoactuacion->tipoensayo)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-amber-50 text-amber-700 text-[11px] font-bold border border-amber-200/60">
                                            <x-atril w="14" h="14" />
                                            <span>{{ __('Assaig') }}</span>
                                        </span>
                                    @elseif ($tipoactuacion->tipoconcierto)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 text-[11px] font-bold border border-indigo-100">
                                            <x-concert w="14" h="14" />
                                            <span>{{ __('Concert') }}</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-slate-100 text-slate-600 text-[11px] font-bold">
                                            <span>{{ __('General') }}</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Botón Editar --}}
                        <a href="{{ route('tipoactuacion.show', $tipoactuacion->id) }}"
                            onclick="event.stopPropagation()"
                            class="p-2.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 transition active:scale-95"
                            title="{{ __('Editar tipus') }}">
                            <x-editar w="18" h="18" />
                        </a>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-indigo-50/80 bg-white p-8 text-center shadow-bento space-y-2">
                    <p class="text-sm font-bold text-slate-800">{{ __('No s\'han trobat tipus d\'actuació.') }}</p>
                    <p class="text-xs text-slate-500">{{ __('Utilitza el botó superior per crear el primer tipus d\'acte.') }}</p>
                </div>
            @endforelse
        </div>

        {{-- TABLA DESKTOP (NEO-BENTO LIGHT) --}}
        <div class="hidden md:block overflow-hidden rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
            <table class="min-w-full divide-y divide-indigo-50">
                <thead class="bg-[#F5F6FC]/80">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider w-20">
                            {{ __('Icona') }}
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Nom del tipus') }}
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Classificació') }}
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider w-28">
                            {{ __('Accions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50/70">
                    @forelse ($tipoactuacions as $tipoactuacion)
                        <tr class="hover:bg-[#F5F6FC]/60 transition-colors cursor-pointer"
                            onclick="window.location='{{ route('tipoactuacion.show', $tipoactuacion->id) }}'">
                            {{-- Icono / Imagen --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="w-11 h-11 rounded-2xl bg-[#F5F6FC] border border-indigo-100/70 flex items-center justify-center mx-auto overflow-hidden shadow-xs">
                                    @if ($tipoactuacion->icon)
                                        <img src="{{ asset('storage/imagenes/tipoactuacion/' . $tipoactuacion->icon) }}"
                                            alt="{{ $tipoactuacion->nombre }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <x-nophoto w="32" h="32" />
                                    @endif
                                </div>
                            </td>

                            {{-- Nombre --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-extrabold text-slate-900 block hover:text-indigo-600 transition">
                                    {{ $tipoactuacion->nombre }}
                                </span>
                            </td>

                            {{-- Clasificación --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($tipoactuacion->tipoensayo)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200/60 shadow-xs">
                                        <x-atril w="16" h="16" />
                                        <span>{{ __('Tipus Assaig') }}</span>
                                    </span>
                                @elseif ($tipoactuacion->tipoconcierto)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100 shadow-xs">
                                        <x-concert w="16" h="16" />
                                        <span>{{ __('Tipus Concert') }}</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200/60">
                                        <span>{{ __('General / Altres') }}</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('tipoactuacion.show', $tipoactuacion->id) }}"
                                    onclick="event.stopPropagation()"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold border border-indigo-200/60 transition active:scale-95"
                                    title="{{ __('Editar tipus d\'actuació') }}">
                                    <x-editar w="14" h="14" />
                                    <span>{{ __('Editar') }}</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-xs">
                                <p class="text-sm font-bold text-slate-800">{{ __('No s\'han trobat tipus d\'actuació.') }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ __('Utilitza el botó superior per crear el primer tipus d\'acte.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- WIDGET DE ESTADÍSTICAS POR TIPO Y AÑO --}}
        <x-statistics.tipoactuaciones />

    </div>

    {{-- BARRA FLOTANTE INFERIOR --}}
    <footer class="fixed bottom-0 left-0 z-20 w-full bg-white/90 backdrop-blur-2xl border-t border-indigo-100/80 shadow-glass">
        <div class="flex justify-center items-center py-3">
            <a href="{{ route('tipoactuacion.create') }}"
                class="flex flex-col items-center text-slate-600 hover:text-indigo-600 transition active:scale-95">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-xs mt-1 font-bold text-slate-700">{{ __('Afegir nou tipus') }}</span>
            </a>
        </div>
    </footer>
</x-app-layout>
