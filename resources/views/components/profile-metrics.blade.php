<div class="bg-white dark:bg-slate-800 rounded-3xl border border-indigo-50/80 dark:border-slate-700/80 shadow-bento p-5 sm:p-8">
    <div class="flex items-center gap-3.5 pb-6 border-b border-slate-100 dark:border-slate-700/60">
        <div class="h-11 w-11 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-primary dark:text-indigo-400 flex items-center justify-center flex-shrink-0 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <div>
            <h3 class="text-xl font-black text-slate-800 dark:text-white tracking-tight">
                {{ __('Estadístiques de Participació') }}
            </h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                {{ __('Històric d\'assistències, concerts i assajos al llarg de les temporades.') }}
            </p>
        </div>
    </div>

    <div class="pt-6">
        <x-usermetrics :userId="Auth::user()->id" :showTitle="false" :card="false" />
    </div>
</div>
