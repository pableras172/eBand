<x-action-section>
    <x-slot name="title">
        <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-br from-amber-500 to-yellow-600 p-2.5 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ __('Notificaciones') }}</h3>
                    <div class="h-1 w-16 bg-gradient-to-r from-amber-500 to-yellow-600 rounded-full mt-1"></div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="description">
        <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 space-y-2">
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                {{ __('Configura las notificaciones en este dispositivo.') }}
            </p>
            <div class="flex items-start space-x-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-3">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs text-amber-700 dark:text-amber-300">
                    {{ __('Activa o desactiva las notificaciones automáticas.') }}
                </p>
            </div>
        </div>
    </x-slot>
    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('Activa o desactiva las notificaciones en este dispositivo. Recuerda que si el navegador te pregunta, debes permitir las notificaciones') }}
        </div>
        <div class="flex items-center mt-5">
            <div class='onesignal-customlink-container'></div>
        </div>
    </x-slot>
</x-action-section>