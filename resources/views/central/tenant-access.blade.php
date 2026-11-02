<x-guest-layout>
    <section class="relative min-h-screen overflow-hidden bg-slate-50">
        <div class="mx-auto flex min-h-screen w-full max-w-6xl items-center px-6 py-10 sm:px-8">
            <div class="grid w-full gap-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-xl sm:p-8 md:grid-cols-2">
                <!-- Left Column: Branding and Demo Explanation -->
                <div class="flex flex-col justify-between rounded-xl bg-gradient-to-br from-blue-700 via-indigo-600 to-indigo-800 p-6 sm:p-8 text-white">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-200">eBand 3.0</span>
                            <span class="rounded-full bg-amber-400/20 px-2.5 py-0.5 text-[10px] font-bold text-amber-200 border border-amber-300/30">Multi-Agrupación</span>
                        </div>
                        <h1 class="mt-4 text-3xl font-black tracking-tight">Acceso a tu Agrupación</h1>
                        <p class="mt-3 text-sm text-blue-100 leading-relaxed">
                            Introduce el código de tu Banda, Charanga o Coral para acceder a su espacio privado.
                        </p>
                    </div>

                    <!-- Highlighted Box for Demo Users -->
                    <div class="my-6 rounded-xl bg-white/10 p-4 border border-white/15 backdrop-blur-sm">
                        <div class="flex items-center gap-2 text-xs font-bold text-amber-300">
                            <span class="flex h-2 w-2 rounded-full bg-amber-400 animate-pulse"></span>
                            <span>¿Quieres probar la aplicación?</span>
                        </div>
                        <p class="mt-1.5 text-xs text-blue-100 leading-relaxed">
                            Hemos pre-cargado el código de prueba <strong class="text-white underline decoration-amber-400 decoration-2">demo</strong> para que puedas explorar todas las funcionalidades de inmediato sin complicaciones.
                        </p>
                    </div>

                    <div class="flex items-center justify-between border-t border-white/10 pt-4">
                        <p class="text-xs text-blue-200/90">Espacio seguro por subdominio.</p>
                        <a href="{{ url('/') }}" class="text-xs font-semibold text-white hover:text-amber-300 underline transition">← Volver a la web</a>
                    </div>
                </div>

                <!-- Right Column: Code Form with preloaded 'demo' -->
                <div class="flex items-center">
                    <div class="w-full">
                        @if (session('status'))
                            <div class="mb-4 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form id="tenant-access-form" method="POST" action="{{ route('tenant-access.store') }}" class="space-y-5">
                            @csrf

                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="code" class="text-sm font-semibold text-slate-700">Código de tu agrupación</label>
                                    <button type="button" 
                                            onclick="document.getElementById('code').value = 'demo';"
                                            class="text-xs font-medium text-blue-700 hover:text-blue-900 underline">
                                        Restablecer a código demo
                                    </button>
                                </div>
                                <div class="relative mt-2">
                                    <input id="code"
                                        name="code"
                                        type="text"
                                        value="{{ old('code', request('code', 'demo')) }}"
                                        required
                                        autofocus
                                        class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 font-semibold text-base"
                                        placeholder="ejemplo: demo o mi-banda" />
                                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <span class="rounded-md bg-blue-100 px-2 py-0.5 text-[11px] font-bold text-blue-800">demo</span>
                                    </span>
                                </div>
                                <p class="mt-2 text-xs text-slate-500">
                                    Si eres miembro de una banda existente, introduce el código facilitado por tu directiva.
                                </p>
                            </div>

                            <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-700 to-indigo-600 px-4 py-3.5 text-sm font-bold tracking-wide text-white shadow-lg shadow-blue-700/25 transition hover:from-blue-800 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                <span>Acceder a la agrupación</span>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
