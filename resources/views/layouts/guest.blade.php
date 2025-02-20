<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
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

        <link rel="apple-touch-icon" href="/imagenes/icons/ios/192.png">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="eBand">
    
    
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/storage/imagenes/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
