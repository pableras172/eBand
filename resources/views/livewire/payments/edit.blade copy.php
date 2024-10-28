<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link href="{{ route('payments.index') }}"
            >{{ __('crud.payments.collectionTitle') }}</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >Edit {{ __('crud.payments.itemTitle') }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <x-ui.toast on="saved"> Payment saved successfully. </x-ui.toast>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>Edit {{ __('crud.payments.itemTitle') }}</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="fechaPago"
                        >{{ __('crud.payments.inputs.fechaPago.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.date-time
                        class="w-full"
                        wire:model="form.fechaPago"
                        name="fechaPago"
                        id="fechaPago"
                    />
                    <x-ui.input.error for="form.fechaPago" />
                </div>

                <div class="w-full">
                    <x-ui.label for="descripcion"
                        >{{ __('crud.payments.inputs.descripcion.label')
                        }}</x-ui.label
                    >
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
                    <x-ui.label for="users_id"
                        >{{ __('crud.payments.inputs.users_id.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.select
                        wire:model="form.users_id"
                        name="users_id"
                        id="users_id"
                        class="w-full"
                    >
                        <option value="">Select data</option>
                        @foreach ($users as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-ui.input.select>
                    <x-ui.input.error for="form.users_id" />
                </div>
            </div>

            <div class="flex justify-between mt-4 border-t border-gray-50 p-4">
                <div>
                    <!-- Other buttons here -->
                </div>
                <div>
                    <x-ui.button type="submit">Save</x-ui.button>
                </div>
            </div>
        </form>
    </div>

    <?php /* @can('view-any', App\Models\ListasUser::class) */?>
    <div class="overflow-hidden border rounded-lg bg-white">
        <div class="w-full mb-0">
            <div class="p-6 space-y-3">
                <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
                    <h2>{{ __('crud.listasUsers.collectionTitle') }}</h2>
                </div>

                <livewire:payment.payment-listas-users-detail :payment="$payment" />
                    
            </div>
        </div>
    </div>
    <?php /* @endcan */ ?>
</div>
