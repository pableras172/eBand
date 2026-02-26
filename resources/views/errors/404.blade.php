<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada 🎵</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
            animation: sway 3s ease-in-out infinite;
        }

        @keyframes sway {
            0%, 100% {
                transform: rotate(-10deg);
            }
            50% {
                transform: rotate(10deg);
            }
        }

        .error-code {
            color: #fff;
            font-size: 5rem;
            margin-bottom: 0.5rem;
            font-weight: 800;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.2);
            letter-spacing: 0.1em;
        }

        h1 {
            color: #fff;
            font-size: 2.2rem;
            margin-bottom: 1rem;
            font-weight: 700;
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
            background: #fff;
            color: #f5576c;
        }

        .btn-primary:hover {
            background: #ffe5e9;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.4);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Notas musicales flotantes */
        .music-note {
            position: absolute;
            font-size: 2.5rem;
            opacity: 0.2;
            animation: float 20s infinite ease-in-out;
            color: #fff;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            25% {
                transform: translateY(-40px) rotate(10deg);
            }
            50% {
                transform: translateY(0) rotate(0deg);
            }
            75% {
                transform: translateY(-25px) rotate(-10deg);
            }
        }

        .note-1 { top: 5%; left: 8%; animation-delay: 0s; font-size: 3rem; }
        .note-2 { top: 25%; right: 12%; animation-delay: 3s; font-size: 2rem; }
        .note-3 { top: 55%; left: 10%; animation-delay: 6s; font-size: 2.5rem; }
        .note-4 { bottom: 10%; right: 15%; animation-delay: 9s; font-size: 3rem; }
        .note-5 { top: 35%; left: 3%; animation-delay: 12s; font-size: 2rem; }
        .note-6 { bottom: 25%; left: 20%; animation-delay: 15s; font-size: 2.5rem; }
        .note-7 { top: 12%; right: 25%; animation-delay: 18s; font-size: 2rem; }
        .note-8 { bottom: 15%; right: 8%; animation-delay: 1s; font-size: 2.5rem; }
        .note-9 { top: 70%; right: 30%; animation-delay: 4s; font-size: 2rem; }
        .note-10 { bottom: 40%; left: 35%; animation-delay: 7s; font-size: 3rem; }

        @media (max-width: 768px) {
            .error-code {
                font-size: 3.5rem;
            }
            h1 {
                font-size: 1.8rem;
            }
            .emoji {
                font-size: 4.5rem;
            }
            .message {
                font-size: 1rem;
                padding: 1.2rem;
            }
            .btn-container {
                flex-direction: column;
                align-items: stretch;
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
    <div class="music-note note-9">♪</div>
    <div class="music-note note-10">♫</div>

    <div class="container">
        <img class="logo" src="{{ URL::to('/') }}/imagenes/logo.png" alt="Logo" />
        
        <div class="emoji">🎸</div>
        
        <div class="error-code">404</div>
        <h1>¡Esta página se perdió en el ensayo!</h1>
        
        <div class="message">
            <p style="margin-bottom: 0.8rem;">🎵 <strong>Parece que esta página ha desafinado y no la encontramos...</strong></p>
            <p>Puede que la URL esté mal escrita, que la página se haya movido de sitio, o simplemente que nunca haya existido. ¡No te preocupes! Vuelve al inicio y sigue tocando tu música favorita.</p>
        </div>

        <div class="btn-container">
            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                <span>🏠</span> Ir al inicio
            </a>
            <button onclick="history.back()" class="btn btn-secondary">
                <span>←</span> Volver atrás
            </button>
        </div>
    </div>
</body>
</html>
