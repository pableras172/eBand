<x-action-section>
    <x-slot name="title">
        {{ __('Notificaciones') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Configura las notificaciones') }}
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