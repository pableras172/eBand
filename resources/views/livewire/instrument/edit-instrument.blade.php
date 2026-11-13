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
                        <x-ui.breadcrumbs.link active>{{ $instrument->name }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ $instrument->name }}
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('instrument.index') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-bold shadow-xs transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Tornar al llistat') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-6 pb-28">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- COLUMNA 1: FORMULARIO DE EDICIÓN (lg:col-span-7) -->
            <div class="lg:col-span-7 bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-8 shadow-bento space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-indigo-50">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                            <x-editar w="15" h="15" />
                        </span>
                        <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Dades de l\'instrument') }}</h2>
                    </div>

                    <form action="{{ route('instrument.destroy', $instrument) }}" method="POST"
                          onsubmit="return confirm('{{ __('Estàs segur que vols eliminar aquest instrument? Els músics que el tinguen assignat quedaran sense instrument principal.') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-2xl bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 text-xs font-bold shadow-xs transition"
                            title="{{ __('Eliminar instrument') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>{{ __('Eliminar') }}</span>
                        </button>
                    </form>
                </div>

                <form method="POST" action="{{ route('instrument.update', $instrument->id) }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Nombre del instrumento -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            {{ __('Nom de l\'instrument') }} <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                            value="{{ old('name', $instrument->name) }}" required>
                        @error('name')
                            <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Orden -->
                    <div>
                        <label for="orden" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            {{ __('Ordre en la plantilla') }} <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="orden" id="orden"
                            class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                            value="{{ old('orden', $instrument->orden) }}" required>
                        <p class="text-[11px] text-slate-400 mt-1">{{ __('Determina la posició en el llistat i en les plantilles de convocatòria.') }}</p>
                        @error('orden')
                            <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icona / Imatge actual y canvi -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            {{ __('Icona de l\'instrument') }}
                        </label>
                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-100/70">
                            <div id="iconPreviewContainer" class="w-14 h-14 rounded-2xl bg-white border border-indigo-100 flex items-center justify-center shrink-0 shadow-2xs overflow-hidden">
                                @if ($instrument->icon)
                                    <img src="{{ asset('storage/imagenes/instruments/' . $instrument->icon) }}"
                                         alt="{{ $instrument->name }}" class="w-full h-full object-cover">
                                @else
                                    <x-nophoto w="36" h="36" />
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" name="icon" id="iconInput" accept="image/*"
                                    class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                <p class="text-[11px] text-slate-400 mt-1">{{ __('Selecciona una imatge per a substituir l\'actual (PNG, JPG, SVG o WebP, màx. 2MB).') }}</p>
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
                            <span>{{ __('Desar canvis') }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- COLUMNA 2: MÚSICOS ASOCIADOS (lg:col-span-5) -->
            <div class="lg:col-span-5 bg-white border border-indigo-50/80 rounded-3xl p-6 shadow-bento space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-indigo-50">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Músics de la corda') }}</h2>
                            <p class="text-[11px] text-slate-400">{{ __('Músics amb aquest instrument assignat') }}</p>
                        </div>
                    </div>

                    <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-100">
                        {{ $instrument->users->count() }}
                    </span>
                </div>

                @if ($instrument->users->isNotEmpty())
                    <div class="max-h-[500px] overflow-y-auto space-y-2 pr-1">
                        @foreach ($instrument->users as $user)
                            <div class="p-3 rounded-2xl bg-[#F5F6FC] border border-indigo-100/60 hover:bg-indigo-50/50 transition flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="w-9 h-9 rounded-full bg-indigo-100 border border-indigo-200 flex items-center justify-center text-indigo-700 text-xs font-bold shrink-0 overflow-hidden shadow-2xs">
                                        @if ($user->profile_photo_path)
                                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ mb_substr($user->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-slate-900 truncate">{{ $user->name }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    @if ($user->activo)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            {{ __('Actiu') }}
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">
                                            {{ __('Inactiu') }}
                                        </span>
                                    @endif

                                    @if (Route::has('users.edit'))
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="p-1 rounded-xl bg-white hover:bg-indigo-50 text-slate-400 hover:text-indigo-600 border border-slate-200/60 shadow-2xs transition"
                                            title="{{ __('Veure fitxa del músic') }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 px-4 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-400 mx-auto mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p class="text-xs font-bold text-slate-700">{{ __('Sense músics assignats') }}</p>
                        <p class="text-[11px] text-slate-400 mt-1 max-w-xs mx-auto">
                            {{ __('Cap músic té assignat aquest instrument com a principal actualment.') }}
                        </p>
                    </div>
                @endif
            </div>

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
