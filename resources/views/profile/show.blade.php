<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <x-ui.breadcrumbs>
                    <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                    <x-ui.breadcrumbs.separator />
                    <x-ui.breadcrumbs.link active>{{ __('El meu Perfil') }}</x-ui.breadcrumbs.link>
                </x-ui.breadcrumbs>
                <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-white tracking-tight mt-1">
                    {{ __('El meu Perfil de Músic') }}
                </h1>
                <p class="text-xs text-slate-400">
                    {{ __('Dades personals, assignació d\'instruments, transports i seguretat') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="pb-24">
        <div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8 space-y-6">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-6 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-6 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-6 sm:mt-0">
                <x-profile-metrics />
            </div>

            <div class="mt-6 sm:mt-0">
                <x-notifications-button />
            </div>

            <x-section-border />

            <div class="mt-6 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-6 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif

            @if (config('cashier.ui_enabled', false))
                <div class="p-4 mt-2">
                    <x-subscription-info />
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
