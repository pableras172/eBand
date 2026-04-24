<div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white">
    <div class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-sky-100 blur-2xl"></div>
    <div class="absolute -bottom-16 -left-12 h-36 w-36 rounded-full bg-emerald-100 blur-2xl"></div>

    <div class="relative space-y-5 p-4 sm:p-6">
        <div class="inline-flex items-center gap-2 rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-wider text-sky-700">
            {{ __('announcements.latest_updates.badge') }}
            <span class="h-1.5 w-1.5 rounded-full bg-sky-500"></span>
            {{ __('announcements.latest_updates.period') }}
        </div>

        <div>
            <h2 class="text-2xl font-extrabold leading-tight text-slate-900 sm:text-3xl">{{ __('announcements.latest_updates.title') }}</h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-600 sm:text-base">
                {{ __('announcements.latest_updates.subtitle') }}
            </p>
        </div>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <article class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-slate-500">01</p>
                <h3 class="mt-1 text-base font-bold text-slate-900">{{ __('announcements.latest_updates.features.announcements.title') }}</h3>
                <p class="mt-1 text-sm text-slate-600">{{ __('announcements.latest_updates.features.announcements.text') }}</p>
            </article>

            <article class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-slate-500">02</p>
                <h3 class="mt-1 text-base font-bold text-slate-900">{{ __('announcements.latest_updates.features.list_view.title') }}</h3>
                <p class="mt-1 text-sm text-slate-600">{{ __('announcements.latest_updates.features.list_view.text') }}</p>
            </article>

            <article class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-slate-500">03</p>
                <h3 class="mt-1 text-base font-bold text-slate-900">{{ __('announcements.latest_updates.features.ui_style.title') }}</h3>
                <p class="mt-1 text-sm text-slate-600">{{ __('announcements.latest_updates.features.ui_style.text') }}</p>
            </article>

            <article class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-slate-500">04</p>
                <h3 class="mt-1 text-base font-bold text-slate-900">{{ __('announcements.latest_updates.features.user_stats.title') }}</h3>
                <p class="mt-1 text-sm text-slate-600">{{ __('announcements.latest_updates.features.user_stats.text') }}</p>
            </article>

            <article class="rounded-xl border border-slate-200 bg-slate-50 p-4 sm:col-span-2">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-slate-500">05</p>
                <h3 class="mt-1 text-base font-bold text-slate-900">{{ __('announcements.latest_updates.features.inventory.title') }}</h3>
                <p class="mt-1 text-sm text-slate-600">{{ __('announcements.latest_updates.features.inventory.text') }}</p>
            </article>
        </div>

        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4">
            <p class="text-sm font-semibold text-emerald-800">{{ __('announcements.latest_updates.footer.title') }}</p>
            <p class="mt-1 text-sm text-emerald-700">{{ __('announcements.latest_updates.footer.text') }}</p>
        </div>
    </div>
</div>
