<div class="max-w-7xl mx-auto py-2 sm:px-4 lg:px-4 space-y-2">
    
    <x-slot name="header">
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/">{{__('common.dashboard')}}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active
                >{{__('Resums')}}</x-ui.breadcrumbs.link
            >
        </x-ui.breadcrumbs>
    </x-slot>  

    <div class="flex justify-between align-top py-2 ml-2">
        <x-ui.input
            wire:model.live="search"
            type="text"
            placeholder="{{ __('Search') }} {{ __('Actuaciones pagadas') }}..."
        />
   </div>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('Are you sure') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button
                wire:click="$toggle('confirmingDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger
                class="ml-3"
                wire:click="delete({{ $deletingPaymetresume }})"
                wire:loading.attr="disabled"
            >
                {{ __('Delete') }}
            </x-ui.button.danger>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- Index Table --}}
    <x-ui.container.table>
        <x-ui.table>
            <x-slot name="head">
                <x-ui.table.header for-crud wire:click="sortBy('descripcion')" 
                    >{{ __('Descripció') }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('user_id')" 
                    >{{ __('Creador') }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('created_at')" 
                    >{{ __('Fecha pago') }}</x-ui.table.header
                >
                <x-ui.table.action-header>{{ __('Actions') }}</x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($paymentresumes as $paymetresume)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-crud
                        >{{ $paymetresume->descripcion }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $paymetresume->user->name }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $paymetresume->created_at }}</x-ui.table.column
                    >
                    <x-ui.table.action-column>
                        <div class="flex space-x-2">
                        <x-ui.action
                            wire:navigate
                            href="{{ route('paymentresumes.edit', $paymetresume) }}"
                            ><x-editar w="18" h="18" /></x-ui.action
                        >
                       
                        <x-ui.action.danger
                            wire:click="confirmDeletion({{ $paymetresume->id }})"
                            ><x-delete w="18" h="18" />                                </x-ui.action.danger
                        >
                        </div>
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="5"
                        >{{ __('No Results Found.') }}</x-ui.table.column
                    >
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $paymentresumes->links() }}</div>
    </x-ui.container.table>
</div>
