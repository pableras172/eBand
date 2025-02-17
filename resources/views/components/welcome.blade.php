<div class="p-3 lg:p-4 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
    <h1 class="mt-4 text-2xl font-medium text-gray-900 dark:text-white">
        {{__('Hola')}}&nbsp;{{Auth::user()->name}},&nbsp;{{__('common.bienvenido_titulo')}} - {{config('app.banda', '')}}
    </h1>   
</div>

<div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
    @can('admin')
    <div>
        <div class="flex items-center">
            <svg width="64px" height="64px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs> <style>.cls-1{fill:none;stroke:#e2a240;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style> </defs> <title></title> <g data-name="79-users" id="_79-users"> <circle class="cls-1" cx="16" cy="13" r="5"></circle> <path class="cls-1" d="M23,28A7,7,0,0,0,9,28Z"></path> <path class="cls-1" d="M24,14a5,5,0,1,0-4-8"></path> <path class="cls-1" d="M25,24h6a7,7,0,0,0-7-7"></path> <path class="cls-1" d="M12,6a5,5,0,1,0-4,8"></path> <path class="cls-1" d="M8,17a7,7,0,0,0-7,7H7"></path> </g> </g></svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900 dark:text-white">
                <a href="{{ route('users.index') }}">{{__('common.listado_musicos_titulo')}}</a>
            </h2>
        </div>

        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            {{__('common.listado_musicos_descripcion')}}
        </p>

        <p class="mt-4 text-sm">
            <a href="{{ route('users.index') }}" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                {{__('common.listado_musicos_ver')}}

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500 dark:fill-indigo-200">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </a>
        </p>
    </div>
    @endcan
    @can('admin')
    <div>
        <div class="flex items-center">
            <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0905 11.9629L19.3632 8.63087L20.9996 7.95235V7.49236C20.9996 6.37238 20.9996 5.4331 20.9118 4.68472C20.8994 4.57895 20.8848 4.4738 20.8686 4.37569C20.7841 3.86441 20.6348 3.38745 20.3465 2.98917C20.2024 2.79002 20.0235 2.61055 19.8007 2.45628C19.7589 2.42736 19.7156 2.39932 19.6707 2.3722L19.6617 2.36679C18.8901 1.90553 18.0228 1.93852 17.1293 2.14305C16.2652 2.34086 15.194 2.74368 13.8803 3.23763L11.5959 4.09656C10.9801 4.32806 10.4584 4.52419 10.049 4.72734C9.61332 4.94348 9.23805 5.1984 8.95662 5.57828C8.67519 5.95817 8.55831 6.36756 8.50457 6.81203C8.45406 7.22978 8.45408 7.7378 8.4541 8.33743V12.6016L10.0905 11.9629Z" fill="#ffc46c"></path> <g opacity="0.5"> <path d="M8.45455 16.1305C7.90347 15.8136 7.24835 15.6298 6.54545 15.6298C4.58735 15.6298 3 17.0558 3 18.8148C3 20.5738 4.58735 21.9998 6.54545 21.9998C8.50355 21.9998 10.0909 20.5738 10.0909 18.8148L10.0909 11.9627L8.45455 12.6014V16.1305Z" fill="#ffc46c"></path> <path d="M19.3636 8.63067V14.1705C18.8126 13.8536 18.1574 13.6698 17.4545 13.6698C15.4964 13.6698 13.9091 15.0958 13.9091 16.8548C13.9091 18.6138 15.4964 20.0398 17.4545 20.0398C19.4126 20.0398 21 18.6138 21 16.8548L21 7.95215L19.3636 8.63067Z" fill="#ffc46c"></path> </g> </g></svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900 dark:text-white">
                <a href="{{ route('instrument.index') }}" > {{__('common.instrumentos')}}</a>
            </h2>
        </div>

        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            {{__('common.instrumentos_descripcion')}}
        </p>
        <p class="mt-4 text-sm">
            <a href="{{ route('instrument.index') }}"  class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                {{__('common.instrumentos_listado_ver')}}

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500 dark:fill-indigo-200">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </a>
        </p>
    </div>
    @endcan
    <div>
        <div class="flex items-center">
            <svg width="64px" height="64px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M182.067 383.79h664.916v473.911H182.067z" fill="#FCE3C3"></path><path d="M846.983 857.701H170.007V401.632h676.976v456.069zM189.428 838.28h638.134V421.053H189.428V838.28z" fill="#ffc46c"></path><path d="M850.483 861.201H166.507V398.132h683.977v463.069z m-676.976-7h669.977V405.132H173.507v449.069z m657.555-12.421H185.929V417.553h645.134V841.78z m-638.133-7h631.134V424.553H192.929V834.78z" fill="#ffc46c"></path><path d="M179.718 273.282h657.556v138.061H179.718z" fill="#ffc46c"></path><path d="M840.774 414.844H176.219V269.782h664.556v145.062z m-657.555-7h650.556V276.782H183.219v131.062z" fill="#ffc46c"></path><path d="M846.983 421.053H170.007V263.572h676.976v157.481z m-657.555-19.421h638.134V282.994H189.428v118.638z" fill="#ffc46c"></path><path d="M850.483 424.553H166.507v-164.48h683.977v164.48z m-676.976-7h669.977v-150.48H173.507v150.48z m657.555-12.421H185.929V279.494h645.134v125.638z m-638.133-7h631.134V286.494H192.929v111.638z" fill="#ffc46c"></path><path d="M672.215 190.225h63.426v162.87h-63.426z" fill="#ED8F27"></path><path d="M745.351 362.806h-82.847V180.514h82.847v182.292z m-63.426-19.421h44.005v-143.45h-44.005v143.45z" fill="#ffc46c"></path><path d="M281.351 190.225h63.426v162.87h-63.426z" fill="#ED8F27"></path><path d="M354.487 362.806H271.64V180.514h82.847v182.292z m-63.426-19.421h44.005v-143.45h-44.005v143.45z" fill="#ffc46c"></path><path d="M688.071 468.427h66.597v66.597h-66.597z" fill="#B12800"></path><path d="M688.071 596.369h66.597v66.597h-66.597zM688.071 724.31h66.597v66.598h-66.597zM546.156 468.427h66.597v66.597h-66.597z" fill="#228E9D"></path><path d="M546.156 596.369h66.597v66.597h-66.597z" fill="#B12800"></path><path d="M546.156 724.31h66.597v66.598h-66.597zM404.239 468.427h66.598v66.597h-66.598z" fill="#228E9D"></path><path d="M404.239 596.369h66.598v66.597h-66.598z" fill="#B12800"></path><path d="M404.239 724.31h66.598v66.598h-66.598zM262.323 596.369h66.598v66.597h-66.598z" fill="#228E9D"></path><path d="M262.323 724.31h66.598v66.598h-66.598z" fill="#B12800"></path></g></svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900 dark:text-white">
                <a href="{{ route('actuacion.index') }}" >  {{__('common.calendario')}}</a>
            </h2>            
        </div>

        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            {{__('common.calendario_descripcion')}}
        </p>
        <p class="mt-4 text-sm">
            <a href="{{ route('actuacion.index') }}" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                {{__('common.calendario_var')}}

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500 dark:fill-indigo-200">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </a>
        </p>
    </div>

    
    <div>
        <div class="flex items-center">
            <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffbd59"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3.29289 9.29289C3 9.58579 3 10.0572 3 11V17C3 17.9428 3 18.4142 3.29289 18.7071C3.58579 19 4.05719 19 5 19C5.94281 19 6.41421 19 6.70711 18.7071C7 18.4142 7 17.9428 7 17V11C7 10.0572 7 9.58579 6.70711 9.29289C6.41421 9 5.94281 9 5 9C4.05719 9 3.58579 9 3.29289 9.29289Z" fill="#1C274C"></path> <path opacity="0.4" d="M17.2929 2.29289C17 2.58579 17 3.05719 17 4V17C17 17.9428 17 18.4142 17.2929 18.7071C17.5858 19 18.0572 19 19 19C19.9428 19 20.4142 19 20.7071 18.7071C21 18.4142 21 17.9428 21 17V4C21 3.05719 21 2.58579 20.7071 2.29289C20.4142 2 19.9428 2 19 2C18.0572 2 17.5858 2 17.2929 2.29289Z" fill="#1C274C"></path> <path opacity="0.7" d="M10 7C10 6.05719 10 5.58579 10.2929 5.29289C10.5858 5 11.0572 5 12 5C12.9428 5 13.4142 5 13.7071 5.29289C14 5.58579 14 6.05719 14 7V17C14 17.9428 14 18.4142 13.7071 18.7071C13.4142 19 12.9428 19 12 19C11.0572 19 10.5858 19 10.2929 18.7071C10 18.4142 10 17.9428 10 17V7Z" fill="#1C274C"></path> <path d="M3 21.25C2.58579 21.25 2.25 21.5858 2.25 22C2.25 22.4142 2.58579 22.75 3 22.75H21C21.4142 22.75 21.75 22.4142 21.75 22C21.75 21.5858 21.4142 21.25 21 21.25H3Z" fill="#1C274C"></path> </g></svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900 dark:text-white">
                <a href="{{ route('actuaciones.usuario.anyo', [Auth::user()->id, date('Y')]) }}" >  {{__('common.mis_listados')}}</a>
            </h2>            
        </div>

        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            {{__('common.mis_listados_text')}}
        </p>
        <p class="mt-4 text-sm">
            <a href="{{ route('actuaciones.usuario.anyo', [Auth::user()->id, date('Y')]) }}" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                {{__('common.ver_mislistas')}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500 dark:fill-indigo-200">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </a>
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <svg width="64px" height="64px" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M38.87 27.571C38.8647 25.6242 38.0883 23.7587 36.7108 22.3831C35.3333 21.0074 33.4668 20.2336 31.52 20.231C29.5748 20.2357 27.7106 21.0106 26.3351 22.386C24.9596 23.7615 24.1847 25.6257 24.18 27.571C24.1826 29.5178 24.9565 31.3842 26.3322 32.7617C27.7078 34.1393 29.5732 34.9157 31.52 34.921C33.4684 34.9178 35.336 34.1424 36.7137 32.7647C38.0914 31.387 38.8668 29.5193 38.87 27.571Z" fill="#eeac49"></path> <path d="M32.39 38.921H30.65C27.3861 38.9239 24.2567 40.2218 21.9487 42.5298C19.6408 44.8377 18.3429 47.9671 18.34 51.231V57.601H44.7V51.231C44.6971 47.9671 43.3992 44.8377 41.0913 42.5298C38.7833 40.2218 35.6539 38.9239 32.39 38.921Z" fill="#eeac49"></path> <path d="M51.52 5.60095H11.52C9.92869 5.60095 8.40256 6.23309 7.27734 7.35831C6.15213 8.48353 5.51999 10.0097 5.51999 11.601V51.601C5.51999 53.1922 6.15213 54.7184 7.27734 55.8436C8.40256 56.9688 9.92869 57.601 11.52 57.601H14.34V51.231C14.3425 48.0404 15.2795 44.9205 17.0354 42.2565C18.7912 39.5925 21.2889 37.5013 24.22 36.2409C22.9529 35.1797 21.9344 33.8531 21.2363 32.355C20.5382 30.8569 20.1776 29.2237 20.18 27.571C20.1845 24.5648 21.3807 21.683 23.5064 19.5573C25.6321 17.4316 28.5138 16.2355 31.52 16.231C34.5277 16.2333 37.4118 17.4285 39.5395 19.5544C41.6672 21.6802 42.865 24.5632 42.87 27.571C42.8724 29.2237 42.5118 30.8569 41.8137 32.355C41.1156 33.8531 40.0971 35.1797 38.83 36.2409C41.7587 37.5034 44.2539 39.5955 46.0078 42.2592C47.7617 44.9229 48.6976 48.0417 48.7 51.231V57.601H51.52C53.1113 57.601 54.6374 56.9688 55.7626 55.8436C56.8879 54.7184 57.52 53.1922 57.52 51.601V11.601C57.52 10.0097 56.8879 8.48353 55.7626 7.35831C54.6374 6.23309 53.1113 5.60095 51.52 5.60095Z" fill="#999999"></path> </g></svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900 dark:text-white">
                <a href="{{ route('profile.show') }}">Perfil</a>
            </h2>
        </div>

        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            {{__('common.perfil_descripcion')}}
        </p>

        <p class="mt-4 text-sm">
            <a href="{{ route('profile.show') }}"  class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                {{__('common.perfil_acceder')}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500 dark:fill-indigo-200">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </a>
        </p>
    </div>

</div>

<footer class="bg-white dark:bg-gray-900">
    <div class="container flex flex-col items-center justify-between p-6 mx-auto space-y-4 sm:space-y-0 sm:flex-row">
        <a href="/">
            <img style="width: 75px;" src="{{ URL::to('/') }}/imagenes/logo.png" />
          </a>

        <p class="text-sm text-gray-600 dark:text-gray-300">© Copyright 2025.</p>

        <div class="flex -mx-2">           

            <a href="#" class="mx-2 text-gray-600 transition-colors duration-300 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400" aria-label="Facebook">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2.00195 12.002C2.00312 16.9214 5.58036 21.1101 10.439 21.881V14.892H7.90195V12.002H10.442V9.80204C10.3284 8.75958 10.6845 7.72064 11.4136 6.96698C12.1427 6.21332 13.1693 5.82306 14.215 5.90204C14.9655 5.91417 15.7141 5.98101 16.455 6.10205V8.56104H15.191C14.7558 8.50405 14.3183 8.64777 14.0017 8.95171C13.6851 9.25566 13.5237 9.68693 13.563 10.124V12.002H16.334L15.891 14.893H13.563V21.881C18.8174 21.0506 22.502 16.2518 21.9475 10.9611C21.3929 5.67041 16.7932 1.73997 11.4808 2.01722C6.16831 2.29447 2.0028 6.68235 2.00195 12.002Z">
                    </path>
                </svg>
            </a>
            <a href="#" class="mx-2 text-gray-600 transition-colors duration-300 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400" aria-label="Instagram">
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81V16.18C2 19.83 4.17 22 7.81 22H16.18C19.82 22 21.99 19.83 21.99 16.19V7.81C22 4.17 19.83 2 16.19 2ZM12 15.88C9.86 15.88 8.12 14.14 8.12 12C8.12 9.86 9.86 8.12 12 8.12C14.14 8.12 15.88 9.86 15.88 12C15.88 14.14 14.14 15.88 12 15.88ZM17.92 6.88C17.87 7 17.8 7.11 17.71 7.21C17.61 7.3 17.5 7.37 17.38 7.42C17.26 7.47 17.13 7.5 17 7.5C16.73 7.5 16.48 7.4 16.29 7.21C16.2 7.11 16.13 7 16.08 6.88C16.03 6.76 16 6.63 16 6.5C16 6.37 16.03 6.24 16.08 6.12C16.13 5.99 16.2 5.89 16.29 5.79C16.52 5.56 16.87 5.45 17.19 5.52C17.26 5.53 17.32 5.55 17.38 5.58C17.44 5.6 17.5 5.63 17.56 5.67C17.61 5.7 17.66 5.75 17.71 5.79C17.8 5.89 17.87 5.99 17.92 6.12C17.97 6.24 18 6.37 18 6.5C18 6.63 17.97 6.76 17.92 6.88Z" fill="#4a4f54"></path> </g></svg>
            </a>            

        </div>
    </div>
</footer>