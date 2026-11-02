<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    
    <!-- Primary Meta Tags -->
    <title>eBand — El software de gestión para Bandas de Música, Xarangas y Corales</title>
    <meta name="title" content="eBand — El software de gestión para Bandas de Música, Xarangas y Corales">
    <meta name="description" content="Plataforma todo en uno para Bandas de Música, Xarangas, Sociedades Musicales y Corales. Control de asistencias (Voy / No voy), archivo digital de partituras, inventario de instrumentos y uniformes, liquidación de bolos y app móvil PWA. Tarifa plana 150€/año.">
    <meta name="keywords" content="software bandas de musica, app banda musica, gestion corales coros orfeones, app charanga xaranga, agrupaciones musicales, control asistencia ensayos, archivo partituras digital, inventario instrumentos uniformes, liquidacion actuaciones bolos, eband, software musical saas">
    <meta name="author" content="eBand">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="eBand — El software de gestión para Bandas de Música, Xarangas y Corales">
    <meta property="og:description" content="La solución todo en uno para Bandas, Xarangas y Corales. Asistencias en tiempo real, archivo digital de partituras, inventario y liquidación de bolos. 150€/año todo incluido.">
    <meta property="og:image" content="{{ asset('logo_e_band.png') }}">
    <meta property="og:site_name" content="eBand">
    <meta property="og:locale" content="es_ES">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="eBand — El software de gestión para Bandas de Música, Xarangas y Corales">
    <meta property="twitter:description" content="Gestiona tu Banda, Xaranga o Coral sin complicaciones: asistencias, archivo de partituras, inventario y liquidaciones.">
    <meta property="twitter:image" content="{{ asset('logo_e_band.png') }}">

    <!-- Mobile & PWA settings -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="eBand">
    <meta name="theme-color" content="#1e40af">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo_e_band.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo_e_band.png') }}">

    <!-- Fonts: Plus Jakarta Sans (Headings) & Inter (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>

    <!-- Structured Data (JSON-LD) for Search Engines -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "SoftwareApplication",
          "name": "eBand",
          "applicationCategory": "BusinessApplication",
          "operatingSystem": "All (Web, iOS, Android, Windows, macOS)",
          "offers": {
            "@@type": "Offer",
            "price": "150.00",
            "priceCurrency": "EUR",
            "priceValidUntil": "2027-12-31",
            "availability": "https://schema.org/InStock",
            "description": "Tarifa plana anual de 150€ con miembros, partituras, actuaciones e inventario ilimitados para agrupaciones musicales."
          },
          "description": "Software especializado en la gestión integral de Bandas de Música, Xarangas, Sociedades Musicales, Corales y Orquestas.",
          "url": "{{ url('/') }}",
          "image": "{{ asset('logo_e_band.png') }}"
        },
        {
          "@@type": "Organization",
          "name": "eBand",
          "url": "{{ url('/') }}",
          "logo": "{{ asset('logo_e_band.png') }}",
          "sameAs": [
            "https://twitter.com/ebandapp"
          ]
        },
        {
          "@@type": "FAQPage",
          "mainEntity": [
            {
              "@@type": "Question",
              "name": "¿Sirve eBand para Corales, Coros y Orfeones además de Bandas?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Sí, totalmente. eBand permite clasificar a los integrantes tanto por instrumentos y cuerdas musicales como por tipos de voz (sopranos, contraltos, tenores, bajos) y compartir partituras corales y audios."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Cómo funciona en teléfonos iPhone y Android?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "eBand está desarrollada como Progressive Web App (PWA). Cada músico puede agregar la app directamente a la pantalla de inicio de su teléfono sin pagar comisiones ni depender de las tiendas de aplicaciones."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Qué incluye la tarifa de 150€ al año?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Es una tarifa plana completa: músicos ilimitados, ensayos y conciertos sin límite, control de asistencia, archivo de partituras en la nube, inventario de trajes e instrumentos, reparto de liquidaciones y soporte continuo."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Cómo acceden los músicos de una banda a su espacio?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Cada agrupación dispone de su propio subdominio privado (ejemplo: tubanda.eband.app) o bien los músicos pueden introducir su código de agrupación en la pantalla de acceso central de eBand."
              }
            }
          ]
        }
      ]
    }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-500 selection:text-white"
      x-data="{ 
          demoModalOpen: {{ $errors->demoAccess->any() ? 'true' : 'false' }}, 
          mobileNav: false,
          activeFaq: null 
      }">

    <!-- ============================================================== -->
    <!-- NAVIGATION BAR                                                 -->
    <!-- ============================================================== -->
    <header class="sticky top-0 z-40 w-full border-b border-slate-200/80 bg-white/90 backdrop-blur-md transition-all">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="group flex items-center gap-3">
                <div class="relative flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-tr from-blue-700 via-indigo-600 to-amber-500 p-0.5 shadow-md shadow-indigo-500/15 transition-transform group-hover:scale-105">
                    <img src="{{ asset('logo_e_band.png') }}" alt="eBand Logo" class="h-full w-full rounded-[10px] object-cover bg-white" width="44" height="44">
                </div>
                <div class="flex flex-col">
                    <span class="font-heading text-2xl font-extrabold tracking-tight text-slate-900">
                        e<span class="text-blue-700">Band</span><span class="text-amber-500">.</span>
                    </span>
                    <span class="text-[10px] font-semibold tracking-wider uppercase text-slate-500">Bandas · Xarangas · Corales</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="#para-quien" class="transition hover:text-blue-700">Para quién</a>
                <a href="#funcionalidades" class="transition hover:text-blue-700">Funcionalidades</a>
                <a href="#galeria" class="transition hover:text-blue-700">Galería</a>
                <a href="#precio" class="transition hover:text-blue-700 flex items-center gap-1.5">
                    <span>Tarifa</span>
                    <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-[11px] font-bold text-amber-800">150€/año</span>
                </a>
                <a href="#faq" class="transition hover:text-blue-700">FAQ</a>
                <a href="#contacto" class="transition hover:text-blue-700">Contacto</a>
            </nav>

            <!-- Navigation Actions -->
            <div class="hidden sm:flex items-center gap-3">
                <a href="{{ Route::has('tenant-access.index') ? route('tenant-access.index') : (Route::has('login') ? route('login') : url('/acceso')) }}" 
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-blue-700 hover:border-slate-300">
                    Acceso a mi banda
                </a>
                <button type="button" 
                        @click="demoModalOpen = true"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-700 to-indigo-600 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-700/20 transition hover:from-blue-800 hover:to-indigo-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    <span>Probar Demo</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center md:hidden">
                <button type="button" 
                        @click="mobileNav = !mobileNav"
                        class="inline-flex items-center justify-center rounded-lg p-2 text-slate-600 hover:bg-slate-100 focus:outline-none"
                        aria-label="Abrir menú de navegación">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileNav" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileNav" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Nav Menu -->
        <div x-show="mobileNav" 
             x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="border-b border-slate-200 bg-white px-4 pt-2 pb-6 md:hidden">
            <nav class="flex flex-col space-y-3 text-base font-medium text-slate-700">
                <a href="#para-quien" @click="mobileNav = false" class="py-2 hover:text-blue-700">Para quién</a>
                <a href="#funcionalidades" @click="mobileNav = false" class="py-2 hover:text-blue-700">Funcionalidades</a>
                <a href="#galeria" @click="mobileNav = false" class="py-2 hover:text-blue-700">Galería del software</a>
                <a href="#precio" @click="mobileNav = false" class="py-2 flex items-center justify-between hover:text-blue-700">
                    <span>Tarifa anual</span>
                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-800">150€/año</span>
                </a>
                <a href="#faq" @click="mobileNav = false" class="py-2 hover:text-blue-700">Preguntas Frecuentes</a>
                <a href="#contacto" @click="mobileNav = false" class="py-2 hover:text-blue-700">Contacto</a>
                <div class="pt-4 flex flex-col gap-2">
                    <a href="{{ Route::has('tenant-access.index') ? route('tenant-access.index') : (Route::has('login') ? route('login') : url('/acceso')) }}" class="w-full text-center rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-slate-700">
                        Acceso a mi banda
                    </a>
                    <button type="button" @click="mobileNav = false; demoModalOpen = true" class="w-full text-center rounded-xl bg-blue-700 py-2.5 text-sm font-bold text-white shadow-md">
                        Probar Demo Inmediata
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <!-- ============================================================== -->
        <!-- HERO SECTION                                                   -->
        <!-- ============================================================== -->
        <section class="relative overflow-hidden pt-12 pb-20 sm:pt-16 sm:pb-28">
            <!-- Ambient Glow Backgrounds -->
            <div class="pointer-events-none absolute -top-40 left-1/2 -z-10 h-[580px] w-[800px] -translate-x-1/2 rounded-full bg-gradient-to-br from-blue-400/20 via-indigo-300/20 to-amber-200/20 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute top-1/2 -right-40 -z-10 h-96 w-96 rounded-full bg-amber-400/10 blur-2xl" aria-hidden="true"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Badge Pill -->
                <div class="flex justify-center">
                    <div class="inline-flex items-center gap-2 rounded-full border border-blue-200/80 bg-blue-50/80 px-4 py-1.5 text-xs font-semibold text-blue-900 shadow-sm backdrop-blur-sm">
                        <span class="flex h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>Plataforma especializada para agrupaciones musicales</span>
                        <span class="text-blue-300">|</span>
                        <span class="text-blue-700 font-bold">Versión 3.0</span>
                    </div>
                </div>

                <!-- Hero Heading & Copy -->
                <div class="mt-8 text-center max-w-4xl mx-auto">
                    <h1 class="font-heading text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl sm:leading-tight lg:leading-[1.12]">
                        El software integral para tu <br class="hidden sm:inline">
                        <span class="bg-gradient-to-r from-blue-700 via-indigo-600 to-amber-600 bg-clip-text text-transparent">
                            Banda de Música, Xaranga o Coral
                        </span>
                    </h1>
                    <p class="mt-6 text-lg sm:text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed font-normal">
                        Pon fin al caos de los grupos de WhatsApp, las partituras perdidas y la incertidumbre de saber quién vendrá al próximo ensayo o concierto. eBand reúne asistencias, repertorio, bolos, contratos e inventario en una única app que todos tus músicos sabrán usar.
                    </p>

                    <!-- CTAs -->
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button type="button" 
                                @click="demoModalOpen = true"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-blue-700 to-indigo-600 px-8 py-4 text-base font-bold text-white shadow-xl shadow-blue-700/25 transition-all hover:scale-[1.02] hover:shadow-2xl hover:from-blue-800 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                            <span>Probar Demo Gratis</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                        <a href="#funcionalidades" 
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-7 py-4 text-base font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900 hover:border-slate-400">
                            <span>Ver cómo funciona</span>
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                    </div>

                    <!-- Trust Bar Indicators -->
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-xs sm:text-sm font-medium text-slate-500">
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Músicos y socios ilimitados</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>App móvil PWA (iOS y Android)</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Tarifa plana 150 € / año</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Sin permanencia</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Software Mockup Card -->
                <div class="mt-14 sm:mt-20 relative mx-auto max-w-6xl">
                    <div class="relative rounded-2xl border border-slate-200/90 bg-white p-2 sm:p-3 shadow-2xl shadow-indigo-900/10">
                        <!-- Browser Bar Simulation -->
                        <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3 bg-slate-50/70 rounded-t-xl">
                            <div class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-rose-400"></span>
                                <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                                <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                            </div>
                            <div class="flex items-center gap-2 rounded-lg bg-white px-4 py-1 text-xs font-medium text-slate-500 border border-slate-200 shadow-xs">
                                <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>https://tubanda.eband.app</span>
                            </div>
                            <div class="text-xs font-semibold text-slate-400">Panel Directiva</div>
                        </div>

                        <!-- Screenshot Image -->
                        <div class="overflow-hidden rounded-b-xl bg-slate-100">
                            <img src="{{ asset('galeria/tablero_resumen.png') }}" 
                                 alt="Panel de control eBand - Gestión de actuaciones, asistencias y repertorio" 
                                 class="w-full h-auto object-cover object-top max-h-[640px]"
                                 loading="eager" 
                                 width="1280" 
                                 height="720">
                        </div>

                        <!-- Floating Micro-Badges -->
                        <div class="absolute -top-4 -left-4 sm:top-8 sm:-left-6 hidden md:flex items-center gap-3 rounded-2xl border border-slate-200 bg-white/95 p-3.5 shadow-xl backdrop-blur-md">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-900">Asistencia confirmada</div>
                                <div class="text-[11px] text-slate-500">42 músicos listos para el ensayo</div>
                            </div>
                        </div>

                        <div class="absolute -bottom-4 -right-4 sm:bottom-10 sm:-right-6 hidden md:flex items-center gap-3 rounded-2xl border border-slate-200 bg-white/95 p-3.5 shadow-xl backdrop-blur-md">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-900">Repertorio sincronizado</div>
                                <div class="text-[11px] text-slate-500">Partituras en PDF por instrumento</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================================== -->
        <!-- TARGET GROUPS / PARA QUIÉN                                     -->
        <!-- ============================================================== -->
        <section id="para-quien" class="py-20 bg-white border-t border-b border-slate-200/80">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <span class="inline-block rounded-full bg-blue-100 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-blue-800">
                        Adaptado a tu agrupación
                    </span>
                    <h2 class="mt-4 font-heading text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                        Diseñado para la realidad diaria de tu colectivo musical
                    </h2>
                    <p class="mt-4 text-base sm:text-lg text-slate-600">
                        Cada conjunto musical tiene sus propias dinámicas. eBand se adapta tanto si sois una gran banda sinfónica, una charanga de fiesta o un coro vocal.
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- 1. Bandas de Música -->
                    <div class="group relative flex flex-col justify-between rounded-2xl border border-slate-200 bg-slate-50/50 p-8 shadow-xs transition hover:border-blue-400 hover:bg-white hover:shadow-xl">
                        <div>
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-700 transition group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                                </svg>
                            </div>
                            <h3 class="mt-6 font-heading text-xl font-bold text-slate-900">Bandas y Sociedades Musicales</h3>
                            <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                                Control exhaustivo de ensayos generales y parciales por cuerda (maderas, metales, percusión). Generación automática de contratos municipales y gestión del archivo histórico.
                            </p>
                            <ul class="mt-6 space-y-2.5 text-xs text-slate-700">
                                <li class="flex items-center gap-2">
                                    <span class="text-blue-600 font-bold">✓</span> Asistencias con avisos "Voy / No voy"
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-blue-600 font-bold">✓</span> Inventario de uniformes y préstamo de instrumental
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-blue-600 font-bold">✓</span> Control de músicos invitados y forasteros
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-blue-600 font-bold">✓</span> Programas de concierto públicos con código QR
                                </li>
                            </ul>
                        </div>
                        <div class="mt-8 pt-4 border-t border-slate-200/60">
                            <span class="text-xs font-semibold text-blue-700 flex items-center gap-1">
                                Ideal para bandas sinfónicas y patronales &rarr;
                            </span>
                        </div>
                    </div>

                    <!-- 2. Xarangas y Charangas -->
                    <div class="group relative flex flex-col justify-between rounded-2xl border-2 border-amber-300/80 bg-gradient-to-b from-amber-50/40 to-white p-8 shadow-md transition hover:border-amber-500 hover:shadow-2xl">
                        <div class="absolute -top-3.5 right-6">
                            <span class="rounded-full bg-gradient-to-r from-amber-500 to-amber-600 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-white shadow-sm">
                                Máxima Agilidad
                            </span>
                        </div>
                        <div>
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-amber-700 transition group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="mt-6 font-heading text-xl font-bold text-slate-900">Xarangas y Charangas</h3>
                            <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                                Respuestas inmediatas para cerrar la plantilla de cada bolo en un clic. Reparto de honorarios por bolo con liquidaciones transparentes para cada miembro.
                            </p>
                            <ul class="mt-6 space-y-2.5 text-xs text-slate-700">
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-600 font-bold">✓</span> Confirmación ultra-rápida desde el móvil
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-600 font-bold">✓</span> Liquidación y cálculo de cobro por actuación
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-600 font-bold">✓</span> Ubicaciones GPS de pasacalles y puntos de encuentro
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-600 font-bold">✓</span> Repertorio de bolos disponible offline
                                </li>
                            </ul>
                        </div>
                        <div class="mt-8 pt-4 border-t border-amber-200/60">
                            <span class="text-xs font-semibold text-amber-700 flex items-center gap-1">
                                Para grupos festivos y de animación &rarr;
                            </span>
                        </div>
                    </div>

                    <!-- 3. Corales, Coros y Orfeones -->
                    <div class="group relative flex flex-col justify-between rounded-2xl border border-slate-200 bg-slate-50/50 p-8 shadow-xs transition hover:border-indigo-400 hover:bg-white hover:shadow-xl">
                        <div>
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700 transition group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                            </div>
                            <h3 class="mt-6 font-heading text-xl font-bold text-slate-900">Corales, Coros y Orfeones</h3>
                            <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                                Organización específica por cuerdas vocales (sopranos, contraltos, tenores y bajos). Archivo de partituras corales y convocatorias claras a encuentros y misas.
                            </p>
                            <ul class="mt-6 space-y-2.5 text-xs text-slate-700">
                                <li class="flex items-center gap-2">
                                    <span class="text-indigo-600 font-bold">✓</span> Segmentación por cuerdas de voz
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-indigo-600 font-bold">✓</span> Partituras y pistas de ensayo en la nube
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-indigo-600 font-bold">✓</span> Asistencia a ensayos semanales y conciertos
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-indigo-600 font-bold">✓</span> Tablón de avisos y cambios de última hora
                                </li>
                            </ul>
                        </div>
                        <div class="mt-8 pt-4 border-t border-slate-200/60">
                            <span class="text-xs font-semibold text-indigo-700 flex items-center gap-1">
                                Para coros polifónicos, de cámara y orfeones &rarr;
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================================== -->
        <!-- CORE FEATURES GRID                                             -->
        <!-- ============================================================== -->
        <section id="funcionalidades" class="py-24 bg-slate-50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <span class="inline-block rounded-full bg-indigo-100 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-indigo-800">
                        Funcionalidades Destacadas
                    </span>
                    <h2 class="mt-4 font-heading text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                        Todo lo que tu directiva y tus músicos necesitan
                    </h2>
                    <p class="mt-4 text-base sm:text-lg text-slate-600">
                        Olvídate de hojas de Excel desactualizadas y notas dispersas. Gestiona tu día a día con herramientas diseñadas exactamente para música en grupo.
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1: Asistencias -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <h3 class="mt-5 font-heading text-lg font-bold text-slate-900">Control de Asistencia ("Voy / No voy")</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Los músicos confirman su asistencia con un toque desde su teléfono. Los directores ven la plantilla en tiempo real clasificada por instrumento o cuerda vocal.
                        </p>
                    </div>

                    <!-- Feature 2: Partituras -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="mt-5 font-heading text-lg font-bold text-slate-900">Archivo de Partituras Digital</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Organiza el repertorio por obras, carpetas y papeles individuales en PDF. Cada músico descarga únicamente las partituras que le corresponden.
                        </p>
                    </div>

                    <!-- Feature 3: Actuaciones y Bolos -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="mt-5 font-heading text-lg font-bold text-slate-900">Actuaciones, Pasacalles y Bolos</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Detalla horario de citación, salida de autobús o furgoneta, uniforme oficial, ubicación GPS exacta y programa de piezas a interpretar.
                        </p>
                    </div>

                    <!-- Feature 4: Inventario -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="mt-5 font-heading text-lg font-bold text-slate-900">Inventario de Trajes e Instrumentos</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Trazabilidad de instrumentos cedidos, chaquetas, corbatas, polos y accesorios con número de serie y registro de entrega firmado.
                        </p>
                    </div>

                    <!-- Feature 5: Liquidaciones -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-5 font-heading text-lg font-bold text-slate-900">Liquidaciones y Pagos Transparentes</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Calcula el reparto económico por actuación, gestiona los pagos a refuerzos o colaboradores externos y genera resúmenes contables en PDF.
                        </p>
                    </div>

                    <!-- Feature 6: PWA Móvil -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="mt-5 font-heading text-lg font-bold text-slate-900">App Móvil PWA para iOS y Android</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Sin necesidad de descargar nada desde tiendas lentas. Los integrantes guardan eBand como icono en su pantalla de inicio y tienen acceso al instante.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================================== -->
        <!-- SCREENSHOT SHOWCASE / GALERÍA                                  -->
        <!-- ============================================================== -->
        <section id="galeria" class="py-24 bg-white border-t border-slate-200/80">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <span class="inline-block rounded-full bg-amber-100 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-amber-800">
                        Capturas Reales
                    </span>
                    <h2 class="mt-4 font-heading text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                        Una interfaz clara que cualquiera sabe utilizar
                    </h2>
                    <p class="mt-4 text-base sm:text-lg text-slate-600">
                        Explora las diferentes pantallas de eBand: pensadas tanto para directivos como para músicos de todas las edades.
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Gallery Card 1 -->
                    <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition hover:shadow-xl hover:border-slate-300">
                        <div class="overflow-hidden bg-slate-200">
                            <img src="{{ asset('galeria/detalle_actuacion.png') }}" 
                                 alt="Ficha de detalle de actuación y asistencias" 
                                 class="h-56 w-full object-cover object-top transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        </div>
                        <div class="p-5">
                            <h4 class="font-heading font-bold text-slate-900">Detalle de Actuación y Bolos</h4>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                Mapa de ubicación, horarios de viaje, uniforme y panel de asistencia de cada músico.
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Card 2 -->
                    <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition hover:shadow-xl hover:border-slate-300">
                        <div class="overflow-hidden bg-slate-200">
                            <img src="{{ asset('galeria/calendario.png') }}" 
                                 alt="Calendario mensual de citas, ensayos y actuaciones" 
                                 class="h-56 w-full object-cover object-top transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        </div>
                        <div class="p-5">
                            <h4 class="font-heading font-bold text-slate-900">Calendario Visual de Ensayos</h4>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                Vista global del mes para evitar solapamientos y planificar convocatorias con antelación.
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Card 3 -->
                    <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition hover:shadow-xl hover:border-slate-300">
                        <div class="overflow-hidden bg-slate-200">
                            <img src="{{ asset('galeria/inventario.png') }}" 
                                 alt="Gestión de inventario de instrumentos y uniformes" 
                                 class="h-56 w-full object-cover object-top transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        </div>
                        <div class="p-5">
                            <h4 class="font-heading font-bold text-slate-900">Control de Inventario</h4>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                Registro de instrumentos propiedad de la asociación y qué músico tiene asignado cada uno.
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Card 4 -->
                    <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition hover:shadow-xl hover:border-slate-300">
                        <div class="overflow-hidden bg-slate-200">
                            <img src="{{ asset('galeria/resumen_actuaciones.png') }}" 
                                 alt="Historial y estadísticas de actuaciones" 
                                 class="h-56 w-full object-cover object-top transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        </div>
                        <div class="p-5">
                            <h4 class="font-heading font-bold text-slate-900">Historial y Estadísticas</h4>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                Métricas de compromisos anuales, porcentaje de asistencia y balances económicos.
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Card 5 -->
                    <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition hover:shadow-xl hover:border-slate-300">
                        <div class="overflow-hidden bg-slate-200">
                            <img src="{{ asset('galeria/anuncios.png') }}" 
                                 alt="Tablón de anuncios y avisos directos a la agrupación" 
                                 class="h-56 w-full object-cover object-top transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        </div>
                        <div class="p-5">
                            <h4 class="font-heading font-bold text-slate-900">Tablón de Anuncios</h4>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                Comunicados oficiales visibles para todos los socios al iniciar sesión en su app.
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Card 6 -->
                    <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition hover:shadow-xl hover:border-slate-300">
                        <div class="overflow-hidden bg-slate-200">
                            <img src="{{ asset('galeria/sugerencias.png') }}" 
                                 alt="Buzón de sugerencias para músicos y socios" 
                                 class="h-56 w-full object-cover object-top transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        </div>
                        <div class="p-5">
                            <h4 class="font-heading font-bold text-slate-900">Buzón de Sugerencias</h4>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                Canal participativo para escuchar propuestas, peticiones de repertorio y mejoras de los miembros.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================================== -->
        <!-- PRICING SECTION (150€/AÑO)                                      -->
        <!-- ============================================================== -->
        <section id="precio" class="py-24 bg-gradient-to-b from-slate-50 to-white relative overflow-hidden">
            <!-- Glow background -->
            <div class="pointer-events-none absolute top-1/2 left-1/2 -z-10 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-amber-400/10 blur-3xl" aria-hidden="true"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <span class="inline-block rounded-full bg-emerald-100 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-emerald-800">
                        Tarifa Única y Transparente
                    </span>
                    <h2 class="mt-4 font-heading text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                        Un único precio sin letra pequeña ni límites
                    </h2>
                    <p class="mt-4 text-base sm:text-lg text-slate-600">
                        Creemos en precios justos para la cultura y el asociacionismo musical. Sin costes por número de músicos ni módulos ocultos.
                    </p>
                </div>

                <div class="mt-16 max-w-xl mx-auto">
                    <div class="relative rounded-3xl border-2 border-blue-600 bg-white p-8 sm:p-10 shadow-2xl shadow-blue-700/10">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-blue-700 to-indigo-600 px-4 py-1 text-xs font-extrabold uppercase tracking-wide text-white shadow-md">
                                ★ Tarifa Plana para Toda la Agrupación
                            </span>
                        </div>

                        <div class="text-center pt-2">
                            <h3 class="font-heading text-2xl font-extrabold text-slate-900">Plan Completo eBand</h3>
                            <p class="mt-2 text-sm text-slate-600">
                                Para Bandas de Música, Xarangas, Sociedades Musicales y Corales.
                            </p>

                            <div class="mt-6 flex items-baseline justify-center gap-2">
                                <span class="font-heading text-5xl sm:text-6xl font-extrabold tracking-tight text-slate-900">150€</span>
                                <span class="text-base font-semibold text-slate-500">/ año</span>
                            </div>
                            <p class="mt-1 text-xs font-medium text-slate-500">Sin sorpresas ni permanencias obligatorias</p>
                        </div>

                        <!-- Included Features List -->
                        <div class="mt-8 border-t border-slate-200 pt-8">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Todo incluido sin límites:</h4>
                            <ul class="mt-4 space-y-3.5 text-sm text-slate-700">
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Músicos y socios ilimitados:</strong> da de alta a toda tu plantilla sin sobrecostes.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Ensayos, conciertos y bolos ilimitados:</strong> agenda y convoca todo el año.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Archivo musical en la nube:</strong> sube partituras en PDF organizadas por papeles e instrumentos.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Inventario de trajes e instrumental:</strong> controla el material de la agrupación y las asignaciones.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Liquidaciones económicas por bolo:</strong> cálculo y reparto automático de pagos.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>App Móvil PWA para cada músico:</strong> lista para instalar en iPhone y Android.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Subdominio propio:</strong> accede con tu dirección privada <code>tubanda.eband.app</code>.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Soporte técnico cercano y copias de seguridad:</strong> te ayudamos en la puesta en marcha.</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex flex-col gap-3">
                            <button type="button" 
                                    @click="demoModalOpen = true"
                                    class="w-full rounded-xl bg-blue-700 py-4 text-center text-sm font-bold text-white shadow-lg shadow-blue-700/25 transition hover:bg-blue-800">
                                Probar Demo Inmediata Gratis
                            </button>
                            <a href="#contacto" 
                               class="w-full rounded-xl border border-slate-300 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                Solicitar Alta o Preguntar Dudas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================================== -->
        <!-- FAQ SECTION (ACCORDION WITH ALPINE)                            -->
        <!-- ============================================================== -->
        <section id="faq" class="py-24 bg-white border-t border-slate-200/80">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <span class="inline-block rounded-full bg-slate-100 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-slate-800">
                        Resolvemos tus Dudas
                    </span>
                    <h2 class="mt-4 font-heading text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                        Preguntas Frecuentes
                    </h2>
                    <p class="mt-4 text-base sm:text-lg text-slate-600">
                        Todo lo que necesitas saber antes de dar el paso con tu agrupación.
                    </p>
                </div>

                <div class="mt-14 space-y-4">
                    <!-- FAQ 1 -->
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-6 transition">
                        <button type="button" 
                                class="flex w-full items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none"
                                @click="activeFaq = (activeFaq === 1 ? null : 1)">
                            <span>¿eBand es compatible con Corales y Coros además de Bandas?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs">
                                <svg class="h-4 w-4 transform transition-transform" :class="activeFaq === 1 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="activeFaq === 1" x-cloak x-collapse class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            Absolutamente. Puedes clasificar a los integrantes tanto por instrumentos (en el caso de bandas y agrupaciones instrumentales) como por <strong>cuerdas vocales (sopranos, contraltos, tenores y bajos)</strong> en coros y agrupaciones vocales. Las partituras y las convocatorias de asistencia se filtran según la voz correspondiente de cada corista.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-6 transition">
                        <button type="button" 
                                class="flex w-full items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none"
                                @click="activeFaq = (activeFaq === 2 ? null : 2)">
                            <span>¿Cómo se instala en iPhone y teléfonos Android?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs">
                                <svg class="h-4 w-4 transform transition-transform" :class="activeFaq === 2 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="activeFaq === 2" x-cloak x-collapse class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            eBand funciona como una <strong>Progressive Web App (PWA)</strong>. No requiere pasar por la App Store ni Google Play. Al abrir el enlace de tu banda en el navegador del móvil, un aviso te permite pulsar <em>"Añadir a pantalla de inicio"</em> (en Safari de iOS o Chrome de Android). Se creará un icono idéntico a una app nativa, con navegación a pantalla completa y funcionamiento fluido sin ocupar almacenamiento innecesario.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-6 transition">
                        <button type="button" 
                                class="flex w-full items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none"
                                @click="activeFaq = (activeFaq === 3 ? null : 3)">
                            <span>¿Qué incluye exactamente la tarifa plana de 150€/año?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs">
                                <svg class="h-4 w-4 transform transition-transform" :class="activeFaq === 3 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="activeFaq === 3" x-cloak x-collapse class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            Incluye el 100% de la plataforma: músicos ilimitados, actuaciones y ensayos sin límite, repositorio de partituras, inventario de trajes e instrumental, módulo de liquidación económica por bolo, soporte por email o WhatsApp, copias de seguridad automáticas y todas las actualizaciones que vayamos publicando.
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-6 transition">
                        <button type="button" 
                                class="flex w-full items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none"
                                @click="activeFaq = (activeFaq === 4 ? null : 4)">
                            <span>¿Cómo acceden los músicos a su espacio privado?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs">
                                <svg class="h-4 w-4 transform transition-transform" :class="activeFaq === 4 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="activeFaq === 4" x-cloak x-collapse class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            Tu agrupación dispone de una dirección web propia (por ejemplo <code>tubanda.eband.app</code>). Además, desde la página principal de <code>eband.app</code> en el botón <em>"Acceso a mi banda"</em>, los integrantes pueden introducir su código único y serán redirigidos a su espacio privado inmediatamente.
                        </div>
                    </div>

                    <!-- FAQ 5 -->
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-6 transition">
                        <button type="button" 
                                class="flex w-full items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none"
                                @click="activeFaq = (activeFaq === 5 ? null : 5)">
                            <span>¿Puedo probar la herramienta antes de contratar?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs">
                                <svg class="h-4 w-4 transform transition-transform" :class="activeFaq === 5 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="activeFaq === 5" x-cloak x-collapse class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            Sí. Puedes acceder a nuestra demo interactiva en cualquier momento pulsando el botón <strong>"Probar Demo"</strong>. Podrás explorar el panel de administración, ver cómo se configuran las actuaciones y experimentar la facilidad de uso.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================================== -->
        <!-- CONTACT & LEAD CAPTURE SECTION                                 -->
        <!-- ============================================================== -->
        <section id="contacto" class="py-24 bg-slate-50 border-t border-slate-200/80">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 items-start">
                    <!-- Left: Contact Copy & Benefits -->
                    <div>
                        <span class="inline-block rounded-full bg-blue-100 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-blue-800">
                            Hablemos
                        </span>
                        <h2 class="mt-4 font-heading text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                            ¿Hablamos de cómo organizar tu agrupación?
                        </h2>
                        <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
                            Cuéntanos cómo os organizáis ahora mismo (si usáis grupos de WhatsApp, hojas de cálculo o papeles sueltos) y te explicamos cómo eBand puede ahorraros horas de trabajo desde la primera semana.
                        </p>

                        <div class="mt-8 space-y-4">
                            <div class="flex items-start gap-3.5">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Respuesta rápida</h4>
                                    <p class="text-xs text-slate-600">Te contestamos en menos de 24 horas laborables con una respuesta clara y directa.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Asesoramiento personalizado</h4>
                                    <p class="text-xs text-slate-600">Revisamos tu caso: banda con escuela, xaranga con bolos o coro polifónico.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3.5">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Sin compromiso alguno</h4>
                                    <p class="text-xs text-slate-600">Pruébalo con tu junta directiva o tus compañeros y decidid con total tranquilidad.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Contact Form -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-200/50">
                        @if(session('success'))
                            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                                <div class="flex items-center gap-2 font-bold">
                                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    ¡Mensaje recibido con éxito!
                                </div>
                                <p class="mt-1 text-xs text-emerald-700">{{ session('success') }}</p>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="nombre" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Tu Nombre *</label>
                                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                                           placeholder="Ej: Laura Martínez"
                                           class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                                    @error('nombre')
                                        <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="banda" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Nombre de la Agrupación *</label>
                                    <input type="text" id="banda" name="banda" value="{{ old('banda') }}" required
                                           placeholder="Banda, Xaranga o Coral..."
                                           class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                                    @error('banda')
                                        <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Correo Electrónico *</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                           placeholder="directiva@tubanda.es"
                                           class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                                    @error('email')
                                        <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="telefono" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Teléfono (opcional)</label>
                                    <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}"
                                           placeholder="+34 600 000 000"
                                           class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                                    @error('telefono')
                                        <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="informacion" class="block text-xs font-bold uppercase tracking-wider text-slate-700">¿Qué os gustaría organizar o mejorar? *</label>
                                <textarea id="informacion" name="informacion" rows="4" required
                                          placeholder="Cuéntanos cuántos integrantes sois, cómo gestionáis ahora los ensayos o cualquier duda que tengáis..."
                                          class="mt-1 block w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">{{ old('informacion') }}</textarea>
                                @error('informacion')
                                    <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- NoCaptcha Display -->
                            <div class="pt-2">
                                {!! NoCaptcha::display() !!}
                                @error('g-recaptcha-response')
                                    <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" 
                                    class="w-full rounded-xl bg-gradient-to-r from-blue-700 to-indigo-600 py-3.5 text-center text-sm font-bold text-white shadow-md shadow-blue-700/20 transition hover:from-blue-800 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                                Enviar Consulta
                            </button>
                            <p class="text-[11px] text-center text-slate-500">
                                Respetamos tu privacidad. Tus datos solo se utilizarán para responder a esta solicitud.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ============================================================== -->
    <!-- DEMO ACCESS MODAL (ALPINE.JS)                                  -->
    <!-- ============================================================== -->
    <div x-show="demoModalOpen" 
         x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog" 
         aria-modal="true">
        <!-- Backdrop -->
        <div x-show="demoModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="demoModalOpen = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <!-- Modal Card -->
        <div x-show="demoModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-lg rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-2xl transition-all z-10">
            
            <button type="button" 
                    @click="demoModalOpen = false" 
                    class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-heading text-xl font-bold text-slate-900">Acceso Inmediato a la Demo</h3>
                    <p class="text-xs text-slate-500">Prueba todas las funcionalidades sin esperas</p>
                </div>
            </div>

            @if($errors->demoAccess->any())
                <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 p-3 text-xs text-rose-700">
                    {{ $errors->demoAccess->first() }}
                </div>
            @endif

            <form action="{{ route('demo.access') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="demo_nombre" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Nombre *</label>
                        <input type="text" id="demo_nombre" name="nombre" required value="{{ old('nombre') }}"
                               placeholder="Tu nombre"
                               class="mt-1 block w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>
                    <div>
                        <label for="demo_apellidos" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Apellidos *</label>
                        <input type="text" id="demo_apellidos" name="apellidos" required value="{{ old('apellidos') }}"
                               placeholder="Tus apellidos"
                               class="mt-1 block w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    </div>
                </div>

                <div>
                    <label for="demo_email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Email *</label>
                    <input type="email" id="demo_email" name="email" required value="{{ old('email') }}"
                           placeholder="tu@email.com"
                           class="mt-1 block w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                </div>

                <div class="pt-2">
                    {!! NoCaptcha::display() !!}
                </div>

                <button type="submit" 
                        class="w-full rounded-xl bg-blue-700 py-3.5 text-sm font-bold text-white shadow-md shadow-blue-700/25 transition hover:bg-blue-800">
                    Entrar a la Demo Ahora
                </button>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- FOOTER                                                         -->
    <!-- ============================================================== -->
    <footer class="border-t border-slate-200 bg-white py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo_e_band.png') }}" alt="eBand Logo" class="h-8 w-8 rounded-lg object-cover" width="32" height="32">
                    <div>
                        <div class="font-heading text-lg font-extrabold text-slate-900">
                            e<span class="text-blue-700">Band</span><span class="text-amber-500">.</span>
                        </div>
                        <p class="text-xs text-slate-500">
                            &copy; {{ date('Y') }} eBand. El software para Bandas de Música, Xarangas y Corales.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-6 text-xs font-medium text-slate-600">
                    <a href="{{ Route::has('tenant-access.index') ? route('tenant-access.index') : (Route::has('login') ? route('login') : url('/acceso')) }}" class="hover:text-blue-700">Acceso a mi banda</a>
                    <a href="#para-quien" class="hover:text-blue-700">Para quién</a>
                    <a href="#funcionalidades" class="hover:text-blue-700">Funcionalidades</a>
                    <a href="#precio" class="hover:text-blue-700">Tarifa 150€</a>
                    <a href="#faq" class="hover:text-blue-700">Preguntas Frecuentes</a>
                    <a href="#contacto" class="hover:text-blue-700">Contacto</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Render reCAPTCHA Script -->
    {!! NoCaptcha::renderJs() !!}
</body>
</html>