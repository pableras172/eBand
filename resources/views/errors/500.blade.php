<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error del servidor 🎵</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
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
            animation: shake 2s ease-in-out infinite;
        }

        @keyframes shake {
            0%, 100% {
                transform: rotate(0deg);
            }
            25% {
                transform: rotate(-15deg);
            }
            75% {
                transform: rotate(15deg);
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
            color: #fc4a1a;
        }

        .btn-primary:hover {
            background: #ffe8e0;
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
            animation: float 18s infinite ease-in-out;
            color: #fff;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            25% {
                transform: translateY(-35px) rotate(8deg);
            }
            50% {
                transform: translateY(0) rotate(0deg);
            }
            75% {
                transform: translateY(-20px) rotate(-8deg);
            }
        }

        .note-1 { top: 8%; left: 10%; animation-delay: 0s; font-size: 3rem; }
        .note-2 { top: 20%; right: 15%; animation-delay: 2.5s; font-size: 2rem; }
        .note-3 { top: 60%; left: 12%; animation-delay: 5s; font-size: 2.5rem; }
        .note-4 { bottom: 12%; right: 18%; animation-delay: 7.5s; font-size: 3rem; }
        .note-5 { top: 40%; left: 5%; animation-delay: 10s; font-size: 2rem; }
        .note-6 { bottom: 28%; left: 22%; animation-delay: 12.5s; font-size: 2.5rem; }
        .note-7 { top: 15%; right: 28%; animation-delay: 15s; font-size: 2rem; }
        .note-8 { bottom: 18%; right: 10%; animation-delay: 1s; font-size: 2.5rem; }

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

    <div class="container">
        <img class="logo" src="{{ URL::to('/') }}/imagenes/logo.png" alt="Logo" />
        
        <div class="emoji">🔧</div>
        
        <div class="error-code">500</div>
        <h1>¡El servidor se ha desafinado!</h1>
        
        <div class="message">
            <p style="margin-bottom: 0.8rem;">🎻 <strong>Algo no ha salido como esperábamos...</strong></p>
            <p>Ha ocurrido un error en nuestro servidor y no hemos podido procesar tu solicitud. Nuestro equipo técnico ya está trabajando para solucionarlo. Mientras tanto, prueba a recargar la página o vuelve más tarde. ¡Lo sentimos por las molestias!</p>
        </div>

        <div class="btn-container">
            <a href="{{ \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : url('/') }}" class="btn btn-primary">
                <span>🏠</span> Ir al inicio
            </a>
            <button onclick="location.reload()" class="btn btn-secondary">
                <span>↻</span> Recargar página
            </button>
        </div>
    </div>
</body>
</html>
