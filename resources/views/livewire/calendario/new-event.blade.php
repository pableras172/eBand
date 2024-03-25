<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Añadir Evento al Calendario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Formulario para agregar evento -->
                    <form wire:submit.prevent="addEvent">
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
                            <input type="text" wire:model.defer="title" id="title" name="title"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="start" class="block text-gray-700 text-sm font-bold mb-2">Fecha de
                                Inicio:</label>
                            <input type="datetime-local" wire:model.defer="start" id="start" name="start"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="end" class="block text-gray-700 text-sm font-bold mb-2">Fecha de Fin:</label>
                            <input type="datetime-local" wire:model.defer="end" id="end" name="end"
                                class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Agregar
                                Evento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>