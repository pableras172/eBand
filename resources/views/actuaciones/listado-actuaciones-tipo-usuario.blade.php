<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Actuaciones') }} - {{$usuario->name}}
        </h2>
        <div class="flex items-center mt-2 mb-4 text-gray-500 w-full">
        </div>
    </x-slot>
    <!-- component -->
<!-- This is an example component -->
<div class="max-w-2xl mx-auto mt-2">
	<div class="p-4 max-w-md bg-white rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{__('Listado de actuaciones del año: ') }}{{$year}}</h3>
            <div class="relative">
                
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.293 11.707a1 1 0 0 1-1.414 0L4.586 8.414a1 1 0 0 1 1.414-1.414L10 10.586l4.293-4.293a1 1 0 1 1 1.414 1.414l-5 5a1 1 0 0 1-1.414 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($actuaciones as $actuacion)
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="{{ asset('storage/imagenes/tipoactuacion/' . $actuacion->actuacion->tipoactuacion->icon) }}" alt="Tipo de actuación">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $actuacion->actuacion->descripcion }} 
                            </p>                                                
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
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
        window.location.href = "/actuacion/"+{{Auth::user()->id}}+"/"+year;
    });


</script>
    </x-app-layout>