<div class="max-w-7xl mx-auto py-6 sm:px-4 lg:px-4 space-y-2">
    <x-slot name="header">
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/">{{__('common.dashboard')}}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link href="{{ route('configurations.index') }}"
                >{{__('common.configuracion')}}</x-ui.breadcrumbs.link
            >
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active
                >{{__('Editar')}}</x-ui.breadcrumbs.link
            >
        </x-ui.breadcrumbs>
    </x-slot>    
    <x-ui.toast on="saved">{{__('Saved.')}}</x-ui.toast>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-4 space-y-2">
                <div class="w-full">
                    <x-ui.label for="param"
                        >{{__('common.crearconfiguracionnombre')}}</x-ui.label
                    >
                    <x-ui.input.text
                        disabled="true"
                        class="w-full"
                        wire:model="form.param"
                        name="param"
                        id="param"
                        placeholder="{{__('common.crearconfiguracionvalor')}}"
                        min="3"
                        max="15"
                    />
                    <x-ui.input.error for="form.param" />
                </div>

                <div class="w-full">
                    <x-ui.label for="value"
                        >{{__('common.crearconfiguracionvalor')}}</x-ui.label
                    >
                    <x-ui.input.text
                        class="w-full"
                        wire:model="form.value"
                        name="value"
                        id="value"
                        placeholder="{{__('common.crearconfiguracionvalorplaceholder')}}"
                    />
                    <x-ui.input.error for="form.value" />
                </div>
            </div>

            <div class="flex justify-between mt-2 border-t border-gray-50 p-4">
                <div>
                    <!-- Other buttons here -->
                </div>
                <div>
                    <x-ui.button type="submit">{{__('Guardar')}}</x-ui.button>
                </div>
            </div>
        </form>
    </div>
</div>
