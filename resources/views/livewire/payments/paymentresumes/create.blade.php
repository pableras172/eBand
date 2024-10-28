<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/">Payments</x-ui.breadcrumbs.link>
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link href="{{ route('paymentresumes.index') }}"
            >{{ __('crud.paymentresumes.collectionTitle')
            }}</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >Create {{ __('crud.paymentresumes.itemTitle')
            }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="descripcion"
                        >{{ __('crud.paymentresumes.inputs.descripcion.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.text
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
                        >{{ __('crud.paymentresumes.inputs.user_id.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.select
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
                        >{{ __('crud.paymentresumes.inputs.created_at.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.date-time
                        class="w-full"
                        wire:model="form.created_at"
                        name="created_at"
                        id="created_at"
                    />
                    <x-ui.input.error for="form.created_at" />
                </div>

                <div class="w-full">
                    <x-ui.label for="document"
                        >{{ __('crud.paymentresumes.inputs.document.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.url
                        class="w-full"
                        wire:model="form.document"
                        name="document"
                        id="document"
                        placeholder="{{ __('crud.paymentresumes.inputs.document.placeholder') }}"
                    />
                    <x-ui.input.error for="form.document" />
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
</div>
