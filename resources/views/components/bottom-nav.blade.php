<nav id="mobile-bottom-nav"
     class="fixed bottom-0 inset-x-0 z-40 w-full bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-slate-200/90 dark:border-slate-800 shadow-[0_-2px_12px_rgba(0,0,0,0.04)] block lg:hidden pb-safe select-none overflow-hidden"
     style="padding-bottom: env(safe-area-inset-bottom, 0px);"
     aria-label="{{ __('Navegació mòbil') }}"
     ontouchstart="">
    {{-- Indicador de carga superior instantáneo --}}
    <div id="bottom-nav-indicator" class="absolute top-0 left-0 right-0 h-[2.5px] bg-gradient-to-r from-indigo-500 via-primary to-indigo-600 opacity-0 transition-opacity duration-150"></div>

    <div class="w-full max-w-lg mx-auto flex flex-row items-center justify-around px-1 py-1 sm:py-1.5"
         style="display: flex; flex-direction: row; align-items: center; justify-content: space-around;">
        {{-- 1. Inicio --}}
        @php $isDashboard = request()->routeIs('dashboard'); @endphp
        <a href="{{ route('dashboard') }}"
           onclick="onTabSelect(this)"
           class="bottom-nav-tab flex-1 flex flex-col items-center justify-center py-1 transition-all {{ $isDashboard ? 'text-primary dark:text-indigo-400 font-bold active-tab' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 font-medium' }}"
           style="flex: 1 1 0%; min-width: 0; text-align: center;">
            <div class="tab-icon-wrapper flex items-center justify-center w-12 h-7 rounded-xl transition-all duration-200 {{ $isDashboard ? 'bg-indigo-50 dark:bg-indigo-950/60 text-primary dark:text-indigo-300 shadow-sm ring-1 ring-indigo-200/50 dark:ring-indigo-800/50' : 'text-slate-500 dark:text-slate-400' }}">
                <span class="material-symbols-outlined text-[22px] transition-transform duration-200 {{ $isDashboard ? 'material-symbols-fill scale-105' : '' }}">home</span>
            </div>
            <span class="text-[10px] sm:text-[11px] truncate tracking-tight mt-0.5 block w-full text-center transition-colors">{{ __('Inicio') }}</span>
        </a>

        {{-- 2. Calendario --}}
        @php 
            $isCalendario = request()->routeIs('actuacion.*') || (request()->routeIs('actuaciones.*') && !request()->routeIs('actuaciones.usuario.*')); 
        @endphp
        <a href="{{ route('actuacion.index') }}"
           onclick="onTabSelect(this)"
           class="bottom-nav-tab flex-1 flex flex-col items-center justify-center py-1 transition-all {{ $isCalendario ? 'text-primary dark:text-indigo-400 font-bold active-tab' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 font-medium' }}"
           style="flex: 1 1 0%; min-width: 0; text-align: center;">
            <div class="tab-icon-wrapper flex items-center justify-center w-12 h-7 rounded-xl transition-all duration-200 {{ $isCalendario ? 'bg-indigo-50 dark:bg-indigo-950/60 text-primary dark:text-indigo-300 shadow-sm ring-1 ring-indigo-200/50 dark:ring-indigo-800/50' : 'text-slate-500 dark:text-slate-400' }}">
                <span class="material-symbols-outlined text-[22px] transition-transform duration-200 {{ $isCalendario ? 'material-symbols-fill scale-105' : '' }}">calendar_month</span>
            </div>
            <span class="text-[10px] sm:text-[11px] truncate tracking-tight mt-0.5 block w-full text-center transition-colors">{{ __('Calendari') }}</span>
        </a>

        {{-- 3. Mis actuaciones --}}
        @php 
            $isMisActuaciones = request()->routeIs('actuaciones.usuario.*'); 
        @endphp
        <a href="{{ route('actuaciones.usuario.anyo', [Auth::id() ?? 0, date('Y')]) }}"
           onclick="onTabSelect(this)"
           class="bottom-nav-tab flex-1 flex flex-col items-center justify-center py-1 transition-all {{ $isMisActuaciones ? 'text-primary dark:text-indigo-400 font-bold active-tab' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 font-medium' }}"
           style="flex: 1 1 0%; min-width: 0; text-align: center;">
            <div class="tab-icon-wrapper flex items-center justify-center w-12 h-7 rounded-xl transition-all duration-200 {{ $isMisActuaciones ? 'bg-indigo-50 dark:bg-indigo-950/60 text-primary dark:text-indigo-300 shadow-sm ring-1 ring-indigo-200/50 dark:ring-indigo-800/50' : 'text-slate-500 dark:text-slate-400' }}">
                <span class="material-symbols-outlined text-[22px] transition-transform duration-200 {{ $isMisActuaciones ? 'material-symbols-fill scale-105' : '' }}">event_available</span>
            </div>
            <span class="text-[10px] sm:text-[11px] truncate tracking-tight mt-0.5 block w-full text-center transition-colors">{{ __('Les meves actuacions') }}</span>
        </a>

        {{-- 4. Perfil --}}
        @php 
            $isProfile = request()->routeIs('profile.*'); 
        @endphp
        <a href="{{ route('profile.show') }}"
           onclick="onTabSelect(this)"
           class="bottom-nav-tab flex-1 flex flex-col items-center justify-center py-1 transition-all {{ $isProfile ? 'text-primary dark:text-indigo-400 font-bold active-tab' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 font-medium' }}"
           style="flex: 1 1 0%; min-width: 0; text-align: center;">
            <div class="tab-icon-wrapper flex items-center justify-center w-12 h-7 rounded-xl transition-all duration-200 {{ $isProfile ? 'bg-indigo-50 dark:bg-indigo-950/60 text-primary dark:text-indigo-300 shadow-sm ring-1 ring-indigo-200/50 dark:ring-indigo-800/50' : 'text-slate-500 dark:text-slate-400' }}">
                <span class="material-symbols-outlined text-[22px] transition-transform duration-200 {{ $isProfile ? 'material-symbols-fill scale-105' : '' }}">person</span>
            </div>
            <span class="text-[10px] sm:text-[11px] truncate tracking-tight mt-0.5 block w-full text-center transition-colors">{{ __('Perfil') }}</span>
        </a>
    </div>

    <script>
        function onTabSelect(tabEl) {
            const nav = document.getElementById('mobile-bottom-nav');
            if (!nav) return;

            // Activar barra de carga superior al milisegundo 0
            const indicator = document.getElementById('bottom-nav-indicator');
            if (indicator) {
                indicator.classList.remove('opacity-0');
                indicator.classList.add('loading-shimmer');
            }

            // Cambiar estado activo visual instantáneo a 0ms en todos los botones
            nav.querySelectorAll('.bottom-nav-tab').forEach(function(el) {
                el.classList.remove('text-primary', 'dark:text-indigo-400', 'font-bold', 'active-tab');
                el.classList.add('text-slate-500', 'dark:text-slate-400', 'font-medium');

                var iconWrap = el.querySelector('.tab-icon-wrapper');
                if (iconWrap) {
                    iconWrap.className = 'tab-icon-wrapper flex items-center justify-center w-12 h-7 rounded-xl transition-all duration-150 text-slate-500 dark:text-slate-400';
                }
                var iconSpan = el.querySelector('.material-symbols-outlined');
                if (iconSpan) {
                    iconSpan.classList.remove('material-symbols-fill', 'scale-105');
                }
            });

            // Activar botón pulsado inmediatamente
            tabEl.classList.remove('text-slate-500', 'dark:text-slate-400', 'font-medium');
            tabEl.classList.add('text-primary', 'dark:text-indigo-400', 'font-bold', 'active-tab');

            var activeIconWrap = tabEl.querySelector('.tab-icon-wrapper');
            if (activeIconWrap) {
                activeIconWrap.className = 'tab-icon-wrapper flex items-center justify-center w-12 h-7 rounded-xl transition-all duration-150 bg-indigo-50 dark:bg-indigo-950/60 text-primary dark:text-indigo-300 shadow-sm ring-1 ring-indigo-200/50 dark:ring-indigo-800/50';
            }
            var activeIconSpan = tabEl.querySelector('.material-symbols-outlined');
            if (activeIconSpan) {
                activeIconSpan.classList.add('material-symbols-fill', 'scale-105');
            }
        }
    </script>
</nav>
