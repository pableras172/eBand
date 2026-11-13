<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Programes de concert') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('Programas de concierto') }}
                    </h1>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <form action="{{ route('concert-programs.download-qr') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-2xl border border-indigo-100 bg-white px-3.5 py-2 text-xs font-bold text-indigo-700 hover:bg-indigo-50 shadow-xs transition">
                        Descargar QR /programa
                    </button>
                </form>
                <a href="{{ route('concert-programs.create') }}" class="rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white hover:bg-indigo-700 shadow-md shadow-indigo-600/20 transition">
                    Nuevo programa
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 pb-28">
        <div class="mx-auto max-w-6xl px-3 sm:px-6 lg:px-8 space-y-4">
            @if (session('success_message'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-semibold text-emerald-800">
                    {{ session('success_message') }}
                </div>
            @endif

            @if (session('error_message'))
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs font-semibold text-rose-800">
                    {{ session('error_message') }}
                </div>
            @endif

            <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-4 text-xs font-medium text-indigo-900 flex items-center justify-between">
                <span>URL pública para QR:
                    <a href="{{ route('concert-programs.public') }}" class="font-bold underline text-indigo-700 hover:text-indigo-800" target="_blank" rel="noopener">
                        {{ route('concert-programs.public') }}
                    </a>
                </span>
                <span class="text-lg">🎺</span>
            </div>

            <div class="overflow-hidden rounded-3xl bg-white border border-indigo-50/80 shadow-bento">
                <table class="min-w-full divide-y divide-indigo-50">
                    <thead class="bg-[#EEF1FA]/60">
                        <tr>
                            <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Titulo</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Fecha</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Hora</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Ubicacion</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Estado</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Obras</th>
                            <th class="px-4 py-3.5 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-indigo-50/70 bg-white">
                        @forelse ($programs as $program)
                            <tr class="hover:bg-indigo-50/30 transition-colors">
                                <td class="px-4 py-3.5 text-sm font-bold text-slate-900">{{ $program->title }}</td>
                                <td class="px-4 py-3.5 text-xs text-slate-700 font-medium">{{ optional($program->event_date)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3.5 text-xs text-slate-700 font-medium">{{ substr((string) $program->event_time, 0, 5) }}</td>
                                <td class="px-4 py-3.5 text-xs text-slate-700">{{ $program->location }}</td>
                                <td class="px-4 py-3.5 text-xs">
                                    @if ($program->is_published)
                                        <span class="rounded-full bg-emerald-50 border border-emerald-200 px-2.5 py-1 text-[11px] font-bold text-emerald-800">Publicado</span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-600">Borrador</span>
                                    @endif

                                    @if ($program->is_featured)
                                        <span class="ml-1 rounded-full bg-amber-50 border border-amber-200 px-2.5 py-1 text-[11px] font-bold text-amber-800">Destacado</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-xs font-bold text-indigo-700">{{ $program->pieces_count }}</td>
                                <td class="px-4 py-3.5 text-right text-xs space-x-2 font-bold">
                                    <a href="{{ route('concert-programs.poster.preview', $program) }}" class="text-cyan-700 hover:text-cyan-900" target="_blank" rel="noopener">Cartel A4</a>
                                    <a href="{{ route('concert-programs.edit', $program) }}" class="text-indigo-600 hover:text-indigo-800">Editar</a>
                                    <form action="{{ route('concert-programs.destroy', $program) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que quieres eliminar este programa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">Todavia no hay programas de concierto.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $programs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
