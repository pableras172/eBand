<x-guest-layout>
    <div class="pt-4 bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
                <x-authentication-card-logo />
            </div>

            <div class="w-full sm:max-w-4xl mt-6 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert">
                <h1 class="text-3xl font-bold mb-6">Política de Privacidad</h1>
                
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    <strong>Fecha de última actualización:</strong> {{ date('d/m/Y') }}
                </p>

                <section class="mb-6">
                    <h2 class="text-2xl font-semibold mb-3">1. Información General</h2>
                    <p class="mb-3">
                        La presente Política de Privacidad establece los términos en que {{ config('app.name') }} utiliza y protege la información 
                        que es proporcionada por sus usuarios al momento de utilizar su plataforma. Esta aplicación está comprometida con la 
                        seguridad de los datos de sus usuarios. Cuando le pedimos llenar los campos de información personal con la cual usted 
                        pueda ser identificado, lo hacemos asegurando que sólo se empleará de acuerdo con los términos de este documento.
                    </p>
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
                        Para ejercer cualquiera de estos derechos, puede ponerse en contacto con el administrador de la aplicación a través de 
                        los canales de comunicación proporcionados en la plataforma.
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

                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                        Esta política de privacidad está sujeta a las leyes aplicables en materia de protección de datos personales.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
