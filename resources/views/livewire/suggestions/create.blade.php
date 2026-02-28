<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('crud.suggestions.create') }}
        </h2>
    </x-slot>

    <div class="overflow-hidden shadow-xl rounded-xl bg-white dark:bg-gray-800">
        <form class="w-full mb-0" wire:submit.prevent="save">
            <!-- Header decorativo -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    {{ __('Comparteix la teva idea') }}
                </h3>
                <p class="text-sm text-blue-100 mt-1">{{ __('Les teves suggerències ens ajuden a millorar') }}</p>
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
                                    {{ auth()->user()->name }}
                                </p>
                            </div>
                        </div>

                        <!-- Checkbox anónimo -->
                        <div class="flex items-center bg-white dark:bg-gray-800 rounded-lg px-4 py-3 shadow-sm">
                            <label class="inline-flex items-center cursor-pointer">
                                <input id="anonimo" type="checkbox" wire:model.live="form.anonimo"
                                    class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2 cursor-pointer" />
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('crud.suggestions.anonymous') ?: 'Enviar com a anònim' }}
                                </span>
                            </label>
                        </div>
                    </div>
                    <x-ui.input.error for="form.users_id" class="mt-2" />
                </div>
            </div>

            <!-- Botón de enviar centrado -->
            <div class="bg-gray-50 dark:bg-gray-900 px-8 py-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-center">
                    <button type="submit" 
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ __('Enviar Suggeriment') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
