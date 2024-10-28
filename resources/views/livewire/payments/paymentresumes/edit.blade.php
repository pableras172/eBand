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
                        <svg width="24px" height="24x" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M192 234.666667h640v64H192z" fill="#424242"></path><path d="M85.333333 533.333333h853.333334v-149.333333c0-46.933333-38.4-85.333333-85.333334-85.333333H170.666667c-46.933333 0-85.333333 38.4-85.333334 85.333333v149.333333z" fill="#616161"></path><path d="M170.666667 768h682.666666c46.933333 0 85.333333-38.4 85.333334-85.333333v-170.666667H85.333333v170.666667c0 46.933333 38.4 85.333333 85.333334 85.333333z" fill="#424242"></path><path d="M853.333333 384m-21.333333 0a21.333333 21.333333 0 1 0 42.666667 0 21.333333 21.333333 0 1 0-42.666667 0Z" fill="#00E676"></path><path d="M234.666667 85.333333h554.666666v213.333334H234.666667z" fill="#f2b54a"></path><path d="M800 661.333333h-576c-17.066667 0-32-14.933333-32-32s14.933333-32 32-32h576c17.066667 0 32 14.933333 32 32s-14.933333 32-32 32z" fill="#242424"></path><path d="M234.666667 661.333333h554.666666v234.666667H234.666667z" fill="#f2b54a"></path><path d="M234.666667 618.666667h554.666666v42.666666H234.666667z" fill="#c79e48"></path><path d="M341.333333 704h362.666667v42.666667H341.333333zM341.333333 789.333333h277.333334v42.666667H341.333333z" fill="#11406e"></path></g></svg>
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
