<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ups... Zona restringida 🎵</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            max-width: 600px;
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
            animation: wiggle 1s ease-in-out infinite;
        }

        @keyframes wiggle {
            0%, 100% {
                transform: rotate(-5deg);
            }
            50% {
                transform: rotate(5deg);
            }
        }

        h1 {
            color: #fff;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .subtitle {
            color: #ffd700;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .message {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .btn-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #ffd700;
            color: #667eea;
        }

        .btn-primary:hover {
            background: #ffed4e;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Partituras flotantes de fondo */
        .music-note {
            position: absolute;
            font-size: 2rem;
            opacity: 0.15;
            animation: float 15s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            25% {
                transform: translateY(-30px) rotate(5deg);
            }
            50% {
                transform: translateY(0) rotate(0deg);
            }
            75% {
                transform: translateY(-20px) rotate(-5deg);
            }
        }

        .note-1 { top: 10%; left: 10%; animation-delay: 0s; }
        .note-2 { top: 20%; right: 15%; animation-delay: 2s; }
        .note-3 { top: 60%; left: 15%; animation-delay: 4s; }
        .note-4 { bottom: 15%; right: 20%; animation-delay: 6s; }
        .note-5 { top: 40%; left: 5%; animation-delay: 8s; }
        .note-6 { bottom: 30%; left: 25%; animation-delay: 10s; }
        .note-7 { top: 15%; right: 30%; animation-delay: 12s; }
        .note-8 { bottom: 20%; right: 10%; animation-delay: 14s; }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            .subtitle {
                font-size: 1.4rem;
            }
            .emoji {
                font-size: 4rem;
            }
            .message {
                font-size: 1rem;
            }
            .btn-container {
                flex-direction: column;
                align-items: stretch;
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
        
        <div class="emoji">🎺</div>
        
        <h1>¡Ups! Zona VIP</h1>
        <div class="subtitle">Error 403</div>
        
        <div class="message">
            <p style="margin-bottom: 0.8rem;">😅 <strong>Parece que has intentado entrar en una zona restringida...</strong></p>
            <p>No te preocupes, pasa todos los días. Esta sección está reservada solo para algunos miembros de la banda. Si crees que deberías tener acceso, habla con un administrador. ¡Seguro que te lo solucionan enseguida!</p>
        </div>

        <div class="btn-container">
            <a href="{{ \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : url('/') }}" class="btn btn-primary">
                <span>🏠</span> Volver al inicio
            </a>
            <button onclick="history.back()" class="btn btn-secondary">
                <span>←</span> Página anterior
            </button>
        </div>
    </div>
</body>
</html>
