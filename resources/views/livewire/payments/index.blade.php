<div class="mx-auto max-w-7xl space-y-6 px-2 py-4 sm:px-4 lg:px-6 pb-28">

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Liquidacions i Pagaments') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('Liquidacions i Repartiment de Bolos') }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Control econòmic d\'actuacions, dietes i desplaçaments') }}
                    </p>
                </div>
            </div>
        </div>

        @php
            use Illuminate\Support\Facades\Auth;

            $user = Auth::user();
            $esPadre = $user->hijos()->exists();
            $hijos = $esPadre ? $user->hijos : collect();
            $usuarioActivo = $this->user ?? session('usuarioActivo', $user);
        @endphp

        {{-- Selector de Menor para Familias / Padres --}}
        @if ($esPadre)
            <div class="mt-4 flex flex-wrap items-center gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-3.5 text-xs text-amber-900 shadow-xs">
                <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center text-amber-700 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>

                <span class="font-bold">
                    {{ __('Estàs consultant la liquidació de:') }}
                </span>

                @if (Auth::user()->hijos && Auth::user()->hijos->count() > 0)
                    <form method="GET" id="hijoForm" class="inline-flex">
                        <select name="hijo_id" class="rounded-xl border border-amber-300 bg-white text-amber-900 px-3 py-1.5 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500"
                            onchange="window.location.href = '/payments/user/' + this.value + '?hijo_id=' + this.value">
                            <option value="{{ Auth::user()->id }}"
                                {{ Auth::user()->id == $usuarioActivo->id ? 'selected' : '' }}>
                                {{ Auth::user()->name }} ({{ __('Tu') }})
                            </option>
                            @foreach (Auth::user()->hijos as $hijo)
                                <option value="{{ $hijo->id }}"
                                    {{ $hijo->id == $usuarioActivo->id ? 'selected' : '' }}>
                                    {{ $hijo->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>
        @endif
        
    </x-slot>

    {{-- BARRA DE ACCIÓN Y BÚSQUEDA (Neo-Bento Violet) --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="w-full md:max-w-md relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input wire:model.live="search" type="text"
                    class="w-full pl-10 pr-4 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    placeholder="{{ __('Cercar liquidació o actuació pagada...') }}" />
            </div>

            @can('create', App\Models\Payment::class)
                <a wire:navigate href="{{ route('payments.create') }}">
                    <button type="button" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>{{ __('Generar nou pagament') }}</span>
                    </button>
                </a>
            @endcan
        </div>
    </div>

    {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title">
            <span class="text-slate-900 font-headline">{{ __('Eliminar registre de pagament') }}</span>
        </x-slot>

        <x-slot name="content">
            <p class="text-slate-600 text-sm">
                {{ __('Estàs segur que vols eliminar este registre de liquidació?') }}
            </p>
            <p class="mt-2 rounded-2xl bg-[#F5F6FC] border border-indigo-100 px-3 py-2 text-xs font-bold text-rose-600">{{ $deletingPaymentDescription }}</p>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-2xl transition"
                wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel·lar') }}
            </button>

            <button type="button" class="ml-3 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-2xl shadow-sm transition"
                wire:click="delete({{ $deletingPayment }})" wire:loading.attr="disabled">
                {{ __('Eliminar') }}
            </button>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- TABLA DE PAGOS Y LIQUIDACIONES (Neo-Bento Violet) --}}
    <div class="overflow-hidden rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
        <table class="min-w-full divide-y divide-indigo-50">
            <thead class="bg-[#EEF1FA]/60">
                <tr>
                    <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:text-indigo-600"
                        wire:click="sortBy('users_id')">
                        {{ __('Músic') }}
                    </th>
                    <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider cursor-pointer hover:text-indigo-600"
                        wire:click="sortBy('fechaPago')">
                        {{ __('Data Pagament') }}
                    </th>
                    <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                        {{ __('Estat') }}
                    </th>
                    <th class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                        {{ __('Accions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-indigo-50/70">
                @forelse ($payments as $payment)
                    <tr wire:loading.class.delay="opacity-75"
                        class="hover:bg-indigo-50/30 transition-colors {{ $payment->confirmadausuaroi ? 'bg-emerald-50/20' : 'bg-rose-50/20' }}">
                        
                        {{-- Músico --}}
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            <div class="flex items-center gap-2.5">
                                <span class="inline-flex h-2.5 w-2.5 rounded-full {{ $payment->confirmadausuaroi ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                <span class="font-bold text-sm text-slate-900">{{ $payment->user->name }}</span>
                            </div>
                        </td>

                        {{-- Fecha de Pago --}}
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-semibold bg-[#F5F6FC] text-slate-700 border border-indigo-100">
                                {{ \Carbon\Carbon::parse($payment->fechaPago)->format('d/m/Y') }}
                            </span>
                        </td>

                        {{-- Estado Confirmación --}}
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            @if ($payment->confirmadausuaroi)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    ✓ {{ __('Liquidat') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    ⏳ {{ __('Pendent de confirmació') }}
                                </span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-4 py-3.5 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                @can('update', $payment)
                                    <a wire:navigate href="{{ route('payments.edit', $payment) }}"
                                        class="p-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-100 transition"
                                        title="{{ __('Editar liquidació') }}">
                                        <x-editar w="16" h="16" />
                                    </a>
                                @endcan
                                @can('delete', $payment)
                                    <button type="button" wire:click="confirmDeletion({{ $payment->id }})"
                                        class="p-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-100 transition"
                                        title="{{ __('Eliminar') }}">
                                        <x-delete w="16" h="16" />
                                    </button>
                                @endcan
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            <p class="font-bold text-slate-800 text-base">{{ __('No s\'han trobat liquidacions') }}</p>
                            <p class="text-xs mt-1">{{ __('No hi ha registres de pagament que coincidisquen amb la cerca.') }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($payments->hasPages())
            <div class="border-t border-indigo-50 px-4 py-3 bg-[#F5F6FC]/60">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
