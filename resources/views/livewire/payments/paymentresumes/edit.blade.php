<div class="max-w-7xl mx-auto py-2 sm:px-6 lg:px-8 space-y-4">
    
    <x-slot name="header">
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/">{{__('common.dashboard')}}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link href="{{ route('paymentresumes.index') }}"
                >{{__('Resums')}}</x-ui.breadcrumbs.link
            >
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active
                >{{$paymetresume->descripcion}}</x-ui.breadcrumbs.link
            >
        </x-ui.breadcrumbs>
    </x-slot>  

    <x-ui.toast on="saved"> Paymetresume saved successfully. </x-ui.toast>
    <x-ui.toast timeout=5000 on="email-sent">{{__('Email enviado correctamente')}}</x-ui.toast>
    <x-ui.toast timeout=5000 color="red" on="email-error">{{__('Error al enviar el email')}}</x-ui.toast>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-4 space-y-2">
                <div class="w-full">
                    <x-ui.label for="descripcion"
                        >{{ __('Descripció') }}</x-ui.label
                    >
                    <x-ui.input.text readonly
                        class="w-full"
                        wire:model="form.descripcion"
                        name="descripcion"
                        id="descripcion"
                        placeholder="{{ __('crud.paymentresumes.inputs.descripcion.placeholder') }}"
                    />
                    <x-ui.input.error for="form.descripcion" />
                </div>

                <div class="w-full">
                    <x-ui.label for="user_id"
                        >{{ __('Creador') }}</x-ui.label
                    >
                    <x-ui.input.select readonly disabled
                        wire:model="form.user_id"
                        name="user_id"
                        id="user_id"
                        class="w-full"
                    >
                        <option value="">Select data</option>
                        @foreach ($users as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-ui.input.select>
                    <x-ui.input.error for="form.user_id" />
                </div>

                <div class="w-full">
                    <x-ui.label for="created_at"
                        >{{ __('Fecha pago') }}<</x-ui.label
                    >
                    <x-ui.input.date-time readonly
                        class="w-full"
                        wire:model="form.created_at"
                        name="created_at"
                        id="created_at"
                    />
                    <x-ui.input.error for="form.created_at" />
                </div>                
            </div>

            <div class="flex justify-center mt-1 border-t border-gray-50 p-2">
                
                <div>
                    <x-ui.button type="button" class="bg-yellow-600 hover:bg-yellow-700" wire:click="print">
                        {{ __('Enviar Email') }}
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="overflow-hidden border rounded-lg bg-white">
        <div class="w-full mb-0">
            <div class="p-2space-y-3">
                <livewire:paymentresume.paymentresume-payments-detail
                    :paymetresume="$paymetresume"
                />
            </div>
        </div>
    </div>    
</div>
