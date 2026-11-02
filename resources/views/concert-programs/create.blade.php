<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear programa de concierto
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl bg-white p-6 shadow sm:p-8">
                @include('concert-programs._form', [
                    'action' => route('concert-programs.store'),
                    'method' => 'POST',
                    'submitLabel' => 'Crear programa',
                ])
            </div>
        </div>
    </div>
</x-app-layout>
