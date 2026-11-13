<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('contratos.index') }}">{{ __('Contractes') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('contratos.actuaciones.index', ['contrato' => $contrato->id]) }}">
                            {{ $contrato->poblacion }}
                        </x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>
                            {{ isset($actuacion) ? __('Modificar actuació') : __('Afegir actuació') }}
                        </x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ isset($actuacion) ? __('Modificar actuació') : __('Afegir actuació') }}
                    </h1>
                    <p class="mt-0.5 text-xs text-slate-500">
                        {{ $contrato->descripcion }} ({{ $contrato->poblacion }})
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('contratos.actuaciones.index', ['contrato' => $contrato->id]) }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-50 border border-indigo-100 px-4 py-2.5 text-xs font-bold text-indigo-700 shadow-xs hover:bg-indigo-100 transition active:scale-95">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>{{ __('Veure totes les actuacions') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto py-4 px-3 sm:px-6 lg:px-8 pb-32 max-w-4xl">
        @if (isset($message))
            <div class="flash-alert flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 py-3 px-4 mb-5 rounded-2xl text-xs font-semibold shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ $message }}</span>
            </div>
        @endif

        {{-- Tarjeta Bento Formulario --}}
        <div class="rounded-3xl border border-indigo-50/80 bg-white p-5 sm:p-7 shadow-bento space-y-6">
            <div class="flex items-center gap-3 border-b border-indigo-50 pb-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold font-headline text-slate-900">
                        {{ isset($actuacion) ? __('Dades de l\'actuació') : __('Nova actuació del contracte') }}
                    </h2>
                    <p class="text-xs text-slate-500">
                        {{ __('Completa la informació, tipus d\'acte, assistència i imports') }}
                    </p>
                </div>
            </div>

            <form
                action="{{ isset($actuacion) ? route('actuacion.update', $actuacion->id) : route('actuacion.store') }}"
                method="POST"
                class="space-y-4">
                @csrf
                @if (isset($actuacion))
                    @method('PUT')
                @endif
                <input type="hidden" id="contratos_id" name="contratos_id" value="{{ $contrato->id }}" />

                {{-- Fecha y Tipo --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <div>
                        <label for="fechaActuacion" class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                            {{ __('Data actuacio') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="fechaActuacion" name="fechaActuacion" required
                            class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                            value="{{ old('fechaActuacion', isset($actuacion) ? $actuacion->fechaActuacion : '') }}">
                    </div>

                    <div>
                        <label for="tipoactuacions_id" class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                            {{ __('Tipus') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="tipoactuacions_id" name="tipoactuacions_id" required
                            class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                            <option value="">{{ __('Selecciona tipus') }}</option>
                            @foreach ($tipoActuacion as $tipo)
                                <option value="{{ $tipo->id }}" @selected(old('tipoactuacions_id', isset($actuacion) ? $actuacion->tipoactuacions_id : null) == $tipo->id)>
                                    {{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="descripcion" class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                        {{ __('Descripció') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea id="descripcion" name="descripcion" rows="2" required
                        placeholder="{{ __('Exemple: Cercavila de la Puríssima, Concert de Gala, etc.') }}"
                        class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] p-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">{{ old('descripcion', isset($actuacion) ? $actuacion->descripcion : '') }}</textarea>
                </div>

                {{-- Personal y Vehículos --}}
                <div class="rounded-2xl border border-indigo-50 bg-slate-50/50 p-4 space-y-3">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-indigo-700">
                        {{ __('Personal i Vehicles') }}
                    </span>

                    <div class="grid grid-cols-2 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label for="musicos" class="mb-1 block text-xs font-bold text-slate-600">{{ __('Numero musics') }}</label>
                            <input type="number" id="musicos" name="musicos" min="0" placeholder="0"
                                value="{{ old('musicos', isset($actuacion) ? $actuacion->musicos : '') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                        </div>

                        <div>
                            <label for="preciomusico" class="mb-1 block text-xs font-bold text-slate-600">{{ __('Preu music') }} (€)</label>
                            <input type="number" id="preciomusico" name="preciomusico" step="0.01" placeholder="0.00"
                                value="{{ old('preciomusico', isset($actuacion) ? $actuacion->preciomusico : '') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                        </div>

                        <div>
                            <label for="coches" class="mb-1 block text-xs font-bold text-slate-600">{{ __('Cantitat de cotxes') }}</label>
                            <input type="number" id="coches" name="coches" min="0" placeholder="0"
                                value="{{ old('coches', isset($actuacion) ? $actuacion->coches : '') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                        </div>

                        <div>
                            <label for="preciocoche" class="mb-1 block text-xs font-bold text-slate-600">{{ __('Preu cotxe') }} (€)</label>
                            <input type="number" id="preciocoche" name="preciocoche" step="0.01" placeholder="0.00"
                                value="{{ old('preciocoche', isset($actuacion) ? $actuacion->preciocoche : '') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                        </div>

                        <div>
                            <label for="furgonas" class="mb-1 block text-xs font-bold text-slate-600">{{ __('Cantitat de furgones') }}</label>
                            <input type="number" id="furgonas" name="furgonas" min="0" placeholder="0"
                                value="{{ old('furgonas', isset($actuacion) ? $actuacion->furgonas : '') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                        </div>

                        <div>
                            <label for="preciofurgona" class="mb-1 block text-xs font-bold text-slate-600">{{ __('Precio furgona') }} (€)</label>
                            <input type="number" id="preciofurgona" name="preciofurgona" step="0.01" placeholder="0.00"
                                value="{{ old('preciofurgona', isset($actuacion) ? $actuacion->preciofurgona : '') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                        </div>
                    </div>
                </div>

                {{-- Observaciones y Porcentaje en la misma línea --}}
                <div class="grid grid-cols-12 gap-2.5 sm:gap-3 items-start">
                    <div class="col-span-8 sm:col-span-9">
                        <label for="observaciones" class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600 whitespace-nowrap">{{ __('Observacions') }}</label>
                        <input type="text" id="observaciones" name="observaciones"
                            placeholder="{{ __('Notes d\'horari, vestuari, etc.') }}"
                            value="{{ old('observaciones', isset($actuacion) ? $actuacion->observaciones : '') }}"
                            class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2 px-3 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                    </div>

                    <div class="col-span-4 sm:col-span-3">
                        <label for="porcentajepersonal" class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600 whitespace-nowrap">{{ __('% Personal') }}</label>
                        <input type="number" id="porcentajepersonal" name="porcentajepersonal" step="0.01" placeholder="100%"
                            value="{{ old('porcentajepersonal', isset($actuacion) ? $actuacion->porcentajepersonal : '') }}"
                            class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                    </div>
                </div>

                {{-- Opciones y Checkboxes --}}
                <div class="pt-2 border-t border-indigo-50 space-y-2">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        {{ __('Estat i Configuració') }}
                    </span>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <input type="hidden" name="pagado" value="0">
                        <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" id="pagado" name="pagado" value="1"
                                class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500"
                                @checked(old('pagado', isset($actuacion) ? $actuacion->pagado : false))>
                            <span>{{ __('Pagat') }}</span>
                        </label>

                        <input type="hidden" name="aplicaporcentaje" value="0">
                        <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" id="aplicaporcentaje" name="aplicaporcentaje" value="1"
                                class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500"
                                @checked(old('aplicaporcentaje', !isset($actuacion) || $actuacion->aplicaporcentaje))>
                            <span>{{ __('Aplicar porcentaje') }}</span>
                        </label>

                        <input type="hidden" name="noaplicapago" value="0">
                        <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" id="noaplicapago" name="noaplicapago" value="1"
                                class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500"
                                @checked(old('noaplicapago', isset($actuacion) ? $actuacion->noaplicapago : false))>
                            <span class="truncate">{{ __('No aplica en los pagos') }}</span>
                        </label>

                        <input type="hidden" name="visible" value="0">
                        <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" id="visible" name="visible" value="1"
                                class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500"
                                @checked(old('visible', !isset($actuacion) || $actuacion->visible))>
                            <span>{{ __('Visible') }}</span>
                        </label>

                        <input type="hidden" name="oficial" value="0">
                        <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" id="oficial" name="oficial" value="1"
                                class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500"
                                @checked(old('oficial', isset($actuacion) ? $actuacion->oficial : false))>
                            <span>{{ __('Acte Oficial') }}</span>
                        </label>

                        <input type="hidden" name="is_draft" value="0">
                        <label class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 hover:bg-indigo-50/50 transition cursor-pointer text-xs font-semibold text-slate-700">
                            <input type="checkbox" id="is_draft" name="is_draft" value="1"
                                class="rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500"
                                @checked(old('is_draft', isset($actuacion) ? $actuacion->is_draft : false))>
                            <span>{{ __('Borrador') }}</span>
                        </label>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-indigo-50">
                    <a href="{{ route('contratos.actuaciones.index', ['contrato' => $contrato->id]) }}"
                        class="rounded-2xl border border-indigo-100 bg-[#F5F6FC] px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-700 transition">
                        {{ __('Cancelar') }}
                    </a>
                    <button type="submit"
                        class="rounded-2xl bg-indigo-600 px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 transition active:scale-95">
                        {{ isset($actuacion) ? __('Guardar canvis') : __('Afegir actuació') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
