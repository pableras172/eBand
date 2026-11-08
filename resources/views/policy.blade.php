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
                    <h2 class="mt-6 text-3xl font-black tracking-tight text-white">{{ __('Tus datos, bajo control.') }}</h2>
                    <p class="mt-2 max-w-sm text-sm text-white/70">{{ __('Conoce qué datos recogemos, cómo los usamos y cuáles son tus derechos.') }}</p>
                </div>
            </div>

            <div class="bg-slate-50 px-6 py-8 sm:px-8 md:max-h-screen md:overflow-y-auto md:px-12 md:py-10">
                <div class="mx-auto w-full max-w-4xl rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm backdrop-blur-sm sm:p-8">
                    <div class="mb-8 flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-5">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cyan-700">eBand Legal</p>
                            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900">Política de Privacidad</h1>
                        </div>
                        <p class="rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-xs font-semibold text-cyan-700">
                            {{ __('Actualizado:') }} {{ date('d/m/Y') }}
                        </p>
                    </div>

                    <div class="mb-8 rounded-xl border border-cyan-200 bg-cyan-50 p-4">
                        <p class="text-sm font-semibold text-cyan-800">{{ __('Resumen rápido') }}</p>
                        <ul class="mt-2 space-y-1 text-sm text-cyan-700">
                            <li>{{ __('Recopilamos solo la información necesaria para gestionar la banda.') }}</li>
                            <li>{{ __('Puedes acceder, corregir o solicitar la eliminación de tus datos.') }}</li>
                            <li>{{ __('No vendemos tus datos personales a terceros.') }}</li>
                        </ul>
                    </div>

                    <div class="prose prose-slate max-w-none prose-headings:font-semibold prose-a:text-cyan-700 hover:prose-a:text-cyan-900 prose-a:no-underline hover:prose-a:underline">

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">1. Información General y Roles en Protección de Datos (RGPD)</h2>
                    <p class="mb-3">
                        La presente Política de Privacidad establece los términos en que {{ config('app.name') }} trata y protege la información que es proporcionada por sus usuarios y clientes al momento de utilizar su plataforma.
                    </p>
                    <div class="mb-4 rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900">
                        <strong class="block mb-1">🏛️ Las Agrupaciones Musicales son las Responsables de los Datos:</strong>
                        <p>
                            En el marco del RGPD (UE 2016/679) y la LOPDGDD 3/2018, <strong>cada agrupación musical (sociedad musical, banda, coro o charanga) actúa como Responsable del Tratamiento</strong> de los datos de sus integrantes, alumnos, socios y familias. <strong>{{ config('app.name') }} actúa estrictamente como Encargado del Tratamiento</strong> (Art. 28 RGPD), proporcionando el soporte tecnológico y almacenamiento seguro conforme a las directrices de la agrupación.
                        </p>
                    </div>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">2. Información que Recopilamos</h2>
                    <p class="mb-3">Nuestra aplicación puede recopilar información personal, por ejemplo:</p>
                    <ul class="list-disc pl-6 mb-3">
                        <li>Nombre y apellidos</li>
                        <li>Correo electrónico</li>
                        <li>Número de teléfono</li>
                        <li>Información relacionada con tu participación en la banda (instrumento, asistencias, etc.)</li>
                        <li>Fotografías de perfil (opcional)</li>
                        <li>Datos de acceso y uso de la plataforma</li>
                    </ul>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">3. Uso de la Información Recopilada</h2>
                    <p class="mb-3">Nuestra aplicación emplea la información con el fin de proporcionar el mejor servicio posible, particularmente para:</p>
                    <ul class="list-disc pl-6 mb-3">
                        <li>Gestionar la participación de los miembros en ensayos y actuaciones</li>
                        <li>Facilitar la comunicación entre los miembros de la banda</li>
                        <li>Mantener un registro de asistencias y eventos</li>
                        <li>Enviar notificaciones sobre eventos, cambios o avisos importantes</li>
                        <li>Mejorar nuestros servicios y la experiencia del usuario</li>
                        <li>Gestionar comentarios y sugerencias</li>
                    </ul>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">4. Cookies y Tecnologías Similares</h2>
                    <p class="mb-3">
                        Una cookie se refiere a un fichero que es enviado con la finalidad de solicitar permiso para almacenarse en su ordenador. 
                        Al aceptar dicho fichero se crea y la cookie sirve entonces para tener información respecto al tráfico web, y también 
                        facilita las futuras visitas a una web recurrente. Nuestra aplicación emplea las cookies para poder identificar las 
                        páginas que son visitadas y su frecuencia. Esta información es empleada únicamente para análisis estadístico y después 
                        la información se elimina de forma permanente.
                    </p>
                    <p class="mb-3">
                        Usted puede eliminar las cookies en cualquier momento desde su ordenador. Sin embargo, las cookies ayudan a proporcionar 
                        un mejor servicio de los sitios web, éstas no dan acceso a información de su ordenador ni de usted, a menos de que usted 
                        así lo quiera y la proporcione directamente.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">5. Seguridad de los Datos</h2>
                    <p class="mb-3">
                        {{ config('app.name') }} está comprometido con proteger la información de sus usuarios. Utilizamos sistemas y procedimientos 
                        de seguridad para proteger su información personal contra acceso no autorizado, uso indebido o divulgación. Empleamos 
                        técnicas de encriptación, control de acceso y otras medidas de seguridad para proteger los datos personales.
                    </p>
                    <p class="mb-3">
                        Sin embargo, ningún sistema de transmisión por Internet o sistema de almacenamiento electrónico es 100% seguro. Por lo tanto, 
                        aunque nos esforzamos por utilizar medios comercialmente aceptables para proteger su información personal, no podemos garantizar 
                        su seguridad absoluta.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">6. Enlaces a Terceros</h2>
                    <p class="mb-3">
                        Esta aplicación puede contener enlaces a otros sitios que pudieran ser de su interés. Una vez que usted haga clic en estos 
                        enlaces y abandone nuestra página, ya no tenemos control sobre el sitio al que es redirigido y por lo tanto no somos 
                        responsables de los términos o privacidad ni de la protección de sus datos en esos otros sitios terceros. Dichos sitios 
                        están sujetos a sus propias políticas de privacidad por lo cual es recomendable que los consulte para confirmar que usted 
                        está de acuerdo con estas.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">7. Control de su Información Personal</h2>
                    <p class="mb-3">En cualquier momento usted puede ejercer los siguientes derechos:</p>
                    <ul class="list-disc pl-6 mb-3">
                        <li><strong>Derecho de Acceso:</strong> Puede solicitar información sobre los datos personales que tenemos sobre usted</li>
                        <li><strong>Derecho de Rectificación:</strong> Puede actualizar o corregir su información personal en cualquier momento</li>
                        <li><strong>Derecho de Supresión:</strong> Puede solicitar la eliminación de su cuenta y datos personales</li>
                        <li><strong>Derecho de Oposición:</strong> Puede oponerse al tratamiento de sus datos personales</li>
                        <li><strong>Derecho de Portabilidad:</strong> Puede solicitar una copia de sus datos en formato estructurado</li>
                    </ul>
                    <p class="mb-3">
                        Para ejercer cualquiera de estos derechos: los miembros, socios y familias de una banda deben dirigirse a su propia agrupación musical (Responsable del Tratamiento). Para consultas de suscripción o clientes directos de la plataforma, pueden escribir a través de los canales de soporte de eBand.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">8. Compartir Información</h2>
                    <p class="mb-3">
                        {{ config('app.name') }} no venderá, cederá ni distribuirá la información personal que es recopilada sin su consentimiento, 
                        salvo que sea requerido por un juez con una orden judicial.
                    </p>
                    <p class="mb-3">
                        La información compartida dentro de la plataforma (como nombres, instrumentos y asistencias) es visible para otros miembros 
                        registrados de la banda con el fin de facilitar la coordinación y comunicación del grupo.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">9. Menores de Edad</h2>
                    <p class="mb-3">
                        Nuestra aplicación está diseñada para ser utilizada por miembros de la banda de todas las edades. En el caso de usuarios 
                        menores de 18 años, recomendamos que el registro y uso de la plataforma se realice bajo la supervisión de un padre, tutor 
                        o representante legal, quien será responsable de los actos realizados por el menor.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">10. Cambios en la Política de Privacidad</h2>
                    <p class="mb-3">
                        {{ config('app.name') }} se reserva el derecho de cambiar los términos de la presente Política de Privacidad en cualquier 
                        momento. Cualquier cambio será notificado a través de la plataforma y/o por correo electrónico. Le recomendamos que 
                        revise periódicamente esta página para estar informado de cualquier cambio.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">11. Consentimiento</h2>
                    <p class="mb-3">
                        Al utilizar nuestra aplicación, usted acepta y consiente la recopilación y uso de su información personal de acuerdo 
                        con esta Política de Privacidad. Si no está de acuerdo con esta política, le rogamos que no utilice nuestra plataforma.
                    </p>
                </section>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">12. Contacto</h2>
                    <p class="mb-3">
                        Si tiene alguna pregunta sobre esta Política de Privacidad, las prácticas de este sitio o sus transacciones con esta 
                        aplicación, puede ponerse en contacto con nosotros a través de los medios de contacto disponibles en la plataforma.
                    </p>
                </section>

                <div class="mt-8 border-t border-slate-200 pt-6">
                    <p class="text-center text-sm text-slate-500">
                        Esta política de privacidad está sujeta a las leyes aplicables en materia de protección de datos personales.
                    </p>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
