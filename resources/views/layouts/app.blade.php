<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{config('app.banda', '')}}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <link rel="manifest" href="manifest.json">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="57x57" href="/storage/imagenes/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/storage/imagenes/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/storage/imagenes/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/storage/imagenes/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/storage/imagenes/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/storage/imagenes/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/storage/imagenes/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/storage/imagenes/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/storage/imagenes/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/storage/imagenes/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/storage/imagenes/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/storage/imagenes/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/storage/imagenes/favicon-16x16.png">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/storage/imagenes/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        var userUUID = '';
        var userId = {{ Auth::user()->id }};
        $.ajax({
            url: '/usersuuid/' + userId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                userUUID = response.uuid;
                OneSignalDeferred.push(function(OneSignal) {
                    OneSignal.init({
                        appId: "7bd1d5a1-fa0a-4db2-87ef-559374d418d5",
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
