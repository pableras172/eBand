<x-slot name="header">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Actuaciones de') }} {{ $contrato->descripcion }}
        </h2>
        <p class="text-sm text-gray-500 mt-1">{{ $contrato->poblacion }}</p>
    </div>
</x-slot>

<div>
    <div class="mx-auto max-w-6xl px-2 py-4 pb-28 sm:px-4">
        @if (session()->has('success'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
            <input
                type="text"
                wire:model.live.debounce.350ms="search"
                placeholder="{{ __('Buscar por descripción, fecha o tipo') }}"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-100"
            >
        </div>

        <div class="space-y-3 sm:hidden">
            @forelse ($actuaciones as $actuacion)
                <details class="group overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <summary class="flex cursor-pointer list-none items-start justify-between gap-3 p-4">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    {{ Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}
                                </span>
                                @if ($actuacion->is_draft)
                                    <span class="rounded-full bg-yellow-100 px-2 py-0.5 text-[11px] font-semibold text-yellow-800">
                                        {{ __('Borrador') }}
                                    </span>
                                @endif
                            </div>
                            <p class="mt-1 truncate text-sm font-semibold text-gray-900">{{ $actuacion->descripcion }}</p>
                            <p class="mt-1 text-xs text-gray-500">
                                {{ optional($actuacion->tipoactuacion)->nombre ?: __('Sin tipo') }}
                            </p>
                        </div>

                        <svg class="mt-1 h-5 w-5 flex-none text-gray-400 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                        </svg>
                    </summary>

                    <div class="border-t border-gray-200 bg-gray-50 p-4">
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Tipo') }}</p>
                                <p class="mt-1 text-gray-700">{{ optional($actuacion->tipoactuacion)->nombre ?: '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Músicos') }}</p>
                                <p class="mt-1 text-gray-700">{{ $actuacion->musicos ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Coches') }}</p>
                                <p class="mt-1 text-gray-700">{{ $actuacion->coches ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Fecha') }}</p>
                                <p class="mt-1 text-gray-700">{{ Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="mt-4 overflow-hidden rounded-xl border border-slate-300 dark:border-slate-600">
                            <div class="flex items-stretch justify-center">
                                <a
                                    href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}"
                                    class="flex-1 flex flex-col items-center justify-center min-w-0 px-3 py-2 border-r border-slate-300 bg-green-50 text-green-700 hover:bg-green-100 dark:bg-green-900/30 dark:border-slate-600 dark:text-green-300 transition"
                                >
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 6H20M4 12H20M4 18H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="text-xs mt-1 font-semibold">{{ __('Llista') }}</span>
                                </a>

                                <button
                                    type="button"
                                    wire:click="openEditModal({{ $actuacion->id }})"
                                    class="flex-1 flex flex-col items-center justify-center min-w-0 px-3 py-2 border-r border-slate-300 bg-slate-50 text-slate-700 hover:bg-slate-100 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200 transition"
                                >
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 20H8L18.5 9.5C19.3284 8.67157 19.3284 7.32843 18.5 6.5C17.6716 5.67157 16.3284 5.67157 15.5 6.5L5 17V20Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M13.5 8.5L15.5 10.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="text-xs mt-1 font-semibold">{{ __('Editar') }}</span>
                                </button>

                                <form
                                    method="POST"
                                    action="{{ route('actuacion.destroy', $actuacion) }}"
                                    onsubmit="return confirm('{{ __('¿Estás seguro de que deseas eliminar esta actuacion?Si la actuación tiene una lista, también se eliminará.') }}')"
                                    class="flex-1"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="flex w-full flex-col items-center justify-center min-w-0 px-3 py-2 bg-red-50 text-red-700 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-300 transition"
                                    >
                                        <svg width="24px" height="24px" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17 11V9C17 6.79086 18.7909 5 21 5H27C29.2091 5 31 6.79086 31 9V11M7 11H41M19 11H29M20 21V33M24 21V33M28 21V33M11 11L13 39C13.1111 40.5556 14.4444 42 16 42H32C33.5556 42 34.8889 40.5556 35 39L37 11" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="text-xs mt-1 font-semibold">{{ __('Eliminar') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </details>
            @empty
                <div class="rounded-xl border border-gray-200 bg-white px-4 py-10 text-center text-sm text-gray-500 shadow-sm">
                    {{ __('No hay actuaciones para este contrato.') }}
                </div>
            @endforelse
        </div>

        <div class="mt-3 rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm sm:hidden">
            {{ $actuaciones->links() }}
        </div>

        <div class="hidden overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm sm:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">{{ __('Fecha') }}</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">{{ __('Descripción') }}</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">{{ __('Tipo') }}</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">{{ __('Músicos') }}</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">{{ __('Coches') }}</th>
                        <th class="px-3 py-2 text-right text-xs font-semibold uppercase tracking-wide text-gray-600">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($actuaciones as $actuacion)
                        <tr>
                            <td class="px-3 py-3 text-sm text-gray-700">{{ Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}</td>
                            <td class="px-3 py-3 text-sm text-gray-900">
                                <div class="flex items-center gap-2">
                                    <span>{{ $actuacion->descripcion }}</span>
                                    @if ($actuacion->is_draft)
                                        <span class="rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-semibold text-yellow-800">{{ __('Borrador') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3 text-sm text-gray-700">{{ optional($actuacion->tipoactuacion)->nombre }}</td>
                            <td class="px-3 py-3 text-sm text-gray-700">{{ $actuacion->musicos ?? '-' }}</td>
                            <td class="px-3 py-3 text-sm text-gray-700">{{ $actuacion->coches ?? '-' }}</td>
                            <td class="px-3 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a
                                        href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}"
                                        class="rounded-md bg-green-700 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-600"
                                    >
                                        {{ __('Llista') }}
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="openEditModal({{ $actuacion->id }})"
                                        class="rounded-md bg-gray-800 px-3 py-1.5 text-xs font-semibold text-white hover:bg-gray-700"
                                    >
                                        {{ __('Editar') }}
                                    </button>

                                    <form
                                        method="POST"
                                        action="{{ route('actuacion.destroy', $actuacion) }}"
                                        onsubmit="return confirm('{{ __('¿Estás seguro de que deseas eliminar esta actuacion?Si la actuación tiene una lista, también se eliminará.') }}')"
                                        class="inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="rounded-md bg-red-700 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-600"
                                        >
                                            {{ __('Eliminar') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-10 text-center text-sm text-gray-500">
                                {{ __('No hay actuaciones para este contrato.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="border-t border-gray-200 px-4 py-3">
                {{ $actuaciones->links() }}
            </div>
        </div>

    </div>

    @if ($showFormModal)
        <div class="fixed inset-0 z-[120] flex items-center justify-center bg-black/50 px-3">
            <div class="max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-xl bg-white shadow-xl">
                <div class="sticky top-0 flex items-center justify-between border-b border-gray-200 bg-white px-5 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $isEditing ? __('Editar actuación') : __('Nueva actuación') }}
                    </h3>
                    <button type="button" wire:click="closeModal" class="text-gray-500 hover:text-gray-700">✕</button>
                </div>

                <form wire:submit="save" class="p-5">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('Data actuacio') }}</label>
                            <input type="date" wire:model="fechaActuacion" class="w-full rounded-md border-gray-300" required>
                            @error('fechaActuacion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('Tipus') }}</label>
                            <select wire:model="tipoactuacions_id" class="w-full rounded-md border-gray-300" required>
                                <option value="">{{ __('Selecciona tipo') }}</option>
                                @foreach ($tiposActuacion as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                            @error('tipoactuacions_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('Descripció') }}</label>
                            <textarea wire:model="descripcion" rows="3" class="w-full rounded-md border-gray-300" required></textarea>
                            @error('descripcion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('Numero musics') }}</label>
                            <input type="number" wire:model="musicos" min="0" class="w-full rounded-md border-gray-300">
                            @error('musicos') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>                       

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('Preu music') }}</label>
                            <input type="number" wire:model="preciomusico"  step="0.01" class="w-full rounded-md border-gray-300">
                            @error('preciomusico') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('Cantitat de cotxes') }}</label>
                            <input type="number" wire:model="coches" min="0" class="w-full rounded-md border-gray-300">
                            @error('coches') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('Preu cotxe') }}</label>
                            <input type="number" wire:model="preciocoche" min="0" step="0.01" class="w-full rounded-md border-gray-300">
                            @error('preciocoche') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('Cantitat de furgones') }}</label>
                            <input type="furgonas" wire:model="furgonas" min="0" class="w-full rounded-md border-gray-300">
                            @error('furgonas') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('Precio furgona') }}</label>
                            <input type="number" wire:model="preciofurgona" min="0" step="0.01" class="w-full rounded-md border-gray-300">
                            @error('preciofurgona') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('Observacions') }}</label>
                            <textarea wire:model="observaciones" rows="2" class="w-full rounded-md border-gray-300"></textarea>
                            @error('observaciones') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('Porcentaje personalizado') }}</label>
                            <input type="number" wire:model="porcentajepersonal" step="0.01" class="w-full rounded-md border-gray-300">
                            @error('porcentajepersonal') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3 md:col-span-2">
                            <label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" wire:model="pagado">{{ __('Pagat') }}</label>
                            <label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" wire:model="aplicaporcentaje">{{ __('Aplicar porcentaje') }}</label>
                            <label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" wire:model="noaplicapago">{{ __('No aplica en los pagos') }}</label>
                            <label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" wire:model="visible">{{ __('Visible') }}</label>
                            <label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" wire:model="oficial">{{ __('Acte Oficial') }}</label>
                            <label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" wire:model="is_draft">{{ __('Borrador') }}</label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <button type="button" wire:click="closeModal" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            {{ __('Cancelar') }}
                        </button>
                        <button type="submit" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                            {{ __('Guardar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <footer class="fixed bottom-0 left-0 z-20 w-full bg-white border-t border-gray-300 shadow dark:bg-gray-800 dark:border-gray-600">
        <div class="mx-2 my-3 flex items-stretch justify-center overflow-hidden rounded-xl border border-slate-300 dark:border-slate-600">
            <button
                type="button"
                wire:click="openCreateModal"
                class="flex-1 flex flex-col items-center justify-center min-w-0 px-3 py-2 border-r border-slate-300 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-900/30 dark:border-slate-600 dark:text-emerald-300 transition"
            >
                <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="text-xs mt-1 font-semibold">{{ __('Nueva actuación') }}</span>
            </button>

            <a
                href="{{ route('contratos.edit', $contrato->id) }}"
                class="flex-1 flex flex-col items-center justify-center min-w-0 px-3 py-2 bg-slate-50 text-slate-700 hover:bg-slate-100 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200 transition"
            >
                <svg width="32px" height="32px" viewBox="0 0 28 28" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path d="M12.5919,3.49635 C13.4146,2.83625 14.5854,2.83625 15.4081,3.49635 L23.1581,9.71468 C23.6903,10.1417 24,10.7872 24,11.4696 L24,22.75 C24,23.9926 22.9926,25 21.75,25 L18.75,25 C17.5074,25 16.5,23.9926 16.5,22.75 L16.5,16.75 C16.5,16.3358 16.1642,16 15.75,16 L12.25,16 C11.8358,16 11.5,16.3358 11.5,16.75 L11.5,22.75 C11.5,23.9926 10.4926,25 9.25,25 L6.25,25 C5.00736,25 4,23.9926 4,22.75 L4,11.4696 C4,10.7872 4.30967,10.1417 4.84191,9.71468 L12.5919,3.49635 Z M14.4694,4.6663 C14.1951,4.44627 13.8049,4.44627 13.5306,4.6663 L5.78064,10.8846 C5.60322,11.027 5.5,11.2421 5.5,11.4696 L5.5,22.75 C5.5,23.1642 5.83579,23.5 6.25,23.5 L9.25,23.5 C9.66421,23.5 10,23.1642 10,22.75 L10,16.75 C10,15.5074 11.0074,14.5 12.25,14.5 L15.75,14.5 C16.9926,14.5 18,15.5074 18,16.75 L18,22.75 C18,23.1642 18.3358,23.5 18.75,23.5 L21.75,23.5 C22.1642,23.5 22.5,23.1642 22.5,22.75 L22.5,11.4696 C22.5,11.2421 22.3968,11.027 22.2194,10.8846 L14.4694,4.6663 Z" />
                </svg>
                <span class="text-xs mt-1 font-semibold">{{ __('Volver al contrato') }}</span>
            </a>
        </div>
    </footer>
</div>
