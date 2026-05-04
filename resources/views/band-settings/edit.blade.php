<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="bg-gradient-to-br from-cyan-500 to-blue-600 p-3 rounded-xl shadow-md">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 9h6M9 13h6M9 17h3" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Datos de la banda') }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Personaliza la información pública y de contacto de la banda.') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-4 px-2 sm:px-4 lg:px-6 space-y-6 pb-28">
        @if (session('success_message'))
            <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success_message') }}
            </div>
        @endif

        @if (session('error_message'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                {{ session('error_message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('band-settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <div class="mb-4 border-b border-gray-100 pb-3">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Identidad de la banda') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('Nombre, fiscalidad y datos básicos de contacto.') }}</p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">{{ __('Nombre') }}</label>
                        <input type="text" name="nombre" id="nombre"
                            value="{{ old('nombre', $bandSetting->nombre) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                            required>
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nif_cif" class="block text-sm font-medium text-gray-700">{{ __('NIF / CIF') }}</label>
                        <input type="text" name="nif_cif" id="nif_cif"
                            value="{{ old('nif_cif', $bandSetting->nif_cif) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('nif_cif')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="direccion" class="block text-sm font-medium text-gray-700">{{ __('Dirección') }}</label>
                        <input type="text" name="direccion" id="direccion"
                            value="{{ old('direccion', $bandSetting->direccion) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('direccion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">{{ __('Teléfono') }}</label>
                        <input type="text" name="telefono" id="telefono"
                            value="{{ old('telefono', $bandSetting->telefono) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('telefono')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email', $bandSetting->email) }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="website" class="block text-sm font-medium text-gray-700">{{ __('Sitio web') }}</label>
                        <input type="url" name="website" id="website"
                            value="{{ old('website', $bandSetting->website) }}"
                            placeholder="https://"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <section class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
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
                                    <option value="{{ $user->id }}" @selected((string) old('iduserpresidente', $bandSetting->iduserpresidente) === (string) $user->id)>
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
                            @if ($bandSetting->logo)
                                <img src="{{ asset('storage/'.$bandSetting->logo) }}" alt="Logo banda" class="h-full w-full object-contain">
                            @else
                                <span class="text-xs text-gray-400 text-center px-2">{{ __('Sin logo') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                <div class="mb-4 border-b border-gray-100 pb-3">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Redes sociales') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('URLs oficiales para compartir desde la web y documentos.') }}</p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label for="urlinstagram" class="block text-sm font-medium text-gray-700">{{ __('Instagram') }}</label>
                        <input type="url" name="urlinstagram" id="urlinstagram"
                            value="{{ old('urlinstagram', $bandSetting->urlinstagram) }}"
                            placeholder="https://instagram.com/..."
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('urlinstagram')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="urlfacebook" class="block text-sm font-medium text-gray-700">{{ __('Facebook') }}</label>
                        <input type="url" name="urlfacebook" id="urlfacebook"
                            value="{{ old('urlfacebook', $bandSetting->urlfacebook) }}"
                            placeholder="https://facebook.com/..."
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('urlfacebook')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="urltiktok" class="block text-sm font-medium text-gray-700">{{ __('TikTok') }}</label>
                        <input type="url" name="urltiktok" id="urltiktok"
                            value="{{ old('urltiktok', $bandSetting->urltiktok) }}"
                            placeholder="https://tiktok.com/@..."
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                        @error('urltiktok')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <section class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
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
                            @checked((bool) old('activarcontactoinfo', $bandSetting->activarcontactoinfo))
                            class="h-5 w-5 rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
                        <label for="activarcontactoinfo" class="text-sm text-gray-700">{{ __('Activo') }}</label>
                    </div>
                </div>

                @if ($bandSetting->activarcontactoinfo)
                    <div class="mt-4 rounded-xl border border-cyan-200 bg-cyan-50 p-4">
                        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <div>
                                <p class="text-sm font-semibold text-cyan-900">{{ __('QR de acceso a /masinfo') }}</p>
                                <p class="text-xs text-cyan-700">{{ __('Genera o actualiza el QR con la URL pública de contacto. Se guardará en almacenamiento para usarlo cuando quieras.') }}</p>

                                <form method="POST" action="{{ route('band-settings.generate-contact-qr') }}" class="mt-3">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center rounded-xl bg-cyan-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-700">
                                        {{ __('Generar QR de /masinfo') }}
                                    </button>
                                </form>
                            </div>

                            @if ($bandSetting->qr_contacto_masinfo)
                                <div class="flex flex-col items-center gap-2">
                                    <img src="{{ asset('storage/' . $bandSetting->qr_contacto_masinfo) }}"
                                        alt="QR /masinfo"
                                        class="h-40 w-40 rounded-lg border border-cyan-200 bg-white object-contain p-2">
                                    <a href="{{ asset('storage/' . $bandSetting->qr_contacto_masinfo) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-xs font-medium text-cyan-700 hover:text-cyan-900">
                                        {{ __('Abrir QR') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </section>

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center rounded-xl bg-cyan-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                    {{ __('Guardar datos de la banda') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
