@php
    $inicioRango = now()->startOfDay();
    $finRango = now()->addDays(30)->endOfDay();
    $inicioSemana = now()->startOfDay();
    $finSemana = now()->addDays(7)->endOfDay();

    $actuacion = \App\Models\Actuacion::join('listas', 'actuacions.id', '=', 'listas.actuacions_id')
        ->join('listas_user', 'listas.id', '=', 'listas_user.listas_id')
        ->where('listas_user.user_id', session('usuarioActivo')->id)
        ->where('actuacions.fechaActuacion', '>=', $inicioRango)
        ->where('actuacions.fechaActuacion', '<=', $finRango)
        ->orderBy('actuacions.fechaActuacion', 'asc')
        ->select('actuacions.*', 'listas_user.disponible as disp', 'listas_user.user_id')
        ->get();

    $actuacionesBanda = \App\Models\Actuacion::whereBetween('fechaActuacion', [$inicioSemana, $finSemana])
        ->with('tipo')
        ->with('contrato')
        ->get();

    $actuacionDisponible = $actuacion->firstWhere('disp', true);
    $misActuacionesProximas = $actuacion->filter(function ($actuacionItem) use ($inicioSemana, $finSemana) {
        $fechaActuacion = \Carbon\Carbon::parse($actuacionItem->fechaActuacion);

        return $actuacionItem->disp
            && $fechaActuacion->greaterThanOrEqualTo($inicioSemana)
            && $fechaActuacion->lessThanOrEqualTo($finSemana);
    })->sortBy('fechaActuacion');
    $proximasActuaciones = $actuacionesBanda->sortBy('fechaActuacion');
    $actuacionesNoDisponibles = $actuacion->where('disp', false);
@endphp

