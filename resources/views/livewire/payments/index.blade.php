<div class="mx-auto max-w-7xl space-y-4 px-2 py-3 sm:px-4 lg:px-4">

    <x-slot name="header">
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active>{{ __('Payments') }}</x-ui.breadcrumbs.link>
        </x-ui.breadcrumbs>
        @php
                use Illuminate\Support\Facades\Auth;

                $user = Auth::user();
                $esPadre = $user->hijos()->exists();
                $hijos = $esPadre ? $user->hijos : collect();
                $usuarioActivo = session('usuarioActivo', $user); // ya debes tener esto en algún middleware o lógica previa

            @endphp

        @if ($esPadre)
            <div class="mt-3 flex flex-wrap items-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-900 shadow-sm">
                {{-- Icono --}}
                <x-shield w="32" h="32"/>

                {{-- Texto --}}
                <span>
                    <span class="font-semibold">{{ __('Estàs veient la informació de:') }}</span>
                </span>

                @if (Auth::user()->hijos && Auth::user()->hijos->count() > 0)
                    <form method="GET" id="hijoForm">
                        <select name="hijo_id" class="ml-1 rounded-lg border-amber-300 bg-white px-2 py-1 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400"
                            onchange="window.location.href = '/payments/user/' + this.value + '?hijo_id=' + this.value">

                            <option value="{{ Auth::user()->id }}"
                                {{ Auth::user()->id == $usuarioActivo->id ? 'selected' : '' }}>
                                {{ Auth::user()->name }} ({{ __('Yo') }})
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

    <div class="rounded-2xl border border-slate-200 bg-gradient-to-r from-white to-slate-50 px-3 py-3 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="w-full md:max-w-md">
                <x-ui.input wire:model.live="search" type="text"
                    class="w-full border-slate-300 bg-white/90"
                    placeholder="{{ __('Search') }} {{ __('Actuaciones pagadas') }}..." />
            </div>

            @can('create', App\Models\Payment::class)
                <a wire:navigate href="{{ route('payments.create') }}">
                    <x-ui.button class="w-full bg-lime-700 shadow-sm transition hover:bg-lime-800 md:w-auto">{{ __('Generar pago') }}</x-ui.button>
                </a>
            @endcan
        </div>
    </div>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content">
            {{ __('¿Estas seguro de que quieres eliminar el pago?') }}
            <p class="mt-2 rounded-lg bg-slate-100 px-2 py-1 text-sm font-semibold text-slate-700">{{ $deletingPaymentDescription }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-ui.button wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger class="ml-3" wire:click="delete({{ $deletingPayment }})"
                wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-ui.button.danger>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- Index Table --}}
    <x-ui.container.table class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <x-ui.table>
            <x-slot name="head">
                <x-ui.table.header for-crud wire:click="sortBy('users_id')">{{ __('Nom') }}</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('fechaPago')">{{ __('Fecha pago') }}</x-ui.table.header>
                <x-ui.table.action-header>{{ __('Actions') }}</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($payments as $payment)
                    <x-ui.table.row wire:loading.class.delay="opacity-75"
                        class="transition-colors hover:bg-slate-50 {{ $payment->confirmadausuaroi ? 'bg-emerald-50/70' : 'bg-rose-50/70' }}">
                        <x-ui.table.column for-crud>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-2.5 w-2.5 rounded-full {{ $payment->confirmadausuaroi ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                <span class="font-medium text-slate-800">{{ $payment->user->name }}</span>
                            </div>
                        </x-ui.table.column>
                        <x-ui.table.column for-crud>
                            <span class="rounded-md bg-white px-2 py-1 text-sm font-medium text-slate-700 shadow-sm">
                                {{ \Carbon\Carbon::parse($payment->fechaPago)->format('d/m/Y') }}
                            </span>
                        </x-ui.table.column>
                        <x-ui.table.action-column>
                            <div class="flex items-center justify-center gap-2">
                                @can('update', $payment)
                                    <x-ui.action wire:navigate href="{{ route('payments.edit', $payment) }}">
                                        <x-editar w="18" h="18" />
                                    </x-ui.action>
                                @endcan
                                @can('delete', $payment)
                                    <x-ui.action.danger wire:click="confirmDeletion({{ $payment->id }})">
                                        <x-delete w="18" h="18" />
                                    </x-ui.action.danger>
                                @endcan
                            </div>
                        </x-ui.table.action-column>

                    </x-ui.table.row>
                @empty
                    <x-ui.table.row>
                        <x-ui.table.column colspan="4">
                            <div class="py-6 text-center text-sm font-medium text-slate-500">{{ __('No Results Found.') }}</div>
                        </x-ui.table.column>
                    </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="border-t border-slate-100 px-2 py-2">{{ $payments->links() }}</div>
    </x-ui.container.table>
</div>
