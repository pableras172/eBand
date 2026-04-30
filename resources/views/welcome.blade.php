<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="eBand es la plataforma completa para gestionar tu banda de música. Organiza actuaciones, asistencias, repertorio, miembros y contratos en un solo lugar. Accede desde cualquier dispositivo.">
    <meta name="keywords" content="gestión bandas música, software bandas, administración musical, calendario actuaciones, asistencias músicos, contratos musicales, repertorio banda">
    <meta name="author" content="eBand">
    <meta name="robots" content="index, follow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    
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

    <title>eBand — La sala de control de tu banda</title>
    <style>
        /* =============================
           RESET & BASE
           ============================= */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-void:      #f7f2e8;
            --bg-deep:      #efe6d6;
            --bg-surface:   #fffaf2;
            --bg-card:      rgba(255,250,242,0.86);
            --border-dim:   rgba(87, 68, 45, 0.12);
            --border-glow:  rgba(217,119,6,0.28);
            --gold:         #d97706;
            --gold-soft:    #f59e0b;
            --gold-dim:     rgba(217,119,6,0.10);
            --coral:        #e76f51;
            --text-primary: #1f2937;
            --text-secondary: #5f6c7b;
            --text-muted:   #8b7359;
            --nav-h:        72px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(245,158,11,0.16), transparent 28%),
                linear-gradient(180deg, #fbf7f0 0%, #f7f2e8 48%, #f1e9dc 100%);
            color: var(--text-primary);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* =============================
           KEYFRAMES
           ============================= */
        @keyframes breathe {
            0%, 100% { transform: scale(1);    opacity: 0.38; }
            50%       { transform: scale(1.12); opacity: 0.58; }
        }

        @keyframes breathe-slow {
            0%, 100% { transform: scale(1);    opacity: 0.20; }
            50%       { transform: scale(1.18); opacity: 0.32; }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        @keyframes float-note {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33%       { transform: translateY(-18px) rotate(8deg); }
            66%       { transform: translateY(-8px) rotate(-5deg); }
        }

        @keyframes pulse-ring {
            0%   { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245,158,11,0.35); }
            70%  { transform: scale(1);    box-shadow: 0 0 0 18px rgba(245,158,11,0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245,158,11,0); }
        }

        @keyframes slide-in-nav {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes reveal {
            from { opacity: 0; transform: translateY(40px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* =============================
           NAV
           ============================= */
        .nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--nav-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            background: rgba(255,250,242,0.78);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border-dim);
            z-index: 9000;
            animation: slide-in-nav 0.6s ease both;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-logo {
            width: 36px;
            height: 36px;
            border-radius: 8px;
        }

        .nav-wordmark {
            font-family: 'Syne', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        .nav-wordmark span {
            color: var(--gold);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* =============================
           BUTTONS
           ============================= */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            line-height: 1;
            white-space: nowrap;
        }

        .btn-ghost {
            background: rgba(255,255,255,0.35);
            color: var(--text-primary);
            border-color: var(--border-dim);
        }

        .btn-ghost:hover {
            color: var(--text-primary);
            border-color: rgba(217,119,6,0.22);
            background: rgba(255,255,255,0.72);
        }

        .btn-gold {
            background: var(--gold);
            color: #07090f;
            font-weight: 600;
        }

        .btn-gold:hover {
            background: var(--gold-soft);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(245,158,11,0.35);
        }

        .btn-gold-outline {
            background: transparent;
            color: var(--gold);
            border-color: rgba(245,158,11,0.5);
        }

        .btn-gold-outline:hover {
            background: var(--gold-dim);
            border-color: var(--gold);
        }

        .btn-lg {
            padding: 14px 30px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 10px;
        }

        /* =============================
           HERO
           ============================= */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: calc(var(--nav-h) + 4rem) 5% 6rem;
            overflow: hidden;
            isolation: isolate;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255, 250, 242, 0.185), rgba(247, 242, 232, 0.205)),
                url('{{ URL::to('/') }}/fondo_eband_head.jpg') center/cover no-repeat;
            filter: blur(8px);
            transform: scale(1.08);
            opacity: 0.78;
            z-index: 0;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.35), rgba(245,158,11,0.05));
            z-index: 0;
        }

        /* Breathing ambient orb — the heart of the experience */
        .hero-orb {
            position: absolute;
            top: 50%;
            left: 50%;
            width: min(700px, 120vw);
            height: min(700px, 120vw);
            transform: translate(-50%, -50%);
            border-radius: 50%;
            background: radial-gradient(circle at center,
                rgba(245,158,11,0.16) 0%,
                rgba(251,191,36,0.10) 30%,
                rgba(245,158,11,0.03) 60%,
                transparent 75%
            );
            animation: breathe 7s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        .hero-orb-outer {
            position: absolute;
            top: 50%;
            left: 50%;
            width: min(1100px, 200vw);
            height: min(1100px, 200vw);
            transform: translate(-50%, -50%);
            border-radius: 50%;
            background: radial-gradient(circle at center,
                rgba(251,191,36,0.08) 0%,
                transparent 65%
            );
            animation: breathe-slow 9s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        /* Floating music notes — barely visible, deeply calming */
        .hero-notes {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 1;
        }

        .note {
            position: absolute;
            font-size: 1.4rem;
            color: rgba(245,158,11,0.18);
            animation: float-note var(--dur, 22s) ease-in-out infinite;
            animation-delay: var(--delay, 0s);
            user-select: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 780px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 100px;
            background: rgba(255,250,242,0.72);
            border: 1px solid rgba(217,119,6,0.22);
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--gold-soft);
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 2rem;
            animation: fadeUp 0.6s ease 0.1s both;
        }

        .hero-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            animation: pulse-ring 2.4s ease infinite;
            flex-shrink: 0;
        }

        .hero-headline {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.6rem, 6.5vw, 4.6rem);
            font-weight: 800;
            line-height: 1.07;
            letter-spacing: -0.03em;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            animation: fadeUp 0.7s ease 0.2s both;
        }

        .hero-headline em {
            font-style: normal;
            color: var(--gold);
        }

        .hero-sub {
            font-size: clamp(1rem, 2.2vw, 1.2rem);
            color: var(--text-secondary);
            line-height: 1.7;
            max-width: 560px;
            margin: 0 auto 2.5rem;
            font-weight: 300;
            animation: fadeUp 0.7s ease 0.35s both;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeUp 0.7s ease 0.5s both;
        }

        .hero-scroll-hint {
            position: absolute;
            bottom: 2.5rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            z-index: 2;
            animation: fadeIn 1.2s ease 1.2s both;
        }

        .scroll-mouse {
            width: 22px;
            height: 36px;
            border: 1.5px solid var(--text-muted);
            border-radius: 12px;
            position: relative;
        }

        .scroll-mouse::after {
            content: '';
            position: absolute;
            top: 6px;
            left: 50%;
            transform: translateX(-50%);
            width: 3px;
            height: 6px;
            background: var(--text-muted);
            border-radius: 2px;
            animation: fadeUp 1.2s ease infinite;
        }

        /* =============================
           STATS STRIP
           ============================= */
        .stats-strip {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0;
            background: var(--bg-surface);
            border-top: 1px solid var(--border-dim);
            border-bottom: 1px solid var(--border-dim);
        }

        .stat-item {
            flex: 1;
            min-width: 160px;
            max-width: 240px;
            padding: 2rem 1.5rem;
            text-align: center;
            border-right: 1px solid var(--border-dim);
            transition: background 0.2s;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-item:hover {
            background: rgba(245,158,11,0.06);
        }

        .stat-num {
            font-family: 'Syne', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--gold);
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* =============================
           SECTION SHARED
           ============================= */
        .section {
            padding: 6rem 5%;
        }

        .section-inner {
            max-width: 1160px;
            margin: 0 auto;
        }

        .section-label {
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 1rem;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.15;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .section-sub {
            font-size: 1.05rem;
            color: var(--text-secondary);
            line-height: 1.7;
            max-width: 520px;
            font-weight: 300;
        }

        .section-header {
            margin-bottom: 3.5rem;
        }

        /* =============================
           FEATURES GRID
           ============================= */
        .features-bg {
            background: var(--bg-deep);
            position: relative;
            overflow: hidden;
        }

        .features-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(239, 230, 214, 0), rgba(239, 230, 214, 0)),
                url('{{ URL::to('/') }}/ensayo.jpg') center/cover no-repeat;
            filter: blur(8px);
            transform: scale(1.06);
            opacity: 0.6;
            z-index: 0;
        }

        .features-bg .section-inner {
            position: relative;
            z-index: 1;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5px;
            background: var(--border-dim);
            border: 1px solid var(--border-dim);
            border-radius: 16px;
            overflow: hidden;
        }

        .feat-card {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            padding: 2rem 2rem 2.2rem;
            transition: background 0.25s ease;
            position: relative;
        }

        .feat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 0;
            background: var(--gold);
            transition: height 0.3s ease;
        }

        .feat-card:hover {
            background: rgba(255,248,238,0.96);
        }

        .feat-card:hover::before {
            height: 100%;
        }

        .feat-icon {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            background: var(--gold-dim);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            font-size: 1.3rem;
            transition: transform 0.25s ease;
        }

        .feat-card:hover .feat-icon {
            transform: scale(1.08);
        }

        .feat-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.6rem;
        }

        .feat-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.65;
            font-weight: 300;
        }

        .feat-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 1rem;
        }

        .feat-tag {
            font-size: 0.72rem;
            padding: 3px 9px;
            border-radius: 100px;
            background: rgba(245,158,11,0.08);
            color: rgba(245,158,11,0.7);
            border: 1px solid rgba(245,158,11,0.15);
            font-weight: 400;
        }

        /* =============================
           HOW IT WORKS
           ============================= */
        .how-bg {
            background: var(--bg-void);
        }

        .steps {
            display: grid;
            grid-template-columns: 1fr 1px 1fr 1px 1fr;
            gap: 0;
            position: relative;
        }

        @media (max-width: 768px) {
            .steps {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .step-divider { display: none; }
        }

        .step-divider {
            background: var(--border-dim);
            align-self: stretch;
        }

        .step {
            padding: 0 2.5rem;
            text-align: center;
        }

        .step:first-child { padding-left: 0; }
        .step:last-child  { padding-right: 0; }

        .step-num {
            font-family: 'Syne', sans-serif;
            font-size: 4rem;
            font-weight: 800;
            color: rgba(245,158,11,0.12);
            line-height: 1;
            margin-bottom: 1rem;
        }

        .step-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.6rem;
        }

        .step-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.65;
            font-weight: 300;
        }

        /* =============================
           GALLERY
           ============================= */
        .gallery-bg {
            background: var(--bg-surface);
            overflow: hidden;
        }

        .gallery-scroll {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding-bottom: 1.5rem;
            scrollbar-width: thin;
            scrollbar-color: var(--border-dim) transparent;
        }

        .gallery-scroll::-webkit-scrollbar {
            height: 4px;
        }

        .gallery-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .gallery-scroll::-webkit-scrollbar-thumb {
            background: var(--border-dim);
            border-radius: 2px;
        }

        .gallery-item {
            flex: 0 0 320px;
            background: var(--bg-card);
            border: 1px solid var(--border-dim);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-6px);
            border-color: var(--border-glow);
        }

        .gallery-img-wrap {
            aspect-ratio: 16/10;
            background: var(--bg-deep);
            overflow: hidden;
        }

        .gallery-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .gallery-item:hover .gallery-img-wrap img {
            transform: scale(1.04);
        }

        .gallery-caption {
            padding: 1.1rem 1.4rem 1.4rem;
        }

        .gallery-caption h4 {
            font-family: 'Syne', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .gallery-caption p {
            font-size: 0.82rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* =============================
           BENEFITS BENTO
           ============================= */
        .benefits-bg {
            background: var(--bg-deep);
        }

        .bento {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: auto auto;
            gap: 1.5px;
            background: var(--border-dim);
            border: 1px solid var(--border-dim);
            border-radius: 16px;
            overflow: hidden;
        }

        .bento-cell {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            padding: 2rem;
            transition: background 0.2s ease;
        }

        .bento-cell:hover {
            background: rgba(255,248,238,0.96);
        }

        .bento-cell.wide {
            grid-column: span 2;
        }

        .bento-cell.tall {
            grid-row: span 2;
        }

        .bento-icon {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            display: block;
        }

        .bento-title {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .bento-desc {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.6;
            font-weight: 300;
        }

        .bento-large-num {
            font-family: 'Syne', sans-serif;
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--gold);
            line-height: 1;
            margin-bottom: 0.4rem;
        }

        @media (max-width: 768px) {
            .bento {
                grid-template-columns: 1fr;
            }

            .bento-cell.wide,
            .bento-cell.tall {
                grid-column: span 1;
                grid-row: span 1;
            }
        }

        /* =============================
           PWA STRIP
           ============================= */
        .pwa-strip {
            background: var(--bg-void);
            padding: 4rem 5%;
            border-top: 1px solid var(--border-dim);
            border-bottom: 1px solid var(--border-dim);
        }

        .pwa-inner {
            max-width: 1160px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 3rem;
            flex-wrap: wrap;
        }

        .pwa-left {
            flex: 1;
            min-width: 260px;
        }

        .pwa-right {
            flex: 0 0 auto;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .pwa-platform {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            background: var(--bg-surface);
            border: 1px solid var(--border-dim);
            border-radius: 10px;
            font-size: 0.88rem;
            color: var(--text-secondary);
            font-weight: 400;
        }

        .pwa-platform-icon {
            font-size: 1.2rem;
        }

        /* =============================
           CTA SECTION
           ============================= */
        .cta-section {
            background: var(--bg-surface);
            padding: 6rem 5%;
            text-align: center;
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255, 250, 242, 0), rgba(255, 250, 242, 0)),
                url('{{ URL::to('/') }}/partitura.jpg') center/cover no-repeat;
            filter: blur(5px);
            transform: scale(1.08);
            opacity: 0.75;
            z-index: 0;
        }

        .cta-glow {
            position: absolute;
            top: -50%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245,158,11,0.10) 0%, transparent 70%);
            pointer-events: none;
            animation: breathe 8s ease-in-out infinite;
        }

        .cta-section .section-title {
            max-width: 600px;
            margin: 0 auto 1rem;
        }

        .cta-section .section-sub {
            max-width: 440px;
            margin: 0 auto 2.5rem;
            text-align: center;
        }

        .cta-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* =============================
           CONTACT
           ============================= */
        .contact-bg {
            background: var(--bg-deep);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: start;
        }

        @media (max-width: 860px) {
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }
        }

        .contact-info-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .contact-info-desc {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.7;
            font-weight: 300;
            margin-bottom: 2rem;
        }

        .contact-benefit {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 1.2rem;
        }

        .contact-benefit-icon {
            width: 32px;
            height: 32px;
            background: var(--gold-dim);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .contact-benefit-text strong {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .contact-benefit-text span {
            font-size: 0.83rem;
            color: var(--text-muted);
        }

        .contact-form {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-dim);
            border-radius: 16px;
            padding: 2.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 520px) {
            .form-row { grid-template-columns: 1fr; }
        }

        .form-field {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 6px;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 11px 14px;
            background: rgba(255,255,255,0.72);
            border: 1px solid var(--border-dim);
            border-radius: 8px;
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 300;
            transition: border-color 0.2s ease, background 0.2s ease;
            outline: none;
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--text-muted);
        }

        .form-input:focus,
        .form-textarea:focus {
            border-color: rgba(245,158,11,0.5);
            background: rgba(245,158,11,0.03);
        }

        .form-textarea {
            resize: vertical;
            min-height: 110px;
        }

        .form-error {
            font-size: 0.78rem;
            color: var(--coral);
            margin-top: 4px;
        }

        .form-alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
        }

        .form-alert-success {
            background: rgba(52, 211, 153, 0.1);
            border: 1px solid rgba(52, 211, 153, 0.25);
            color: #047857;
        }

        .form-alert-error {
            background: rgba(251, 113, 133, 0.1);
            border: 1px solid rgba(251, 113, 133, 0.25);
            color: var(--coral);
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--gold);
            color: #07090f;
            border: none;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            background: var(--gold-soft);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(245,158,11,0.35);
        }

        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* =============================
           FOOTER
           ============================= */
        .footer {
            background: var(--bg-void);
            border-top: 1px solid var(--border-dim);
            padding: 2.5rem 5%;
        }

        .footer-inner {
            max-width: 1160px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-copy {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-links a {
            font-size: 0.82rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--gold);
        }

        /* =============================
           REVEAL ON SCROLL
           ============================= */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* =============================
           RESPONSIVE
           ============================= */
        @media (max-width: 640px) {
            .nav-wordmark {
                display: none;
            }

            .stat-item {
                min-width: 120px;
                padding: 1.5rem 1rem;
            }

            .stat-num {
                font-size: 1.6rem;
            }

            .step {
                padding: 0;
            }

            .section {
                padding: 4rem 5%;
            }

            .btn-lg {
                padding: 12px 22px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <!-- =====================
         NAV
         ===================== -->
    <nav class="nav">
        <a href="{{ url('/') }}" class="nav-brand">
            <img class="nav-logo" src="{{ URL::to('/') }}/logo_e_band.png" alt="eBand" />
            <span class="nav-wordmark">e<span>Band</span></span>
        </a>
        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-gold">Ir al dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost">Iniciar sesión</a>
            @endauth
        </div>
    </nav>

    <!-- =====================
         HERO
         ===================== -->
    <section class="hero">
        <!-- Breathing ambient orb -->
        <div class="hero-orb-outer"></div>
        <div class="hero-orb"></div>

        <!-- Floating notes -->
        <div class="hero-notes" aria-hidden="true">
            <span class="note" style="top:12%; left:8%; --dur:26s; --delay:0s;">♩</span>
            <span class="note" style="top:18%; right:12%; --dur:32s; --delay:4s; font-size:1rem;">♫</span>
            <span class="note" style="top:68%; left:6%; --dur:22s; --delay:8s; font-size:1.1rem;">♪</span>
            <span class="note" style="bottom:18%; right:9%; --dur:28s; --delay:2s;">♬</span>
            <span class="note" style="top:45%; left:4%; --dur:34s; --delay:14s; font-size:0.9rem;">♭</span>
            <span class="note" style="top:30%; right:5%; --dur:20s; --delay:6s; font-size:0.85rem;">♯</span>
            <span class="note" style="bottom:30%; left:15%; --dur:38s; --delay:10s; font-size:0.8rem;">𝄞</span>
        </div>

        <div class="hero-content">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Hecho para bandas que quieren ir tranquilas
            </div>
            <h1 class="hero-headline">
                Menos caos, mas musica<br>para <em>tu banda</em>
            </h1>
            <p class="hero-sub">
                eBand te ayuda a organizar actuaciones, contratos, miembros e inventario
                sin hojas sueltas, sin mensajes perdidos y sin complicarte el dia.
                Todo mas claro, mas cercano y accesible desde cualquier dispositivo.
            </p>
            <div class="hero-actions">
                <a href="{{ route('login') }}" class="btn btn-gold btn-lg">Empezar la demo</a>
                <a href="#features" class="btn btn-gold-outline btn-lg">Ver características</a>
            </div>
        </div>

        <div class="hero-scroll-hint" aria-hidden="true">
            <div class="scroll-mouse"></div>
            Descubre
        </div>
    </section>

    <!-- =====================
         STATS
         ===================== -->
    <div class="stats-strip">
        <div class="stat-item">
            <div class="stat-num">360°</div>
            <div class="stat-label">Gestión integral</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">PWA</div>
            <div class="stat-label">Instala en tu móvil</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">∞</div>
            <div class="stat-label">Miembros y actuaciones</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">PDF</div>
            <div class="stat-label">Contratos automáticos</div>
        </div>
    </div>

    <!-- =====================
         FEATURES
         ===================== -->
    <section class="section features-bg" id="features">
        <div class="section-inner">
            <div class="section-header reveal">
                <div class="section-label">Características</div>
                <h2 class="section-title">Todo lo que necesitas para llevar la banda con calma</h2>
                <p class="section-sub">Herramientas pensadas para el dia a dia real de ensayos, conciertos, papeleo y coordinacion entre personas.</p>
            </div>

            <div class="features-grid reveal">
                <div class="feat-card">
                    <div class="feat-icon">🎭</div>
                    <div class="feat-title">Gestión de Actuaciones</div>
                    <div class="feat-desc">Calendario interactivo con filtrado por fecha, marcado de actos oficiales con indicadores visuales y control de visibilidad.</div>
                    <div class="feat-tags">
                        <span class="feat-tag">Calendario</span>
                        <span class="feat-tag">Historial</span>
                        <span class="feat-tag">Actos oficiales</span>
                    </div>
                </div>

                <div class="feat-card">
                    <div class="feat-icon">✅</div>
                    <div class="feat-title">Control de Asistencias</div>
                    <div class="feat-desc">Seguimiento por actuación, disponibilidad de músicos y reportes automáticos para no perder el detalle de ningún ensayo ni concierto.</div>
                    <div class="feat-tags">
                        <span class="feat-tag">Reportes</span>
                        <span class="feat-tag">Por músico</span>
                    </div>
                </div>

                <div class="feat-card">
                    <div class="feat-icon">👥</div>
                    <div class="feat-title">Gestión de Miembros</div>
                    <div class="feat-desc">Autenticación segura con roles y permisos, verificación de email y restablecimiento de contraseña personalizados. Administra instrumentos y accesos fácilmente.</div>
                    <div class="feat-tags">
                        <span class="feat-tag">Roles</span>
                        <span class="feat-tag">Permisos</span>
                        <span class="feat-tag">Fortify</span>
                    </div>
                </div>

                <div class="feat-card">
                    <div class="feat-icon">📋</div>
                    <div class="feat-title">Contratos y Documentos</div>
                    <div class="feat-desc">Genera contratos de actuación. Consulta el historial de contratos desde la administración.</div>
                    <div class="feat-tags">
                        <span class="feat-tag">Automático</span>
                    </div>
                </div>

                <div class="feat-card">
                    <div class="feat-icon">📦</div>
                    <div class="feat-title">Control de Inventario</div>
                    <div class="feat-desc">Gestiona instrumentos y material con estado, valor económico, responsables asignados e histórico completo de movimientos.</div>
                    <div class="feat-tags">
                        <span class="feat-tag">Instrumentos</span>
                        <span class="feat-tag">Histórico</span>
                        <span class="feat-tag">Responsables</span>
                    </div>
                </div>

                <div class="feat-card">
                    <div class="feat-icon">🎁</div>
                    <div class="feat-title">Sistema de anuncios</div>
                    <div class="feat-desc">Crea anuncios para que cuando los usuarios accedan a la app estén informados de novedades y eventos importantes.</div>
                    <div class="feat-tags">
                        <span class="feat-tag">Anuncios</span>
                        <span class="feat-tag">Novedades</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================
         HOW IT WORKS
         ===================== -->
    <section class="section how-bg">
        <div class="section-inner">
            <div class="section-header reveal" style="text-align:center; max-width:480px; margin-left:auto; margin-right:auto; margin-bottom:3.5rem;">
                <div class="section-label">Cómo funciona</div>
                <h2 class="section-title">En marcha en minutos</h2>
            </div>

            <div class="steps reveal">
                <div class="step">
                    <div class="step-num">01</div>
                    <div class="step-title">Crea tu banda</div>
                    <div class="step-desc">Registra tu cuenta, personaliza el perfil de tu banda y configura los instrumentos y secciones.</div>
                </div>
                <div class="step-divider"></div>
                <div class="step">
                    <div class="step-num">02</div>
                    <div class="step-title">Invita a los miembros</div>
                    <div class="step-desc">Cada músico recibe acceso con su rol: director, administrativo o músico. Todo bajo control.</div>
                </div>
                <div class="step-divider"></div>
                <div class="step">
                    <div class="step-num">03</div>
                    <div class="step-title">Gestiona desde el día 1</div>
                    <div class="step-desc">Crea actuaciones, registra asistencias, genera contratos y controla el inventario. Todo en uno.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================
         GALLERY
         ===================== -->
    <section class="section gallery-bg">
        <div class="section-inner">
            <div class="section-header reveal">
                <div class="section-label">Interfaz</div>
                <h2 class="section-title">Ve eBand en acción</h2>
                <p class="section-sub">Diseño responsive para que puedas trabajar tanto en dispositivos móviles como en escritorio.</p>
            </div>
        </div>

        <div class="section-inner">
            <div class="gallery-scroll reveal">
                <div class="gallery-item">
                    <div class="gallery-img-wrap">
                        <img src="{{ URL::to('/') }}/galeria/anuncios.png" alt="Anuncios" loading="lazy">
                    </div>
                    <div class="gallery-caption">
                        <h4>Anuncios a usuarios</h4>
                        <p>Anuncios para mantener a los miembros informados sobre novedades y eventos importantes.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrap">
                        <img src="{{ URL::to('/') }}/galeria/tablero_resumen.png" alt="Tablero principal" loading="lazy">
                    </div>
                    <div class="gallery-caption">
                        <h4>Tablero Principal</h4>
                        <p>Métricas clave de la banda en un vistazo.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrap">
                        <img src="{{ URL::to('/') }}/galeria/calendario.png" alt="Calendario de actuaciones" loading="lazy">
                    </div>
                    <div class="gallery-caption">
                        <h4>Calendario de Actuaciones</h4>
                        <p>Visualiza y organiza todos los eventos con claridad.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrap">
                        <img src="{{ URL::to('/') }}/galeria/detalle_actuacion.png" alt="Detalle de actuación" loading="lazy">
                    </div>
                    <div class="gallery-caption">
                        <h4>Detalle de Actuación</h4>
                        <p>Información completa: lugar, asistencias y gestión.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrap">
                        <img src="{{ URL::to('/') }}/galeria/resumen_actuaciones.png" alt="Resumen de actuaciones" loading="lazy">
                    </div>
                    <div class="gallery-caption">
                        <h4>Resumen de Actuaciones</h4>
                        <p>Listado completo con filtros y estadísticas.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrap">
                        <img src="{{ URL::to('/') }}/galeria/inventario.png" alt="Resumen de actuaciones" loading="lazy">
                    </div>
                    <div class="gallery-caption">
                        <h4>Gestión de Inventario</h4>
                        <p>Controla en todo momento el inventario de tu banda y los músicos que tienen asignados los instrumentos.</p>
                    </div>
                </div> 
                <div class="gallery-item">
                    <div class="gallery-img-wrap">
                        <img src="{{ URL::to('/') }}/galeria/sugerencias.png" alt="Configuración flexible" loading="lazy">
                    </div>
                    <div class="gallery-caption">
                        <h4>Buzón de sugerencias</h4>
                        <p>Escucha a los músicos.</p>
                    </div>
                </div>               
                <div class="gallery-item">
                    <div class="gallery-img-wrap">
                        <img src="{{ URL::to('/') }}/galeria/personalizar_actuaciones.png" alt="Configuración flexible" loading="lazy">
                    </div>
                    <div class="gallery-caption">
                        <h4>Configuración Flexible</h4>
                        <p>Personaliza campos según tu banda.</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-img-wrap">
                        <img src="{{ URL::to('/') }}/galeria/personalizacion_instrumentos.png" alt="Gestión de instrumentos" loading="lazy">
                    </div>
                    <div class="gallery-caption">
                        <h4>Gestión de Instrumentos</h4>
                        <p>Define y asigna instrumentos personalizados.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================
         BENEFITS BENTO
         ===================== -->
    <section class="section benefits-bg">
        <div class="section-inner">
            <div class="section-header reveal">
                <div class="section-label">Por qué eBand</div>
                <h2 class="section-title">Diseñado para músicos,<br>no para administradores</h2>
            </div>

            <div class="bento reveal">
                <div class="bento-cell wide">
                    <span class="bento-icon">⚡</span>
                    <div class="bento-title">Fácil desde el primer día</div>
                    <div class="bento-desc">Interfaz intuitiva pensada para músicos. No necesitas formación técnica para tener tu banda perfectamente organizada.</div>
                </div>
                <div class="bento-cell">
                    <span class="bento-icon">🔒</span>
                    <div class="bento-title">Seguro y privado</div>
                    <div class="bento-desc">Autenticación robusta con Laravel Fortify. Tus datos y los de tu banda están protegidos.</div>
                </div>
                <div class="bento-cell">
                    <span class="bento-icon">☁️</span>
                    <div class="bento-title">Siempre disponible</div>
                    <div class="bento-desc">Accede desde cualquier dispositivo, en cualquier momento. En la nube, sin instalaciones.</div>
                </div>
                <div class="bento-cell">
                    <span class="bento-icon">📊</span>
                    <div class="bento-title">Reportes automáticos</div>
                    <div class="bento-desc">Estadísticas de asistencia, actuaciones y rendimiento para tomar mejores decisiones.</div>
                </div>
                <div class="bento-cell">
                    <div class="bento-large-num">+3</div>
                    <div class="bento-title">idiomas disponibles</div>
                    <div class="bento-desc">Cambia el idioma de la interfaz según las preferencias de cada miembro.</div>
                </div>
                <div class="bento-cell">
                    <span class="bento-icon">💬</span>
                    <div class="bento-title">Comunicación fluida</div>
                    <div class="bento-desc">Notificaciones y sistema de comentarios para mantener a toda la banda al día.</div>
                </div>
                <div class="bento-cell">
                    <span class="bento-icon">🎯</span>
                    <div class="bento-title">100% personalizable</div>
                    <div class="bento-desc">Adapta tipos de actuación, instrumentos y flujos a cómo funciona tu banda.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================
         PWA STRIP
         ===================== -->
    <div class="pwa-strip">
        <div class="pwa-inner reveal">
            <div class="pwa-left">
                <div class="section-label">App Móvil</div>
                <h3 style="font-family:'Syne',sans-serif; font-size:1.6rem; font-weight:700; color:var(--text-primary); margin-bottom:0.6rem; letter-spacing:-0.02em;">
                    Instálala en tu dispositivo
                </h3>
                <p style="font-size:0.9rem; color:var(--text-secondary); line-height:1.65; font-weight:300; max-width:380px;">
                    eBand es una Progressive Web App. Instálala en cualquier dispositivo y accede aunque no tengas conexión.
                </p>
            </div>
            <div class="pwa-right">
                <div class="pwa-platform">
                    <span class="pwa-platform-icon">🤖</span>
                    Android
                </div>
                <div class="pwa-platform">
                    <span class="pwa-platform-icon">🍎</span>
                    iOS
                </div>
                <div class="pwa-platform">
                    <span class="pwa-platform-icon">🪟</span>
                    Windows
                </div>
            </div>
        </div>
    </div>

    <!-- =====================
         CTA
         ===================== -->
    <section class="cta-section">
        <div class="cta-glow" aria-hidden="true"></div>
        <div style="position:relative; z-index:2;">
            <div class="section-label" style="text-align:center; margin-bottom:1rem;">¿Listo?</div>
            <h2 class="section-title" style="text-align:center;">Tu banda merece una<br><em style="font-style:normal; color:var(--gold);">gestion mas sencilla y humana</em></h2>
            <p class="section-sub" style="text-align:center; margin-top:0.5rem;">Prueba eBand y descubre una forma mas clara de coordinar a tu gente, preparar actuaciones y tener todo a mano.</p>
            <div class="cta-actions" style="margin-top:2.5rem;">                
                <a href="{{ route('login') }}" class="btn btn-ghost btn-lg">Empezar la demo</a>
            </div>
        </div>
    </section>

    <!-- =====================
         CONTACT
         ===================== -->
    <section class="section contact-bg" id="contact">
        <div class="section-inner">
            <div class="contact-grid">
                <div class="reveal">
                    <div class="section-label">Contacto</div>
                    <h2 class="contact-info-title">Hablamos cuando quieras,<br>sin rodeos</h2>
                    <p class="contact-info-desc">Cuéntanos como os organizais ahora y te enseñamos de manera cercana como eBand puede encajar en vuestra banda desde el primer dia.</p>

                    <div class="contact-benefit">
                        <div class="contact-benefit-icon">⚡</div>
                        <div class="contact-benefit-text">
                            <strong>Respuesta rápida</strong>
                            <span>Te respondemos pronto y con una propuesta clara</span>
                        </div>
                    </div>
                    <div class="contact-benefit">
                        <div class="contact-benefit-icon">🎯</div>
                        <div class="contact-benefit-text">
                            <strong>Asesoramiento personalizado</strong>
                            <span>Te enseñamos lo que de verdad os puede ahorrar tiempo</span>
                        </div>
                    </div>
                    <div class="contact-benefit">
                        <div class="contact-benefit-icon">🎁</div>
                        <div class="contact-benefit-text">
                            <strong>Sin compromiso</strong>
                            <span>Puedes probarlo y valorar si encaja con vosotros</span>
                        </div>
                    </div>
                </div>

                <div class="contact-form reveal">
                    @if(session('success'))
                        <div class="form-alert form-alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="form-alert form-alert-error">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label" for="nombre">Nombre *</label>
                                <input class="form-input" type="text" id="nombre" name="nombre" required value="{{ old('nombre') }}" placeholder="Tu nombre">
                                @error('nombre')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="banda">Banda *</label>
                                <input class="form-input" type="text" id="banda" name="banda" required value="{{ old('banda') }}" placeholder="Nombre de tu banda">
                                @error('banda')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label" for="email">Email *</label>
                                <input class="form-input" type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="tu@email.com">
                                @error('email')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="telefono">Teléfono</label>
                                <input class="form-input" type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="+34 600 000 000">
                                @error('telefono')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="informacion">Consulta *</label>
                            <textarea class="form-textarea" id="informacion" name="informacion" required placeholder="Cuéntanos sobre tu banda y en qué podemos ayudarte...">{{ old('informacion') }}</textarea>
                            @error('informacion')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-field">
                            {!! NoCaptcha::display() !!}
                            @error('g-recaptcha-response')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit">Enviar mensaje</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- =====================
         FOOTER
         ===================== -->
    <footer class="footer">
        <div class="footer-inner">
            <div>
                <div class="nav-wordmark" style="font-size:1rem; margin-bottom:4px; font-family:'Syne',sans-serif; font-weight:800; color:var(--text-primary);">e<span style="color:var(--gold)">Band</span></div>
                <p class="footer-copy">&copy; {{ date('Y') }} eBand — Sistema de Gestión para Bandas de Música</p>
            </div>
            <div class="footer-links">
                <a href="{{ route('login') }}">Iniciar sesión</a>
                <a href="{{ route('register') }}">Crear cuenta</a>
                <a href="#contact">Contacto</a>
            </div>
        </div>
    </footer>

    {!! NoCaptcha::renderJs() !!}

    <script>
        // Scroll reveal
        (function () {
            const els = document.querySelectorAll('.reveal');
            const io = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            io.unobserve(entry.target);
                        }
                    });
                },
                { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
            );
            els.forEach((el) => io.observe(el));
        })();

        // Smooth anchor scroll
        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
