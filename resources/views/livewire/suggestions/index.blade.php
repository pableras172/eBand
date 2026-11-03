<div class="max-w-7xl mx-auto py-4 px-3 pb-8 sm:px-6 lg:px-8 space-y-6">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                    <span>💡</span> {{ __('crud.suggestions.collectionTitle') }}
                </h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Comparteix idees, propostes i suggeriments per a millorar la nostra banda') }}
                </p>
            </div>

            <a href="{{ route('suggestions.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 transition focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>{{ __('Nou suggeriment') }}</span>
            </a>
        </div>
    </x-slot>

    {{-- Modal de confirmación de eliminación --}}
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

    {{-- Barra de búsqueda y contador --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="relative flex-1 max-w-md">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="{{ __('Cercar per títol o contingut...') }}"
                class="w-full rounded-xl border border-gray-200 bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200 pl-10 pr-4 py-2 text-sm shadow-xs focus:border-cyan-500 focus:bg-white dark:focus:bg-gray-900 focus:ring-cyan-500 transition" />
        </div>

        <div class="flex items-center gap-2 text-xs font-medium text-gray-500 dark:text-gray-400 self-end sm:self-center">
            <span>{{ __('Total suggeriments') }}: <strong class="text-gray-900 dark:text-gray-100 font-bold">{{ $suggestions->total() }}</strong></span>
        </div>
    </div>

    {{-- Grid de tarjetas de sugerencias estilo Actividades --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($suggestions as $suggestion)
            @can('view', $suggestion)
                <div wire:key="card-suggestion-{{ $suggestion->id }}"
                    class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all flex flex-col justify-between overflow-hidden">
                    <div class="p-6 space-y-4">
                        <div class="flex items-start justify-between gap-3">
                            <span class="text-2xl p-3 rounded-2xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-300 shadow-xs">
                                💡
                            </span>
                            <div class="flex flex-col items-end gap-1">
                                @if($suggestion->anonimo == false && $suggestion->user)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300 border border-cyan-100 dark:border-cyan-800/40">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="truncate max-w-[130px]">{{ $suggestion->user->name ?? $suggestion->user->email }}</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ __('crud.suggestions.anonymous') ?: 'Anònim' }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 leading-snug line-clamp-2">
                                {{ $suggestion->titulo }}
                            </h2>
                            @if ($suggestion->texto)
                                <p class="text-xs text-gray-600 dark:text-gray-300 line-clamp-3 mt-2 leading-relaxed whitespace-pre-line">
                                    {{ $suggestion->texto }}
                                </p>
                            @endif
                        </div>

                        @if (! empty($suggestion->observaciones))
                            <div class="rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/40 p-3 text-xs text-amber-900 dark:text-amber-200 space-y-1">
                                <p class="font-bold flex items-center gap-1.5 text-amber-800 dark:text-amber-300">
                                    <span>📋</span> {{ __('Nota de la directiva') }}
                                </p>
                                <p class="text-xs leading-relaxed">{{ $suggestion->observaciones }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="px-6 py-3.5 bg-gray-50/70 dark:bg-gray-800/80 border-t border-gray-100 dark:border-gray-700/80 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $suggestion->fechacreacion ? \Carbon\Carbon::parse($suggestion->fechacreacion)->translatedFormat('d M Y') : '' }}
                        </span>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('suggestions.edit', $suggestion) }}"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-cyan-50 hover:bg-cyan-100 text-cyan-800 dark:bg-cyan-900/40 dark:text-cyan-200 font-semibold transition">
                                <span>{{ __('Veure') }}</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            @can('delete', $suggestion)
                                <button type="button" wire:click="confirmDeletion('{{ $suggestion->id }}')"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition"
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
            <div class="col-span-full py-16 text-center bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 text-3xl mb-4">
                    💡
                </div>
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-1">
                    {{ __('No hi ha cap suggeriment') }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto mb-6">
                    {{ __('Sigues el primer en proposar una idea per a millorar la banda.') }}
                </p>
                <a href="{{ route('suggestions.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-cyan-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 transition">
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
