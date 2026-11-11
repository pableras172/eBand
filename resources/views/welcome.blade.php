<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    
    <!-- Primary Meta Tags -->
    <title>eBand · Software y App de Gestión para Bandas de Música, Coros y Agrupaciones Musicales</title>
    <meta name="title" content="eBand · Software y App de Gestión para Bandas de Música, Coros y Agrupaciones Musicales">
    <meta name="description" content="eBand es la plataforma y app móvil de gestión para Bandas de Música, Charangas, Sociedades Musicales y Corales. Control de asistencia y disponibilidad a ensayos, inventario de uniformes y material, control parental, actividades extra y liquidaciones de bolos. Tarifa plana 150€/año sin límites.">
    <meta name="keywords" content="software gestion banda de musica, app gestion bandas musicales, plataforma gestion bandas, aplicacion gestion bandas, software bandas de musica, software gestion orquestas, app agrupaciones musicales, gestion coros corales orfeones, app charanga, control asistencia ensayos banda, control parental banda musica, inventario uniformes banda, liquidacion bolos, eband, software musical saas">
    <meta name="author" content="eBand">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="eBand · Software y App de Gestión para Bandas de Música, Coros y Charangas">
    <meta property="og:description" content="Plataforma y app de gestión integral para Bandas de Música, Charangas y Corales. Control de disponibilidad en tiempo real, control parental, actividades con confirmación Sí/No, inventario y liquidaciones. Tarifa plana 150€/año.">
    <meta property="og:image" content="{{ asset('logo_e_band.png') }}">
    <meta property="og:site_name" content="eBand">
    <meta property="og:locale" content="es_ES">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="eBand · Software y App de Gestión para Bandas de Música, Coros y Charangas">
    <meta property="twitter:description" content="Gestiona tu Banda, Charanga o Coral sin complicaciones: asistencia en tiempo real, control parental, inventario de uniformes, actividades y reparto de bolos.">
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
            "description": "Tarifa plana anual de 150€ con miembros, actuaciones, actividades extra, control parental e inventario ilimitados para agrupaciones musicales."
          },
          "description": "Software especializado en la gestión integral de Bandas de Música, Charangas, Sociedades Musicales y Corales.",
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
              "name": "¿Sirve eBand para Corales y Coros además de Bandas?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Sí, totalmente. eBand permite clasificar a los integrantes tanto por instrumentos y cuerdas musicales como por tipos de voz (sopranos, contraltos, tenores, bajos) y gestionar convocatorias, asistencias y actividades."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Cómo funciona el Control Parental para familias con menores?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Los padres o tutores disponen de una vista unificada desde su propio usuario donde pueden ver las convocatorias, ensayos, uniformes y actividades de sus hijos menores, e inscribirlos directamente."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Por qué utilizar eBand en lugar de hojas de cálculo de Excel o grupos de WhatsApp?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Llevar una banda, charanga o coro con Excel y grupos de WhatsApp genera mensajes perdidos, falta de respuestas a última hora y decenas de versiones de la misma lista. eBand centraliza y automatiza todo en una plataforma común para Android, iOS y Escritorio: cada músico marca su disponibilidad con un solo clic, la directiva ve la plantilla confirmada en tiempo real, las familias gestionan a sus hijos con control parental, y todo con una tarifa plana de 150€/año con miembros ilimitados."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Cómo funciona en teléfonos iPhone, Android y ordenadores?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "eBand es 100% multiplataforma: funciona tanto en escritorio (ordenadores PC y Mac) a través de cualquier navegador web, como en teléfonos móviles iPhone y Android (como PWA y próximamente con apps nativas en App Store y Google Play)."
              }
            },
            {
              "@@type": "Question",
              "name": "¿Qué incluye la tarifa de 150€ al año?",
              "acceptedAnswer": {
                "@@type": "Answer",
                "text": "Es una tarifa plana completa: músicos ilimitados, ensayos y conciertos sin límite, control de disponibilidad (Disponible / No disponible), inventario de trajes y material, control parental, actividades extra, liquidaciones de bolos y soporte continuo."
              }
            }
          ]
        }
      ]
    }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-500 selection:text-white">

    <!-- ============================================================== -->
    <!-- NAVIGATION BAR                                                 -->
    <!-- ============================================================== -->
    <header class="sticky top-0 z-40 w-full border-b border-slate-200/80 bg-white/90 backdrop-blur-md transition-all pt-safe">
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
                    <span class="text-[10px] font-semibold tracking-wider uppercase text-slate-500">Bandas · Charangas · Corales</span>
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
                        data-demo-trigger
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
                        id="mobile-nav-toggle"
                        class="inline-flex items-center justify-center rounded-lg p-2 text-slate-600 hover:bg-slate-100 focus:outline-none"
                        aria-label="Abrir menú de navegación">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Nav Menu -->
        <div id="mobile-nav-menu"
             class="hidden border-b border-slate-200 bg-white px-4 pt-2 pb-6 md:hidden">
            <nav class="flex flex-col space-y-3 text-base font-medium text-slate-700">
                <a href="#para-quien" class="py-2 hover:text-blue-700">Para quién</a>
                <a href="#funcionalidades" class="py-2 hover:text-blue-700">Funcionalidades</a>
                <a href="#galeria" class="py-2 hover:text-blue-700">Galería del software</a>
                <a href="#precio" class="py-2 flex items-center justify-between hover:text-blue-700">
                    <span>Tarifa anual</span>
                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-800">150€/año</span>
                </a>
                <a href="#faq" class="py-2 hover:text-blue-700">Preguntas Frecuentes</a>
                <a href="#contacto" class="py-2 hover:text-blue-700">Contacto</a>
                <div class="pt-4 flex flex-col gap-2">
                    <a href="{{ Route::has('tenant-access.index') ? route('tenant-access.index') : (Route::has('login') ? route('login') : url('/acceso')) }}" class="w-full text-center rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-slate-700">
                        Acceso a mi banda
                    </a>
                    <button type="button" data-demo-trigger class="w-full text-center rounded-xl bg-blue-700 py-2.5 text-sm font-bold text-white shadow-md">
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
                        <span class="text-blue-700 font-bold">Android · iOS · Escritorio</span>
                    </div>
                </div>

                <!-- Hero Heading & Copy -->
                <div class="mt-8 text-center max-w-4xl mx-auto">
                    <h1 class="font-heading text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl sm:leading-tight lg:leading-[1.12]">
                        El software y app de gestión para tu <br class="hidden sm:inline">
                        <span class="bg-gradient-to-r from-blue-700 via-indigo-600 to-amber-600 bg-clip-text text-transparent">
                            Banda de Música, Charanga, Coro u Orquesta
                        </span>
                    </h1>
                    <p class="mt-6 text-lg sm:text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed font-normal">
                        Pon fin al caos de los grupos de WhatsApp y hojas de cálculo dispersas. Con eBand gestionas la disponibilidad de tus músicos en tiempo real, el control parental para familias, el inventario de uniformes y material, las actividades y las liquidaciones de bolos. Disponible para <strong>Android, iOS y Escritorio (PC / Mac)</strong> en una plataforma intuitiva que todos sabrán usar.
                    </p>

                    <!-- CTAs -->
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <button type="button" 
                                data-demo-trigger
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

                    <!-- App Store & Google Play Badges (Próximamente disponible) -->
                    <div class="mt-8 flex flex-col items-center justify-center">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 border border-blue-200/80 px-3 py-1 text-xs font-semibold text-blue-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-blue-600 animate-ping"></span>
                                📱 Disponible en Escritorio, Web/PWA y próximamente en tiendas oficiales móviles:
                            </span>
                        </div>
                        <div class="flex flex-wrap items-center justify-center gap-3">
                            <!-- App Store Button -->
                            <div class="group relative inline-flex items-center gap-3 rounded-2xl border border-slate-800 bg-slate-900 px-4 py-2.5 text-white shadow-lg shadow-slate-900/10 transition hover:bg-slate-800 cursor-default">
                                <svg class="h-7 w-7 fill-current text-white shrink-0" viewBox="0 0 24 24">
                                    <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.63-.77 1.06-1.85.94-2.93-.93.04-2.06.62-2.73 1.4-.59.68-1.11 1.77-.97 2.83 1.04.08 2.1-.53 2.76-1.3z"/>
                                </svg>
                                <div class="text-left leading-tight">
                                    <div class="text-[10px] font-medium text-slate-400">Consíguelo en el</div>
                                    <div class="text-sm font-bold tracking-tight text-white">App Store</div>
                                </div>
                                <span class="ml-2 rounded-full bg-blue-500/25 px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-blue-300 border border-blue-400/40">
                                    Próximamente
                                </span>
                            </div>

                            <!-- Google Play Button -->
                            <div class="group relative inline-flex items-center gap-3 rounded-2xl border border-slate-800 bg-slate-900 px-4 py-2.5 text-white shadow-lg shadow-slate-900/10 transition hover:bg-slate-800 cursor-default">
                                <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24">
                                    <path fill="#EA4335" d="M3.6 1.8L13.5 12 3.6 22.2c-.4-.4-.6-1-.6-1.7V3.5c0-.7.2-1.3.6-1.7z"/>
                                    <path fill="#FBBC04" d="M16.9 8.6L13.5 12l3.4 3.4 3.9-2.2c1.1-.6 1.1-1.7 0-2.4l-3.9-2.2z"/>
                                    <path fill="#4285F4" d="M3.6 1.8l10.9 9.3 2.4-2.5L5.7.5C4.8 0 4.1.5 3.6 1.8z"/>
                                    <path fill="#34A853" d="M16.9 15.4L14.5 13 3.6 22.2c.5 1.3 1.2 1.8 2.1 1.3l11.2-8.1z"/>
                                </svg>
                                <div class="text-left leading-tight">
                                    <div class="text-[10px] font-medium text-slate-400">Disponible en</div>
                                    <div class="text-sm font-bold tracking-tight text-white">Google Play</div>
                                </div>
                                <span class="ml-2 rounded-full bg-emerald-500/25 px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-emerald-300 border border-emerald-400/40">
                                    Próximamente
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Bar Indicators -->
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-xs sm:text-sm font-medium text-slate-500">
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Músicos y familias ilimitados</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Multiplataforma: Android, iOS y Escritorio</span>
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
                                 alt="Panel de control eBand - Gestión de actuaciones, disponibilidad y actividades" 
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
                                <div class="text-xs font-bold text-slate-900">Disponibilidad en tiempo real</div>
                                <div class="text-[11px] text-slate-500">Músicos disponibles para el ensayo</div>
                            </div>
                        </div>

                        <div class="absolute -bottom-4 -right-4 sm:bottom-10 sm:-right-6 hidden md:flex items-center gap-3 rounded-2xl border border-slate-200 bg-white/95 p-3.5 shadow-xl backdrop-blur-md">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-900">Control Parental y Familias</div>
                                <div class="text-[11px] text-slate-500">Padres y alumnos conectados</div>
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
                                Control exhaustivo de ensayos generales y parciales por cuerda (maderas, metales, percusión). Gestión de familias con alumnos menores, actividades extra e inventario de material.
                            </p>
                            <ul class="mt-6 space-y-2.5 text-xs text-slate-700">
                                <li class="flex items-center gap-2">
                                    <span class="text-blue-600 font-bold">✓</span> Disponibilidad inmediata ("Disponible / No disponible")
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-blue-600 font-bold">✓</span> Control parental para padres de educandos y menores
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-blue-600 font-bold">✓</span> Inventario de uniformes y de todo el material de la banda
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-blue-600 font-bold">✓</span> Actividades extra, viajes, comidas y cursos
                                </li>
                            </ul>
                        </div>
                        <div class="mt-8 pt-4 border-t border-slate-200/60">
                            <span class="text-xs font-semibold text-blue-700 flex items-center gap-1">
                                Para bandas sinfónicas, patronales y escuelas &rarr;
                            </span>
                        </div>
                    </div>

                    <!-- 2. Charangas -->
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
                            <h3 class="mt-6 font-heading text-xl font-bold text-slate-900">Charangas</h3>
                            <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                                Respuestas inmediatas para cerrar la plantilla de cada bolo en un clic. Reparto de honorarios por bolo con liquidaciones transparentes para cada miembro o refuerzo.
                            </p>
                            <ul class="mt-6 space-y-2.5 text-xs text-slate-700">
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-600 font-bold">✓</span> Confirmación ultra-rápida desde el móvil (Disponible / No disponible)
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-600 font-bold">✓</span> Liquidación y cálculo de cobro por actuación
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-600 font-bold">✓</span> Ubicaciones GPS de pasacalles y puntos de encuentro
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-amber-600 font-bold">✓</span> Horarios de salida de transporte y furgoneta
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                                </svg>
                            </div>
                            <h3 class="mt-6 font-heading text-xl font-bold text-slate-900">Corales, Coros y Orfeones</h3>
                            <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                                Organización específica por cuerdas vocales (sopranos, contraltos, tenores y bajos). Convocatorias a misas, certámenes, encuentros corales y salidas grupales.
                            </p>
                            <ul class="mt-6 space-y-2.5 text-xs text-slate-700">
                                <li class="flex items-center gap-2">
                                    <span class="text-indigo-600 font-bold">✓</span> Segmentación por cuerdas de voz
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-indigo-600 font-bold">✓</span> Convocatorias claras a ensayos y conciertos
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-indigo-600 font-bold">✓</span> Actividades extra y viajes de hermanamiento
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
                        Todo lo que tu directiva, directores y miembros necesitan
                    </h2>
                    <p class="mt-4 text-base sm:text-lg text-slate-600">
                        Olvídate de hojas de cálculo dispersas y notas de papel. Gestiona tu día a día con herramientas diseñadas exactamente para la realidad asociativa de bandas, coros y orquestas.
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1: Asistencia / Disponibilidad -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <h3 class="mt-5 font-heading text-lg font-bold text-slate-900">Control de Asistencia a Ensayos y Disponibilidad</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Los músicos indican con un solo clic si están <strong>Disponibles</strong> o <strong>No disponibles</strong> desde su teléfono o navegador de escritorio. El director y la junta conocen la plantilla confirmada por cuerda o instrumento en tiempo real.
                        </p>
                    </div>

                    <!-- Feature 2: Control Parental y Familias -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-5 font-heading text-lg font-bold text-slate-900">Control Parental para Familias</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Los padres y tutores pueden supervisar las convocatorias, ensayos y eventos de sus hijos menores, ver sus uniformes asignados e inscribirlos en actividades desde una única cuenta.
                        </p>
                    </div>

                    <!-- Feature 3: Actividades Extra y Convocatorias -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="mt-5 font-heading text-lg font-bold text-slate-900">Actividades, Conciertos y Convivencia</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Convoca conciertos o ensayos con confirmación directa (Sí / No) o eventos de pago como comidas de hermandad con elección de menús y viajes. Comparte convocatorias por WhatsApp en un toque.
                        </p>
                    </div>

                    <!-- Feature 4: Inventario de uniformes y material -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="mt-5 font-heading text-lg font-bold text-slate-900">Inventario de Uniformes y Material</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Controla los uniformes oficiales (trajes, corbatas, polos) y todo el material de la banda: instrumentos propios, atriles, fundas y accesorios asignados a cada integrante.
                        </p>
                    </div>

                    <!-- Feature 5: Liquidaciones económicas -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-5 font-heading text-lg font-bold text-slate-900">Liquidaciones y Reparto por Bolo</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Calcula el reparto económico por actuación, gestiona los pagos a refuerzos o colaboradores externos (forasteros) y genera balances contables claros.
                        </p>
                    </div>

                    <!-- Feature 6: App Móvil y Escritorio (Android, iOS y PC/Mac) -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-xs transition hover:shadow-md hover:border-slate-300">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="mt-5 flex items-center justify-between">
                            <h3 class="font-heading text-lg font-bold text-slate-900">App Móvil y Escritorio</h3>
                            <span class="rounded-full bg-purple-100 px-2 py-0.5 text-[10px] font-bold text-purple-800">Android · iOS · PC/Mac</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Accede cómodamente desde cualquier dispositivo: navegador web en tu ordenador de escritorio o app en teléfonos <strong>Android</strong> e <strong>iPhone</strong> (ya como PWA y próximamente en App Store y Google Play).
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
                        Explora las diferentes pantallas de eBand: pensadas tanto para directivos como para músicos y familias de todas las edades.
                    </p>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Gallery Card 1 -->
                    <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition hover:shadow-xl hover:border-slate-300">
                        <div class="overflow-hidden bg-slate-200">
                            <img src="{{ asset('galeria/detalle_actuacion.png') }}" 
                                 alt="Ficha de detalle de actuación y disponibilidad" 
                                 class="h-56 w-full object-cover object-top transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        </div>
                        <div class="p-5">
                            <h4 class="font-heading font-bold text-slate-900">Detalle de Actuación y Bolos</h4>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                Mapa de ubicación, horarios de transporte, uniforme requerido y panel de disponibilidad de los músicos.
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
                                Vista global del mes para evitar solapamientos y planificar convocatorias y actividades con antelación.
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Card 3 -->
                    <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition hover:shadow-xl hover:border-slate-300">
                        <div class="overflow-hidden bg-slate-200">
                            <img src="{{ asset('galeria/inventario.png') }}" 
                                 alt="Gestión de inventario de uniformes y material de la banda" 
                                 class="h-56 w-full object-cover object-top transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        </div>
                        <div class="p-5">
                            <h4 class="font-heading font-bold text-slate-900">Inventario de Material y Uniformes</h4>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                Registro completo del material propiedad de la agrupación y qué músico o familia tiene asignado cada elemento.
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
                                Métricas de compromisos anuales, porcentaje de asistencia y balances económicos de bolos.
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
                                Comunicados oficiales visibles para todos los socios y familias al entrar en la aplicación.
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
                                Canal participativo para escuchar propuestas, actividades y sugerencias de mejora de los integrantes.
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Card 7: Listado de Actividades y Botón Compartir -->
                    <div class="group overflow-hidden rounded-2xl border-2 border-indigo-200 bg-gradient-to-b from-indigo-50/30 to-white transition hover:shadow-xl hover:border-indigo-400">
                        <div class="overflow-hidden bg-slate-200 relative">
                            <span class="absolute top-3 right-3 z-10 rounded-full bg-indigo-600 px-2.5 py-0.5 text-[10px] font-bold text-white shadow-sm">
                                Nuevo
                            </span>
                            <img src="{{ asset('listadoActividades.png') }}" 
                                 alt="Listado de actividades con botón de compartir por WhatsApp y filtros" 
                                 class="h-56 w-full object-cover object-top transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        </div>
                        <div class="p-5">
                            <h4 class="font-heading font-bold text-slate-900 flex items-center gap-1.5">
                                <span>Actividades y Convocatorias</span>
                            </h4>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                Conciertos, comidas, reuniones o ensayos sin precio. Botón rápido de compartir por WhatsApp para convocar a la banda al instante.
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Card 8: Control de Asistencia y Pendientes -->
                    <div class="group overflow-hidden rounded-2xl border-2 border-emerald-200 bg-gradient-to-b from-emerald-50/30 to-white transition hover:shadow-xl hover:border-emerald-400">
                        <div class="overflow-hidden bg-slate-200 relative">
                            <span class="absolute top-3 right-3 z-10 rounded-full bg-emerald-600 px-2.5 py-0.5 text-[10px] font-bold text-white shadow-sm">
                                Nuevo
                            </span>
                            <img src="{{ asset('estadisticasActividades.png') }}" 
                                 alt="Panel de control de actividad con confirmados, no asistirán y pendientes de respuesta" 
                                 class="h-56 w-full object-cover object-top transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        </div>
                        <div class="p-5">
                            <h4 class="font-heading font-bold text-slate-900 flex items-center gap-1.5">
                                <span>Control de Asistencia y Pendientes</span>
                            </h4>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                Tarjetas en tiempo real de confirmados, no asistirán y pendientes de responder, junto con el desglose de menús para proveedores.
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
                                Para Bandas de Música, Charangas y Corales.
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
                                    <span><strong>Músicos, socios y familias ilimitados:</strong> da de alta a toda tu agrupación sin sobrecostes.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Control de disponibilidad:</strong> el músico o tutor indica "Disponible / No disponible" con 1 clic.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Control parental y gestión de menores:</strong> acceso familiar unificado para padres y alumnos.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Actividades extra y eventos especiales:</strong> viajes, comidas, talleres y convivencia con inscripción.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Inventario de uniformes y material:</strong> trazabilidad de trajes, instrumentos propios y accesorios.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>Liquidaciones económicas por bolo:</strong> cálculo y reparto automático de pagos a integrantes y refuerzos.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><strong>App Móvil PWA para cada músico:</strong> instalable fácilmente en iPhone y Android.</span>
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
                                    <span><strong>Soporte técnico y copias de seguridad:</strong> te ayudamos en la puesta en marcha.</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex flex-col gap-3">
                            <button type="button" 
                                    data-demo-trigger
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
        <!-- FAQ SECTION (NATIVE HTML5 ACCORDION WITH DETAILS/SUMMARY)       -->
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
                    <!-- FAQ 1: Corales -->
                    <details name="faq" class="group rounded-2xl border border-slate-200 bg-slate-50/60 p-6 transition duration-200 open:bg-white open:shadow-md hover:border-slate-300">
                        <summary class="flex w-full cursor-pointer list-none items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none select-none [&::-webkit-details-marker]:hidden">
                            <span>¿eBand es compatible con Corales y Coros además de Bandas?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs transition-transform duration-200 group-open:rotate-180">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            Absolutamente. Puedes clasificar a los integrantes tanto por instrumentos (en el caso de bandas y agrupaciones instrumentales) como por <strong>cuerdas vocales (sopranos, contraltos, tenores y bajos)</strong> en coros y agrupaciones vocales. Las convocatorias, disponibilidad y actividades se gestionan perfectamente según la voz de cada corista.
                        </div>
                    </details>

                    <!-- FAQ 2: Control Parental -->
                    <details name="faq" class="group rounded-2xl border border-slate-200 bg-slate-50/60 p-6 transition duration-200 open:bg-white open:shadow-md hover:border-slate-300">
                        <summary class="flex w-full cursor-pointer list-none items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none select-none [&::-webkit-details-marker]:hidden">
                            <span>¿Cómo funciona el Control Parental para familias con hijos menores?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs transition-transform duration-200 group-open:rotate-180">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            Muchos músicos de bandas y escuelas de música son menores de edad. Los padres o tutores disponen de una vista familiar donde pueden consultar las convocatorias, ensayos, uniformes y actividades de sus hijos, marcar su disponibilidad (Disponible / No disponible) e inscribirlos en salidas o actividades extra sin necesidad de que el menor gestione un usuario independiente.
                        </div>
                    </details>

                    <!-- FAQ 3: eBand vs Excel / WhatsApp -->
                    <details name="faq" class="group rounded-2xl border border-slate-200 bg-slate-50/60 p-6 transition duration-200 open:bg-white open:shadow-md hover:border-slate-300">
                        <summary class="flex w-full cursor-pointer list-none items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none select-none [&::-webkit-details-marker]:hidden">
                            <span>¿Por qué utilizar eBand en lugar de hojas de cálculo de Excel o grupos de WhatsApp?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs transition-transform duration-200 group-open:rotate-180">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            Gestionar una banda, charanga o coro con Excel y grupos de WhatsApp genera mensajes perdidos, falta de respuestas a última hora y múltiples versiones desactualizadas de un mismo archivo. eBand centraliza y automatiza toda la gestión en una plataforma común accesible desde <strong>Android, iOS y Escritorio (PC / Mac)</strong>: cada músico indica su disponibilidad con un solo clic, el director y la junta directiva visualizan la plantilla confirmada en tiempo real, las familias disponen de control parental para sus hijos y las actuaciones cuentan con liquidación económica automática. Todo con una <strong>tarifa plana de 150€/año sin límites de miembros</strong>.
                        </div>
                    </details>

                    <!-- FAQ 3: iPhone y Android -->
                    <details name="faq" class="group rounded-2xl border border-slate-200 bg-slate-50/60 p-6 transition duration-200 open:bg-white open:shadow-md hover:border-slate-300">
                        <summary class="flex w-full cursor-pointer list-none items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none select-none [&::-webkit-details-marker]:hidden">
                            <span>¿Cómo se instala en iPhone y teléfonos Android?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs transition-transform duration-200 group-open:rotate-180">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            Actualmente eBand funciona como <strong>Progressive Web App (PWA)</strong>: al abrir el enlace de tu banda en el navegador del móvil, basta con pulsar <em>"Añadir a pantalla de inicio"</em> (en Safari de iOS o Chrome de Android) para tener acceso instantáneo con icono en tu teléfono. Además, <strong>muy pronto estará disponible para descargar de forma directa y nativa en el App Store y Google Play</strong>.
                        </div>
                    </details>

                    <!-- FAQ 4: Tarifa -->
                    <details name="faq" class="group rounded-2xl border border-slate-200 bg-slate-50/60 p-6 transition duration-200 open:bg-white open:shadow-md hover:border-slate-300">
                        <summary class="flex w-full cursor-pointer list-none items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none select-none [&::-webkit-details-marker]:hidden">
                            <span>¿Qué incluye exactamente la tarifa plana de 150€/año?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs transition-transform duration-200 group-open:rotate-180">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            Incluye el 100% de la plataforma: músicos y familias ilimitados, actuaciones, ensayos y actividades extra sin límite, control de disponibilidad, inventario de uniformes y material de la banda, módulo de liquidación económica por bolo, soporte por email o WhatsApp, copias de seguridad continuas y todas las actualizaciones de la versión 3.0.
                        </div>
                    </details>

                    <!-- FAQ 5: Acceso -->
                    <details name="faq" class="group rounded-2xl border border-slate-200 bg-slate-50/60 p-6 transition duration-200 open:bg-white open:shadow-md hover:border-slate-300">
                        <summary class="flex w-full cursor-pointer list-none items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none select-none [&::-webkit-details-marker]:hidden">
                            <span>¿Cómo acceden los integrantes a su espacio privado?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs transition-transform duration-200 group-open:rotate-180">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            Cada agrupación dispone de una dirección web propia (por ejemplo <code>tubanda.eband.app</code>). Además, desde la página principal de <code>eband.app</code> en el botón <em>"Acceso a mi banda"</em>, los integrantes pueden introducir su código único y serán dirigidos automáticamente a su espacio privado.
                        </div>
                    </details>

                    <!-- FAQ 6: Demo -->
                    <details name="faq" class="group rounded-2xl border border-slate-200 bg-slate-50/60 p-6 transition duration-200 open:bg-white open:shadow-md hover:border-slate-300">
                        <summary class="flex w-full cursor-pointer list-none items-center justify-between text-left text-base font-bold text-slate-900 focus:outline-none select-none [&::-webkit-details-marker]:hidden">
                            <span>¿Puedo probar la herramienta antes de contratar?</span>
                            <span class="ml-4 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 border border-slate-200 shadow-xs transition-transform duration-200 group-open:rotate-180">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-3 text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                            Sí. Puedes acceder a nuestra demo interactiva en cualquier momento pulsando el botón <strong>"Probar Demo"</strong>. Podrás explorar el panel de administración, ver cómo se configuran las actuaciones y comprobar la agilidad de uso.
                        </div>
                    </details>
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
                                    <p class="text-xs text-slate-600">Te contestamos en menos de 24 horas laborables con una propuesta clara y directa.</p>
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
                                    <p class="text-xs text-slate-600">Revisamos tu caso: banda con escuela, charanga con bolos o coro polifónico.</p>
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
                                           placeholder="Banda, Charanga o Coral..."
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
                                Respetamos tu privacidad. Tus datos solo se utilizarán para responder a esta solicitud. Consulta nuestra <a href="{{ route('politica-privacidad') }}" class="underline hover:text-blue-700">Política de Privacidad</a>.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ============================================================== -->
    <!-- DEMO ACCESS MODAL                                              -->
    <!-- ============================================================== -->
    <div id="demo-modal"
         class="hidden fixed inset-0 z-50 items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog" 
         aria-modal="true">
        <!-- Backdrop -->
        <div id="demo-modal-backdrop"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity cursor-pointer"></div>

        <!-- Modal Card -->
        <div class="relative w-full max-w-lg rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-2xl transition-all z-10">
            
            <button type="button" 
                    id="demo-modal-close"
                    class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none"
                    aria-label="Cerrar ventana">
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
                    <p class="text-xs text-slate-500">Explora eBand en tiempo real sin esperas</p>
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
                    @if ($errors->demoAccess->has('g-recaptcha-response'))
                        <span class="mt-1 block text-xs text-rose-600 font-medium">{{ $errors->demoAccess->first('g-recaptcha-response') }}</span>
                    @endif
                </div>

                <button type="submit" 
                        class="w-full rounded-xl bg-blue-700 py-3.5 text-sm font-bold text-white shadow-md shadow-blue-700/25 transition hover:bg-blue-800">
                    Entrar a la Demo Ahora
                </button>
                <p class="text-[11px] text-center text-slate-500 mt-2">
                    Al acceder aceptas nuestra <a href="{{ route('politica-privacidad') }}" target="_blank" class="underline hover:text-blue-700">Política de Privacidad</a>.
                </p>
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
                            &copy; {{ date('Y') }} eBand. El software para Bandas de Música, Charangas y Corales.
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
                    <a href="{{ route('politica-privacidad') }}" class="hover:text-blue-700 font-semibold text-slate-700">Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Render reCAPTCHA Script -->
    {!! NoCaptcha::renderJs() !!}

    <!-- Fallback pure JS for bulletproof modal, FAQ accordion and mobile menu -->
    <script>
        window.openDemoModal = function () {
            const modal = document.getElementById('demo-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        };

        window.closeDemoModal = function () {
            const modal = document.getElementById('demo-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
        };

        document.addEventListener('DOMContentLoaded', function () {
            // Demo Modal open / close handlers
            const demoButtons = document.querySelectorAll('[data-demo-trigger]');
            const demoClose = document.getElementById('demo-modal-close');
            const demoBackdrop = document.getElementById('demo-modal-backdrop');

            demoButtons.forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    window.openDemoModal();
                });
            });

            if (demoClose) {
                demoClose.addEventListener('click', window.closeDemoModal);
            }
            if (demoBackdrop) {
                demoBackdrop.addEventListener('click', window.closeDemoModal);
            }

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    window.closeDemoModal();
                }
            });

            // Accordion: cerrar otros <details> al abrir uno
            const allDetails = document.querySelectorAll('details[name="faq"]');
            allDetails.forEach(function (targetDetail) {
                targetDetail.addEventListener('toggle', function () {
                    if (targetDetail.open) {
                        allDetails.forEach(function (otherDetail) {
                            if (otherDetail !== targetDetail && otherDetail.open) {
                                otherDetail.open = false;
                            }
                        });
                    }
                });
            });

            // Mobile menu toggle
            const mobileToggle = document.getElementById('mobile-nav-toggle');
            const mobileMenu = document.getElementById('mobile-nav-menu');
            if (mobileToggle && mobileMenu) {
                mobileToggle.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            @if($errors->demoAccess->any())
                window.openDemoModal();
            @endif
        });
    </script>
</body>
</html>