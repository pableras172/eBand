<x-guest-layout>
    <section class="relative min-h-screen overflow-hidden bg-slate-50">
        <div class="mx-auto flex min-h-screen w-full max-w-6xl items-center px-6 py-10 sm:px-8">
            <div class="grid w-full gap-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-xl sm:p-8 md:grid-cols-2">
                <div class="flex flex-col justify-between rounded-xl bg-gradient-to-br from-cyan-600 to-teal-600 p-6 text-white">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cyan-100">eBand 3.0.0</p>
                        <h1 class="mt-3 text-3xl font-black tracking-tight">Acceso por grupo</h1>
                        <p class="mt-3 text-sm text-cyan-100">
                            Introduce el código de tu banda o conjunto para acceder a su espacio privado.
                        </p>
                    </div>
                    <p class="mt-6 text-xs text-cyan-100/90">El código solo se usa para localizar tu dominio de acceso inicial.</p>
                </div>

                <div class="flex items-center">
                    <div class="w-full">
                        @if ($errors->any())
                            <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('tenant-access.store', ['central_domain' => request()->route('central_domain') ?? request()->getHost()]) }}" class="space-y-4">
                            @csrf

                            <div>
                                <label for="code" class="text-sm font-semibold text-slate-700">Código de grupo</label>
                                <input id="code"
                                    name="code"
                                    type="text"
                                    value="{{ old('code') }}"
                                    required
                                    autofocus
                                    class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3 py-3 text-slate-900 placeholder:text-slate-400 focus:border-cyan-400 focus:ring-cyan-400"
                                    placeholder="ejemplo: banda-centro" />
                            </div>

                            <button type="submit"
                                class="inline-flex w-full items-center justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-black tracking-wide text-slate-900 shadow-lg shadow-cyan-500/25 transition hover:bg-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2">
                                Continuar al grupo
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
