<div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8 space-y-6">
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl shadow-md">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $item->nombre }}</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-0.5">{{ __('Editar Item de Inventario') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Resumen del item -->
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="bg-gradient-to-br from-gray-500 to-gray-700 p-2 rounded-lg">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Información actual') }}</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 dark:divide-gray-700">
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Año') }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $item->year }}</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Creado') }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $item->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Valor Total') }}</p>
                    <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">€{{ number_format($item->valor_total, 2, ',', '.') }}</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ __('Valor Residual') }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">€{{ number_format($item->valor_residual, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Formulario de edición -->
        <form wire:submit.prevent="save" class="space-y-6">

            <!-- Sección: Identificación -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-2 rounded-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Identificación') }}</h2>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Categoría -->
                    <div>
                        <label for="inventory_category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Categoría') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="inventory_category_id" wire:model="inventory_category_id"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">{{ __('Selecciona una categoría') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nombre }}</option>
                            @endforeach
                        </select>
                        @error('inventory_category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Nombre') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nombre" wire:model="nombre"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Estado') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="estado" wire:model="estado"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="nuevo">{{ __('Nuevo') }}</option>
                            <option value="usado">{{ __('Usado') }}</option>
                            <option value="desperfectos">{{ __('Con desperfectos') }}</option>
                            <option value="dañado">{{ __('Dañado') }}</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección: Datos económicos -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-2 rounded-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Datos económicos') }}</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Cantidad -->
                        <div>
                            <label for="cantidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Cantidad') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="cantidad" wire:model="cantidad" min="1"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('cantidad')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Valor Unitario -->
                        <div>
                            <label for="valor_unitario" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Valor Unitario (€)') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="valor_unitario" wire:model="valor_unitario" min="0" step="0.01"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('valor_unitario')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Tasa de Depreciación -->
                        <div>
                            <label for="depreciation_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Depreciación Anual (%)') }}
                            </label>
                            <input type="number" id="depreciation_rate" wire:model="depreciation_rate" min="0" max="100" step="0.01"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('depreciation_rate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Compra -->
                        <div>
                            <label for="purchase_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Fecha de Compra') }}
                            </label>
                            <input type="date" id="purchase_date" wire:model="purchase_date"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('purchase_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección: Responsables y Observaciones -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Responsables -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-2 rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Responsables') }}</h2>
                    </div>
                    <div class="p-6">
                        <select id="responsables" wire:model="responsables" multiple
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            size="{{ min(count($availableUsers), 8) }}">
                            @foreach ($availableUsers as $userId => $userName)
                                <option value="{{ $userId }}">{{ $userName }}</option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">{{ __('Mantén Ctrl / Cmd para seleccionar varios') }}</p>
                        @error('responsables')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="bg-gradient-to-br from-yellow-400 to-orange-500 p-2 rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('Observaciones') }}</h2>
                    </div>
                    <div class="p-6">
                        <textarea id="observaciones" wire:model="observaciones" rows="6"
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 resize-none"
                            placeholder="{{ __('Añade notas u observaciones sobre este item...') }}"></textarea>
                        @error('observaciones')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-wrap items-center justify-between gap-3 pt-4">
                <div class="flex items-center gap-2">
                    <a href="{{ route('inventory.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 border border-slate-300 rounded-2xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('Cancel·lar') }}
                    </a>

                    <button type="button" wire:click="confirmDelete"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 text-xs font-bold shadow-xs transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>{{ __('Eliminar material') }}</span>
                    </button>
                </div>

                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Desar canvis') }}
                </button>
            </div>

        </form>
    </div>

    {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
    <x-dialog-modal wire:model.live="confirmingDeletion">
        <x-slot name="title">
            <div class="flex items-center gap-2 text-rose-600 font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span>{{ __('Eliminar material de l\'inventari') }}</span>
            </div>
        </x-slot>

        <x-slot name="content">
            <p class="text-sm text-slate-600">
                {{ __('Estàs segur que vols eliminar aquest element de l\'inventari? S\'eliminaran també els registres de moviments i assignacions vinculades. Aquesta acció no es pot desfer.') }}
            </p>
        </x-slot>

        <x-slot name="footer">
            <div class="flex items-center justify-end gap-3">
                <x-secondary-button wire:click="cancelDelete">
                    {{ __('Cancel·lar') }}
                </x-secondary-button>

                <x-danger-button wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Eliminar definitivament') }}
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
