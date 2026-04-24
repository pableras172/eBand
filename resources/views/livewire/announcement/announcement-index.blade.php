<div class="max-w-7xl mx-auto py-2 px-2 pb-24 sm:px-6 lg:px-8 space-y-4">
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Anuncios</h1>
                <p class="text-sm text-gray-600">Gestiona anuncios segmentados por instrumentos y vigencia.</p>
            </div>
            <a href="{{ route('announcements.create') }}"
                class="inline-flex items-center rounded-md bg-cyan-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-cyan-500">
                Nuevo anuncio
            </a>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-xl bg-white p-4 shadow-sm sm:p-6">
        <div class="mb-4">
            <label for="announcement-search" class="mb-1 block text-sm font-medium text-gray-700">Buscar</label>
            <input id="announcement-search" type="text" wire:model.live="search" placeholder="Título o contenido"
                class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" />
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Título</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Destino</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Vigencia</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Creado por</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Seguimiento</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Notificado</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($announcements as $announcement)
                        <tr class="align-top">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-900">{{ $announcement->title }}</p>
                                <p class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit(strip_tags((string) $announcement->body), 100) }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @if ($announcement->applies_to_all)
                                    Todos los usuarios
                                @else
                                    {{ $announcement->instruments->pluck('name')->join(', ') }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <div>{{ optional($announcement->starts_at)->format('d/m/Y H:i') }}</div>
                                <div class="text-xs text-gray-500">hasta {{ optional($announcement->ends_at)->format('d/m/Y H:i') ?: 'sin fin' }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ optional($announcement->creator)->name ?: 'Sistema' }}</td>
                            <td class="px-4 py-3 text-xs text-gray-700">
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="rounded-full bg-slate-100 px-2 py-1 font-semibold text-slate-700">Destino: {{ $metrics[$announcement->id]['targeted'] ?? 0 }}</span>
                                    <span class="rounded-full bg-emerald-100 px-2 py-1 font-semibold text-emerald-700">Leido: {{ $metrics[$announcement->id]['read'] ?? 0 }}</span>
                                    <span class="rounded-full bg-amber-100 px-2 py-1 font-semibold text-amber-700">Cerrado: {{ $metrics[$announcement->id]['closed'] ?? 0 }}</span>
                                    <span class="rounded-full bg-rose-100 px-2 py-1 font-semibold text-rose-700">Pendiente: {{ $metrics[$announcement->id]['pending'] ?? 0 }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ optional($announcement->notified_at)->format('d/m/Y H:i') ?: 'Pendiente' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <button type="button" wire:click="notifyUsers({{ $announcement->id }})"
                                        class="rounded-md border border-cyan-200 bg-cyan-50 px-3 py-1.5 text-xs font-semibold text-cyan-700 hover:bg-cyan-100">
                                        Notificar
                                    </button>
                                    <a href="{{ route('announcements.edit', $announcement) }}"
                                        class="rounded-md border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                        Editar
                                    </a>
                                    <button type="button" wire:click="confirmDeletion({{ $announcement->id }})"
                                        class="rounded-md border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">No hay anuncios disponibles.</td>
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
