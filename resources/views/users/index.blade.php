<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-br from-amber-400 to-orange-500 p-3 rounded-xl shadow-md">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Llistat de músics') }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $users->total() }} {{ __('músics registrats') }}</p>
            </div>
        </div>
    </x-slot>

    @if (request()->has('success') && request()->success)
        <div class="bg-green-200 text-green-800 py-2 px-4 mb-4 rounded">
            {{ __('Usuari creat') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto py-2 px-2 pb-28 sm:px-6 lg:px-8">

        {{-- FILTROS --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-4 mb-4">
            <form method="GET" action="{{ route('users.index') }}" id="filtros-form">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                    {{-- Nombre --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1 uppercase tracking-wide">
                            {{ __('Buscar per nom') }}
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="nombre" value="{{ $nombre }}"
                                placeholder="{{ __('Nom del músic...') }}"
                                class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    {{-- Instrumento --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1 uppercase tracking-wide">
                            {{ __('Instrument') }}
                        </label>
                        <select name="instrument_id" onchange="this.form.submit()"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">{{ __('Tots els instruments') }}</option>
                            @foreach ($instruments as $instrument)
                                <option value="{{ $instrument->id }}" @selected($instrument_id == $instrument->id)>
                                    {{ $instrument->name }} ({{ $instrument->users_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Activo / Inactivo --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1 uppercase tracking-wide">
                            {{ __('Estat') }}
                        </label>
                        <select name="activo" onchange="this.form.submit()"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">{{ __('Tots') }}</option>
                            <option value="1" @selected($activo === '1')>{{ __('Actius') }}</option>
                            <option value="0" @selected($activo === '0')>{{ __('Inactius') }}</option>
                        </select>
                    </div>

                </div>

                {{-- Acciones: buscar + limpiar --}}
                <div class="flex flex-wrap items-center gap-2 mt-3">
                    <button type="submit"
                        class="inline-flex items-center gap-1 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        {{ __('Buscar') }}
                    </button>

                    @if ($nombre || $instrument_id || ($activo !== null && $activo !== ''))
                        <a href="{{ route('users.index') }}"
                            class="inline-flex items-center gap-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-semibold rounded-lg shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('Netejar filtres') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- TABLA --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider w-12"></th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Nom') }}
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell">
                            {{ __('Email') }}
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell">
                            {{ __('Fecha Alta') }}
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell">
                            {{ __('Instrument') }}
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell">
                            {{ __('Actiu') }}
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Accions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($users as $user)
                        @php
                            $rowBg = match(true) {
                                $user->activo == 0 => 'bg-red-700 text-white',
                                $user->forastero == 1 => 'bg-gray-300 dark:bg-gray-600',
                                $user->hijos->isNotEmpty() => 'bg-amber-50 dark:bg-amber-900/20',
                                default => 'bg-white dark:bg-gray-800',
                            };
                        @endphp
                        <tr class="{{ $rowBg }} @if($user->forastero) hidden forastero-row @endif transition-colors">

                            {{-- Avatar --}}
                            <td class="px-3 py-3 whitespace-nowrap">
                                <div class="relative inline-block">
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                        class="h-10 w-10 rounded-full object-cover ring-2 ring-white dark:ring-gray-700 shadow">
                                    @if ($user->activo == 0)
                                        <span class="absolute -bottom-1 -right-1 bg-red-500 rounded-full w-3.5 h-3.5 border-2 border-white" title="{{ __('Inactiu') }}"></span>
                                    @elseif($user->hijos->isNotEmpty())
                                        <span class="absolute -bottom-1 -right-1 bg-amber-400 rounded-full w-3.5 h-3.5 border-2 border-white" title="{{ __('Pare/Mare') }}"></span>
                                    @else
                                        <span class="absolute -bottom-1 -right-1 bg-green-400 rounded-full w-3.5 h-3.5 border-2 border-white" title="{{ __('Actiu') }}"></span>
                                    @endif
                                </div>
                            </td>

                            {{-- Nom --}}
                            <td class="px-3 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium @if($user->activo == 0) text-white @else text-gray-900 dark:text-gray-100 @endif">
                                        {{ $user->name }}
                                    </span>
                                    @if ($user->hijos->isNotEmpty())
                                        <span title="{{ __('Pare/Mare') }}">
                                            <svg height="16px" width="16px" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path style="fill:#646363;" d="M468.125,128.73C304.284,99.474,234.069,0,234.069,0S163.847,99.474,0.013,128.73 c0,64.367-5.858,277.944,234.056,383.27C473.976,406.675,468.125,193.098,468.125,128.73z"/>
                                                <path style="fill:#EAEEBE;" d="M234.069,466.88C63.977,384.073,43.61,240.378,41.255,161.786 c95.349-23.792,158.067-69.25,192.814-101.558c34.747,32.308,97.458,77.766,192.807,101.558 C424.528,240.378,404.155,384.073,234.069,466.88z"/>
                                                <path style="fill:#716363;" d="M234.069,76.947c-30.837,29.14-88.066,71.389-176.221,92.92 c0.613,23.74,3.007,54.442,11.742,87.595h164.48V76.947z"/>
                                                <path style="fill:#716363;" d="M234.069,449.449c104.49-50.468,147.133-126.108,164.506-191.988H234.069V449.449z"/>
                                            </svg>
                                        </span>
                                    @endif
                                    <a href="{{ route('actuaciones.usuario.anyo', [$user->id, date('Y')]) }}"
                                        class="text-amber-500 hover:text-amber-700 transition" title="{{ __('Estadístiques') }}">
                                        <svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.29289 9.29289C3 9.58579 3 10.0572 3 11V17C3 17.9428 3 18.4142 3.29289 18.7071C3.58579 19 4.05719 19 5 19C5.94281 19 6.41421 19 6.70711 18.7071C7 18.4142 7 17.9428 7 17V11C7 10.0572 7 9.58579 6.70711 9.29289C6.41421 9 5.94281 9 5 9C4.05719 9 3.58579 9 3.29289 9.29289Z" fill="currentColor"/>
                                            <path opacity="0.4" d="M17.2929 2.29289C17 2.58579 17 3.05719 17 4V17C17 17.9428 17 18.4142 17.2929 18.7071C17.5858 19 18.0572 19 19 19C19.9428 19 20.4142 19 20.7071 18.7071C21 18.4142 21 17.9428 21 17V4C21 3.05719 21 2.58579 20.7071 2.29289C20.4142 2 19.9428 2 19 2C18.0572 2 17.5858 2 17.2929 2.29289Z" fill="currentColor"/>
                                            <path opacity="0.7" d="M10 7C10 6.05719 10 5.58579 10.2929 5.29289C10.5858 5 11.0572 5 12 5C12.9428 5 13.4142 5 13.7071 5.29289C14 5.58579 14 6.05719 14 7V17C14 17.9428 14 18.4142 13.7071 18.7071C13.4142 19 12.9428 19 12 19C11.0572 19 10.5858 19 10.2929 18.7071C10 18.4142 10 17.9428 10 17V7Z" fill="currentColor"/>
                                            <path d="M3 21.25C2.58579 21.25 2.25 21.5858 2.25 22C2.25 22.4142 2.58579 22.75 3 22.75H21C21.4142 22.75 21.75 22.4142 21.75 22C21.75 21.5858 21.4142 21.25 21 21.25H3Z" fill="currentColor"/>
                                        </svg>
                                    </a>
                                </div>
                                @if ($user->instrument)
                                    <p class="text-xs @if($user->activo == 0) text-red-200 @else text-gray-400 dark:text-gray-500 @endif mt-0.5 md:hidden">
                                        {{ $user->instrument->name }}
                                    </p>
                                @endif
                            </td>

                            {{-- Email --}}
                            <td class="px-3 py-3 whitespace-nowrap text-sm @if($user->activo == 0) text-white @else text-gray-600 dark:text-gray-300 @endif hidden md:table-cell">
                                {{ $user->email }}
                            </td>

                            {{-- Fecha Alta --}}
                            <td class="px-3 py-3 whitespace-nowrap text-sm @if($user->activo == 0) text-white @else text-gray-600 dark:text-gray-300 @endif hidden md:table-cell">
                                {{ $user->fechaAlta ? \Carbon\Carbon::parse($user->fechaAlta)->format('d/m/Y') : '-' }}
                            </td>

                            {{-- Instrument --}}
                            <td class="px-3 py-3 whitespace-nowrap text-sm @if($user->activo == 0) text-white @else text-gray-600 dark:text-gray-300 @endif hidden md:table-cell">
                                {{ $user->instrument?->name ?? __('Sense instrument') }}
                            </td>

                            {{-- Actiu --}}
                            <td class="px-3 py-3 whitespace-nowrap hidden md:table-cell">
                                <form method="POST" action="{{ route('users.toggle-active', $user) }}" class="inline-flex">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="activo" value="{{ $user->activo ? 0 : 1 }}">
                                    <button type="submit"
                                        class="group inline-flex h-7 w-14 items-center rounded-full border transition focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 {{ $user->activo ? 'justify-end border-green-200 bg-green-100' : 'justify-start border-red-200 bg-red-100' }}"
                                        aria-label="{{ $user->activo ? __('Desactivar usuario') : __('Activar usuario') }}"
                                        title="{{ $user->activo ? __('Desactivar usuario') : __('Activar usuario') }}">
                                        <span class="mx-1 inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $user->activo ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}">
                                            {{ $user->activo ? __('Sí') : __('No') }}
                                        </span>
                                    </button>
                                </form>
                            </td>

                            {{-- Accions --}}
                            <td class="px-3 py-3 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('users.edit', $user->id) }}" title="{{ __('Editar') }}">
                                        <x-editar w="24" h="24" />
                                    </a>
                                    @if (!$user->porcentaje)
                                        <svg width="20px" height="20px" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" title="{{ __('Sense percentatge assignat') }}">
                                            <path style="fill:#ffc35a;" d="m11 1032.362-10 18h20zm0 2 8 15H3z" transform="translate(0 -1030.362)"/>
                                            <path style="fill:#373737;fill-opacity:.94;" d="M10 1046.362h2v2h-2z" transform="translate(0 -1030.362)"/>
                                            <path style="fill:#373737;fill-opacity:.94;" d="M10 1045.362h2v-6h-2z" transform="translate(0 -1030.362)"/>
                                        </svg>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="font-medium">{{ __('Cap músic trobat') }}</p>
                                <p class="text-sm mt-1">{{ __('Prova a canviar els filtres de cerca') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        @if ($users->hasPages())
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif

    </div>

    {{-- FOOTER --}}
    <footer class="fixed bottom-0 left-0 z-20 w-full bg-white border-t border-gray-300 shadow dark:bg-gray-800 dark:border-gray-600">
        <div class="flex justify-around items-center px-6 py-3">

            <a href="{{ route('users.index') }}"
                class="flex flex-col items-center text-gray-700 hover:text-yellow-600 dark:text-gray-300 dark:hover:text-yellow-400 transition">
                <svg width="32px" height="32px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                    <path d="M618.666667 490.666667H405.333333L149.333333 192h725.333334z" fill="#F57C00"/>
                    <path d="M618.666667 810.666667l-213.333334 128V490.666667h213.333334zM885.333333 192h-746.666666C121.6 192 106.666667 177.066667 106.666667 160S121.6 128 138.666667 128h746.666666c17.066667 0 32 14.933333 32 32S902.4 192 885.333333 192z" fill="#FF9800"/>
                    <path d="M810.666667 810.666667m-213.333334 0a213.333333 213.333333 0 1 0 426.666667 0 213.333333 213.333333 0 1 0-426.666667 0Z" fill="#F44336"/>
                    <path d="M682.666667 768h256v85.333333H682.666667z" fill="#FFFFFF"/>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Borrar Filtros') }}</span>
            </a>

            <a href="{{ route('users.index', ['padres' => 1]) }}"
                class="flex flex-col items-center text-gray-700 hover:text-yellow-600 dark:text-gray-300 dark:hover:text-yellow-400 transition">
                <svg height="32px" width="32px" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path style="fill:#646363;" d="M468.125,128.73C304.284,99.474,234.069,0,234.069,0S163.847,99.474,0.013,128.73 c0,64.367-5.858,277.944,234.056,383.27C473.976,406.675,468.125,193.098,468.125,128.73z"/>
                    <path style="fill:#EAEEBE;" d="M234.069,466.88C63.977,384.073,43.61,240.378,41.255,161.786 c95.349-23.792,158.067-69.25,192.814-101.558c34.747,32.308,97.458,77.766,192.807,101.558 C424.528,240.378,404.155,384.073,234.069,466.88z"/>
                    <path style="fill:#F0C57B;" d="M410.284,169.867c-1.813,70.95-19.134,203.716-176.215,279.583 c-29.05-14.015-53.306-29.989-73.582-47.191c-27.411-23.173-47.513-48.568-62.293-74.285 c-33.346-58.164-39.32-118.025-40.346-158.106c88.156-21.531,145.384-63.78,176.221-92.92 c15.328,14.483,37.185,32.21,66.118,49.035c26.16,15.183,58.132,29.637,96.284,40.256 C400.981,167.525,405.6,168.725,410.284,169.867z"/>
                    <path style="fill:#716363;" d="M234.069,76.947c-30.837,29.14-88.066,71.389-176.221,92.92 c0.613,23.74,3.007,54.442,11.742,87.595h164.48V76.947z"/>
                    <path style="fill:#716363;" d="M234.069,449.449c104.49-50.468,147.133-126.108,164.506-191.988H234.069V449.449z"/>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Mostrar padres') }}</span>
            </a>

            <button type="button" id="mostrarForasters"
                class="flex flex-col items-center text-gray-700 hover:text-yellow-600 dark:text-gray-300 dark:hover:text-yellow-400 transition"
                onclick="toggleForasters(this)">
                <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.5001 12C20.5377 12 23.0001 14.4624 23.0001 17.5C23.0001 20.5376 20.5377 23 17.5001 23C14.4626 23 12.0001 20.5376 12.0001 17.5C12.0001 14.4624 14.4626 12 17.5001 12ZM17.5001 19.751C17.1552 19.751 16.8756 20.0306 16.8756 20.3755C16.8756 20.7204 17.1552 21 17.5001 21C17.845 21 18.1246 20.7204 18.1246 20.3755C18.1246 20.0306 17.845 19.751 17.5001 19.751ZM17.5002 13.8741C16.4522 13.8741 15.6359 14.6915 15.6468 15.8284C15.6494 16.1045 15.8754 16.3262 16.1516 16.3236C16.4277 16.3209 16.6494 16.0949 16.6467 15.8188C16.6412 15.2398 17.0064 14.8741 17.5002 14.8741C17.9725 14.8741 18.3536 15.266 18.3536 15.8236C18.3536 16.0158 18.2983 16.1659 18.1296 16.3851L18.0356 16.501L17.9366 16.6142L17.6712 16.9043L17.5348 17.0615C17.1515 17.5182 17.0002 17.854 17.0002 18.3716C17.0002 18.6477 17.224 18.8716 17.5002 18.8716C17.7763 18.8716 18.0002 18.6477 18.0002 18.3716C18.0002 18.1684 18.0587 18.0126 18.239 17.7813L18.3239 17.6772L18.4249 17.5618L18.6906 17.2713L18.8252 17.1162C19.2035 16.6654 19.3536 16.333 19.3536 15.8236C19.3536 14.7199 18.5312 13.8741 17.5002 13.8741ZM12.0224 13.9993C11.7257 14.4626 11.4862 14.966 11.3137 15.4996L4.25254 15.4999C3.83895 15.4999 3.50366 15.8352 3.50366 16.2488V16.8265C3.50366 17.3622 3.69477 17.8802 4.04263 18.2876C5.29594 19.7553 7.26182 20.5011 10.0001 20.5011C10.5966 20.5011 11.1564 20.4657 11.6804 20.3952C11.9255 20.8901 12.2331 21.3486 12.5919 21.7615C11.7964 21.9217 10.9315 22.0011 10.0001 22.0011C6.85426 22.0011 4.46825 21.0959 2.90194 19.2617C2.32218 18.5828 2.00366 17.7193 2.00366 16.8265V16.2488C2.00366 15.0068 3.01052 13.9999 4.25254 13.9999L12.0224 13.9993ZM10.0001 2.00464C12.7615 2.00464 15.0001 4.24321 15.0001 7.00464C15.0001 9.76606 12.7615 12.0046 10.0001 12.0046C7.2387 12.0046 5.00012 9.76606 5.00012 7.00464C5.00012 4.24321 7.2387 2.00464 10.0001 2.00464ZM10.0001 3.50464C8.06712 3.50464 6.50012 5.07164 6.50012 7.00464C6.50012 8.93764 8.06712 10.5046 10.0001 10.5046C11.9331 10.5046 13.5001 8.93764 13.5001 7.00464C13.5001 5.07164 11.9331 3.50464 10.0001 3.50464Z" fill="#7f7834"/>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Mostrar forasters') }}</span>
            </button>

            <a href="{{ route('users.create') }}"
                class="flex flex-col items-center text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 transition">
                <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.5,12 C20.5376,12 23,14.4624 23,17.5 C23,20.5376 20.5376,23 17.5,23 C14.4624,23 12,20.5376 12,17.5 C12,14.4624 14.4624,12 17.5,12 Z M12.0223,13.9993 C11.7256,14.4626 11.486,14.966 11.3136,15.4996 L4.25242,15.4999 C3.83882,15.4999 3.50354,15.8352 3.50354,16.2488 L3.50354,16.8265 C3.50354,17.3622 3.69465,17.8802 4.04251,18.2876 C5.29582,19.7553 7.2617,20.5011 10,20.5011 C10.5964,20.5011 11.1563,20.4657 11.6802,20.3952 C11.9254,20.8901 12.233,21.3486 12.5917,21.7615 C11.7962,21.9217 10.9314,22.0011 10,22.0011 C6.85414,22.0011 4.46812,21.0959 2.90182,19.2617 C2.32206,18.5828 2.00354,17.7193 2.00354,16.8265 L2.00354,16.2488 C2.00354,15.0068 3.0104,13.9999 4.25242,13.9999 L12.0223,13.9993 Z M17.5,14 L17.4101,14.0081 C17.206,14.0451 17.0451,14.206 17.0081,14.4101 L17,14.5 L16.999,17 L14.5039,17 L14.414,17.0081 C14.2099,17.0451 14.049,17.206 14.012,17.4101 L14.0039,17.5 L14.012,17.5899 C14.049,17.794 14.2099,17.9549 14.414,17.992 L14.5039,18 L16.999,18 L17,20.5 L17.0081,20.5899 C17.0451,20.794 17.206,20.9549 17.4101,20.9919 L17.5,21 L17.5899,20.9919 C17.794,20.9549 17.9549,20.794 17.9919,20.5899 L18,20.5 L17.999,18 L20.5039,18 L20.5938,17.992 C20.7979,17.9549 20.9588,17.794 20.9958,17.5899 L21.0039,17.5 L20.9958,17.4101 C20.9588,17.206 20.7979,17.0451 20.5938,17.0081 L20.5039,17 L17.999,17 L18,14.5 L17.9919,14.4101 C17.9549,14.206 17.794,14.0451 17.5899,14.0081 L17.5,14 Z M10,2.00464 C12.7614,2.00464 15,4.24321 15,7.00464 C15,9.76606 12.7614,12.0046 10,12.0046 C7.23857,12.0046 5,9.76606 5,7.00464 C5,4.24321 7.23857,2.00464 10,2.00464 Z M10,3.50464 C8.067,3.50464 6.5,5.07164 6.5,7.00464 C6.5,8.93764 8.067,10.5046 10,10.5046 C11.933,10.5046 13.5,8.93764 13.5,7.00464 C13.5,5.07164 11.933,3.50464 10,3.50464 Z" fill="#0c6600"/>
                </svg>
                <span class="text-xs mt-1 font-bold">{{ __('Nou music') }}</span>
            </a>

        </div>
    </footer>

    <script>
        function toggleForasters(boton) {
            const rows = document.querySelectorAll('.forastero-row');
            const labelEl = boton.querySelector('span');
            const isHidden = rows.length > 0 && rows[0].classList.contains('hidden');

            rows.forEach(row => {
                row.classList.toggle('hidden', !isHidden);
            });

            labelEl.textContent = isHidden ? '{{ __('Ocultar forasters') }}' : '{{ __('Mostrar forasters') }}';
        }
    </script>
</x-app-layout>
