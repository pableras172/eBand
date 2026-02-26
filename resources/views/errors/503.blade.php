<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento en progreso 🎵</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .container {
            text-align: center;
            z-index: 10;
            max-width: 700px;
            padding: 2rem;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 1.5rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .emoji {
            font-size: 6rem;
            margin-bottom: 1rem;
            display: inline-block;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        h1 {
            color: #fff;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .subtitle {
            color: #fff;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        .message {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            background: rgba(255, 255, 255, 0.15);
            padding: 1.5rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .quote-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.2rem;
            border-radius: 12px;
            margin-top: 1.5rem;
            border-left: 4px solid #fff;
            font-style: italic;
            color: rgba(255, 255, 255, 0.9);
        }

        .quote-author {
            margin-top: 0.8rem;
            font-size: 0.9rem;
            color: #fff;
            font-weight: 600;
            font-style: normal;
        }

        /* Notas musicales flotantes */
        .music-note {
            position: absolute;
            font-size: 2.5rem;
            opacity: 0.15;
            animation: float 16s infinite ease-in-out;
            color: #fff;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            25% {
                transform: translateY(-30px) rotate(6deg);
            }
            50% {
                transform: translateY(0) rotate(0deg);
            }
            75% {
                transform: translateY(-18px) rotate(-6deg);
            }
        }

        .note-1 { top: 10%; left: 12%; animation-delay: 0s; font-size: 3rem; }
        .note-2 { top: 25%; right: 18%; animation-delay: 2s; font-size: 2rem; }
        .note-3 { top: 55%; left: 15%; animation-delay: 4s; font-size: 2.5rem; }
        .note-4 { bottom: 15%; right: 20%; animation-delay: 6s; font-size: 3rem; }
        .note-5 { top: 38%; left: 8%; animation-delay: 8s; font-size: 2rem; }
        .note-6 { bottom: 30%; left: 25%; animation-delay: 10s; font-size: 2.5rem; }
        .note-7 { top: 18%; right: 30%; animation-delay: 12s; font-size: 2rem; }
        .note-8 { bottom: 22%; right: 12%; animation-delay: 14s; font-size: 2.5rem; }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            .subtitle {
                font-size: 1.1rem;
            }
            .emoji {
                font-size: 4.5rem;
            }
            .message {
                font-size: 1rem;
                padding: 1.2rem;
            }
            .music-note {
                font-size: 1.5rem !important;
            }
        }
    </style>
</head>
<body>
    <!-- Notas musicales de fondo -->
    <div class="music-note note-1">♪</div>
    <div class="music-note note-2">♫</div>
    <div class="music-note note-3">♬</div>
    <div class="music-note note-4">♭</div>
    <div class="music-note note-5">♯</div>
    <div class="music-note note-6">♪</div>
    <div class="music-note note-7">♫</div>
    <div class="music-note note-8">♬</div>

    <div class="container">
        <img class="logo" src="{{ URL::to('/') }}/imagenes/logo.png" alt="Logo" />
        
        <div class="emoji">🎵</div>
        
        <h1>¡Estamos afinando instrumentos!</h1>
        <div class="subtitle">Mantenimiento en progreso...</div>
        
        <div class="message">
            <p style="margin-bottom: 0.8rem;">🎼 <strong>Estamos mejorando la plataforma para ti</strong></p>
            <p>Nuestro equipo está realizando tareas de mantenimiento para ofrecerte una mejor experiencia. Volveremos muy pronto con novedades y mejoras. ¡Gracias por tu paciencia y comprensión!</p>
        </div>

        <div class="quote-box">
            <p>"La música es el lenguaje universal de la humanidad."</p>
            <div class="quote-author">— Henry Wadsworth Longfellow</div>
        </div>
    </div>
</body>
</html>
