<div>
    <div class="flex justify-between align-top py-4 ml-1">
        <x-ui.input
            wire:model.live="detailListasUsersSearch"
            type="text"
            placeholder="{{ __('Search') }} {{ __('Actuaciones pagadas') }}..."
        />
    </div>

    {{-- Modal --}}
    <x-ui.modal wire:model="showingModal">
        <div class="overflow-hidden border rounded-lg bg-white">
            <form class="w-full mb-0" wire:submit.prevent="save">
                <div class="p-6 space-y-3">
                    <div class="w-full">
                        <x-ui.input.checkbox class=""
                            wire:model="form.coche"
                            name="coche"
                            id="coche"/>
                        <x-ui.label for="coche">{{ __('Coche')}}</x-ui.label>
                        <x-ui.input.error for="form.coche" />
                    </div>

                    <div class="w-full">
                        <x-ui.input.checkbox
                            class=""
                            wire:model="form.pagada"
                            name="pagada"
                            id="pagada"
                        />
                        <x-ui.label for="pagada"
                            >{{ __('Pagada')
                            }}</x-ui.label
                        >
                        <x-ui.input.error for="form.pagada" />
                    </div>

                    <div class="w-full">
                        <x-ui.input.checkbox
                            class=""
                            wire:model="form.cuentas"
                            name="cuentas"
                            id="cuentas"
                        />
                        <x-ui.label for="cuentas"
                            >{{ __('crud.listasUsers.inputs.cuentas.label')
                            }}</x-ui.label
                        >
                        <x-ui.input.error for="form.cuentas" />
                    </div>

                    <div class="w-full">
                        <x-ui.input.checkbox
                            class=""
                            wire:model="form.disponible"
                            name="disponible"
                            id="disponible"
                        />
                        <x-ui.label for="disponible"
                            >{{ __('crud.listasUsers.inputs.disponible.label')
                            }}</x-ui.label
                        >
                        <x-ui.input.error for="form.disponible" />
                    </div>
                </div>

                <div
                    class="flex justify-between mt-4 border-t border-gray-50 bg-gray-50 p-4"
                >
                    <div>
                        <!-- Other buttons here -->
                    </div>
                    <div>
                        <x-ui.button type="submit">{{ __('Save') }}</x-ui.button>
                    </div>
                </div>
            </form>
        </div>
    </x-ui.modal>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingListasUserDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('¿Seguro que quieres eliminar al usuario de la actuación') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button
                wire:click="$toggle('confirmingListasUserDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger
                class="ml-3"
                wire:click="deleteListasUser({{ $deletingListasUser }})"
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
                <x-ui.table.header for-detailCrud>{{ __('Fecha Actuación') }}</x-ui.table.header>
                <x-ui.table.header for-detailCrud>{{ __('Nombre Actuación') }}</x-ui.table.header>
                <x-ui.table.header for-detailCrud>{{ __('Coche') }}</x-ui.table.header>
                <x-ui.table.header for-detailCrud>{{ __('Acto') }}</x-ui.table.header>
                <x-ui.table.header for-detailCrud>{{ __('Total') }}</x-ui.table.header>
                @can('admin')
                <x-ui.table.action-header>{{ __('Opciones') }}</x-ui.table.action-header>
                @endcan
            </x-slot>

            <x-slot name="body">
                @forelse ($detailListasUsers as $listasUser)
                <x-ui.table.row wire:loading.class.delay="opacity-75">
                    <x-ui.table.column for-detailCrud>
                        {{ \Carbon\Carbon::parse($listasUser->listas->actuacion->fechaActuacion)->format('d/m/Y') }}
                    </x-ui.table.column>                    
                    <x-ui.table.column for-detailCrud>{{ $listasUser->listas->actuacion->descripcion }}</x-ui.table.column>
                    <x-ui.table.column for-detailCrud>{{ $listasUser->totalCoche }}</x-ui.table.column>
                    <x-ui.table.column for-detailCrud>{{ $listasUser->totalActuacion }}</x-ui.table.column>
                    <x-ui.table.column for-detailCrud>{{ $listasUser->totalActo }}</x-ui.table.column>                    
                    
                    @can('admin')
                    <x-ui.table.action-column>                        
                       
                            <x-ui.action.danger wire:click="confirmListasUserDeletion({{ $listasUser->id }})">{{ __('Delete') }}</x-ui.action.danger>
                        
                    </x-ui.table.action-column>
                    @endcan
                </x-ui.table.row>
                @empty
                <x-ui.table.row>
                    <x-ui.table.column colspan="6">{{ __('No hay actuaciones') }} </x-ui.table.column>
                </x-ui.table.row>
                @endforelse
            </x-slot>
        </x-ui.table>

        <div class="mt-2">{{ $detailListasUsers->links() }}</div>
    </x-ui.container.table>
</div>
