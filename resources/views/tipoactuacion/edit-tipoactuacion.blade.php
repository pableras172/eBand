<x-app-layout>
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
                        <x-ui.breadcrumbs.link href="{{ route('tipoactuacion.index') }}">{{ __('Tipus d\'actuació') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ $tipoactuacion->nombre }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <div class="flex items-center gap-2 mt-0.5">
                        <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight">
                            {{ __('Editar tipus d\'actuació') }}
                        </h1>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ __('Actualitza el nom, categoria funcional o imatge representativa') }}
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
        <div class="rounded-3xl border border-indigo-50/80 bg-white p-6 sm:p-8 shadow-bento space-y-6">
            <form method="POST" action="{{ route('tipoactuacion.update', $tipoactuacion) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div>
                    <label for="nombre" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('Nom del tipus') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nombre" id="nombre"
                        class="w-full text-sm bg-[#F5F6FC] border border-indigo-100 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition p-3.5"
                        value="{{ old('nombre', $tipoactuacion->nombre) }}" required />
                    @error('nombre')
                        <p class="text-rose-600 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Icono / Imagen con Preview --}}
                <div>
                    <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('Imatge o icona actual') }}
                    </label>
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-100/70">
                        {{-- Vista previa actual --}}
                        <div class="w-16 h-16 rounded-2xl bg-white border border-indigo-100 flex items-center justify-center shrink-0 overflow-hidden shadow-xs">
                            @if ($tipoactuacion->icon)
                                <img src="{{ asset('storage/imagenes/tipoactuacion/' . $tipoactuacion->icon) }}"
                                    alt="{{ $tipoactuacion->nombre }}"
                                    class="w-full h-full object-cover">
                            @else
                                <x-nophoto w="40" h="40" />
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <span class="text-xs font-bold text-slate-700 block mb-1">
                                {{ __('Substituir imatge (opcional)') }}
                            </span>
                            <input type="file" name="icon" id="icon" accept="image/*"
                                class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer focus:outline-none transition" />
                        </div>
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
                        <option value="" @selected(!$tipoactuacion->tipoensayo && !$tipoactuacion->tipoconcierto)>
                            {{ __('General / Altres actuacions') }}
                        </option>
                        <option value="ensayo" @selected($tipoactuacion->tipoensayo)>
                            {{ __('Es de tipus assaig') }}
                        </option>
                        <option value="concierto" @selected($tipoactuacion->tipoconcierto)>
                            {{ __('Es de tipus concert') }}
                        </option>
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
                <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-indigo-50">
                    <button type="button"
                        onclick="if(confirm('{{ __('Segur que vols eliminar este tipus d\'actuació?') }}')) { document.getElementById('delete-tipo-form').submit(); }"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold border border-rose-200/60 transition active:scale-95">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>{{ __('Eliminar tipus') }}</span>
                    </button>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('tipoactuacion.index') }}"
                            class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                            {{ __('Cancel·lar') }}
                        </a>

                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-600/20 transition active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ __('Guardar canvis') }}</span>
                        </button>
                    </div>
                </div>
            </form>

            {{-- Formulario oculto para eliminar --}}
            <form id="delete-tipo-form" action="{{ route('tipoactuacion.destroy', $tipoactuacion) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</x-app-layout>
