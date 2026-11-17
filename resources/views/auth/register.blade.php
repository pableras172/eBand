<x-guest-layout>
    @php
        $bandName = function_exists('tenant_name') && function_exists('tenant') && tenant()
            ? tenant_name()
            : ($bandSetting?->nombre ?? config('app.banda', config('app.name', 'eBand')));
        $bandLogo = $bandSetting?->logo ? asset('storage/'.$bandSetting->logo) : url('/imagenes/logo.png');
        $hasSocialOrContact = $bandSetting && (
            $bandSetting->direccion ||
            $bandSetting->telefono ||
            $bandSetting->email ||
            $bandSetting->website ||
            $bandSetting->urlinstagram ||
            $bandSetting->urlfacebook ||
            $bandSetting->urltiktok
        );
    @endphp
    <section class="relative min-h-screen overflow-hidden bg-slate-50">

        <div class="grid min-h-screen grid-cols-1 md:grid-cols-2">

            {{-- Panel izquierdo: imagen de concierto (solo escritorio) --}}
            <div class="relative hidden overflow-hidden md:flex md:flex-col md:justify-between p-8 lg:p-12">
                <img
                    src="https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=1280&q=80&fit=crop"
                    alt="Concierto"
                    class="absolute inset-0 h-full w-full object-cover object-center"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-900/65 to-slate-900/35"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(34,211,238,0.22),transparent_55%)]"></div>

                {{-- Header superior del panel izquierdo --}}
                <div class="relative z-10 flex items-center justify-between">
                    <a href="/" class="inline-flex items-center gap-3 rounded-2xl border border-white/20 bg-white/10 px-4 py-2.5 backdrop-blur-md shadow-sm transition hover:bg-white/20">
                        <img class="h-9 w-auto object-contain" src="{{ $bandLogo }}" alt="{{ $bandName }}" />
                        <span class="text-sm font-bold tracking-wide text-white">{{ $bandName }}</span>
                    </a>
                </div>

                {{-- Info y redes en la parte inferior del panel izquierdo --}}
                <div class="relative z-10 space-y-5">
                    <div>
                        <h2 class="text-3xl font-black tracking-tight text-white">{{ __('Únete a la banda.') }}</h2>
                        <p class="mt-2 text-sm text-white/70 max-w-sm leading-relaxed">
                            {{ __('Actuaciones, asistencia, partituras, pagos y equipo en un solo lugar.') }}
                        </p>
                    </div>

                    @if ($hasSocialOrContact)
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md space-y-3 max-w-md">
                            @if ($bandSetting->direccion)
                                <div class="flex items-start gap-2.5 text-xs text-white/90">
                                    <svg class="h-4 w-4 text-cyan-300 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <span class="leading-snug">{{ $bandSetting->direccion }}</span>
                                </div>
                            @endif

                            @if ($bandSetting->telefono || $bandSetting->email)
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-white/80">
                                    @if ($bandSetting->telefono)
                                        <a href="tel:{{ $bandSetting->telefono }}" class="inline-flex items-center gap-1.5 hover:text-cyan-300 transition">
                                            <svg class="h-3.5 w-3.5 text-cyan-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                            </svg>
                                            <span>{{ $bandSetting->telefono }}</span>
                                        </a>
                                    @endif

                                    @if ($bandSetting->email)
                                        <a href="mailto:{{ $bandSetting->email }}" class="inline-flex items-center gap-1.5 hover:text-cyan-300 transition">
                                            <svg class="h-3.5 w-3.5 text-cyan-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                            </svg>
                                            <span>{{ $bandSetting->email }}</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            {{-- Redes Sociales y Web --}}
                            @if ($bandSetting->website || $bandSetting->urlinstagram || $bandSetting->urlfacebook || $bandSetting->urltiktok)
                                <div class="pt-2 border-t border-white/10 flex items-center gap-2">
                                    @if ($bandSetting->website)
                                        <a href="{{ $bandSetting->website }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white/10 text-white hover:bg-cyan-500 hover:text-slate-900 transition"
                                            title="{{ __('Web oficial') }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                            </svg>
                                        </a>
                                    @endif

                                    @if ($bandSetting->urlinstagram)
                                        <a href="{{ $bandSetting->urlinstagram }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white/10 text-white hover:bg-pink-600 hover:text-white transition"
                                            title="Instagram">
                                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            </svg>
                                        </a>
                                    @endif

                                    @if ($bandSetting->urlfacebook)
                                        <a href="{{ $bandSetting->urlfacebook }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white/10 text-white hover:bg-blue-600 hover:text-white transition"
                                            title="Facebook">
                                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                        </a>
                                    @endif

                                    @if ($bandSetting->urltiktok)
                                        <a href="{{ $bandSetting->urltiktok }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white/10 text-white hover:bg-black hover:text-white transition"
                                            title="TikTok">
                                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Panel derecho: formulario --}}
            <div class="flex items-center bg-slate-50 px-6 py-8 sm:px-8 md:px-12 md:py-12">
                <div class="w-full max-w-md mx-auto">
                    <div class="mb-6">
                        {{-- Logo visible en móvil --}}
                        <a href="/" class="mb-5 inline-flex items-center gap-2.5 rounded-xl border border-cyan-200 bg-white/95 px-3.5 py-2 shadow-sm backdrop-blur-sm transition hover:bg-white md:hidden">
                            <img class="h-8 w-auto object-contain" src="{{ $bandLogo }}" alt="{{ $bandName }}" />
                            <span class="text-sm font-bold tracking-wide text-slate-800">{{ $bandName }}</span>
                        </a>

                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-cyan-700">{{ $bandName }}</p>
                        <h2 class="mt-1 text-2xl sm:text-3xl font-black tracking-tight text-slate-900">{{ __('Nuevo usuario') }}</h2>

                        @if ($bandSetting?->direccion)
                            <p class="mt-1 flex items-center gap-1.5 text-xs text-slate-500">
                                <svg class="h-3.5 w-3.5 text-cyan-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <span class="truncate">{{ $bandSetting->direccion }}</span>
                            </p>
                        @endif
                    </div>

                    <x-validation-errors class="mb-4 rounded-xl border border-rose-200 bg-rose-50 p-3 text-rose-700" />

                    @if ($errors->has('g-recaptcha-response'))
                        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 p-3 text-sm font-medium text-rose-700">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </div>
                    @endif

                    <div class="mb-5 flex items-center justify-between rounded-xl border border-slate-200 bg-white/80 px-3 py-2 backdrop-blur-sm">
                        <p class="text-sm font-medium text-slate-700">{{ __('¿Ya tienes cuenta?') }}</p>
                        <a class="rounded-md text-sm font-semibold text-cyan-700 underline decoration-cyan-300 underline-offset-4 transition hover:text-cyan-900 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-white"
                            href="{{ route('login') }}">
                            {{ __('auth.iniciasesion') }}
                        </a>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-label for="name" class="text-sm font-semibold text-slate-700" value="{{ __('auth.nombre') }}" />
                            <x-input id="name" class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3 py-3 text-slate-900 placeholder:text-slate-400 focus:border-cyan-400 focus:ring-cyan-400" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        </div>

                        <div>
                            <x-label for="apellidos" class="text-sm font-semibold text-slate-700" value="{{ __('auth.apellidos') }}" />
                            <x-input id="apellidos" class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3 py-3 text-slate-900 placeholder:text-slate-400 focus:border-cyan-400 focus:ring-cyan-400" type="text" name="apellidos" :value="old('apellidos')" required autofocus autocomplete="family-name" />
                        </div>

                        <div>
                            <x-label for="email" class="text-sm font-semibold text-slate-700" value="{{ __('auth.email') }}" />
                            <x-input id="email" class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3 py-3 text-slate-900 placeholder:text-slate-400 focus:border-cyan-400 focus:ring-cyan-400" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        </div>

                        <div>
                            <x-label for="password" class="text-sm font-semibold text-slate-700" value="{{ __('auth.contrase') }}" />
                            <x-input id="password" class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3 py-3 text-slate-900 placeholder:text-slate-400 focus:border-cyan-400 focus:ring-cyan-400" type="password" name="password" required autocomplete="new-password" />
                        </div>

                        <div>
                            <x-label for="password_confirmation" class="text-sm font-semibold text-slate-700" value="{{ __('auth.confirmacontrase') }}" />
                            <x-input id="password_confirmation" class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3 py-3 text-slate-900 placeholder:text-slate-400 focus:border-cyan-400 focus:ring-cyan-400" type="password" name="password_confirmation" required autocomplete="new-password" />
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div>
                                <x-label for="terms">
                                    <div class="flex items-start gap-2">
                                        <x-checkbox name="terms" id="terms" required class="mt-0.5" />
                                        <div class="ms-1 text-sm text-slate-600">
                                            {!! __('auth.terminos', [
                                                'terms_of_service' =>
                                                    '<a target="_blank" href="' .
                                                    route('terms.show') .
                                                    '" class="font-medium text-cyan-700 underline decoration-cyan-300 underline-offset-4 hover:text-cyan-900">' .
                                                    __('auth.terminosservicio') .
                                                    '</a>',
                                                'privacy_policy' =>
                                                    '<a target="_blank" href="' .
                                                    route('policy.show') .
                                                    '" class="font-medium text-cyan-700 underline decoration-cyan-300 underline-offset-4 hover:text-cyan-900">' .
                                                    __('auth.politicaprivacidad') .
                                                    '</a>',
                                            ]) !!}
                                        </div>
                                    </div>
                                </x-label>
                            </div>
                        @endif

                        <div class="flex justify-center">
                            {!! NoCaptcha::display() !!}
                        </div>

                        <x-button class="w-full justify-center rounded-xl bg-cyan-500 px-4 py-3 text-sm font-black tracking-wide text-slate-900 shadow-lg shadow-cyan-500/25 transition hover:bg-cyan-400 focus:ring-cyan-300">
                            {{ __('auth.registrar') }}
                        </x-button>
                    </form>

                    {{-- Footer de contacto y redes sociales de la banda (visible en móvil y desktop) --}}
                    @if ($hasSocialOrContact)
                        <div class="mt-8 border-t border-slate-200/80 pt-6">
                            <div class="flex flex-col items-center gap-3 text-center sm:flex-row sm:justify-between sm:text-left">
                                <div class="space-y-0.5">
                                    <p class="text-xs font-semibold text-slate-700">{{ $bandName }}</p>
                                    @if ($bandSetting->email || $bandSetting->telefono)
                                        <div class="flex items-center justify-center gap-3 text-[11px] text-slate-500 sm:justify-start">
                                            @if ($bandSetting->telefono)
                                                <a href="tel:{{ $bandSetting->telefono }}" class="hover:text-cyan-700 transition">{{ $bandSetting->telefono }}</a>
                                            @endif
                                            @if ($bandSetting->telefono && $bandSetting->email)
                                                <span>•</span>
                                            @endif
                                            @if ($bandSetting->email)
                                                <a href="mailto:{{ $bandSetting->email }}" class="hover:text-cyan-700 transition">{{ $bandSetting->email }}</a>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                {{-- Iconos de redes sociales --}}
                                @if ($bandSetting->website || $bandSetting->urlinstagram || $bandSetting->urlfacebook || $bandSetting->urltiktok)
                                    <div class="flex items-center gap-1.5 text-slate-500">
                                        @if ($bandSetting->website)
                                            <a href="{{ $bandSetting->website }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 transition"
                                                title="{{ __('Web oficial') }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                                </svg>
                                            </a>
                                        @endif

                                        @if ($bandSetting->urlinstagram)
                                            <a href="{{ $bandSetting->urlinstagram }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-pink-50 hover:text-pink-600 transition"
                                                title="Instagram">
                                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                                </svg>
                                            </a>
                                        @endif

                                        @if ($bandSetting->urlfacebook)
                                            <a href="{{ $bandSetting->urlfacebook }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition"
                                                title="Facebook">
                                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                </svg>
                                            </a>
                                        @endif

                                        @if ($bandSetting->urltiktok)
                                            <a href="{{ $bandSetting->urltiktok }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-black transition"
                                                title="TikTok">
                                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
{!! NoCaptcha::renderJs() !!}
