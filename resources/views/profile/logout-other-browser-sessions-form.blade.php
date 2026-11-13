<div class="bg-white dark:bg-slate-800 rounded-3xl border border-indigo-50/80 dark:border-slate-700/80 shadow-bento p-5 sm:p-8">
    <!-- Encabezado de la Tarjeta Bento -->
    <div class="flex items-center gap-3.5 pb-6 border-b border-slate-100 dark:border-slate-700/60">
        <div class="h-11 w-11 rounded-2xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 flex items-center justify-center flex-shrink-0 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <h3 class="text-xl font-black text-slate-800 dark:text-white tracking-tight">
                {{ __('Sessions de Navegador Actives') }}
            </h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                {{ __('Revisa i tanca les sessions iniciades en altres dispositius o navegadors.') }}
            </p>
        </div>
    </div>

    <div class="py-6 space-y-6">
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl">
            {{ __('Si cal, pots tancar la sessió a tots els altres dispositius i navegadors. Si sospites que el teu compte ha sigut compromés, et recomanem a més canviar la teua contrasenya.') }}
        </p>

        @if (count($this->sessions) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach ($this->sessions as $session)
                    <div class="flex items-center gap-3.5 p-3.5 rounded-2xl border border-slate-100 dark:border-slate-700/60 bg-slate-50/60 dark:bg-slate-900/40">
                        <div class="p-2.5 rounded-xl bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 shadow-xs border border-slate-100 dark:border-slate-700 flex-shrink-0">
                            @if ($session->agent->isDesktop())
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 truncate">
                                {{ $session->agent->platform() ? $session->agent->platform() : __('Desconegut') }} — {{ $session->agent->browser() ? $session->agent->browser() : __('Desconegut') }}
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 flex items-center gap-1.5 flex-wrap">
                                <span>{{ $session->ip_address }}</span>
                                <span>•</span>
                                @if ($session->is_current_device)
                                    <span class="inline-flex items-center gap-1 font-bold text-emerald-600 dark:text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ __('Aquest dispositiu') }}
                                    </span>
                                @else
                                    <span>{{ __('Última activa') }}: {{ $session->last_active }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Acciones -->
    <div class="flex items-center gap-3 pt-6 border-t border-slate-100 dark:border-slate-700/60">
        <button type="button" 
                wire:click="confirmLogout" 
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-bold shadow-xs transition-colors">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span>{{ __('Tancar altres sessions del navegador') }}</span>
        </button>

        <x-action-message class="ms-3 text-xs sm:text-sm font-bold text-emerald-600 dark:text-emerald-400" on="loggedOut">
            {{ __('Fet.') }}
        </x-action-message>
    </div>

    <!-- Modal de Confirmación -->
    <x-dialog-modal wire:model.live="confirmingLogout">
        <x-slot name="title">
            {{ __('Tancar altres sessions del navegador') }}
        </x-slot>

        <x-slot name="content">
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                {{ __('Introdueix la teua contrasenya per confirmar que vols tancar la sessió a tots els teus altres dispositius i navegadors.') }}
            </p>

            <div class="mt-4" x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                <x-input type="password" class="mt-1 block w-full rounded-xl border-slate-200 dark:border-slate-700 text-sm"
                            autocomplete="current-password"
                            placeholder="{{ __('Contrasenya') }}"
                            x-ref="password"
                            wire:model="password"
                            wire:keydown.enter="logoutOtherBrowserSessions" />

                <x-input-error for="password" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled" class="rounded-xl">
                {{ __('Cancel·lar') }}
            </x-secondary-button>

            <button type="button" 
                    class="ms-3 px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs sm:text-sm font-bold shadow-md shadow-primary/20 transition-all"
                    wire:click="logoutOtherBrowserSessions"
                    wire:loading.attr="disabled">
                {{ __('Tancar altres sessions') }}
            </button>
        </x-slot>
    </x-dialog-modal>
</div>
