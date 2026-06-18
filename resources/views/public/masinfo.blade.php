<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $bandSetting?->nombre ?? config('app.name', 'eBand') }} | Mas informacion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        $shareTitle = $program->title ?? ($bandSetting?->nombre ?? config('app.name', 'eBand'));
        $shareDescription = $program->participants ?? ($bandSetting?->descripcion ?? __('Es fácil: contáctanos para más info sobre la banda.'));
        if (isset($program) && $program->image_path) {
            $shareImage = asset('storage/' . $program->image_path);
        } elseif (!empty($bandSetting?->logo)) {
            $shareImage = asset('storage/' . $bandSetting->logo);
        } else {
            $shareImage = asset('imagenes/logo.png');
        }
        $shareUrl = request()->fullUrl();
    @endphp

    <meta name="description" content="{{ \Illuminate\Support\Str::limit($shareDescription, 197) }}">
    <meta property="og:title" content="{{ $shareTitle }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit($shareDescription, 197) }}">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:url" content="{{ $shareUrl }}">
    <meta property="og:site_name" content="{{ config('app.name', 'eBand') }}">
    <meta property="og:type" content="{{ isset($program) ? 'event' : 'website' }}">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $shareTitle }}">
    <meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit($shareDescription, 197) }}">
    <meta name="twitter:image" content="{{ $shareImage }}">
