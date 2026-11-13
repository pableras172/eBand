<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 14.25v-8.25A2.25 2.25 0 0017.25 3.75H6.75A2.25 2.25 0 004.5 6v12a2.25 2.25 0 002.25 2.25h7.5m-6-12h7.5m-7.5 4.5h4.5m5.25 2.25v6m3-3h-6" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Contractes') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ __('Llistat de contractes') }}
                        </h1>
                        <span class="inline-flex items-center rounded-xl bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100">
                            {{ $contratos->total() }} {{ __('totals') }}
                        </span>
                    </div>
                    <p class="mt-0.5 text-xs text-slate-500">
                        {{ __('Gestió d\'acords, municipis i actuacions de la banda') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('contratos.create') }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>{{ __('Nou contracte') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto py-4 px-3 sm:px-6 lg:px-8 pb-32">
        {{-- Alertas Flash --}}
        @if (session()->has('success'))
            <div class="flash-alert flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 mb-4 rounded-2xl text-xs font-semibold shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session()->has('deletesuccess'))
            <div class="flash-alert flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 mb-4 rounded-2xl text-xs font-semibold shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span><strong>{{ __('Contracte eliminat') }}:</strong> {{ session('deletesuccess') }}</span>
            </div>
        @endif

        @if (session()->has('duplicatesuccess'))
            <div class="flash-alert flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 mb-4 rounded-2xl text-xs font-semibold shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span>{{ session('duplicatesuccess') }}</span>
            </div>
        @endif

        {{-- Barra de búsqueda y selector de año (Neo-Bento) --}}
        <div class="mb-5 rounded-3xl border border-indigo-50/80 bg-white p-4 shadow-bento">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <form method="GET" action="{{ route('contratos.anyo', $year) }}" class="flex w-full flex-col gap-2.5 sm:flex-row lg:max-w-xl">
                    <div class="relative flex-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0Z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="{{ __('Busca per població, descripció o contacte') }}"
                            class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 pl-11 pr-4 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition" />
                    </div>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition hover:bg-indigo-700 active:scale-95">
                        {{ __('Search') }}
                    </button>
                    @if (!empty($search))
                        <a href="{{ route('contratos.anyo', $year) }}"
                            class="inline-flex items-center justify-center rounded-2xl border border-indigo-100 bg-[#F5F6FC] px-3 py-2.5 text-xs font-semibold text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-700">
                            {{ __('Netejar') }}
                        </a>
                    @endif
                </form>

                <div class="flex items-center gap-2 self-end lg:self-auto">
                    <label for="yearSelect" class="text-xs font-bold text-slate-500 uppercase tracking-wide">
                        {{ __('Any') }}:
                    </label>
                    <div class="relative">
                        <select id="yearSelect"
                            class="appearance-none rounded-2xl border border-indigo-100 bg-[#F5F6FC] py-2.5 pl-4 pr-10 text-xs font-bold text-slate-700 shadow-xs transition hover:border-indigo-200 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30">
                            @for ($i = date('Y') - 3; $i <= date('Y') + 2; $i++)
                                <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile Cards Layout (Solo pantallas móviles < md) --}}
        <div class="space-y-3.5 md:hidden">
            @forelse ($contratos as $contrato)
                <div class="rounded-3xl border border-indigo-50/80 bg-white p-5 shadow-bento space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1 rounded-xl bg-indigo-50 px-2.5 py-0.5 text-xs font-bold text-indigo-700 border border-indigo-100/70">
                                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $contrato->poblacion }}
                                </span>
                                @if ($contrato->anyo)
                                    <span class="rounded-xl bg-slate-100 px-2 py-0.5 text-[11px] font-bold text-slate-600">
                                        {{ $contrato->anyo }}
                                    </span>
                                @endif
                            </div>
                            <h2 class="mt-2 text-sm font-bold text-slate-900 leading-snug">
                                {{ $contrato->descripcion }}
                            </h2>
                        </div>
                        <a href="{{ route('contratos.actuaciones.index', ['contrato' => $contrato->id]) }}"
                            class="shrink-0 inline-flex flex-col items-center justify-center w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-xs hover:bg-indigo-100 transition"
                            title="{{ __('Actuacions') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[10.5px] uppercase font-semibold">{{ __('Dates') }}</span>
                            <span class="font-medium text-slate-700">
                                {{ $contrato->fechainicio ? \Carbon\Carbon::parse($contrato->fechainicio)->format('d/m/Y') : '-' }}
                                –
                                {{ $contrato->fechafin ? \Carbon\Carbon::parse($contrato->fechafin)->format('d/m/Y') : '-' }}
                            </span>
                        </div>
                        @if ($contrato->contacto)
                            <div>
                                <span class="text-slate-400 block text-[10.5px] uppercase font-semibold">{{ __('Contacte') }}</span>
                                <span class="font-medium text-slate-700 truncate block">
                                    {{ $contrato->contacto }}
                                    @if ($contrato->telefono)
                                        <span class="text-slate-400">({{ $contrato->telefono }})</span>
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Acciones Mobile --}}
                    <div class="flex items-center justify-end gap-1.5 pt-2 border-t border-slate-100">
                        <a href="{{ route('contratos.actuaciones.index', ['contrato' => $contrato->id]) }}"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100/70 hover:bg-indigo-100 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ __('Actuacions') }}</span>
                        </a>
                        <a href="{{ route('contratos.edit', $contrato->id) }}"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span>{{ __('Editar') }}</span>
                        </a>
                        <a href="{{ route('contratos.duplicate', $contrato->id) }}"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition"
                            title="{{ __('Duplicar') }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </a>
                        <form action="{{ route('contratos.destroy', $contrato) }}" method="POST"
                            onsubmit="return confirm('{{ __('¿Estás seguro de que deseas eliminar este contrato? Se eliminarán las actuaciones y las listas relacionadas.') }}')"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-red-50 text-red-600 text-xs font-bold border border-red-100 hover:bg-red-100 transition"
                                title="{{ __('Eliminar') }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-indigo-50/80 bg-white p-8 text-center shadow-bento">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-500">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 14.25v-8.25A2.25 2.25 0 0017.25 3.75H6.75A2.25 2.25 0 004.5 6v12a2.25 2.25 0 002.25 2.25h7.5m-6-12h7.5m-7.5 4.5h4.5m5.25 2.25v6m3-3h-6" />
                        </svg>
                    </div>
                    <p class="mt-4 text-sm font-bold text-slate-800">{{ __('Sin resultados') }}</p>
                    <p class="mt-1 text-xs text-slate-500">{{ __('No hay contratos para este filtro.') }}</p>
                    <a href="{{ route('contratos.create') }}"
                        class="mt-4 inline-flex items-center gap-1.5 rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow-sm hover:bg-indigo-700">
                        {{ __('Crear primer contrato') }}
                    </a>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $contratos->links() }}
            </div>
        </div>

        {{-- Desktop Table Layout (Pantallas >= md) --}}
        <div class="hidden md:block overflow-hidden rounded-3xl border border-indigo-50/80 bg-white shadow-bento">
            <table class="min-w-full divide-y divide-indigo-50">
                <thead>
                    <tr class="bg-[#EEF1FA]/60">
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Població') }}
                        </th>
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Descripció') }}
                        </th>
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Dates') }}
                        </th>
                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Contacte') }}
                        </th>
                        <th scope="col" class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Actuacions') }}
                        </th>
                        <th scope="col" class="px-5 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">
                            {{ __('Accions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50/70 bg-white">
                    @forelse ($contratos as $contrato)
                        <tr class="group cursor-pointer hover:bg-indigo-50/40 transition"
                            data-url="{{ route('contratos.edit', $contrato->id) }}">
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-50/80 px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100/70">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $contrato->poblacion }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-sm text-slate-900 group-hover:text-indigo-600 transition">
                                    {{ $contrato->descripcion }}
                                </div>
                                @if ($contrato->observacions)
                                    <div class="text-xs text-slate-400 truncate max-w-xs mt-0.5">
                                        {{ $contrato->observacions }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-xs text-slate-600">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>
                                        {{ $contrato->fechainicio ? \Carbon\Carbon::parse($contrato->fechainicio)->format('d/m/Y') : '-' }}
                                    </span>
                                    <span class="text-slate-400">→</span>
                                    <span>
                                        {{ $contrato->fechafin ? \Carbon\Carbon::parse($contrato->fechafin)->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-xs text-slate-600">
                                @if ($contrato->contacto)
                                    <div class="font-semibold text-slate-800">{{ $contrato->contacto }}</div>
                                    @if ($contrato->telefono || $contrato->correo)
                                        <div class="text-[11px] text-slate-400">
                                            {{ $contrato->telefono ?? $contrato->correo }}
                                        </div>
                                    @endif
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('contratos.actuaciones.index', ['contrato' => $contrato->id]) }}"
                                    class="inline-flex items-center gap-1.5 rounded-2xl bg-indigo-50 px-3 py-1.5 text-xs font-bold text-indigo-700 border border-indigo-100 hover:bg-indigo-100 transition shadow-2xs">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ __('Actuacions') }}</span>
                                </a>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-right text-xs font-medium">
                                <div class="inline-flex items-center gap-1">
                                    <a href="{{ route('contratos.edit', $contrato->id) }}"
                                        class="rounded-xl p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition"
                                        title="{{ __('Editar') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('contratos.duplicate', $contrato->id) }}"
                                        class="rounded-xl p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition"
                                        title="{{ __('Duplicar') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('contratos.destroy', $contrato) }}" method="POST"
                                        onsubmit="return confirm('{{ __('¿Estás seguro de que deseas eliminar este contrato? Se eliminarán las actuaciones y las listas relacionadas.') }}')"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-xl p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 transition"
                                            title="{{ __('Eliminar') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="mx-auto max-w-md">
                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-500">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 14.25v-8.25A2.25 2.25 0 0017.25 3.75H6.75A2.25 2.25 0 004.5 6v12a2.25 2.25 0 002.25 2.25h7.5m-6-12h7.5m-7.5 4.5h4.5m5.25 2.25v6m3-3h-6" />
                                        </svg>
                                    </div>
                                    <p class="mt-4 text-sm font-bold text-slate-800">{{ __('Sin resultados') }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ __('No hay contratos para este filtro.') }}</p>
                                    <a href="{{ route('contratos.create') }}"
                                        class="mt-4 inline-flex items-center gap-1.5 rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow-sm hover:bg-indigo-700">
                                        {{ __('Crear primer contrato') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="border-t border-indigo-50 px-6 py-4">
                {{ $contratos->links() }}
            </div>
        </div>
    </div>

    {{-- Barra Flotante Inferior (Neo-Bento Claro) --}}
    <footer class="fixed bottom-0 left-0 z-20 w-full bg-white/90 backdrop-blur-2xl border-t border-indigo-100/80 shadow-glass">
        <div class="flex justify-center items-center py-2.5 px-4">
            <a href="{{ route('contratos.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>{{ __('Nou contracte') }}</span>
            </a>
        </div>
    </footer>

    <script>
        document.getElementById('yearSelect').addEventListener('change', function() {
            var year = this.value;
            var params = new URLSearchParams(window.location.search);
            var search = params.get('search');
            var targetUrl = "/contratos/year/" + year;

            if (search) {
                targetUrl += "?search=" + encodeURIComponent(search);
            }

            window.location.href = targetUrl;
        });

        // Ocultar mensajes flash con fade-out
        window.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.flash-alert');
            const fadeDurationMs = 700;

            alerts.forEach(el => {
                setTimeout(() => {
                    el.classList.add('opacity-0');
                    setTimeout(() => el.classList.add('hidden'), fadeDurationMs);
                }, 4000);
            });

            document.querySelectorAll('tbody tr[data-url]').forEach(row => {
                row.addEventListener('click', (e) => {
                    if (e.target.closest('a, button, form')) return;
                    window.location.href = row.dataset.url;
                });
            });
        });
    </script>
</x-app-layout>
