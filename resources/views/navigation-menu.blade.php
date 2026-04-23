@php
    use App\Helpers\ConfigHelper;
@endphp

<nav x-data="{ open: false, mobileAdminOpen: false, mobileActivityOpen: true }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50 shadow-md">
    

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
                                    class="inline-flex items-center rounded-md px-3 py-2 text-sm leading-4 font-medium transition ease-in-out duration-150 {{ request()->routeIs('actuaciones.usuario.anyo', 'payments.user', 'suggestions.index', 'inventory.index', 'inventory.show') ? 'border border-cyan-200 bg-cyan-50 text-cyan-700' : 'border border-transparent bg-white text-gray-500 hover:text-gray-700 focus:bg-gray-50 active:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300 dark:focus:bg-gray-700 dark:active:bg-gray-700' }}">
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
                            <div class="px-4 pt-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                {{ __('La meva activitat') }}
                            </div>
                            <div class="w-60 px-4 m-2">
                                <x-nav-link
                                    href="{{ route('actuaciones.usuario.anyo', [Auth::user()->id, date('Y')]) }}" :active="request()->routeIs('actuaciones.usuario.anyo')">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                        <span>{{ __('Les meves actuacions') }}</span>
                                    </div>
                                </x-nav-link>
                            </div>
                            <div class="w-60 px-4  m-2">
                                <x-nav-link href="{{ route('payments.user', [Auth::user()->id]) }}" :active="request()->routeIs('payments.user')">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        <span>{{ __('Els meus pagaments') }}</span>
                                    </div>
                                </x-nav-link>
                            </div>
                            <div class="w-60 px-4  m-2">
                                <x-nav-link href="{{ route('suggestions.index') }}" :active="request()->routeIs('suggestions.index')">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                        <span>{{ __('Mis sugerencias') }}</span>
                                    </div>
                                </x-nav-link>
                            </div>
                            <div class="w-60 px-4  m-2">
                                <x-nav-link href="{{ route('inventory.index') }}" :active="request()->routeIs('inventory.index', 'inventory.show')">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <span>{{ __('Inventario') }}</span>
                                    </div>
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
                                        class="inline-flex items-center rounded-md px-3 py-2 text-sm leading-4 font-medium transition ease-in-out duration-150 {{ request()->routeIs('tipoactuacion.*', 'instrument.*', 'users.*', 'contratos.*', 'payments.*', 'paymentresumes.*', 'comments.*', 'configurations*') ? 'border border-cyan-200 bg-cyan-50 text-cyan-700' : 'border border-transparent bg-white text-gray-500 hover:text-gray-700 focus:bg-gray-50 active:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300 dark:focus:bg-gray-700 dark:active:bg-gray-700' }}">
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
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <span>{{ __('Tipus de actuacio') }}</span>
                                        </div>
                                    </x-nav-link>
                                </div>
                                <div class="w-60 px-4 m-2">
                                    <x-nav-link href="{{ route('instrument.index') }}" :active="request()->routeIs('instrument.index')">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                            </svg>
                                            <span>{{ __('Instruments') }}</span>
                                        </div>
                                    </x-nav-link>
                                </div>
                                <div class="w-60 px-4 m-2">
                                    <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <span>{{ __('Musics') }}</span>
                                        </div>
                                    </x-nav-link>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                <div class="w-60 px-4 m-2">
                                    <x-nav-link href="{{ route('contratos.index') }}" :active="request()->routeIs('contratos.index')">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>{{ __('Contractes') }}</span>
                                        </div>
                                    </x-nav-link>
                                </div>
                                <div class="w-60 px-4 m-2">
                                    <x-nav-link href="{{ route('payments.index') }}" :active="request()->routeIs('payments.index')">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span>{{ __('Comptes') }}</span>
                                        </div>
                                    </x-nav-link>
                                </div>
                                <div class="w-60 px-4 m-2">
                                    <x-nav-link href="{{ route('paymentresumes.index') }}" :active="request()->routeIs('paymentresumes.index')">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ __('Resums comptes') }}</span>
                                        </div>
                                    </x-nav-link>
                                </div>

                                <div class="w-60 px-4 m-2">
                                    <x-nav-link href="{{ route('suggestions.index') }}" :active="request()->routeIs('suggestions.index')">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                            <span>{{ __('Sugerencias') }}</span>
                                        </div>
                                    </x-nav-link>
                                </div>

                                <div class="w-60 px-4 m-2">
                                    <x-nav-link href="{{ route('inventory.index') }}" :active="request()->routeIs('inventory.index', 'inventory.create', 'inventory.edit', 'inventory.show')">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            <span>{{ __('Inventario') }}</span>
                                        </div>
                                    </x-nav-link>
                                </div>

                                @if (ConfigHelper::getConfigValue('enableusermessages') === 'true')
                                    <div class="w-60 px-4 m-2">
                                        <x-nav-link href="{{ route('comments.index') }}" :active="request()->routeIs('comments.index')">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                </svg>
                                                <span>{{ __('Comentaris') }}</span>
                                            </div>
                                        </x-nav-link>
                                    </div>
                                @endif


                                @can('SuperAdmin')
                                    <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                    <div class="w-60 px-4 m-2">
                                        <x-nav-link href="/configurations">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span>{{ __('Configuracion') }}</span>
                                            </div>
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
                                        src="{{ Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                             
                            @auth
                                {{-- 
                                <a href="{{ route('notifications.index') }}" class="relative inline-block">
                                    🔔

                                    @if (auth()->user()->unreadNotifications->count())
                                        <span
                                            style="
                                    position:absolute;
                                    top:-5px;
                                    right:-8px;
                                    background:red;
                                    color:white;
                                    font-size:10px;
                                    border-radius:50%;
                                    padding:2px 6px;
                                ">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </a>
                                --}}
                             @endauth
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
                                @if (App::getLocale() != 'ca_VL')
                                    <x-responsive-nav-link href="/greeting/ca_VL">
                                        <span class="fi fi-es-ct"></span>
                                    </x-responsive-nav-link>
                                @endif

                                @if (App::getLocale() != 'es')
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
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white dark:bg-gray-800 max-h-[80vh] overflow-y-auto">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>{{ __('Dashboard') }}</span>
                </div>
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
                @auth
                    <a href="{{ route('notifications.index') }}" class="relative inline-block ml-4">
                        🔔
                        @if (auth()->user()->unreadNotifications->count())
                            <span
                                style="position:absolute; top:-5px; right:-8px; background:red; color:white; font-size:10px; border-radius:50%; padding:2px 6px;">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                @endauth
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>{{ __('Mi perfil') }}</span>
                    </div>
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('actuacion.index') }}" :active="request()->routeIs('actuacion.index')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ __('Calendari') }}</span>
                    </div>
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('suggestions.index') }}" :active="request()->routeIs('suggestions.index')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <span>{{ __('Sugerencias') }}</span>
                    </div>
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('inventory.index') }}" :active="request()->routeIs('inventory.index', 'inventory.show')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span>{{ __('Inventario') }}</span>
                    </div>
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif


                @can('admin')
                    <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                    <button type="button" @click="mobileAdminOpen = !mobileAdminOpen"
                        class="flex w-full items-center justify-between px-4 py-2 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        <span>{{ __('Administracion') }}</span>
                        <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': mobileAdminOpen }" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.51a.75.75 0 01-1.08 0l-4.25-4.51a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="mobileAdminOpen" x-transition class="space-y-1">
                        <x-responsive-nav-link href="{{ route('instrument.index') }}" :active="request()->routeIs('instrument.index')">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                <span>{{ __('Instruments') }}</span>
                            </div>
                        </x-responsive-nav-link>

                        <x-responsive-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>{{ __('Musics') }}</span>
                            </div>
                        </x-responsive-nav-link>

                        <x-responsive-nav-link href="{{ route('tipoactuacion.index') }}" :active="request()->routeIs('tipoactuacion.index')">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span>{{ __('Tipus de actuacio') }}</span>
                            </div>
                        </x-responsive-nav-link>

                        @if (ConfigHelper::getConfigValue('enableusermessages') === 'true')
                            <x-responsive-nav-link href="{{ route('comments.index') }}" :active="request()->routeIs('comments.index')">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span>{{ __('Comentaris') }}</span>
                                </div>
                            </x-responsive-nav-link>
                        @endif
                    </div>
                @endcan

                <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>

                @can('admin')
                    <x-responsive-nav-link href="{{ route('contratos.index') }}" :active="request()->routeIs('contratos.index')">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>{{ __('Contratos') }}</span>
                        </div>
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('payments.index') }}" :active="request()->routeIs('payments.index')">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>{{ __('Comptes') }}</span>
                        </div>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('paymentresumes.index') }}" :active="request()->routeIs('paymentresumes.index')">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span>{{ __('Resums comptes') }}</span>
                        </div>
                    </x-responsive-nav-link>
                @endcan

                @can('SuperAdmin')
                    <x-responsive-nav-link href="/configurations">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ __('Configuracion') }}</span>
                        </div>
                    </x-responsive-nav-link>
                @endcan

                <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('selecciona idioma') }}
                </div>

                <div class="grid grid-cols-2 justify-center items-center gap-4">
                    @if (App::getLocale() != 'ca_VL')
                        <x-responsive-nav-link href="/greeting/ca_VL">
                            <span class="fi fi-es-ct"></span>
                        </x-responsive-nav-link>
                    @endif

                    @if (App::getLocale() != 'es')
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

                <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>

                <button type="button" @click="mobileActivityOpen = !mobileActivityOpen"
                    class="flex w-full items-center justify-between px-4 py-2 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    <span>{{ __('La meva activitat') }}</span>
                    <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': mobileActivityOpen }" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.51a.75.75 0 01-1.08 0l-4.25-4.51a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="mobileActivityOpen" x-transition class="space-y-1">
                    <x-responsive-nav-link href="{{ route('actuaciones.usuario.anyo', [Auth::user()->id, date('Y')]) }}"
                        :active="request()->routeIs('actuaciones.usuario.anyo')">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span>{{ __('Les meves actuacions') }}</span>
                        </div>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('payments.user', [Auth::user()->id]) }}" :active="request()->routeIs('payments.user')">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <span>{{ __('Els meus pagaments') }}</span>
                        </div>
                    </x-responsive-nav-link>
                </div>


                <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="text-red-600">{{ __('auth.logout') }}</span>
                        </div>
                    </x-responsive-nav-link>
                </form>


            </div>
        </div>
    </div>
</nav>
