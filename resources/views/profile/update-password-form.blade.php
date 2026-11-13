<div class="bg-white dark:bg-slate-800 rounded-3xl border border-indigo-50/80 dark:border-slate-700/80 shadow-bento p-5 sm:p-8">
    <form wire:submit="updatePassword">
        <!-- Encabezado de la Tarjeta Bento -->
        <div class="flex items-center gap-3.5 pb-6 border-b border-slate-100 dark:border-slate-700/60">
            <div class="h-11 w-11 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-black text-slate-800 dark:text-white tracking-tight">
                    {{ __('Actualitzar Contrasenya') }}
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                    {{ __('Assegura\'t que el teu compte utilitza una contrasenya llarga i segura per protegir el teu accés.') }}
                </p>
            </div>
        </div>

        <div class="py-6 space-y-5 max-w-xl">
            <!-- Contraseña Actual -->
            <div>
                <x-label for="current_password" value="{{ __('Contrasenya actual') }}" class="font-semibold text-slate-700 dark:text-slate-300" />
                <x-input id="current_password" type="password" 
                    class="mt-1.5 block w-full rounded-xl border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-primary/20 text-sm shadow-xs" 
                    wire:model="state.current_password" autocomplete="current-password" />
                <x-input-error for="current_password" class="mt-1.5" />
            </div>

            <!-- Nueva Contraseña -->
            <div>
                <x-label for="password" value="{{ __('Nova contrasenya') }}" class="font-semibold text-slate-700 dark:text-slate-300" />
                <x-input id="password" type="password" 
                    class="mt-1.5 block w-full rounded-xl border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-primary/20 text-sm shadow-xs" 
                    wire:model="state.password" autocomplete="new-password" />
                <x-input-error for="password" class="mt-1.5" />
                <p class="text-xs text-slate-400 mt-1">
                    {{ __('Recomanem almenys 8 caràcters barrejant lletres, números i símbols.') }}
                </p>
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <x-label for="password_confirmation" value="{{ __('Confirma la nova contrasenya') }}" class="font-semibold text-slate-700 dark:text-slate-300" />
                <x-input id="password_confirmation" type="password" 
                    class="mt-1.5 block w-full rounded-xl border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-primary/20 text-sm shadow-xs" 
                    wire:model="state.password_confirmation" autocomplete="new-password" />
                <x-input-error for="password_confirmation" class="mt-1.5" />
            </div>
        </div>

        <!-- Acciones / Botón Guardar -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-700/60">
            <x-action-message class="me-3 text-xs sm:text-sm font-bold text-emerald-600 dark:text-emerald-400" on="saved">
                {{ __('Contrasenya actualitzada.') }}
            </x-action-message>

            <button type="submit" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white font-bold text-xs sm:text-sm shadow-md shadow-primary/20 transition-all duration-200 active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ __('Desar Contrasenya') }}</span>
            </button>
        </div>
    </form>
</div>
