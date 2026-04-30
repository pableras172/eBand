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
                {{-- Overlay gradiente de abajo hacia arriba --}}
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/50 to-slate-800/20"></div>
                {{-- Toque de color cyan sutil en esquina superior --}}
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(34,211,238,0.15),transparent_55%)]"></div>

                <div class="relative z-10 p-10">
                    <a href="/" class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-3 py-2 backdrop-blur-sm transition hover:bg-white/20">
                        <img class="h-8 w-auto" src="{{ URL::to('/') }}/imagenes/logo.png" alt="Logo" />
                        <span class="text-sm font-semibold tracking-wide text-white">eBand</span>
                    </a>
                    <h2 class="mt-6 text-3xl font-black tracking-tight text-white">{{ __('Gestiona tu banda.') }}</h2>
                    <p class="mt-2 max-w-xs text-sm text-white/60">{{ __('Actuaciones, pagos y equipo en un solo lugar.') }}</p>
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
                        <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900">{{ __('Bienvenido') }}</h2>
                    </div>

                    <x-validation-errors class="mb-4 rounded-xl border border-rose-200 bg-rose-50 p-3 text-rose-700" />

                    @if ($errors->demoAccess->any())
                        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
                            {{ $errors->demoAccess->first() }}
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-5 flex items-center justify-between rounded-xl border border-slate-200 bg-white/80 px-3 py-2 backdrop-blur-sm">
                        <p class="text-sm font-medium text-slate-700">{{ __('¿Aún no tienes cuenta?') }}</p>
                        <a class="rounded-md text-sm font-semibold text-cyan-700 underline decoration-cyan-300 underline-offset-4 transition hover:text-cyan-900 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-white"
                            href="{{ route('register') }}">
                            {{ __('Nuevo usuario?') }}
                        </a>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-label for="email" class="text-sm font-semibold text-slate-700" value="{{ __('auth.email') }}" />
                            <x-input id="email" class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3 py-3 text-slate-900 placeholder:text-slate-400 focus:border-cyan-400 focus:ring-cyan-400" type="email" name="email" :value="old('email')"
                                required autofocus autocomplete="username" />
                        </div>

                        <div>
                            <x-label for="password" class="text-sm font-semibold text-slate-700" value="{{ __('auth.contrase') }}" />
                            <x-input id="password" class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3 py-3 text-slate-900 placeholder:text-slate-400 focus:border-cyan-400 focus:ring-cyan-400" type="password" name="password" required
                                autocomplete="current-password" />
                        </div>

                        <div class="flex items-center justify-between gap-3 pt-1">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ms-2 text-sm text-slate-700">{{ __('auth.recordarme') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-slate-700 underline decoration-slate-300 underline-offset-4 transition hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-white"
                                    href="{{ route('password.request') }}">
                                    {{ __('auth.olvidado') }}
                                </a>
                            @endif
                        </div>

                        <x-button class="w-full justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-black tracking-wide text-slate-900 shadow-lg shadow-cyan-500/25 transition hover:bg-cyan-400 focus:ring-cyan-300">
                            {{ __('Log in') }}
                        </x-button>
                    </form>

                    @if (config('demo.enabled'))
                        <div class="my-6 flex items-center gap-3">
                            <div class="h-px flex-1 bg-slate-200"></div>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Demo</span>
                            <div class="h-px flex-1 bg-slate-200"></div>
                        </div>

                        <form method="POST" action="{{ route('demo.access') }}" class="space-y-3 rounded-2xl border border-cyan-200 bg-cyan-50/60 p-4">
                            @csrf

                            <p class="text-sm font-semibold text-slate-800">{{ __('Solicita acceso inmediato a la demo') }}</p>
                            <p class="text-xs text-slate-600">{{ __('Te abrimos la app al instante con acceso completo del entorno de pruebas y te enviaremos un email de seguimiento.') }}</p>

                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div>
                                    <x-label for="demo_nombre" class="text-sm font-semibold text-slate-700" value="Nombre" />
                                    <x-input id="demo_nombre" class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3 py-2 text-slate-900" type="text" name="nombre"
                                        :value="old('nombre')" required autocomplete="given-name" />
                                </div>

                                <div>
                                    <x-label for="demo_apellidos" class="text-sm font-semibold text-slate-700" value="Apellidos" />
                                    <x-input id="demo_apellidos" class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3 py-2 text-slate-900" type="text" name="apellidos"
                                        :value="old('apellidos')" required autocomplete="family-name" />
                                </div>
                            </div>

                            <div>
                                <x-label for="demo_email" class="text-sm font-semibold text-slate-700" value="Email" />
                                <x-input id="demo_email" class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3 py-2 text-slate-900" type="email" name="email"
                                    :value="old('email')" required autocomplete="email" />
                            </div>

                            <div class="flex justify-center">
                                {!! NoCaptcha::display() !!}
                            </div>

                            <x-button class="w-full justify-center rounded-xl bg-slate-900 px-4 py-3 text-sm font-black tracking-wide text-white transition hover:bg-slate-700">
                                {{ __('Acceder a la demo ahora') }}
                            </x-button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>

@if (config('demo.enabled'))
    {!! NoCaptcha::renderJs() !!}
@endif
