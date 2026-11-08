<div class="max-w-7xl mx-auto py-4 px-2 pb-24 sm:px-6 lg:px-8 space-y-6"
    x-data="{
        shareModalOpen: false,
        shareData: { title: '', text: '', url: '' },
        copied: false,
        compartir(data) {
            this.shareData = data;
            this.copied = false;
            if (navigator.share) {
                navigator.share({
                    title: data.title,
                    text: data.text,
                    url: data.url
                }).catch(err => {
                    if (err.name !== 'AbortError') {
                        this.shareModalOpen = true;
                    }
                });
            } else {
                this.shareModalOpen = true;
            }
        },
        copyToClipboard() {
            navigator.clipboard.writeText(this.shareData.url).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2500);
            });
        }
    }">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <span>🎉</span> {{ __('actividades.admin_title') }}
                </h1>
                <p class="text-sm text-gray-600">{{ __('actividades.admin_subtitle') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('actividades.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                    {{ __('actividades.view_as_musician') }}
                </a>
                <a href="{{ route('admin.actividades.create') }}"
                    class="inline-flex items-center rounded-lg bg-cyan-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('actividades.new_activity') }}
                </a>
            </div>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filtros y Búsqueda -->
    <div class="rounded-2xl bg-white p-4 shadow-sm sm:p-6 border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="admin-search" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">{{ __('Buscar') }}</label>
                <input id="admin-search" type="text" wire:model.live.debounce.300ms="search" placeholder="Título o lugar..."
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" />
            </div>

            <div>
                <label for="admin-filtro-tipo" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">{{ __('Tipo') }}</label>
                <select id="admin-filtro-tipo" wire:model.live="filtroTipo"
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                    <option value="">{{ __('actividades.types.all') }}</option>
                    <option value="comida">🍽️ {{ __('actividades.types.comida') }}</option>
                    <option value="cena">🍷 {{ __('actividades.types.cena') }}</option>
                    <option value="concierto">🎺 {{ __('actividades.types.concierto') }}</option>
                    <option value="reunion">📋 {{ __('actividades.types.reunion') }}</option>
                    <option value="excursion">🚌 {{ __('actividades.types.excursion') }}</option>
                    <option value="otro">🎉 {{ __('actividades.types.otro') }}</option>
                </select>
            </div>

            <div>
                <label for="admin-filtro-estado" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">{{ __('Estado') }}</label>
                <select id="admin-filtro-estado" wire:model.live="filtroEstado"
                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                    <option value="">{{ __('actividades.status.all') }}</option>
                    <option value="borrador">{{ __('actividades.status.borrador') }}</option>
                    <option value="abierta">{{ __('actividades.status.abierta') }}</option>
                    <option value="cerrada">{{ __('actividades.status.cerrada') }}</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabla de Actividades -->
    <div class="rounded-2xl bg-white shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('actividades.activity') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('actividades.event_date') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('actividades.deadline') }}</th>
                        <th class="px-5 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Inscritos') }}</th>
                        <th class="px-5 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('actividades.total_predicted') }}</th>
                        <th class="px-5 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Estado') }}</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($actividades as $act)
                        <tr wire:key="actividad-{{ $act->id }}" class="hover:bg-gray-50/60 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl p-2 rounded-xl bg-gray-50">{{ $act->icono }}</span>
                                    <div>
                                        <div class="font-semibold text-gray-900 flex items-center gap-1.5">
                                            <span>{{ $act->titulo }}</span>
                                            @if ($act->notified_at)
                                                <span title="{{ __('actividades.notified_at', ['date' => $act->notified_at->translatedFormat('d M Y, H:i')]) }}" class="cursor-pointer text-xs">🔔</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center gap-2 mt-0.5">
                                            <span>{{ __('actividades.types.' . $act->tipo) }}</span>
                                            @if($act->lugar)
                                                <span>•</span>
                                                <span class="truncate max-w-xs">📍 {{ $act->lugar }}</span>
                                            @endif
                                            <span>•</span>
                                            @if ($act->es_de_pago)
                                                <span>{{ $act->opciones_count }} {{ __('opcions') }}</span>
                                            @else
                                                <span class="text-cyan-700 font-medium">🎺 {{ __('actividades.free_individual_badge') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="font-medium">{{ $act->fecha->translatedFormat('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $act->fecha->format('H:i') }} h</div>
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div>{{ $act->fecha_limite_inscripcion->translatedFormat('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $act->fecha_limite_inscripcion->format('H:i') }} h</div>
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700">
                                    {{ $act->inscripciones_count }} {{ __('persones') }}
                                </span>
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap text-center font-medium text-gray-900 text-sm">
                                @if ($act->es_de_pago)
                                    {{ number_format((float) ($act->inscripciones_sum_total ?? 0), 2, ',', '.') }} €
                                @else
                                    <span class="text-gray-400 font-normal">-</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap text-center">
                                <div class="inline-flex rounded-lg shadow-xs" role="group">
                                    @if ($act->estado === 'borrador')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                            {{ __('actividades.status.borrador') }}
                                        </span>
                                    @elseif ($act->estado === 'abierta')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                            {{ __('actividades.status.abierta') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700">
                                            {{ __('actividades.status.cerrada') }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Notificar OneSignal -->
                                    @if ($act->estado === 'abierta')
                                        <button type="button" wire:click="notificarOneSignal({{ $act->id }})"
                                            wire:confirm="{{ __('actividades.confirm_notify') }}"
                                            title="{{ __('actividades.notify_onesignal') }}"
                                            class="p-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                        </button>
                                    @endif

                                    <!-- Compartir -->
                                    <button type="button"
                                        @click="compartir({
                                            title: @js($act->titulo),
                                            text: @js(__('actividades.share_text', ['title' => $act->titulo, 'date' => $act->fecha->translatedFormat('d M Y, H:i')])),
                                            url: @js(route('actividades.show', $act))
                                        })"
                                        title="{{ __('actividades.share') }}"
                                        class="p-2 text-emerald-600 hover:text-emerald-800 hover:bg-emerald-50 rounded-lg transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                    </button>

                                    <!-- Ver detalle / inscripciones -->
                                    <a href="{{ route('admin.actividades.detail', $act) }}"
                                        title="{{ __('actividades.dashboard_title') }}"
                                        class="p-2 text-cyan-600 hover:text-cyan-800 hover:bg-cyan-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </a>

                                    <!-- Editar -->
                                    <a href="{{ route('admin.actividades.edit', $act) }}"
                                        title="{{ __('Editar') }}"
                                        class="p-2 text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>

                                    <!-- Eliminar -->
                                    <button type="button" wire:click="confirmDeletion({{ $act->id }})"
                                        title="{{ __('actividades.delete') }}"
                                        class="p-2 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-gray-500">
                                <div class="max-w-xs mx-auto text-center space-y-2">
                                    <span class="text-4xl block">📋</span>
                                    <p class="font-medium text-gray-900">{{ __('actividades.no_activities') }}</p>
                                    <p class="text-xs text-gray-500">{{ __('actividades.no_activities_sub') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($actividades->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $actividades->links() }}
            </div>
        @endif
    </div>

    <!-- Modal confirmación borrado -->
    @if ($confirmingDeletion)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4 border border-gray-100">
                <div class="flex items-center gap-3 text-rose-600">
                    <div class="p-2 rounded-full bg-rose-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">{{ __('actividades.confirm_delete_title') }}</h3>
                </div>

                <p class="text-sm text-gray-600">
                    {{ __('actividades.confirm_delete_sub') }}
                </p>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" wire:click="$set('confirmingDeletion', false)"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        {{ __('actividades.cancel') }}
                    </button>
                    <button type="button" wire:click="delete"
                        class="rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700 shadow-sm">
                        {{ __('actividades.yes_delete') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Compartir Enlace (Para ordenadores o navegadores sin Web Share) -->
    <div x-show="shareModalOpen" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-xs flex items-center justify-center p-4"
        @keydown.escape.window="shareModalOpen = false">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4 border border-gray-100"
            @click.outside="shareModalOpen = false">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🔗</span>
                    <h3 class="text-base font-bold text-gray-900">{{ __('actividades.share_modal_title') }}</h3>
                </div>
                <button type="button" @click="shareModalOpen = false" class="text-gray-400 hover:text-gray-600 transition">
                    ✕
                </button>
            </div>

            <div class="space-y-3">
                <p class="text-xs text-gray-700 font-semibold" x-text="shareData.title"></p>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">
                        {{ __('actividades.share_url_label') }}
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="text" readonly :value="shareData.url"
                            class="w-full rounded-lg border-gray-300 text-xs bg-gray-50 text-gray-700 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 select-all py-2"
                            @click="$el.select()" />
                        <button type="button" @click="copyToClipboard()"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-cyan-600 hover:bg-cyan-500 text-white text-xs font-semibold shadow-sm transition whitespace-nowrap cursor-pointer">
                            <template x-if="!copied">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ __('actividades.copy_url') }}</span>
                                </span>
                            </template>
                            <template x-if="copied">
                                <span class="flex items-center gap-1 text-emerald-200">
                                    <span>✓</span>
                                    <span>{{ __('actividades.copied') }}</span>
                                </span>
                            </template>
                        </button>
                    </div>
                </div>

                <!-- Accesos directos a WhatsApp Web -->
                <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                    <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent(shareData.text + ' ' + shareData.url)"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold transition shadow-xs">
                        <span>💬</span>
                        <span>{{ __('actividades.share_whatsapp') }}</span>
                    </a>

                    <button type="button" @click="shareModalOpen = false"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition cursor-pointer">
                        {{ __('actividades.close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
