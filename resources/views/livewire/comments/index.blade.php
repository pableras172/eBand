<div class="space-y-5">
    {{-- HEADER Y BREADCRUMBS --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Comentaris') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ __('Comentaris d\'actuacions') }}
                        </h1>
                        <span class="inline-flex items-center rounded-xl bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100">
                            {{ $counts['all'] }} {{ __('totals') }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Supervisió de missatges, dubtes dels músics sobre actuacions i moderació') }}
                    </p>
                </div>
            </div>

            @can('SuperAdmin')
                <div class="flex items-center gap-2">
                    <a href="{{ url('/run-job') }}"
                        class="inline-flex items-center gap-2 rounded-2xl border border-indigo-100 bg-white px-3.5 py-2.5 text-xs font-bold text-indigo-700 hover:bg-indigo-50 shadow-xs transition active:scale-95"
                        title="{{ __('Executar tasca de notificacions de comentaris diaris') }}">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>{{ __('Executar notificacions') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </x-slot>

    {{-- BARRA DE FILTROS Y BÚSQUEDA NEO-BENTO --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-4 sm:p-5 shadow-bento space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            {{-- Píldoras de estado --}}
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" wire:click="setFilter('all')"
                    class="inline-flex items-center gap-1.5 rounded-2xl px-3.5 py-2 text-xs font-bold transition {{ $filter === 'all' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-[#F5F6FC] text-slate-600 hover:bg-indigo-50 hover:text-indigo-700' }}">
                    <span>{{ __('Tots') }}</span>
                    <span class="rounded-xl px-1.5 py-0.5 text-[10px] {{ $filter === 'all' ? 'bg-white/20 text-white' : 'bg-slate-200/70 text-slate-600' }}">
                        {{ $counts['all'] }}
                    </span>
                </button>

                <button type="button" wire:click="setFilter('active')"
                    class="inline-flex items-center gap-1.5 rounded-2xl px-3.5 py-2 text-xs font-bold transition {{ $filter === 'active' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-[#F5F6FC] text-slate-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                    <span>{{ __('Actius') }}</span>
                    <span class="rounded-xl px-1.5 py-0.5 text-[10px] {{ $filter === 'active' ? 'bg-white/20 text-white' : 'bg-slate-200/70 text-slate-600' }}">
                        {{ $counts['active'] }}
                    </span>
                </button>

                <button type="button" wire:click="setFilter('flagged')"
                    class="inline-flex items-center gap-1.5 rounded-2xl px-3.5 py-2 text-xs font-bold transition {{ $filter === 'flagged' ? 'bg-amber-600 text-white shadow-xs' : 'bg-[#F5F6FC] text-slate-600 hover:bg-amber-50 hover:text-amber-700' }}">
                    <span>{{ __('Inadequats / Denunciats') }}</span>
                    <span class="rounded-xl px-1.5 py-0.5 text-[10px] {{ $filter === 'flagged' ? 'bg-white/20 text-white' : ($counts['flagged'] > 0 ? 'bg-amber-100 text-amber-800 font-black' : 'bg-slate-200/70 text-slate-600') }}">
                        {{ $counts['flagged'] }}
                    </span>
                </button>

                <button type="button" wire:click="setFilter('deleted')"
                    class="inline-flex items-center gap-1.5 rounded-2xl px-3.5 py-2 text-xs font-bold transition {{ $filter === 'deleted' ? 'bg-rose-600 text-white shadow-xs' : 'bg-[#F5F6FC] text-slate-600 hover:bg-rose-50 hover:text-rose-700' }}">
                    <span>{{ __('Ocults / Eliminats') }}</span>
                    <span class="rounded-xl px-1.5 py-0.5 text-[10px] {{ $filter === 'deleted' ? 'bg-white/20 text-white' : 'bg-slate-200/70 text-slate-600' }}">
                        {{ $counts['deleted'] }}
                    </span>
                </button>
            </div>

            {{-- Buscador con debounce --}}
            <div class="relative w-full md:w-80">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Buscar comentari, músic o actuació...') }}"
                    class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] pl-10 pr-9 py-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                @if ($search)
                    <button type="button" wire:click="$set('search', '')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                        ✕
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- LISTADO MÓVIL (md:hidden) --}}
    <div class="md:hidden space-y-3">
        @forelse ($comments as $comment)
            <div class="rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento space-y-3 transition hover:border-indigo-100">
                {{-- Cabecera de la tarjeta: Usuario + Fecha + Badges --}}
                <div class="flex items-start justify-between gap-2 border-b border-indigo-50/70 pb-2.5">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-700 shrink-0">
                            {{ mb_substr(optional($comment->user)->name ?? 'U', 0, 2) }}
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-800 leading-tight">
                                {{ optional($comment->user)->name ?? __('Usuari desconegut') }}
                            </span>
                            <span class="block text-[11px] text-slate-400">
                                {{ $comment->created_at ? $comment->created_at->diffForHumans() : '-' }}
                            </span>
                        </div>
                    </div>

                    {{-- Badges de estado --}}
                    <div class="flex items-center gap-1.5 shrink-0">
                        @if ($comment->eliminado)
                            <span class="rounded-xl bg-rose-50 px-2 py-0.5 text-[10px] font-bold text-rose-700 border border-rose-200">
                                {{ __('Eliminat') }}
                            </span>
                        @elseif ($comment->inadecuado)
                            <span class="rounded-xl bg-amber-50 px-2 py-0.5 text-[10px] font-bold text-amber-700 border border-amber-200">
                                {{ __('Inadequat') }}
                            </span>
                        @else
                            <span class="rounded-xl bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700 border border-emerald-200">
                                {{ __('Actiu') }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Referencia a la Actuación --}}
                @if ($comment->actuacion)
                    <div class="flex items-center gap-1.5 text-[11px] text-indigo-700 bg-indigo-50/70 border border-indigo-100/70 rounded-xl px-2.5 py-1">
                        <svg class="w-3.5 h-3.5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-bold truncate">{{ $comment->actuacion->descripcion }}</span>
                        @if ($comment->actuacion->fechaActuacion)
                            <span class="text-indigo-400 shrink-0">({{ \Carbon\Carbon::parse($comment->actuacion->fechaActuacion)->format('d/m/Y') }})</span>
                        @endif
                    </div>
                @endif

                {{-- Cuerpo del Comentario --}}
                <div class="rounded-2xl bg-[#F5F6FC] p-3 text-xs text-slate-700 leading-relaxed border border-indigo-50/80">
                    <p class="whitespace-pre-line">{{ $comment->comment }}</p>
                </div>

                {{-- Acciones rápidas --}}
                <div class="flex items-center justify-end gap-2 pt-1 border-t border-indigo-50/60">
                    {{-- Toggle Inadecuado --}}
                    <button type="button" wire:click="confirmDenuncia({{ $comment->id }}, '{{ addslashes(Str::limit($comment->comment, 80)) }}')"
                        class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold transition {{ $comment->inadecuado ? 'bg-amber-100 text-amber-800 border border-amber-200 hover:bg-amber-200' : 'bg-slate-100 text-slate-600 hover:bg-amber-50 hover:text-amber-700' }}"
                        title="{{ $comment->inadecuado ? __('Desmarcar de contingut inadequat') : __('Marcar com a inadequat') }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>{{ $comment->inadecuado ? __('Inadequat') : __('Moderar') }}</span>
                    </button>

                    {{-- Toggle Eliminado --}}
                    <button type="button" wire:click="confirmDeletion({{ $comment->id }})"
                        class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold transition {{ $comment->eliminado ? 'bg-rose-100 text-rose-800 border border-rose-200 hover:bg-rose-200' : 'bg-slate-100 text-slate-600 hover:bg-rose-50 hover:text-rose-700' }}"
                        title="{{ $comment->eliminado ? __('Restaurar comentari') : __('Ocultar comentari') }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if ($comment->eliminado)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            @endif
                        </svg>
                        <span>{{ $comment->eliminado ? __('Restaurar') : __('Ocultar') }}</span>
                    </button>

                    {{-- Enlace a editar --}}
                    <a wire:navigate href="{{ route('comments.edit', $comment) }}"
                        class="inline-flex items-center gap-1 p-1.5 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition"
                        title="{{ __('Editar comentari') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="rounded-3xl border border-indigo-50/80 bg-white p-8 text-center shadow-bento">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <p class="mt-4 text-sm font-bold text-slate-800">{{ __('No s\'han trobat comentaris') }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ __('Prova amb un altre terme de cerca o canvia el filtre d\'estat.') }}</p>
            </div>
        @endforelse

        @if ($comments->hasPages())
            <div class="pt-2">
                {{ $comments->links() }}
            </div>
        @endif
    </div>

    {{-- TABLA ESCRITORIO (hidden md:block) --}}
    <div class="hidden md:block overflow-hidden rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-indigo-50">
                <thead>
                    <tr class="bg-[#EEF1FA]/60">
                        <th scope="col" wire:click="sortBy('users.name')" class="cursor-pointer px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hover:text-indigo-600 transition">
                            <div class="inline-flex items-center gap-1">
                                <span>{{ __('Músic / Usuari') }}</span>
                                @if ($sortField === 'users.name')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Actuació') }}
                        </th>
                        <th scope="col" wire:click="sortBy('comments.comment')" class="cursor-pointer px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hover:text-indigo-600 transition">
                            <div class="inline-flex items-center gap-1">
                                <span>{{ __('Comentari') }}</span>
                                @if ($sortField === 'comments.comment')
                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Estat') }}
                        </th>
                        <th scope="col" class="px-5 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Accions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50/70 bg-white">
                    @forelse ($comments as $comment)
                        <tr wire:loading.class.delay="opacity-70" class="group hover:bg-indigo-50/40 transition {{ $comment->eliminado ? 'bg-rose-50/30' : ($comment->inadecuado ? 'bg-amber-50/30' : '') }}">
                            {{-- Usuario --}}
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-700 shrink-0">
                                        {{ mb_substr(optional($comment->user)->name ?? 'U', 0, 2) }}
                                    </div>
                                    <div>
                                        <span class="block text-xs font-bold text-slate-800 leading-tight">
                                            {{ optional($comment->user)->name ?? __('Usuari desconegut') }}
                                        </span>
                                        <span class="block text-[11px] text-slate-400">
                                            {{ $comment->created_at ? $comment->created_at->format('d/m/Y H:i') : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- Actuación --}}
                            <td class="px-5 py-4 whitespace-nowrap">
                                @if ($comment->actuacion)
                                    <div class="inline-flex flex-col">
                                        <span class="text-xs font-bold text-slate-800 truncate max-w-[200px]" title="{{ $comment->actuacion->descripcion }}">
                                            {{ $comment->actuacion->descripcion }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-[11px] text-slate-400">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($comment->actuacion->fechaActuacion)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>

                            {{-- Comentario --}}
                            <td class="px-5 py-4">
                                <div class="max-w-md">
                                    <p class="text-xs text-slate-700 line-clamp-2 leading-relaxed" title="{{ $comment->comment }}">
                                        {{ $comment->comment }}
                                    </p>
                                </div>
                            </td>

                            {{-- Estado --}}
                            <td class="px-5 py-4 whitespace-nowrap text-center">
                                @if ($comment->eliminado)
                                    <span class="inline-flex items-center gap-1 rounded-xl bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>{{ __('Eliminat') }}</span>
                                    </span>
                                @elseif ($comment->inadecuado)
                                    <span class="inline-flex items-center gap-1 rounded-xl bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>{{ __('Inadequat') }}</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-xl bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>{{ __('Actiu') }}</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-5 py-4 whitespace-nowrap text-right text-xs font-medium">
                                <div class="inline-flex items-center gap-1.5">
                                    {{-- Botón Moderar / Inadecuado --}}
                                    <button type="button" wire:click="confirmDenuncia({{ $comment->id }}, '{{ addslashes(Str::limit($comment->comment, 80)) }}')"
                                        class="rounded-xl p-2 transition {{ $comment->inadecuado ? 'bg-amber-100 text-amber-700 hover:bg-amber-200' : 'text-slate-400 hover:text-amber-600 hover:bg-amber-50' }}"
                                        title="{{ $comment->inadecuado ? __('Desmarcar de contingut inadequat') : __('Marcar com a inadequat') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </button>

                                    {{-- Botón Ocultar / Restaurar --}}
                                    <button type="button" wire:click="confirmDeletion({{ $comment->id }})"
                                        class="rounded-xl p-2 transition {{ $comment->eliminado ? 'bg-rose-100 text-rose-700 hover:bg-rose-200' : 'text-slate-400 hover:text-rose-600 hover:bg-rose-50' }}"
                                        title="{{ $comment->eliminado ? __('Restaurar comentari') : __('Ocultar comentari') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if ($comment->eliminado)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            @endif
                                        </svg>
                                    </button>

                                    {{-- Editar --}}
                                    <a wire:navigate href="{{ route('comments.edit', $comment) }}"
                                        class="rounded-xl p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition"
                                        title="{{ __('Editar comentari') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-xs">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 mx-auto flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-700 block text-sm">{{ __('No s\'han trobat comentaris') }}</span>
                                <span class="text-slate-500">{{ __('Prova amb un altre terme de cerca o canvia el filtre d\'estat.') }}</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($comments->hasPages())
            <div class="border-t border-indigo-50 px-5 py-3.5 bg-[#F5F6FC]/60">
                {{ $comments->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL DE CONFIRMACIÓN: OCULTAR / ELIMINAR --}}
    @if ($confirmingDeletion)
        <div class="fixed inset-0 z-[120] flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4">
            <div class="w-full max-w-md rounded-3xl border border-indigo-50 bg-white p-6 shadow-2xl space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold font-headline text-slate-900">{{ __('Canviar visibilitat del comentari') }}</h3>
                        <p class="text-xs text-slate-500">{{ __('Vols canviar l\'estat d\'eliminat / ocult d\'este missatge?') }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-indigo-50">
                    <button type="button" wire:click="$set('confirmingDeletion', false)"
                        class="rounded-2xl border border-indigo-100 bg-[#F5F6FC] px-4 py-2 text-xs font-bold text-slate-600 hover:bg-indigo-50 transition">
                        {{ __('Cancel·lar') }}
                    </button>
                    <button type="button" wire:click="delete"
                        class="rounded-2xl bg-rose-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-rose-600/20 hover:bg-rose-700 transition active:scale-95">
                        {{ __('Confirmar') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL DE CONFIRMACIÓN: MODERAR / INADECUADO --}}
    @if ($confirmingDenuncia)
        <div class="fixed inset-0 z-[120] flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4">
            <div class="w-full max-w-md rounded-3xl border border-indigo-50 bg-white p-6 shadow-2xl space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold font-headline text-slate-900">{{ __('Moderar comentari') }}</h3>
                        <p class="text-xs text-slate-500">{{ __('Alternar la marca de contingut inadequat o denunciat') }}</p>
                    </div>
                </div>

                @if ($contenidoComentario)
                    <div class="rounded-2xl bg-[#F5F6FC] p-3 text-xs text-slate-700 italic border border-indigo-50">
                        "{{ $contenidoComentario }}"
                    </div>
                @endif

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-indigo-50">
                    <button type="button" wire:click="$set('confirmingDenuncia', false)"
                        class="rounded-2xl border border-indigo-100 bg-[#F5F6FC] px-4 py-2 text-xs font-bold text-slate-600 hover:bg-indigo-50 transition">
                        {{ __('Cancel·lar') }}
                    </button>
                    <button type="button" wire:click="denuncia"
                        class="rounded-2xl bg-amber-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-amber-600/20 hover:bg-amber-700 transition active:scale-95">
                        {{ __('Confirmar canvi') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
