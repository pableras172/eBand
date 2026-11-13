<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>{{ __('Dades de la banda') }}</x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ __('Dades de la banda') }}
                    </h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">
                        {{ __('Personalitza la informació pública i de contacte de la banda.') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if ($bandSetting?->activarcontactoinfo)
                    <a href="{{ route('masinfo.create') }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-white hover:bg-indigo-50/50 text-indigo-600 border border-indigo-100 text-xs font-bold shadow-xs transition"
                        title="{{ __('Veure formulari públic de contacte') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>{{ __('Veure /masinfo') }}</span>
                    </a>
                @endif

                <a href="/"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-bold shadow-xs transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('Tornar al dashboard') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Formulari ocult per generar / descarregar QR de contacte -->
    <form id="form-generate-qr" method="POST" action="{{ route('band-settings.generate-contact-qr') }}" class="hidden">
        @csrf
    </form>

    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-6 pb-28 space-y-6">
        @if (session('success_message'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-semibold text-emerald-800 flex items-center gap-2 shadow-xs">
                <span class="text-emerald-600 font-bold">✓</span>
                <span>{{ session('success_message') }}</span>
            </div>
        @endif

        @if (session('error_message'))
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs font-semibold text-rose-800 flex items-center gap-2 shadow-xs">
                <span class="text-rose-600 font-bold">⚠</span>
                <span>{{ session('error_message') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('band-settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                <!-- COLUMNA 1: IDENTITAT I XARXES (lg:col-span-7) -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- SECCIÓ: Identitat de la banda -->
                    <section class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-7 shadow-bento space-y-5">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50/80">
                            <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Identitat de la banda') }}</h2>
                                <p class="text-[11px] text-slate-500 font-medium">{{ __('Nom, fiscalitat i dades bàsiques de contacte.') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <!-- Nom -->
                            <div class="sm:col-span-2">
                                <label for="nombre" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Nom') }} <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="nombre" id="nombre"
                                    value="{{ old('nombre', $bandSetting?->nombre) }}"
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    placeholder="{{ __('Ex: Unió Musical d\'Alberic') }}"
                                    required>
                                @error('nombre')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIF / CIF -->
                            <div>
                                <label for="nif_cif" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('NIF / CIF') }}
                                </label>
                                <input type="text" name="nif_cif" id="nif_cif"
                                    value="{{ old('nif_cif', $bandSetting?->nif_cif) }}"
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    placeholder="G12345678">
                                @error('nif_cif')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Telèfon -->
                            <div>
                                <label for="telefono" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Telefon') }}
                                </label>
                                <input type="text" name="telefono" id="telefono"
                                    value="{{ old('telefono', $bandSetting?->telefono) }}"
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    placeholder="+34 600 000 000">
                                @error('telefono')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Direcció -->
                            <div class="sm:col-span-2">
                                <label for="direccion" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Direcció') }}
                                </label>
                                <input type="text" name="direccion" id="direccion"
                                    value="{{ old('direccion', $bandSetting?->direccion) }}"
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    placeholder="{{ __('Carrer Major, 12, 46260 Alberic') }}">
                                @error('direccion')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="sm:col-span-2">
                                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Email') }}
                                </label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $bandSetting?->email) }}"
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    placeholder="info@banda.org">
                                @error('email')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lloc web -->
                            <div class="sm:col-span-2">
                                <label for="website" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Sitio web') }}
                                </label>
                                <input type="url" name="website" id="website"
                                    value="{{ old('website', $bandSetting?->website) }}"
                                    placeholder="https://www.banda.org"
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                @error('website')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- SECCIÓ: Xarxes socials -->
                    <section class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-7 shadow-bento space-y-5">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50/80">
                            <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Xarxes socials') }}</h2>
                                <p class="text-[11px] text-slate-500 font-medium">{{ __('URLs oficials per a compartir des del web i documents.') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <!-- Instagram -->
                            <div>
                                <label for="urlinstagram" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Instagram
                                </label>
                                <input type="url" name="urlinstagram" id="urlinstagram"
                                    value="{{ old('urlinstagram', $bandSetting?->urlinstagram) }}"
                                    placeholder="https://instagram.com/..."
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                @error('urlinstagram')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Facebook -->
                            <div>
                                <label for="urlfacebook" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Facebook
                                </label>
                                <input type="url" name="urlfacebook" id="urlfacebook"
                                    value="{{ old('urlfacebook', $bandSetting?->urlfacebook) }}"
                                    placeholder="https://facebook.com/..."
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                @error('urlfacebook')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- TikTok -->
                            <div>
                                <label for="urltiktok" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    TikTok
                                </label>
                                <input type="url" name="urltiktok" id="urltiktok"
                                    value="{{ old('urltiktok', $bandSetting?->urltiktok) }}"
                                    placeholder="https://tiktok.com/@..."
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                @error('urltiktok')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>
                </div>

                <!-- COLUMNA 2: PRESIDÈNCIA, LOGO I PORTAL PÚBLIC (lg:col-span-5) -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- SECCIÓ: Presidència i imatge -->
                    <section class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-7 shadow-bento space-y-5">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50/80">
                            <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Presidència i imatge') }}</h2>
                                <p class="text-[11px] text-slate-500 font-medium">{{ __('Selecciona la presidència actual i el logo de la banda.') }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- President -->
                            <div>
                                <label for="iduserpresidente" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Presidente') }}
                                </label>
                                <select name="iduserpresidente" id="iduserpresidente"
                                    class="w-full px-3.5 py-2.5 text-xs bg-[#F5F6FC] border border-indigo-100/70 rounded-2xl text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                    <option value="">{{ __('Selecciona un usuario') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected((string) old('iduserpresidente', $bandSetting?->iduserpresidente) === (string) $user->id)>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('iduserpresidente')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Logo i previsualització -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    {{ __('Logo') }}
                                </label>
                                <div class="flex items-center gap-4 p-4 rounded-2xl bg-[#F5F6FC] border border-indigo-100/70">
                                    <div class="w-16 h-16 rounded-2xl bg-white border border-indigo-100 flex items-center justify-center shrink-0 shadow-2xs overflow-hidden">
                                        @if ($bandSetting?->logo)
                                            <img id="logoPreview" src="{{ asset('storage/'.$bandSetting->logo) }}" alt="Logo banda" class="h-full w-full object-contain">
                                        @else
                                            <img id="logoPreview" src="" alt="Logo banda" class="h-full w-full object-contain hidden">
                                            <span id="logoPlaceholder" class="text-[10px] font-bold text-slate-400 text-center px-1 uppercase tracking-wider">{{ __('Sense logo') }}</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <input type="file" name="logo" id="logoInput" accept="image/*"
                                            class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                        <p class="text-[11px] text-slate-400 mt-1">{{ __('Formatos recomendados: JPG, PNG, WEBP. Máximo 2MB.') }}</p>
                                    </div>
                                </div>
                                @error('logo')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- SECCIÓ: Formulari públic de contacte -->
                    <section class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-7 shadow-bento space-y-4">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50/80">
                            <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('Formulari públic de contacte') }}</h2>
                                <p class="text-[11px] text-slate-500 font-medium">{{ __('Permet activar o desactivar l\'accés públic a /masinfo.') }}</p>
                            </div>
                        </div>

                        <!-- Toggle activació -->
                        <label for="activarcontactoinfo"
                            class="flex items-center justify-between rounded-2xl border border-indigo-100/80 bg-[#F5F6FC] hover:bg-indigo-50/40 p-4 cursor-pointer transition">
                            <div class="pr-3">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $bandSetting?->activarcontactoinfo ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <p class="text-xs font-bold text-slate-800">{{ __('Activar formulari /masinfo') }}</p>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-0.5">{{ __('Si està desactivat, els visitants seran redirigits a l\'inici.') }}</p>
                            </div>
                            <input type="hidden" name="activarcontactoinfo" value="0">
                            <input type="checkbox"
                                name="activarcontactoinfo"
                                id="activarcontactoinfo"
                                value="1"
                                @checked((bool) old('activarcontactoinfo', $bandSetting?->activarcontactoinfo))
                                class="h-5 w-5 rounded-lg border-indigo-300 text-indigo-600 focus:ring-indigo-500 transition">
                        </label>
                    </section>

                    <!-- SECCIÓ: QR de contacte (/masinfo) -->
                    @if ($bandSetting?->activarcontactoinfo)
                        <section class="bg-white border border-indigo-50/80 rounded-3xl p-6 lg:p-7 shadow-bento space-y-4">
                            <div class="flex items-center gap-2.5 pb-4 border-b border-indigo-50/80">
                                <span class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                </span>
                                <div>
                                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">{{ __('QR d\'accés a /masinfo') }}</h2>
                                    <p class="text-[11px] text-slate-500 font-medium">{{ __('Codi QR amb la URL pública de contacte.') }}</p>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row items-center gap-5">
                                @if ($bandSetting?->qr_contacto_masinfo)
                                    <div class="shrink-0 flex flex-col items-center gap-2">
                                        <img src="{{ asset('storage/' . $bandSetting->qr_contacto_masinfo) }}"
                                            alt="QR /masinfo"
                                            class="h-32 w-32 rounded-2xl border border-indigo-100 bg-white object-contain p-2 shadow-xs">
                                        <a href="{{ asset('storage/' . $bandSetting->qr_contacto_masinfo) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-600 hover:text-indigo-800">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            <span>{{ __('Abrir QR') }}</span>
                                        </a>
                                    </div>
                                @endif

                                <div class="space-y-3 flex-1 text-center sm:text-left">
                                    <p class="text-xs text-slate-500">
                                        {{ __('Genera o actualitza el QR amb la imatge de la banda per a cartells, programes de festes i xarxes.') }}
                                    </p>
                                    <div>
                                        <button type="submit" form="form-generate-qr"
                                            class="inline-flex items-center gap-1.5 rounded-2xl bg-indigo-50 border border-indigo-100 px-4 py-2 text-xs font-bold text-indigo-700 shadow-xs hover:bg-indigo-100 transition">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            <span>{{ __('Generar / Descarregar QR') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>

                <!-- BARRA D'ACCIONS INFERIOR (lg:col-span-12) -->
                <div class="lg:col-span-12 bg-white border border-indigo-50/80 rounded-3xl p-5 lg:p-6 shadow-bento flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="/"
                        class="inline-flex items-center gap-2 px-4 py-2.5 border border-slate-300 rounded-2xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-xs w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>{{ __('Tornar al dashboard') }}</span>
                    </a>

                    <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold shadow-md shadow-indigo-600/20 transition w-full sm:w-auto justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ __('Desar dades de la banda') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoInput = document.getElementById('logoInput');
            const logoPreview = document.getElementById('logoPreview');
            const logoPlaceholder = document.getElementById('logoPlaceholder');

            if (logoInput && logoPreview) {
                logoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            logoPreview.src = ev.target.result;
                            logoPreview.classList.remove('hidden');
                            if (logoPlaceholder) {
                                logoPlaceholder.classList.add('hidden');
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</x-app-layout>
