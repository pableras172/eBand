<div class="max-w-7xl mx-auto space-y-6 px-2 py-4 sm:px-4 lg:px-6 pb-20">
    
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <x-ui.breadcrumbs>
                    <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                    <x-ui.breadcrumbs.separator />
                    <x-ui.breadcrumbs.link active>{{ __('Resums de Liquidacions') }}</x-ui.breadcrumbs.link>
                </x-ui.breadcrumbs>
                <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-white tracking-tight mt-1">
                    {{ __('Resums Generals de Liquidacions') }}
                </h1>
                <p class="text-xs text-slate-400">
                    {{ __('Històric consolidat de tancaments de comptes i pagaments de bolos') }}
                </p>
            </div>
        </div>
    </x-slot>  

    {{-- Buscador y Acciones --}}
    <div class="rounded-2xl border border-slate-800 bg-[#111827] p-4 shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="w-full sm:max-w-md relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input
                    wire:model.live="search"
                    type="text"
                    class="w-full pl-10 pr-4 py-2.5 text-xs bg-[#0B1120] border border-slate-700 rounded-xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="{{ __('Cercar per descripció de resum...') }}"
                />
            </div>

            @can('create', App\Models\Paymentresume::class)
                <a wire:navigate href="{{ route('paymentresumes.create') }}">
                    <button type="button" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-lg shadow-blue-900/30 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>{{ __('Crear nou resum') }}</span>
                    </button>
                </a>
            @endcan
        </div>
    </div>

    {{-- Modal Confirmación Eliminación --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title">
            <span class="text-white font-headline">{{ __('Eliminar resum de liquidacions') }}</span>
        </x-slot>

        <x-slot name="content">
            <p class="text-slate-300 text-sm">
                {{ __('Segur que vols eliminar este resum de liquidacions consolidat?') }}
            </p>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold rounded-xl border border-slate-700 transition"
                wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel·lar') }}
            </button>

            <button type="button" class="ml-3 px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold rounded-xl shadow-md transition"
                wire:click="delete({{ $deletingPaymetresume }})" wire:loading.attr="disabled">
                {{ __('Eliminar') }}
            </button>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- Tabla Resúmenes (Dark Command Center) --}}
    <div class="overflow-hidden rounded-2xl border border-slate-800 bg-[#111827] shadow-xl">
        <table class="min-w-full divide-y divide-slate-800">
            <thead class="bg-slate-900/60">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider cursor-pointer hover:text-white"
                        wire:click="sortBy('descripcion')">
                        {{ __('Descripció') }}
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider cursor-pointer hover:text-white"
                        wire:click="sortBy('user_id')">
                        {{ __('Creat per') }}
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider cursor-pointer hover:text-white"
                        wire:click="sortBy('created_at')">
                        {{ __('Data') }}
                    </th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">
                        {{ __('Accions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/80">
                @forelse ($paymentresumes as $paymetresume)
                    <tr wire:loading.class.delay="opacity-75" class="hover:bg-slate-800/40 transition-colors">
                        <td class="px-4 py-3.5 whitespace-nowrap text-sm font-bold text-white">
                            {{ $paymetresume->descripcion }}
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs text-slate-300">
                            {{ $paymetresume->user?->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs text-slate-400">
                            {{ $paymetresume->created_at ? $paymetresume->created_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a wire:navigate href="{{ route('paymentresumes.edit', $paymetresume) }}"
                                    class="p-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white transition"
                                    title="{{ __('Editar resum') }}">
                                    <x-editar w="16" h="16" />
                                </a>

                                <button type="button" wire:click="confirmDeletion({{ $paymetresume->id }})"
                                    class="p-1.5 rounded-lg bg-slate-800 hover:bg-rose-900/50 text-rose-400 border border-slate-700 transition"
                                    title="{{ __('Eliminar') }}">
                                    <x-delete w="16" h="16" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-xs">
                            {{ __('No s\'han trobat resums de liquidació.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($paymentresumes->hasPages())
            <div class="border-t border-slate-800 px-4 py-3 bg-slate-900/40">
                {{ $paymentresumes->links() }}
            </div>
        @endif
    </div>
</div>
