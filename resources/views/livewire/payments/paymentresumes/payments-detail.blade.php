<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 ml-2 mr-2 space-y-2 sm:space-y-0">
        <x-ui.input
            wire:model.live="detailPaymentsSearch"
            type="text"
            placeholder="{{ __('Search') }}"
            class="w-full sm:w-auto"
        />
    </div>

    {{-- Modal --}}
    <x-ui.modal wire:model="showingModal">
        <div class="overflow-hidden border rounded-lg bg-white">
            <form class="w-full mb-0" wire:submit.prevent="save">
                <div class="p-6 space-y-3">
                    <div class="w-full">
                        <x-ui.label for="fechaPago">{{ __('Fecha pago') }}</x-ui.label>
                        <x-ui.input.date-time
                            class="w-full"
                            wire:model="form.fechaPago"
                            name="fechaPago"
                            id="fechaPago"
                        />
                        <x-ui.input.error for="form.fechaPago" />
                    </div>

                    <div class="w-full">
                        <x-ui.label for="descripcion">{{ __('Descripció') }}</x-ui.label>
                        <x-ui.input.text
                            class="w-full"
                            wire:model="form.descripcion"
                            name="descripcion"
                            id="descripcion"
                            placeholder="{{ __('crud.payments.inputs.descripcion.placeholder') }}"
                        />
                        <x-ui.input.error for="form.descripcion" />
                    </div>

                    <div class="w-full">
                        <x-ui.label for="fechaInicio">{{ __('crud.payments.inputs.fechaInicio.label') }}</x-ui.label>
                        <x-ui.input.date-time
                            class="w-full"
                            wire:model="form.fechaInicio"
                            name="fechaInicio"
                            id="fechaInicio"
                        />
                        <x-ui.input.error for="form.fechaInicio" />
                    </div>

                    <div class="w-full">
                        <x-ui.label for="fechaFin">{{ __('crud.payments.inputs.fechaFin.label') }}</x-ui.label>
                        <x-ui.input.date-time
                            class="w-full"
                            wire:model="form.fechaFin"
                            name="fechaFin"
                            id="fechaFin"
                        />
                        <x-ui.input.error for="form.fechaFin" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between mt-4 border-t border-gray-50 bg-gray-50 p-4">
                    <div class="mb-2 sm:mb-0">
                        <!-- Other buttons here -->
                    </div>
                    <div>
                        <x-ui.button type="submit">Save</x-ui.button>
                    </div>
                </div>
            </form>
        </div>
    </x-ui.modal>

    {{-- Delete Modal --}}
    <x-ui.modal.confirm wire:model="confirmingPaymentDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('Are you sure?') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button
                wire:click="$toggle('confirmingPaymentDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger
                class="ml-3"
                wire:click="deletePayment({{ $deletingPayment }})"
                wire:loading.attr="disabled"
            >
                {{ __('Delete') }}
            </x-ui.button.danger>
        </x-slot>
    </x-ui.modal.confirm>

    {{-- Index Table --}}
    <div class="overflow-x-auto">
        <x-ui.container.table>
            <x-ui.table>
                <x-slot name="head">
                    <x-ui.table.header for-detailCrud wire:click="sortBy('descripcion')">
                        {{ __('Descripció') }}
                    </x-ui.table.header>
                    <x-ui.table.action-header>{{ __('Actions') }}</x-ui.table.action-header>
                </x-slot>

                <x-slot name="body">
                    @forelse ($detailPayments as $payment)
                    <x-ui.table.row wire:loading.class.delay="opacity-75">
                        <x-ui.table.column for-detailCrud>
                            {{ $payment->descripcion }}
                        </x-ui.table.column>
                        <x-ui.table.action-column>
                            <div class="flex space-x-2">
                                @can('update', $payment)
                                <x-ui.action href="{{ route('payments.edit', $payment) }}">
                                    <x-editar w="18" h="18" />                                
                                </x-ui.action>
                                @endcan
                                @can('delete', $payment)
                                <x-ui.action.danger wire:click="confirmPaymentDeletion({{ $payment->id }})">
                                    <x-delete w="18" h="18" />      
                                </x-ui.action.danger>
                                @endcan
                            </div>
                        </x-ui.table.action-column>
                    </x-ui.table.row>
                    @empty
                    <x-ui.table.row>
                        <x-ui.table.column colspan="5">
                            {{ __('No hay pagos') }}
                        </x-ui.table.column>
                    </x-ui.table.row>
                    @endforelse
                </x-slot>
            </x-ui.table>

            <div class="mt-2 mb-2">{{ $detailPayments->links() }}</div>
        </x-ui.container.table>
    </div>
</div>
