<div class="bg-white dark:bg-slate-800 rounded-3xl border border-indigo-50/80 dark:border-slate-700/80 shadow-bento p-5 sm:p-8">
    <form wire:submit="updateProfileInformation">
        <!-- Encabezado de la Tarjeta Bento -->
        <div class="flex items-center gap-3.5 pb-6 border-b border-slate-100 dark:border-slate-700/60">
            <div class="h-11 w-11 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-primary dark:text-indigo-400 flex items-center justify-center flex-shrink-0 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-black text-slate-800 dark:text-white tracking-tight">
                    {{ __('Informació del perfil') }}
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                    {{ __('Actualitza les teues dades de contacte, instrument assignat i disponibilitat logística.') }}
                </p>
            </div>
        </div>

        <div class="py-6 space-y-8">
            <!-- BLOQUE 1: FOTO DE PERFIL -->
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div x-data="{ photoName: null, photoPreview: null }" class="flex flex-col sm:flex-row items-center sm:items-start gap-5 p-4 rounded-2xl bg-slate-50/70 dark:bg-slate-900/40 border border-slate-100 dark:border-slate-700/50">
                    <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
                        x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                photoPreview = e.target.result;
                            };
                            reader.readAsDataURL($refs.photo.files[0]);
                        " />

                    <!-- Avatar actual / preview -->
                    <div class="relative flex-shrink-0">
                        <div x-show="! photoPreview">
                            <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                                class="rounded-2xl h-20 w-20 object-cover ring-2 ring-white dark:ring-slate-700 shadow-sm">
                        </div>
                        <div x-show="photoPreview" style="display: none;">
                            <span class="block rounded-2xl w-20 h-20 bg-cover bg-no-repeat bg-center ring-2 ring-primary shadow-sm"
                                x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 text-center sm:text-left flex-1">
                        <div>
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ __('Foto de Perfil') }}</span>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('Format recomanat: JPG o PNG. Màxim 1 MB.') }}</p>
                        </div>

                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 pt-1">
                            <button type="button" 
                                    x-on:click.prevent="$refs.photo.click()"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-600 shadow-xs transition-colors">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ __('Selecciona una nova foto') }}</span>
                            </button>

                            @if ($this->user->profile_photo_path)
                                <button type="button" 
                                        wire:click="deleteProfilePhoto"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>{{ __('Esborrar foto') }}</span>
                                </button>
                            @endif
                        </div>

                        <x-input-error for="photo" class="mt-1" />
                    </div>
                </div>
            @endif

            <!-- BLOQUE 2: DADES DE CONTACTE I IDENTITAT -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-3">
                    {{ __('Dades de Contacte') }}
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Nombre -->
                    <div>
                        <x-label for="name" value="{{ __('Nom complet') }}" class="font-semibold text-slate-700 dark:text-slate-300" />
                        <x-input id="name" type="text" class="mt-1.5 block w-full rounded-xl border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-primary/20 text-sm shadow-xs" 
                            wire:model="state.name" required autocomplete="name" />
                        <x-input-error for="name" class="mt-1.5" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-label for="email" value="{{ __('Correu electrònic') }}" class="font-semibold text-slate-700 dark:text-slate-300" />
                        <x-input id="email" type="email" class="mt-1.5 block w-full rounded-xl border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-primary/20 text-sm shadow-xs" 
                            wire:model="state.email" required autocomplete="username" />
                        <x-input-error for="email" class="mt-1.5" />

                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && !$this->user->hasVerifiedEmail())
                            <div class="mt-2 text-xs text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 p-2.5 rounded-xl border border-amber-200 dark:border-amber-800">
                                <span>{{ __('El teu correu electrònic no està verificat.') }}</span>
                                <button type="button"
                                    class="underline font-bold hover:text-amber-900 dark:hover:text-amber-200 ml-1"
                                    wire:click.prevent="sendEmailVerification">
                                    {{ __('Reenviar correu de verificació') }}
                                </button>
                            </div>

                            @if ($this->verificationLinkSent)
                                <p class="mt-2 font-medium text-xs text-emerald-600 dark:text-emerald-400">
                                    {{ __('S\'ha enviat un nou enllaç de verificació a la teua adreça.') }}
                                </p>
                            @endif
                        @endif
                    </div>

                    <!-- Telefono -->
                    <div>
                        <x-label for="telefono" value="{{ __('Telèfon mòbil') }}" class="font-semibold text-slate-700 dark:text-slate-300" />
                        <x-input id="telefono" type="text" class="mt-1.5 block w-full rounded-xl border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-primary/20 text-sm shadow-xs" 
                            wire:model="state.telefono" placeholder="600 000 000" />
                        <x-input-error for="telefono" class="mt-1.5" />
                    </div>

                    <!-- Instrumento -->
                    <div>
                        <x-label for="instrument" value="{{ __('Instrument principal') }}" class="font-semibold text-slate-700 dark:text-slate-300" />
                        <select id="instrument" name="instrument" wire:model="state.instrument_id" 
                            class="mt-1.5 block w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:border-primary focus:ring-primary/20 text-sm shadow-xs">
                            <option value="">{{ __('Selecciona Instrument') }}</option>
                            @foreach ($instruments as $instrument)
                                <option value="{{ $instrument->id }}">{{ $instrument->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="instrument_id" class="mt-1.5" />
                    </div>
                </div>
            </div>

            <!-- BLOQUE 3: DADES DE BANDA & GESTIÓ -->
            <div class="pt-2">
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-3">
                    {{ __('Dades de la Banda i Liquidació') }}
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Porcentaje -->
                    <div>
                        <x-label for="porcentaje" value="{{ __('Percentatge de liquidació (%)') }}" class="font-semibold text-slate-700 dark:text-slate-300" />
                        @if (Auth::user()->roles()->where('title', 'Admin')->exists())
                            <x-input id="porcentaje" type="number" min="0" max="100" class="mt-1.5 block w-full rounded-xl border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-primary/20 text-sm shadow-xs" 
                                wire:model="state.porcentaje" />
                            <p class="text-xs text-slate-400 mt-1">{{ __('Com a administrador pots ajustar el percentatge assignat a aquest músic.') }}</p>
                        @else
                            <div class="mt-1.5 flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-sm">
                                <span class="font-bold text-slate-800 dark:text-slate-200">{{ $state['porcentaje'] ?? 100 }}%</span>
                                <span class="text-xs text-slate-400">{{ __('Assignat per la direcció') }}</span>
                            </div>
                        @endif
                        <x-input-error for="porcentaje" class="mt-1.5" />
                    </div>

                    @if (Auth::user()->roles()->where('title', 'Admin')->exists())
                        <!-- Fecha Alta -->
                        <div>
                            <x-label for="fechaAlta" value="{{ __('Data d\'Alta') }}" class="font-semibold text-slate-700 dark:text-slate-300" />
                            <x-input id="fechaAlta" type="date" class="mt-1.5 block w-full rounded-xl border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-primary/20 text-sm shadow-xs" 
                                wire:model="state.fechaAlta" />
                            <x-input-error for="fechaAlta" class="mt-1.5" />
                        </div>

                        <!-- Activo & Forastero -->
                        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label for="activo" class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-900/40 cursor-pointer hover:border-slate-300 transition-colors">
                                <input id="activo" type="checkbox" wire:model="state.activo"
                                    class="h-5 w-5 rounded-lg border-slate-300 text-primary focus:ring-primary/20" />
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ __('Músic Actiu') }}</p>
                                    <p class="text-xs text-slate-500">{{ __('Participa en les convocatòries regulars de la banda.') }}</p>
                                </div>
                            </label>

                            <label for="forastero" class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-900/40 cursor-pointer hover:border-slate-300 transition-colors">
                                <input id="forastero" type="checkbox" wire:model="state.forastero"
                                    class="h-5 w-5 rounded-lg border-slate-300 text-primary focus:ring-primary/20" />
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ __('Músic Foraster / Reforç') }}</p>
                                    <p class="text-xs text-slate-500">{{ __('Músic extern convocat per a reforç puntual.') }}</p>
                                </div>
                            </label>
                        </div>

                        <!-- Observaciones -->
                        <div class="md:col-span-2">
                            <x-label for="observaciones" value="{{ __('Observacions de Direcció') }}" class="font-semibold text-slate-700 dark:text-slate-300" />
                            <textarea id="observaciones" rows="3" class="mt-1.5 block w-full rounded-xl border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-primary/20 text-sm shadow-xs" 
                                wire:model="state.observaciones" placeholder="{{ __('Notes administratives internes sobre el músic...') }}"></textarea>
                            <x-input-error for="observaciones" class="mt-1.5" />
                        </div>
                    @endif
                </div>
            </div>

            <!-- BLOQUE 4: LOGÍSTICA I DISPONIBILITAT DE TRANSPORTS -->
            <div class="pt-2">
                <div class="flex items-center gap-2 mb-3">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        {{ __('Logística i Disponibilitat de Transports') }}
                    </h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Cotxe -->
                    <label for="tienecoche" 
                           class="relative flex items-center justify-between p-4 rounded-2xl border-2 transition-all cursor-pointer {{ !empty($state['tienecoche']) ? 'border-sky-500 bg-sky-50/40 dark:bg-sky-950/20' : 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/60 hover:border-slate-300' }}">
                        <div class="flex items-center gap-3.5">
                            <div class="p-2.5 rounded-xl bg-sky-100 dark:bg-sky-900/50 text-sky-600 dark:text-sky-400 flex-shrink-0">
                                <x-coche h="24" w="24"/>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ __('Vehicle Propi (Cotxe)') }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ __('Puc aportar vehicle propi per als desplaçaments si cal.') }}
                                </p>
                            </div>
                        </div>
                        <input type="checkbox" name="tienecoche" id="tienecoche"
                            wire:model.live="state.tienecoche"
                            class="h-5 w-5 rounded-lg border-slate-300 text-sky-600 focus:ring-sky-500 flex-shrink-0 ml-3" />
                    </label>

                    <!-- Furgona -->
                    <label for="tienefurgo" 
                           class="relative flex items-center justify-between p-4 rounded-2xl border-2 transition-all cursor-pointer {{ !empty($state['tienefurgo']) ? 'border-amber-500 bg-amber-50/40 dark:bg-amber-950/20' : 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/60 hover:border-slate-300' }}">
                        <div class="flex items-center gap-3.5">
                            <div class="p-2.5 rounded-xl bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 flex-shrink-0">
                                <x-furgo h="24" w="24"/>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ __('Furgoneta de la Banda') }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ __('Puc conduir la furgoneta o carregar material musical.') }}
                                </p>
                            </div>
                        </div>
                        <input type="checkbox" name="tienefurgo" id="tienefurgo"
                            wire:model.live="state.tienefurgo"
                            class="h-5 w-5 rounded-lg border-slate-300 text-amber-600 focus:ring-amber-500 flex-shrink-0 ml-3" />
                    </label>
                </div>
            </div>
        </div>

        <!-- ACCIONES / BOTÓN GUARDAR -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-700/60">
            <x-action-message class="me-3 text-xs sm:text-sm font-bold text-emerald-600 dark:text-emerald-400" on="saved">
                {{ __('Guardat correctament.') }}
            </x-action-message>

            <button type="submit" 
                    wire:loading.attr="disabled" 
                    wire:target="photo, updateProfileInformation"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white font-bold text-xs sm:text-sm shadow-md shadow-primary/20 transition-all duration-200 active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" wire:loading.remove wire:target="updateProfileInformation">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" wire:loading wire:target="updateProfileInformation">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ __('Guardar Canvis') }}</span>
            </button>
        </div>
    </form>
</div>
