@php
    $bandName = function_exists('tenant_name') && function_exists('tenant') && tenant()
        ? tenant_name()
        : ($bandSetting?->nombre ?? config('app.banda', config('app.name', 'eBand')));
    $bandLogo = $bandSetting?->logo ? asset('storage/'.$bandSetting->logo) : url('/imagenes/logo.png');
@endphp

<aside class="hidden lg:flex flex-col justify-between w-64 min-h-screen h-screen sticky top-0 bg-[#0B1120] border-r border-slate-800/80 shrink-0 p-4 z-40 select-none" aria-label="{{ __('Menú principal') }}">
    <div class="flex flex-col gap-6">
        {{-- Brand Logo & Band Badge --}}
        <div class="flex flex-col gap-3 pt-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-2">
                <img src="{{ $bandLogo }}" alt="{{ $bandName }}" class="h-9 w-auto object-contain brightness-110">
                <div class="flex flex-col min-w-0">
                    <span class="font-headline font-bold text-white text-base tracking-tight truncate">eBand</span>
                    <span class="text-[10px] text-blue-400 font-semibold uppercase tracking-wider">Command Center</span>
                </div>
            </a>

            {{-- Selector de Banda / Tenant Pill --}}
            <div class="flex items-center gap-2 bg-slate-900/90 border border-slate-800 rounded-xl px-3 py-2">
                <span class="material-symbols-outlined text-blue-400 text-[18px] shrink-0">groups</span>
                <span class="text-xs font-medium text-slate-200 truncate flex-1" title="{{ $bandName }}">{{ $bandName }}</span>
            </div>
        </div>

        {{-- Navigation Menu --}}
        <nav class="flex flex-col gap-1">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider px-3 mb-1">{{ __('Navegació') }}</span>

            {{-- Dashboard --}}
            @php $isDashboard = request()->routeIs('dashboard'); @endphp
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ $isDashboard ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30 font-semibold shadow-sm shadow-blue-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-900/60' }}">
                <span class="material-symbols-outlined text-[20px] {{ $isDashboard ? 'text-blue-400' : 'text-slate-400' }}">home</span>
                <span>{{ __('Inici') }}</span>
            </a>

            {{-- Actuaciones / Calendario --}}
            @php $isActuaciones = request()->routeIs('actuacion.*') || request()->routeIs('actuaciones.*'); @endphp
            <a href="{{ route('actuacion.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ $isActuaciones ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30 font-semibold shadow-sm shadow-blue-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-900/60' }}">
                <span class="material-symbols-outlined text-[20px] {{ $isActuaciones ? 'text-blue-400' : 'text-slate-400' }}">event</span>
                <span>{{ __('Actuacions i Assajos') }}</span>
            </a>

            {{-- Actividades --}}
            @php $isActividades = request()->routeIs('actividades.*'); @endphp
            <a href="{{ route('actividades.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ $isActividades ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30 font-semibold shadow-sm shadow-blue-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-900/60' }}">
                <span class="material-symbols-outlined text-[20px] {{ $isActividades ? 'text-blue-400' : 'text-slate-400' }}">local_activity</span>
                <span>{{ __('Activitats Internes') }}</span>
            </a>

            {{-- Músicos / Cuerdas --}}
            @if (Route::has('users.index'))
                @php $isMusicos = request()->routeIs('users.*') || request()->routeIs('musicos.*'); @endphp
                <a href="{{ route('users.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ $isMusicos ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30 font-semibold shadow-sm shadow-blue-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-900/60' }}">
                    <span class="material-symbols-outlined text-[20px] {{ $isMusicos ? 'text-blue-400' : 'text-slate-400' }}">groups</span>
                    <span>{{ __('Directori de Músics') }}</span>
                </a>
            @endif

            {{-- Mi Actividad --}}
            @php $isMyAct = request()->routeIs('actuaciones.usuario.anyo'); @endphp
            <a href="{{ route('actuaciones.usuario.anyo', [Auth::user()->id, date('Y')]) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all {{ $isMyAct ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30 font-semibold shadow-sm shadow-blue-500/10' : 'text-slate-400 hover:text-white hover:bg-slate-900/60' }}">
                <span class="material-symbols-outlined text-[20px] {{ $isMyAct ? 'text-blue-400' : 'text-slate-400' }}">badge</span>
                <span>{{ __('La meva activitat') }}</span>
            </a>
        </nav>
    </div>

    {{-- User Profile Card / Footer --}}
    <div class="pt-4 border-t border-slate-800/80">
        <div class="flex items-center justify-between p-2 rounded-xl bg-slate-900/80 border border-slate-800">
            <a href="{{ route('profile.show') }}" class="flex items-center gap-2.5 min-w-0 flex-1 hover:opacity-90">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-blue-500/30 shrink-0">
                <div class="flex flex-col min-w-0">
                    <span class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</span>
                    <span class="text-[11px] text-slate-400 truncate">{{ Auth::user()->instrument->name ?? __('Músic') }}</span>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit" aria-label="{{ __('Cerrar sesión') }}" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
