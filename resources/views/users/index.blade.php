<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Llistat de músics') }}
        </h2>
    </x-slot>

    @if (request()->has('success') && request()->success)
        <div class="bg-green-200 text-green-800 py-2 px-4 mb-4 rounded">
            {{ __('Usuari creat') }}
        </div>
    @endif

    <div>
        <div class="container mx-auto py-2 px-2 sm:px-6 lg:px-0">

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                        </th>
                                        <th scope="col"
                                            class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Nom') }}
                                        </th>
                                        <!-- EMAIL -->
                                        <th scope="col"
                                            class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                            {{ __('Email') }}
                                        </th>
                                        <!-- FECHA ALTA -->
                                        <th scope="col"
                                            class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                            {{ __('Fecha Alta') }}
                                        </th>
                                        <!-- INSTRUMENT -->
                                        <th scope="col"
                                            class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                            {{ __('Instrument') }}
                                        </th>
                                        <!-- ACTIU -->
                                        <th scope="col"
                                            class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                            {{ __('Actiu') }}
                                        </th>
                                        <th scope="col"
                                            class="px-2 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Accions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($users as $user)
                                        @if ($user->activo == 0)
                                            <tr @if ($user->forastero == 1) class="listaforastero" @endif
                                                style="background-color: #891212; color: white; @if ($user->forastero) display: none; @endif">
                                            @else
                                            <tr @if ($user->forastero == 1) class="listaforastero" @endif
                                                style="
            @if ($user->forastero == 1) background-color: #97a9a9; display: none; 
            @elseif($user->hijos->isNotEmpty()) background-color: #ffe08a;  {{-- amarillo padres --}} @endif
        ">
                                        @endif

                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                                    class="h-10 w-10 rounded-full">
                                                @if ($user->hijos->isNotEmpty())
                                                    <span class="ml-2 text-yellow-600">
                                                        {{-- aquí metes el icono que quieras, por ejemplo: --}}
                                                        <svg height="24px" width="24px" version="1.1" id="_x36_"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <g>
                                                                    <path style="fill:#646363;"
                                                                        d="M468.125,128.73C304.284,99.474,234.069,0,234.069,0S163.847,99.474,0.013,128.73 c0,64.367-5.858,277.944,234.056,383.27C473.976,406.675,468.125,193.098,468.125,128.73z">
                                                                    </path>
                                                                    <path style="fill:#EAEEBE;"
                                                                        d="M234.069,466.88C63.977,384.073,43.61,240.378,41.255,161.786 c95.349-23.792,158.067-69.25,192.814-101.558c34.747,32.308,97.458,77.766,192.807,101.558 C424.528,240.378,404.155,384.073,234.069,466.88z">
                                                                    </path>
                                                                    <path style="fill:#F0C57B;"
                                                                        d="M410.284,169.867c-1.813,70.95-19.134,203.716-176.215,279.583 c-29.05-14.015-53.306-29.989-73.582-47.191c-27.411-23.173-47.513-48.568-62.293-74.285 c-33.346-58.164-39.32-118.025-40.346-158.106c88.156-21.531,145.384-63.78,176.221-92.92 c15.328,14.483,37.185,32.21,66.118,49.035c26.16,15.183,58.132,29.637,96.284,40.256 C400.981,167.525,405.6,168.725,410.284,169.867z">
                                                                    </path>
                                                                    <g>
                                                                        <path style="fill:#716363;"
                                                                            d="M234.069,76.947c-30.837,29.14-88.066,71.389-176.221,92.92 c0.613,23.74,3.007,54.442,11.742,87.595h164.48V76.947z">
                                                                        </path>
                                                                        <path style="opacity:0.26;fill:#F1891A;"
                                                                            d="M396.472,166.238c-38.152-10.618-70.124-25.073-96.284-40.256 c-28.934-16.825-50.79-34.552-66.118-49.035v180.515h164.506c8.748-33.153,11.103-63.841,11.709-87.595 C405.6,168.725,400.981,167.525,396.472,166.238z">
                                                                        </path>
                                                                        <path style="opacity:0.26;fill:#F1891A;"
                                                                            d="M69.589,257.462c6.012,22.824,15.011,46.8,28.604,70.512 c14.78,25.718,34.882,51.113,62.293,74.285c20.276,17.202,44.532,33.176,73.582,47.191V257.462H69.589z">
                                                                        </path>
                                                                        <path style="fill:#716363;"
                                                                            d="M234.069,449.449c104.49-50.468,147.133-126.108,164.506-191.988H234.069V449.449z">
                                                                        </path>
                                                                    </g>
                                                                    <path style="opacity:0.08;fill:#231815;"
                                                                        d="M234.069,0c0,0,70.215,99.474,234.056,128.73c0,64.367,5.851,277.944-234.056,383.27V0 z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        @if ($user->activo == 0)
                                            <td class="px-2 py-2 whitespace-nowrap text-sm text-white-900">
                                            @else
                                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-900">
                                        @endif
                                        <div class="flex justify-between">

                                            {{ $user->name }}

                                            <a href="{{ route('actuaciones.usuario.anyo', [$user->id, date('Y')]) }}"
                                                alt="{{ __('Estadísticas') }}">
                                                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" stroke="#ffbd59">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M3.29289 9.29289C3 9.58579 3 10.0572 3 11V17C3 17.9428 3 18.4142 3.29289 18.7071C3.58579 19 4.05719 19 5 19C5.94281 19 6.41421 19 6.70711 18.7071C7 18.4142 7 17.9428 7 17V11C7 10.0572 7 9.58579 6.70711 9.29289C6.41421 9 5.94281 9 5 9C4.05719 9 3.58579 9 3.29289 9.29289Z"
                                                            fill="#1C274C"></path>
                                                        <path opacity="0.4"
                                                            d="M17.2929 2.29289C17 2.58579 17 3.05719 17 4V17C17 17.9428 17 18.4142 17.2929 18.7071C17.5858 19 18.0572 19 19 19C19.9428 19 20.4142 19 20.7071 18.7071C21 18.4142 21 17.9428 21 17V4C21 3.05719 21 2.58579 20.7071 2.29289C20.4142 2 19.9428 2 19 2C18.0572 2 17.5858 2 17.2929 2.29289Z"
                                                            fill="#1C274C"></path>
                                                        <path opacity="0.7"
                                                            d="M10 7C10 6.05719 10 5.58579 10.2929 5.29289C10.5858 5 11.0572 5 12 5C12.9428 5 13.4142 5 13.7071 5.29289C14 5.58579 14 6.05719 14 7V17C14 17.9428 14 18.4142 13.7071 18.7071C13.4142 19 12.9428 19 12 19C11.0572 19 10.5858 19 10.2929 18.7071C10 18.4142 10 17.9428 10 17V7Z"
                                                            fill="#1C274C"></path>
                                                        <path
                                                            d="M3 21.25C2.58579 21.25 2.25 21.5858 2.25 22C2.25 22.4142 2.58579 22.75 3 22.75H21C21.4142 22.75 21.75 22.4142 21.75 22C21.75 21.5858 21.4142 21.25 21 21.25H3Z"
                                                            fill="#1C274C"></path>
                                                    </g>
                                                </svg>
                                            </a>

                                        </div>
                                        </td>
                                        <!-- EMAIL -->
                                        <td
                                            class="px-2 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $user->email }}
                                        </td>
                                        <!-- FECHA ALTA -->
                                        <td
                                            class="px-2 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $user->fechaAlta ? \Carbon\Carbon::parse($user->fechaAlta)->format('d/m/Y') : '-' }}
                                        </td>
                                        <!-- INSTRUMENT -->
                                        <td
                                            class="px-2 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            @if ($user->instrument)
                                                {{ $user->instrument->name }}
                                            @else
                                                {{ __('No te instrument asignat') }}
                                            @endif
                                        </td>
                                        <!-- ACTIU -->
                                        <td
                                            class="px-2 py-2 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                                            {{ $user->activo ? 'Si' : 'No' }}
                                        </td>

                                        <td class="px-2 py-2 whitespace-nowrap text-sm font-medium">
                                            <div class="flex justify-center">
                                                <a href="{{ route('users.edit', $user->id) }}">
                                                    <x-editar w="24" h="24" />
                                                </a>

                                                @if (!$user->porcentaje)
                                                    <svg width="24px" height="24px" viewBox="0 0 22 22"
                                                        xmlns:dc="http://purl.org/dc/elements/1.1/"
                                                        xmlns:cc="http://creativecommons.org/ns#"
                                                        xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                                                        xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                                                        id="svg2" version="1.1" inkscape:version="0.92.1 r15371"
                                                        sodipodi:docname="dark_warning.svg" fill="#000000">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                            stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <defs id="defs4">
                                                                <linearGradient gradientUnits="userSpaceOnUse"
                                                                    y2="2" x2="16" y1="29.999973"
                                                                    x1="16" id="linearGradient4144"
                                                                    xlink:href="#linearGradient4155"
                                                                    inkscape:collect="always"
                                                                    gradientTransform="matrix(1.66667 0 0 -1.66667 -15.667 1064.696)">
                                                                </linearGradient>
                                                                <linearGradient inkscape:collect="always"
                                                                    id="linearGradient4155">
                                                                    <stop style="stop-color:#fcd994;stop-opacity:1"
                                                                        offset="0" id="stop4157"></stop>
                                                                    <stop style="stop-color:#fff6e1;stop-opacity:1"
                                                                        offset="1" id="stop4159"></stop>
                                                                </linearGradient>
                                                            </defs>
                                                            <sodipodi:namedview id="base" pagecolor="#ffffff"
                                                                bordercolor="#666666" borderopacity="1.0"
                                                                inkscape:pageopacity="0.0" inkscape:pageshadow="2"
                                                                inkscape:zoom="22.4" inkscape:cx="-8.3436117"
                                                                inkscape:cy="10.155389" inkscape:document-units="px"
                                                                inkscape:current-layer="layer1" showgrid="true"
                                                                inkscape:showpageshadow="false" borderlayer="true"
                                                                inkscape:window-width="1884"
                                                                inkscape:window-height="1051" inkscape:window-x="0"
                                                                inkscape:window-y="0" inkscape:window-maximized="1"
                                                                units="px">
                                                                <sodipodi:guide position="2,20.000017"
                                                                    orientation="18,0" id="guide4085"
                                                                    inkscape:locked="false"></sodipodi:guide>
                                                                <sodipodi:guide position="2,2.0000174"
                                                                    orientation="0,18" id="guide4087"
                                                                    inkscape:locked="false"></sodipodi:guide>
                                                                <sodipodi:guide position="20,2.0000174"
                                                                    orientation="-18,0" id="guide4089"
                                                                    inkscape:locked="false"></sodipodi:guide>
                                                                <sodipodi:guide position="20,20.000017"
                                                                    orientation="0,-18" id="guide4091"
                                                                    inkscape:locked="false"></sodipodi:guide>
                                                                <sodipodi:guide position="3,19.000017"
                                                                    orientation="16,0" id="guide4093"
                                                                    inkscape:locked="false"></sodipodi:guide>
                                                                <sodipodi:guide position="3,3.0000174"
                                                                    orientation="0,16" id="guide4095"
                                                                    inkscape:locked="false"></sodipodi:guide>
                                                                <sodipodi:guide position="19,3.0000174"
                                                                    orientation="-16,0" id="guide4097"
                                                                    inkscape:locked="false"></sodipodi:guide>
                                                                <sodipodi:guide position="19,19.000017"
                                                                    orientation="0,-16" id="guide4099"
                                                                    inkscape:locked="false"></sodipodi:guide>
                                                                <inkscape:grid type="xygrid" id="grid4101">
                                                                </inkscape:grid>
                                                            </sodipodi:namedview>
                                                            <metadata id="metadata7">
                                                                <rdf:rdf>
                                                                    <cc:work>
                                                                        <dc:format>image/svg+xml</dc:format>
                                                                        <dc:type
                                                                            rdf:resource="http://purl.org/dc/dcmitype/StillImage">
                                                                        </dc:type>
                                                                        <dc:title></dc:title>
                                                                        <dc:creator>
                                                                            <cc:agent>
                                                                                <dc:title>Timothée Giet</dc:title>
                                                                            </cc:agent>
                                                                        </dc:creator>
                                                                        <dc:date>2017</dc:date>
                                                                        <cc:license
                                                                            rdf:resource="http://creativecommons.org/licenses/by-sa/4.0/">
                                                                        </cc:license>
                                                                    </cc:work>
                                                                    <cc:license
                                                                        rdf:about="http://creativecommons.org/licenses/by-sa/4.0/">
                                                                        <cc:permits
                                                                            rdf:resource="http://creativecommons.org/ns#Reproduction">
                                                                        </cc:permits>
                                                                        <cc:permits
                                                                            rdf:resource="http://creativecommons.org/ns#Distribution">
                                                                        </cc:permits>
                                                                        <cc:requires
                                                                            rdf:resource="http://creativecommons.org/ns#Notice">
                                                                        </cc:requires>
                                                                        <cc:requires
                                                                            rdf:resource="http://creativecommons.org/ns#Attribution">
                                                                        </cc:requires>
                                                                        <cc:permits
                                                                            rdf:resource="http://creativecommons.org/ns#DerivativeWorks">
                                                                        </cc:permits>
                                                                        <cc:requires
                                                                            rdf:resource="http://creativecommons.org/ns#ShareAlike">
                                                                        </cc:requires>
                                                                    </cc:license>
                                                                </rdf:rdf>
                                                            </metadata>
                                                            <g inkscape:label="Capa 1" inkscape:groupmode="layer"
                                                                id="layer1" transform="translate(0 -1030.362)">
                                                                <path
                                                                    style="fill:#ffc35a;fill-opacity:1;stroke:none;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
                                                                    d="m11 1032.362-10 18h20zm0 2 8 15H3z"
                                                                    id="path839" inkscape:connector-curvature="0"
                                                                    sodipodi:nodetypes="cccccccc"></path>
                                                                <path
                                                                    style="fill:#373737;fill-opacity:.94117647;stroke:none;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
                                                                    d="M10 1046.362h2v2h-2z" id="path844"
                                                                    inkscape:connector-curvature="0"></path>
                                                                <path
                                                                    style="fill:#373737;fill-opacity:.94117647;stroke:none;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
                                                                    d="M10 1045.362h2v-6h-2z" id="path846"
                                                                    inkscape:connector-curvature="0"
                                                                    sodipodi:nodetypes="ccccc"></path>
                                                            </g>
                                                        </g>
                                                    </svg>
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
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Filtra por instrumento:') }}</h2>
                <a href="{{ route('users.index') }}">
                    <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M15 15L21 21M21 15L15 21M10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L17 11"
                                stroke="#b2843e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </g>
                    </svg>
                </a>
            </div>

            <div class="flex flex-wrap justify-center bg-white py-4 px-6">
                @foreach ($instruments as $instrument)
                    <a href="{{ route('users.index', ['instrument_id' => $instrument->id]) }}"
                        class="relative group flex items-center mb-2 mr-4 rounded-md">
                        <img class="w-8 h-8 rounded-full"
                            src="{{ asset('/storage/imagenes/instruments/' . $instrument->icon) }}"
                            alt="{{ $instrument->name }}">
                        <div class="absolute inset-0 bg-gray-900 opacity-50 rounded-md"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-white text-xs font-bold">{{ $instrument->users_count }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
    <div style="height: 75px">

    </div>

    <footer
        class="fixed bottom-0 left-0 z-20 w-full bg-white border-t border-gray-300 shadow dark:bg-gray-800 dark:border-gray-600">
        <div class="flex justify-around items-center px-6 py-3">

            <a href="{{ route('users.index') }}"
                class="flex flex-col items-center text-gray-700 hover:text-yellow-600 dark:text-gray-300 dark:hover:text-yellow-400 transition">
                <svg width="32px" height="32px" viewBox="0 0 1024 1024" class="icon" version="1.1"
                    xmlns="http://www.w3.org/2000/svg" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M618.666667 490.666667H405.333333L149.333333 192h725.333334z" fill="#F57C00"></path>
                        <path
                            d="M618.666667 810.666667l-213.333334 128V490.666667h213.333334zM885.333333 192h-746.666666C121.6 192 106.666667 177.066667 106.666667 160S121.6 128 138.666667 128h746.666666c17.066667 0 32 14.933333 32 32S902.4 192 885.333333 192z"
                            fill="#FF9800"></path>
                        <path
                            d="M810.666667 810.666667m-213.333334 0a213.333333 213.333333 0 1 0 426.666667 0 213.333333 213.333333 0 1 0-426.666667 0Z"
                            fill="#F44336"></path>
                        <path d="M682.666667 768h256v85.333333H682.666667z" fill="#FFFFFF"></path>
                    </g>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Borrar Filtros') }}</span>
            </a>

            <a href="{{ route('users.index', ['padres' => 1]) }}"
                class="flex flex-col items-center text-gray-700 hover:text-yellow-600 dark:text-gray-300 dark:hover:text-yellow-400 transition">
                <svg height="32px" width="32px" version="1.1" id="_x36_" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                    fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g>
                            <path style="fill:#646363;"
                                d="M468.125,128.73C304.284,99.474,234.069,0,234.069,0S163.847,99.474,0.013,128.73 c0,64.367-5.858,277.944,234.056,383.27C473.976,406.675,468.125,193.098,468.125,128.73z">
                            </path>
                            <path style="fill:#EAEEBE;"
                                d="M234.069,466.88C63.977,384.073,43.61,240.378,41.255,161.786 c95.349-23.792,158.067-69.25,192.814-101.558c34.747,32.308,97.458,77.766,192.807,101.558 C424.528,240.378,404.155,384.073,234.069,466.88z">
                            </path>
                            <path style="fill:#F0C57B;"
                                d="M410.284,169.867c-1.813,70.95-19.134,203.716-176.215,279.583 c-29.05-14.015-53.306-29.989-73.582-47.191c-27.411-23.173-47.513-48.568-62.293-74.285 c-33.346-58.164-39.32-118.025-40.346-158.106c88.156-21.531,145.384-63.78,176.221-92.92 c15.328,14.483,37.185,32.21,66.118,49.035c26.16,15.183,58.132,29.637,96.284,40.256 C400.981,167.525,405.6,168.725,410.284,169.867z">
                            </path>
                            <g>
                                <path style="fill:#716363;"
                                    d="M234.069,76.947c-30.837,29.14-88.066,71.389-176.221,92.92 c0.613,23.74,3.007,54.442,11.742,87.595h164.48V76.947z">
                                </path>
                                <path style="opacity:0.26;fill:#F1891A;"
                                    d="M396.472,166.238c-38.152-10.618-70.124-25.073-96.284-40.256 c-28.934-16.825-50.79-34.552-66.118-49.035v180.515h164.506c8.748-33.153,11.103-63.841,11.709-87.595 C405.6,168.725,400.981,167.525,396.472,166.238z">
                                </path>
                                <path style="opacity:0.26;fill:#F1891A;"
                                    d="M69.589,257.462c6.012,22.824,15.011,46.8,28.604,70.512 c14.78,25.718,34.882,51.113,62.293,74.285c20.276,17.202,44.532,33.176,73.582,47.191V257.462H69.589z">
                                </path>
                                <path style="fill:#716363;"
                                    d="M234.069,449.449c104.49-50.468,147.133-126.108,164.506-191.988H234.069V449.449z">
                                </path>
                            </g>
                            <path style="opacity:0.08;fill:#231815;"
                                d="M234.069,0c0,0,70.215,99.474,234.056,128.73c0,64.367,5.851,277.944-234.056,383.27V0 z">
                            </path>
                        </g>
                    </g>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Mostrar padres') }}</span>
            </a>

            <!-- Botón Mostrar Forasters -->
            <button type="button" id="mostrarForasters"
                class="flex flex-col items-center text-gray-700 hover:text-yellow-600 dark:text-gray-300 dark:hover:text-yellow-400 transition"
                onclick="mostrarForasters(this)">
                <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M17.5001 12C20.5377 12 23.0001 14.4624 23.0001 17.5C23.0001 20.5376 20.5377 23 17.5001 23C14.4626 23 12.0001 20.5376 12.0001 17.5C12.0001 14.4624 14.4626 12 17.5001 12ZM17.5001 19.751C17.1552 19.751 16.8756 20.0306 16.8756 20.3755C16.8756 20.7204 17.1552 21 17.5001 21C17.845 21 18.1246 20.7204 18.1246 20.3755C18.1246 20.0306 17.845 19.751 17.5001 19.751ZM17.5002 13.8741C16.4522 13.8741 15.6359 14.6915 15.6468 15.8284C15.6494 16.1045 15.8754 16.3262 16.1516 16.3236C16.4277 16.3209 16.6494 16.0949 16.6467 15.8188C16.6412 15.2398 17.0064 14.8741 17.5002 14.8741C17.9725 14.8741 18.3536 15.266 18.3536 15.8236C18.3536 16.0158 18.2983 16.1659 18.1296 16.3851L18.0356 16.501L17.9366 16.6142L17.6712 16.9043L17.5348 17.0615C17.1515 17.5182 17.0002 17.854 17.0002 18.3716C17.0002 18.6477 17.224 18.8716 17.5002 18.8716C17.7763 18.8716 18.0002 18.6477 18.0002 18.3716C18.0002 18.1684 18.0587 18.0126 18.239 17.7813L18.3239 17.6772L18.4249 17.5618L18.6906 17.2713L18.8252 17.1162C19.2035 16.6654 19.3536 16.333 19.3536 15.8236C19.3536 14.7199 18.5312 13.8741 17.5002 13.8741ZM12.0224 13.9993C11.7257 14.4626 11.4862 14.966 11.3137 15.4996L4.25254 15.4999C3.83895 15.4999 3.50366 15.8352 3.50366 16.2488V16.8265C3.50366 17.3622 3.69477 17.8802 4.04263 18.2876C5.29594 19.7553 7.26182 20.5011 10.0001 20.5011C10.5966 20.5011 11.1564 20.4657 11.6804 20.3952C11.9255 20.8901 12.2331 21.3486 12.5919 21.7615C11.7964 21.9217 10.9315 22.0011 10.0001 22.0011C6.85426 22.0011 4.46825 21.0959 2.90194 19.2617C2.32218 18.5828 2.00366 17.7193 2.00366 16.8265V16.2488C2.00366 15.0068 3.01052 13.9999 4.25254 13.9999L12.0224 13.9993ZM10.0001 2.00464C12.7615 2.00464 15.0001 4.24321 15.0001 7.00464C15.0001 9.76606 12.7615 12.0046 10.0001 12.0046C7.2387 12.0046 5.00012 9.76606 5.00012 7.00464C5.00012 4.24321 7.2387 2.00464 10.0001 2.00464ZM10.0001 3.50464C8.06712 3.50464 6.50012 5.07164 6.50012 7.00464C6.50012 8.93764 8.06712 10.5046 10.0001 10.5046C11.9331 10.5046 13.5001 8.93764 13.5001 7.00464C13.5001 5.07164 11.9331 3.50464 10.0001 3.50464Z"
                            fill="#7f7834"></path>
                    </g>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Mostrar forasters') }}</span>
            </button>

            <!-- Botón Nou Music -->
            <a href="{{ route('users.create') }}"
                class="flex flex-col items-center text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 transition">
                <svg width="32px" height="32px" viewBox="0 0 24 24" version="1.1"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                        <title>ic_fluent_person_add_24_regular</title>
                        <desc>Created with Sketch.</desc>
                        <g id="🔍-System-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="ic_fluent_person_add_24_regular" fill="#0c6600" fill-rule="nonzero">
                                <path
                                    d="M17.5,12 C20.5376,12 23,14.4624 23,17.5 C23,20.5376 20.5376,23 17.5,23 C14.4624,23 12,20.5376 12,17.5 C12,14.4624 14.4624,12 17.5,12 Z M12.0223,13.9993 C11.7256,14.4626 11.486,14.966 11.3136,15.4996 L4.25242,15.4999 C3.83882,15.4999 3.50354,15.8352 3.50354,16.2488 L3.50354,16.8265 C3.50354,17.3622 3.69465,17.8802 4.04251,18.2876 C5.29582,19.7553 7.2617,20.5011 10,20.5011 C10.5964,20.5011 11.1563,20.4657 11.6802,20.3952 C11.9254,20.8901 12.233,21.3486 12.5917,21.7615 C11.7962,21.9217 10.9314,22.0011 10,22.0011 C6.85414,22.0011 4.46812,21.0959 2.90182,19.2617 C2.32206,18.5828 2.00354,17.7193 2.00354,16.8265 L2.00354,16.2488 C2.00354,15.0068 3.0104,13.9999 4.25242,13.9999 L12.0223,13.9993 Z M17.5,14 L17.4101,14.0081 C17.206,14.0451 17.0451,14.206 17.0081,14.4101 L17,14.5 L16.999,17 L14.5039,17 L14.414,17.0081 C14.2099,17.0451 14.049,17.206 14.012,17.4101 L14.0039,17.5 L14.012,17.5899 C14.049,17.794 14.2099,17.9549 14.414,17.992 L14.5039,18 L16.999,18 L17,20.5 L17.0081,20.5899 C17.0451,20.794 17.206,20.9549 17.4101,20.9919 L17.5,21 L17.5899,20.9919 C17.794,20.9549 17.9549,20.794 17.9919,20.5899 L18,20.5 L17.999,18 L20.5039,18 L20.5938,17.992 C20.7979,17.9549 20.9588,17.794 20.9958,17.5899 L21.0039,17.5 L20.9958,17.4101 C20.9588,17.206 20.7979,17.0451 20.5938,17.0081 L20.5039,17 L17.999,17 L18,14.5 L17.9919,14.4101 C17.9549,14.206 17.794,14.0451 17.5899,14.0081 L17.5,14 Z M10,2.00464 C12.7614,2.00464 15,4.24321 15,7.00464 C15,9.76606 12.7614,12.0046 10,12.0046 C7.23857,12.0046 5,9.76606 5,7.00464 C5,4.24321 7.23857,2.00464 10,2.00464 Z M10,3.50464 C8.067,3.50464 6.5,5.07164 6.5,7.00464 C6.5,8.93764 8.067,10.5046 10,10.5046 C11.933,10.5046 13.5,8.93764 13.5,7.00464 C13.5,5.07164 11.933,3.50464 10,3.50464 Z"
                                    id="🎨-Color"> </path>
                            </g>
                        </g>
                    </g>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Nou music') }}</span>
            </a>

        </div>
    </footer>



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

            if (boton.textContent.trim() === '{{ __('Mostrar forasters') }}') {
                boton.textContent = '{{ __('Ocultar forasters') }}';
            } else {
                boton.textContent = '{{ __('Mostrar forasters') }}';
            }
        }
    </script>
</x-app-layout>
