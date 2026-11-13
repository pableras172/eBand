<div class="mx-auto max-w-7xl space-y-6 px-3 py-5 sm:px-6 lg:px-8 pb-32">

    {{-- HEADER Y BREADCRUMBS --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('payments.index') }}">{{ __('Liquidacions') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Generar Nova Liquidació') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ __('Generar Nova Liquidació') }}
                        </h1>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Genera els pagaments d\'actuacions per a un músic o per a tota la banda de forma massiva') }}
                    </p>
                </div>
            </div>

            <div>
                <a wire:navigate href="{{ route('payments.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold border border-slate-200/60 shadow-xs transition active:scale-95">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Tornar al llistat') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    {{-- TOASTS --}}
    <x-ui.toast timeout=5000 on="saved">{{ __('common.pagocreado') }}</x-ui.toast>
    <x-ui.toast timeout=5000 on="errorpayment" color="red">{{ __('Se ha producido un error generando el pago') }}</x-ui.toast>

    {{-- GRID PRINCIPAL (FORMULARIO + PREVISUALIZACIÓN) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- COLUMNA IZQUIERDA: FORMULARIO BENTO --}}
        <div class="lg:col-span-5 rounded-3xl border border-indigo-50/80 bg-white p-6 shadow-bento space-y-5">
            <div class="flex items-center gap-2.5 border-b border-indigo-50/70 pb-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold font-headline text-slate-800 uppercase tracking-wider">{{ __('Paràmetres de la liquidació') }}</h2>
                    <p class="text-[11px] text-slate-400">{{ __('Configura el destinatari, dates i descripció del pagament') }}</p>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-4">
                {{-- Destinatari --}}
                <div>
                    <label for="users_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('Destinatari del pagament') }} <span class="text-rose-500">*</span>
                    </label>
                    <select wire:model.live="form.users_id" id="users_id"
                        class="w-full text-sm bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 p-3 transition cursor-pointer">
                        <option value="-1">{{ __('Selecciona una opció...') }}</option>
                        <option value="0" class="font-bold text-indigo-700">👥 {{ __('Tots els músics actius (Liquidació massiva)') }}</option>
                        <optgroup label="{{ __('Músics individuals') }}">
                            @foreach ($users as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                    @error('form.users_id')
                        <p class="text-rose-600 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha de Pago --}}
                <div>
                    <label for="fechaPago" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('Data de pagament / liquidació') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" wire:model="form.fechaPago" id="fechaPago"
                        class="w-full text-sm bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 p-3 transition" />
                    @error('form.fechaPago')
                        <p class="text-rose-600 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripció --}}
                <div>
                    <label for="descripcion" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('Descripció o Concepte') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" wire:model="form.descripcion" id="descripcion"
                        placeholder="{{ __('Ex: Liquidació Concert Santa Cecília 2026') }}"
                        class="w-full text-sm bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 p-3 transition" />
                    @error('form.descripcion')
                        <p class="text-rose-600 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Rang de Dates d'Actuacions --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="fechaInicio" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Data Inici') }} <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" wire:model.live="form.fechaInicio" id="fechaInicio"
                            class="w-full text-sm bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 p-3 transition" />
                        @error('form.fechaInicio')
                            <p class="text-rose-600 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="fechaFin" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Data Fi') }} <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" wire:model.live="form.fechaFin" id="fechaFin"
                            class="w-full text-sm bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 p-3 transition" />
                        @error('form.fechaFin')
                            <p class="text-rose-600 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Banner informatiu --}}
                <div class="rounded-2xl bg-indigo-50/70 border border-indigo-100 p-3.5 flex items-start gap-3">
                    <div class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs text-indigo-900 leading-relaxed">
                        {{ __('Es crearan els registres de pagament individuals consolidats en un Resum de Liquidació. Només s\'inclouran les actuacions confirmades i que apliquen pagament en el rang indicat.') }}
                    </p>
                </div>

                {{-- Botó Submit --}}
                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-600/20 transition active:scale-95 disabled:opacity-60 cursor-pointer">
                        <svg wire:loading.remove wire:target="save" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="save">{{ __('Generar liquidació') }}</span>
                        <span wire:loading wire:target="save">{{ __('Processant liquidació...') }}</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- COLUMNA DERECHA: PREVISUALIZACIÓN DE ACTUACIONES INCLUIDAS --}}
        <div class="lg:col-span-7 rounded-3xl border border-indigo-50/80 bg-white p-6 shadow-bento space-y-4">
            <div class="flex items-center justify-between border-b border-indigo-50/70 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold font-headline text-slate-800 uppercase tracking-wider">{{ __('Previsualització d\'actuacions') }}</h2>
                        <p class="text-[11px] text-slate-400">{{ __('Actuacions que compleixen les condicions seleccionades') }}</p>
                    </div>
                </div>

                @if ($actuaciones && $actuaciones->count() > 0)
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 border border-indigo-100">
                        <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                        <span>{{ $actuaciones->count() }} {{ __('actuacions trobades') }}</span>
                    </span>
                @else
                    <span class="rounded-xl bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-500">
                        0 {{ __('actes') }}
                    </span>
                @endif
            </div>

            {{-- SPINNER DE CARGA LIVEWIRE --}}
            <div wire:loading wire:target="form.users_id, form.fechaInicio, form.fechaFin, consultarActuaciones" class="w-full py-12 text-center space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 mx-auto flex items-center justify-center animate-spin">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <p class="text-xs font-bold text-slate-600">{{ __('Carregant actuacions pendents...') }}</p>
            </div>

            {{-- LISTADO DE ACTUACIONES (CUANDO NO ESTÁ CARGANDO) --}}
            <div wire:loading.remove wire:target="form.users_id, form.fechaInicio, form.fechaFin, consultarActuaciones">
                @if ($actuaciones && $actuaciones->count() > 0)

                    {{-- VISTA MÓVIL (md:hidden) --}}
                    <div class="md:hidden space-y-3">
                        @foreach ($actuaciones as $actuacion)
                            @php
                                $tipo = $actuacion->tipoactuacion;
                                $iconUrl = \App\Models\Tipoactuacion::resolveIconUrl($tipo?->icon);
                            @endphp
                            <div class="rounded-2xl border border-indigo-50 bg-[#F5F6FC]/60 p-3.5 space-y-2.5">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="inline-flex items-center gap-1.5 rounded-xl bg-white px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100 shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}</span>
                                    </div>

                                    @if ($tipo)
                                        <div class="inline-flex items-center gap-1.5 rounded-xl bg-white px-2 py-0.5 text-[11px] font-bold text-slate-700 border border-indigo-50">
                                            <img class="w-3.5 h-3.5 object-contain rounded-full"
                                                src="{{ $iconUrl }}"
                                                onerror="this.onerror=null;this.src='{{ asset(\App\Models\Tipoactuacion::DEFAULT_ICON_PATH) }}';"
                                                alt="{{ $tipo->nombre }}">
                                            <span>{{ $tipo->nombre }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <h4 class="text-xs font-bold text-slate-800 leading-snug">{{ $actuacion->descripcion }}</h4>
                                    @if ($actuacion->contrato?->poblacion)
                                        <p class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ $actuacion->contrato->poblacion }}</span>
                                        </p>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between pt-1 border-t border-indigo-50/80 text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="font-extrabold text-slate-900">{{ number_format($actuacion->preciomusico, 2) }} €</span>
                                        @if ($actuacion->preciocoche > 0)
                                            <span class="text-[10px] text-slate-500 font-medium">+{{ number_format($actuacion->preciocoche, 2) }} € 🚗</span>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-1">
                                        @if ($actuacion->oficial)
                                            <span class="rounded-lg bg-indigo-50 px-1.5 py-0.5 text-[10px] font-bold text-indigo-700 border border-indigo-200">⭐ {{ __('Oficial') }}</span>
                                        @endif
                                        @if ($actuacion->pagado)
                                            <span class="rounded-lg bg-emerald-50 px-1.5 py-0.5 text-[10px] font-bold text-emerald-700 border border-emerald-200">✓ {{ __('Pagada') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- VISTA ESCRITORIO (hidden md:block) --}}
                    <div class="hidden md:block overflow-hidden rounded-2xl border border-indigo-50/80 bg-white">
                        <table class="min-w-full divide-y divide-indigo-50">
                            <thead>
                                <tr class="bg-[#EEF1FA]/60">
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        {{ __('Data') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        {{ __('Tipus') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        {{ __('Actuació') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        {{ __('Caixet base') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        {{ __('Estat') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-indigo-50/70 bg-white">
                                @foreach ($actuaciones as $actuacion)
                                    @php
                                        $tipo = $actuacion->tipoactuacion;
                                        $iconUrl = \App\Models\Tipoactuacion::resolveIconUrl($tipo?->icon);
                                    @endphp
                                    <tr class="hover:bg-indigo-50/30 transition">
                                        {{-- Data --}}
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-50/80 px-2.5 py-1 text-xs font-bold text-indigo-700 border border-indigo-100/70">
                                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }}</span>
                                            </div>
                                        </td>

                                        {{-- Tipus --}}
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if ($tipo)
                                                <div class="inline-flex items-center gap-1.5 rounded-xl bg-[#F5F6FC] px-2.5 py-1 text-xs font-bold text-slate-700 border border-indigo-50">
                                                    <img class="w-3.5 h-3.5 object-contain rounded-full"
                                                        src="{{ $iconUrl }}"
                                                        onerror="this.onerror=null;this.src='{{ asset(\App\Models\Tipoactuacion::DEFAULT_ICON_PATH) }}';"
                                                        alt="{{ $tipo->nombre }}">
                                                    <span>{{ $tipo->nombre }}</span>
                                                </div>
                                            @else
                                                <span class="text-xs text-slate-400">-</span>
                                            @endif
                                        </td>

                                        {{-- Actuació & Població --}}
                                        <td class="px-4 py-3">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-bold text-slate-800">{{ $actuacion->descripcion }}</span>
                                                @if ($actuacion->contrato?->poblacion)
                                                    <span class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        <span>{{ $actuacion->contrato->poblacion }}</span>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Caixet Base & Plus Vehicle --}}
                                        <td class="px-4 py-3 whitespace-nowrap text-right">
                                            <span class="text-xs font-extrabold text-slate-900">{{ number_format($actuacion->preciomusico, 2) }} €</span>
                                            @if ($actuacion->preciocoche > 0)
                                                <span class="block text-[10px] text-slate-400 font-medium">+{{ number_format($actuacion->preciocoche, 2) }} € 🚗</span>
                                            @endif
                                        </td>

                                        {{-- Estat / Badges --}}
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            <div class="inline-flex items-center gap-1.5 justify-center">
                                                @if ($actuacion->oficial)
                                                    <span class="rounded-xl bg-indigo-50 px-2 py-0.5 text-[10px] font-bold text-indigo-700 border border-indigo-200" title="{{ __('Acte oficial') }}">
                                                        ⭐ {{ __('Oficial') }}
                                                    </span>
                                                @endif

                                                @if ($actuacion->pagado)
                                                    <span class="rounded-xl bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700 border border-emerald-200" title="{{ __('Actuació liquidada') }}">
                                                        ✓ {{ __('Pagada') }}
                                                    </span>
                                                @else
                                                    <span class="rounded-xl bg-amber-50 px-2 py-0.5 text-[10px] font-bold text-amber-700 border border-amber-200">
                                                        ⏳ {{ __('Pendent') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @elseif (empty($form['fechaInicio']) || empty($form['fechaFin']))
                    {{-- ESTADO VACÍO: RANGO DE FECHAS NO DEFINIDO --}}
                    <div class="rounded-2xl border border-dashed border-indigo-100 bg-[#F5F6FC]/50 p-8 text-center space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 mx-auto flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Selecciona el rang de dates') }}</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">
                            {{ __('Selecciona el rang de dates (Inici i Fi) per a consultar automàticament les actuacions a liquidar.') }}
                        </p>
                    </div>

                @else
                    {{-- ESTADO VACÍO: NINGUNA ACTUACIÓN EN EL RANGO --}}
                    <div class="rounded-2xl border border-dashed border-slate-200 bg-[#F5F6FC]/50 p-8 text-center space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('No s\'han trobat actuacions pendents') }}</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">
                            {{ __('No hi ha actuacions pendents de pagament per al filtre seleccionat en el rang de dates indicat.') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
