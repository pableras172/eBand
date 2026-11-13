<nav class="fixed bottom-0 inset-x-0 z-40 pb-safe px-4 pointer-events-none block lg:hidden" aria-label="{{ __('Navegació mòbil') }}">
    <div class="mb-2 mx-auto max-w-md pointer-events-auto bg-white/90 backdrop-blur-2xl border border-white/80 shadow-glass rounded-3xl px-3 py-1.5 flex items-center justify-around">
        {{-- 1. Inicio --}}
        @php $isDashboard = request()->routeIs('dashboard'); @endphp
        <a href="{{ route('dashboard') }}"
           class="group flex flex-col items-center justify-center min-w-[60px] py-1 transition-all {{ $isDashboard ? 'text-primary font-bold' : 'text-slate-500 hover:text-primary font-medium' }}">
            <div class="flex items-center justify-center w-12 h-7 rounded-2xl transition-all group-active:scale-90 {{ $isDashboard ? 'bg-indigo-50 text-primary shadow-sm' : 'text-slate-500' }}">
                <span class="material-symbols-outlined text-[22px]">home</span>
            </div>
            <span class="text-[11px] tracking-normal mt-0.5">{{ __('Inici') }}</span>
        </a>

        {{-- 2. Actuaciones / Calendario --}}
        @php $isActuaciones = request()->routeIs('actuacion.*') || request()->routeIs('actuaciones.*'); @endphp
        <a href="{{ route('actuacion.index') }}"
           class="group flex flex-col items-center justify-center min-w-[60px] py-1 transition-all {{ $isActuaciones ? 'text-primary font-bold' : 'text-slate-500 hover:text-primary font-medium' }}">
            <div class="flex items-center justify-center w-12 h-7 rounded-2xl transition-all group-active:scale-90 {{ $isActuaciones ? 'bg-indigo-50 text-primary shadow-sm' : 'text-slate-500' }}">
                <span class="material-symbols-outlined text-[22px]">event</span>
            </div>
            <span class="text-[11px] tracking-normal mt-0.5">{{ __('Actuacions') }}</span>
        </a>

        {{-- 3. Músicos / Cuerdas --}}
        @php $isMusicos = request()->routeIs('musicos.*') || request()->routeIs('users.*'); @endphp
        @if (Route::has('users.index'))
            <a href="{{ route('users.index') }}"
               class="group flex flex-col items-center justify-center min-w-[60px] py-1 transition-all {{ $isMusicos ? 'text-primary font-bold' : 'text-slate-500 hover:text-primary font-medium' }}">
                <div class="flex items-center justify-center w-12 h-7 rounded-2xl transition-all group-active:scale-90 {{ $isMusicos ? 'bg-indigo-50 text-primary shadow-sm' : 'text-slate-500' }}">
                    <span class="material-symbols-outlined text-[22px]">groups</span>
                </div>
                <span class="text-[11px] tracking-normal mt-0.5">{{ __('Músics') }}</span>
            </a>
        @endif

        {{-- 4. Mi Actividad / Gestió --}}
        @php $isActivity = request()->routeIs('actividades.*') || request()->routeIs('inventory.*') || request()->routeIs('payments.*'); @endphp
        <a href="{{ route('actuaciones.usuario.anyo', [Auth::user()->id, date('Y')]) }}"
           class="group flex flex-col items-center justify-center min-w-[60px] py-1 transition-all {{ $isActivity ? 'text-primary font-bold' : 'text-slate-500 hover:text-primary font-medium' }}">
            <div class="flex items-center justify-center w-12 h-7 rounded-2xl transition-all group-active:scale-90 {{ $isActivity ? 'bg-indigo-50 text-primary shadow-sm' : 'text-slate-500' }}">
                <span class="material-symbols-outlined text-[22px]">business_center</span>
            </div>
            <span class="text-[11px] tracking-normal mt-0.5">{{ __('Activitat') }}</span>
        </a>
    </div>
</nav>
