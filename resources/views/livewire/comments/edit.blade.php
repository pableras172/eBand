<div class="space-y-6 max-w-4xl mx-auto pb-32">
    {{-- HEADER Y BREADCRUMBS --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('comments.index') }}">{{ __('Comentaris') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Editar') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('Editar comentari') }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Moderar el contingut i canviar l\'estat de visibilitat') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a wire:navigate href="{{ route('comments.index') }}"
                    class="inline-flex items-center gap-2 rounded-2xl border border-indigo-100 bg-white px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-700 shadow-xs transition active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Tornar al llistat') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    {{-- TARJETA BENTO FORMULARIO --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-5 sm:p-7 shadow-bento space-y-6">
        {{-- Banner de contexto: Actuación y Usuario --}}
        <div class="rounded-2xl bg-[#F5F6FC] border border-indigo-50 p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-100/70 text-indigo-700 font-extrabold flex items-center justify-center text-sm shrink-0">
                    {{ mb_substr($form->username, 0, 2) }}
                </div>
                <div>
                    <span class="block text-xs font-bold text-slate-900">{{ $form->username }}</span>
                    <span class="block text-[11px] text-slate-500">
                        {{ __('Publicat') }}: {{ $form->fechaComentario ? \Carbon\Carbon::parse($form->fechaComentario)->format('d/m/Y H:i') : '-' }}
                    </span>
                </div>
            </div>

            <div class="sm:text-right">
                <span class="block text-[11px] font-bold uppercase tracking-wider text-indigo-600">{{ __('Actuació') }}</span>
                <span class="text-xs font-bold text-slate-800">{{ $form->actuacion }}</span>
            </div>
        </div>

        {{-- Formulario Livewire --}}
        <form wire:submit="save" class="space-y-5">
            {{-- Texto del comentario --}}
            <div>
                <label for="comment" class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                    {{ __('Text del comentari') }} <span class="text-red-500">*</span>
                </label>
                <textarea id="comment" wire:model="form.comment" rows="5" required
                    class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] p-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"></textarea>
                @error('form.comment')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Bloque de Opciones de Moderación --}}
            <div class="pt-2 border-t border-indigo-50 space-y-3">
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    {{ __('Estat i moderació') }}
                </span>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    {{-- Toggle Inadecuado --}}
                    <label class="flex items-start gap-3 p-3.5 rounded-2xl bg-[#F5F6FC] border border-indigo-50 hover:bg-amber-50/60 transition cursor-pointer">
                        <input type="checkbox" wire:model="form.inadecuado" class="mt-0.5 rounded border-indigo-200 text-amber-600 focus:ring-amber-500">
                        <span class="flex-1">
                            <span class="block text-xs font-bold text-slate-800">{{ __('Marcar com a inadequat') }}</span>
                            <span class="block text-[11px] text-slate-500 mt-0.5">{{ __('Indica que el missatge conté contingut ofensiu o inapropiat per a la comunitat.') }}</span>
                        </span>
                    </label>

                    {{-- Toggle Eliminado --}}
                    <label class="flex items-start gap-3 p-3.5 rounded-2xl bg-[#F5F6FC] border border-indigo-50 hover:bg-rose-50/60 transition cursor-pointer">
                        <input type="checkbox" wire:model="form.eliminado" class="mt-0.5 rounded border-indigo-200 text-rose-600 focus:ring-rose-500">
                        <span class="flex-1">
                            <span class="block text-xs font-bold text-slate-800">{{ __('Ocultar / Donar de baixa') }}</span>
                            <span class="block text-[11px] text-slate-500 mt-0.5">{{ __('El missatge no serà visible per als músics en el llistat d\'actuació.') }}</span>
                        </span>
                    </label>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-indigo-50">
                <a wire:navigate href="{{ route('comments.index') }}"
                    class="rounded-2xl border border-indigo-100 bg-[#F5F6FC] px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-700 transition">
                    {{ __('Cancel·lar') }}
                </a>
                <button type="submit"
                    class="rounded-2xl bg-indigo-600 px-6 py-2.5 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 transition active:scale-95">
                    {{ __('Guardar canvis') }}
                </button>
            </div>
        </form>
    </div>
</div>
