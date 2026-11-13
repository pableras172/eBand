<x-app-layout>
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
                        <x-ui.breadcrumbs.link active>{{ __('Tipus de actuacio') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('Tipus d\'actuació') }}
                    </h1>
                </div>
            </div>

            <a href="{{ route('tipoactuacion.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>{{ __('Nou tipus') }}</span>
            </a>
        </div>
    </x-slot>

    @if (request()->has('success') && request()->success)
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 rounded-2xl text-xs font-semibold">
                {{ request()->success }}
            </div>
        </div>
    @endif

    @if (request()->has('error') && request()->error)
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="bg-rose-50 border border-rose-200 text-rose-800 py-3 px-4 rounded-2xl text-xs font-semibold">
                {{ request()->error }}
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 space-y-6 pb-28">
        <div class="bg-white shadow-bento rounded-3xl border border-indigo-50/80 overflow-hidden">

            <table class="min-w-full divide-y divide-indigo-50">
                <thead class="bg-[#EEF1FA]/60">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Nom') }}
                        </th>
                        <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Imatge') }}
                        </th>
                        <th scope="col" class="hidden sm:table-cell px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Accions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50/70">
                    @foreach ($tipoactuacions as $tipoactuacion)
                        <tr class="hover:bg-indigo-50/30 transition-colors cursor-pointer"
                            onclick="window.location='{{ route('tipoactuacion.show', $tipoactuacion->id) }}'">
                            <td class="px-6 py-3.5 text-sm font-bold text-slate-900">
                                <div class="flex items-center gap-2.5">
                                    @if ($tipoactuacion->tipoensayo)
                                        <x-atril w="22" h="22" />
                                    @endif
                                    @if ($tipoactuacion->tipoconcierto)
                                        <x-concert w="22" h="22" />
                                    @endif
                                    <span>{{ $tipoactuacion->nombre }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-center">
                                @if ($tipoactuacion->icon)
                                    <img src="{{ asset('storage/imagenes/tipoactuacion/' . $tipoactuacion->icon) }}"
                                        alt="{{ $tipoactuacion->nombre }}"
                                        class="w-10 h-10 rounded-full object-cover mx-auto border border-indigo-100 shadow-xs">
                                @else
                                    <div class="flex justify-center">
                                        <x-nophoto w="40" h="40" />
                                    </div>
                                @endif
                            </td>
                            <td class="hidden sm:table-cell px-6 py-3.5 text-center">
                                <a href="{{ route('tipoactuacion.show', $tipoactuacion->id) }}"
                                   onclick="event.stopPropagation()"
                                   class="inline-flex items-center justify-center p-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 transition">
                                    <x-editar w="20" h="20" />
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-statistics.tipoactuaciones />
    </div>
    
    <footer
        class="fixed bottom-0 left-0 z-20 w-full bg-white/90 backdrop-blur-2xl border-t border-indigo-100/80 shadow-glass">
        <div class="flex justify-center items-center py-3">
            <!-- Botón Afegir -->
            <a href="{{ route('tipoactuacion.create') }}"
                class="flex flex-col items-center text-slate-600 hover:text-indigo-600 transition">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-xs mt-1 font-bold text-slate-700">{{ __('Afegir') }}</span>
            </a>
        </div>
    </footer>
</x-app-layout>


</x-app-layout>
