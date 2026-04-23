<x-guest-layout>
    <section class="relative min-h-screen overflow-hidden bg-slate-50">
        <div class="grid min-h-screen grid-cols-1 md:grid-cols-2">
            <div class="relative hidden overflow-hidden md:flex md:flex-col md:justify-end">
                <img
                    src="https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=1280&q=80&fit=crop"
                    alt="Concierto sinfónico"
                    class="absolute inset-0 h-full w-full object-cover object-center"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/55 to-slate-800/25"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(34,211,238,0.18),transparent_55%)]"></div>

                <div class="relative z-10 p-10">
                    <a href="/" class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-3 py-2 backdrop-blur-sm transition hover:bg-white/20">
                        <img class="h-8 w-auto" src="{{ URL::to('/') }}/imagenes/logo.png" alt="Logo" />
                        <span class="text-sm font-semibold tracking-wide text-white">eBand</span>
                    </a>
                    <h2 class="mt-6 text-3xl font-black tracking-tight text-white">{{ __('Transparencia y confianza.') }}</h2>
                    <p class="mt-2 max-w-sm text-sm text-white/70">{{ __('Aquí encontrarás las condiciones de uso de la plataforma explicadas de forma clara.') }}</p>
                </div>
            </div>

            <div class="bg-slate-50 px-6 py-8 sm:px-8 md:max-h-screen md:overflow-y-auto md:px-12 md:py-10">
                <div class="mx-auto w-full max-w-4xl rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm backdrop-blur-sm sm:p-8">
                    <div class="mb-8 flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cyan-700">eBand Legal</p>
                            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900">Términos y Condiciones de Uso</h1>
                        </div>
                        <p class="rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-xs font-semibold text-cyan-700">
                            {{ __('Actualizado:') }} {{ date('d/m/Y') }}
                        </p>
                    </div>

                    <div class="mb-8 rounded-xl border border-cyan-200 bg-cyan-50 p-4">
                        <p class="text-sm font-semibold text-cyan-800">{{ __('Lectura rápida') }}</p>
                        <ul class="mt-2 space-y-1 text-sm text-cyan-700">
                            <li>{{ __('Este documento regula el uso de la plataforma y sus funciones.') }}</li>
                            <li>{{ __('Incluye normas de conducta, privacidad, responsabilidad y contacto.') }}</li>
                            <li>{{ __('Si continúas usando la app, aceptas estas condiciones.') }}</li>
                        </ul>
                    </div>

                    <div class="prose prose-slate max-w-none prose-headings:font-semibold prose-a:text-cyan-700 hover:prose-a:text-cyan-900 prose-a:no-underline hover:prose-a:underline">

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">1. Aceptación de los Términos</h2>
                    <p class="mb-3">
                        Bienvenido a {{ config('app.name') }}. Al acceder y utilizar esta aplicación, usted acepta cumplir con estos 
                        Términos y Condiciones de Uso. Si no está de acuerdo con alguna parte de estos términos, no debe utilizar 
                        nuestra plataforma.
                    </p>
                    <p class="mb-3">
                        Nos reservamos el derecho de modificar estos términos en cualquier momento. Las modificaciones entrarán en 
                        vigor inmediatamente después de su publicación en la plataforma. Es su responsabilidad revisar periódicamente 
                        estos términos para estar informado de cualquier cambio.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">2. Descripción del Servicio</h2>
                    <p class="mb-3">
                        {{ config('app.name') }} es una plataforma diseñada para facilitar la gestión y coordinación de bandas de música. 
                        El servicio incluye, entre otras funcionalidades:
                    </p>
                    <ul class="list-disc pl-6 mb-3">
                        <li>Gestión de miembros de la banda y sus instrumentos</li>
                        <li>Organización de ensayos y actuaciones</li>
                        <li>Control de asistencias</li>
                        <li>Sistema de comunicación y comentarios</li>
                        <li>Gestión de sugerencias</li>
                        <li>Estadísticas de participación</li>
                        <li>Notificaciones y alertas</li>
                    </ul>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">3. Registro y Cuenta de Usuario</h2>
                    <p class="mb-3">
                        Para utilizar la plataforma, es necesario crear una cuenta de usuario. Al registrarse, usted se compromete a:
                    </p>
                    <ul class="list-disc pl-6 mb-3">
                        <li>Proporcionar información verdadera, precisa, actualizada y completa</li>
                        <li>Mantener y actualizar su información para que siga siendo verdadera, precisa, actualizada y completa</li>
                        <li>Mantener la confidencialidad de su contraseña y cuenta</li>
                        <li>Notificar inmediatamente cualquier uso no autorizado de su cuenta</li>
                        <li>Ser responsable de todas las actividades que ocurran en su cuenta</li>
                    </ul>
                    <p class="mb-3">
                        Nos reservamos el derecho de suspender o cancelar su cuenta si la información proporcionada es incorrecta, 
                        inexacta, desactualizada o incompleta.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">4. Uso Aceptable</h2>
                    <p class="mb-3">Al utilizar {{ config('app.name') }}, usted se compromete a:</p>
                    <ul class="list-disc pl-6 mb-3">
                        <li>Utilizar la plataforma solo para fines relacionados con la banda y sus actividades</li>
                        <li>Respetar a todos los miembros de la comunidad</li>
                        <li>No publicar contenido ofensivo, difamatorio, discriminatorio o ilegal</li>
                        <li>No utilizar la plataforma para enviar spam o contenido no solicitado</li>
                        <li>No intentar acceder a áreas restringidas o cuentas de otros usuarios</li>
                        <li>No utilizar la plataforma para ninguna actividad que viole las leyes aplicables</li>
                        <li>No realizar ingeniería inversa, descompilar o intentar extraer el código fuente de la aplicación</li>
                    </ul>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">5. Roles y Permisos</h2>
                    <p class="mb-3">
                        La plataforma cuenta con diferentes roles de usuario con permisos específicos:
                    </p>
                    <ul class="list-disc pl-6 mb-3">
                        <li><strong>Administradores:</strong> Tienen acceso completo a todas las funcionalidades de gestión</li>
                        <li><strong>Músicos:</strong> Pueden gestionar su perfil, confirmar asistencias y participar en la comunicación</li>
                        <li><strong>Otros roles específicos:</strong> Según la configuración de la banda</li>
                    </ul>
                    <p class="mb-3">
                        Los permisos son asignados por los administradores de la banda y pueden ser modificados en cualquier momento.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">6. Contenido del Usuario</h2>
                    <p class="mb-3">
                        Al publicar comentarios, sugerencias, fotografías u otro contenido en la plataforma, usted:
                    </p>
                    <ul class="list-disc pl-6 mb-3">
                        <li>Declara que es el propietario o tiene los derechos necesarios sobre el contenido</li>
                        <li>Otorga a {{ config('app.name') }} una licencia para usar, almacenar y mostrar dicho contenido</li>
                        <li>Acepta que otros miembros de la banda puedan ver su contenido</li>
                        <li>Es responsable del contenido que publica</li>
                    </ul>
                    <p class="mb-3">
                        Nos reservamos el derecho de eliminar cualquier contenido que consideremos inapropiado, ofensivo o que viole 
                        estos términos.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">7. Asistencias y Compromisos</h2>
                    <p class="mb-3">
                        La información sobre asistencias a ensayos y actuaciones registrada en la plataforma es orientativa y está sujeta 
                        a cambios. Los usuarios son responsables de:
                    </p>
                    <ul class="list-disc pl-6 mb-3">
                        <li>Mantener actualizada su disponibilidad</li>
                        <li>Confirmar o rechazar su asistencia a eventos en el plazo establecido</li>
                        <li>Comunicar cualquier cambio de última hora</li>
                        <li>Cumplir con los compromisos confirmados</li>
                    </ul>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">8. Propiedad Intelectual</h2>
                    <p class="mb-3">
                        Todo el contenido de {{ config('app.name') }}, incluyendo pero no limitado a textos, gráficos, logos, iconos, 
                        imágenes, clips de audio y software, es propiedad de la aplicación o de sus proveedores de contenido y está 
                        protegido por las leyes de propiedad intelectual.
                    </p>
                    <p class="mb-3">
                        No se permite la reproducción, distribución, modificación o uso comercial del contenido de la plataforma sin 
                        autorización previa por escrito.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">9. Privacidad y Protección de Datos</h2>
                    <p class="mb-3">
                        El uso de sus datos personales está regido por nuestra <a href="{{ route('policy.show') }}" class="text-cyan-700 hover:underline">Política de Privacidad</a>, 
                        que forma parte integral de estos Términos y Condiciones. Le recomendamos que la lea detenidamente.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">10. Disponibilidad del Servicio</h2>
                    <p class="mb-3">
                        Nos esforzamos por mantener la plataforma disponible las 24 horas del día, los 7 días de la semana. Sin embargo, 
                        pueden producirse interrupciones debido a:
                    </p>
                    <ul class="list-disc pl-6 mb-3">
                        <li>Mantenimiento programado o de emergencia</li>
                        <li>Problemas técnicos o de infraestructura</li>
                        <li>Causas de fuerza mayor</li>
                    </ul>
                    <p class="mb-3">
                        No nos hacemos responsables de ninguna pérdida o daño que pueda resultar de la interrupción temporal del servicio.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">11. Limitación de Responsabilidad</h2>
                    <p class="mb-3">
                        {{ config('app.name') }} se proporciona "tal cual" y "según disponibilidad". No garantizamos que:
                    </p>
                    <ul class="list-disc pl-6 mb-3">
                        <li>El servicio será ininterrumpido, seguro o libre de errores</li>
                        <li>Los resultados obtenidos del uso del servicio serán precisos o fiables</li>
                        <li>Cualquier error en el software será corregido</li>
                    </ul>
                    <p class="mb-3">
                        En ningún caso seremos responsables de daños directos, indirectos, incidentales, especiales o consecuentes que 
                        resulten del uso o la imposibilidad de usar la plataforma.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">12. Notificaciones</h2>
                    <p class="mb-3">
                        La plataforma puede enviar notificaciones por correo electrónico, notificaciones push u otros medios. Al 
                        registrarse, usted acepta recibir estas comunicaciones relacionadas con:
                    </p>
                    <ul class="list-disc pl-6 mb-3">
                        <li>Eventos próximos (ensayos y actuaciones)</li>
                        <li>Cambios en los eventos</li>
                        <li>Mensajes de la dirección de la banda</li>
                        <li>Actualizaciones del servicio</li>
                    </ul>
                    <p class="mb-3">
                        Puede ajustar sus preferencias de notificación en la configuración de su perfil.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">13. Terminación</h2>
                    <p class="mb-3">
                        Podemos suspender o terminar su acceso a la plataforma en cualquier momento, con o sin causa, con o sin aviso 
                        previo, por cualquier motivo, incluyendo pero no limitado a:
                    </p>
                    <ul class="list-disc pl-6 mb-3">
                        <li>Violación de estos Términos y Condiciones</li>
                        <li>Comportamiento inapropiado o abusivo</li>
                        <li>Solicitud del usuario</li>
                        <li>Decisión de la dirección de la banda</li>
                    </ul>
                    <p class="mb-3">
                        Usted puede cancelar su cuenta en cualquier momento desde la configuración de su perfil o contactando con 
                        los administradores.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">14. Modificaciones del Servicio</h2>
                    <p class="mb-3">
                        Nos reservamos el derecho de modificar, suspender o descontinuar cualquier aspecto de la plataforma en 
                        cualquier momento, incluyendo la disponibilidad de cualquier característica, base de datos o contenido.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">15. Legislación Aplicable</h2>
                    <p class="mb-3">
                        Estos Términos y Condiciones se rigen por las leyes aplicables en España. Cualquier disputa relacionada con 
                        estos términos se resolverá en los tribunales competentes.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">16. Divisibilidad</h2>
                    <p class="mb-3">
                        Si cualquier disposición de estos Términos y Condiciones se considera inválida o inaplicable, dicha disposición 
                        será eliminada y las disposiciones restantes seguirán siendo válidas y aplicables.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">17. Contacto</h2>
                    <p class="mb-3">
                        Si tiene alguna pregunta sobre estos Términos y Condiciones, puede ponerse en contacto con los administradores 
                        de la plataforma a través de los canales de comunicación disponibles en la aplicación.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">18. Aceptación Final</h2>
                    <p class="mb-3">
                        Al hacer clic en "Aceptar", al registrarse o al utilizar {{ config('app.name') }}, usted reconoce que ha leído, 
                        comprendido y acepta estar sujeto a estos Términos y Condiciones de Uso, así como a nuestra Política de Privacidad.
                    </p>
                </section>

                <div class="mt-8 border-t border-slate-200 pt-6">
                    <p class="text-center text-sm text-slate-500">
                        Estos términos y condiciones constituyen un acuerdo legal entre usted y {{ config('app.name') }}.
                        <br>
                        Última actualización: {{ date('d/m/Y') }}
                    </p>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
