<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (isset($actuacion))
                {{__('Modificar actuación en')}} {{ $contrato->descripcion }}
            @else
            {{__('Añadir actuación a ')}} {{ $contrato->descripcion }}
            @endif
        </h2>
    </x-slot>

    <div class="container mx-auto py-10 px-4 sm:px-8 lg:px-32">
        <!-- Mensajes de error o éxito -->
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">{{__('Error')}}</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Formulario -->
        <form
            @if (isset($actuacion)) action="{{ route('actuacion.update', $actuacion->id) }}"
                method="POST"
            @else
                action="{{ route('actuacion.store') }}"
                method="POST" @endif
            class="max-w-lg mx-auto">
            @csrf
            @if (isset($actuacion))
                @method('PUT')
            @endif

            <div class="mb-4">
                <label for="fechaActuacion" class="block text-sm font-medium text-gray-700">{{__('Data actuacio')}}</label>
                <input type="date" id="fechaActuacion" name="fechaActuacion" required
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    @if (isset($actuacion)) value="{{ $actuacion->fechaActuacion }}" @endif>
            </div>
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">{{__('Descripció')}}</label>
                <textarea id="descripcion" name="descripcion" rows="3" required
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @if (isset($actuacion))
                        {{ $actuacion->descripcion }}
                    @endif
                </textarea>
            </div>

            <div class="mb-4">
                <label for="tipoactuacions_id" class="block text-sm font-medium text-gray-700">{{__('Tipus')}}</label>
                <select id="tipoactuacions_id" name="tipoactuacions_id" required
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <!-- Iterar sobre las opciones del select -->
                    @foreach ($tipoActuacion as $tipo)
                        <option value="{{ $tipo->id }}" @if (isset($actuacion) && $actuacion->tipoactuacions_id == $tipo->id) selected @endif>
                            {{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="coches" class="block text-sm font-medium text-gray-700">{{__('Cantitat de cotxes')}}</label>
                    <input type="number" id="coches" name="coches"
                        value="{{ isset($actuacion) ? $actuacion->coches : '' }}"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="preciocoche" class="block text-sm font-medium text-gray-700">{{__('Preu cotxe')}}</label>
                    <input type="number" id="preciocoche" name="preciocoche" step="0.01"
                        value="{{ isset($actuacion) ? $actuacion->preciocoche : '' }}"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="musicos" class="block text-sm font-medium text-gray-700">{{__('Numero musics')}}</label>
                    <input type="number" id="musicos" name="musicos"
                        value="{{ isset($actuacion) ? $actuacion->musicos : '' }}"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="preciomusico" class="block text-sm font-medium text-gray-700">{{__('Preu music')}}</label>
                    <input type="number" id="preciomusico" name="preciomusico" step="0.01"
                        value="{{ isset($actuacion) ? $actuacion->preciomusico : '' }}"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>


            </div>

            <div class="mb-4">
                <label for="observaciones" class="block text-sm font-medium text-gray-700">{{__('Observacions')}}</label>
                <textarea id="observaciones" name="observaciones" rows="3"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ isset($actuacion) ? $actuacion->observaciones : '' }}</textarea>
            </div>
            <div class="mb-4">
                <label for="pagado" class="block text-sm font-medium text-gray-700">{{__('Pagat')}}</label>
                <input type="checkbox" id="pagado" name="pagado"
                    class="mt-1 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                    {{ isset($actuacion) && $actuacion->pagado ? 'checked' : '' }}>
            </div>
            <input type="hidden" id="contratos_id" name="contratos_id" value="{{ $contrato->id }}" />
            <div class="flex justify-center">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-gray-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Guardar</button>
            </div>
        </form>

        <!-- Grid de actuaciones -->
        <div class="mt-8">
            <div class="w-full bg-white">
                <h2 class="text-center text-lg font-semibold mb-4"> {{ __('common.actuacionescontrato') }}</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($actuaciones as $actuacion)
                    <div>
                        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
                            <div class="p-4 flex items-center">
                                <div class="pr-4 bg-blue-200 p-2 rounded-lg text-center">
                                    <p class="text-4xl font-bold text-white">
                                        {{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d') }}</p>
                                    <p class="text-sm text-white">
                                        {{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('F Y') }}</p>
                                </div>
                                <div class="ml-4">
                                    <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">
                                        {{ $actuacion->descripcion }}</div>
                                    <p class="mt-2 text-gray-500">{{__('Tipus')}}: {{ $actuacion->tipoactuacion->nombre }}</p>
                                    <p class="mt-2 text-gray-500">{{__('Numero musics')}}: {{ $actuacion->musicos }}</p>
                                    <p class="mt-2 text-gray-500">{{__('Cantitat de cotxes')}}: {{ $actuacion->coches }}</p>
                                    <p class="mt-2 text-gray-500">{{ $actuacion->observaciones }}</p>
                                </div>
                            </div>
                            <div class="flex justify-center">
                                <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacion->id]) }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-green-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-2 mr-2">
                                    {{__('Llista')}}
                                </a>
                                <a href="{{ route('actuacion.edit', $actuacion->id) }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-gray-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-2 mr-2">
                                    {{__('Editar')}}
                                </a>

                                <form action="{{ route('actuacion.destroy', $actuacion) }}" method="post"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta actuacion?Si la actuación tiene una lista, también se eliminará.')">
                                    @csrf
                                    @method('DELETE')
                                    <div class="block text-right">
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-2">
                                            {{__('Eliminar')}}
                                        </button>
                                    </div>
                                </form>
                                {{-- <a href="{{ route('actuacion.destroy', $actuacion->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-red-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mb-2">
                                Eliminar
                            </a> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex justify-center mt-4 mb-4">
            <a href="{{ route('contratos.index') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-blue-800 hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                {{__('Tornar al llistat')}}
            </a>
        </div>
    </div>

</x-app-layout>
