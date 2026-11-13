<div class="max-w-7xl mx-auto py-2 px-2 pb-28 sm:px-6 lg:px-8 space-y-4">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5a2 2 0 114 0v1.465a1 1 0 00.293.707l1.535 1.535A2 2 0 0117.414 12H8.586a2 2 0 01-1.414-3.414l1.535-1.535A1 1 0 009 7.465V5a2 2 0 012-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17h6m-6 3h6" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Anuncis') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('Anuncis i Comunicats') }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">Gestiona anuncis segmentats per instruments i vigència.</p>
                </div>
            </div>
            <a href="{{ route('announcements.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Nuevo anuncio</span>
            </a>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-3xl bg-white p-5 shadow-bento border border-indigo-50/80 sm:p-6">
        <div class="mb-4">
            <label for="announcement-search" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600">Buscar</label>
            <input id="announcement-search" type="text" wire:model.live="search" placeholder="Título o contenido"
                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] px-4 py-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 shadow-xs" />
        </div>

        <div class="overflow-x-auto rounded-2xl border border-indigo-50">
            <table class="min-w-full divide-y divide-indigo-50">
                <thead class="bg-[#EEF1FA]/60">
                    <tr>
                        <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Título</th>
                        <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Destino</th>
                        <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Vigencia</th>
                        <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Creado por</th>
                        <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Seguimiento</th>
                        <th class="px-4 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Notificado</th>
                        <th class="px-4 py-3.5 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50/70 bg-white">
                    @forelse ($announcements as $announcement)
                        <tr class="align-top hover:bg-indigo-50/30 transition-colors">
                            <td class="px-4 py-3.5">
                                <p class="font-bold text-slate-900 text-sm">{{ $announcement->title }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ \Illuminate\Support\Str::limit(strip_tags((string) $announcement->body), 100) }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-xs font-semibold text-slate-700">
                                @if ($announcement->applies_to_all)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">Tots els usuaris</span>
                                @else
                                    {{ $announcement->instruments->pluck('name')->join(', ') }}
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-xs text-slate-700">
                                <div class="font-bold text-slate-800">{{ optional($announcement->starts_at)->format('d/m/Y H:i') }}</div>
                                <div class="text-[11px] text-slate-400">fins {{ optional($ends_at = $announcement->ends_at)->format('d/m/Y H:i') ?: 'sense fi' }}</div>
                            </td>
                            <td class="px-4 py-3.5 text-xs font-semibold text-slate-700">{{ optional($announcement->creator)->name ?: 'Sistema' }}</td>
                            <td class="px-4 py-3.5 text-xs text-slate-700">
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="rounded-full bg-slate-100 px-2 py-0.5 font-bold text-slate-700 text-[10px]">Destino: {{ $metrics[$announcement->id]['targeted'] ?? 0 }}</span>
                                    <span class="rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 px-2 py-0.5 font-bold text-[10px]">Leído: {{ $metrics[$announcement->id]['read'] ?? 0 }}</span>
                                    <span class="rounded-full bg-amber-50 text-amber-800 border border-amber-200 px-2 py-0.5 font-bold text-[10px]">Cerrado: {{ $metrics[$announcement->id]['closed'] ?? 0 }}</span>
                                    <span class="rounded-full bg-rose-50 text-rose-800 border border-rose-200 px-2 py-0.5 font-bold text-[10px]">Pendiente: {{ $metrics[$announcement->id]['pending'] ?? 0 }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-xs text-slate-600">{{ optional($announcement->notified_at)->format('d/m/Y H:i') ?: 'Pendiente' }}</td>
                            <td class="px-4 py-3.5">
                                <div class="flex justify-end gap-1.5">
                                    <button type="button" wire:click="notifyUsers({{ $announcement->id }})"
                                        class="rounded-xl border border-indigo-200 bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700 hover:bg-indigo-100 transition">
                                        Notificar
                                    </button>
                                    <a href="{{ route('announcements.edit', $announcement) }}"
                                        class="rounded-xl border border-indigo-100 bg-white px-2.5 py-1 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                                        Editar
                                    </a>
                                    <button type="button" wire:click="confirmDeletion({{ $announcement->id }})"
                                        class="rounded-xl border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-700 hover:bg-rose-100 transition">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">No hay anuncios disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $announcements->links() }}
        </div>
    </div>

    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title">Eliminar anuncio</x-slot>
        <x-slot name="content">Esta acción no se puede deshacer.</x-slot>
        <x-slot name="footer">
            <x-ui.button wire:click="$toggle('confirmingDeletion')">Cancelar</x-ui.button>
            <x-ui.button.danger class="ml-3" wire:click="delete">Eliminar</x-ui.button.danger>
        </x-slot>
    </x-ui.modal.confirm>
</div>