</head>
<body class="min-h-screen bg-gradient-to-b from-white via-slate-50 to-white text-gray-900">
            
    @php
        $logoUrl = $bandSetting?->logo ? asset('storage/' . $bandSetting->logo) : URL::to('/') . '/imagenes/logo.png';
    @endphp

    <div class="pointer-events-none fixed inset-0 -z-20 opacity-25 blur-[6px]"
        style="background-image: url('{{ URL::to('/') }}/fondo_eband_head.jpg'); background-size: cover; background-position: center;">
    </div>
    <div class="pointer-events-none fixed inset-0 -z-10 bg-gradient-to-b from-white/85 via-white/92 to-white"></div>

    <main class="mx-auto w-full max-w-4xl px-4 py-10 sm:px-6 lg:px-8" data-initial-interes="{{ old('interes', '') }}">
        <div class="mb-2 flex justify-end">
            <div class="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white p-1.5 shadow-sm">                
                <div class="inline-flex overflow-hidden rounded-md border border-slate-300">
                    <a href="/greeting/ca_VL" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold transition sm:text-sm {{ app()->getLocale() === 'ca_VL' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-50' }}">
                        <span class="fi fi-es-ct"></span>
                        <span>VAL</span>
                    </a>
                    <a href="/greeting/es" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold transition sm:text-sm {{ app()->getLocale() === 'es' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 hover:bg-slate-50' }}">
                        <span class="fi fi-es"></span>
                        <span>CAS</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white/95 p-6 shadow-xl sm:p-10 backdrop-blur-sm">
            <div class="mb-8 flex flex-col items-center text-center gap-3">
                <img src="{{ $logoUrl }}" alt="{{ $bandSetting?->nombre ?? 'eBand' }}" class="h-20 w-20 rounded-2xl object-cover ring-4 ring-white shadow-md">
                <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">{{ __('Hola') }}</h1>
                <p class="max-w-2xl text-sm text-gray-600 sm:text-base">
                    {{ __('Es facil: nos cuentas que necesitas y te respondemos de forma cercana, clara y sin compromiso.') }}
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    {{ __('Revisa los campos del formulario y vuelve a intentarlo.') }}
                </div>
            @endif

            <section class="mb-8">
                <p class="mb-3 text-sm font-semibold text-gray-700">{{ __('Para empezar, elige una opcion:') }}</p>
                <div class="grid gap-3 sm:grid-cols-2">
                    <button
                        type="button"
                        data-set-interes="soy_banda"
                        class="option-card rounded-2xl border border-slate-200 bg-white p-4 text-left transition hover:border-sky-300 hover:bg-sky-50/40">
                        <p class="text-base font-semibold">{{ __('Soy una banda') }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ __('Quiero conocer el programa y ver si nos encaja.') }}</p>
                    </button>

                    <button
                        type="button"
                        data-set-interes="busco_banda"
                        class="option-card rounded-2xl border border-slate-200 bg-white p-4 text-left transition hover:border-sky-300 hover:bg-sky-50/40">
                        <p class="text-base font-semibold">{{ __('Busco una banda') }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ __('Necesito presupuesto para actuaciones y eventos.') }}</p>
                    </button>
                </div>
            </section>

            <section data-section="busco_banda" class="hidden">
                <div class="mb-4 rounded-2xl border border-sky-100 bg-sky-50 p-4 text-sm text-sky-900">
                    {{ __('Has llegado al lugar adecuado. Si quieres contar con la banda ') }}<strong>{{ $bandSetting?->nombre ?? config('app.name', 'eBand') }}</strong>{{ __(' en tus actuaciones, aquí tienes nuestros datos de contacto.') }}
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                        
                        <h2 class="text-lg font-semibold text-gray-900">{{ $bandSetting?->nombre ?? config('app.name', 'eBand') }}</h2>
                        <p class="mt-1 text-sm text-gray-600">{{ __('Aquí tienes nuestros datos de contacto:') }}</p>

                        <ul class="mt-3 space-y-2 text-sm text-gray-700">
                            @if(!empty($bandSetting?->telefono))
                                <li class="flex items-center gap-3">
                                    <!-- Phone icon -->
                                   <x-phone w="20" h="20" />
                                    <span class="font-medium">{{ __('Teléfono:') }}</span>
                                    <a href="tel:{{ $bandSetting->telefono }}" class="text-sky-700 hover:underline">{{ $bandSetting->telefono }}</a>
                                </li>
                            @endif

                            @if(!empty($bandSetting?->email))
                                <li class="flex items-center gap-3">
                                    <!-- Mail icon -->
                                    <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M3 8.5V17.5C3 18.3284 3.67157 19 4.5 19H19.5C20.3284 19 21 18.3284 21 17.5V8.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 8.5L12 13.5L3 8.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="font-medium">{{ __('Correo:') }}</span>
                                    <a href="mailto:{{ $bandSetting->email }}" class="text-sky-700 hover:underline">{{ $bandSetting->email }}</a>
                                </li>
                            @endif

                            @if(!empty($bandSetting?->website))
                                <li class="flex items-center gap-3">
                                    <!-- Globe icon -->
                                    <x-navi w="20" h="20" />
                                            <span class="font-medium">{{ __('Web:') }}</span>
                                    <a href="{{ $bandSetting->website }}" class="text-sky-700 hover:underline" target="_blank" rel="noopener noreferrer">{{ $bandSetting->website }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    @php
                        $socials = [
                            'urlinstagram' => ['label' => 'Instagram', 'emoji' => '📸'],
                            'urlfacebook' => ['label' => 'Facebook', 'emoji' => '👍'],
                            'urltiktok' => ['label' => 'TikTok', 'emoji' => '🎵'],
                        ];
                    @endphp

                    <div>
                        <p class="mb-2 text-sm text-gray-700 font-semibold">{{ __('Contáctanos en redes') }}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            @php
                                $waNumber = preg_replace('/\D/', '', $bandSetting?->telefono);
                                $waText = urlencode(__('Hola, me gustaría más información sobre vuestra banda.'));
                            @endphp
                            <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}"  target="_blank" rel="noopener noreferrer" class="flex justify-center items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-gray-700 hover:bg-sky-50 hover:border-sky-200 w-full">
                                        <span class="text-lg">🗨</span>
                                        <span>{{ $waNumber }}</span>
                                    </a>
                            @foreach($socials as $field => $meta)
                                @if(!empty($bandSetting?->{$field}))
                                    <a href="{{ $bandSetting->{$field} }}" target="_blank" rel="noopener noreferrer" class="flex justify-center items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-gray-700 hover:bg-sky-50 hover:border-sky-200 w-full">
                                        <span class="text-lg">{{ $meta['emoji'] }}</span>
                                        <span>{{ $meta['label'] }}</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section data-section="soy_banda" class="hidden">
                <div class="mb-4 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-900">
                    <p class="mb-2 font-semibold">{{ __('Te ayudamos a digitalizar la gestion de tu banda, paso a paso y sin lios.') }}</p>
                    <ul class="grid gap-1 text-sm sm:grid-cols-2">
                        <li>{{ __('- Planificacion de actuaciones y calendario') }}</li>
                        <li>{{ __('- Gestion de asistencia y estadisticas') }}</li>
                        <li>{{ __('- Contratos, pagos y control administrativo') }}</li>
                        <li>{{ __('- Herramientas pensadas para directiva y musicos') }}</li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('masinfo.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="interes" value="soy_banda">

                    <div>
                        <label for="nombre_apellidos_info" class="block text-sm font-medium text-gray-700">{{ __('Nombre y apellidos') }}</label>
                        <input id="nombre_apellidos_info" name="nombre_apellidos" type="text" value="{{ old('nombre_apellidos') }}" class="mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                        @error('nombre_apellidos') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="entidad_info" class="block text-sm font-medium text-gray-700">{{ __('Nombre de la banda') }}</label>
                            <input id="entidad_info" name="entidad" type="text" value="{{ old('entidad') }}" class="mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                            @error('entidad') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="municipio_info" class="block text-sm font-medium text-gray-700">{{ __('Municipio') }}</label>
                            <input id="municipio_info" name="municipio" type="text" value="{{ old('municipio') }}" class="mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                            @error('municipio') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="telefono_contacto_info" class="block text-sm font-medium text-gray-700">{{ __('Telefono de contacto') }}</label>
                            <input id="telefono_contacto_info" name="telefono_contacto" type="text" value="{{ old('telefono_contacto') }}" class="mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                            @error('telefono_contacto') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email_contacto_info" class="block text-sm font-medium text-gray-700">{{ __('Correo de contacto') }}</label>
                            <input id="email_contacto_info" name="email_contacto" type="email" value="{{ old('email_contacto') }}" class="mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                            @error('email_contacto') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="mensaje_info" class="block text-sm font-medium text-gray-700">{{ __('Cuentanos brevemente que necesitas') }}</label>
                        <textarea id="mensaje_info" name="mensaje" rows="4" class="mt-1 w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">{{ old('mensaje') }}</textarea>
                        @error('mensaje') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <button type="submit" class="inline-flex items-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-500">
                            {{ __('Quiero mas informacion') }}
                        </button>
                    </div>
                </form>
            </section>

            
        </div>
    </main>

    <footer class="mt-6">
            <div class="mx-auto max-w-4xl px-4 py-6 text-center">
                <a href="https://eband.app/?utm_source=site&utm_medium=footer&utm_campaign=eband_link" aria-label="Visita eBand.app" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-3 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 px-4 py-2 shadow-lg transform transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.333 0-4 1.333-4 4s2.667 4 4 4 4-1.333 4-4-2.667-4-4-4z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                    </svg>
                    <span class="font-semibold text-white">{{ __('Descobreix eBand.app') }}</span>
                    <svg class="h-4 w-4 text-white opacity-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>

                <p class="mt-3 text-xs text-slate-600">
                    {{ __('Gestió i organització de bandes i xarangas. Prova la nostra app per més funcionalitats i gestió fàcil.') }}
                </p>
            </div>
        </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const main = document.querySelector('main[data-initial-interes]');
            if (!main) {
                return;
            }

            const initialInteres = main.getAttribute('data-initial-interes') || '';
            const optionButtons = Array.from(document.querySelectorAll('[data-set-interes]'));
            const sections = {
                soy_banda: document.querySelector('[data-section="soy_banda"]'),
                busco_banda: document.querySelector('[data-section="busco_banda"]'),
            };

            function setInteres(value) {
                Object.entries(sections).forEach(([key, section]) => {
                    if (!section) {
                        return;
                    }
                    if (key === value) {
                        section.classList.remove('hidden');
                    } else {
                        section.classList.add('hidden');
                    }
                });

                optionButtons.forEach((button) => {
                    const isActive = button.getAttribute('data-set-interes') === value;
                    button.classList.toggle('border-sky-500', isActive);
                    button.classList.toggle('bg-sky-50', isActive);
                    button.classList.toggle('text-sky-900', isActive);
                    button.classList.toggle('ring-2', isActive);
                    button.classList.toggle('ring-sky-200', isActive);
                });
            }

            optionButtons.forEach((button) => {
                button.addEventListener('click', function () {
                    setInteres(button.getAttribute('data-set-interes'));
                });
            });

            if (initialInteres === 'soy_banda' || initialInteres === 'busco_banda') {
                setInteres(initialInteres);
            }
        });
    </script>
</body>
</html>
