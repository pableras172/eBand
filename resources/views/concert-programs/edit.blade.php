<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar programa de concierto
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @if (session('success_message'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success_message') }}
                </div>
            @endif

            <div class="rounded-xl bg-white p-6 shadow sm:p-8">
                @include('concert-programs._form', [
                    'action' => route('concert-programs.update', $program),
                    'method' => 'PUT',
                    'submitLabel' => 'Guardar cambios',
                ])
            </div>
        </div>
    </div>
</x-app-layout>
