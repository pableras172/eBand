<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

            <!-- Open Graph (Facebook y WhatsApp) -->
    <meta property="og:title" content="{{ config('app.name', 'Laravel') }} - {{config('app.banda', '')}}" />
    <meta property="og:description" content="Facilita la gestió de bandes amb eBand: organitza concerts, assajos i molt més." />
    <meta property="og:image" content="{{ url('/imagenes/logo.png') }}" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }} - {{config('app.banda', '')}}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ config('app.name', 'Laravel') }} - {{config('app.banda', '')}}" />
    <meta name="twitter:description" content="Facilita la gestió de bandes amb eBand: organitza concerts, assajos i molt més." />
    <meta name="twitter:image" content="{{ url('/imagenes/icons/favicon/logoSmall_192.png') }}" />

    <meta name="title" content="{{ config('app.name', 'Laravel') }} - {{config('app.banda', '')}}" />
    <meta name="description" content="Facilita la gestió de bandes amb eBand: organitza concerts, assajos i molt més." />
    <link rel="icon" href="{{ url('/imagenes/icons/favicon/logoSmall_192.png') }}" type="image/png">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{config('app.banda', '')}}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!--link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet"-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"  crossorigin="anonymous"> <!-- integrity="sha384-DyZ88mC6Up2uqS4h/KvnQZK1ZoxSDeVUPZ3h5jC4Q4hzsj4Z8cdVf4QlScYOu4i0" -->

    <link rel="manifest" href="manifest.json">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">

    <link  rel="stylesheet"  href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css"/>


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
        var userUUID = '';
        var userId = {{ Auth::user()->id }};
        var appId = "{{ config('services.onesignal.app_id') }}";
        $.ajax({
            url: '/usersuuid/' +  userId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                userUUID = response.uuid;
                OneSignalDeferred.push(function(OneSignal) {
                    OneSignal.init({
                        appId: appId,
                        useSubscriptionWorkaround: true, // Habilitar modo de compatibilidad
                        allowLocalhostAsSecureOrigin: true, // Para pruebas en local
                        cookie: {
                            secure: true,
                            sameSite: 'none'
                        },
                    }).then(function() {
                        OneSignal.login(userUUID);
                    }).catch(function(error) {
                        // Manejar cualquier error que ocurra durante la inicialización de OneSignal
                        console.error('Error initializing OneSignal:', error);
                    });
                });

            },
            error: function(xhr, status, error) {
                // Manejo de errores
                console.error('Error al obtener el UUID del usuario:', error);
            }
        });          
        
        function showToast(response){
            var type = response.alert_type;
            toastr.options.positionClass='toast-top-full-width';
            toastr.options.progressBar=true;
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
