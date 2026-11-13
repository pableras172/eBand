<div class="space-y-4">
    {{-- Toasts locales del detalle --}}
    <x-ui.toast timeout=4000 on="listas-user-updated">{{ __('S\'han actualitzat els conceptes i recalculat el pagament.') }}</x-ui.toast>
    <x-ui.toast timeout=4000 on="listas-user-deleted">{{ __('S\'ha eliminat l\'actuació de la liquidació i recalculat el total.') }}</x-ui.toast>
    <x-ui.toast timeout=4000 on="actuacion-added">{{ __('Actuació afegida correctament a la liquidació.') }}</x-ui.toast>
    <x-ui.toast timeout=5000 on="actuacion-prices-updated">{{ __('S\'han actualitzat els preus de l\'actuació i recalculat les liquidacions afectades.') }}</x-ui.toast>

    {{-- Barra de búsqueda y Acción de Añadir (Neo-Bento Claro) --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="relative w-full sm:max-w-xs">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input
                wire:model.live="detailListasUsersSearch"
                type="text"
                class="w-full pl-10 pr-4 py-2 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                placeholder="{{ __('Cercar actuacions pagades...') }}"
            />
        </div>

        <div class="flex items-center gap-2">
            {{-- Indicador de desplazamiento horizontal en móvil --}}
            <div class="sm:hidden flex items-center gap-1 text-[10.5px] font-semibold text-indigo-600 bg-indigo-50/70 border border-indigo-100 px-2 py-1 rounded-xl">
                <svg class="w-3.5 h-3.5 text-indigo-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                <span>{{ __('Desplaça') }}</span>
            </div>

            {{-- Botón Admin: Añadir actuación que faltaba --}}
            @can('admin')
                <button type="button" wire:click="openAddModal"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-2xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold border border-indigo-100 shadow-xs transition active:scale-95">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>{{ __('Afegir actuació') }}</span>
                </button>
            @endcan
        </div>
    </div>

    {{-- Modal Edición Detalle / Suplementos (Neo-Bento Claro) --}}
    <x-ui.modal wire:model="showingModal">
        <div class="overflow-hidden rounded-3xl border border-indigo-50 bg-white text-slate-900 shadow-2xl">
            <form class="w-full mb-0" wire:submit.prevent="save">
                <div class="p-6 space-y-4">
                    <div class="border-b border-indigo-50 pb-3">
                        <h3 class="text-base font-bold font-headline text-slate-900">
                            {{ __('Modificar conceptes i suplements') }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ __('Els imports de la línia i el total de la liquidació es recalcularan automàticament.') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2.5 p-3 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 cursor-pointer hover:bg-indigo-50/50 transition">
                            <input type="checkbox" wire:model="form.coche" name="coche" id="coche"
                                class="rounded-lg bg-white border-indigo-200 text-amber-500 focus:ring-amber-400 h-4 w-4" />
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">🚗 {{ __('Cotxe') }}</span>
                                <span class="text-[10px] text-slate-500 block">{{ __('Plus de desplaçament') }}</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-2.5 p-3 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 cursor-pointer hover:bg-indigo-50/50 transition">
                            <input type="checkbox" wire:model="form.furgona" name="furgona" id="furgona"
                                class="rounded-lg bg-white border-indigo-200 text-blue-500 focus:ring-blue-400 h-4 w-4" />
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">🚐 {{ __('Furgoneta') }}</span>
                                <span class="text-[10px] text-slate-500 block">{{ __('Transport d\'instrumental') }}</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-2.5 p-3 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 cursor-pointer hover:bg-indigo-50/50 transition">
                            <input type="checkbox" wire:model="form.pagada" name="pagada" id="pagada"
                                class="rounded-lg bg-white border-indigo-200 text-emerald-500 focus:ring-emerald-400 h-4 w-4" />
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">✓ {{ __('Pagada') }}</span>
                                <span class="text-[10px] text-slate-500 block">{{ __('Marcada com a liquidada') }}</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-2.5 p-3 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 cursor-pointer hover:bg-indigo-50/50 transition">
                            <input type="checkbox" wire:model="form.disponible" name="disponible" id="disponible"
                                class="rounded-lg bg-white border-indigo-200 text-green-500 focus:ring-green-400 h-4 w-4" />
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">🎺 {{ __('Assistència') }}</span>
                                <span class="text-[10px] text-slate-500 block">{{ __('Assistència confirmada') }}</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 border-t border-indigo-50 bg-[#F5F6FC]/60 p-4">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-2xl transition">
                        {{ __('Cancel·lar') }}
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-2xl shadow-md shadow-indigo-600/20 transition">
                        {{ __('Guardar i recalcular') }}
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>

    {{-- Modal Añadir Actuación que Faltaba --}}
    <x-ui.modal wire:model="showingAddModal">
        <div class="overflow-hidden rounded-3xl border border-indigo-50 bg-white text-slate-900 shadow-2xl">
            <form class="w-full mb-0" wire:submit.prevent="addActuacion">
                <div class="p-6 space-y-4">
                    <div class="border-b border-indigo-50 pb-3">
                        <h3 class="text-base font-bold font-headline text-slate-900">
                            {{ __('Afegir actuació a la liquidació') }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ __('Selecciona l\'actuació que faltava per a incorporar-la amb el seu import i suplements.') }}
                        </p>
                    </div>

                    <div>
                        <label for="selectedActuacionId" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Selecciona l\'actuació') }}
                        </label>
                        <select wire:model="selectedActuacionId" id="selectedActuacionId"
                            class="w-full text-xs bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 p-3 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500">
                            <option value="">-- {{ __('Tria una actuació pendent') }} --</option>
                            @foreach ($availableActuaciones as $act)
                                <option value="{{ $act->id }}">
                                    {{ \Carbon\Carbon::parse($act->fechaActuacion)->format('d/m/Y') }} - {{ $act->descripcion }} (Bolo: {{ number_format($act->preciomusico, 2) }} €)
                                </option>
                            @endforeach
                        </select>
                        @error('selectedActuacionId')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <label class="flex items-center gap-2.5 p-3 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 cursor-pointer hover:bg-indigo-50/50 transition">
                            <input type="checkbox" wire:model="addWithCoche"
                                class="rounded-lg bg-white border-indigo-200 text-amber-500 focus:ring-amber-400 h-4 w-4" />
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">🚗 {{ __('Amb Cotxe') }}</span>
                                <span class="text-[10px] text-slate-500 block">{{ __('Afegir plus vehicle') }}</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-2.5 p-3 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 cursor-pointer hover:bg-indigo-50/50 transition">
                            <input type="checkbox" wire:model="addWithFurgo"
                                class="rounded-lg bg-white border-indigo-200 text-blue-500 focus:ring-blue-400 h-4 w-4" />
                            <div>
                                <span class="text-xs font-bold text-slate-800 block">🚐 {{ __('Amb Furgo') }}</span>
                                <span class="text-[10px] text-slate-500 block">{{ __('Afegir plus furgoneta') }}</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 border-t border-indigo-50 bg-[#F5F6FC]/60 p-4">
                    <button type="button" wire:click="closeAddModal" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-2xl transition">
                        {{ __('Cancel·lar') }}
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-2xl shadow-md shadow-indigo-600/20 transition">
                        {{ __('Incorporar a la liquidació') }}
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>

    {{-- Modal Editar Precios de la Actuación (Actualiza todas las liquidaciones afectadas) --}}
    <x-ui.modal wire:model="showingActuacionPriceModal">
        <div class="overflow-hidden rounded-3xl border border-indigo-50 bg-white text-slate-900 shadow-2xl">
            <form class="w-full mb-0" wire:submit.prevent="saveActuacionPrices">
                <div class="p-6 space-y-4">
                    <div class="border-b border-indigo-50 pb-3">
                        <h3 class="text-base font-bold font-headline text-slate-900">
                            {{ __('Modificar preus de l\'actuació') }}
                        </h3>
                        <p class="text-xs text-slate-700 font-semibold mt-1">
                            {{ $editingActuacionDescripcion }}
                        </p>
                        @if ($editingActuacionPagosCount > 0)
                            <div class="mt-2 p-3 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ __('Esta actuació està inclosa en :count liquidacions de músics. En guardar, s\'actualitzaran automàticament.', ['count' => $editingActuacionPagosCount]) }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label for="editingPrecioMusico" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                {{ __('Preu músic (€)') }}
                            </label>
                            <input type="number" step="0.01" wire:model="editingPrecioMusico" id="editingPrecioMusico"
                                class="w-full text-xs font-bold bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 p-3 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500" />
                            @error('editingPrecioMusico')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="editingPrecioCoche" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                {{ __('Preu cotxe (€)') }}
                            </label>
                            <input type="number" step="0.01" wire:model="editingPrecioCoche" id="editingPrecioCoche"
                                class="w-full text-xs font-bold bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 p-3 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500" />
                            @error('editingPrecioCoche')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="editingPrecioFurgona" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                {{ __('Preu furgoneta (€)') }}
                            </label>
                            <input type="number" step="0.01" wire:model="editingPrecioFurgona" id="editingPrecioFurgona"
                                class="w-full text-xs font-bold bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 p-3 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500" />
                            @error('editingPrecioFurgona')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if ($editingListasUserId)
                        <div class="p-3.5 rounded-2xl bg-indigo-50/50 border border-indigo-100/70 space-y-2">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-600 block">
                                {{ __('Suplements d\'este músic en esta actuació:') }}
                            </span>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center gap-2 p-2.5 rounded-xl bg-white border border-indigo-100 cursor-pointer hover:bg-indigo-50/50 transition">
                                    <input type="checkbox" wire:model="editingMusicoCoche"
                                        class="rounded-md border-indigo-200 text-amber-500 focus:ring-amber-400 h-4 w-4" />
                                    <div>
                                        <span class="text-xs font-bold text-slate-800 block">🚗 {{ __('Cotxe') }}</span>
                                        <span class="text-[10px] text-slate-500 block">{{ __('Aporta vehicle propi') }}</span>
                                    </div>
                                </label>
                                <label class="flex items-center gap-2 p-2.5 rounded-xl bg-white border border-indigo-100 cursor-pointer hover:bg-indigo-50/50 transition">
                                    <input type="checkbox" wire:model="editingMusicoFurgona"
                                        class="rounded-md border-indigo-200 text-blue-500 focus:ring-blue-400 h-4 w-4" />
                                    <div>
                                        <span class="text-xs font-bold text-slate-800 block">🚐 {{ __('Furgoneta') }}</span>
                                        <span class="text-[10px] text-slate-500 block">{{ __('Conduïx furgoneta') }}</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-2 border-t border-indigo-50 bg-[#F5F6FC]/60 p-4">
                    <button type="button" wire:click="closeActuacionPriceModal" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-2xl transition">
                        {{ __('Cancel·lar') }}
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-2xl shadow-md shadow-indigo-600/20 transition">
                        {{ __('Guardar i actualitzar liquidacions') }}
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>

    {{-- Modal Confirmación Eliminación --}}
    <x-ui.modal.confirm wire:model="confirmingListasUserDeletion">
        <x-slot name="title">
            <span class="text-slate-900 font-headline">{{ __('Eliminar de la llista i del pagament') }}</span>
        </x-slot>

        <x-slot name="content">
            <p class="text-slate-600 text-sm">
                {{ __('Segur que vols donar de baixa el músic d\'aquesta actuació? S\'eliminarà de la llista d\'assistència per no haver assistit i es descomptarà de la liquidació.') }}
            </p>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-2xl transition"
                wire:click="$toggle('confirmingListasUserDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel·lar') }}
            </button>

            <button type="button" class="ml-3 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-2xl shadow-sm transition"
                wire:click="deleteListasUser({{ $deletingListasUser }})" wire:loading.attr="disabled">
                {{ __('Eliminar i descomptar') }}
            </button>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- Tabla de Desglose de Actuaciones (Neo-Bento Claro con Scroll Horizontal en Móvil) --}}
    <div class="overflow-hidden rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
        <div class="overflow-x-auto overscroll-x-contain touch-pan-x w-full">
            <table class="min-w-[680px] w-full divide-y divide-indigo-50 text-left">
                <thead class="bg-[#EEF1FA]/60">
                    <tr>
                        <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">{{ __('Data') }}</th>
                        <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">{{ __('Actuació') }}</th>
                        <th class="px-4 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">🚗 {{ __('Cotxe') }}</th>
                        <th class="px-4 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">🚐 {{ __('Furgo') }}</th>
                        <th class="px-4 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">🎺 {{ __('Bolo') }}</th>
                        <th class="px-4 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">{{ __('Total') }}</th>
                        @can('admin')
                            <th class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">{{ __('Accions') }}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50/70">
                    @forelse ($detailListasUsers as $listasUser)
                        <tr wire:loading.class.delay="opacity-75" class="hover:bg-indigo-50/30 transition-colors">
                            <td class="px-4 py-3.5 whitespace-nowrap text-xs text-slate-600">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-xl text-xs font-medium bg-[#F5F6FC] text-slate-700 border border-indigo-100/60">
                                    {{ \Carbon\Carbon::parse($listasUser->listas->actuacion->fechaActuacion)->format('d/m/Y') }}
                                </span>
                            </td>                    
                            <td class="px-4 py-3.5 text-xs font-bold text-slate-900 min-w-[200px]">
                                {{ $listasUser->listas->actuacion->descripcion }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap text-xs text-right font-semibold text-amber-700">
                                {{ $listasUser->coche ? number_format($listasUser->totalCoche, 2, ',', '.') . ' €' : '-' }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap text-xs text-right font-semibold text-blue-700">
                                {{ $listasUser->furgona ? number_format($listasUser->totalFurgo, 2, ',', '.') . ' €' : '-' }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap text-xs text-right font-medium text-slate-700">
                                {{ number_format($listasUser->totalActuacion, 2, ',', '.') }} €
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap text-xs text-right font-black text-emerald-600">
                                {{ number_format($listasUser->totalActo, 2, ',', '.') }} €
                            </td>                    
                            
                            @can('admin')
                                <td class="px-4 py-3.5 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- Botón Editar Precios de la Actuación (Actualiza liquidaciones) --}}
                                        <button type="button" wire:click="openActuacionPriceModal({{ $listasUser->listas->actuacion->id }}, {{ $listasUser->id }})"
                                            class="p-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/60 transition active:scale-95"
                                            title="{{ __('Editar preus de l\'actuació i actualitzar liquidacions') }}">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                        </button>

                                        {{-- Botón Editar Suplementos (Cotxe, Furgo) --}}
                                        <button type="button" wire:click="editListasUser({{ $listasUser->id }})"
                                            class="p-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-100 transition active:scale-95"
                                            title="{{ __('Editar suplements (cotxe, furgo)') }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>

                                        {{-- Botón Eliminar de lista y pago --}}
                                        <button type="button" wire:click="confirmListasUserDeletion({{ $listasUser->id }})"
                                            class="p-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-100 transition active:scale-95"
                                            title="{{ __('Donar de baixa de l\'actuació i descomptar') }}">
                                            <x-delete w="14" h="14" />
                                        </button>
                                    </div>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-500 text-xs">
                                <p class="font-bold text-slate-800 text-sm">{{ __('No hi ha actuacions registrades') }}</p>
                                <p class="text-xs mt-0.5">{{ __('Aquesta liquidació no compta amb línies de desglossament associades.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($detailListasUsers->hasPages())
            <div class="border-t border-indigo-50 px-4 py-3 bg-[#F5F6FC]/60">
                {{ $detailListasUsers->links() }}
            </div>
        @endif
    </div>
</div>
