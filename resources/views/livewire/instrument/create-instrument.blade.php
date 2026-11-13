<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12 0c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('instrument.index') }}">{{ __('Instruments') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Nou instrument') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('Nou Instrument') }}
                    </h1>
                </div>
            </div>

            <a href="{{ route('instrument.index') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-bold shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>{{ __('Tornar al llistat') }}</span>
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto px-3 sm:px-6 lg:px-8 mt-6 pb-28">
        <div class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-8 shadow-bento space-y-6">
            <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50">
                <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </span>
                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Dades de l\'instrument') }}</h2>
            </div>

            <form method="POST" action="{{ route('instrument.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Nom del instrument -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        {{ __('Nom de l\'instrument') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name"
                        class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                        value="{{ old('name', '') }}" placeholder="{{ __('ex: Clarinet en Sib, Fagot, Trompeta...') }}" required>
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ordre -->
                <div>
                    <label for="orden" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        {{ __('Ordre en la plantilla') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="orden" id="orden"
                        class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                        value="{{ old('orden', $nextOrder ?? 1) }}" placeholder="{{ __('Ordre numèric') }}" required>
                    <p class="text-[11px] text-slate-400 mt-1">{{ __('Determina la posició en el llistat i en les plantilles de convocatòria.') }}</p>
                    @error('orden')
                        <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icona / Imatge -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        {{ __('Icona o Imatge de l\'instrument') }}
                    </label>
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-100/70">
                        <div id="iconPreviewContainer" class="w-14 h-14 rounded-2xl bg-white border border-indigo-100 flex items-center justify-center shrink-0 shadow-2xs overflow-hidden">
                            <x-nophoto w="36" h="36" />
                        </div>
                        <div class="flex-1">
                            <input type="file" name="icon" id="iconInput" accept="image/*"
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                            <p class="text-[11px] text-slate-400 mt-1">{{ __('Formats acceptats: PNG, JPG, SVG o WebP (màx. 2MB).') }}</p>
                        </div>
                    </div>
                    @error('icon')
                        <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botons -->
                <div class="flex items-center justify-between gap-3 pt-4 border-t border-indigo-50">
                    <a href="{{ route('instrument.index') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-300 rounded-2xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>{{ __('Cancel·lar') }}</span>
                    </a>

                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold shadow-md shadow-indigo-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ __('Crear instrument') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const iconInput = document.getElementById('iconInput');
            const previewContainer = document.getElementById('iconPreviewContainer');

            if (iconInput && previewContainer) {
                iconInput.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            previewContainer.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover rounded-2xl">`;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</x-app-layout>
