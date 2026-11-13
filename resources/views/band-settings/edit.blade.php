<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 9h6M9 13h6M9 17h3" />
                </svg>
            </div>
            <div>
                <x-ui.breadcrumbs>
                    <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                    <x-ui.breadcrumbs.separator />
                    <x-ui.breadcrumbs.link active>{{ __('Dades de la banda') }}</x-ui.breadcrumbs.link>
                </x-ui.breadcrumbs>
                <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">{{ __('Datos de la banda') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">{{ __('Personaliza la información pública y de contacto de la banda.') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-4 px-2 sm:px-4 lg:px-6 space-y-6 pb-28">
        @if (session('success_message'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-semibold text-emerald-800">
                {{ session('success_message') }}
            </div>
        @endif

        @if (session('error_message'))
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs font-semibold text-rose-800">
                {{ session('error_message') }}
            </div>
        @endif

        @if ($bandSetting?->activarcontactoinfo)
            <section class="rounded-3xl border border-indigo-50/80 bg-white p-6 shadow-bento">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <p class="text-sm font-bold text-slate-900">{{ __('QR de acceso a /masinfo') }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ __('Genera o actualiza el QR con la URL pública de contacto. Se guardará en almacenamiento para usarlo cuando quieras.') }}</p>

                        <form method="POST" action="{{ route('band-settings.generate-contact-qr') }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center rounded-2xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 transition">
                                {{ __('Generar QR de /masinfo') }}
                            </button>
                        </form>
                    </div>

                    @if ($bandSetting?->qr_contacto_masinfo)
                        <div class="flex flex-col items-center gap-2">
                            <img src="{{ asset('storage/' . $bandSetting->qr_contacto_masinfo) }}"
                                alt="QR /masinfo"
                                class="h-40 w-40 rounded-2xl border border-indigo-100 bg-white object-contain p-2 shadow-xs">
                            <a href="{{ asset('storage/' . $bandSetting->qr_contacto_masinfo) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                                {{ __('Abrir QR') }}
                            </a>
                        </div>
                    @endif
                </div>
            </section>
        @endif
        <form method="POST" action="{{ route('band-settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="rounded-3xl bg-white p-6 shadow-bento border border-indigo-50/80">
                <div class="mb-4 border-b border-gray-100 pb-3">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Identidad de la banda') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('Nombre, fiscalidad y datos básicos de contacto.') }}</p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>
                        <input type="text" name="nombre" id="nombre"
                            value="{{ old('nombre', $bandSetting?->nombre) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                            required>
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nif_cif" class="block text-sm font-medium text-gray-700">{{ __('NIF / CIF') }}</label>
                        <input type="text" name="nif_cif" id="nif_cif"
                            value="{{ old('nif_cif', $bandSetting?->nif_cif) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('nif_cif')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="direccion" class="block text-sm font-medium text-gray-700">{{ __('Dirección') }}</label>
                        <input type="text" name="direccion" id="direccion"
                            value="{{ old('direccion', $bandSetting?->direccion) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('direccion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">{{ __('Teléfono') }}</label>
                        <input type="text" name="telefono" id="telefono"
                            value="{{ old('telefono', $bandSetting?->telefono) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('telefono')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email', $bandSetting?->email) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="website" class="block text-sm font-medium text-gray-700">{{ __('Sitio web') }}</label>
                        <input type="url" name="website" id="website"
                            value="{{ old('website', $bandSetting?->website) }}"
                            placeholder="https://"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <section class="rounded-3xl bg-white p-6 shadow-bento border border-indigo-50/80">
                <div class="mb-4 border-b border-gray-100 pb-3">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Presidencia e imagen') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('Selecciona la presidencia actual y el logo de la banda.') }}</p>
                </div>

                <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_auto]">
                    <div class="space-y-4">
                        <div>
                            <label for="iduserpresidente" class="block text-sm font-medium text-gray-700">{{ __('Presidente') }}</label>
                            <select name="iduserpresidente" id="iduserpresidente"
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                <option value="">{{ __('Selecciona un usuario') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected((string) old('iduserpresidente', $bandSetting?->iduserpresidente) === (string) $user->id)>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('iduserpresidente')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700">{{ __('Logo') }}</label>
                            <input type="file" name="logo" id="logo" accept="image/*"
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                            <p class="mt-1 text-xs text-gray-500">{{ __('Formatos recomendados: JPG, PNG, WEBP. Máximo 2MB.') }}</p>
                            @error('logo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-center">
                        <div class="h-28 w-28 rounded-2xl border border-gray-200 bg-gray-50 overflow-hidden flex items-center justify-center">
                            @if ($bandSetting?->logo)
                                <img src="{{ asset('storage/'.$bandSetting->logo) }}" alt="Logo banda" class="h-full w-full object-contain">
                            @else
                                <span class="text-xs text-gray-400 text-center px-2">{{ __('Sin logo') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-3xl bg-white p-6 shadow-bento border border-indigo-50/80">
                <div class="mb-4 border-b border-gray-100 pb-3">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Redes sociales') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('URLs oficiales para compartir desde la web y documentos.') }}</p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label for="urlinstagram" class="block text-sm font-medium text-gray-700">{{ __('Instagram') }}</label>
                        <input type="url" name="urlinstagram" id="urlinstagram"
                            value="{{ old('urlinstagram', $bandSetting?->urlinstagram) }}"
                            placeholder="https://instagram.com/..."
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('urlinstagram')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="urlfacebook" class="block text-sm font-medium text-gray-700">{{ __('Facebook') }}</label>
                        <input type="url" name="urlfacebook" id="urlfacebook"
                            value="{{ old('urlfacebook', $bandSetting?->urlfacebook) }}"
                            placeholder="https://facebook.com/..."
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('urlfacebook')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="urltiktok" class="block text-sm font-medium text-gray-700">{{ __('TikTok') }}</label>
                        <input type="url" name="urltiktok" id="urltiktok"
                            value="{{ old('urltiktok', $bandSetting?->urltiktok) }}"
                            placeholder="https://tiktok.com/@..."
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('urltiktok')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <section class="rounded-3xl bg-white p-6 shadow-bento border border-indigo-50/80">
                <div class="mb-4 border-b border-gray-100 pb-3">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Formulario público de contacto') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('Permite activar o desactivar el acceso público a /masinfo.') }}</p>
                </div>

                <div class="flex items-start justify-between gap-4 rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ __('Activar formulario /masinfo') }}</p>
                        <p class="text-xs text-gray-500">{{ __('Si está desactivado, los visitantes serán redirigidos a inicio.') }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="hidden" name="activarcontactoinfo" value="0">
                        <input type="checkbox"
                            name="activarcontactoinfo"
                            id="activarcontactoinfo"
                            value="1"
                            @checked((bool) old('activarcontactoinfo', $bandSetting?->activarcontactoinfo))
                            class="h-5 w-5 rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
                        <label for="activarcontactoinfo" class="text-sm text-gray-700">{{ __('Activo') }}</label>
                    </div>
                </div>

                
            </section>

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center rounded-2xl bg-indigo-600 px-6 py-3 text-xs font-bold text-white shadow-md shadow-indigo-600/20 transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    {{ __('Guardar datos de la banda') }}
                </button>
            </div>
                </button>
            </div>
        </form>
        
    </div>
</x-app-layout>
