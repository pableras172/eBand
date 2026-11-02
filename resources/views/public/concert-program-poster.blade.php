<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartel A4 - Programa de concierto</title>
    <style>
        :root {
            --paper-width: 210mm;
            --paper-height: 297mm;
            --ink: #111827;
            --muted: #4b5563;
            --line: #d1d5db;
            --bg: #f8fafc;
            --accent: #b91c1c;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font-family: Georgia, "Times New Roman", serif;
        }

        .actions {
            max-width: var(--paper-width);
            margin: 1.5rem auto 0;
            padding: 0 0.75rem;
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .actions a,
        .actions button {
            border: 1px solid var(--line);
            background: #fff;
            color: var(--ink);
            border-radius: 0.4rem;
            padding: 0.45rem 0.85rem;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
        }

        .poster {
            width: var(--paper-width);
            min-height: var(--paper-height);
            margin: 1rem auto 2rem;
            background: #fff;
            border: 1px solid var(--line);
            padding: 14mm 14mm 12mm;
            display: grid;
            grid-template-rows: auto auto 1fr auto;
            gap: 7mm;
        }

        .title {
            margin: 0;
            font-size: 13mm;
            line-height: 1.05;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .meta {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 3mm;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            padding: 3.5mm 0;
            font-size: 3.8mm;
        }

        .meta strong {
            color: var(--muted);
            font-size: 3.2mm;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            display: block;
            margin-bottom: 0.8mm;
        }

        .hero {
            display: grid;
            grid-template-columns: 40% 1fr;
            gap: 6mm;
            align-items: start;
        }

        .hero-image {
            width: 100%;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            border: 1px solid var(--line);
        }

        .participants {
            margin: 0 0 4mm;
            color: var(--muted);
            white-space: pre-line;
            font-size: 3.8mm;
        }

        .repertoire-title {
            margin: 0 0 3mm;
            color: var(--accent);
            font-size: 5.2mm;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .repertoire {
            margin: 0;
            padding-left: 5mm;
            display: grid;
            gap: 2.2mm;
        }

        .repertoire li {
            font-size: 3.8mm;
            line-height: 1.35;
            break-inside: avoid;
        }

        .piece-title {
            font-weight: 700;
        }

        .piece-author {
            color: var(--muted);
            font-style: italic;
        }

        .piece-details {
            display: block;
            color: var(--muted);
            font-size: 3.3mm;
            margin-top: 0.6mm;
        }

        .footer {
            border-top: 1px solid var(--line);
            padding-top: 3mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 4mm;
        }

        .footer small {
            color: var(--muted);
            font-size: 2.9mm;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .logos {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-items: center;
            gap: 3mm;
        }

        .logos img {
            height: 10mm;
            width: auto;
            object-fit: contain;
        }

        .empty {
            width: min(720px, calc(100% - 2rem));
            margin: 3rem auto;
            background: #fff;
            border: 1px solid var(--line);
            padding: 2rem;
            text-align: center;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        @media print {
            body {
                background: #fff;
            }

            .actions {
                display: none;
            }

            .poster {
                margin: 0;
                border: none;
                width: 210mm;
                min-height: 297mm;
                break-after: always;
            }
        }

        @media (max-width: 900px) {
            .poster {
                width: calc(100% - 1rem);
                min-height: auto;
                padding: 1rem;
            }

            .meta {
                grid-template-columns: 1fr;
            }

            .hero {
                grid-template-columns: 1fr;
            }

            .hero-image {
                max-height: 320px;
            }
        }
    </style>
</head>
<body>
    @if (! $program)
        <section class="empty">
            <h1>Cartel A4</h1>
            <p>Todavia no hay ningun programa publicado para generar el cartel.</p>
        </section>
    @else
        <div class="actions">
            @if (!empty($isAdminPreview))
                <a href="{{ route('concert-programs.index') }}">Volver a administracion</a>
            @else
                <a href="{{ route('concert-programs.public') }}">Volver al programa</a>
            @endif
            <button type="button" onclick="window.print()">Imprimir o guardar PDF</button>
        </div>

        <article class="poster">
            <header>
                <h1 class="title">{{ $program->title }}</h1>
            </header>

            <section class="meta">
                <div>
                    <strong>Fecha</strong>
                    <span>{{ optional($program->event_date)->format('d/m/Y') }}</span>
                </div>
                <div>
                    <strong>Hora</strong>
                    <span>{{ substr((string) $program->event_time, 0, 5) }}</span>
                </div>
                <div>
                    <strong>Ubicacion</strong>
                    <span>{{ $program->location }}</span>
                </div>
            </section>

            <section class="hero">
                <div>
                    @if ($program->image_path)
                        <img class="hero-image" src="{{ asset('storage/'.$program->image_path) }}" alt="Imagen del concierto">
                    @endif
                </div>

                <div>
                    @if ($program->participants)
                        <p class="participants">{{ $program->participants }}</p>
                    @endif

                    <h2 class="repertoire-title">Repertorio</h2>

                    <ol class="repertoire">
                        @foreach ($program->pieces as $piece)
                            <li>
                                <span class="piece-title">{{ $piece->title }}</span>
                                @if ($piece->author)
                                    <span class="piece-author"> - {{ $piece->author }}</span>
                                @endif
                                @if ($piece->details)
                                    <div class="piece-details">{!! $piece->details !!}</div>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            </section>

            @php
                $logos = array_filter([
                    $program->logo_1_path,
                    $program->logo_2_path,
                    $program->logo_3_path,
                ]);
            @endphp

            <footer class="footer">
                <small>Programa oficial del concierto</small>
                @if (count($logos) > 0)
                    <div class="logos">
                        @foreach ($logos as $logo)
                            <img src="{{ asset('storage/'.$logo) }}" alt="Logo colaborador">
                        @endforeach
                    </div>
                @endif
            </footer>
        </article>
    @endif
</body>
</html>
