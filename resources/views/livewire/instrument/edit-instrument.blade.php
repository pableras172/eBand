<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar instrumento
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
        <!-- Botón de eliminación -->
        <form action="{{ route('instrument.destroy', $instrument) }}" method="post" 
              onsubmit="return confirm('¿Estás seguro de que deseas eliminar este instrumento?')" class="mb-4 text-right">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md transition">
                🗑️ Eliminar
            </button>
        </form>

        <!-- Formulario de edición -->
        <form method="POST" action="{{ route('instrument.update', $instrument->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name" id="name"
                       class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
                       value="{{ old('name', $instrument->name) }}" required>
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Orden -->
            <div>
                <label for="orden" class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                <input type="number" name="orden" id="orden"
                       class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
                       value="{{ old('orden', $instrument->orden) }}" required>
                @error('orden')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Icono -->
            <div class="flex items-center space-x-4">
                <!-- Vista previa del icono actual -->
                <div class="flex-shrink-0">
                    @if ($instrument->icon)
                        <img src="{{ asset('storage/imagenes/instruments/' . $instrument->icon) }}" 
                             alt="Icono actual" class="w-16 h-16 rounded-full border">
                    @else
                        <x-nophoto w="40" h="40"/>
                    @endif
                </div>

                <!-- Campo para subir nuevo icono -->
                <div class="w-full">
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icono</label>
                    <input type="file" name="icon" id="icon" 
                           class="w-full border border-gray-300 rounded-md shadow-sm p-2 cursor-pointer file:bg-blue-100 file:text-blue-700 file:rounded-md file:border-0 file:py-2 file:px-3 hover:file:bg-blue-200" accept="image/*">
                    @error('icon')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between pt-4">
                <button type="submit" 
                        class="bg-green-600 text-white font-bold py-2 px-4 rounded-md hover:bg-green-700 transition">
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
