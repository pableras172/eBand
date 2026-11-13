@php
    $bandName = function_exists('tenant_name') && function_exists('tenant') && tenant()
        ? tenant_name()
        : ($bandSetting?->nombre ?? config('app.banda', config('app.name', 'eBand')));
    $bandLogo = $bandSetting?->logo ? asset('storage/'.$bandSetting->logo) : url('/imagenes/logo.png');
@endphp

<aside class="hidden lg:flex flex-col justify-between w-64 min-h-screen h-screen sticky top-0 bg-white border-r border-slate-200/80 shrink-0 p-4 z-40 select-none overflow-y-auto" aria-label="{{ __('Menú principal') }}">
    <div class="flex flex-col gap-5">
        {{-- Brand Logo & Band Badge --}}
        <div class="flex flex-col gap-2.5 pt-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-1">
                <img src="{{ $bandLogo }}" alt="{{ $bandName }}" class="h-8 w-auto object-contain">
                <div class="flex flex-col min-w-0">
                    <span class="font-headline font-extrabold text-on-surface text-base tracking-tight truncate">eBand</span>
                    <span class="text-[10px] text-primary font-bold uppercase tracking-wider">Neo-Bento Platform</span>
                </div>
            </a>

            {{-- Selector de Banda / Tenant Pill --}}
            <div class="flex items-center gap-2 bg-surface-subtle border border-indigo-100/60 rounded-2xl px-3 py-2">
                <span class="material-symbols-outlined text-primary text-[18px] shrink-0">groups</span>
                <span class="text-xs font-semibold text-on-surface truncate flex-1" title="{{ $bandName }}">{{ $bandName }}</span>
            </div>
        </div>

        {{-- Navigation Menu --}}
        <nav class="flex flex-col gap-1">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-1">{{ __('Navegació') }}</span>

            {{-- 1. Dashboard --}}
            @php $isDashboard = request()->routeIs('dashboard'); @endphp
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-2xl font-medium text-xs transition-all {{ $isDashboard ? 'bg-indigo-50 text-primary border border-indigo-100 font-bold shadow-sm' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                <span class="material-symbols-outlined text-[19px] {{ $isDashboard ? 'text-primary' : 'text-slate-400' }}">home</span>
                <span>{{ __('Inici') }}</span>
            </a>

            {{-- 2. Actuaciones / Calendario --}}
            @php $isActuaciones = request()->routeIs('actuacion.*') || request()->routeIs('actuaciones.*'); @endphp
            <a href="{{ route('actuacion.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-2xl font-medium text-xs transition-all {{ $isActuaciones ? 'bg-indigo-50 text-primary border border-indigo-100 font-bold shadow-sm' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                <span class="material-symbols-outlined text-[19px] {{ $isActuaciones ? 'text-primary' : 'text-slate-400' }}">event</span>
                <span>{{ __('Actuacions i Assajos') }}</span>
            </a>

            {{-- 3. Músicos / Cuerdas --}}
            @if (Route::has('users.index'))
                @php $isMusicos = request()->routeIs('users.*') || request()->routeIs('musicos.*'); @endphp
                <a href="{{ route('users.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-2xl font-medium text-xs transition-all {{ $isMusicos ? 'bg-indigo-50 text-primary border border-indigo-100 font-bold shadow-sm' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[19px] {{ $isMusicos ? 'text-primary' : 'text-slate-400' }}">groups</span>
                    <span>{{ __('Músics i Cordes') }}</span>
                </a>
            @endif

            {{-- 4. Actividades --}}
            @if (Route::has('actividades.index'))
                @php $isActividades = request()->routeIs('actividades.*'); @endphp
                <a href="{{ route('actividades.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-2xl font-medium text-xs transition-all {{ $isActividades ? 'bg-indigo-50 text-primary border border-indigo-100 font-bold shadow-sm' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[19px] {{ $isActividades ? 'text-primary' : 'text-slate-400' }}">celebration</span>
                    <span>{{ __('Activitats') }}</span>
                </a>
            @endif

            {{-- 5. Inventario --}}
            @if (Route::has('inventory.index') && (Auth::user()->can('admin') || Auth::user()->inventoryItems()->exists()))
                @php $isInv = request()->routeIs('inventory.*'); @endphp
                <a href="{{ route('inventory.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-2xl font-medium text-xs transition-all {{ $isInv ? 'bg-indigo-50 text-primary border border-indigo-100 font-bold shadow-sm' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[19px] {{ $isInv ? 'text-primary' : 'text-slate-400' }}">inventory_2</span>
                    <span>{{ __('Inventari') }}</span>
                </a>
            @endif

            {{-- 6. Liquidaciones / Pagos --}}
            @if (Route::has('payments.user') && Auth::check())
                @php $isPay = request()->routeIs('payments.*'); @endphp
                <a href="{{ route('payments.user', ['user' => Auth::id()]) }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-2xl font-medium text-xs transition-all {{ $isPay ? 'bg-indigo-50 text-primary border border-indigo-100 font-bold shadow-sm' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[19px] {{ $isPay ? 'text-primary' : 'text-slate-400' }}">payments</span>
                    <span>{{ __('Liquidacions') }}</span>
                </a>
            @endif

            {{-- 7. Sugerencias --}}
            @if (Route::has('suggestions.index'))
                @php $isSug = request()->routeIs('suggestions.*'); @endphp
                <a href="{{ route('suggestions.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-2xl font-medium text-xs transition-all {{ $isSug ? 'bg-indigo-50 text-primary border border-indigo-100 font-bold shadow-sm' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[19px] {{ $isSug ? 'text-primary' : 'text-slate-400' }}">lightbulb</span>
                    <span>{{ __('Bústia de Suggeriments') }}</span>
                </a>
            @endif

            {{-- 8. Mi Actividad / Estadísticas --}}
            @php $isMyAct = request()->routeIs('actuaciones.usuario.anyo'); @endphp
            <a href="{{ route('actuaciones.usuario.anyo', [Auth::user()->id, date('Y')]) }}"
               class="flex items-center gap-3 px-3 py-2 rounded-2xl font-medium text-xs transition-all {{ $isMyAct ? 'bg-indigo-50 text-primary border border-indigo-100 font-bold shadow-sm' : 'text-slate-600 hover:text-primary hover:bg-slate-50' }}">
                <span class="material-symbols-outlined text-[19px] {{ $isMyAct ? 'text-primary' : 'text-slate-400' }}">badge</span>
                <span>{{ __('El meu historial') }}</span>
            </a>

            {{-- SECCIÓN DE ADMINISTRACIÓN --}}
            @can('admin')
                <div class="pt-3 mt-2 border-t border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-1 block">{{ __('Administració') }}</span>

                    @if (Route::has('tipoactuacion.index'))
                        <a href="{{ route('tipoactuacion.index') }}"
                           class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-xs text-slate-600 hover:text-primary hover:bg-slate-50 transition">
                            <span class="material-symbols-outlined text-[17px] text-slate-400">category</span>
                            <span>{{ __('Tipus d\'actuació') }}</span>
                        </a>
                    @endif

                    @if (Route::has('instrument.index'))
                        <a href="{{ route('instrument.index') }}"
                           class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-xs text-slate-600 hover:text-primary hover:bg-slate-50 transition">
                            <span class="material-symbols-outlined text-[17px] text-slate-400">music_note</span>
                            <span>{{ __('Instruments') }}</span>
                        </a>
                    @endif

                    @if (Route::has('contratos.index'))
                        <a href="{{ route('contratos.index') }}"
                           class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-xs text-slate-600 hover:text-primary hover:bg-slate-50 transition">
                            <span class="material-symbols-outlined text-[17px] text-slate-400">description</span>
                            <span>{{ __('Contractes') }}</span>
                        </a>
                    @endif

                    @if (Route::has('announcements.index'))
                        <a href="{{ route('announcements.index') }}"
                           class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-xs text-slate-600 hover:text-primary hover:bg-slate-50 transition">
                            <span class="material-symbols-outlined text-[17px] text-slate-400">campaign</span>
                            <span>{{ __('Avisos i Comunicats') }}</span>
                        </a>
                    @endif

                    @if (Route::has('concert-programs.index'))
                        <a href="{{ route('concert-programs.index') }}"
                           class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-xs text-slate-600 hover:text-primary hover:bg-slate-50 transition">
                            <span class="material-symbols-outlined text-[17px] text-slate-400">menu_book</span>
                            <span>{{ __('Programes de concert') }}</span>
                        </a>
                    @endif

                    @if (Route::has('band-settings.edit'))
                        <a href="{{ route('band-settings.edit') }}"
                           class="flex items-center gap-3 px-3 py-1.5 rounded-xl text-xs text-slate-600 hover:text-primary hover:bg-slate-50 transition">
                            <span class="material-symbols-outlined text-[17px] text-slate-400">settings</span>
                            <span>{{ __('Dades de la banda') }}</span>
                        </a>
                    @endif
                </div>
            @endcan
        </nav>
    </div>

    {{-- User Profile Card / Footer --}}
    <div class="pt-3 border-t border-slate-100">
        <div class="flex items-center justify-between p-2 rounded-2xl bg-surface-subtle border border-indigo-50">
            <a href="{{ route('profile.show') }}" class="flex items-center gap-2.5 min-w-0 flex-1 hover:opacity-90">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-xl object-cover ring-2 ring-white shadow-sm shrink-0">
                <div class="flex flex-col min-w-0">
                    <span class="text-xs font-bold text-on-surface truncate">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-slate-500 truncate">{{ Auth::user()->instrument->name ?? __('Músic') }}</span>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit" aria-label="{{ __('Tancar sessió') }}" class="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-white transition-colors" title="{{ __('Tancar sessió') }}">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
