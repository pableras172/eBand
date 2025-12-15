<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-4">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('crud.suggestions.create') }}
        </h2>
    </x-slot>

    <div class="overflow-hidden border rounded-lg bg-white">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <div class="p-6 space-y-3">
                <div class="w-full">
                    <x-ui.label for="fechacreacion">{{ __('crud.suggestions.inputs.fechacreacion.label') }}</x-ui.label>
                    <x-ui.input.date-time class="w-full" wire:model="form.fechacreacion" name="fechacreacion"
                        id="fechacreacion" readonly />
                    <x-ui.input.error for="form.fechacreacion" />
                </div>

                <div class="w-full">
                    <x-ui.label for="titulo">{{ __('crud.suggestions.inputs.titulo.label') }}</x-ui.label>
                    <x-ui.input.text class="w-full" wire:model="form.titulo" name="titulo" id="titulo"
                        placeholder="{{ __('crud.suggestions.inputs.titulo.placeholder') }}" />
                    <x-ui.input.error for="form.titulo" />
                </div>

                <div class="w-full">
                    <x-ui.label for="texto">{{ __('crud.suggestions.inputs.texto.label') }}</x-ui.label>
                    <x-ui.input.textarea class="w-full" wire:model="form.texto" rows="6" name="texto"
                        id="texto" placeholder="{{ __('crud.suggestions.inputs.texto.placeholder') }}" />
                    <x-ui.input.error for="form.texto" />
                </div>
                <div class="flex justify-between mt-4 border-t border-gray-50 p-4">
                    <div class="w-full">

                        <!-- campo oculto con el id del usuario (se actualizará a null si se marca anonimato en save) -->
                        <input type="hidden" wire:model="form.users_id" />

                        <!-- mostrar quién será el creador (reactivo) -->
                        <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                           {{ __('crud.suggestions.created_by') ?? 'Creado por' }}: {{ auth()->user()->name }}
                        </div>

                        <x-ui.input.error for="form.users_id" />
                    </div>
                    <div class="w-full">
                        <div class="mt-1">
                            <label class="inline-flex items-center text-sm text-gray-700 dark:text-gray-200">
                                <input id="anonimo" type="checkbox" wire:model.live="form.anonimo"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                <span
                                    class="ml-2">{{ __('crud.suggestions.anonymous') ?: 'Enviar como anónimo' }}</span>
                            </label>
                        </div>

                        <x-ui.input.error for="anonimo" />
                    </div>
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
