<div>
    <button type="button" 
        wire:click="$set('displayingPreviewListas', true)"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold border border-slate-200 shadow-sm transition active:scale-95 shrink-0"
        title="{{ __('Previsualitzar convocatòria') }}">
        <span class="material-symbols-outlined text-[17px] text-primary">visibility</span>
        <span>{{ __('Previsualitzar') }}</span>
    </button>

    <x-dialog-modal wire:model.live="displayingPreviewListas">
        <x-slot name="title">
            <div class="flex items-center justify-between gap-3 border-b border-indigo-50 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-primary shrink-0"></span>
                    <h2 class="font-extrabold text-base sm:text-lg text-slate-800 tracking-tight">
                        {{ $actuacion->descripcion }}
                    </h2>
                </div>
                <button type="button" wire:click="$set('displayingPreviewListas', false)" class="text-slate-400 hover:text-slate-600 transition p-1 rounded-lg">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <div class="flex flex-wrap items-center gap-3 mt-2 text-xs font-semibold text-slate-500">
                <span class="inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span>
                    {{ $actuacion->contrato?->poblacion ?? __('No especificada') }}
                </span>
                <span class="inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px] text-slate-400">event</span>
                    {{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('d/m/Y') }} · {{ \Carbon\Carbon::parse($actuacion->fechaActuacion)->format('H:i') }} h
                </span>
                @if ($actuacion->musicos > 0)
                    <span class="inline-flex items-center gap-1 text-primary">
                        <span class="material-symbols-outlined text-[16px]">groups</span>
                        {{ $totalFilas ?? 0 }} / {{ $actuacion->musicos }} {{ __('músics') }}
                    </span>
                @endif
                @if ($actuacion->coches > 0)
                    <span class="inline-flex items-center gap-1 text-amber-600">
                        <span class="material-symbols-outlined text-[16px]">directions_car</span>
                        {{ $cochesCount ?? 0 }} / {{ $actuacion->coches }} {{ __('vehicles') }}
                    </span>
                @endif
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3 max-h-[60vh] sm:max-h-[65vh] overflow-y-auto pr-1">
                @foreach ($usuarios->groupBy('instrument_id') as $instrumento => $usuariosDelInstrumento)
                    @php
                        $nombreInst = $usuariosDelInstrumento->first()->instrument->name ?? __('Sense instrument');
                        $convocadosInst = $usuariosDelInstrumento->where('seleccionado', true)->count();
                    @endphp
                    <details class="group bg-surface-subtle border border-indigo-50/80 rounded-2xl p-2.5 transition" open>
                        <summary class="flex items-center justify-between cursor-pointer select-none font-bold text-xs text-on-surface uppercase tracking-wider py-1 px-1">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-primary transition-transform group-open:rotate-90">chevron_right</span>
                                <span>{{ $nombreInst }}</span>
                            </span>
                            <span class="text-[11px] font-extrabold text-primary bg-indigo-50 px-2 py-0.5 rounded-full border border-indigo-100">
                                {{ $convocadosInst }}
                            </span>
                        </summary>

                        <ul class="divide-y divide-slate-100 mt-2 bg-white rounded-xl border border-indigo-50/60 overflow-hidden">
                            @foreach ($usuariosDelInstrumento->sortBy('name')->sortBy('forastero') as $user)
                                @if (!$user->disponible || !$user->seleccionado)
                                    @continue
                                @endif
                                <li class="p-2.5 flex justify-between items-center text-xs {{ Auth::id() == $user->id ? 'bg-indigo-50/50 font-bold' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <img src="{{ asset($user->profile_photo_url) }}" alt="{{ $user->name }}"
                                            class="h-8 w-8 rounded-full object-cover border border-slate-200">
                                        <span class="font-medium text-slate-800">
                                            {{ $user->name }}
                                            @if ($user->forastero)
                                                <span class="ml-1.5 px-1.5 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-800 rounded">
                                                    {{ __('common.llogat') }}
                                                </span>
                                            @endif
                                            @if (Auth::id() == $user->id)
                                                <span class="ml-1.5 px-1.5 py-0.5 text-[10px] font-bold bg-indigo-100 text-indigo-700 rounded">
                                                    {{ __('Tu') }}
                                                </span>
                                            @endif
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        @if ($user->coche)
                                            <span class="text-xs" title="{{ __('Cotxe') }}">🚗</span>
                                        @endif
                                        @if ($user->furgona)
                                            <span class="text-xs" title="{{ __('Furgona') }}">🚐</span>
                                        @endif
                                        <span class="text-emerald-600 font-bold text-xs">✓</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </details>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex items-center justify-between w-full gap-2">
                <x-print w="32" h="32" a='{{ $actuacion->id }}' />
                <x-secondary-button wire:click="$set('displayingPreviewListas', false)" wire:loading.attr="disabled" class="rounded-xl">
                    {{ __('Tancar') }}
                </x-secondary-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
