@php
    use App\Helpers\ConfigHelper;
@endphp

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 py-2 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="{{ route('actuacion.index') }}" :active="request()->routeIs('actuacion.index')">
                        {{ __('Calendari') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                    {{ __('La meva activitat') }}
                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-60 px-4 m-2">                               
                                <x-nav-link href="{{ route('actuaciones.usuario.anyo', [Auth::user()->id, date('Y')]) }}">
                                    {{__('Les meves actuacions')}}
                                </x-nav-link>
                            </div>
                            <div class="w-60 px-4  m-2">                               
                                <x-nav-link href="{{ route('payments.user', [Auth::user()->id]) }}">
                                    {{__('Els meus pagaments')}}
                                </x-nav-link>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>


                @can('admin')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ __('Administracion') }}
                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>
    
                            <x-slot name="content">
                                <div class="w-60 px-4 m-2">                               
                                    <x-nav-link href="{{ route('tipoactuacion.index') }}" :active="request()->routeIs('tipoactuacion.index')">
                                        {{ __('Tipus de actuacio') }}
                                    </x-nav-link>
                                </div>
                                <div class="w-60 px-4 m-2">                               
                                    <x-nav-link href="{{ route('instrument.index') }}" :active="request()->routeIs('instrument.index')">
                                        {{ __('Instruments') }}
                                    </x-nav-link>
                                </div>
                                <div class="w-60 px-4 m-2">                               
                                    <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                                        {{ __('Musics') }}
                                    </x-nav-link>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                <div class="w-60 px-4 m-2">                               
                                    <x-nav-link href="{{ route('contratos.index') }}" :active="request()->routeIs('contratos.index')">
                                        {{ __('Contractes') }}
                                    </x-nav-link>
                                </div>
                                <div class="w-60 px-4 m-2">                               
                                    <x-nav-link href="{{ route('payments.index') }}" :active="request()->routeIs('payments.index')">
                                        {{ __('Comptes') }}
                                    </x-nav-link>
                                </div>
                                <div class="w-60 px-4 m-2">                               
                                    <x-nav-link href="{{ route('paymentresumes.index') }}" :active="request()->routeIs('paymentresumes.index')">
                                        {{ __('Resums comptes') }}
                                    </x-nav-link>
                                </div>

                                @if (ConfigHelper::getConfigValue('enableusermessages') === 'true')
                                <div class="w-60 px-4 m-2">                               
                                    <x-nav-link href="{{ route('comments.index') }}" :active="request()->routeIs('comments.index')">
                                        {{ __('Comentaris') }}
                                    </x-nav-link>
                                </div>
                                @endif


                                @can('SuperAdmin')
                                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                <div class="w-60 px-4 m-2">                               
                                    <x-nav-link href="/configurations">
                                        {{ __('Configuracion') }}
                                    </x-nav-link>
                                </div>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    </div>

                @endcan              


            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                {{-- 
                <div x-data="window.themeSwitcher()" x-init="switchTheme()" @keydown.window.tab="switchOn = false"
                    class="flex items-center justify-center space-x-2">
                    <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn">

                    <button x-ref="switchButton" type="button" @click="switchOn = ! switchOn; switchTheme()"
                        :class="switchOn ? 'bg-blue-600' : 'bg-neutral-200'"
                        class="relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10">
                        <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'"
                            class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
                    </button>

                    <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
                        :class="{ 'text-blue-600': switchOn, 'text-gray-400': !switchOn }" class="text-sm select-none">
                        Dark Mode
                    </label>
                </div>
                --}}

                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('auth.manageaccount') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('auth.miperfil') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('selecciona idioma') }}
                            </div>

                            <div class="grid grid-cols-2 justify-center items-center gap-4">
                                @if (App::getLocale()!='ca_VL')
                                <x-responsive-nav-link href="/greeting/ca_VL">
                                    <span class="fi fi-es-ct"></span>
                                </x-responsive-nav-link>                      
                                    
                                @endif
                               
                                @if (App::getLocale()!='es')
                                <x-responsive-nav-link href="/greeting/es">
                                    <span class="fi fi-es"></span>
                                </x-responsive-nav-link>
                                @endif
                               
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('auth.logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>


        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">

            {{-- 
            <div x-data="window.themeSwitcher()" x-init="switchTheme()" @keydown.window.tab="switchOn = false"
                class="flex items-center justify-center space-x-2">
                <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn">

                <button x-ref="switchButton" type="button" @click="switchOn = ! switchOn; switchTheme()"
                    :class="switchOn ? 'bg-blue-600' : 'bg-neutral-200'"
                    class="relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10">
                    <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'"
                        class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
                </button>

                <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
                    :class="{ 'text-blue-600': switchOn, 'text-gray-400': !switchOn }" class="text-sm select-none">
                    Dark Mode
                </label>
            </div>
            --}}

            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Mi perfil') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('actuacion.index') }}" :active="request()->routeIs('actuacion.index')">
                    {{ __('Calendari') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif


                @can('admin')
                    <div class="border-t border-gray-200 dark:border-gray-600"></div>
                    <x-responsive-nav-link href="{{ route('instrument.index') }}" :active="request()->routeIs('instrument.index')">
                        {{ __('Instruments') }}
                    </x-responsive-nav-link>
                 
                    <x-responsive-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                        {{ __('Musics') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('tipoactuacion.index') }}" :active="request()->routeIs('tipoactuacion.index')">
                        {{ __('Tipus de actuacio') }}
                    </x-responsive-nav-link>
                    
                    @if (ConfigHelper::getConfigValue('enableusermessages') === 'true')
                    <x-responsive-nav-link href="{{ route('comments.index') }}" :active="request()->routeIs('comments.index')">
                        {{ __('Comentaris') }}
                    </x-responsive-nav-link>  
                    @endif
                    
                @endcan

                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                @can('admin')
                    <x-responsive-nav-link href="{{ route('contratos.index') }}" :active="request()->routeIs('contratos.index')">
                        {{ __('Contractes') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('payments.index') }}" :active="request()->routeIs('payments.index')">
                        {{ __('Comptes') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('paymentresumes.index') }}" :active="request()->routeIs('paymentresumes.index')">
                        {{ __('Resums comptes') }}
                    </x-responsive-nav-link>                                 
                @endcan

                @can('SuperAdmin')
                    <x-responsive-nav-link href="/configurations">
                        {{ __('Configuracion') }}
                    </x-responsive-nav-link>    
                @endcan  

                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('selecciona idioma') }}
                </div>

                <div class="grid grid-cols-2 justify-center items-center gap-4">
                    @if (App::getLocale()!='ca_VL')
                    <x-responsive-nav-link href="/greeting/ca_VL">
                        <span class="fi fi-es-ct"></span>
                    </x-responsive-nav-link>                      
                        
                    @endif
                   
                    @if (App::getLocale()!='es')
                    <x-responsive-nav-link href="/greeting/es">
                        <span class="fi fi-es"></span>
                    </x-responsive-nav-link>
                    @endif
                   
                </div>


                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200 dark:border-gray-600"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif

                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('La meva activitat') }}
                </div>
               
                <x-responsive-nav-link href="{{ route('actuaciones.usuario.anyo', [Auth::user()->id, date('Y')]) }}"
                    :active="request()->routeIs('actuaciones.usuario.anyo')">
                    {{ __('Les meves actuacions') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link  href="{{ route('payments.user', [Auth::user()->id]) }}"
                    :active="request()->routeIs('payments.user')">
                    {{__('Els meus pagaments')}}
                </x-responsive-nav-link>


                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>


            </div>
        </div>
    </div>
</nav>
