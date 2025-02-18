<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento en progreso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #034460;
            color: #fff;
            text-align: center;
            padding: 5%;
            font-family: 'Arial', sans-serif;
        }

        .logo {
            width: 75px;
            margin-bottom: 20px;
        }

        /* Animación de batuta */
        .baton {
            transform-origin: bottom center;
            animation: wave 2s ease-in-out infinite;
        }

        @keyframes wave {
            0% { transform: rotate(-20deg); }
            50% { transform: rotate(20deg); }
            100% { transform: rotate(-20deg); }
        }

        .arm-left {
            transform-origin: top center;
            animation: armLeft 2s ease-in-out infinite;
        }

        @keyframes armLeft {
            0% { transform: rotate(-15deg); }
            50% { transform: rotate(15deg); }
            100% { transform: rotate(-15deg); }
        }

        .arm-right {
            transform-origin: top center;
            animation: armRight 2s ease-in-out infinite;
            animation-delay: 1s;
        }

        @keyframes armRight {
            0% { transform: rotate(15deg); }
            50% { transform: rotate(-15deg); }
            100% { transform: rotate(15deg); }
        }

        /* Estilo para el carrusel */
        .carousel-item {
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 1.4em;
            font-style: italic;
            padding: 20px;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .carousel-item.active {
            opacity: 1;
        }

        .quote-author {
            margin-top: 10px;
            font-size: 1em;
            color: #FFD700;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <!-- Logo de la app -->
        <img class="logo" src="{{ URL::to('/') }}/imagenes/logo.png" alt="Logo de la app" />

        <!-- SVG animado del director de orquesta -->
        <div class="mb-4">
            <svg width="200" height="200" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <!-- Cabeza -->
                <circle cx="100" cy="60" r="20" fill="#FFD700"/>
                
                <!-- Cuerpo -->
                <rect x="90" y="80" width="20" height="60" fill="#FFD700"/>

                <!-- Brazos -->
                <rect x="70" y="85" width="10" height="60" fill="#FFA500" class="arm-left"/>
                <rect x="120" y="85" width="10" height="60" fill="#FFA500" class="arm-right"/>

                <!-- Batuta en la mano derecha -->
                <line x1="125" y1="140" x2="150" y2="110" stroke="#fff" stroke-width="3" class="baton"/>

                <!-- Nota musical -->
                <path d="M 160 120 C 165 110 180 110 185 120 C 190 130 175 140 170 130 Z" fill="#FFD700"/>
                <circle cx="160" cy="120" r="5" fill="#FFD700"/>
                <line x1="160" y1="115" x2="160" y2="100" stroke="#FFD700" stroke-width="3"/>
            </svg>
        </div>

        <h1 class="mb-4">¡Estamos en mantenimiento!</h1>
        <p class="mb-3">Estamos afinando nuestra plataforma para ofrecerte una mejor experiencia. 🎶</p>
        <p>Volveremos en breve. ¡Gracias por tu paciencia! 😊</p>

        <!-- Carrusel de citas célebres -->
        <div id="quoteCarousel" class="carousel slide mt-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="w-100">
                        <p>"La música es el lenguaje universal de la humanidad."</p>
                        <div class="quote-author">— Henry Wadsworth Longfellow</div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="w-100">
                        <p>"La música es el arte más directo, entra por el oído y va al corazón."</p>
                        <div class="quote-author">— Magdalena Martínez</div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="w-100">
                        <p>"La música puede cambiar el mundo porque puede cambiar a las personas."</p>
                        <div class="quote-author">— Bono</div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="w-100">
                        <p>"La música es el vínculo que une la vida del espíritu con la vida de los sentidos."</p>
                        <div class="quote-author">— Beethoven</div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="w-100">
                        <p>"Sin música, la vida sería un error."</p>
                        <div class="quote-author">— Friedrich Nietzsche</div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="w-100">
                        <p>"La música compone los ánimos descompuestos y alivia los trabajos que nacen del espíritu."</p>
                        <div class="quote-author">— Miguel de Cervantes</div>
                    </div>
                </div>
            </div>

            <!-- Controles del carrusel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#quoteCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#quoteCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <!-- JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
