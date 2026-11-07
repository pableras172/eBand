# Tareas: App Móvil (iOS / Android) y Resolución de Tenant

**Entrada**: Documentos de diseño en `specs/mobile-app-wrapper/` (`spec.md` y `plan.md`)

**Prerequisitos**: `plan.md` (aprobado), `spec.md` (aprobado)

**Pruebas**: Se incluyen tareas de pruebas PHPUnit para el endpoint API central y validación de comportamiento de la app móvil.

**Organización**: Las tareas están agrupadas por fases e historias de usuario para permitir una ejecución incremental y verificable.

## Formato: `[ID] [P?] [Story] Descripción`
- **[P]**: Se puede ejecutar en paralelo (archivos independientes)
- **[Story]**: Historia de usuario asociada en `spec.md`

---

## Fase 1: Preparación del Entorno y Estructura

**Propósito**: Preparar las rutas centrales de Laravel y la estructura del proyecto Capacitor en `mobile/`.

- [x] T001 Verificar la configuración de rutas centrales en `routes/central.php` y el modelo `Tenant` en `app/Models/Tenant.php`
- [x] T002 [P] Crear el directorio `mobile/` en la raíz del repositorio con la estructura base (`src/`, `src/js/`, `src/css/`)
- [x] T003 [P] Inicializar `mobile/package.json` con las dependencias de Capacitor (`@capacitor/core`, `@capacitor/cli`, `@capacitor/preferences`, `@capacitor/network`, `@capacitor/browser`, `@capacitor/app`)

---

## Fase 2: Backend Central - API de Resolución de Tenant (Historia 2 - P1)

**Objetivo**: Implementar el endpoint público en el dominio central que valide el código de la agrupación y devuelva los metadatos necesarios.

### Pruebas (TDD)
- [x] T004 [P] [US2] Crear la prueba de características `tests/Feature/Api/MobileTenantResolverTest.php` verificando:
  - Código válido devuelve 200 y JSON con `target_url`, `name`, `code`, `logo_url`, `primary_color`.
  - Código inexistente devuelve 404 con mensaje amigable.
  - Insensibilidad a mayúsculas/minúsculas y espacios en blanco.
  - Código vacío devuelve 422.

### Implementación Backend
- [x] T005 [P] [US2] Crear el Form Request `app/Http/Requests/Mobile/ResolveTenantRequest.php` con validación y sanitización (`strtoupper(trim(...))`)
- [x] T006 [P] [US2] Crear el recurso API `app/Http/Resources/MobileTenantResource.php` para estructurar la respuesta JSON
- [x] T007 [US2] Crear el controlador `app/Http/Controllers/Api/MobileTenantResolverController.php` con la lógica de búsqueda por columna `code` en el modelo `Tenant` y resolución del dominio/subdominio asociado
- [x] T008 [US2] Registrar la ruta `GET /api/v1/mobile/tenants/resolve` en `routes/central.php` con middleware de rate limiting (`throttle:60,1`)
- [ ] T009 [US2] Ejecutar las pruebas con PHPUnit (`vendor/bin/sail artisan test --filter=MobileTenantResolverTest`) y formatear con Pint (`vendor/bin/sail bin pint --dirty`)

---

## Fase 3: Contenedor Móvil - Onboarding y WebView (Historias 1 y 3 - P1)

**Objetivo**: Crear la interfaz nativa/local en `mobile/src/` que pide el código, lo valida, lo guarda y redirige al WebView.

- [x] T010 [P] [US1] Crear la interfaz de usuario en `mobile/src/index.html` con pantalla de bienvenida, campo para introducir código, estado de carga y tarjeta de confirmación de la agrupación
- [x] T011 [P] [US1] Diseñar estilos en `mobile/src/css/app.css` con diseño responsive, adaptable a dark mode y branding corporativo de eBand
- [x] T012 [US1] Desarrollar la lógica en `mobile/src/js/app.js`:
  - Comprobación inicial de `Preferences.get({ key: 'eband_tenant_url' })`
  - Llamada HTTP a la API central para resolver el código
  - Renderizado de datos de confirmación (nombre y logo)
  - Persistencia en `@capacitor/preferences` tras confirmación
- [x] T013 [US3] Implementar la configuración de Capacitor en `mobile/capacitor.config.ts`:
  - `appId`: `es.eband.app`
  - `appName`: `eBand`
  - Configuración de `server.url` o navegación dinámica del WebView a la URL del tenant
  - Permitir navegación hacia dominios de eBand y persistencia de cookies

---

## Fase 4: Adaptación del Frontend Web de eBand (Historia 3 - P1)

**Objetivo**: Asegurar que la web existente se visualiza impecablemente dentro del WebView de iOS y Android.

- [x] T014 [P] [US3] Actualizar el meta-tag `viewport` en `resources/views/layouts/app.blade.php` y `guest.blade.php` con `viewport-fit=cover`
- [ ] T015 [P] [US3] Añadir soporte CSS para safe-areas en el layout principal (`env(safe-area-inset-top)`, `env(safe-area-inset-bottom)`)
- [ ] T016 [US3] Ocultar condicionalmente avisos web de instalación PWA cuando la cabecera o User-Agent identifique la app Capacitor

---

## Fase 5: Contingencia y Mantenimiento (Historias 4 y 5 - P2)

**Objetivo**: Gestionar la falta de conexión a internet y permitir cambiar o desvincular la agrupación.

- [x] T017 [P] [US5] Implementar detección de estado de red con `@capacitor/network` en `mobile/src/js/app.js`
- [x] T018 [P] [US5] Diseñar la vista de contingencia "Sin conexión a internet" con botón de reintentar conexión en `mobile/src/index.html`
- [x] T019 [US4] Implementar función de desvinculación `desvincularBanda()` que limpie `Preferences` y devuelva al usuario a la pantalla de código
- [x] T020 [US4] Interceptar enlaces salientes con `@capacitor/browser` para que URLs externas se abran en el navegador nativo del sistema

---

## Fase 6: Proyectos Nativos de Android e iOS (Fase de Plataformas)

**Objetivo**: Generar los proyectos nativos de compilación en Android Studio y Xcode.

- [x] T021 Añadir la plataforma Android con `@capacitor/android` (`npx cap add android`)
- [x] T022 Añadir la plataforma iOS con workflow de GitHub Actions en macOS (`.github/workflows/build-ios.yml`)
- [x] T023 Configurar permisos e iconos de app en `mobile/android` (Cámara, Biometría, OneSignal Push y Botón Atrás)
- [x] T023b Actualizar `minSdkVersion` a 24 en `mobile/android/variables.gradle` para cumplimiento con protección automática e integridad de Google Play Console
- [x] T023c Actualizar `targetSdkVersion` y `compileSdkVersion` a 36 en `mobile/android/variables.gradle` para cumplimiento con las políticas de Google Play Console
- [x] T024 Crear la guía rápida `specs/mobile-app-wrapper/quickstart.md` con los comandos de sincronización (`npx cap sync`) y ejecución en emulador o dispositivo real

---

## Fase 7: Cierre y Verificación

- [ ] T025 Ejecutar la suite completa de pruebas PHPUnit para certificar que no hay regresiones
- [ ] T026 Ejecutar Laravel Pint sobre todos los archivos PHP creados o modificados
- [ ] T027 Validar el flujo extremo a extremo: arranque en limpio -> código -> validación API -> redirección al tenant
