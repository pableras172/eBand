<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
    <x-slot name="header">
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/">{{ __('Dashboard') }}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link href="{{ route('comments.index') }}">{{ __('Comentarios') }}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active>{{ __('Editar') }}</x-ui.breadcrumbs.link>
        </x-ui.breadcrumbs>
    </x-slot>

    <x-ui.toast on="saved">{{ __('Comentario actualizado') }}</x-ui.toast>

    <div class="overflow-hidden border rounded-lg bg-white">
        <h2 class="text-xl font-bold text-center text-gray-900 p-3">
            {{ $form->actuacion }}
        </h2>
        
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="comment">{{ __('Texto') }}</x-ui.label>
                    <x-ui.input.textarea class="w-full" wire:model="form.comment" rows="6" name="comment"
                        id="comment"  />
                    <x-ui.input.error for="form.comment" />
                </div>

                <div class="w-full">
                    <x-ui.label for="user_id">{{ __('Usuario') }}</x-ui.label>
                    <x-ui.input.text readonly class="w-full" wire:model="form.username" name="username"
                        id="username" />
                    <x-ui.input.error for="form.username" />
                </div>
                <div class="flex justify-center items-center space-x-2">
                    <div class="flex items-center space-x-2">

                        <x-ui.input.checkbox class="" wire:model="form.eliminado" name="eliminado" id="eliminado"
                            :checked="$form->eliminado == 1" />
                        <x-ui.label for="eliminado">{{ __('Eliminado') }}</x-ui.label>
                    </div>
                    <div class="flex items-center space-x-2">

                        <x-ui.input.checkbox class="" wire:model="form.inadecuado" name="inadecuado"
                            id="inadecuado" :checked="$form->inadecuado == 1" />
                        <x-ui.label for="inadecuado">{{ __('Inadecuado') }}</x-ui.label>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-4 border-t border-gray-50 p-4">
                <div>
                    <!-- Other buttons here -->
                </div>
                <div>
                    <x-ui.button type="submit">{{ __('Guardar') }}</x-ui.button>
                </div>
            </div>
        </form>
    </div>
</div>
