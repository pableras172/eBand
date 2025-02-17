<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo instrumento
        </h2>
        <x-ui.breadcrumbs>
            <x-ui.breadcrumbs.link href="/">{{__('common.dashboard')}}</x-ui.breadcrumbs.link>
            <x-ui.breadcrumbs.separator />
            <x-ui.breadcrumbs.link active
                > {{__('common.instrumentos')}}</x-ui.breadcrumbs.link
            >
        </x-ui.breadcrumbs>
    </x-slot>

    <div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <form method="POST" action="{{ route('instrument.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Nombre del instrumento -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name" id="name" 
                       class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
                       value="{{ old('name', '') }}" placeholder="Introduce el nombre" required>
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Orden -->
            <div>
                <label for="orden" class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                <input type="number" name="orden" id="orden" 
                       class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
                       value="{{ old('orden', '') }}" placeholder="Introduce el orden" required>
                @error('orden')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Icono -->
            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icono</label>
                <input type="file" name="icon" id="icon" 
                       class="w-full border border-gray-300 rounded-md shadow-sm p-2 cursor-pointer file:bg-blue-100 file:text-blue-700 file:rounded-md file:border-0 file:py-2 file:px-3 hover:file:bg-blue-200" accept="image/*">
                @error('icon')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between pt-4">
                <button type="submit" 
                        class="bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition">
                    Guardar
                </button>
                <a href="{{ route('instrument.index') }}" 
                   class="text-gray-600 hover:underline text-sm">
                    ← Volver al listado
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
