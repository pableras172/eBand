<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('concert-programs.index') }}">{{ __('Programes de concert') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Nou programa') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('Crear programa de concert') }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Introdueix les dades bàsiques, imatges i repertori del concert') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('concert-programs.index') }}"
                    class="inline-flex items-center gap-2 rounded-2xl border border-indigo-100 bg-white px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-700 shadow-xs transition active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Tornar al llistat') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 pb-32">
        <div class="mx-auto max-w-5xl px-3 sm:px-6 lg:px-8">
            @include('concert-programs._form', [
                'action' => route('concert-programs.store'),
                'method' => 'POST',
                'submitLabel' => __('Crear programa'),
            ])
        </div>
    </div>
</x-app-layout>
