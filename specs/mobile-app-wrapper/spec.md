# Especificación de la Feature: App Móvil (iOS / Android) y Resolución de Tenant

**Contexto / Rama**: `3.0.0`

**Creado**: 2026-11-04

**Estado**: Draft

**Entrada**: Requerimiento de usuario: *"Crear una app iOS / Android que tenga dentro la aplicación web. La aplicación se encargaría de recoger el código de la banda o agrupación en la primera instalación y a partir de ahí realizar el login o registro en la agrupación indicada."*

---

## 📖 Resumen Ejecutivo

Esta funcionalidad define la arquitectura y el comportamiento del contenedor móvil híbrido (iOS y Android basado en Capacitor) y del backend central de eBand. La aplicación móvil se distribuye como una única app universal en App Store y Google Play. Al abrirse por primera vez, solicita al usuario el código único de su banda o agrupación musical, resuelve dicho código contra la API Central de eBand y, a partir de ese momento, redirige al usuario al entorno web aislado de su tenant (`https://{subdominio}.eband.es` o dominio personalizado), manteniendo una sesión persistente y permitiendo futuras capacidades nativas (notificaciones push segmentadas por tenant, escaneo de QR y acceso a cámara).

---

## 🎯 Escenarios de Usuario y Pruebas

### Historia de Usuario 1 - Primer arranque y vinculación de agrupación mediante código (Prioridad: P1)

Como músico o miembro de una banda que acaba de instalar la app móvil en su teléfono, quiero introducir el código que me ha proporcionado mi agrupación para que la app se configure automáticamente y me lleve al entorno de mi banda.

**Por qué esta prioridad**: Es la puerta de entrada indispensable para que la app funcione. Sin este paso, la app no sabe a qué tenant multi-base de datos debe apuntar.

**Prueba independiente**:
1. Abrir la app limpia (sin datos guardados).
2. Introducir el código de prueba de una banda activa (ej. `BANDA-DEMO`).
3. Pulsar "Continuar".
4. Verificar que se muestra la tarjeta de confirmación con el nombre y escudo de la agrupación.
5. Confirmar y verificar que el WebView carga inmediatamente la pantalla de login/registro del tenant correspondiente (`https://demo.eband.es/login`).

**Escenarios de aceptación**:
1. **Dado** que la app no tiene un tenant configurado previamente, **cuando** se inicia, **entonces** se muestra la pantalla de bienvenida y el formulario de introducción de código.
2. **Dado** un código de banda válido introducido por el usuario (ignorando mayúsculas, minúsculas o espacios accidentales), **cuando** el usuario solicita validar, **entonces** la app consulta la API central y presenta una vista previa con nombre y logotipo de la agrupación.
3. **Dado** que el usuario confirma la agrupación mostrada, **cuando** pulsa en acceder, **entonces** se guarda la configuración en el almacenamiento local persistente del dispositivo y se abre el WebView en la URL del tenant.

---

### Historia de Usuario 2 - Resolución y validación del código en la API Central (Prioridad: P1)

Como backend central de eBand, quiero exponer un endpoint API público y seguro que reciba un código de agrupación y devuelva los metadatos necesarios para configurar la app móvil.

**Por qué esta prioridad**: La app móvil no tiene acceso directo a la base de datos central ni a los subdominios de cada tenant; requiere un contrato de datos ligero y fiable para resolver el tenant.

**Prueba independiente**:
* Realizar una petición `GET` o `POST` a `/api/v1/mobile/tenants/resolve?code=BANDA-DEMO` y comprobar que responde `200 OK` con JSON estructurado conteniendo `tenant_id`, `name`, `code`, `logo_url`, `primary_color` y `target_url`.
* Realizar la misma petición con un código inexistente y comprobar respuesta `404 Not Found` con mensaje amigable.

**Escenarios de aceptación**:
1. **Dado** un código existente y perteneciente a un tenant activo, **cuando** se consulta el endpoint de resolución, **entonces** devuelve código HTTP `200` y el payload de configuración del tenant.
2. **Dado** un código no registrado o mal formateado, **cuando** se consulta el endpoint, **entonces** devuelve código HTTP `404` con el mensaje: *"No hemos encontrado ninguna agrupación con este código. Revisa que esté bien escrito."*.
3. **Dado** un tenant que se encuentra suspendido o desactivado, **cuando** se consulta el endpoint, **entonces** devuelve código HTTP `403` o `422` indicando que el acceso para esa agrupación está temporalmente inactivo.

---

### Historia de Usuario 3 - Navegación segura, sesión persistente y adaptación visual (Prioridad: P1)

Como músico ya vinculado a mi agrupación, quiero que al abrir la app entre directamente a mi área de trabajo sin pedirme el código de nuevo, y que la sesión permanezca iniciada cómodamente.

**Por qué esta prioridad**: La experiencia de usuario de una app móvil exige inmediatez; pedir credenciales o códigos repetidamente causa fricción y abandono.

**Prueba independiente**:
* Cerrar por completo la app móvil tras haber iniciado sesión en una banda y volver a abrirla; verificar que carga directamente el Dashboard del tenant sin pasar por el onboarding ni pedir login de nuevo.

