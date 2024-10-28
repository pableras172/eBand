<div class="max-w-7xl mx-auto py-4 sm:px-2 lg:px-4 space-y-2">
    <x-slot name="header">
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/">{{__('common.dashboard')}}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active
                >{{__('common.configuracion')}}</x-ui.breadcrumbs.link
            >
        </x-ui.breadcrumbs>
    </x-slot>    

    <div class="flex justify-between align-top py-4 ml-2">
        <x-ui.input
            wire:model.live="search"
            type="text"
            placeholder="{{ __('Search') }}..."
        />

        <?php 
        /*
        @can('create', App\Models\Configuration::class)
        <a wire:navigate href="{{ route('configurations.create') }}">
            <x-ui.button>{{ __('New') }}</x-ui.button>
        </a>
        @endcan
        */
        ?>
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
                wire:click="delete({{ $deletingConfiguration }})"
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
                <x-ui.table.header for-crud wire:click="sortBy('param')"
                    >{{ __('common.crearconfiguracionnombre')
                    }}</x-ui.table.header
                >
                <x-ui.table.header for-crud wire:click="sortBy('value')"
                    >{{ __('common.crearconfiguracionvalor')
                    }}</x-ui.table.header
                >
                <x-ui.table.action-header></x-ui.table.action-header>
            </x-slot>

            <x-slot name="body">
                @forelse ($configurations as $configuration)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-crud
                        >{{ $configuration->param }}</x-ui.table.column
                    >
                    <x-ui.table.column for-crud
                        >{{ $configuration->value }}</x-ui.table.column
                    >
                    <x-ui.table.action-column>
                        @can('update', $configuration)
                        <x-ui.action
                            wire:navigate
                            href="{{ route('configurations.edit', $configuration) }}"
                            >{{ __('Edit')
                        }}</x-ui.action
                        >
                        @endcan @can('delete', $configuration)
                        <x-ui.action.danger
                            wire:click="confirmDeletion({{ $configuration->id }})"
                            >{{ __('Delete')
                        }}</x-ui.action.danger
                        >
                        @endcan
                    </x-ui.table.action-column>
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="3"
                        >{{ __('No Results Found.') }}</x-ui.table.column
                    >
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $configurations->links() }}</div>
    </x-ui.container.table>
</div>
