<div class="mx-auto max-w-4xl space-y-6 px-2 py-4 sm:px-4 lg:px-6 pb-28">

    {{-- HEADER Y BREADCRUMBS --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('paymentresumes.index') }}">{{ __('Resums de Liquidacions') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Crear Nou Resum') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ __('Crear Nou Resum de Liquidacions') }}
                        </h1>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Genera un nou resum per agrupar i consolidar pagaments de músics') }}
                    </p>
                </div>
            </div>

            <div>
                <a wire:navigate href="{{ route('paymentresumes.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold border border-slate-200/60 shadow-xs transition active:scale-95">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Tornar al llistat') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    {{-- FORMULARIO NEO-BENTO --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-6 shadow-bento">
        <form wire:submit.prevent="save" class="space-y-5">
            <div>
                <label for="descripcion" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    {{ __('Descripció del Resum') }} <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                    wire:model="form.descripcion"
                    id="descripcion"
                    class="w-full text-sm bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 p-3"
                    placeholder="{{ __('Ex: Tancament Festes de Moros i Cristians 2026') }}" />
                @error('form.descripcion')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="user_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('Creat per (Responsable)') }} <span class="text-rose-500">*</span>
                    </label>
                    <select wire:model="form.user_id" id="user_id"
                        class="w-full text-xs bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 p-3">
                        <option value="">{{ __('Selecciona un responsable') }}</option>
                        @foreach ($users as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('form.user_id')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="created_at" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('Data del resum') }}
                    </label>
                    <input type="datetime-local"
                        wire:model="form.created_at"
                        id="created_at"
                        class="w-full text-xs bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 p-3" />
                    @error('form.created_at')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="document" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    {{ __('Enllaç al document extern / justificant (opcional)') }}
                </label>
                <input type="url"
                    wire:model="form.document"
                    id="document"
                    class="w-full text-xs bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 p-3"
                    placeholder="https://..." />
                @error('form.document')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-indigo-50">
                <a wire:navigate href="{{ route('paymentresumes.index') }}"
                    class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    {{ __('Cancel·lar') }}
                </a>

                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ __('Crear i continuar') }}</span>
                </button>
            </div>
        </form>
    </div>

</div>
