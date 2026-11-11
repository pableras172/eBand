<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    
    <title>Política de Privacidad · eBand</title>
    <meta name="title" content="Política de Privacidad · eBand">
    <meta name="description" content="Política de Privacidad de eBand. Información sobre el tratamiento de datos personales, roles de las agrupaciones musicales como Responsables del Tratamiento y eBand como Encargado del Tratamiento (RGPD).">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/politica-privacidad') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/politica-privacidad') }}">
    <meta property="og:title" content="Política de Privacidad · eBand">
    <meta property="og:description" content="Información legal y protección de datos en la plataforma eBand.">
    <meta property="og:image" content="{{ asset('logo_e_band.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo_e_band.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo_e_band.png') }}">

    <!-- Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

    <!-- Header / Navbar simplificada -->
    <header class="sticky top-0 z-40 w-full border-b border-slate-200/80 bg-white/90 backdrop-blur-md pt-safe">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="group flex items-center gap-3">
                <div class="relative flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-tr from-blue-700 via-indigo-600 to-amber-500 p-0.5 shadow-md shadow-indigo-500/15 transition-transform group-hover:scale-105">
                    <img src="{{ asset('logo_e_band.png') }}" alt="eBand Logo" class="h-full w-full rounded-[10px] object-cover bg-white" width="44" height="44">
                </div>
                <div class="flex flex-col">
                    <span class="font-heading text-2xl font-extrabold tracking-tight text-slate-900">
                        e<span class="text-blue-700">Band</span><span class="text-amber-500">.</span>
                    </span>
                    <span class="text-[10px] font-semibold tracking-wider uppercase text-slate-500">Bandas · Charangas · Corales</span>
                </div>
            </a>

            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-blue-700 hover:border-slate-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver al inicio</span>
                </a>
            </div>
        </div>
    </header>

    <main class="py-12 sm:py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            
            <!-- Encabezado del documento -->
            <div class="border-b border-slate-200 pb-8">
                <div class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-800 mb-4">
                    <span>Marco RGPD (UE 2016/679) & LOPDGDD 3/2018</span>
                </div>
                <h1 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight">
                    Política de Privacidad y Protección de Datos
                </h1>
                <p class="mt-4 text-sm sm:text-base text-slate-600 leading-relaxed">
                    Última actualización: {{ date('d/m/Y') }}. Esta política detalla de forma clara y transparente cómo se tratan los datos personales en la plataforma eBand, estableciendo con precisión la distinción legal de responsabilidades entre las agrupaciones musicales usuarias y nuestra plataforma.
                </p>
            </div>

            <!-- Destacado Legal Clave: Las Bandas son las Responsables -->
            <div class="my-8 rounded-2xl border-2 border-blue-500/30 bg-blue-50/50 p-6 sm:p-8">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-white text-2xl shadow-md">
                        🏛️
                    </div>
                    <div>
                        <h2 class="font-heading text-lg sm:text-xl font-bold text-blue-950">
                            Principio Fundamental: Las Agrupaciones Musicales son las Responsables de los Datos
                        </h2>
                        <p class="mt-2 text-xs sm:text-sm text-blue-900/90 leading-relaxed">
                            En el funcionamiento de eBand, <strong>cada agrupación musical (sociedad musical, banda de música, charanga, coro u orquesta) actúa como Responsable del Tratamiento</strong> de los datos de sus integrantes, músicos, socios, alumnos y familias. <strong>eBand actúa única y exclusivamente como Encargado del Tratamiento</strong> (Art. 28 RGPD), prestando el servicio tecnológico de software y almacenamiento en la nube bajo las directrices de la agrupación.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cuerpo del texto legal -->
            <div class="prose prose-slate max-w-none space-y-8 text-sm sm:text-base leading-relaxed text-slate-700">

                <!-- 1. Identificación y Alcance -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
                    <h2 class="font-heading text-xl font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>1.</span> Identificación de la Plataforma y Alcance
                    </h2>
                    <p class="mt-4">
                        La plataforma <strong>eBand</strong> (accesible a través de <code>https://eband.app</code> y sus respectivos subdominios asignados a agrupaciones musicales) es una solución tecnológica tipo Software as a Service (SaaS) diseñada para la gestión interna de agrupaciones musicales: control de convocatorias y disponibilidad de ensayos, actuaciones, inventario de material y uniformes, control parental para familias, actividades y liquidaciones de actuaciones.
                    </p>
                    <p class="mt-3">
                        La presente Política de Privacidad es aplicable a todas las personas que naveguen por la web pública de eBand, a las personas de contacto de las agrupaciones musicales que contraten o soliciten información, y a los usuarios que utilicen el software como integrantes o tutores autorizados.
                    </p>
                </section>

                <!-- 2. Diferenciación de Roles -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
                    <h2 class="font-heading text-xl font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>2.</span> Roles en el Tratamiento de Datos (RGPD)
                    </h2>
                    
                    <div class="mt-5 space-y-6">
                        <!-- Subrol A: La Agrupación -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-5">
                            <h3 class="font-heading text-base font-bold text-slate-900 flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                A. La Agrupación Musical como RESPONSABLE DEL TRATAMIENTO
                            </h3>
                            <p class="mt-2 text-sm text-slate-600">
                                La entidad musical (asociación, sociedad musical, charanga o coro) que contrata el servicio es quien decide qué datos personales recopilar de sus músicos, socios, profesores o alumnos, con qué fines se utilizan y bajo qué legitimación (estatutaria, asociativa, contractual o mediante consentimiento explícito).
                            </p>
                            <ul class="mt-3 list-disc pl-5 text-xs sm:text-sm text-slate-600 space-y-1">
                                <li>Es responsabilidad de la agrupación musical informar a sus integrantes y recabar las autorizaciones correspondientes para darles de alta en la plataforma.</li>
                                <li>La agrupación es la encargada directa de atender y tramitar las solicitudes de ejercicio de derechos (acceso, rectificación, supresión) de sus integrantes.</li>
                            </ul>
                        </div>

                        <!-- Subrol B: eBand como Encargado -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-5">
                            <h3 class="font-heading text-base font-bold text-slate-900 flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-blue-600"></span>
                                B. eBand como ENCARGADO DEL TRATAMIENTO
                            </h3>
                            <p class="mt-2 text-sm text-slate-600">
                                De conformidad con el artículo 28 del Reglamento General de Protección de Datos (RGPD), eBand procesa los datos personales alojados en la plataforma exclusivamente por cuenta de la agrupación musical y para la prestación del servicio contratado.
                            </p>
                            <ul class="mt-3 list-disc pl-5 text-xs sm:text-sm text-slate-600 space-y-1">
                                <li><strong>No vendemos ni comercializamos</strong> los datos de los músicos ni de las agrupaciones a terceros.</li>
                                <li><strong>No utilizamos los datos</strong> para fines publicitarios propios ni de terceros anunciantes.</li>
                                <li>Mantenemos el secreto profesional y deber de confidencialidad de todo el personal con acceso al soporte técnico.</li>
                                <li>Garantizamos el aislamiento de los datos de cada agrupación musical mediante arquitectura segura independiente (multi-tenant).</li>
                            </ul>
                        </div>

                        <!-- Subrol C: eBand como Responsable directo -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-5">
                            <h3 class="font-heading text-base font-bold text-slate-900 flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                                C. eBand como Responsable Únicamente de Clientes Directos y Leads
                            </h3>
                            <p class="mt-2 text-sm text-slate-600">
                                eBand actúa como Responsable del Tratamiento únicamente sobre los datos de contacto y facturación de las personas representantes de las juntas directivas que solicitan demos, piden información comercial o formalizan la contratación y pago anual de la licencia de 150€/año.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- 3. Tipología de Datos Tratados -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
                    <h2 class="font-heading text-xl font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>3.</span> Tipología de Datos Gestionados en la Plataforma
                    </h2>
                    <p class="mt-4">
                        La plataforma permite a las agrupaciones gestionar las siguientes categorías de datos estrictamente necesarios para su operativa:
                    </p>
                    <ul class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm text-slate-700">
                        <li class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-blue-600 font-bold">✓</span> Datos de identificación: nombre, apellidos, email y teléfono.
                        </li>
                        <li class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-blue-600 font-bold">✓</span> Datos musicales: instrumento, cuerda vocal, sección o rol directivo.
                        </li>
                        <li class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-blue-600 font-bold">✓</span> Asistencia y disponibilidad: respuestas a convocatorias de ensayos y conciertos.
                        </li>
                        <li class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-blue-600 font-bold">✓</span> Inventario: uniformes asignados (tallas), material o instrumentos cedidos.
                        </li>
                        <li class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-blue-600 font-bold">✓</span> Vinculación familiar: relación entre tutores legales y menores de edad.
                        </li>
                        <li class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-blue-600 font-bold">✓</span> Liquidaciones: registro interno de reparto de honorarios por actuación (charangas/bolos).
                        </li>
                    </ul>
                </section>

                <!-- 4. Menores de Edad y Control Parental -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
                    <h2 class="font-heading text-xl font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>4.</span> Protección Especial de Menores y Control Parental
                    </h2>
                    <p class="mt-4">
                        Gran parte de los integrantes de bandas de música, escuelas de educandos y agrupaciones juveniles son menores de edad. eBand incluye la funcionalidad específica de <strong>Control Parental</strong> para que los padres, madres o tutores legales puedan:
                    </p>
                    <ul class="mt-3 list-disc pl-5 space-y-1 text-xs sm:text-sm text-slate-600">
                        <li>Supervisar de forma centralizada las convocatorias, ensayos y salidas de sus hijos.</li>
                        <li>Confirmar la disponibilidad y asistencia de los menores a los actos.</li>
                        <li>Inscribirlos en actividades de convivencia, viajes o cursos organizados por la entidad.</li>
                    </ul>
                    <p class="mt-3 text-xs sm:text-sm text-slate-500 italic bg-amber-50 p-3 rounded-xl border border-amber-200 text-amber-900">
                        Recordatorio: Cada agrupación musical es responsable de contar con el consentimiento o autorización expresa de los progenitores o tutores legales de los menores antes de incorporarlos a la base de datos de la plataforma.
                    </p>
                </section>

                <!-- 5. Seguridad y Ubicación de los Servidores -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
                    <h2 class="font-heading text-xl font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>5.</span> Medidas de Seguridad y Alojamiento en la UE
                    </h2>
                    <p class="mt-4">
                        eBand implementa medidas de seguridad técnicas y organizativas para salvaguardar la confidencialidad, integridad y disponibilidad de la información:
                    </p>
                    <ul class="mt-3 list-disc pl-5 space-y-1.5 text-xs sm:text-sm text-slate-600">
                        <li><strong>Servidores en la Unión Europea</strong>: Toda la infraestructura, bases de datos y copias de seguridad están alojadas en centros de datos ubicados en territorio europeo, cumpliendo íntegramente las garantías del RGPD.</li>
                        <li><strong>Cifrado de comunicaciones</strong>: Transferencia de datos cifrada de extremo a extremo mediante certificados SSL/TLS (HTTPS).</li>
                        <li><strong>Control de acceso por roles</strong>: Los miembros solo visualizan los datos necesarios para su participación, mientras que los administradores y directores disponen de permisos según su cargo.</li>
                        <li><strong>Copias de seguridad automáticas</strong> continuas para prevenir cualquier pérdida accidental de datos.</li>
                    </ul>
                </section>

                <!-- 6. Ejercicio de Derechos -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
                    <h2 class="font-heading text-xl font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>6.</span> Ejercicio de Derechos (Acceso, Rectificación, Supresión y Oposición)
                    </h2>
                    <p class="mt-4">
                        La normativa vigente en protección de datos reconoce los derechos de Acceso, Rectificación, Supresión, Limitación del tratamiento, Portabilidad y Oposición. El cauce para ejercerlos depende de tu relación:
                    </p>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                            <h4 class="font-bold text-slate-900 text-sm">Si eres Músico, Socio, Alumno o Familiar:</h4>
                            <p class="mt-2 text-xs text-slate-600">
                                Al ser tu <strong>agrupación musical la Responsable del Tratamiento</strong>, debes solicitar el ejercicio de tus derechos directamente ante la junta directiva o administración de tu banda, coro o charanga. Ellos disponen en eBand de las herramientas para actualizar, descargar o eliminar tu perfil y el de tus hijos.
                            </p>
                        </div>
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                            <h4 class="font-bold text-slate-900 text-sm">Si eres Cliente o Contacto de eBand:</h4>
                            <p class="mt-2 text-xs text-slate-600">
                                Para cualquier consulta relativa a la suscripción, facturación o datos de contacto recogidos a través de la web principal, puedes escribirnos directamente a nuestro correo de contacto o a través del formulario de soporte.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- 7. Conservación de Datos -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
                    <h2 class="font-heading text-xl font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>7.</span> Conservación y Cancelación del Servicio
                    </h2>
                    <p class="mt-4">
                        Los datos de cada agrupación se conservan mientras se mantenga vigente la suscripción anual del servicio. En caso de baja o cancelación, la agrupación podrá solicitar la exportación completa de sus registros. Finalizado el periodo de custodia técnica y plazos legales obligatorios, los datos serán eliminados de forma segura de los servidores activos.
                    </p>
                </section>

                <!-- 8. Modificaciones -->
                <section class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs">
                    <h2 class="font-heading text-xl font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>8.</span> Actualizaciones de esta Política
                    </h2>
                    <p class="mt-4">
                        eBand podrá actualizar la presente Política de Privacidad para adaptarla a novedades legislativas, jurisprudenciales o mejoras funcionales de la plataforma. Cualquier modificación relevante será publicada en esta misma página y comunicada oportunamente a las agrupaciones clientes.
                    </p>
                </section>

            </div>

            <!-- Botón de retorno al final -->
            <div class="mt-12 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-700 px-6 py-3 text-sm font-bold text-white shadow-md shadow-blue-700/20 transition hover:bg-blue-800">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver a la página principal de eBand</span>
                </a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white py-8 mt-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} eBand. Todos los derechos reservados. Software de gestión para agrupaciones musicales.</p>
        </div>
    </footer>

</body>
</html>
