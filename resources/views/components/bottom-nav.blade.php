<nav class="fixed bottom-0 inset-x-0 z-50 pb-safe bg-[#0B1120]/90 backdrop-blur-xl border-t border-slate-800 shadow-[0_-4px_20px_rgba(0,0,0,0.5)] block lg:hidden" aria-label="{{ __('Navegación móvil') }}">
    <div class="flex items-center justify-around h-16 px-2 max-w-md mx-auto">
        {{-- 1. Inicio --}}
        @php $isDashboard = request()->routeIs('dashboard'); @endphp
        <a href="{{ route('dashboard') }}"
           class="group flex flex-col items-center justify-center min-w-[64px] min-h-[48px] py-1 transition-colors {{ $isDashboard ? 'text-blue-400 font-bold' : 'text-slate-400 hover:text-slate-200' }}">
            <div class="flex items-center justify-center w-12 h-7 rounded-full transition-all group-active:scale-95 {{ $isDashboard ? 'bg-blue-600/20 border border-blue-500/40 text-blue-400 shadow-sm shadow-blue-500/20' : 'text-slate-400' }}">
                <span class="material-symbols-outlined text-[22px]">home</span>
            </div>
            <span class="text-[11px] font-medium tracking-normal mt-0.5">{{ __('Inici') }}</span>
        </a>

        {{-- 2. Actuaciones / Calendario --}}
        @php $isActuaciones = request()->routeIs('actuacion.*') || request()->routeIs('actuaciones.*'); @endphp
        <a href="{{ route('actuacion.index') }}"
           class="group flex flex-col items-center justify-center min-w-[64px] min-h-[48px] py-1 transition-colors {{ $isActuaciones ? 'text-blue-400 font-bold' : 'text-slate-400 hover:text-slate-200' }}">
            <div class="flex items-center justify-center w-12 h-7 rounded-full transition-all group-active:scale-95 {{ $isActuaciones ? 'bg-blue-600/20 border border-blue-500/40 text-blue-400 shadow-sm shadow-blue-500/20' : 'text-slate-400' }}">
                <span class="material-symbols-outlined text-[22px]">event</span>
            </div>
            <span class="text-[11px] font-medium tracking-normal mt-0.5">{{ __('Actuacions') }}</span>
        </a>

        {{-- 3. Músicos / Cuerdas --}}
        @php $isMusicos = request()->routeIs('musicos.*') || request()->routeIs('users.*'); @endphp
        @if (Route::has('users.index'))
            <a href="{{ route('users.index') }}"
               class="group flex flex-col items-center justify-center min-w-[64px] min-h-[48px] py-1 transition-colors {{ $isMusicos ? 'text-blue-400 font-bold' : 'text-slate-400 hover:text-slate-200' }}">
                <div class="flex items-center justify-center w-12 h-7 rounded-full transition-all group-active:scale-95 {{ $isMusicos ? 'bg-blue-600/20 border border-blue-500/40 text-blue-400 shadow-sm shadow-blue-500/20' : 'text-slate-400' }}">
                    <span class="material-symbols-outlined text-[22px]">groups</span>
                </div>
                <span class="text-[11px] font-medium tracking-normal mt-0.5">{{ __('Músics') }}</span>
            </a>
        @endif

        {{-- 4. Mi Actividad / Menú Más --}}
        @php $isActivity = request()->routeIs('actividades.*') || request()->routeIs('inventory.*') || request()->routeIs('payments.*'); @endphp
        <a href="{{ route('actuaciones.usuario.anyo', [Auth::user()->id, date('Y')]) }}"
           class="group flex flex-col items-center justify-center min-w-[64px] min-h-[48px] py-1 transition-colors {{ $isActivity ? 'text-blue-400 font-bold' : 'text-slate-400 hover:text-slate-200' }}">
            <div class="flex items-center justify-center w-12 h-7 rounded-full transition-all group-active:scale-95 {{ $isActivity ? 'bg-blue-600/20 border border-blue-500/40 text-blue-400 shadow-sm shadow-blue-500/20' : 'text-slate-400' }}">
                <span class="material-symbols-outlined text-[22px]">badge</span>
            </div>
            <span class="text-[11px] font-medium tracking-normal mt-0.5">{{ __('Activitat') }}</span>
        </a>
    </div>
</nav>
