<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="relative w-full sm:max-w-xs">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input
                wire:model.live="detailListasUsersSearch"
                type="text"
                class="w-full pl-9 pr-3 py-2 text-xs bg-[#0B1120] border border-slate-700 rounded-xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="{{ __('Cercar actuacions pagades...') }}"
            />
        </div>
    </div>

    {{-- Modal Edición Detalle --}}
    <x-ui.modal wire:model="showingModal">
        <div class="overflow-hidden rounded-2xl border border-slate-800 bg-[#111827] text-white">
            <form class="w-full mb-0" wire:submit.prevent="save">
                <div class="p-6 space-y-4">
                    <h3 class="text-base font-bold font-headline text-white border-b border-slate-800 pb-3">
                        {{ __('Ajustar conceptes de la liquidació') }}
                    </h3>

                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 rounded-xl bg-[#0B1120] border border-slate-700/60 cursor-pointer">
                            <input type="checkbox" wire:model="form.coche" name="coche" id="coche"
                                class="rounded bg-slate-800 border-slate-700 text-amber-500 focus:ring-0 h-4 w-4" />
                            <span class="text-xs font-semibold text-slate-200">🚗 {{ __('Cotxe') }}</span>
                        </label>

                        <label class="flex items-center gap-2 p-3 rounded-xl bg-[#0B1120] border border-slate-700/60 cursor-pointer">
                            <input type="checkbox" wire:model="form.pagada" name="pagada" id="pagada"
                                class="rounded bg-slate-800 border-slate-700 text-emerald-500 focus:ring-0 h-4 w-4" />
                            <span class="text-xs font-semibold text-slate-200">✓ {{ __('Pagada') }}</span>
                        </label>

                        <label class="flex items-center gap-2 p-3 rounded-xl bg-[#0B1120] border border-slate-700/60 cursor-pointer">
                            <input type="checkbox" wire:model="form.cuentas" name="cuentas" id="cuentas"
                                class="rounded bg-slate-800 border-slate-700 text-blue-500 focus:ring-0 h-4 w-4" />
                            <span class="text-xs font-semibold text-slate-200">📊 {{ __('Comptabilitzada') }}</span>
                        </label>

                        <label class="flex items-center gap-2 p-3 rounded-xl bg-[#0B1120] border border-slate-700/60 cursor-pointer">
                            <input type="checkbox" wire:model="form.disponible" name="disponible" id="disponible"
                                class="rounded bg-slate-800 border-slate-700 text-green-500 focus:ring-0 h-4 w-4" />
                            <span class="text-xs font-semibold text-slate-200">🎺 {{ __('Disponible') }}</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 border-t border-slate-800 bg-slate-900/60 p-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl shadow-md transition">
                        {{ __('Guardar') }}
                    </button>
                </div>
            </form>
        </div>
    </x-ui.modal>

    {{-- Modal Confirmación Eliminación --}}
    <x-ui.modal.confirm wire:model="confirmingListasUserDeletion">
        <x-slot name="title">
            <span class="text-white font-headline">{{ __('Eliminar registre') }}</span>
        </x-slot>

        <x-slot name="content">
            <p class="text-slate-300 text-sm">
                {{ __('Segur que vols eliminar l\'usuari d\'aquesta liquidació d\'actuació?') }}
            </p>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold rounded-xl border border-slate-700 transition"
                wire:click="$toggle('confirmingListasUserDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel·lar') }}
            </button>

            <button type="button" class="ml-3 px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl shadow-md transition"
                wire:click="deleteListasUser({{ $deletingListasUser }})" wire:loading.attr="disabled">
                {{ __('Eliminar') }}
            </button>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- Tabla de Desglose de Bolos (Dark Command Center) --}}
    <div class="overflow-hidden rounded-2xl border border-slate-800 bg-[#111827] shadow-xl">
        <table class="min-w-full divide-y divide-slate-800">
            <thead class="bg-slate-900/60">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('Data') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('Actuació') }}</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">🚗 {{ __('Cotxe') }}</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">🚐 {{ __('Furgo') }}</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">🎺 {{ __('Bolo') }}</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('Total') }}</th>
                    @can('admin')
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('Opcions') }}</th>
                    @endcan
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/80">
                @forelse ($detailListasUsers as $listasUser)
                    <tr wire:loading.class.delay="opacity-75" class="hover:bg-slate-800/40 transition-colors">
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs text-slate-300">
                            {{ \Carbon\Carbon::parse($listasUser->listas->actuacion->fechaActuacion)->format('d/m/Y') }}
                        </td>                    
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs font-bold text-white">
                            {{ $listasUser->listas->actuacion->descripcion }}
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs text-right font-medium text-amber-400">
                            {{ $listasUser->totalCoche > 0 ? number_format($listasUser->totalCoche, 2) . ' €' : '-' }}
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs text-right font-medium text-blue-400">
                            {{ $listasUser->totalFurgo > 0 ? number_format($listasUser->totalFurgo, 2) . ' €' : '-' }}
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs text-right font-medium text-slate-200">
                            {{ number_format($listasUser->totalActuacion, 2) }} €
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs text-right font-extrabold text-emerald-400">
                            {{ number_format($listasUser->totalActo, 2) }} €
                        </td>                    
                        
                        @can('admin')
                            <td class="px-4 py-3.5 whitespace-nowrap text-center">
                                <button type="button" wire:click="confirmListasUserDeletion({{ $listasUser->id }})"
                                    class="p-1.5 rounded-lg bg-slate-800 hover:bg-rose-900/50 text-rose-400 border border-slate-700 transition"
                                    title="{{ __('Eliminar') }}">
                                    <x-delete w="16" h="16" />
                                </button>
                            </td>
                        @endcan
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-slate-400 text-xs">
                            {{ __('No hi ha actuacions registrades per a aquesta liquidació.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($detailListasUsers->hasPages())
            <div class="border-t border-slate-800 px-4 py-3 bg-slate-900/40">
                {{ $detailListasUsers->links() }}
            </div>
        @endif
    </div>
</div>
