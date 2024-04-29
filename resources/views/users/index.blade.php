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
                                    <th scope="col" class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        
                                    </th>
                                    <th scope="col" class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Nom')}}
                                    </th>
                                    <!-- EMAIL -->
                                    <th scope="col" class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{__('Email')}}
                                    </th>                                    
                                    <!-- FECHA ALTA -->
                                    <th scope="col" class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{__('Fecha Alta')}}
                                    </th>
                                    <!-- INSTRUMENT -->
                                    <th scope="col" class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{__('Instrument')}}
                                    </th>
                                    <!-- ACTIU -->
                                    <th scope="col" class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        {{__('Actiu')}}
                                    </th>                                    
                                    <th scope="col" class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900">
                                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full">
                                        </td>
                                        @if ($user->activo == 0)
                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-white-900">
                                        @else
                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900">
                                        @endif                                        
                                            <div class="flex justify-between">
                                              {{ $user->name }}
                                              <a href="{{ route('actuaciones.usuario.anyo', [$user->id, date('Y')]) }}" alt="{{__('Estadísticas')}}">
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffbd59"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3.29289 9.29289C3 9.58579 3 10.0572 3 11V17C3 17.9428 3 18.4142 3.29289 18.7071C3.58579 19 4.05719 19 5 19C5.94281 19 6.41421 19 6.70711 18.7071C7 18.4142 7 17.9428 7 17V11C7 10.0572 7 9.58579 6.70711 9.29289C6.41421 9 5.94281 9 5 9C4.05719 9 3.58579 9 3.29289 9.29289Z" fill="#1C274C"></path> <path opacity="0.4" d="M17.2929 2.29289C17 2.58579 17 3.05719 17 4V17C17 17.9428 17 18.4142 17.2929 18.7071C17.5858 19 18.0572 19 19 19C19.9428 19 20.4142 19 20.7071 18.7071C21 18.4142 21 17.9428 21 17V4C21 3.05719 21 2.58579 20.7071 2.29289C20.4142 2 19.9428 2 19 2C18.0572 2 17.5858 2 17.2929 2.29289Z" fill="#1C274C"></path> <path opacity="0.7" d="M10 7C10 6.05719 10 5.58579 10.2929 5.29289C10.5858 5 11.0572 5 12 5C12.9428 5 13.4142 5 13.7071 5.29289C14 5.58579 14 6.05719 14 7V17C14 17.9428 14 18.4142 13.7071 18.7071C13.4142 19 12.9428 19 12 19C11.0572 19 10.5858 19 10.2929 18.7071C10 18.4142 10 17.9428 10 17V7Z" fill="#1C274C"></path> <path d="M3 21.25C2.58579 21.25 2.25 21.5858 2.25 22C2.25 22.4142 2.58579 22.75 3 22.75H21C21.4142 22.75 21.75 22.4142 21.75 22C21.75 21.5858 21.4142 21.25 21 21.25H3Z" fill="#1C274C"></path> </g></svg>
                                                </a>
                                      

                                            </div>
                                        </td>
                                        <!-- EMAIL -->
                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $user->email }}
                                        </td>   
                                        <!-- FECHA ALTA -->
                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $user->fechaAlta ? \Carbon\Carbon::parse($user->fechaAlta)->format('d/m/Y') : '-' }}
                                        </td>
                                        <!-- INSTRUMENT -->
                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            @if ($user->instrument)
                                                {{ $user->instrument->name }}
                                            @else
                                                {{__('No te instrument asignat')}}
                                            @endif
                                        </td>
                                        <!-- ACTIU -->
                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $user->activo ? 'Si' : 'No' }}
                                        </td>

                                        <td class="px-2 py-2 whitespace-nowrap text-sm font-medium">   
                                            <div class="flex justify-between">                                                                                     
                                            <a href="{{ route('users.edit', $user->id) }}" class="bg-fondobotonazul hover:bg-fondobotonazul-400 text-white font-bold py-2 px-4 rounded">
                                                {{__('Editar')}}
                                            </a>
                                           
                                                @if(!$user->porcentaje)
                                                    <svg width="24px" height="24px" viewBox="0 0 22 22" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" id="svg2" version="1.1" inkscape:version="0.92.1 r15371" sodipodi:docname="dark_warning.svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs id="defs4"> <linearGradient gradientUnits="userSpaceOnUse" y2="2" x2="16" y1="29.999973" x1="16" id="linearGradient4144" xlink:href="#linearGradient4155" inkscape:collect="always" gradientTransform="matrix(1.66667 0 0 -1.66667 -15.667 1064.696)"></linearGradient> <linearGradient inkscape:collect="always" id="linearGradient4155"> <stop style="stop-color:#fcd994;stop-opacity:1" offset="0" id="stop4157"></stop> <stop style="stop-color:#fff6e1;stop-opacity:1" offset="1" id="stop4159"></stop> </linearGradient> </defs> <sodipodi:namedview id="base" pagecolor="#ffffff" bordercolor="#666666" borderopacity="1.0" inkscape:pageopacity="0.0" inkscape:pageshadow="2" inkscape:zoom="22.4" inkscape:cx="-8.3436117" inkscape:cy="10.155389" inkscape:document-units="px" inkscape:current-layer="layer1" showgrid="true" inkscape:showpageshadow="false" borderlayer="true" inkscape:window-width="1884" inkscape:window-height="1051" inkscape:window-x="0" inkscape:window-y="0" inkscape:window-maximized="1" units="px"> <sodipodi:guide position="2,20.000017" orientation="18,0" id="guide4085" inkscape:locked="false"></sodipodi:guide> <sodipodi:guide position="2,2.0000174" orientation="0,18" id="guide4087" inkscape:locked="false"></sodipodi:guide> <sodipodi:guide position="20,2.0000174" orientation="-18,0" id="guide4089" inkscape:locked="false"></sodipodi:guide> <sodipodi:guide position="20,20.000017" orientation="0,-18" id="guide4091" inkscape:locked="false"></sodipodi:guide> <sodipodi:guide position="3,19.000017" orientation="16,0" id="guide4093" inkscape:locked="false"></sodipodi:guide> <sodipodi:guide position="3,3.0000174" orientation="0,16" id="guide4095" inkscape:locked="false"></sodipodi:guide> <sodipodi:guide position="19,3.0000174" orientation="-16,0" id="guide4097" inkscape:locked="false"></sodipodi:guide> <sodipodi:guide position="19,19.000017" orientation="0,-16" id="guide4099" inkscape:locked="false"></sodipodi:guide> <inkscape:grid type="xygrid" id="grid4101"></inkscape:grid> </sodipodi:namedview> <metadata id="metadata7"> <rdf:rdf> <cc:work> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"></dc:type> <dc:title></dc:title> <dc:creator> <cc:agent> <dc:title>Timothée Giet</dc:title> </cc:agent> </dc:creator> <dc:date>2017</dc:date> <cc:license rdf:resource="http://creativecommons.org/licenses/by-sa/4.0/"></cc:license> </cc:work> <cc:license rdf:about="http://creativecommons.org/licenses/by-sa/4.0/"> <cc:permits rdf:resource="http://creativecommons.org/ns#Reproduction"></cc:permits> <cc:permits rdf:resource="http://creativecommons.org/ns#Distribution"></cc:permits> <cc:requires rdf:resource="http://creativecommons.org/ns#Notice"></cc:requires> <cc:requires rdf:resource="http://creativecommons.org/ns#Attribution"></cc:requires> <cc:permits rdf:resource="http://creativecommons.org/ns#DerivativeWorks"></cc:permits> <cc:requires rdf:resource="http://creativecommons.org/ns#ShareAlike"></cc:requires> </cc:license> </rdf:rdf> </metadata> <g inkscape:label="Capa 1" inkscape:groupmode="layer" id="layer1" transform="translate(0 -1030.362)"> <path style="fill:#ffc35a;fill-opacity:1;stroke:none;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" d="m11 1032.362-10 18h20zm0 2 8 15H3z" id="path839" inkscape:connector-curvature="0" sodipodi:nodetypes="cccccccc"></path> <path style="fill:#373737;fill-opacity:.94117647;stroke:none;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" d="M10 1046.362h2v2h-2z" id="path844" inkscape:connector-curvature="0"></path> <path style="fill:#373737;fill-opacity:.94117647;stroke:none;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" d="M10 1045.362h2v-6h-2z" id="path846" inkscape:connector-curvature="0" sodipodi:nodetypes="ccccc"></path> </g> </g></svg>
                                                @endif
                                           
                                        </div>                                                                              
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
            <div class="bg-white px-4 py-2 mb-4 flex justify-center  items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{__('Filtra por instrumento:')}}</h2>
                <a href="{{ route('users.index') }}" >
                    <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 15L21 21M21 15L15 21M10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L17 11" stroke="#b2843e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </a>
            </div>
            
            <div class="flex flex-wrap justify-center bg-white py-4 px-6">
                @foreach($instruments as $instrument)
                <a href="{{ route('users.index', ['instrument_id' => $instrument->id]) }}" class="relative group flex items-center mb-2 mr-4 rounded-md">
                    <img class="w-8 h-8 rounded-full" src="{{ asset('/storage/imagenes/instruments/' . $instrument->icon) }}" alt="{{ $instrument->name }}">
                    <div class="absolute inset-0 bg-gray-900 opacity-50 rounded-md"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-white text-xs font-bold">{{ $instrument->users_count }}</span>
                    </div>
                </a>
                @endforeach
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
