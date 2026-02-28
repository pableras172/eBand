<div class="max-w-4xl mx-auto py-5 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('crud.suggestions.collectionTitle') }}
        </h2>
    </x-slot>

    <x-ui.toast on="saved">{{ __('crud.suggestions.toast.saved') }}</x-ui.toast>

    <div class="overflow-hidden shadow-xl rounded-xl bg-white dark:bg-gray-800">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <!-- Header decorativo -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Editar Suggeriment') }}
                </h3>
                <p class="text-sm text-blue-100 mt-1">{{ __('Modifica el teu suggeriment') }}</p>
            </div>

            <div class="p-8 space-y-6">
                <!-- Fecha de creación -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <x-ui.label for="fechacreacion" class="text-gray-700 dark:text-gray-300">
                        {{ __('crud.suggestions.inputs.fechacreacion.label') }}
                    </x-ui.label>
                    <x-ui.input.date-time class="w-full mt-1" wire:model="form.fechacreacion" name="fechacreacion"
                        id="fechacreacion" readonly />
                    <x-ui.input.error for="form.fechacreacion" />
                    @if (!empty($form->fechacreacion))
                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $form->fechacreacion }}</div>
                    @endif
                </div>

                <!-- Título -->
                <div>
                    <x-ui.label for="titulo" class="text-gray-700 dark:text-gray-300 font-semibold">
                        {{ __('crud.suggestions.inputs.titulo.label') }}
                    </x-ui.label>
                    <x-ui.input.text class="w-full mt-2 text-lg" wire:model="form.titulo" name="titulo" id="titulo"
                        placeholder="{{ __('crud.suggestions.inputs.titulo.placeholder') }}" />
                    <x-ui.input.error for="form.titulo" />
                </div>

                <!-- Texto -->
                <div>
                    <x-ui.label for="texto" class="text-gray-700 dark:text-gray-300 font-semibold">
                        {{ __('crud.suggestions.inputs.texto.label') }}
                    </x-ui.label>
                    <x-ui.input.textarea class="w-full mt-2" wire:model="form.texto" rows="8" name="texto"
                        id="texto" placeholder="{{ __('crud.suggestions.inputs.texto.placeholder') }}" />
                    <x-ui.input.error for="form.texto" />
                </div>

                <!-- Observaciones (solo admins) -->
                @can('admin')
                <div class="bg-amber-50 dark:bg-gray-700 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <x-ui.label for="observaciones" class="text-amber-800 dark:text-amber-200 font-semibold">
                            {{ __('crud.suggestions.inputs.observaciones.label') }}
                        </x-ui.label>
                    </div>
                    <x-ui.input.textarea class="w-full" wire:model="form.observaciones" rows="4"
                        name="observaciones" id="observaciones"
                        placeholder="{{ __('crud.suggestions.inputs.observaciones.placeholder') }}" />
                    <x-ui.input.error for="form.observaciones" />
                </div>
                @endcan

                <!-- Información del usuario y anonimato -->
                <div class="bg-blue-50 dark:bg-gray-700 border border-blue-200 dark:border-gray-600 rounded-lg p-5">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <!-- Campo oculto -->
                        <input type="hidden" wire:model="form.users_id" />

                        <!-- Información del creador -->
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide">
                                    {{ __('crud.suggestions.created_by') ?? 'Creat per' }}
                                </p>
                                <p class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ $form->suggestion?->user?->name ?? __('Guest') }}
                                </p>
                            </div>
                        </div>

                        <!-- Checkbox anónimo -->
                        <div class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-3 shadow-sm">
                            <label class="inline-flex items-center cursor-pointer">
                                <input id="anonimo" type="checkbox" wire:model="form.anonimo"
                                    class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2 cursor-pointer" />
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('crud.suggestions.anonymous') ?: 'Enviar com a anònim' }}
                                </span>
                            </label>
                        </div>
                    </div>
                    <x-ui.input.error for="form.users_id" class="mt-2" />
                    <x-ui.input.error for="form.anonimo" class="mt-2" />
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="bg-gray-50 dark:bg-gray-900 px-8 py-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <!-- Botón volver -->
                    <a href="{{ route('suggestions.index') }}" wire:navigate
                        class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('Tornar') }}
                    </a>

                    <!-- Botón guardar -->
                    <button type="submit" 
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ __('Guardar') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
