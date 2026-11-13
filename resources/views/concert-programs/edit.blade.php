<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('concert-programs.index') }}">{{ __('Programes de concert') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Editar programa') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ $program->title }}
                        </h1>
                        @if ($program->is_published)
                            <span class="inline-flex items-center rounded-xl bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700 border border-emerald-200">
                                {{ __('Publicat') }}
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-xl bg-amber-50 px-2.5 py-0.5 text-xs font-bold text-amber-700 border border-amber-200">
                                {{ __('Borrador') }}
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ optional($program->event_date)->format('d/m/Y') }} — {{ $program->location }}
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
            @if (session('success_message'))
                <div class="flash-alert flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 mb-6 rounded-2xl text-xs font-semibold shadow-xs">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success_message') }}</span>
                </div>
            @endif

            @include('concert-programs._form', [
                'action' => route('concert-programs.update', $program),
                'method' => 'PUT',
                'submitLabel' => __('Guardar canvis'),
            ])
        </div>
    </div>
</x-app-layout>
