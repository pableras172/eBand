<x-app-layout>
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
                        <x-ui.breadcrumbs.link href="{{ route('tipoactuacion.index') }}">{{ __('Tipus d\'actuació') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Nou tipus') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ __('Nou tipus d\'actuació') }}
                        </h1>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Registra una nova categoria per a catalogar les actuacions de la banda') }}
                    </p>
                </div>
            </div>

            <div>
                <a href="{{ route('tipoactuacion.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold border border-slate-200/60 shadow-xs transition active:scale-95">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Tornar al llistat') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto px-3 sm:px-6 lg:px-8 mt-6 pb-28">
        {{-- TARJETA NEO-BENTO FORMULARIO --}}
        <div class="rounded-3xl border border-indigo-50/80 bg-white p-6 sm:p-8 shadow-bento">
            <form method="POST" action="{{ route('tipoactuacion.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Nombre --}}
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('Nom del tipus') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name"
                        class="w-full text-sm bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition p-3.5"
                        value="{{ old('name', '') }}" placeholder="{{ __('Ex: Concert de Festes, Cercavila, Assaig Extraordinari...') }}" required />
                    @error('name')
                        <p class="text-rose-600 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Icono / Imagen --}}
                <div>
                    <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('Icona o imatge representativa') }} <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="file" name="icon" id="icon" accept="image/*" required
                            class="w-full text-xs text-slate-600 bg-[#F5F6FC] border border-indigo-100 rounded-2xl p-2.5 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
                    </div>
                    @error('icon')
                        <p class="text-rose-600 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Clasificación: Ensayo / Concierto / General --}}
                <div>
                    <label for="tipoactuacion" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('Classificació funcional') }}
                    </label>
                    <select name="tipoactuacion" id="tipoactuacion"
                        class="w-full text-xs font-semibold bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition p-3">
                        <option value="" {{ old('tipoactuacion') == '' ? 'selected' : '' }}>{{ __('General / Altres actuacions') }}</option>
                        <option value="ensayo" {{ old('tipoactuacion') == 'ensayo' ? 'selected' : '' }}>{{ __('Es de tipus assaig') }}</option>
                        <option value="concierto" {{ old('tipoactuacion') == 'concierto' ? 'selected' : '' }}>{{ __('Es de tipus concert') }}</option>
                    </select>

                    <div class="mt-2.5 flex items-start gap-2 p-3 bg-indigo-50/50 rounded-2xl border border-indigo-100/60 text-indigo-900 text-xs">
                        <svg class="w-4 h-4 text-indigo-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-[11px] leading-relaxed text-indigo-800">
                            {{ __('ayuda_tipos') }}
                        </p>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-indigo-50">
                    <a href="{{ route('tipoactuacion.index') }}"
                        class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                        {{ __('Cancel·lar') }}
                    </a>

                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ __('Guardar nou tipus') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
