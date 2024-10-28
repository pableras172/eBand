<div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8 space-y-4">
    
    <x-slot name="header">
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/">{{__('common.dashboard')}}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            @can('admin')
                <x-ui.breadcrumbs.link href="{{ route('payments.index') }}">
                    {{__('Payments')}}</x-ui.breadcrumbs.link
                >
            @endcan            
            @cannot('admin')
                <x-ui.breadcrumbs.link href="{{ route('payments.user', [Auth::user()->id]) }}">
                    {{__('Payments')}}</x-ui.breadcrumbs.link
                >
            @endcannot
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active
                >{{__('Detalles del pago')}}</x-ui.breadcrumbs.link
            >
        </x-ui.breadcrumbs>
    </x-slot>
    
    <x-ui.modal.confirm wire:model="confirmingDeletion">
        <x-slot name="title"> {{ __('Delete') }} </x-slot>

        <x-slot name="content"> {{ __('¿Estás seguro de que quieres eliminar el pago?') }} </x-slot>

        <x-slot name="footer">
            <x-ui.button
                wire:click="$toggle('confirmingDeletion')"
                wire:loading.attr="disabled"
            >
                {{ __('Cancel') }}
            </x-ui.button>

            <x-ui.button.danger
                class="ml-3"
                wire:click="delete({{ $deletingPayment }})"
                wire:loading.attr="disabled"
            >
                {{ __('Delete') }}
            </x-ui.button.danger>
        </x-slot>
    </x-ui.modal.confirm>


    <x-ui.toast timeout=5000 on="saved">{{__('common.pagocreado')}}</x-ui.toast>
    <x-ui.toast timeout=5000 on="confirmed">{{__('Se ha confirmado el pago')}}</x-ui.toast>
    <x-ui.toast timeout=5000 on="notconfirmed">{{__('El pago se ha marcado como pendiente')}}</x-ui.toast>
    <x-ui.toast timeout=5000 color="red" on="errorobservaciones">{{__('No has indicado observaciones')}}</x-ui.toast>

    <div class="overflow-hidden border rounded-lg bg-white">    
        
        <div class="text-right mt-1 p-2">
            @if (!$pendiente)
                <x-pendiente />
            @else
                <x-confirmado />
            @endif
        </div>
        

        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-2">                
                        <x-ui.label for="users_id">{{ __('Nom') }}</x-ui.label>
                        <x-ui.input.select wire:model="form.users_id" name="users_id" id="users_id" class="w-full" readonly disabled>
                            <option value="0">{{__('common.todosusuarios')}}</option>
                            @foreach ($users as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-ui.input.select>
                        <x-ui.input.error for="form.users_id" />
                    </div>

                    <div class="mb-2">     
                        <x-ui.label for="fechaPago">{{ __('Fecha pago') }}</x-ui.label>
                        <x-ui.input type="date" class="w-full  text-right" wire:model="form.fechaPago" name="fechaPago" id="fechaPago" readonly />
                        <x-ui.input.error for="form.fechaPago" />
                    </div>
                </div>
                <div class="w-full">
                    <x-ui.label for="descripcion">{{ __('Descripció') }}</x-ui.label>
                    <x-ui.input.text class="w-full" wire:model="form.descripcion" name="descripcion" id="descripcion"
                        placeholder="{{ __('Descripció') }}" readonly />
                    <x-ui.input.error for="form.descripcion" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-2">
                
                        <x-ui.label for="fechaInicio">{{ __('Data Inici') }}</x-ui.label>
                        <x-ui.input type="date" class="w-full" wire:model="form.fechaInicio" name="fechaInicio" id="fechaInicio" readonly />
                        <x-ui.input.error for="form.fechaInicio" />
                    </div>

                    <div class="mb-2">
                        <x-ui.label for="fechaFin">{{ __('Data de Fi') }}</x-ui.label>
                        <x-ui.input type="date" class="w-full" wire:model="form.fechaFin" name="fechaFin" id="fechaFin" readonly />
                        <x-ui.input.error for="form.fechaFin" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-2">
                        <x-ui.label for="descripcion">{{ __('Porcentaje del usuario') }}</x-ui.label>
                        <x-ui.input.text class="w-full text-right border-blue-500" wire:model="form.porcentaje" name="porcentaje" id="porcentaje"
                            placeholder="{{ __('crud.payments.inputs.descripcion.placeholder') }}" readonly />
                        <x-ui.input.error for="form.porcentaje" />
                    </div>  

                    <div class="mb-2">
                        <x-ui.label for="descripcion">{{ __('Total a pagar') }}</x-ui.label>
                        <x-ui.input.text class="w-full text-right border-red-500" wire:model="form.totalPago" name="totalPago" id="totalPago"
                            placeholder="{{ __('crud.payments.inputs.descripcion.placeholder') }}" readonly />
                        <x-ui.input.error for="form.totalPago" />
                    </div>  
                </div> 

                <div class="w-full">
                    <x-ui.label for="observaciones">{{ __('Observaciones') }}</x-ui.label>
                    <x-ui.input.textarea class="w-full" wire:model="form.observaciones" name="observaciones" id="observaciones"
                        placeholder="{{ __('Observaciones') }}" />
                    <x-ui.input.error for="form.observaciones" />
                </div> 

            </div>            
        </form>
        <div class="flex justify-center mt-1 border-t border-gray-50 p-2 space-x-4">               
            <x-ui.button type="button" class="bg-yellow-600 hover:bg-yellow-700" wire:click="print">
                {{ __('Imprmir') }}
            </x-ui.button>
            @if (!$pendiente)
            <x-ui.button type="button" class="bg-lime-700 hover:bg-lime-800" wire:click="confirm">
                {{ __('Confirmar') }}
            </x-ui.button>
            @else
            <x-ui.button type="button" class="bg-red-700 hover:bg-red-800" wire:click="noConfirmar">
                {{ __('No confirmar') }}
            </x-ui.button>
            @endif
        </div>
    </div>

    <?php /* @can('view-any', App\Models\ListasUser::class) */?>
    <div class="overflow-hidden border rounded-lg bg-white">
        <div class="w-full mb-0">
            <div class="p-2 space-y-3">               

                <livewire:payment.payment-listas-users-detail :payment="$payment" />
                    
            </div>
        </div>
    </div>
    @can('admin')
        <div class="flex justify-center mt-1 border-t border-gray-50 p-2 space-x-4">   
            <x-ui.button type="button" class="bg-red-900 hover:bg-red-700" wire:click="confirmDeletion({{ $payment->id }})">
                {{ __('Delete') }}
            </x-ui.button>
        </div>
    @endcan
</div>
