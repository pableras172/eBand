<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/">{{__('common.dashboard')}}</x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link href="{{ route('configurations.index') }}">
            {{__('common.configuracion')}}
        </x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active>
            {{__('common.crearconfiguracion')}}
            </x-ui.breadcrumbs.link>
    </x-ui.breadcrumbs>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>{{__('common.crearconfiguracion')}}</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="param"
                        >{{__('common.crearconfiguracionnombre')}}</x-ui.label
                    >
                    <x-ui.input.text
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

            <div class="flex justify-between mt-4 border-t border-gray-50 p-4">
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
