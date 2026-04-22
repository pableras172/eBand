<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="eBand es la plataforma completa para gestionar tu banda de música. Organiza actuaciones, asistencias, repertorio, miembros y contratos en un solo lugar. Accede desde cualquier dispositivo.">
    <meta name="keywords" content="gestión bandas música, software bandas, administración musical, calendario actuaciones, asistencias músicos, contratos musicales, repertorio banda">
    <meta name="author" content="eBand">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="eBand - Sistema de Gestión para Bandas de Música">
    <meta property="og:description" content="La plataforma completa para organizar actuaciones, asistencias, repertorio y mucho más. Gestiona tu banda de música de forma profesional.">
    <meta property="og:image" content="{{ URL::to('/') }}/logo_e_band.png">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="eBand - Sistema de Gestión para Bandas de Música">
    <meta property="twitter:description" content="La plataforma completa para organizar actuaciones, asistencias, repertorio y mucho más. Gestiona tu banda de música de forma profesional.">
    <meta property="twitter:image" content="{{ URL::to('/') }}/logo_e_band.png">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ URL::to('/') }}/logo_e_band.png">
    <link rel="apple-touch-icon" href="{{ URL::to('/') }}/logo_e_band.png">
    
    <title>eBand - Sistema de Gestión para Bandas de Música | Gestiona tu banda profesionalmente</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo {
            height: 50px;
            width: 50px;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 10px 25px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-outline:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        /* Hero Section */
        .hero {
            margin-top: 80px;
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            color: white;
            padding: 2rem 5%;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ URL::to('/') }}/fondo_eband_head.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(3px);
            z-index: 1;
        }

        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.85) 0%, rgba(118, 75, 162, 0.85) 100%);
            z-index: 2;
        }

        .hero-content {
            max-width: 1200px;
            text-align: center;
            z-index: 10;
            position: relative;
        }

        .hero h1 {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.8s ease-out;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            animation: fadeInUp 1s ease-out;
        }

        .hero-logo {
            width: 150px;
            height: 150px;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
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

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        /* Notas musicales flotantes */
        .music-note {
            position: absolute;
            font-size: 2.5rem;
            opacity: 0.15;
            animation: float 20s infinite ease-in-out;
            color: white;
            z-index: 3;
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

        .note-1 { top: 10%; left: 10%; animation-delay: 0s; }
        .note-2 { top: 20%; right: 15%; animation-delay: 3s; }
        .note-3 { top: 60%; left: 12%; animation-delay: 6s; }
        .note-4 { bottom: 15%; right: 20%; animation-delay: 9s; }
        .note-5 { top: 40%; left: 8%; animation-delay: 12s; }

        /* Features Section */
        .features {
            padding: 5rem 5%;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #667eea;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Benefits Section */
        .benefits {
            padding: 5rem 5%;
            background: white;
            position: relative;
            overflow: hidden;
        }

        .benefits::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background-image: url('{{ URL::to('/') }}/ensayo.jpg');
            background-size: cover;
            background-position: center left;
            filter: blur(2px);
            opacity: 0.3;
            z-index: 1;
        }

        .benefits::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.7) 30%, rgba(255, 255, 255, 0) 100%);
            z-index: 2;
        }

        .benefits .section-title,
        .benefits .section-subtitle {
            position: relative;
            z-index: 3;
        }

        .benefits-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            position: relative;
            z-index: 3;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .benefit-icon {
            font-size: 2rem;
            color: #667eea;
            flex-shrink: 0;
        }

        .benefit-text h4 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .benefit-text p {
            color: #666;
            line-height: 1.5;
        }

        /* Gallery Section */
        .gallery {
            padding: 5rem 5%;
            background: #f8f9fa;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .gallery-item {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .gallery-image-container {
            width: 100%;
            padding-bottom: 100%; /* Aspect ratio 1:1 for square */
            position: relative;
            overflow: hidden;
            background: #f0f0f0;
        }

        .gallery-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-caption {
            padding: 1.5rem;
        }

        .gallery-caption h4 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: #667eea;
        }

        .gallery-caption p {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.4;
        }

        /* CTA Section */
        .cta {
            padding: 5rem 5%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ URL::to('/') }}/partitura.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(3px);
            opacity: 0.2;
            z-index: 1;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .cta p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            position: relative;
            z-index: 2;
        }

        .btn-cta {
            padding: 15px 40px;
            font-size: 1.2rem;
            background: white;
            color: #667eea;
            border: none;
            border-radius: 30px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            position: relative;
            z-index: 2;
        }

        .btn-cta:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 35px rgba(255, 255, 255, 0.3);
        }

        /* Contact Section */
        .contact {
            padding: 5rem 5%;
            background: #f8f9fa;
        }

        .contact-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Footer */
        .footer {
            background: #2d3748;
            color: white;
            padding: 2rem 5%;
            text-align: center;
        }

        .footer p {
            margin-bottom: 0.5rem;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.2rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .logo-text {
                display: none;
            }

            .nav-buttons {
                gap: 0.5rem;
            }

            .btn {
                padding: 8px 20px;
                font-size: 0.9rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .music-note {
                font-size: 1.5rem !important;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-section">
            <img class="logo" src="{{ URL::to('/') }}/logo_e_band.png" alt="eBand Logo" />
            <span class="logo-text">eBand</span>
        </div>
        <nav class="nav-buttons">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
            @endauth
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="music-note note-1">♪</div>
        <div class="music-note note-2">♫</div>
        <div class="music-note note-3">♬</div>
        <div class="music-note note-4">♭</div>
        <div class="music-note note-5">♯</div>

        <div class="hero-content">
            <img src="{{ URL::to('/') }}/logo_e_band.png" alt="eBand Logo" class="hero-logo">
            <h1>Gestiona tu banda de música</h1>
            <p>La plataforma completa para organizar actuaciones, asistencias, repertorio y mucho más</p>
            <a href="{{ route('register') }}" class="btn-cta">Comienza gratis</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2 class="section-title">Todo lo que necesitas en un solo lugar</h2>
        <p class="section-subtitle">Herramientas profesionales diseñadas específicamente para bandas de música</p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🎭</div>
                <h3>Gestión de Actuaciones</h3>
                <p>Calendario interactivo para organizar tus conciertos, actos oficiales y eventos. Filtra por fecha y mantén el historial de todas tus actuaciones.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">✅</div>
                <h3>Control de Asistencias</h3>
                <p>Sistema completo de asistencias por actuación con seguimiento detallado, disponibilidad de músicos y reportes automáticos.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Gestión de Miembros</h3>
                <p>Administra los músicos de tu banda, asigna instrumentos, controla asistencias y permisos de forma sencilla.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📋</div>
                <h3>Contratos y Documentos</h3>
                <p>Crea, almacena y gestiona contratos de actuación con generación automática de documentos PDF.</p>
            </div>

           

            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Aplicación Móvil</h3>
                <p>Accede desde cualquier dispositivo. Instala la PWA en tu móvil y consulta información offline.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🌍</div>
                <h3>Multiidioma</h3>
                <p>Interfaz disponible en varios idiomas. Cambia el idioma según las preferencias de tu banda para una experiencia personalizada.</p>
            </div>

            
    </section>

    <!-- Benefits Section -->
    <section class="benefits">
        <h2 class="section-title">¿Por qué elegir eBand?</h2>
        <p class="section-subtitle">Ventajas que marcan la diferencia</p>

        <div class="benefits-content">
            <div class="benefit-item">
                <div class="benefit-icon">⚡</div>
                <div class="benefit-text">
                    <h4>Fácil de usar</h4>
                    <p>Interfaz intuitiva diseñada para músicos, no necesitas ser experto en tecnología.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">🔒</div>
                <div class="benefit-text">
                    <h4>Seguro y privado</h4>
                    <p>Tus datos están protegidos con las últimas medidas de seguridad.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">☁️</div>
                <div class="benefit-text">
                    <h4>En la nube</h4>
                    <p>Accede desde cualquier lugar, en cualquier momento, desde cualquier dispositivo.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">📊</div>
                <div class="benefit-text">
                    <h4>Reportes detallados</h4>
                    <p>Estadísticas y reportes automáticos para tomar mejores decisiones.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">📦</div>
                <div class="benefit-text">
                    <h4>Control de inventario</h4>
                    <p>Gestiona instrumentos y material con estado, valor, responsables e histórico de movimientos.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">🎯</div>
                <div class="benefit-text">
                    <h4>Personalizable</h4>
                    <p>Adapta la plataforma a las necesidades específicas de tu banda.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon">💬</div>
                <div class="benefit-text">
                    <h4>Comunicación fluida</h4>
                    <p>Sistema de notificaciones y comentarios para mantener a todos informados.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery">
        <h2 class="section-title">Ve eBand en acción</h2>
        <p class="section-subtitle">Descubre la interfaz intuitiva y las funcionalidades de nuestra plataforma</p>

        <div class="gallery-grid">
            <div class="gallery-item">
                <div class="gallery-image-container">
                    <img src="{{ URL::to('/') }}/galeria/tablero_resumen.png" alt="Tablero de resumen" class="gallery-image">
                </div>
                <div class="gallery-caption">
                    <h4>Tablero Principal</h4>
                    <p>Vista general con todas las métricas importantes de tu banda en un solo lugar.</p>
                </div>
            </div>

            <div class="gallery-item">
                <div class="gallery-image-container">
                    <img src="{{ URL::to('/') }}/galeria/calendario.png" alt="Calendario de actuaciones" class="gallery-image">
                </div>
                <div class="gallery-caption">
                    <h4>Calendario de Actuaciones</h4>
                    <p>Visualiza y organiza todas tus actuaciones de forma clara y ordenada.</p>
                </div>
            </div>

            <div class="gallery-item">
                <div class="gallery-image-container">
                    <img src="{{ URL::to('/') }}/galeria/detalle_actuacion.png" alt="Detalle de actuación" class="gallery-image">
                </div>
                <div class="gallery-caption">
                    <h4>Detalle de Actuación</h4>
                    <p>Información completa de cada evento: lugar, fecha, asistencias y gestión completa.</p>
                </div>
            </div>

            <div class="gallery-item">
                <div class="gallery-image-container">
                    <img src="{{ URL::to('/') }}/galeria/resumen_actuaciones.png" alt="Resumen de actuaciones" class="gallery-image">
                </div>
                <div class="gallery-caption">
                    <h4>Resumen de Actuaciones</h4>
                    <p>Listado completo con filtros y estadísticas de todas tus actuaciones.</p>
                </div>
            </div>

            <div class="gallery-item">
                <div class="gallery-image-container">
                    <img src="{{ URL::to('/') }}/galeria/personalizar_actuaciones.png" alt="Personalizar actuaciones" class="gallery-image">
                </div>
                <div class="gallery-caption">
                    <h4>Configuración Flexible</h4>
                    <p>Personaliza campos y opciones según las necesidades de tu banda.</p>
                </div>
            </div>

            <div class="gallery-item">
                <div class="gallery-image-container">
                    <img src="{{ URL::to('/') }}/galeria/personalizacion_instrumentos.png" alt="Personalización de instrumentos" class="gallery-image">
                </div>
                <div class="gallery-caption">
                    <h4>Gestión de Instrumentos</h4>
                    <p>Define y asigna instrumentos personalizados para cada miembro.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <h2>¿Listo para mejorar la gestión de tu banda?</h2>
        <p>Únete a las bandas que ya están usando eBand para organizarse mejor</p>
        <a href="{{ route('register') }}" class="btn-cta">Crear cuenta gratis</a>
    </section>

    <!-- Contact Section -->
    <section class="contact">
        <h2 class="section-title">¿Tienes preguntas? Contáctanos</h2>
        <p class="section-subtitle">Estamos aquí para ayudarte a mejorar la gestión de tu banda</p>

        <div class="contact-container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" required value="{{ old('nombre') }}">
                    @error('nombre')
                        <small style="color: #e74c3c;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="banda">Nombre de la Banda *</label>
                    <input type="text" id="banda" name="banda" required value="{{ old('banda') }}">
                    @error('banda')
                        <small style="color: #e74c3c;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}">
                    @error('telefono')
                        <small style="color: #e74c3c;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}">
                    @error('email')
                        <small style="color: #e74c3c;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="informacion">Información / Consulta *</label>
                    <textarea id="informacion" name="informacion" required>{{ old('informacion') }}</textarea>
                    @error('informacion')
                        <small style="color: #e74c3c;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    {!! NoCaptcha::display() !!}
                    @error('g-recaptcha-response')
                        <small style="color: #e74c3c;">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">Enviar mensaje</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} eBand - Sistema de Gestión para Bandas de Música</p>
        <p>Desarrollado con ❤️ para la comunidad musical</p>
        <p style="margin-top: 1rem;">
            <a href="{{ route('login') }}">Iniciar sesión</a> | 
            <a href="{{ route('register') }}">Registrarse</a>
        </p>
    </footer>
    {!! NoCaptcha::renderJs() !!}
</body>
</html>