**Escenarios de aceptación**:
1. **Dado** que existe una configuración de tenant guardada en el dispositivo, **cuando** se lanza la app, **entonces** se omite la pantalla de código y se inicializa directamente el WebView con la URL base del tenant.
2. **Dado** que el usuario ha iniciado sesión marcando "Recordarme" o con la cookie de sesión activa, **cuando** vuelve a abrir la app, **entonces** accede de inmediato a su panel sin volver al formulario de login.
3. **Dado** que la web se carga dentro del contenedor móvil, **cuando** detecta la cabecera o User-Agent de la app, **entonces** aplica los márgenes seguros (*safe-area-inset*) para evitar que el notch o la barra de inicio de iOS/Android tapen elementos de la interfaz.

---

### Historia de Usuario 4 - Desvinculación y cambio de agrupación (Prioridad: P2)

Como músico que se ha equivocado de código al configurar la app o que toca en una nueva banda, quiero poder desvincular mi teléfono de la agrupación actual para introducir un nuevo código.

**Por qué esta prioridad**: Evita que un error humano en la primera configuración obligue al usuario a desinstalar y reinstalar la aplicación desde la tienda.

**Prueba independiente**:
* Acceder a la opción de ajustes/perfil dentro de la app móvil y pulsar "Desvincular agrupación / Cambiar de banda"; verificar que se limpia el almacenamiento del dispositivo y se regresa a la pantalla de solicitud de código.

**Escenarios de aceptación**:
1. **Dado** un usuario con la app configurada, **cuando** selecciona "Desvincular agrupación" y confirma el diálogo nativo, **entonces** se eliminan los datos de tenant y cookies locales y se regresa a la pantalla de bienvenida inicial.

---

### Historia de Usuario 5 - Manejo de conectividad y pantalla offline (Prioridad: P2)

Como músico en una actuación o ensayo en un lugar con poca cobertura o modo avión, quiero recibir un aviso visual claro si la app no puede conectar con el servidor, pudiendo reintentar con un solo toque.

**Por qué esta prioridad**: Fundamental para cumplir con las directrices de Apple (Guideline 4.2) y evitar pantallas blancas o errores nativos de "Página no encontrada".

**Prueba independiente**:
* Activar modo avión en el dispositivo y abrir la app; verificar que se renderiza una pantalla nativa/local amigable con botón "Reintentar conexión".

**Escenarios de aceptación**:
1. **Dado** que el dispositivo no tiene acceso a internet al abrir la app o durante una navegación crítica, **cuando** falla la carga de red, **entonces** se muestra la pantalla de reconexión sin romper el contenedor WebView.
2. **Dado** que el usuario recupera la conexión y pulsa "Reintentar", **cuando** se restablece el acceso a la red, **entonces** la app recarga automáticamente la última página web visitada.

---

### Historia de Usuario 6 - Soporte para Notificaciones Push nativas por Tenant (Prioridad: P3)

Como músico de la banda, quiero recibir notificaciones push en mi móvil cuando se publiquen nuevas actuaciones, avisos o cambios de repertorio en mi agrupación.

**Por qué esta prioridad**: Incrementa exponencialmente el engagement respecto a una simple web y aprovecha la infraestructura ya existente de OneSignal en el modelo `Tenant`.

**Escenarios de aceptación**:
1. **Dado** que el usuario ha concedido permisos de notificación tras iniciar sesión, **cuando** la app se registra en OneSignal, **entonces** envía el `external_user_id` y el tag `tenant_id` a la cuenta de OneSignal configurada para ese tenant.
2. **Dado** que un administrador crea un aviso en eBand para su agrupación, **cuando** se dispara la notificación push, **entonces** sólo los dispositivos vinculados a ese tenant reciben el mensaje.

---

## ⚠️ Casos Límite y Consideraciones Especiales

1. **¿Qué ocurre si el código introducido tiene espacios o variaciones de capitalización?**
   * El cliente y el servidor deben aplicar sanitización: `strtoupper(trim($code))`. Si el usuario introduce ` banda-san-pedro `, debe tratarse igual que `BANDA-SAN-PEDRO`.
2. **¿Qué ocurre si la agrupación utiliza un dominio propio en vez de un subdominio de eBand?**
   * El endpoint de resolución debe devolver la URL canónica final (`https://banda.com` o `https://banda.eband.es`), de modo que el WebView navegue al origen correcto con independencia de la estrategia de DNS del tenant.
3. **¿Qué ocurre con los enlaces externos (ej. vídeos de YouTube de obras, mapas de Google Maps, enlaces bancarios)?**
   * Los enlaces que no pertenezcan al dominio del tenant deben abrirse en el navegador nativo del sistema (Safari / Chrome) mediante el plugin `App` / `Browser` de Capacitor, evitando que el usuario quede "atrapado" navegando en sitios de terceros dentro de la app.
