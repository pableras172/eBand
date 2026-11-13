<div class="max-w-7xl mx-auto pt-2 pb-28 px-3 sm:px-6 lg:px-8 space-y-4">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 shadow-xs">
                    <span class="text-xl">💡</span>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('crud.suggestions.collectionTitle') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('crud.suggestions.collectionTitle') }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Comparteix idees, propostes i suggeriments per a millorar la nostra banda') }}
                    </p>
                </div>
            </div>

            <a href="{{ route('suggestions.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>{{ __('Nou suggeriment') }}</span>
            </a>
        </div>
    </x-slot>

    {{-- Modal de confirmación en el stack de modales para no interferir con el flujo ni con space-y --}}
    @push('modals')
        <x-ui.modal.confirm wire:model="confirmingDeletion">
            <x-slot name="title"> {{ __('Eliminar suggeriment') }} </x-slot>

            <x-slot name="content">
                {{ __('Estàs segur que vols eliminar este suggeriment? Esta acció no es pot desfer.') }}
            </x-slot>

            <x-slot name="footer">
                <x-ui.button wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel·lar') }}
                </x-ui.button>

                <x-ui.button.danger class="ml-3" wire:click="delete({{ $deletingSuggestion }})"
                    wire:loading.attr="disabled">
                    {{ __('Eliminar') }}
                </x-ui.button.danger>
            </x-slot>
        </x-ui.modal.confirm>
    @endpush

    {{-- Barra de búsqueda y contador compactos (Neo-Bento Violet) --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-white p-3 rounded-3xl shadow-bento border border-indigo-50/80">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="{{ __('Cercar per títol o contingut...') }}"
                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] pl-10 pr-3 py-2 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition" />
        </div>

        <div class="flex items-center justify-end gap-1.5 text-xs text-slate-500 px-2 font-medium">
            <span>{{ __('Total suggeriments') }}: <strong class="text-indigo-700 font-bold">{{ $suggestions->total() }}</strong></span>
        </div>
    </div>

    {{-- Grid de tarjetas de sugerencias con espaciado optimizado (Neo-Bento Violet) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
        @forelse ($suggestions as $suggestion)
            @can('view', $suggestion)
                <div wire:key="card-suggestion-{{ $suggestion->id }}"
                    class="rounded-3xl bg-white shadow-bento border border-indigo-50/80 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    <div class="p-5 space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <span class="text-xl p-2.5 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 shadow-xs">
                                💡
                            </span>
                            <div class="flex flex-col items-end gap-1">
                                @if($suggestion->anonimo == false && $suggestion->user)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="truncate max-w-[130px]">{{ $suggestion->user->name ?? $suggestion->user->email }}</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ __('crud.suggestions.anonymous') ?: 'Anònim' }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h2 class="text-base sm:text-lg font-bold font-headline text-slate-900 leading-snug line-clamp-2">
                                {{ $suggestion->titulo }}
                            </h2>
                            @if ($suggestion->texto)
                                <p class="text-xs text-slate-500 line-clamp-3 mt-1.5 leading-relaxed whitespace-pre-line">
                                    {{ $suggestion->texto }}
                                </p>
                            @endif
                        </div>

                        @if (! empty($suggestion->observaciones))
                            <div class="rounded-2xl bg-amber-50 border border-amber-200/80 p-3 text-xs text-amber-900 space-y-1">
                                <p class="font-bold flex items-center gap-1.5 text-amber-800">
                                    <span>📋</span> {{ __('Nota de la directiva') }}
                                </p>
                                <p class="text-xs leading-relaxed">{{ $suggestion->observaciones }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="px-5 py-3 bg-[#F5F6FC]/70 border-t border-indigo-50 flex items-center justify-between text-xs text-slate-500">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $suggestion->fechacreacion ? \Carbon\Carbon::parse($suggestion->fechacreacion)->translatedFormat('d M Y') : '' }}
                        </span>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('suggestions.edit', $suggestion) }}"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold transition">
                                <span>{{ __('Veure') }}</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            @can('delete', $suggestion)
                                <button type="button" wire:click="confirmDeletion('{{ $suggestion->id }}')"
                                    class="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition"
                                    title="{{ __('Eliminar') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
            @endcan
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-indigo-50 shadow-bento">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 text-2xl mb-3 border border-amber-200">
                    💡
                </div>
                <h3 class="text-base font-bold font-headline text-slate-900 mb-1">
                    {{ __('No hi ha cap suggeriment') }}
                </h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto mb-4">
                    {{ __('Sigues el primer en proposar una idea per a millorar la banda.') }}
                </p>
                <a href="{{ route('suggestions.create') }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow-sm hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>{{ __('Proposar suggeriment') }}</span>
                </a>
            </div>
        @endforelse
    </div>

    {{-- Paginación limpia --}}
    <div class="pt-2">
        {{ $suggestions->links() }}
    </div>
</div>