<div class="space-y-4">
    <section class="overflow-hidden rounded-2xl border border-sky-100 bg-white shadow-sm">
        <div class="border-b border-sky-100 bg-gradient-to-r from-sky-50 to-cyan-50 px-4 py-3">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-sky-700">
                        {{ __('Planning') }}
                    </p>
                    <h2 class="mt-1 text-base font-bold text-slate-900">
                        {{ __('Tu próxima actuación') }}
                    </h2>
                </div>
                <span class="inline-flex items-center rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                    {{ $actuacionDisponible ? __('1 activa') : __('Sin próximas') }}
                </span>
            </div>
        </div>

        <div class="px-4 py-4">
            @if ($actuacionDisponible)
                <div class="rounded-xl border border-sky-100 bg-sky-50/70 p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs font-medium uppercase tracking-wide text-sky-700">
                                {{ \Carbon\Carbon::parse($actuacionDisponible->fechaActuacion)->format('d/m/Y') }}
                            </p>
                            <p class="mt-1 truncate text-base font-semibold text-slate-900">
                                {{ $actuacionDisponible->descripcion }}
                            </p>
                        </div>

                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacionDisponible->id]) }}"
                            class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white text-[#b06d36] shadow-sm ring-1 ring-sky-100 transition hover:translate-x-0.5 hover:bg-sky-50">
                            <svg width="22" height="22" viewBox="0 0 24 24" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" aria-hidden="true">
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M14.6470979,6.30372605 L14.7197247,6.21961512 C14.9860188,5.95337607 15.402685,5.92921307
                                        15.6962739,6.14709787 L15.7803849,6.21972471 L20.7769976,11.21737 C21.0430885,11.4835159 21.0673924,11.8999028
                                        20.8498298,12.1934928 L20.777305,12.2776129 L15.7806923,17.2810585 C15.4879993,17.5741518 15.0131257,17.5744763
                                        14.7200324,17.2817833 C14.453584,17.0156987 14.4290932,16.5990517 14.646747,16.3052914 L14.7193077,16.2211234
                                        L18.4301989,12.504 L3.75019891,12.504946 C3.37050315,12.504946 3.05670795,12.2227922 3.00704553,11.8567166
                                        L3.00019891,11.754946 C3.00019891,11.3752503 3.28235279,11.0614551 3.64842835,11.0117927 L3.75019891,11.004946
                                        L18.4431989,11.004 L14.7196151,7.28027529 C14.4533761,7.01398122 14.4292131,6.59731504 14.6470979,6.30372605
                                        L14.7197247,6.21961512 L14.6470979,6.30372605 Z"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>
            @else
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                    <p class="font-medium text-slate-800">{{ __('Nada a la vista') }}</p>
                    <p class="mt-1">{{ __('No hay actuaciones') }}</p>
                </div>
            @endif
        </div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-emerald-100 bg-white shadow-sm">
        <div class="border-b border-emerald-100 bg-gradient-to-r from-emerald-50 to-teal-50 px-4 py-3">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">
                        {{ __('Mis actuaciones') }}
                    </p>
                    <h2 class="mt-1 text-base font-bold text-slate-900">
                        {{ __('Mis próximas 7 días') }}
                    </h2>
                </div>
                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                    {{ $misActuacionesProximas->count() }}
                </span>
            </div>
        </div>

        <div class="px-4 py-4">
            @if ($misActuacionesProximas->count() > 0)
                <div class="space-y-3">
                    @foreach ($misActuacionesProximas as $actuacionu)
                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacionu->id]) }}"
                            class="group flex items-center justify-between gap-3 rounded-xl border border-emerald-100 bg-emerald-50/60 px-4 py-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                            <div class="min-w-0">
                                <p class="text-xs font-medium uppercase tracking-wide text-emerald-700">
                                    {{ \Carbon\Carbon::parse($actuacionu->fechaActuacion)->format('d/m/Y') }}
                                </p>
                                <p class="mt-1 truncate text-sm font-semibold text-slate-900">
                                    {{ $actuacionu->descripcion }}
                                </p>
                            </div>

                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-[#b06d36] shadow-sm ring-1 ring-emerald-100 transition group-hover:translate-x-0.5">
                                <svg width="18" height="18" viewBox="0 0 24 24" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" aria-hidden="true">
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M14.6470979,6.30372605 L14.7197247,6.21961512 C14.9860188,5.95337607 15.402685,5.92921307
                                            15.6962739,6.14709787 L15.7803849,6.21972471 L20.7769976,11.21737 C21.0430885,11.4835159 21.0673924,11.8999028
                                            20.8498298,12.1934928 L20.777305,12.2776129 L15.7806923,17.2810585 C15.4879993,17.5741518 15.0131257,17.5744763
                                            14.7200324,17.2817833 C14.453584,17.0156987 14.4290932,16.5990517 14.646747,16.3052914 L14.7193077,16.2211234
                                            L18.4301989,12.504 L3.75019891,12.504946 C3.37050315,12.504946 3.05670795,12.2227922 3.00704553,11.8567166
                                            L3.00019891,11.754946 C3.00019891,11.3752503 3.28235279,11.0614551 3.64842835,11.0117927 L3.75019891,11.004946
                                            L18.4431989,11.004 L14.7196151,7.28027529 C14.4533761,7.01398122 14.4292131,6.59731504 14.6470979,6.30372605
                                            L14.7197247,6.21961512 L14.6470979,6.30372605 Z"></path>
                                    </g>
                                </svg>
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                    <p class="font-medium text-slate-800">{{ __('Nada a la vista') }}</p>
                    <p class="mt-1">{{ __('No hay actuaciones') }}</p>
                </div>
            @endif
        </div>
    </section>

    <details class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <summary class="cursor-pointer list-none border-b border-slate-100 bg-gradient-to-r from-slate-50 to-zinc-50 px-4 py-3">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="mt-1 text-base font-bold text-slate-900">
                        {{ __('Todo lo de la Banda y mis No disponible') }}
                    </h2>
                </div>
                <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                    {{ __('Mostrar') }}
                </span>
            </div>
        </summary>

        <div class="space-y-4 px-4 py-4">
            <section class="overflow-hidden rounded-2xl border border-amber-100 bg-white shadow-sm">
                <div class="border-b border-amber-100 bg-gradient-to-r from-amber-50 to-orange-50 px-4 py-3">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-700">
                                {{ __('Agenda') }}
                            </p>
                            <h2 class="mt-1 text-base font-bold text-slate-900">
                                {{ __('En los próximos 7 días') }}
                            </h2>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                            {{ $proximasActuaciones->count() }}
                        </span>
                    </div>
                </div>

                <div class="px-4 py-4">
                    @if ($proximasActuaciones->count() > 0)
                        <div class="space-y-3">
                            @foreach ($proximasActuaciones as $actuacionb)
                                @php
                                    $fecha = $actuacionb->fechaActuacion;
                                @endphp
                                <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacionb->id]) }}"
                                    class="group flex items-center justify-between gap-3 rounded-xl border border-amber-100 bg-amber-50/60 px-4 py-3 transition hover:border-amber-200 hover:bg-amber-50">
                                    <div class="min-w-0">
                                        <p class="text-xs font-medium uppercase tracking-wide text-amber-700">
                                            {{ $fecha ? \Carbon\Carbon::parse($fecha)->format('d/m/Y') : __('Sin fecha') }}
                                        </p>
                                        <p class="mt-1 truncate text-sm font-semibold text-slate-900">
                                            {{ $actuacionb->descripcion }}
                                        </p>
                                        <p class="mt-1 truncate text-xs text-slate-500">
                                            {{ $actuacionb->contrato->poblacion }}
                                        </p>
                                    </div>

                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-[#b06d36] shadow-sm ring-1 ring-amber-100 transition group-hover:translate-x-0.5">
                                        <svg width="18" height="18" viewBox="0 0 24 24" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" aria-hidden="true">
                                            <g id="SVGRepo_iconCarrier">
                                                <path d="M14.6470979,6.30372605 L14.7197247,6.21961512 C14.9860188,5.95337607 15.402685,5.92921307
                                                    15.6962739,6.14709787 L15.7803849,6.21972471 L20.7769976,11.21737 C21.0430885,11.4835159 21.0673924,11.8999028
                                                    20.8498298,12.1934928 L20.777305,12.2776129 L15.7806923,17.2810585 C15.4879993,17.5741518 15.0131257,17.5744763
                                                    14.7200324,17.2817833 C14.453584,17.0156987 14.4290932,16.5990517 14.646747,16.3052914 L14.7193077,16.2211234
                                                    L18.4301989,12.504 L3.75019891,12.504946 C3.37050315,12.504946 3.05670795,12.2227922 3.00704553,11.8567166
                                                    L3.00019891,11.754946 C3.00019891,11.3752503 3.28235279,11.0614551 3.64842835,11.0117927 L3.75019891,11.004946
                                                    L18.4431989,11.004 L14.7196151,7.28027529 C14.4533761,7.01398122 14.4292131,6.59731504 14.6470979,6.30372605
                                                    L14.7197247,6.21961512 L14.6470979,6.30372605 Z"></path>
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                            <p class="font-medium text-slate-800">{{ __('Nada a la vista') }}</p>
                            <p class="mt-1">{{ __('No hay actuaciones') }}</p>
                        </div>
                    @endif
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl border border-rose-100 bg-white shadow-sm">
                <div class="border-b border-rose-100 bg-gradient-to-r from-rose-50 to-red-50 px-4 py-3">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-rose-700">
                                {{ __('Alertas') }}
                            </p>
                            <h2 class="mt-1 text-base font-bold text-slate-900">
                                {{ __('No disponble per a') }}
                            </h2>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                            {{ $actuacionesNoDisponibles->count() }}
                        </span>
                    </div>
                </div>

                <div class="px-4 py-4">
                    @if ($actuacionesNoDisponibles->count() > 0)
                        <div class="space-y-3">
                            @foreach ($actuacionesNoDisponibles as $actuacionu)
                                <div class="flex items-center justify-between gap-3 rounded-xl border border-rose-100 bg-rose-50/70 px-4 py-3">
                                    <div class="min-w-0">
                                        <p class="text-xs font-medium uppercase tracking-wide text-rose-700">
                                            {{ \Carbon\Carbon::parse($actuacionu->fechaActuacion)->format('d/m/Y') }}
                                        </p>
                                        <a href="{{ route('listas.actuacion', ['actuacion_id' => $actuacionu->id]) }}"
                                            class="mt-1 block truncate text-sm font-semibold text-slate-900 transition hover:text-rose-700">
                                            {{ $actuacionu->descripcion }}
                                        </a>
                                    </div>

                                    <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-rose-500 shadow-sm ring-1 ring-rose-100">
                                        <x-disponible w="22" h="22" />
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                            <p class="font-medium text-slate-800">{{ __('Nada a la vista') }}</p>
                            <p class="mt-1">{{ __('Parece que estas disponible para todo') }}</p>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </details>

    <a href="{{ route('actuacion.index') }}"
        class="flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-slate-800">
        {{ __('Calendari') }}
    </a>
</div>