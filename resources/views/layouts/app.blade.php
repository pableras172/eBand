<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @php
        $bandName = function_exists('tenant_name') && function_exists('tenant') && tenant()
            ? (config('app.name', 'Laravel') . ' - ' . tenant_name())
            : ($bandSetting?->nombre ?? config('app.banda', config('app.name', 'eBand')));
        $bandLogo = $bandSetting?->logo ? asset('storage/'.$bandSetting->logo) : url('/imagenes/logo.png');
    @endphp

    <!-- Open Graph (Facebook y WhatsApp) -->
    <meta property="og:title" content="{{ $bandName }}" />
    <meta property="og:description"
        content="Facilita la gestió de bandes amb eBand: organitza concerts, assajos i molt més." />
    <meta property="og:image" content="{{ $bandLogo }}" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ $bandName }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $bandName }}" />
    <meta name="twitter:description"
        content="Facilita la gestió de bandes amb eBand: organitza concerts, assajos i molt més." />
    <meta name="twitter:image" content="{{ $bandLogo }}" />

    <meta name="title" content="{{ $bandName }}" />
    <meta name="description"
        content="Facilita la gestió de bandes amb eBand: organitza concerts, assajos i molt més." />
    <link rel="icon" href="{{ url('/imagenes/icons/favicon/logoSmall_192.png') }}" type="image/png">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $bandName }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!--link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet"-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        crossorigin="anonymous">
    <!-- integrity="sha384-DyZ88mC6Up2uqS4h/KvnQZK1ZoxSDeVUPZ3h5jC4Q4hzsj4Z8cdVf4QlScYOu4i0" -->

    <link rel="manifest" href="{{ url('/manifest.json') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css" />

     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>


    <link rel="apple-touch-icon" href="/imagenes/icons/ios/192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="eBand">


    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/storage/imagenes/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        var userId = {{ Auth::user()->id }};
        var appId = "{{ tenant_onesignal_app_id() }}";
        var currentHost = window.location.hostname;
        var isHttps = window.location.protocol === 'https:';
        var shouldInitOneSignal = isHttps && appId !== '';

        if (shouldInitOneSignal) {
            $.ajax({
                url: '/usersuuid/' + userId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var userUUID = response.uuid;

                    if (!userUUID) {
                        return;
                    }

                    OneSignalDeferred.push(function(OneSignal) {
                        OneSignal.init({
                            appId: appId,
                            serviceWorkerParam: { scope: '/' },
                            serviceWorkerPath: 'sw.js',
                            cookie: {
                                secure: true,
                                sameSite: 'none'
                            },
                        }).then(function() {
                            OneSignal.login(userUUID);
                        }).catch(function(error) {
                            console.error('Error initializing OneSignal:', error);
                        });
                    });

                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener el UUID del usuario:', error);
                }
            });
        } else {
            console.info('OneSignal desactivado en ' + currentHost + ' (requiere HTTPS y appId válido).');
        }

        function showToast(response) {
            var type = response.alert_type;
            toastr.options.positionClass = 'toast-top-full-width';
            toastr.options.progressBar = true;
            toastr.options.timeOut = 5000;
            switch (type) {
                case 'info':
                    toastr.info(response.message);
                    break;
                case 'success':
                    toastr.success(response.message);
                    break;
                case 'warning':
                    toastr.warning(response.message);
                    break;
                case 'error':
                    toastr.error(response.message);
                    break;
            }

        }
    </script>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

</head>

<body class="font-sans antialiased" x-data="themeSwitcher()" :class="{ 'dark': switchOn }">
    <x-banner />

    @if (session('demo_mode'))
        <div class="relative z-50 border-b border-amber-300 bg-amber-100 px-4 py-2 text-center text-sm font-semibold text-amber-900">
            <div class="flex flex-col items-center justify-center gap-2 sm:flex-row sm:gap-3">
                <span>Modo demo activo: estas en un entorno de pruebas con acceso completo.</span>
                <a href="{{ route('demo.info.create') }}" class="inline-flex items-center rounded-md border border-amber-500 px-3 py-1 text-xs font-bold uppercase tracking-wide text-amber-900 transition hover:bg-amber-200">
                    Solicitar informacion
                </a>
            </div>
        </div>
    @endif

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
