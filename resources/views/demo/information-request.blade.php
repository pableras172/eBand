<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Solicitar informacion
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <p class="font-semibold">Revisa los campos del formulario.</p>
                </div>
            @endif

            <div class="rounded-2xl border border-amber-200 bg-white p-6 shadow-sm dark:border-amber-800 dark:bg-gray-800">
                <p class="mb-6 text-sm text-gray-600 dark:text-gray-300">
                    Si quieres que te contactemos con mas detalle sobre eBand, dejanos tus datos y te escribiremos con informacion adaptada a tu banda.
                </p>

                <form method="POST" action="{{ route('demo.info.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="nombre_apellidos" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nombre y apellidos</label>
                        <input
                            id="nombre_apellidos"
                            name="nombre_apellidos"
                            type="text"
                            value="{{ old('nombre_apellidos', $defaultNombreApellidos) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                            required
                        >
                        @error('nombre_apellidos')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="email_contacto" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email de contacto</label>
                            <input
                                id="email_contacto"
                                name="email_contacto"
                                type="email"
                                value="{{ old('email_contacto', $defaultEmailContacto) }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                required
                            >
                            @error('email_contacto')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefono_contacto" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Telefono de contacto</label>
                            <input
                                id="telefono_contacto"
                                name="telefono_contacto"
                                type="text"
                                value="{{ old('telefono_contacto', $defaultTelefonoContacto) }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                                required
                            >
                            @error('telefono_contacto')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="nombre_banda" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nombre de la banda</label>
                            <input
                                id="nombre_banda"
                                name="nombre_banda"
                                type="text"
                                value="{{ old('nombre_banda') }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                            >
                            @error('nombre_banda')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="numero_musicos" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Numero de musicos</label>
                            <input
                                id="numero_musicos"
                                name="numero_musicos"
                                type="number"
                                min="1"
                                value="{{ old('numero_musicos') }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                            >
                            @error('numero_musicos')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="notas" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Algunas notas</label>
                        <textarea
                            id="notas"
                            name="notas"
                            rows="5"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                            required
                        >{{ old('notas') }}</textarea>
                        @error('notas')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('dashboard') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                            Volver
                        </a>
                        <button type="submit" class="rounded-lg bg-amber-500 px-5 py-2 text-sm font-semibold text-amber-950 transition hover:bg-amber-400">
                            Enviar solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
