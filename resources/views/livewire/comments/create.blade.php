<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-ui.breadcrumbs>
        <x-ui.breadcrumbs.link href="/dashboard"
            >Dashboard</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link href="{{ route('comments.index') }}"
            >{{ __('crud.comments.collectionTitle') }}</x-ui.breadcrumbs.link
        >
        <x-ui.breadcrumbs.separator />
        <x-ui.breadcrumbs.link active
            >Create {{ __('crud.comments.itemTitle') }}</x-ui.breadcrumbs.link
        >
    </x-ui.breadcrumbs>

    <div class="w-full text-gray-500 text-lg font-semibold py-4 uppercase">
        <h1>Create {{ __('crud.comments.itemTitle') }}</h1>
    </div>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="comment"
                        >{{ __('crud.comments.inputs.comment.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.textarea
                        class="w-full"
                        wire:model="form.comment"
                        rows="6"
                        name="comment"
                        id="comment"
                        placeholder="{{ __('crud.comments.inputs.comment.placeholder') }}"
                    />
                    <x-ui.input.error for="form.comment" />
                </div>

                <div class="w-full">
                    <x-ui.label for="user_id"
                        >{{ __('crud.comments.inputs.user_id.label')
                        }}</x-ui.label
                    >
                    <x-ui.input.select
                        wire:model="form.user_id"
                        name="user_id"
                        id="user_id"
                        class="w-full"
                    >
                        <option value="">Select data</option>
                        @foreach ($comments as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-ui.input.select>
                    <x-ui.input.error for="form.user_id" />
                </div>

                <div class="w-full">
                    <x-ui.label for="data"
                        >{{ __('crud.comments.inputs.data.label') }}</x-ui.label
                    >
                    <x-ui.input.textarea
                        class="w-full"
                        wire:model="form.data"
                        rows="6"
                        name="data"
                        id="data"
                        placeholder="{{ __('crud.comments.inputs.data.placeholder') }}"
                    />
                    <x-ui.input.error for="form.data" />
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
