<div class="bg-white dark:bg-slate-800 rounded-3xl border border-indigo-50/80 dark:border-slate-700/80 shadow-bento p-5 sm:p-8">
    <div class="flex items-center gap-3.5 pb-6 border-b border-slate-100 dark:border-slate-700/60">
        <div class="h-11 w-11 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </div>
        <div>
            <h3 class="text-xl font-black text-slate-800 dark:text-white tracking-tight">
                {{ __('Notificacions al Dispositiu') }}
            </h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                {{ __('Configura les notificacions emergents i avisos de convocatòries en aquest navegador.') }}
            </p>
        </div>
    </div>

    <div class="py-6 space-y-4">
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-2xl leading-relaxed">
            {{ __('Activa les notificacions en aquest dispositiu per rebre alertes immediates quan es publique una nova actuació, canvi d\'horari o convocatòria de la banda. Recorda permetre els permisos al teu navegador si te\'ls sol·licita.') }}
        </p>

        <div class="pt-2">
            <div class="onesignal-customlink-container inline-block"></div>
        </div>
    </div>
</div>
