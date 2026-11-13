<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 shadow-lg shadow-amber-900/10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Músics') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-white tracking-tight mt-0.5">
                        {{ __('Directori de Músics') }}
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                    {{ $users->total() }} {{ __('músics registrats') }}
                </span>
                <a href="{{ route('users.create') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-lg shadow-blue-900/30 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>{{ __('Nou músic') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    @if (request()->has('success') && request()->success)
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 py-3 px-4 mb-4 rounded-xl text-sm font-semibold flex items-center gap-2">
            <span>✓</span> {{ __('Usuari creat correctament.') }}
        </div>
    @endif

    @if (session('success_message'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 py-3 px-4 mb-4 rounded-xl text-sm font-semibold flex items-center gap-2">
            <span>✓</span> {{ session('success_message') }}
        </div>
    @endif

    <div class="space-y-6 pb-28">

        {{-- PANEL DE FILTROS (Dark Command Center) --}}
        <div class="bg-[#111827] border border-slate-800 rounded-2xl p-4 lg:p-5 shadow-xl">
            <form method="GET" action="{{ route('users.index') }}" id="filtros-form">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                    {{-- Buscador por Nombre --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">
                            {{ __('Cercar per nom') }}
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="nombre" value="{{ $nombre }}"
                                placeholder="{{ __('Nom o cognom...') }}"
                                class="w-full pl-9 pr-3 py-2 text-xs bg-[#0B1120] border border-slate-700 rounded-xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                    </div>

                    {{-- Selector de Instrumento --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">
                            {{ __('Instrument') }}
                        </label>
                        <select name="instrument_id" onchange="this.form.submit()"
                            class="w-full px-3 py-2 text-xs bg-[#0B1120] border border-slate-700 rounded-xl text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">{{ __('Tots els instruments') }}</option>
                            @foreach ($instruments as $instrument)
                                <option value="{{ $instrument->id }}" @selected($instrument_id == $instrument->id)>
                                    {{ $instrument->name }} ({{ $instrument->users_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Selector de Estado --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">
                            {{ __('Estat') }}
                        </label>
                        <select name="activo" onchange="this.form.submit()"
                            class="w-full px-3 py-2 text-xs bg-[#0B1120] border border-slate-700 rounded-xl text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">{{ __('Tots els estats') }}</option>
                            <option value="1" @selected($activo === '1')>{{ __('Actius') }}</option>
                            <option value="0" @selected($activo === '0')>{{ __('Inactius') }}</option>
                        </select>
                    </div>

                </div>

                {{-- Acciones del filtro --}}
                <div class="flex flex-wrap items-center justify-between gap-2 mt-4 pt-4 border-t border-slate-800">
                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl shadow-md transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            {{ __('Filtrar') }}
                        </button>

                        @if ($nombre || $instrument_id || ($activo !== null && $activo !== ''))
                            <a href="{{ route('users.index') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold rounded-xl border border-slate-700 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ __('Netejar filtres') }}
                            </a>
                        @endif
                    </div>

                    <button type="button" onclick="openExportModal()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600/20 hover:bg-emerald-600/30 text-emerald-300 border border-emerald-500/30 text-xs font-bold rounded-xl transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-4-4m4 4l4-4m5 7H3" />
                        </svg>
                        {{ __('Exportar Llistat') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- VISTA MÓVIL (< 768px): Tarjetas táctiles y compactas --}}
        <div class="grid grid-cols-1 gap-3 md:hidden">
            @forelse ($users as $user)
                <div class="bg-[#111827] border {{ $user->activo == 0 ? 'border-rose-900/40 bg-rose-950/10' : ($user->hijos->isNotEmpty() ? 'border-amber-500/30' : 'border-slate-800') }} rounded-2xl p-4 shadow-lg space-y-3 @if($user->forastero) hidden forastero-row @endif">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                    class="h-11 w-11 rounded-full object-cover border border-slate-700 shadow">
                                @if ($user->activo == 0)
                                    <span class="absolute -bottom-1 -right-1 bg-rose-500 rounded-full w-3.5 h-3.5 border-2 border-[#111827]" title="{{ __('Inactiu') }}"></span>
                                @elseif($user->hijos->isNotEmpty())
                                    <span class="absolute -bottom-1 -right-1 bg-amber-400 rounded-full w-3.5 h-3.5 border-2 border-[#111827]" title="{{ __('Pare/Mare') }}"></span>
                                @else
                                    <span class="absolute -bottom-1 -right-1 bg-emerald-400 rounded-full w-3.5 h-3.5 border-2 border-[#111827]" title="{{ __('Actiu') }}"></span>
                                @endif
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-sm font-bold text-white">
                                        {{ $user->name }}
                                    </h3>
                                    @if ($user->hijos->isNotEmpty())
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                            {{ __('Família') }}
                                        </span>
                                    @endif
                                    @if ($user->forastero)
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-700 text-slate-300">
                                            {{ __('Reforç') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-blue-400 font-semibold mt-0.5">
                                    {{ $user->instrument?->name ?? __('Sense instrument') }}
                                </div>
                            </div>
                        </div>

                        {{-- Toggle de Activo Móvil --}}
                        <form method="POST" action="{{ route('users.toggle-active', $user) }}" class="inline-flex">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="activo" value="{{ $user->activo ? 0 : 1 }}">
                            <button type="submit"
                                class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold transition {{ $user->activo ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30' }}">
                                {{ $user->activo ? __('Actiu') : __('Inactiu') }}
                            </button>
                        </form>
                    </div>

                    {{-- Datos secundarios y acciones --}}
                    <div class="flex items-center justify-between pt-2.5 border-t border-slate-800/80 text-xs text-slate-400">
                        <span class="truncate max-w-[180px]">{{ $user->email }}</span>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('actuaciones.usuario.anyo', [$user->id, date('Y')]) }}"
                                class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-amber-400 border border-slate-700 transition" 
                                title="{{ __('Estadístiques') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}"
                                class="p-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white transition"
                                title="{{ __('Editar') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-[#111827] border border-slate-800 rounded-2xl p-8 text-center text-slate-400 text-sm">
                    {{ __('Cap músic trobat amb els filtres seleccionats.') }}
                </div>
            @endforelse
        </div>

        {{-- VISTA ESCRITORIO (>= 768px): Tabla densa Dark Command Center --}}
        <div class="hidden md:block bg-[#111827] border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
            <table class="min-w-full divide-y divide-slate-800">
                <thead class="bg-slate-900/60">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-14"></th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                            {{ __('Músic') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                            {{ __('Email') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                            {{ __('Data Alta') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                            {{ __('Instrument') }}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                            {{ __('Estat') }}
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">
                            {{ __('Accions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-800/50 transition-colors {{ $user->activo == 0 ? 'bg-rose-950/20' : ($user->hijos->isNotEmpty() ? 'bg-amber-500/5' : '') }} @if($user->forastero) hidden forastero-row @endif">

                            {{-- Avatar --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="relative inline-block">
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                        class="h-9 w-9 rounded-full object-cover border border-slate-700 shadow">
                                    @if ($user->activo == 0)
                                        <span class="absolute -bottom-1 -right-1 bg-rose-500 rounded-full w-3 h-3 border-2 border-[#111827]" title="{{ __('Inactiu') }}"></span>
                                    @elseif($user->hijos->isNotEmpty())
                                        <span class="absolute -bottom-1 -right-1 bg-amber-400 rounded-full w-3 h-3 border-2 border-[#111827]" title="{{ __('Pare/Mare') }}"></span>
                                    @else
                                        <span class="absolute -bottom-1 -right-1 bg-emerald-400 rounded-full w-3 h-3 border-2 border-[#111827]" title="{{ __('Actiu') }}"></span>
                                    @endif
                                </div>
                            </td>

                            {{-- Nombre y tags --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-white">
                                        {{ $user->name }}
                                    </span>
                                    @if ($user->hijos->isNotEmpty())
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30" title="{{ __('Té fills associats a la banda') }}">
                                            {{ __('Família') }}
                                        </span>
                                    @endif
                                    @if ($user->forastero)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-700 text-slate-300">
                                            {{ __('Reforç') }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="px-4 py-3 whitespace-nowrap text-xs text-slate-300">
                                {{ $user->email }}
                            </td>

                            {{-- Fecha de Alta --}}
                            <td class="px-4 py-3 whitespace-nowrap text-xs text-slate-400">
                                {{ $user->fechaAlta ? \Carbon\Carbon::parse($user->fechaAlta)->format('d/m/Y') : '-' }}
                            </td>

                            {{-- Instrumento --}}
                            <td class="px-4 py-3 whitespace-nowrap text-xs font-semibold text-blue-400">
                                {{ $user->instrument?->name ?? __('Sense instrument') }}
                            </td>

                            {{-- Toggle Activo --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <form method="POST" action="{{ route('users.toggle-active', $user) }}" class="inline-flex">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="activo" value="{{ $user->activo ? 0 : 1 }}">
                                    <button type="submit"
                                        class="group inline-flex h-6 w-14 items-center rounded-full border transition focus:outline-none {{ $user->activo ? 'justify-end border-emerald-500/30 bg-emerald-500/20 text-emerald-300' : 'justify-start border-rose-500/30 bg-rose-500/20 text-rose-300' }}"
                                        aria-label="{{ $user->activo ? __('Desactivar usuari') : __('Activar usuari') }}"
                                        title="{{ $user->activo ? __('Desactivar usuari') : __('Activar usuari') }}">
                                        <span class="mx-1 inline-flex items-center rounded-full px-1.5 py-0.2 text-[10px] font-bold {{ $user->activo ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                                            {{ $user->activo ? __('Sí') : __('No') }}
                                        </span>
                                    </button>
                                </form>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('actuaciones.usuario.anyo', [$user->id, date('Y')]) }}"
                                        class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-amber-400 border border-slate-700 transition" 
                                        title="{{ __('Estadístiques d\'assistència') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="p-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white shadow-md transition" 
                                        title="{{ __('Editar perfil') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    @if (!$user->porcentaje)
                                        <span title="{{ __('Sense percentatge assignat') }}" class="text-amber-400">
                                            ⚠️
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <p class="font-bold text-white">{{ __('Cap músic trobat') }}</p>
                                <p class="text-xs mt-1">{{ __('Prova a canviar o netejar els filtres de cerca.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if ($users->hasPages())
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif

        {{-- Estadísticas de Cuerdas / Instrumentos --}}
        <div class="mt-6">
            <x-statistics.instruments />
        </div>

    </div>

    {{-- MODAL DE EXPORTACIÓN (Dark Command Center) --}}
    <div id="exportModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeExportModal()"></div>

        <div class="relative mx-auto mt-20 w-[92%] max-w-lg rounded-2xl bg-[#111827] border border-slate-800 shadow-2xl p-6">
            <div class="flex items-start justify-between gap-4 border-b border-slate-800 pb-4">
                <div>
                    <h3 class="text-lg font-bold font-headline text-white">{{ __('Exportar llistat de músics') }}</h3>
                    <p class="text-xs text-slate-400 mt-1">
                        {{ __('Descarrega el fitxer o envia\'l directament per correu electrònic.') }}
                    </p>
                </div>
                <button type="button" onclick="closeExportModal()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition">✕</button>
            </div>

            <form id="exportUsersForm" method="POST" action="{{ route('users.export') }}" class="mt-5 space-y-4">
                @csrf
                <input type="hidden" name="mode" id="exportModeInput" value="download">
                <input type="hidden" name="nombre" value="{{ $nombre }}">
                <input type="hidden" name="instrument_id" value="{{ $instrument_id }}">
                <input type="hidden" name="activo" value="{{ $activo }}">
                <input type="hidden" name="padres" value="{{ request()->boolean('padres') ? 1 : 0 }}">

                <div>
                    <label for="exportEmail" class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">
                        {{ __('Correu per a l\'enviament (opcional)') }}
                    </label>
                    <input id="exportEmail" type="email" name="email"
                        placeholder="{{ __('correu@banda.org') }}"
                        class="w-full px-3 py-2 text-xs bg-[#0B1120] border border-slate-700 rounded-xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                <div class="flex flex-wrap justify-end gap-2 pt-3 border-t border-slate-800">
                    <button type="button" onclick="closeExportModal()"
                        class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold rounded-xl border border-slate-700 transition">
                        {{ __('Cancel·lar') }}
                    </button>

                    <button type="button" onclick="submitExport('download')"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-md transition">
                        {{ __('Descarregar fitxer') }}
                    </button>

                    <button type="button" onclick="submitExport('email')"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-xl shadow-md transition">
                        {{ __('Enviar per correu') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- BARRA INFERIOR DE ACCIONES RÁPIDAS --}}
    <footer class="fixed bottom-0 left-0 right-0 z-20 bg-[#0B1120]/95 backdrop-blur-xl border-t border-slate-800 py-2.5 px-4 shadow-2xl">
        <div class="max-w-7xl mx-auto flex justify-around items-center">
            
            <a href="{{ route('users.index') }}"
                class="flex flex-col items-center text-slate-400 hover:text-white transition">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="text-[11px] mt-1 font-semibold">{{ __('Netejar filtres') }}</span>
            </a>

            <a href="{{ route('users.index', ['padres' => 1]) }}"
                class="flex flex-col items-center {{ request()->boolean('padres') ? 'text-amber-400' : 'text-slate-400 hover:text-white' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-[11px] mt-1 font-semibold">{{ __('Pares/Mares') }}</span>
            </a>

            <button type="button" id="mostrarForasters"
                class="flex flex-col items-center text-slate-400 hover:text-white transition"
                onclick="toggleForasters(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span class="text-[11px] mt-1 font-semibold">{{ __('Reforços') }}</span>
            </button>

            <a href="{{ route('users.create') }}"
                class="flex flex-col items-center text-blue-400 hover:text-blue-300 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <span class="text-[11px] mt-1 font-semibold">{{ __('Nou músic') }}</span>
            </a>

        </div>
    </footer>

    <script>
        function openExportModal() {
            document.getElementById('exportModal').classList.remove('hidden');
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.add('hidden');
        }

        function submitExport(mode) {
            const form = document.getElementById('exportUsersForm');
            const modeInput = document.getElementById('exportModeInput');
            const emailInput = document.getElementById('exportEmail');

            modeInput.value = mode;
            emailInput.required = mode === 'email';

            if (mode === 'email' && !emailInput.value) {
                emailInput.focus();
                return;
            }

            if (mode === 'download') {
                closeExportModal();
                setTimeout(() => {
                    form.submit();
                }, 0);
                return;
            }

            form.submit();
        }

        function toggleForasters(boton) {
            const rows = document.querySelectorAll('.forastero-row');
            const labelEl = boton.querySelector('span');
            const isHidden = rows.length > 0 && rows[0].classList.contains('hidden');

            rows.forEach(row => {
                row.classList.toggle('hidden', !isHidden);
            });

            labelEl.textContent = isHidden ? '{{ __('Ocultar reforços') }}' : '{{ __('Reforços') }}';
        }
    </script>
</x-app-layout>
