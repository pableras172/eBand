<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('users.index') }}">{{ __('Músics') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>
                            @if (isset($user))
                                {{ $user->name }}
                            @else
                                {{ __('Nou music') }}
                            @endif
                        </x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        @if (isset($user))
                            {{ __('Editar músic') }}: <span class="text-indigo-600">{{ $user->name }}</span>
                        @else
                            {{ __('Nou Music') }}
                        @endif
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-bold shadow-xs transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Tornar al llistat') }}</span>
                </a>

                @if (isset($user))
                    <form action="{{ route('users.destroy', $user->id) }}" method="post"
                        onsubmit="return confirm('{{ __('Estàs segur que vols eliminar aquest músic?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 text-xs font-bold shadow-xs transition"
                            title="{{ __('Eliminar músic') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>{{ __('Eliminar') }}</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-6 pb-28">
        <form method="post" action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
            class="space-y-6">
            @csrf
            @if (isset($user))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                <!-- COLUMNA 1: DADES PRINCIPALS (lg:col-span-7) -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- SECCIÓ: Identitat i accés -->
                    <section class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-7 shadow-bento space-y-5">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50/80">
                            <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Identitat i accés') }}</h2>
                                <p class="text-[11px] text-slate-500 font-medium">{{ __('Dades bàsiques del músic i credencials d’accés.') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <!-- Nom -->
                            <div>
                                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Nom') }} <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" required
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    value="{{ old('name', isset($user) ? $user->name : '') }}" />
                                @error('name')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Telèfon -->
                            <div>
                                <label for="telefono" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Telefon') }} <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="telefono" id="telefono" required
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    value="{{ old('telefono', isset($user) ? $user->telefono : '') }}" />
                                @error('telefono')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="sm:col-span-2">
                                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Email') }} <span class="text-rose-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" required
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    value="{{ old('email', isset($user) ? $user->email : '') }}" />
                                @error('email')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="sm:col-span-2">
                                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Password') }}
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                        class="w-full pl-3.5 pr-11 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                        value="{{ isset($user) ? '' : 'Banda2024' }}"
                                        placeholder="{{ isset($user) ? __('Deixa en blanc per no canviar') : '' }}" />
                                    <button type="button" onclick="togglePasswordVisibility()"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 transition"
                                        title="{{ __('Mostrar/Ocultar contrasenya') }}">
                                        <svg id="eye-open" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg id="eye-closed" class="hidden h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">
                                    @if (!isset($user))
                                        {{ __('Valor predeterminat: Banda2024 (pots canviar-lo abans de guardar)') }}
                                    @else
                                        {{ __('Deixa en blanc si no vols modificar el password') }}
                                    @endif
                                </p>
                                @error('password')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- SECCIÓ: Dades musicals -->
                    <section class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-7 shadow-bento space-y-5">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50/80">
                            <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12 0c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Dades musicals') }}</h2>
                                <p class="text-[11px] text-slate-500 font-medium">{{ __('Assignació instrumental, percentatge i data d’alta.') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <!-- Instrument -->
                            <div class="sm:col-span-2">
                                <label for="instrument" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Instrument') }}
                                </label>
                                <select name="instrument_id" id="instrument"
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                    <option value="">{{ __('Selecciona un instrument') }}</option>
                                    @foreach ($instruments as $instrument)
                                        <option value="{{ $instrument->id }}"
                                            @selected(old('instrument_id', isset($user) ? $user->instrument_id : '') == $instrument->id)>
                                            {{ $instrument->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('instrument_id')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Percentatge -->
                            <div>
                                <label for="porcentaje" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Percentaje') }}
                                </label>
                                <input type="number" name="porcentaje" id="porcentaje"
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    value="{{ old('porcentaje', isset($user) ? $user->porcentaje : '') }}" />
                                @error('porcentaje')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Data Alta -->
                            <div class="sm:col-span-3">
                                <label for="fechaAlta" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Data Alta') }} <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="fechaAlta" id="fechaAlta" required
                                    class="w-full sm:w-1/2 px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    value="{{ old('fechaAlta', isset($user) ? $user->fechaAlta : '') }}" />
                                @error('fechaAlta')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- SECCIÓ: Observacions -->
                    <section class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-7 shadow-bento space-y-5">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50/80">
                            <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Observacions') }}</h2>
                                <p class="text-[11px] text-slate-500 font-medium">{{ __('Informació interna o notas relevantes para la gestión.') }}</p>
                            </div>
                        </div>

                        <div>
                            <textarea name="observaciones" id="observaciones" rows="4"
                                class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                placeholder="{{ __('Informació interna o notes rellevants per a la gestió...') }}">{{ old('observaciones', isset($user) ? $user->observaciones : '') }}</textarea>
                            @error('observaciones')
                                <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>
                </div>

                <!-- COLUMNA 2: ESTAT, FAMÍLIA, PERMISOS (lg:col-span-5) -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- SECCIÓ: Estat i perfil -->
                    <section class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-7 shadow-bento space-y-4">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50/80">
                            <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Estat i perfil') }}</h2>
                                <p class="text-[11px] text-slate-500 font-medium">{{ __('Marcadors ràpids para disponibilidad y tipología de usuario.') }}</p>
                            </div>
                        </div>

                        <div class="space-y-2.5">
                            <!-- Actiu -->
                            <label for="activo"
                                class="flex items-center justify-between rounded-2xl border border-emerald-100 bg-emerald-50/60 hover:bg-emerald-50 p-3.5 cursor-pointer transition">
                                <div class="pr-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <p class="text-xs font-bold text-slate-800">{{ __('Actiu') }}</p>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ __('Permite que el usuario aparezca como disponible en la aplicación.') }}</p>
                                </div>
                                <input type="checkbox" name="activo" id="activo"
                                    class="h-5 w-5 rounded-lg border-emerald-300 text-emerald-600 focus:ring-emerald-500 transition"
                                    {{ (isset($user) && $user->activo) || old('activo') ? 'checked' : '' }}>
                            </label>
                            @error('activo')
                                <p class="text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror

                            <!-- Foraster -->
                            <label for="forastero"
                                class="flex items-center justify-between rounded-2xl border border-slate-200/80 bg-[#F5F6FC] hover:bg-slate-100/70 p-3.5 cursor-pointer transition">
                                <div class="pr-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        <p class="text-xs font-bold text-slate-800">{{ __('Foraster') }}</p>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ __('Identifica a los músicos externos o no habituales.') }}</p>
                                </div>
                                <input type="checkbox" name="forastero" id="forastero"
                                    class="h-5 w-5 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 transition"
                                    {{ (isset($user) && $user->forastero) || old('forastero') ? 'checked' : '' }}>
                            </label>
                            @error('forastero')
                                <p class="text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror

                            <!-- Furgona -->
                            <label for="tienefurgo"
                                class="flex items-center justify-between rounded-2xl border border-indigo-100/80 bg-indigo-50/30 hover:bg-indigo-50/60 p-3.5 cursor-pointer transition">
                                <div class="pr-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                        <p class="text-xs font-bold text-slate-800">{{ __('Furgona') }}</p>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ __('El músic ha indicat que pot agafar furgona en cas de ser necessari.') }}</p>
                                </div>
                                <input type="checkbox" name="tienefurgo" id="tienefurgo"
                                    class="h-5 w-5 rounded-lg border-indigo-300 text-indigo-600 focus:ring-indigo-500 transition"
                                    {{ (isset($user) && $user->tienefurgo) || old('tienefurgo') ? 'checked' : '' }}>
                            </label>
                            @error('tienefurgo')
                                <p class="text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror

                            <!-- Coche -->
                            <label for="tienecoche"
                                class="flex items-center justify-between rounded-2xl border border-indigo-100/80 bg-indigo-50/30 hover:bg-indigo-50/60 p-3.5 cursor-pointer transition">
                                <div class="pr-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                        <p class="text-xs font-bold text-slate-800">{{ __('Coche') }}</p>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ __('El músic ha indicat que pot agafar coche en cas de ser necessari.') }}</p>
                                </div>
                                <input type="checkbox" name="tienecoche" id="tienecoche"
                                    class="h-5 w-5 rounded-lg border-indigo-300 text-indigo-600 focus:ring-indigo-500 transition"
                                    {{ (isset($user) && $user->tienecoche) || old('tienecoche') ? 'checked' : '' }}>
                            </label>
                            @error('tienecoche')
                                <p class="text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>

                    <!-- SECCIÓ: Família musical -->
                    <section class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-7 shadow-bento space-y-4">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50/80">
                            <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Familia musical') }}</h2>
                                <p class="text-[11px] text-slate-500 font-medium">{{ __('Agrupa fills asociados y controla el estado de padre o madre.') }}</p>
                            </div>
                        </div>

                        <input type="hidden" name="es_padre" id="es_padre_hidden" value="0">

                        <label for="es_padre"
                            class="flex items-center justify-between rounded-2xl border border-amber-200/80 bg-amber-50/50 hover:bg-amber-50 p-3.5 cursor-pointer transition">
                            <div class="pr-3">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    <p class="text-xs font-bold text-slate-800">{{ __('És pare/mare?') }}</p>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-0.5">{{ __('Al activarlo podrás asociar músicos dependientes o hijos.') }}</p>
                            </div>
                            <input type="checkbox" id="es_padre"
                                class="h-5 w-5 rounded-lg border-amber-300 text-amber-600 focus:ring-amber-500 transition"
                                onchange="toggleHijos()"
                                {{ old('es_padre', isset($user) && $user->hijos->count() ? 1 : 0) ? 'checked' : '' }}>
                        </label>

                        <div id="selector-hijos" class="mt-4 hidden">
                            <label for="hijos" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                {{ __('Selecciona fills') }}
                            </label>
                            <select name="hijos[]" id="hijos" multiple size="4"
                                class="w-full px-3.5 py-2 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                @foreach ($todosLosUsuarios as $posibleHijo)
                                    @if (!isset($user) || $posibleHijo->id !== $user->id)
                                        <option value="{{ $posibleHijo->id }}" class="py-1 px-2 rounded-lg"
                                            {{ collect(old('hijos', isset($user) ? $user->hijos->pluck('id')->all() : []))->contains($posibleHijo->id) ? 'selected' : '' }}>
                                            {{ $posibleHijo->name }} ({{ $posibleHijo->email }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <p class="text-[11px] text-slate-400 mt-1">{{ __('Mantén premut Ctrl (o Cmd) per seleccionar múltiples fills.') }}</p>
                        </div>

                        @if (isset($user) && $user->hijos->count())
                            <div class="mt-3 rounded-2xl border border-indigo-100/80 bg-indigo-50/40 p-3.5">
                                <p class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">{{ __('Fills associats') }}</p>
                                <ul class="space-y-1.5">
                                    @foreach ($user->hijos as $hijo)
                                        <li class="flex items-center gap-2 text-xs text-slate-700 font-medium">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                            <span>{{ $hijo->name }}</span>
                                            <span class="text-slate-400 text-[11px]">({{ $hijo->email }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </section>

                    <!-- SECCIÓ: Permisos i rols -->
                    <section class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-7 shadow-bento space-y-4">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50/80">
                            <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Permisos') }}</h2>
                                <p class="text-[11px] text-slate-500 font-medium">{{ __('Selecciona uno o varios roles para definir el acceso interno.') }}</p>
                            </div>
                        </div>

                        <div>
                            <label for="roles" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                {{ __('Roles') }} <span class="text-rose-500">*</span>
                            </label>
                            <select name="roles[]" id="roles" multiple="multiple" size="3"
                                class="w-full px-3.5 py-2 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                @foreach ($roles as $id => $role)
                                    <option value="{{ $id }}" class="py-1 px-2 rounded-lg"
                                        {{ collect(old('roles', isset($user) ? $user->roles->pluck('id')->all() : []))->contains($id) ? 'selected' : '' }}>
                                        {{ $role }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-[11px] text-slate-400 mt-1">{{ __('Selecciona un o diversos rols mantenint premut Ctrl/Cmd.') }}</p>
                            @error('roles')
                                <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>
                </div>

                <input type="hidden" id="uuid" name="uuid" value="{{ Ramsey\Uuid\Uuid::uuid4()->toString() }}" />

                <!-- BARRA D'ACCIONS INFERIOR (lg:col-span-12) -->
                <div class="lg:col-span-12 bg-white border border-indigo-50/80 rounded-3xl p-5 lg:p-6 shadow-bento flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('users.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 border border-slate-300 rounded-2xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-xs w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>{{ __('Tornar al llistat') }}</span>
                    </a>

                    <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold shadow-md shadow-indigo-600/20 transition w-full sm:w-auto justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>
                                @if (isset($user))
                                    {{ __('Actualitzar músic') }}
                                @else
                                    {{ __('Guardar músic') }}
                                @endif
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        @if (isset($user))
            <div class="mt-8">
                <x-usermetrics :userId="$user->id" />
            </div>
        @endif
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        function toggleHijos() {
            const checkbox = document.getElementById('es_padre');
            const hijosDiv = document.getElementById('selector-hijos');
            const hiddenField = document.getElementById('es_padre_hidden');

            if (checkbox && hijosDiv && hiddenField) {
                hijosDiv.classList.toggle('hidden', !checkbox.checked);
                hiddenField.value = checkbox.checked ? 1 : 0;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleHijos();
        });
    </script>
</x-app-layout>