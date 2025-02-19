<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 500 - Error en el servidor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #034460;
            color: #fff;
            text-align: center;
            padding: 5%;
            font-family: 'Arial', sans-serif;
            position: relative;
            overflow: hidden;
        }

        .logo {
            width: 75px;
            margin-bottom: 20px;
        }

        h1 {
            margin-top: 20px;
            font-size: 3rem;
            color: #FFD700;
        }

        .message {
            font-size: 1.5rem;
            margin: 30px 0;
            color: #fff;
        }

        .btn-back {
            background-color: #FFA500;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .btn-back:hover {
            transform: scale(1.05);
            background-color: #FF8800;
        }

        /* Animación de notas musicales */
        .note {
            position: absolute;
            font-size: 2.5rem;
            color: #FFD700;
            animation: float 4s infinite linear;
            opacity: 0.7;
        }

        @keyframes float {
            0% {
                transform: translateY(100%);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateY(-120%);
                opacity: 0;
            }
        }

        .note1 {
            left: 10%;
            animation-delay: 0s;
        }

        .note2 {
            left: 30%;
            animation-delay: 1s;
        }

        .note3 {
            left: 50%;
            animation-delay: 2s;
        }

        .note4 {
            left: 70%;
            animation-delay: 3s;
        }

        .note5 {
            left: 90%;
            animation-delay: 4s;
        }
    </style>
</head>
<body>
    <!-- Logo -->
    <img class="logo" src="{{ URL::to('/') }}/imagenes/logo.png" alt="Logo de la app" />

    <!-- Mensaje -->
    <h1>¡Error 500!</h1>
    <p class="message">Parece que la nota musical no ha sonado muy bien... 🎶</p>

    <!-- Botón para volver atrás -->
    <button class="btn-back" onclick="history.back()">⬅️ Volver a la página anterior</button>

    <!-- Notas musicales flotantes -->
    <div class="note note1">🎵</div>
    <div class="note note2">🎶</div>
    <div class="note note3">🎼</div>
    <div class="note note4">🎹</div>
    <div class="note note5">🎷</div>
</body>
</html>
