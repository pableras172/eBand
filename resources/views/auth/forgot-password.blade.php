<x-guest-layout>
    <section class="relative min-h-screen overflow-hidden bg-slate-50">

        <div class="grid min-h-screen grid-cols-1 md:grid-cols-2">

            {{-- Panel izquierdo: imagen de concierto (solo escritorio) --}}
            <div class="relative hidden overflow-hidden md:flex md:flex-col md:justify-end">
                <img
                    src="https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=1280&q=80&fit=crop"
                    alt="Concierto"
                    class="absolute inset-0 h-full w-full object-cover object-center"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/50 to-slate-800/20"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(34,211,238,0.15),transparent_55%)]"></div>

                <div class="relative z-10 p-10">
                    <a href="/" class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-3 py-2 backdrop-blur-sm transition hover:bg-white/20">
                        <img class="h-8 w-auto" src="{{ URL::to('/') }}/imagenes/logo.png" alt="Logo" />
                        <span class="text-sm font-semibold tracking-wide text-white">eBand</span>
                    </a>
                    <h2 class="mt-6 text-3xl font-black tracking-tight text-white">{{ __('Sin contraseña, sin problema.') }}</h2>
                    <p class="mt-2 max-w-xs text-sm text-white/60">{{ __('Te enviamos un enlace a tu email para que puedas recuperar el acceso en segundos.') }}</p>
                </div>
            </div>

            {{-- Panel derecho: formulario --}}
            <div class="flex items-center bg-slate-50 px-6 py-8 sm:px-8 md:px-12 md:py-12">
                <div class="w-full max-w-md">
                    <div class="mb-6">
                        {{-- Logo visible en móvil --}}
                        <a href="/" class="mb-5 inline-flex items-center gap-2 rounded-xl border border-cyan-200 bg-white/90 px-3 py-2 shadow-sm backdrop-blur-sm transition hover:bg-white md:hidden">
                            <img class="h-8 w-auto" src="{{ URL::to('/') }}/imagenes/logo.png" alt="Logo" />
                            <span class="text-sm font-semibold tracking-wide text-slate-800">eBand</span>
                        </a>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cyan-700">eBand Access</p>
                        <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900">{{ __('Recupera tu acceso') }}</h2>
                    </div>

                    {{-- Instrucciones --}}
                    <div class="mb-5 rounded-xl border border-cyan-200 bg-cyan-50 p-4">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-cyan-800">{{ __('¿Cómo funciona?') }}</p>
                                <ol class="mt-2 space-y-1 text-sm text-cyan-700">
                                    <li>1. {{ __('Introduce el email con el que te registraste.') }}</li>
                                    <li>2. {{ __('Recibirás un enlace para crear una nueva contraseña.') }}</li>
                                    <li>3. {{ __('El enlace caduca en 60 minutos por seguridad.') }}</li>
                                </ol>
                                <p class="mt-2 text-xs text-cyan-600">{{ __('Revisa también la carpeta de spam si no ves el correo.') }}</p>
                            </div>
                        </div>
                    </div>

                    @if (session('status'))
                        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <x-validation-errors class="mb-4 rounded-xl border border-rose-200 bg-rose-50 p-3 text-rose-700" />

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-label for="email" class="text-sm font-semibold text-slate-700" value="{{ __('auth.email') }}" />
                            <x-input id="email" class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3 py-3 text-slate-900 placeholder:text-slate-400 focus:border-cyan-400 focus:ring-cyan-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        </div>

                        <x-button class="w-full justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-black tracking-wide text-slate-900 shadow-lg shadow-cyan-500/25 transition hover:bg-cyan-400 focus:ring-cyan-300">
                            {{ __('Enviar enlace de recuperación') }}
                        </x-button>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 underline decoration-slate-300 underline-offset-4 transition hover:text-slate-900">
                                {{ __('Volver al login') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
