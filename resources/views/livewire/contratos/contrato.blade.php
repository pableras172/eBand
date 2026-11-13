<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-xs">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 14.25v-8.25A2.25 2.25 0 0017.25 3.75H6.75A2.25 2.25 0 004.5 6v12a2.25 2.25 0 002.25 2.25h7.5m-6-12h7.5m-7.5 4.5h4.5m5.25 2.25v6m3-3h-6" />
                    </svg>
                </div>
                <div>
                    <x-ui.breadcrumbs>
                        <x-ui.breadcrumbs.link href="/">{{ __('common.dashboard') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link href="{{ route('contratos.index') }}">{{ __('Contractes') }}</x-ui.breadcrumbs.link>
                        <x-ui.breadcrumbs.separator />
                        <x-ui.breadcrumbs.link active>
                            {{ isset($contrato) ? __('Editar contracte') : __('Nou contracte') }}
                        </x-ui.breadcrumbs.link>
                    </x-ui.breadcrumbs>
                    <h1 class="text-2xl lg:text-3xl font-extrabold font-headline text-slate-900 tracking-tight mt-0.5">
                        {{ isset($contrato) ? __('Editar contracte') : __('Nou contracte') }}
                    </h1>
                    <p class="mt-0.5 text-xs text-slate-500">
                        {{ isset($contrato) ? ($contrato->poblacion . ' — ' . $contrato->descripcion) : __('Registra un nou acord de la banda i la seua localització') }}
                    </p>
                </div>
            </div>

            @if (isset($contrato))
                <div class="flex items-center gap-2">
                    <a href="{{ route('contratos.actuaciones.index', ['contrato' => $contrato->id]) }}"
                        class="inline-flex items-center gap-2 rounded-2xl bg-indigo-50 border border-indigo-100 px-4 py-2.5 text-xs font-bold text-indigo-700 shadow-xs hover:bg-indigo-100 transition active:scale-95">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ __('Veure actuacions') }}</span>
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="container mx-auto py-4 px-3 sm:px-6 lg:px-8 pb-32 max-w-5xl">
        {{-- Errores de validación / Alertas --}}
        @if (session('error'))
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 py-3 px-4 mb-5 rounded-2xl text-xs font-semibold shadow-xs">
                <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 mb-5 rounded-2xl text-xs space-y-1 shadow-xs">
                <p class="font-bold">{{ __('Hi ha errors en el formulari:') }}</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="contratoForm" method="POST"
            action="{{ isset($contrato) ? route('contratos.update', $contrato->id) : route('contratos.store') }}"
            class="space-y-6">
            @csrf
            @if (isset($contrato))
                @method('PUT')
            @endif

            {{-- Bento Card 1: Ubicació i Població --}}
            <div class="rounded-3xl border border-indigo-50/80 bg-white p-6 shadow-bento space-y-5">
                <div class="flex items-center gap-3 border-b border-indigo-50 pb-3">
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold font-headline text-slate-900">
                            {{ __('Ubicació i geolocalització') }}
                        </h2>
                        <p class="text-xs text-slate-500">
                            {{ __('Indica la població on se celebra el contracte per a ubicar-lo al mapa') }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="relative">
                        <label for="poblacion" class="block text-xs font-bold uppercase tracking-wide text-slate-600 mb-1.5">
                            {{ __('Població') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </span>
                            <input type="text" id="poblacion" name="poblacion" autocomplete="off"
                                placeholder="{{ __('Escriu un municipi (ex. Llíria, Cullera, Buñol)...') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 pl-10 pr-4 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ old('poblacion', isset($contrato) ? $contrato->poblacion : '') }}" required />
                        </div>
                        <div id="municipio-suggestions"
                            class="absolute z-50 left-0 right-0 mt-1 max-h-60 overflow-y-auto rounded-2xl border border-indigo-100 bg-white shadow-xl hidden">
                        </div>

                        <input type="hidden" id="latitude" name="latitude"
                            value="{{ old('latitude', isset($contrato) ? $contrato->latitude : '') }}">
                        <input type="hidden" id="longitude" name="longitude"
                            value="{{ old('longitude', isset($contrato) ? $contrato->longitude : '') }}">
                    </div>

                    {{-- Mapa interactivo --}}
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wide text-slate-600 mb-1.5">
                            {{ __('Visualització al mapa') }}
                        </span>
                        <div class="rounded-2xl border border-indigo-100/80 overflow-hidden shadow-inner">
                            <livewire:location-map :height="200" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bento Card 2: Dades Generals i Dates --}}
            <div class="rounded-3xl border border-indigo-50/80 bg-white p-6 shadow-bento space-y-5">
                <div class="flex items-center gap-3 border-b border-indigo-50 pb-3">
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold font-headline text-slate-900">
                            {{ __('Dades del contracte') }}
                        </h2>
                        <p class="text-xs text-slate-500">
                            {{ __('Període de vigència, descripció i exercici') }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="descripcion" class="block text-xs font-bold uppercase tracking-wide text-slate-600 mb-1.5">
                            {{ __('Descripció') }} <span class="text-red-500">*</span>
                        </label>
                        <textarea id="descripcion" name="descripcion" rows="3" required
                            placeholder="{{ __('Exemple: Festes Patronals i Moros i Cristians de Sant Vicent') }}"
                            class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] p-3 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">{{ old('descripcion', isset($contrato) ? $contrato->descripcion : '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="fechainicio" class="block text-xs font-bold uppercase tracking-wide text-slate-600 mb-1.5">
                                {{ __('Data Inici') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="fechainicio" name="fechainicio"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ old('fechainicio', isset($contrato) ? $contrato->fechainicio : '') }}" required>
                        </div>
                        <div>
                            <label for="fechafin" class="block text-xs font-bold uppercase tracking-wide text-slate-600 mb-1.5">
                                {{ __('Data de Fi') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="fechafin" name="fechafin"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ old('fechafin', isset($contrato) ? $contrato->fechafin : '') }}" required>
                        </div>
                        <div>
                            <label for="anyo" class="block text-xs font-bold uppercase tracking-wide text-slate-600 mb-1.5">
                                {{ __('Any') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="anyo" name="anyo" min="1900" max="2100"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3 text-xs font-medium text-slate-800 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ old('anyo', isset($contrato) ? $contrato->anyo : date('Y')) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bento Card 3: Contacte i Observacions --}}
            <div class="rounded-3xl border border-indigo-50/80 bg-white p-6 shadow-bento space-y-5">
                <div class="flex items-center gap-3 border-b border-indigo-50 pb-3">
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold font-headline text-slate-900">
                            {{ __('Contacte i observacions') }}
                        </h2>
                        <p class="text-xs text-slate-500">
                            {{ __('Persona responsable de la contractació i notes rellevants') }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="contacto" class="block text-xs font-bold uppercase tracking-wide text-slate-600 mb-1.5">
                                {{ __('Persona de contacte') }}
                            </label>
                            <input type="text" id="contacto" name="contacto"
                                placeholder="{{ __('Nom del representant o comissió') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ old('contacto', isset($contrato) ? $contrato->contacto : '') }}">
                        </div>
                        <div>
                            <label for="dnicontacto" class="block text-xs font-bold uppercase tracking-wide text-slate-600 mb-1.5">
                                {{ __('DNI / NIF') }}
                            </label>
                            <input type="text" id="dnicontacto" name="dnicontacto"
                                placeholder="{{ __('12345678A') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ old('dnicontacto', isset($contrato) ? $contrato->dnicontacto : '') }}">
                        </div>
                        <div>
                            <label for="telefono" class="block text-xs font-bold uppercase tracking-wide text-slate-600 mb-1.5">
                                {{ __('Telèfon') }}
                            </label>
                            <input type="text" id="telefono" name="telefono"
                                placeholder="{{ __('600 000 000') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ old('telefono', isset($contrato) ? $contrato->telefono : '') }}">
                        </div>
                        <div>
                            <label for="correo" class="block text-xs font-bold uppercase tracking-wide text-slate-600 mb-1.5">
                                {{ __('Correu electrònic') }}
                            </label>
                            <input type="email" id="correo" name="correo"
                                placeholder="{{ __('contacte@festes.org') }}"
                                class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] py-2.5 px-3 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition"
                                value="{{ old('correo', isset($contrato) ? $contrato->correo : '') }}">
                        </div>
                    </div>

                    <div>
                        <label for="observacions" class="block text-xs font-bold uppercase tracking-wide text-slate-600 mb-1.5">
                            {{ __('Observacions') }}
                        </label>
                        <textarea id="observacions" name="observacions" rows="3"
                            placeholder="{{ __('Detalls sobre vestuari, alimentació, allotjament o particularitats del contracte...') }}"
                            class="w-full rounded-2xl border border-indigo-100/70 bg-[#F5F6FC] p-3 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition">{{ old('observacions', isset($contrato) ? $contrato->observacions : '') }}</textarea>
                    </div>
                </div>
            </div>
        </form>

        {{-- Bento Card 4: Importar actuacions des d'Excel (només en mode edició) --}}
        @if (isset($contrato))
            <div class="mt-6 rounded-3xl border border-indigo-50/80 bg-white p-6 shadow-bento space-y-4">
                <div class="flex items-center gap-3 border-b border-indigo-50 pb-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold font-headline text-slate-900">
                            {{ __('Importar actuacions des d\'Excel') }}
                        </h2>
                        <p class="text-xs text-slate-500">
                            {{ __('Pots carregar ràpidament un calendari complet d\'actuacions per a aquest contracte') }}
                        </p>
                    </div>
                </div>

                @livewire('actuaciones.importar-excel', ['contratoId' => $contrato->id])
            </div>
        @endif
    </div>

    {{-- Barra Flotante Inferior de Acciones (Neo-Bento Claro) --}}
    <footer class="fixed bottom-0 left-0 z-20 w-full bg-white/90 backdrop-blur-2xl border-t border-indigo-100/80 shadow-glass">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between gap-3 max-w-5xl">
            {{-- Enlace volver --}}
            <a href="{{ route('contratos.index') }}"
                class="inline-flex items-center gap-1.5 rounded-2xl border border-indigo-100 bg-[#F5F6FC] px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-700 active:scale-95 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>{{ __('Tornar') }}</span>
            </a>

            <div class="flex items-center gap-2">
                @if (isset($contrato))
                    {{-- Actuaciones --}}
                    <a href="{{ route('contratos.actuaciones.index', ['contrato' => $contrato->id]) }}"
                        class="hidden sm:inline-flex items-center gap-1.5 rounded-2xl bg-indigo-50 border border-indigo-100 px-3.5 py-2.5 text-xs font-bold text-indigo-700 hover:bg-indigo-100 transition active:scale-95"
                        title="{{ __('Actuacions') }}">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ __('Actuacions') }}</span>
                    </a>

                    {{-- Duplicar --}}
                    <a href="{{ route('contratos.duplicate', $contrato->id) }}"
                        class="inline-flex items-center gap-1.5 rounded-2xl bg-slate-100 border border-slate-200 px-3 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-200 transition active:scale-95"
                        title="{{ __('Duplicar') }}">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span class="hidden sm:inline">{{ __('Duplicar') }}</span>
                    </a>

                    {{-- Eliminar --}}
                    <form action="{{ route('contratos.destroy', $contrato) }}" method="POST"
                        onsubmit="return confirm('{{ __('¿Estás seguro de que deseas eliminar este contrato? Se eliminarán las actuaciones y las listas relacionadas.') }}')"
                        class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 rounded-2xl bg-red-50 border border-red-100 px-3 py-2.5 text-xs font-bold text-red-600 hover:bg-red-100 active:scale-95 transition"
                            title="{{ __('Eliminar') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span class="hidden sm:inline">{{ __('Eliminar') }}</span>
                        </button>
                    </form>
                @endif

                {{-- Botón Guardar / Actualizar --}}
                <button type="submit" form="contratoForm" id="submitBtn"
                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-indigo-600/20 hover:bg-indigo-700 active:scale-95 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ isset($contrato) ? __('Guardar canvis') : __('Crear contracte') }}</span>
                </button>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('poblacion');
            const box = document.getElementById('municipio-suggestions');
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const descripcion = document.getElementById('descripcion');

            // Si latitud y longitud tienen valor, actualizar el mapa al cargar la página
            const latValue = latInput ? latInput.value : null;
            const lngValue = lngInput ? lngInput.value : null;

            if (latValue && lngValue && window.MapComponent) {
                window.MapComponent.setMunicipios([{
                    nombre: input ? input.value : '',
                    coords: [parseFloat(latValue), parseFloat(lngValue)],
                    texto: descripcion ? descripcion.value : ''
                }]);
            }

            let debounce;

            if (input && box) {
                input.addEventListener('input', () => {
                    clearTimeout(debounce);
                    const q = input.value.trim();

                    if (q.length < 3) {
                        box.classList.add('hidden');
                        box.innerHTML = '';
                        return;
                    }

                    debounce = setTimeout(async () => {
                        try {
                            const url = `https://nominatim.openstreetmap.org/search?format=json&countrycodes=es&limit=5&q=${encodeURIComponent(q)}`;
                            const res = await fetch(url);
                            const data = await res.json();

                            box.innerHTML = '';
                            if (!data || !data.length) {
                                box.classList.add('hidden');
                                return;
                            }

                            data.forEach(item => {
                                const div = document.createElement('div');
                                div.className = 'px-4 py-2.5 hover:bg-indigo-50/80 cursor-pointer text-xs font-medium text-slate-700 border-b border-indigo-50 last:border-0 transition';
                                div.textContent = item.display_name;

                                div.addEventListener('click', () => {
                                    input.value = item.name || item.display_name;
                                    if (latInput) latInput.value = item.lat;
                                    if (lngInput) lngInput.value = item.lon;

                                    if (window.MapComponent) {
                                        window.MapComponent.setMunicipios([{
                                            nombre: item.display_name,
                                            coords: [parseFloat(item.lat), parseFloat(item.lon)],
                                            texto: item.display_name
                                        }]);
                                    }

                                    box.innerHTML = '';
                                    box.classList.add('hidden');
                                });

                                box.appendChild(div);
                            });

                            box.classList.remove('hidden');
                        } catch (err) {
                            console.error('Error fetching suggestions:', err);
                        }
                    }, 400);
                });

                document.addEventListener('click', (e) => {
                    if (!box.contains(e.target) && e.target !== input) {
                        box.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</x-app-layout>
