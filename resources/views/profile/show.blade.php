<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <x-ui.breadcrumbs>
                    <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                    <x-ui.breadcrumbs.separator />
                    <x-ui.breadcrumbs.link active>{{ __('El meu Perfil') }}</x-ui.breadcrumbs.link>
                </x-ui.breadcrumbs>
                <h1 class="text-2xl lg:text-3xl font-black font-headline text-on-surface tracking-tight mt-1">
                    {{ __('El meu Perfil de Músic') }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    {{ __('Dades personals, assignació d\'instruments, transports i seguretat') }}
                </p>
            </div>
        </div>
    </x-slot>

    @php
        $user = Auth::user();
        $isAdmin = $user->roles()->where('title', 'Admin')->exists();
    @endphp

    <div class="pb-24 pt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" x-data="{ activeTab: 'dades' }">

            <!-- Hero Card Bento de Perfil -->
            <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl border border-indigo-50/80 dark:border-slate-700/80 shadow-bento p-6 sm:p-8">
                <!-- Aura sutil de fondo -->
                <div class="absolute -top-16 -right-16 w-64 h-64 bg-gradient-to-br from-primary/10 via-indigo-500/10 to-transparent rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <!-- Foto / Avatar con badge -->
                    <div class="relative flex-shrink-0">
                        <img src="{{ $user->profile_photo_url }}" 
                             alt="{{ $user->name }}"
                             class="h-24 w-24 sm:h-28 sm:w-28 rounded-2xl object-cover ring-4 ring-indigo-50 dark:ring-slate-700 shadow-md">
                        @if ($user->activo ?? true)
                            <span class="absolute -bottom-1 -right-1 h-5 w-5 bg-emerald-500 border-2 border-white dark:border-slate-800 rounded-full shadow-sm" title="{{ __('Actiu') }}"></span>
                        @else
                            <span class="absolute -bottom-1 -right-1 h-5 w-5 bg-rose-500 border-2 border-white dark:border-slate-800 rounded-full shadow-sm" title="{{ __('Inactiu') }}"></span>
                        @endif
                    </div>

                    <!-- Datos y badges semánticos -->
                    <div class="flex-1 text-center sm:text-left space-y-3">
                        <div class="space-y-1">
                            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-white tracking-tight">
                                {{ $user->name }}
                            </h2>
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-4 gap-y-1 text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $user->email }}
                                </span>
                                @if ($user->telefono)
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $user->telefono }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Badges Bento -->
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 pt-1">
                            <!-- Instrumento -->
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800">
                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                {{ $user->instrument?->name ?? __('Sense instrument') }}
                            </span>

                            <!-- Rol -->
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-100 dark:border-purple-800">
                                <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                {{ $isAdmin ? __('Administrador') : __('Músic') }}
                            </span>

                            <!-- Liquidació -->
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800">
                                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $user->porcentaje ?? 100 }}% {{ __('Liquidació') }}
                            </span>

                            <!-- Vehículos -->
                            @if ($user->tienecoche)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-50 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 border border-sky-100 dark:border-sky-800">
                                    <x-coche h="14" w="14" />
                                    {{ __('Cotxe disponible') }}
                                </span>
                            @endif

                            @if ($user->tienefurgo)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-100 dark:border-amber-800">
                                    <x-furgo h="14" w="14" />
                                    {{ __('Furgona disponible') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navegación por Pestañas Bento Semánticas -->
            <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-1.5 rounded-2xl border border-indigo-50/80 dark:border-slate-700 shadow-bento inline-flex flex-wrap gap-1.5 w-full sm:w-auto">
                <!-- Tab 1: Dades del Músic -->
                <button type="button"
                        @click="activeTab = 'dades'"
                        :class="activeTab === 'dades' 
                            ? 'bg-primary text-white shadow-md shadow-primary/25 font-bold' 
                            : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/70 dark:hover:bg-slate-700 font-semibold'"
                        class="flex-1 sm:flex-initial flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>{{ __('Dades del Músic') }}</span>
                </button>

                <!-- Tab 2: Seguretat i Accés -->
                <button type="button"
                        @click="activeTab = 'seguretat'"
                        :class="activeTab === 'seguretat' 
                            ? 'bg-primary text-white shadow-md shadow-primary/25 font-bold' 
                            : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/70 dark:hover:bg-slate-700 font-semibold'"
                        class="flex-1 sm:flex-initial flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>{{ __('Seguretat i Accés') }}</span>
                </button>

                <!-- Tab 3: Mètriques i Notificacions -->
                <button type="button"
                        @click="activeTab = 'notificacions'"
                        :class="activeTab === 'notificacions' 
                            ? 'bg-primary text-white shadow-md shadow-primary/25 font-bold' 
                            : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/70 dark:hover:bg-slate-700 font-semibold'"
                        class="flex-1 sm:flex-initial flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>{{ __('Mètriques i Notificacions') }}</span>
                </button>
            </div>

            <!-- CONTENIDO PESTAÑA 1: DADES DEL MÚSIC -->
            <div x-show="activeTab === 'dades'" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="space-y-6">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.update-profile-information-form')
                @endif
            </div>

            <!-- CONTENIDO PESTAÑA 2: SEGURETAT I ACCÉS -->
            <div x-show="activeTab === 'seguretat'" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0"
                 style="display: none;"
                 class="space-y-6">
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    @livewire('profile.update-password-form')
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    @livewire('profile.two-factor-authentication-form')
                @endif

                @livewire('profile.logout-other-browser-sessions-form')

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    @livewire('profile.delete-user-form')
                @endif
            </div>

            <!-- CONTENIDO PESTAÑA 3: MÈTRIQUES I NOTIFICACIONS -->
            <div x-show="activeTab === 'notificacions'" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-2" 
                 x-transition:enter-end="opacity-100 translate-y-0"
                 style="display: none;"
                 class="space-y-6">
                <x-notifications-button />

                <x-profile-metrics />

                @if (config('cashier.ui_enabled', false))
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-indigo-50/80 dark:border-slate-700 shadow-bento p-6">
                        <x-subscription-info />
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
