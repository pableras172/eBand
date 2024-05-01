<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Actuaciones') }} - {{ $usuario->name }}
        </h2>
        <div class="flex items-center mt-2 mb-4 text-gray-500 w-full">
            <div class="mr-2 px-2 py-2 flex items-center"><x-disponible w="24" h="24" />{{ __('Has marcat no disponible') }}</div>
            <div class="mr-2 px-2 py-2  flex items-center"><x-coche w="24" h="24" />{{ __('Has agafat el cotxe') }}</div>
            <div class="mr-2 px-2 py-2  flex items-center"><x-euro w="24" h="24" />{{ __('Actuació pagada') }}</div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-2">
        <div class="p-4 max-w-md bg-white rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">
                    {{ __('Listado de actuaciones del año: ') }}{{ $year }}</h3>
            </div>
            <hr>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($actuaciones as $actuacion)
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full"
                                        src="{{ asset('storage/imagenes/tipoactuacion/' . $actuacion->actuacion->tipoactuacion->icon) }}"
                                        alt="Tipo de actuación">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $actuacion->actuacion->descripcion }}
                                    </p>
                                    <div class="flex items-center">
                                        @if (!$actuacion->pivot->disponible)
                                            <x-disponible w="24" h="24" />
                                        @endif

                                        @if ($actuacion->pivot->coche)
                                            <x-coche w="24" h="24" />
                                        @endif

                                        @if ($actuacion->pivot->pagada)
                                            <x-euro w="24" h="24" />
                                        @endif
                                    </div>

                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($actuacion->actuacion->fechaActuacion)->format('d/m/Y') }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('yearSelect').addEventListener('change', function() {
            var year = this.value;
            window.location.href = "/actuacion/" + {{ Auth::user()->id }} + "/" + year;
        });
    </script>
</x-app-layout>
