<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Llistat de músics')}}
        </h2>
    </x-slot>

    @if(request()->has('success') && request()->success)
    <div class="bg-green-200 text-green-800 py-2 px-4 mb-4 rounded">
        {{__('Usuari creat')}}
    </div>
    @endif

    <div>
        <div class="container mx-auto py-2 px-2 sm:px-6 lg:px-0">        
            <div class="block mb-2">

                <div class="flex justify-between">
                    <button type="button" 
                    id="mostrarForasters"
                    class="bg-fondofosrastero hover:bg-fondofosrastero-700 text-white font-bold py-2 px-4 rounded" onclick="mostrarForasters(this)">
                    {{__('Mostrar forasters')}}                               
                </button>
                    <a href="{{ route('users.create') }}" class="bg-green-700 hover:bg-green-500 text-white font-bold py-2 px-4 rounded">{{__('Nou music')}}</a>

                </div>
                
            </div>
                    
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                <tr>
                                    <th scope="col" class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        
                                    </th>
                                    <th scope="col" class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Nom')}}
                                    </th>
                                    <!-- EMAIL -->
                                    <th scope="col" class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{__('Email')}}
                                    </th>                                    
                                    <!-- FECHA ALTA -->
                                    <th scope="col" class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{__('Fecha Alta')}}
                                    </th>
                                    <!-- INSTRUMENT -->
                                    <th scope="col" class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{__('Instrument')}}
                                    </th>
                                    <!-- ACTIU -->
                                    <th scope="col" class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{__('Actiu')}}
                                    </th>                                    
                                    <th scope="col" class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Accions')}}
                                    </th>                                    
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    
                                        @if ($user->activo == 0)
                                            <tr @if ($user->forastero==1) class="listaforastero" @endif style="background-color: #891212; color: white; @if($user->forastero) display: none; @endif">
                                        @else
                                            <tr  @if ($user->forastero==1) class="listaforastero" @endif style="@if($user->forastero==1)background-color: #97a9a9; display: none; @endif">
                                        @endif
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full">
                                        </td>
                                        @if ($user->activo == 0)
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-white-900">
                                        @else
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                        @endif                                        
                                            {{ $user->name }}                                           
                                        </td>
                                        <!-- EMAIL -->
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $user->email }}
                                        </td>   
                                        <!-- FECHA ALTA -->
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $user->fechaAlta ? \Carbon\Carbon::parse($user->fechaAlta)->format('d/m/Y') : '-' }}
                                        </td>
                                        <!-- INSTRUMENT -->
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            @if ($user->instrument)
                                                {{ $user->instrument->name }}
                                            @else
                                                {{__('No te instrument asignat')}}
                                            @endif
                                        </td>
                                        <!-- ACTIU -->
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $user->activo ? 'Si' : 'No' }}
                                        </td>

                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">                                                                                        
                                            <a href="{{ route('users.edit', $user->id) }}" class="bg-fondobotonazul hover:bg-fondobotonazul-400 text-white font-bold py-2 px-4 rounded">
                                                {{__('Editar')}}
                                            </a>                                            
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
    function mostrarForasters(boton) {
            // Obtenemos el valor del atributo data-instrument-name del botón
           
            
            // Seleccionamos todos los elementos <li> con la clase correspondiente al instrumento
            const elementsToShowHide = document.querySelectorAll(`.listaforastero`);

            // Iteramos sobre los elementos para mostrarlos u ocultarlos
            elementsToShowHide.forEach(element => {
                // Si el elemento está visible, lo ocultamos; si está oculto, lo mostramos
                if (element.style.display === 'none') {
                    element.style.display = '';
                } else {
                    element.style.display = 'none';
                }
            });

            if (boton.textContent.trim() === '{{__('Mostrar forasters')}}') {
                boton.textContent = '{{__('Ocultar forasters')}}';
            } else {
                boton.textContent = '{{__('Mostrar forasters')}}';
            }
        }

    </script>
</x-app-layout>
