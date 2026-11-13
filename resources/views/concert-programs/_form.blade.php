@php
    $repertoireRows = old('repertoire', $repertoire ?? []);

    if (count($repertoireRows) === 0) {
        $repertoireRows = [
            ['title' => '', 'author' => '', 'details' => '', 'url' => '', 'sort_order' => 1],
        ];
    }
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    {{-- Card 1: Dades generals --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-5 sm:p-7 shadow-bento space-y-5">
        <div class="flex items-center gap-3 border-b border-indigo-50 pb-3">
            <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-base font-bold font-headline text-slate-900">{{ __('Dades bàsiques del concert') }}</h2>
                <p class="text-xs text-slate-500">{{ __('Títol, ubicació física, data i hora de la presentació') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="title" class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                    {{ __('Títol') }} <span class="text-red-500">*</span>
                </label>
                <input id="title" name="title" type="text" required
                    placeholder="{{ __('Exemple: Concert de Primavera 2026') }}"
                    class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                    value="{{ old('title', $program->title) }}">
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="location" class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                    {{ __('Ubicació') }} <span class="text-red-500">*</span>
                </label>
                <input id="location" name="location" type="text" required
                    placeholder="{{ __('Exemple: Auditori Municipal') }}"
                    class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                    value="{{ old('location', $program->location) }}">
                @error('location')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="event_date" class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                    {{ __('Data') }} <span class="text-red-500">*</span>
                </label>
                <input id="event_date" name="event_date" type="date" required
                    class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                    value="{{ old('event_date', optional($program->event_date)->format('Y-m-d')) }}">
                @error('event_date')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="event_time" class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                    {{ __('Hora') }} <span class="text-red-500">*</span>
                </label>
                <input id="event_time" name="event_time" type="time" required
                    class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3.5 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                    value="{{ old('event_time', $program->event_time ? substr((string) $program->event_time, 0, 5) : null) }}">
                @error('event_time')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="participants" class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                {{ __('Participants (opcional)') }}
            </label>
            <textarea id="participants" name="participants" rows="3"
                placeholder="{{ __('Director, solistes, bandes convidades...') }}"
                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] p-3 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">{{ old('participants', $program->participants) }}</textarea>
            @error('participants')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Card 2: Publicació i Difusió --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-5 sm:p-7 shadow-bento space-y-4">
        <div class="flex items-center gap-3 border-b border-indigo-50 pb-3">
            <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            <div>
                <h2 class="text-base font-bold font-headline text-slate-900">{{ __('Publicació i difusió') }}</h2>
                <p class="text-xs text-slate-500">{{ __('Configuració de visibilitat a la pàgina pública del programa') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <label class="flex items-start gap-3 p-3.5 rounded-2xl bg-[#F5F6FC] border border-indigo-50 hover:bg-indigo-50/60 transition cursor-pointer">
                <input type="checkbox" name="is_published" value="1" class="mt-0.5 rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500" @checked(old('is_published', $program->is_published))>
                <span class="flex-1">
                    <span class="block text-xs font-bold text-slate-800">{{ __('Publicat') }}</span>
                    <span class="block text-[11px] text-slate-500 mt-0.5">{{ __('Només els programes publicats apareixen a la URL pública /programa.') }}</span>
                </span>
            </label>

            <label class="flex items-start gap-3 p-3.5 rounded-2xl bg-[#F5F6FC] border border-indigo-50 hover:bg-indigo-50/60 transition cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" class="mt-0.5 rounded border-indigo-200 text-indigo-600 focus:ring-indigo-500" @checked(old('is_featured', $program->is_featured))>
                <span class="flex-1">
                    <span class="block text-xs font-bold text-slate-800">{{ __('Destacar manualment') }}</span>
                    <span class="block text-[11px] text-slate-500 mt-0.5">{{ __('Si està actiu, tindrà prioritat absoluta com a programa actiu principal.') }}</span>
                </span>
            </label>
        </div>

        @error('is_published')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
        @error('is_featured')
            <p class="text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Card 3: Imatges i Logos --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-5 sm:p-7 shadow-bento space-y-5">
        <div class="flex items-center gap-3 border-b border-indigo-50 pb-3">
            <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-base font-bold font-headline text-slate-900">{{ __('Cartell i logos col·laboradors') }}</h2>
                <p class="text-xs text-slate-500">{{ __('Imatge principal del cartell i patrocinadors per al peu de pàgina o impressió') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            {{-- Imagen principal --}}
            <div class="p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-50/80 space-y-2">
                <label for="image" class="block text-xs font-bold uppercase tracking-wide text-slate-700">
                    {{ __('Imatge principal (Cartell)') }}
                </label>
                @if ($program->image_path)
                    <div class="flex items-center gap-3 p-2 bg-white rounded-xl border border-indigo-100/60 mb-2">
                        <img src="{{ asset('storage/' . $program->image_path) }}" alt="{{ $program->title }}" class="w-12 h-12 object-cover rounded-lg border border-indigo-50">
                        <div class="flex-1 min-w-0">
                            <span class="block text-[11px] font-bold text-slate-700 truncate">{{ basename($program->image_path) }}</span>
                            <span class="text-[10px] text-slate-400">{{ __('Pujar un altre fitxer per reemplaçar-lo') }}</span>
                        </div>
                    </div>
                @endif
                <input id="image" name="image" type="file" accept="image/*"
                    class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">
                @error('image')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Logo 1 --}}
            <div class="p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-50/80 space-y-2">
                <label for="logo_1" class="block text-xs font-bold uppercase tracking-wide text-slate-700">
                    {{ __('Logo 1 (Ajuntament / Principal)') }}
                </label>
                @if ($program->logo_1_path)
                    <div class="flex items-center gap-3 p-2 bg-white rounded-xl border border-indigo-100/60 mb-2">
                        <img src="{{ asset('storage/' . $program->logo_1_path) }}" alt="Logo 1" class="w-10 h-10 object-contain rounded-lg border border-indigo-50">
                        <div class="flex-1 min-w-0">
                            <span class="block text-[11px] font-bold text-slate-700 truncate">{{ basename($program->logo_1_path) }}</span>
                            <span class="text-[10px] text-slate-400">{{ __('Pujar fitxer per reemplaçar') }}</span>
                        </div>
                    </div>
                @endif
                <input id="logo_1" name="logo_1" type="file" accept="image/*"
                    class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">
                @error('logo_1')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Logo 2 --}}
            <div class="p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-50/80 space-y-2">
                <label for="logo_2" class="block text-xs font-bold uppercase tracking-wide text-slate-700">
                    {{ __('Logo 2 (Societat / Entitat)') }}
                </label>
                @if ($program->logo_2_path)
                    <div class="flex items-center gap-3 p-2 bg-white rounded-xl border border-indigo-100/60 mb-2">
                        <img src="{{ asset('storage/' . $program->logo_2_path) }}" alt="Logo 2" class="w-10 h-10 object-contain rounded-lg border border-indigo-50">
                        <div class="flex-1 min-w-0">
                            <span class="block text-[11px] font-bold text-slate-700 truncate">{{ basename($program->logo_2_path) }}</span>
                            <span class="text-[10px] text-slate-400">{{ __('Pujar fitxer per reemplaçar') }}</span>
                        </div>
                    </div>
                @endif
                <input id="logo_2" name="logo_2" type="file" accept="image/*"
                    class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">
                @error('logo_2')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Logo 3 --}}
            <div class="p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-50/80 space-y-2">
                <label for="logo_3" class="block text-xs font-bold uppercase tracking-wide text-slate-700">
                    {{ __('Logo 3 (Patrocinador / Col·laborador)') }}
                </label>
                @if ($program->logo_3_path)
                    <div class="flex items-center gap-3 p-2 bg-white rounded-xl border border-indigo-100/60 mb-2">
                        <img src="{{ asset('storage/' . $program->logo_3_path) }}" alt="Logo 3" class="w-10 h-10 object-contain rounded-lg border border-indigo-50">
                        <div class="flex-1 min-w-0">
                            <span class="block text-[11px] font-bold text-slate-700 truncate">{{ basename($program->logo_3_path) }}</span>
                            <span class="text-[10px] text-slate-400">{{ __('Pujar fitxer per reemplaçar') }}</span>
                        </div>
                    </div>
                @endif
                <input id="logo_3" name="logo_3" type="file" accept="image/*"
                    class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">
                @error('logo_3')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Card 4: Repertori d'Obres --}}
    <div class="rounded-3xl border border-indigo-50/80 bg-white p-5 sm:p-7 shadow-bento space-y-5">
        <div class="flex items-center justify-between border-b border-indigo-50 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold font-headline text-slate-900">{{ __('Repertori del concert') }}</h2>
                    <p class="text-xs text-slate-500">{{ __('Peces, autors, ordenació i detalls addicionals') }}</p>
                </div>
            </div>

            <button type="button" id="add-piece"
                class="inline-flex items-center gap-1.5 rounded-2xl bg-indigo-600 px-3.5 py-2 text-xs font-bold text-white shadow-xs hover:bg-indigo-700 active:scale-95 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>{{ __('Afegir obra') }}</span>
            </button>
        </div>

        @error('repertoire')
            <p class="text-xs text-red-600 font-semibold">{{ $message }}</p>
        @enderror

        <div id="repertoire-list" class="space-y-3.5">
            @foreach ($repertoireRows as $index => $piece)
                <div class="piece-row rounded-2xl border border-indigo-100/70 bg-[#F5F6FC]/50 p-4 space-y-3 transition hover:border-indigo-200">
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-12 items-start">
                        <div class="sm:col-span-6">
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                {{ __('Títol de l\'obra') }} <span class="text-red-500">*</span>
                            </label>
                            <input name="repertoire[{{ $index }}][title]" type="text" required
                                placeholder="{{ __('Ex: Amunt València, Pasdoble') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ $piece['title'] ?? '' }}">
                            @error('repertoire.'.$index.'.title')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-4">
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                {{ __('Autor / Compositor') }}
                            </label>
                            <input name="repertoire[{{ $index }}][author]" type="text"
                                placeholder="{{ __('Ex: José Serrano') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ $piece['author'] ?? '' }}">
                            @error('repertoire.'.$index.'.author')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                {{ __('Ordre') }}
                            </label>
                            <input name="repertoire[{{ $index }}][sort_order]" type="number" min="1"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ $piece['sort_order'] ?? ($index + 1) }}">
                            @error('repertoire.'.$index.'.sort_order')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                {{ __('Detalls o moviments (opcional)') }}
                            </label>
                            <textarea name="repertoire[{{ $index }}][details]" rows="2"
                                placeholder="{{ __('I. Andante, II. Allegro...') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white p-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">{{ $piece['details'] ?? '' }}</textarea>
                            @error('repertoire.'.$index.'.details')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                {{ __('Enllaç d\'àudio o vídeo (opcional)') }}
                            </label>
                            <input name="repertoire[{{ $index }}][url]" type="url" placeholder="https://youtube.com/..."
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ $piece['url'] ?? '' }}">
                            @error('repertoire.'.$index.'.url')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-1">
                        <button type="button" class="remove-piece inline-flex items-center gap-1 text-xs font-bold text-rose-600 hover:text-rose-800 hover:bg-rose-50 px-2.5 py-1 rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>{{ __('Eliminar obra') }}</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Barra de botons d'acció --}}
    <div class="flex items-center justify-end gap-3 pt-4">
        <a href="{{ route('concert-programs.index') }}"
            class="rounded-2xl border border-indigo-100 bg-[#F5F6FC] px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-700 transition">
            {{ __('Cancel·lar') }}
        </a>
        <button type="submit"
            class="rounded-2xl bg-indigo-600 px-6 py-2.5 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 transition active:scale-95">
            {{ $submitLabel }}
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const repertoireList = document.getElementById('repertoire-list');
        const addButton = document.getElementById('add-piece');

        if (!repertoireList || !addButton) {
            return;
        }

        const rowTemplate = function (index) {
            return `
                <div class="piece-row rounded-2xl border border-indigo-100/70 bg-[#F5F6FC]/50 p-4 space-y-3 transition hover:border-indigo-200">
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-12 items-start">
                        <div class="sm:col-span-6">
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                {{ __('Títol de l\'obra') }} <span class="text-red-500">*</span>
                            </label>
                            <input name="repertoire[${index}][title]" type="text" required
                                placeholder="{{ __('Ex: Amunt València, Pasdoble') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                        </div>
                        <div class="sm:col-span-4">
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                {{ __('Autor / Compositor') }}
                            </label>
                            <input name="repertoire[${index}][author]" type="text"
                                placeholder="{{ __('Ex: José Serrano') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                {{ __('Ordre') }}
                            </label>
                            <input name="repertoire[${index}][sort_order]" type="number" min="1" value="${index + 1}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                {{ __('Detalls o moviments (opcional)') }}
                            </label>
                            <textarea name="repertoire[${index}][details]" rows="2"
                                placeholder="{{ __('I. Andante, II. Allegro...') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white p-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"></textarea>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-600">
                                {{ __('Enllaç d\'àudio o vídeo (opcional)') }}
                            </label>
                            <input name="repertoire[${index}][url]" type="url" placeholder="https://youtube.com/..."
                                class="w-full rounded-2xl border border-indigo-100/70 bg-white py-2 px-3 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">
                        </div>
                    </div>
                    <div class="flex justify-end pt-1">
                        <button type="button" class="remove-piece inline-flex items-center gap-1 text-xs font-bold text-rose-600 hover:text-rose-800 hover:bg-rose-50 px-2.5 py-1 rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>{{ __('Eliminar obra') }}</span>
                        </button>
                    </div>
                </div>
            `;
        };

        const refreshDeleteButtons = function () {
            const rows = repertoireList.querySelectorAll('.piece-row');
            rows.forEach(function (row) {
                const removeButton = row.querySelector('.remove-piece');
                if (!removeButton) {
                    return;
                }

                removeButton.onclick = function () {
                    if (repertoireList.querySelectorAll('.piece-row').length > 1) {
                        row.remove();
                    }
                };
            });
        };

        addButton.addEventListener('click', function () {
            const newIndex = repertoireList.querySelectorAll('.piece-row').length;
            repertoireList.insertAdjacentHTML('beforeend', rowTemplate(newIndex));
            refreshDeleteButtons();
        });

        refreshDeleteButtons();
    });
</script>
