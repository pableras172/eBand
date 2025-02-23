 <h1>Proyecto de Gestión de Bandas de Música</h1>
    <p>Este es un proyecto desarrollado en Laravel 11 con Fortify para la autenticación, y cuenta con una PWA optimizada para la instalación en Windows, Android y Apple.</p>

    <h2>Características principales</h2>
    <ul>
        <li><strong>Gestión de usuarios</strong> con Fortify, sobrescribiendo los métodos de verificación de email y restablecimiento de contraseña.</li>
        <li><strong>PWA (Progressive Web App)</strong> con un <code>manifest.json</code> dinámico generado por <code>ManifestService</code>.</li>
        <li><strong>Sistema de autenticación</strong> seguro con Laravel Fortify.</li>
        <li><strong>Interfaz moderna y responsiva</strong> para la administración y gestión de bandas de música.</li>
    </ul>

    <h2>Instalación</h2>
    <h3>Requisitos</h3>
    <ul>
        <li>PHP 8.1 o superior</li>
        <li>Composer</li>
        <li>Node.js y npm</li>
        <li>MySQL o PostgreSQL</li>
    </ul>
    
    <h3>Pasos para instalar</h3>
    <ol>
        <li>Clona el repositorio:<br>
            <code>git clone https://github.com/pableras172/eband.git</code><br>
            <code>cd proyecto-bandas</code>
        </li>
        <li>Instala las dependencias de Laravel:<br>
            <code>composer install</code>
        </li>
        <li>Instala las dependencias de JavaScript:<br>
            <code>npm install</code>
        </li>
        <li>Copia el archivo de entorno y configúralo:<br>
            <code>cp .env.example .env</code><br>
            Configura la base de datos en el archivo <code>.env</code>
        </li>
        <li>Genera la clave de la aplicación:<br>
            <code>php artisan key:generate</code>
        </li>
        <li>Ejecuta las migraciones y seedea la base de datos:<br>
            <code>php artisan migrate --seed</code>
        </li>
        <li>Inicia el servidor de desarrollo:<br>
            <code>php artisan serve</code>
        </li>
    </ol>

    <h2>Configuración de la PWA</h2>
    <p>La aplicación incluye un <code>manifest.json</code> dinámico que se genera a través de <code>ManifestService</code>. Para asegurarse de que funcione correctamente:</p>
    <ul>
        <li>Configura la URL base en <code>.env</code></li>
        <li>Asegúrate de que los archivos de iconos estén en la carpeta <code>public/icons</code></li>
    </ul>

    <h2>Personalización de correos</h2>
    <p>Los correos de verificación y restablecimiento de contraseña han sido sobrescritos en Fortify. Para modificar las plantillas, revisa:</p>
    <ul>
        <li><code>app/Mail/VerifyEmail.php</code></li>
        <li><code>app/Mail/ResetPassword.php</code></li>
    </ul>

    <h2>Despliegue</h2>
    <p>Para desplegar la aplicación en producción:</p>
    <ol>
        <li>Ejecuta las migraciones:<br>
            <code>php artisan migrate --force</code>
        </li>
        <li>Compila los assets:<br>
            <code>npm run build</code>
        </li>
        <li>Configura el almacenamiento enlazado:<br>
            <code>php artisan storage:link</code>
        </li>
        <li>Configura correctamente la caché de configuración:<br>
            <code>php artisan config:cache</code>
        </li>
    </ol>

<h2>Licencia</h2>
<p>Este proyecto es de propiedad exclusiva del desarrollador. No está permitido modificarlo ni distribuirlo sin autorización expresa.</p>


    <hr>
    <p><strong>Desarrollado por pableras172</strong></p>


