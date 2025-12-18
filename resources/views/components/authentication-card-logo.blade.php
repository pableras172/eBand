<div class="relative w-full">
    <!-- Fondo borroso y oscuro que cubre todo el contenedor -->
    <div class="absolute inset-0 bg-cover bg-center transform scale-105"
         style="background-image: url('{{ URL::to('/') }}/imagenes/logo.png'); filter: blur(4px) brightness(0.9);"></div>
    <!-- Capa overlay para más contraste -->
    <div class="absolute inset-0 bg-black/30"></div>

    <!-- Contenido en primer plano -->
    <div class="relative flex flex-col items-center justify-center p-4">
        <div class="text-center mt-4 mb-2">
            <h1 class="text-4xl sm:text-4xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-pink-500 to-orange-500">
                {{ config('app.name') }}
            </h1>
            
        </div>

        <x-lottie style="width: 300px; height: 200px;" path="{{ asset('storage/animaciones/login.json') }}" loop="true" autoplay="true" />

        <!--<a href="/" class="mt-2">
            <img style="width: 200px;" src="{{ URL::to('/') }}/imagenes/logo.png" alt="Logo" />
        </a-->
    </div>
</div>


