<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi actividad') }}
        </h2>
        <div class="flex items-center mt-2 mb-4 text-gray-500 w-full">
        </div>
    </x-slot>
    <!-- component -->
<!-- This is an example component -->
<div class="max-w-2xl mx-auto mt-2">
	<div class="p-4 max-w-md bg-white rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{__('Actuaciones totales')}}</h3>        
   </div>
   <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($totalesPorTipoActuacion as $tipoActuacionNombre => $tipoActuacion)
            <li class="py-3 sm:py-4">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="{{ asset('storage/imagenes/tipoactuacion/' . $tipoActuacion['icono']) }}" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ $tipoActuacionNombre }} 
                        </p>                        
                    </div>
                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                        {{ $tipoActuacion['total'] }}
                    </div>
                </div>
            </li>  
            @endforeach          
        </ul>
   </div>
</div>	
</div>
    </x-app-layout>