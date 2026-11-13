<div>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('contratos.index') }}">{{ __('Contractes') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('contratos.edit', $contrato->id) }}">{{ $contrato->poblacion }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Actuacions') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ $contrato->descripcion }}
                        </h1>
                        <span class="inline-flex items-center rounded-xl bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100">
                            {{ $actuaciones->total() }} {{ __('actuacions') }}
                        </span>
                    </div>
                    <p class="mt-0.5 text-xs text-slate-500">
                        {{ $contrato->poblacion }} @if ($contrato->anyo) ({{ $contrato->anyo }}) @endif
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" wire:click="openCreateModal"
                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>{{ __('Nova actuació') }}</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto py-4 px-3 sm:px-6 lg:px-8 pb-32">
        @if (session()->has('success'))
            <div class="flash-alert flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 mb-5 rounded-2xl text-xs font-semibold shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Barra de búsqueda (Neo-Bento) --}}
        <div class="mb-5 rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento">
            <div class="relative w-full sm:max-w-md">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0Z" />
                    </svg>
                </span>
                <input
                    type="text"
                    wire:model.live.debounce.350ms="search"
                    placeholder="{{ __('Buscar per descripció, data o tipus...') }}"
                    class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 pl-11 pr-4 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                >
            </div>
        </div>

        {{-- Mobile Cards Layout (Solo móvil < sm) --}}
        <div class="space-y-3.5 sm:hidden">
            @forelse ($actuaciones as $actuacion)
                <div class="rounded-3xl border border-indigo-50/80 bg-white p-5 shadow-bento space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-1.5 mb-1">
                                <span class="inline-flex items-center gap-1 rounded-xl bg-indigo-50 px-2 py-0.5 text-xs font-bold text-indigo-700 border border-indigo-100/70">
                                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}
                                </span>
                                @if ($actuacion->is_draft)
                                    <span class="rounded-xl bg-amber-50 px-2 py-0.5 text-[11px] font-bold text-amber-700 border border-amber-200">
                                        {{ __('Borrador') }}
                                    </span>
                                @endif
                                @if ($actuacion->oficial)
                                    <span class="rounded-xl bg-indigo-50 px-2 py-0.5 text-[11px] font-bold text-indigo-700 border border-indigo-200">
                                        {{ __('Oficial') }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 leading-snug">
                                {{ $actuacion->descripcion }}
                            </h3>
                            <p class="mt-0.5 text-xs font-semibold text-slate-500">
                                {{ optional($actuacion->tipoactuacion)->nombre ?: __('Sin tipo') }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pt-2 border-t border-slate-100 text-center text-xs">
                        <div class="bg-slate-50 rounded-xl p-2">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">{{ __('Músics') }}</span>
                            <span class="font-bold text-slate-800">{{ $actuacion->musicos ?? '-' }}</span>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-2">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">{{ __('Cotxes') }}</span>
                            <span class="font-bold text-slate-800">{{ $actuacion->coches ?? '-' }}</span>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-2">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">{{ __('Furgones') }}</span>
                            <span class="font-bold text-slate-800">{{ $actuacion->furgonas ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Acciones Mobile --}}
                    <div class="flex items-center justify-end gap-1.5 pt-2 border-t border-slate-100">
                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100 hover:bg-indigo-100 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>{{ __('Llista') }}</span>
                        </a>

                        <button type="button" wire:click="openEditModal({{ $actuacion->id }})"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span>{{ __('Editar') }}</span>
                        </button>

                        <form method="POST" action="{{ route('actuacion.destroy', $actuacion) }}"
                            onsubmit="return confirm('{{ __('¿Estás seguro de que deseas eliminar esta actuacion? Si la actuación tiene una lista, también se eliminará.') }}')"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-red-50 text-red-600 text-xs font-bold border border-red-100 hover:bg-red-100 transition"
                                title="{{ __('Eliminar') }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-indigo-50/80 bg-white p-8 text-center shadow-bento">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-500">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="mt-4 text-sm font-bold text-slate-800">{{ __('Sin resultados') }}</p>
                    <p class="mt-1 text-xs text-slate-500">{{ __('No hay actuaciones para este contrato.') }}</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $actuaciones->links() }}
            </div>
        </div>

        {{-- Desktop Table Layout (sm y superior) --}}
        <div class="hidden sm:block overflow-hidden rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
            <table class="min-w-full divide-y divide-indigo-50">
                <thead>
                    <tr class="bg-[#EEF1FA]/60">
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Data') }}</th>
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Descripció') }}</th>
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Tipus') }}</th>
                        <th scope="col" class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Músics') }}</th>
                        <th scope="col" class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Vehicles') }}</th>
                        <th scope="col" class="px-5 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">{{ __('Accions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50/70 bg-white">
                    @forelse ($actuaciones as $actuacion)
                        <tr class="group hover:bg-indigo-50/40 transition">
                            <td class="px-5 py-4 whitespace-nowrap text-xs font-bold text-slate-700">
                                <div class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-50/80 px-2.5 py-1 text-indigo-700 border border-indigo-100/70">
                                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-sm text-slate-900">{{ $actuacion->descripcion }}</span>
                                    @if ($actuacion->is_draft)
                                        <span class="rounded-xl bg-amber-50 px-2 py-0.5 text-[11px] font-bold text-amber-700 border border-amber-200">
                                            {{ __('Borrador') }}
                                        </span>
                                    @endif
                                    @if ($actuacion->oficial)
                                        <span class="rounded-xl bg-indigo-50 px-2 py-0.5 text-[11px] font-bold text-indigo-700 border border-indigo-200">
                                            {{ __('Oficial') }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-xs font-semibold text-slate-600">
                                {{ optional($actuacion->tipoactuacion)->nombre ?: '-' }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-center text-xs font-bold text-slate-700">
                                {{ $actuacion->musicos ?? '-' }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-center text-xs text-slate-600">
                                <div class="flex items-center justify-center gap-2">
                                    <span title="{{ __('Cotxes') }}" class="inline-flex items-center gap-0.5">
                                        🚗 <span class="font-bold text-slate-700">{{ $actuacion->coches ?? 0 }}</span>
                                    </span>
                                    <span title="{{ __('Furgones') }}" class="inline-flex items-center gap-0.5">
                                        🚐 <span class="font-bold text-slate-700">{{ $actuacion->furgonas ?? 0 }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-right text-xs font-medium">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}"
                                        class="inline-flex items-center gap-1 rounded-xl bg-indigo-50 px-3 py-1.5 text-xs font-bold text-indigo-700 border border-indigo-100 hover:bg-indigo-100 transition shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span>{{ __('Llista') }}</span>
                                    </a>

                                    <button type="button" wire:click="openEditModal({{ $actuacion->id }})"
                                        class="rounded-xl p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition"
                                        title="{{ __('Editar') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <form method="POST" action="{{ route('actuacion.destroy', $actuacion) }}"
                                        onsubmit="return confirm('{{ __('¿Estás seguro de que deseas eliminar esta actuacion? Si la actuación tiene una lista, también se eliminará.') }}')"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-xl p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 transition"
                                            title="{{ __('Eliminar') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="mx-auto max-w-md">
                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-500">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="mt-4 text-sm font-bold text-slate-800">{{ __('Sin resultados') }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ __('No hay actuaciones para este contrato.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="border-t border-indigo-50 px-6 py-4">
                {{ $actuaciones->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Crear / Editar Actuación (Neo-Bento Claro) --}}
    @if ($showFormModal)
        <div class="fixed inset-0 z-[120] flex items-center justify-center bg-slate-900/50 backdrop-blur-xs p-3.5 sm:p-6">
            <div class="w-full max-w-2xl max-h-[80dvh] sm:max-h-[82vh] my-auto rounded-3xl border border-indigo-50 bg-white shadow-2xl flex flex-col overflow-hidden">
                {{-- Header Modal Fijo --}}
                <div class="flex-none flex items-center justify-between border-b border-indigo-50 bg-white px-4 py-3 sm:px-6 sm:py-3.5">
                    <div class="flex items-center gap-2.5 sm:gap-3">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-bold font-headline text-slate-900">
                                {{ $isEditing ? __('Editar actuació') : __('Nova actuació') }}
                            </h3>
                            <p class="text-[11px] text-slate-400 hidden sm:block">
                                {{ $contrato->poblacion }} — {{ $contrato->descripcion }}
                            </p>
                        </div>
                    </div>
                    <button type="button" wire:click="closeModal"
                        class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-200 transition">
                        ✕
                    </button>
                </div>

                {{-- Formulario con cuerpo scrolleable y footer fijo --}}
                <form wire:submit="save" class="flex-1 flex flex-col min-h-0">
                    <div class="flex-1 overflow-y-auto p-3.5 sm:p-5 space-y-3 overscroll-contain">
                        {{-- Fecha y Tipo --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3">
                            <div>
                                <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                    {{ __('Data actuacio') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="date" wire:model="fechaActuacion"
                                    class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition" required>
                                @error('fechaActuacion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                    {{ __('Tipus') }} <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="tipoactuacions_id"
                                    class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition" required>
                                    <option value="">{{ __('Selecciona tipus') }}</option>
                                    @foreach ($tiposActuacion as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('tipoactuacions_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                {{ __('Descripció') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="descripcion" rows="2"
                                placeholder="{{ __('Exemple: Entrada de Moros, Concert de Primavera, etc.') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] p-2.5 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition" required></textarea>
                            @error('descripcion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Bloque Músicos y Precios --}}
                        <div class="rounded-2xl border border-indigo-50 bg-slate-50/50 p-3 space-y-2.5">
                            <span class="block text-[11px] font-bold uppercase tracking-wider text-indigo-700">
                                {{ __('Personal i Vehicles') }}
                            </span>

                            <div class="grid grid-cols-2 gap-2.5 sm:gap-3">
                                <div>
                                    <label class="mb-1 block text-xs font-bold text-slate-600">{{ __('Numero musics') }}</label>
                                    <input type="number" wire:model="musicos" min="0" placeholder="0"
                                        class="w-full rounded-2xl border border-indigo-100/70 bg-white py-1.5 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                                    @error('musicos') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="mb-1 block text-xs font-bold text-slate-600">{{ __('Preu music') }} (€)</label>
                                    <input type="number" wire:model="preciomusico" step="0.01" placeholder="0.00"
                                        class="w-full rounded-2xl border border-indigo-100/70 bg-white py-1.5 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                                    @error('preciomusico') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="mb-1 block text-xs font-bold text-slate-600">{{ __('Cantitat de cotxes') }}</label>
                                    <input type="number" wire:model="coches" min="0" placeholder="0"
                                        class="w-full rounded-2xl border border-indigo-100/70 bg-white py-1.5 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                                    @error('coches') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="mb-1 block text-xs font-bold text-slate-600">{{ __('Preu cotxe') }} (€)</label>
                                    <input type="number" wire:model="preciocoche" min="0" step="0.01" placeholder="0.00"
                                        class="w-full rounded-2xl border border-indigo-100/70 bg-white py-1.5 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                                    @error('preciocoche') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="mb-1 block text-xs font-bold text-slate-600">{{ __('Cantitat de furgones') }}</label>
                                    <input type="number" wire:model="furgonas" min="0" placeholder="0"
                                        class="w-full rounded-2xl border border-indigo-100/70 bg-white py-1.5 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                                    @error('furgonas') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="mb-1 block text-xs font-bold text-slate-600">{{ __('Precio furgona') }} (€)</label>
                                    <input type="number" wire:model="preciofurgona" min="0" step="0.01" placeholder="0.00"
                                        class="w-full rounded-2xl border border-indigo-100/70 bg-white py-1.5 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                                    @error('preciofurgona') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Observaciones y % Personalizado en la misma línea --}}
                        <div class="grid grid-cols-12 gap-2.5 sm:gap-3 items-start">
                            <div class="col-span-8 sm:col-span-9">
                                <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600 whitespace-nowrap">
                                    {{ __('Observacions') }}
                                </label>
                                <input type="text" wire:model="observaciones"
                                    placeholder="{{ __('Notes d\'horari, vestuari, etc.') }}"
                                    class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2 px-3 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                                @error('observaciones') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-4 sm:col-span-3">
                                <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600 whitespace-nowrap">
                                    {{ __('% Personal') }}
                                </label>
                                <input type="number" wire:model="porcentajepersonal" step="0.01" placeholder="100%"
                                    class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                                @error('porcentajepersonal') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Opciones y Checkboxes --}}
                        <div class="pt-2 border-t border-indigo-50 space-y-2">
                            <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                {{ __('Estat i Configuració') }}
                            </span>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                                    <input type="checkbox" wire:model="pagado" class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500">
                                    <span>{{ __('Pagat') }}</span>
                                </label>
                                <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                                    <input type="checkbox" wire:model="aplicaporcentaje" class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500">
                                    <span>{{ __('Aplicar porcentaje') }}</span>
                                </label>
                                <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                                    <input type="checkbox" wire:model="noaplicapago" class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500">
                                    <span class="truncate">{{ __('No aplica en los pagos') }}</span>
                                </label>
                                <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                                    <input type="checkbox" wire:model="visible" class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500">
                                    <span>{{ __('Visible') }}</span>
                                </label>
                                <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                                    <input type="checkbox" wire:model="oficial" class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500">
                                    <span>{{ __('Acte Oficial') }}</span>
                                </label>
                                <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                                    <input type="checkbox" wire:model="is_draft" class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500">
                                    <span>{{ __('Borrador') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Modal Fijo con Botones --}}
                    <div class="flex-none border-t border-indigo-50 bg-white/95 backdrop-blur-md px-4 py-3 sm:px-6 sm:py-3.5 flex items-center justify-end gap-2.5 shadow-xs">
                        <button type="button" wire:click="closeModal"
                            class="rounded-2xl border border-indigo-100 bg-[#F5F6FC] px-4 py-2 text-xs font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-700 transition">
                            {{ __('Cancelar') }}
                        </button>
                        <button type="submit"
                            class="rounded-2xl bg-indigo-600 px-5 py-2 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 transition active:scale-95">
                            {{ __('Guardar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Barra Flotante Inferior (Neo-Bento Claro) --}}
    <footer class="fixed bottom-0 left-0 z-20 w-full bg-white/90 backdrop-blur-2xl border-t border-indigo-100/80 shadow-glass">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between gap-3 max-w-5xl">
            <a href="{{ route('contratos.edit', $contrato->id) }}"
                class="inline-flex items-center gap-1.5 rounded-2xl border border-indigo-100 bg-[#F5F6FC] px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-700 active:scale-95 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>{{ __('Tornar al contracte') }}</span>
            </a>

            <button type="button" wire:click="openCreateModal"
                class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>{{ __('Nova actuació') }}</span>
            </button>
        </div>
    </footer>
</div>
