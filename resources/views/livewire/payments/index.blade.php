<div class="max-w-7xl mx-auto py-2 sm:px-4 lg:px-4 space-y-2">

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
            <div class="bg-yellow-100 text-gray-800 text-sm p-2 mb-1 rounded flex items-center gap-2">
                {{-- Icono --}}
                <x-shield w="32" h="32"/>

                {{-- Texto --}}
                <span>
                    {{ __('Estàs veient la informació de:') }}
                </span>

                @if (Auth::user()->hijos && Auth::user()->hijos->count() > 0)
                    <form method="GET" id="hijoForm">
                        <select name="hijo_id" class="ml-2 border-gray-300 rounded"
                            onchange="window.location.href = '/payments/user/' + this.value + '?hijo_id=' + this.value">

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

    <div class="flex justify-between align-top py-1 px-2">
        <x-ui.input wire:model.live="search" type="text"
            placeholder="{{ __('Search') }} {{ __('Actuaciones pagadas') }}..." />

           
        @can('create', App\Models\Payment::class)
            <a wire:navigate href="{{ route('payments.create') }}">
                <x-ui.button class="bg-lime-700 hover:bg-lime-800">{{ __('Generar pago') }}</x-ui.button>
            </a>
        @endcan
    </div>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content">
            {{ __('¿Estas seguro de que quieres eliminar el pago?') }}
            <p class="text-sm font-bold">{{ $deletingPaymentDescription }}</p>
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
    <x-ui.container.table>
        <x-ui.table>
            <x-slot name="head">
                <x-ui.table.header for-crud wire:click="sortBy('users_id')">{{ __('Nom') }}</x-ui.table.header>
                <x-ui.table.header for-crud wire:click="sortBy('fechaPago')">{{ __('Fecha pago') }}</x-ui.table.header>
                <x-ui.table.action-header>{{ __('Actions') }}</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($payments as $payment)
                    <x-ui.table.row wire:loading.class.delay="opacity-75"
                        class="{{ $payment->confirmadausuaroi ? 'bg-green-100' : 'bg-red-100' }}">
                        <x-ui.table.column for-crud>{{ $payment->user->name }}</x-ui.table.column>
                        <x-ui.table.column for-crud>
                            {{ \Carbon\Carbon::parse($payment->fechaPago)->format('d/m/Y') }}</x-ui.table.column>
                        <x-ui.table.action-column>
                            <div class="flex justify-center items-center space-x-2">
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
                        <x-ui.table.column colspan="4">{{ __('No Results Found.') }}</x-ui.table.column>
                    </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $payments->links() }}</div>
    </x-ui.container.table>
</div>