4. **¿Qué ocurre si la sesión web caduca en el servidor?**
   * Laravel redirigirá automáticamente a la ruta `/login` del tenant. La app móvil permanecerá en el entorno de la banda correcta y solo pedirá credenciales, sin pedir de nuevo el código de agrupación.
5. **¿Qué ocurre si el usuario escanea un código QR en lugar de teclear el código?**
   * La app ofrecerá un botón opcional para abrir la cámara nativa; el QR contendrá una URL (`https://eband.es/join?code=XYZ`) o el texto plano del código, rellenando automáticamente el campo.

---

## 🛠️ Requisitos del Sistema

### Requisitos Funcionales

* **FR-001**: El backend central de eBand DEBE exponer la ruta pública `GET /api/v1/mobile/tenants/resolve` protegida con rate-limiting.
* **FR-002**: La API DEBE validar la existencia del código en la tabla `tenants` y comprobar que el estado de la agrupación esté activo.
* **FR-003**: La API DEBE retornar un payload JSON con: `tenant_id`, `name`, `code`, `logo_url`, `target_url` y atributos de personalización visual (colores de tema si aplican).
* **FR-004**: La app móvil DEBE almacenar en almacenamiento local seguro (`@capacitor/preferences`) la configuración del tenant una vez confirmada.
* **FR-005**: La app móvil DEBE inicializar el WebView apuntando a la URL del tenant resuelto en todos los arranques posteriores a la vinculación.
* **FR-006**: La aplicación web DEBE detectar peticiones originadas desde la app móvil (mediante cabecera `X-eBand-Mobile: true` o User-Agent) para ajustar safe-areas CSS y ocultar banners PWA redundantes.
* **FR-007**: La app móvil DEBE interceptar enlaces salientes fuera del dominio del tenant para abrirlos con el navegador del sistema operativo.
* **FR-008**: La app móvil DEBE contar con un mecanismo accesible para desvincular la agrupación y limpiar el almacenamiento local.
* **FR-009**: La app móvil DEBE gestionar el estado sin conexión mediante una vista nativa de contingencia con acción de reintento.
* **FR-010**: El contenedor móvil DEBE soportar la integración del SDK nativo de OneSignal vinculando el `app_id` definido en la configuración del tenant.
* **FR-011**: La configuración de la plataforma Android DEBE establecer `minSdkVersion = 24` (Android 7.0 Nougat) para dar cumplimiento a la protección automática e integridad de aplicaciones de Google Play Console (Play Integrity / Play Protect automatic protection), con `targetSdkVersion = 36` y `compileSdkVersion = 36`.

---

## 📐 Superficie en Laravel y Arquitectura del Proyecto

### En el Backend Central de Laravel (eBand):
* **Rutas Centrales** (`routes/central.php` o `routes/api.php` bajo dominio central):
  * `GET /api/v1/mobile/tenants/resolve`
* **Controlador Central**:
  * `app/Http/Controllers/Api/MobileTenantResolverController.php`
* **Form Request**:
  * `app/Http/Requests/Mobile/ResolveTenantRequest.php` (validación de formato del código)
* **Recurso API**:
  * `app/Http/Resources/MobileTenantResource.php`
* **Pruebas PHPUnit**:
  * `tests/Feature/Api/MobileTenantResolverTest.php`

### En las Vistas / Frontend de eBand:
* **Layouts Blade** (`resources/views/layouts/app.blade.php`, `guest.blade.php`):
  * Soporte de meta-tag `viewport-fit=cover`.
  * Inclusión de variables CSS para safe areas: `padding-top: env(safe-area-inset-top)`.
  * Ocultación condicional de banners de instalación PWA cuando se navegue dentro del WebView nativo.

### En la App Móvil (Contenedor Capacitor):
* Estructura base en directorio móvil (`mobile/` o repositorio satélite):
  * `capacitor.config.ts` (configuración de esquemas, URLs permitidas y plugins).
  * `src/index.html` (pantalla de bienvenida y onboarding ultra-ligera para la vinculación inicial).
  * `src/js/app.js` (lógica de consulta a la API central, guardado en `Preferences` y redirección a WebView).
  * Plugins requeridos:
    * `@capacitor/preferences` (almacenamiento local del código y URL).
    * `@capacitor/network` (detección online/offline).
    * `@capacitor/browser` o `@capacitor/app` (manejo de enlaces externos y botón atrás de Android).
    * `@capacitor/status-bar` / `@capacitor/splash-screen` (aspecto nativo pulido).
    * `@onesignal/onesignal-capacitor` (notificaciones push nativas).

---

## 📊 Criterios de Éxito y Validación

* **SC-001**: Un usuario nuevo es capaz de vincular su banda introduciendo el código en menos de 15 segundos desde la apertura de la app.
* **SC-002**: La API de resolución responde en menos de 200ms en condiciones normales de red.
* **SC-003**: Tras cerrar forzosamente la app y volver a entrar, el 100% de los usuarios vinculados acceden directamente a su entorno sin ver la pantalla de código.
* **SC-004**: Cumplimiento del 100% de las directrices de revisión de Apple App Store (Guideline 4.2 y navegación webview integrada con capacidades nativas).
