<div class="bg-white dark:bg-slate-800 rounded-3xl border border-indigo-50/80 dark:border-slate-700/80 shadow-bento p-5 sm:p-8">
    <!-- Encabezado de la Tarjeta Bento -->
    <div class="flex items-center gap-3.5 pb-6 border-b border-slate-100 dark:border-slate-700/60">
        <div class="h-11 w-11 rounded-2xl bg-orange-50 dark:bg-orange-950/60 text-orange-600 dark:text-orange-400 flex items-center justify-center flex-shrink-0 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>
        <div class="flex-1">
            <div class="flex flex-wrap items-center gap-2">
                <h3 class="text-xl font-black text-slate-800 dark:text-white tracking-tight">
                    {{ __('Autenticació en Dos Passos (2FA)') }}
                </h3>
                @if ($this->enabled)
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        {{ __('Activat') }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        {{ __('Desactivat') }}
                    </span>
                @endif
            </div>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                {{ __('Afig una capa addicional de seguretat al teu compte mitjançant una aplicació d\'autenticació.') }}
            </p>
        </div>
    </div>

    <div class="py-6 space-y-5">
        <div class="max-w-2xl text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    <p class="font-semibold text-amber-700 dark:text-amber-400">
                        {{ __('Finalitza l\'activació de l\'autenticació en dos passos escanejant el codi següent.') }}
                    </p>
                @else
                    <p class="text-slate-700 dark:text-slate-300">
                        {{ __('Tens activada l\'autenticació en dos passos. Cada vegada que inicies sessió se\'t demanarà un codi segur des de la teua aplicació d\'autenticació (com Google Authenticator o similar).') }}
                    </p>
                @endif
            @else
                <p>
                    {{ __('Quan actives el doble factor, se\'t demanarà un token d\'accés des del teu telèfon intel·ligent durant l\'inici de sessió.') }}
                </p>
            @endif
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-700/60 max-w-xl space-y-4">
                    <p class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200">
                        @if ($showingConfirmation)
                            {{ __('Escaneja aquest codi QR amb la teua aplicació d\'autenticació i introdueix el codi de 6 dígits generat per a confirmar:') }}
                        @else
                            {{ __('El doble factor està habilitat. Escaneja aquest codi QR des de la teua app d\'autenticació:') }}
                        @endif
                    </p>

                    <div class="p-4 bg-white rounded-2xl inline-block shadow-xs border border-slate-200">
                        {!! $this->user->twoFactorQrCodeSvg() !!}
                    </div>

                    <div class="text-xs text-slate-600 dark:text-slate-400">
                        <span class="font-bold text-slate-700 dark:text-slate-300">{{ __('Clau de configuració manual') }}:</span>
                        <code class="block mt-1 font-mono text-xs bg-white dark:bg-slate-800 p-2 rounded-lg border border-slate-200 dark:border-slate-700 select-all">
                            {{ decrypt($this->user->two_factor_secret) }}
                        </code>
                    </div>

                    @if ($showingConfirmation)
                        <div class="pt-2">
                            <x-label for="code" value="{{ __('Codi de confirmació de l\'aplicació') }}" class="font-semibold text-slate-700 dark:text-slate-300" />
                            <div class="flex items-center gap-3 mt-1.5">
                                <x-input id="code" type="text" name="code" class="block w-48 rounded-xl border-slate-200 dark:border-slate-700 text-center tracking-widest font-mono text-lg" 
                                    inputmode="numeric" autofocus autocomplete="one-time-code" placeholder="000000"
                                    wire:model="code" wire:keydown.enter="confirmTwoFactorAuthentication" />
                                <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                                    <button type="button" class="px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white font-bold text-xs sm:text-sm shadow-md shadow-primary/20 transition-all">
                                        {{ __('Confirmar') }}
                                    </button>
                                </x-confirms-password>
                            </div>
                            <x-input-error for="code" class="mt-1.5" />
                        </div>
                    @endif
                </div>
            @endif

            @if ($showingRecoveryCodes)
                <div class="p-5 rounded-2xl bg-amber-50/50 dark:bg-amber-950/20 border border-amber-200/80 dark:border-amber-800/50 max-w-xl space-y-3">
                    <div class="flex items-center gap-2 text-amber-800 dark:text-amber-300">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h4 class="font-bold text-sm">{{ __('Codis de Recuperació') }}</h4>
                    </div>
                    <p class="text-xs text-amber-700 dark:text-amber-400">
                        {{ __('Guarda aquests codis en un lloc segur. Et permetran accedir al teu compte si perds el teu dispositiu.') }}
                    </p>

                    <div class="grid grid-cols-2 gap-2 p-3 font-mono text-xs bg-white dark:bg-slate-900 rounded-xl border border-amber-200 dark:border-amber-800">
                        @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $recoveryCode)
                            <div class="p-1 select-all text-slate-800 dark:text-slate-200">{{ $recoveryCode }}</div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>

    <!-- Botones de Acción -->
    <div class="flex flex-wrap items-center gap-3 pt-6 border-t border-slate-100 dark:border-slate-700/60">
        @if (! $this->enabled)
            <x-confirms-password wire:then="enableTwoFactorAuthentication">
                <button type="button" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white font-bold text-xs sm:text-sm shadow-md shadow-primary/20 transition-all duration-200" wire:loading.attr="disabled">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>{{ __('Activar 2FA') }}</span>
                </button>
            </x-confirms-password>
        @else
            @if ($showingRecoveryCodes)
                <x-confirms-password wire:then="regenerateRecoveryCodes">
                    <button type="button" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-semibold transition-colors">
                        {{ __('Regenerar codis de recuperació') }}
                    </button>
                </x-confirms-password>
            @elseif ($showingConfirmation)
                <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                    <button type="button" class="px-4 py-2 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs sm:text-sm font-bold shadow-md shadow-primary/20 transition-all" wire:loading.attr="disabled">
                        {{ __('Confirmar') }}
                    </button>
                </x-confirms-password>
            @else
                <x-confirms-password wire:then="showRecoveryCodes">
                    <button type="button" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-semibold transition-colors">
                        {{ __('Mostrar codis de recuperació') }}
                    </button>
                </x-confirms-password>
            @endif

            @if ($showingConfirmation)
                <x-confirms-password wire:then="disableTwoFactorAuthentication">
                    <button type="button" class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 hover:bg-slate-50 text-xs sm:text-sm font-semibold transition-colors" wire:loading.attr="disabled">
                        {{ __('Cancel·lar') }}
                    </button>
                </x-confirms-password>
            @else
                <x-confirms-password wire:then="disableTwoFactorAuthentication">
                    <button type="button" class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300 text-xs sm:text-sm font-bold transition-colors" wire:loading.attr="disabled">
                        {{ __('Desactivar 2FA') }}
                    </button>
                </x-confirms-password>
            @endif
        @endif
    </div>
</div>
