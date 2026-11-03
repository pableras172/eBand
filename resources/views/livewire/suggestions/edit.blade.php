<div class="max-w-4xl mx-auto py-4 px-3 pb-24 sm:px-6 lg:px-8 space-y-6">
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-1">
                    <a href="{{ route('suggestions.index') }}" class="hover:text-cyan-600 transition">{{ __('crud.suggestions.collectionTitle') }}</a>
                    <span>/</span>
                    <span class="text-gray-700 dark:text-gray-300 font-medium">{{ __('Detall del suggeriment') }}</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                    <span>💡</span> {{ __('Detall del suggeriment') }}
                </h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Consulta i gestiona este suggeriment de la banda') }}
                </p>
            </div>

            <a href="{{ route('suggestions.index') }}"
                class="inline-flex items-center rounded-xl border border-gray-300 bg-white dark:bg-gray-800 dark:border-gray-600 px-3.5 py-2 text-xs font-semibold text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Tornar') }}
            </a>
        </div>
    </x-slot>

    <x-ui.toast on="saved">{{ __('crud.suggestions.toast.saved') }}</x-ui.toast>

    @if ($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 dark:bg-rose-950/40 dark:border-rose-800 p-4 text-sm text-rose-800 dark:text-rose-200 space-y-1 shadow-sm">
            <p class="font-bold flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ __('Si us plau, revisa els errors:') }}
            </p>
            <ul class="list-disc list-inside text-xs space-y-0.5 pl-7">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="rounded-2xl bg-white dark:bg-gray-800 p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-gray-700 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-3">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                    <span>📝</span> {{ __('Dades del suggeriment') }}
                </h2>
                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ $form->fechacreacion ? \Carbon\Carbon::parse($form->fechacreacion)->translatedFormat('d M Y, H:i') : '' }}
                </span>
            </div>

            <!-- Título -->
            <div>
                <label for="titulo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                    {{ __('crud.suggestions.inputs.titulo.label') }} <span class="text-rose-500">*</span>
                </label>
                <input id="titulo" type="text" wire:model="form.titulo"
                    class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 py-2.5 px-3.5 text-sm shadow-xs focus:border-cyan-500 focus:ring-cyan-500 dark:text-gray-100 transition" />
                @error('form.titulo') <span class="text-xs text-rose-600 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>

            <!-- Texto / Descripción -->
            <div>
                <label for="texto" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                    {{ __('crud.suggestions.inputs.texto.label') }} <span class="text-rose-500">*</span>
                </label>
                <textarea id="texto" rows="6" wire:model="form.texto"
                    class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 p-3.5 text-sm shadow-xs focus:border-cyan-500 focus:ring-cyan-500 dark:text-gray-100 transition"></textarea>
                @error('form.texto') <span class="text-xs text-rose-600 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>

            <!-- Observaciones (solo admins) -->
            @can('admin')
                <div class="rounded-xl border border-amber-200 bg-amber-50/60 dark:bg-amber-950/30 dark:border-amber-800/60 p-5 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">📋</span>
                        <div>
                            <label for="observaciones" class="block text-sm font-bold text-amber-900 dark:text-amber-200">
                                {{ __('crud.suggestions.inputs.observaciones.label') }}
                            </label>
                            <p class="text-xs text-amber-700 dark:text-amber-400">
                                {{ __('Resposta o comentari visible per a qui ha proposat la idea.') }}
                            </p>
                        </div>
                    </div>
                    <textarea id="observaciones" rows="3" wire:model="form.observaciones"
                        placeholder="{{ __('crud.suggestions.inputs.observaciones.placeholder') ?: 'Escriu una resposta oficial per part de la directiva...' }}"
                        class="w-full rounded-xl border border-amber-300 dark:border-amber-700 bg-white dark:bg-gray-900 p-3 text-sm shadow-xs focus:border-amber-500 focus:ring-amber-500 dark:text-gray-100 placeholder:text-gray-400 transition"></textarea>
                    @error('form.observaciones') <span class="text-xs text-rose-600 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>
            @endcan

            <!-- Tarjeta de autor y anonimato -->
            <div class="rounded-xl border border-cyan-100 bg-cyan-50/60 dark:bg-gray-700/50 dark:border-gray-600 p-5 space-y-3">
                <input type="hidden" wire:model="form.users_id" />

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-cyan-600 text-white flex items-center justify-center font-bold text-base shadow-xs">
                            {{ strtoupper(substr($form->suggestion?->user?->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">{{ __('Autor / Autora') }}</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                {{ $form->suggestion?->user?->name ?? __('crud.suggestions.anonymous') }}
                            </p>
                        </div>
                    </div>

                    <!-- Checkbox anónimo -->
                    <label class="inline-flex items-center gap-3 cursor-pointer bg-white dark:bg-gray-800 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 shadow-xs hover:border-cyan-400 transition">
                        <input id="anonimo" type="checkbox" wire:model.live="form.anonimo"
                            class="w-4 h-4 rounded text-cyan-600 focus:ring-cyan-500 border-gray-300 cursor-pointer" />
                        <span class="text-xs font-semibold text-gray-800 dark:text-gray-200 select-none">
                            🎭 {{ __('crud.suggestions.anonymous') ?: 'Enviar com a anònim' }}
                        </span>
                    </label>
                </div>

                @if ($form->anonimo)
                    <p class="text-xs text-cyan-800 dark:text-cyan-300 flex items-center gap-1.5 pt-2 border-t border-cyan-100 dark:border-gray-600">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('El nom d’este suggeriment està ocult per a la resta de músics.') }}</span>
                    </p>
                @endif
            </div>

            <!-- Botones de acción -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('suggestions.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 shadow-xs hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    {{ __('Tornar') }}
                </a>

                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span wire:loading.remove>{{ __('Guardar canvis') }}</span>
                    <span wire:loading>{{ __('Guardant...') }}</span>
                </button>
            </div>
        </div>
    </form>
</div>
