<div class="bg-rose-50/40 dark:bg-rose-950/20 rounded-3xl border border-rose-200/80 dark:border-rose-900/40 shadow-bento p-5 sm:p-8">
    <!-- Encabezado de la Tarjeta Bento de Peligro -->
    <div class="flex items-center gap-3.5 pb-6 border-b border-rose-100 dark:border-rose-900/40">
        <div class="h-11 w-11 rounded-2xl bg-rose-100 dark:bg-rose-900/60 text-rose-600 dark:text-rose-400 flex items-center justify-center flex-shrink-0 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div>
            <h3 class="text-xl font-black text-rose-900 dark:text-rose-200 tracking-tight">
                {{ __('Desactivar Compte') }}
            </h3>
            <p class="text-xs sm:text-sm text-rose-700/80 dark:text-rose-400">
                {{ __('Desactiva permanentment el teu compte i el teu accés a la plataforma.') }}
            </p>
        </div>
    </div>

    <div class="py-6 space-y-4 max-w-2xl text-xs sm:text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
        <p>
            {{ __('Una vegada desactivat el teu compte, tots els seus recursos i dades seran eliminats de forma permanent o desvinculats. Abans de procedir, descarrega qualsevol dada o informació que desitges conservar.') }}
        </p>
    </div>

    <!-- Botón de Acción -->
    <div class="pt-2">
        <button type="button" 
                wire:click="confirmUserDeletion" 
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-bold shadow-md shadow-rose-600/20 transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            <span>{{ __('Desactivar el meu compte') }}</span>
        </button>
    </div>

    <!-- Modal de Confirmación -->
    <x-dialog-modal wire:model.live="confirmingUserDeletion">
        <x-slot name="title">
            <span class="text-rose-600 dark:text-rose-400 font-black">{{ __('Confirmar desactivació del compte') }}</span>
        </x-slot>

        <x-slot name="content">
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                {{ __('Estàs segur que vols desactivar el teu compte? Aquesta acció no es pot desfer. Introdueix la teua contrasenya per confirmar que desitges procedir.') }}
            </p>

            <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                <x-input type="password" class="mt-1 block w-full rounded-xl border-slate-200 dark:border-slate-700 text-sm"
                            autocomplete="current-password"
                            placeholder="{{ __('Contrasenya') }}"
                            x-ref="password"
                            wire:model="password"
                            wire:keydown.enter="deleteUser" />

                <x-input-error for="password" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled" class="rounded-xl">
                {{ __('Cancel·lar') }}
            </x-secondary-button>

            <x-danger-button class="ms-3 rounded-xl" wire:click="deleteUser" wire:loading.attr="disabled">
                {{ __('Eliminar definitivament') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
