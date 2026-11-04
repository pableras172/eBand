# Plan de Implementación: App Móvil (iOS / Android) y Resolución de Tenant

**Branch**: `3.0.0` | **Fecha**: 2026-11-04 | **Spec**: [spec.md](spec.md)

**Entrada**: Especificación funcional en [specs/mobile-app-wrapper/spec.md](spec.md) para empaquetar la aplicación web eBand en una app nativa móvil (iOS / Android) que solicita el código de la agrupación en su primer arranque y navega al tenant correspondiente.

---

## 1. Resumen

El proyecto consiste en dotar a **eBand** de una aplicación móvil universal (iOS y Android) desarrollada con **Capacitor**, alojada en el subdirectorio `mobile/` de este mismo repositorio. 

El sistema consta de dos pilares sincronizados:
1. **Backend Central (Laravel)**: Proporciona un endpoint público (`/api/v1/mobile/tenants/resolve`) que recibe el código de la banda introducido por el usuario, valida su existencia y estado en la base de datos central de `stancl/tenancy`, y retorna la URL destino (`https://{subdominio}.eband.es` o dominio propio) junto con los metadatos de identidad visual (nombre, logo y colores).
2. **Contenedor Móvil (Capacitor)**: Aplicación ligera que gestiona el onboarding nativo (pantalla de bienvenida para introducir el código o escanear QR), persiste la configuración seleccionada en el dispositivo mediante `@capacitor/preferences`, inicializa el WebView hacia el tenant de la banda y gestiona la experiencia nativa (persistencia de sesión, safe areas, pantalla offline y enlaces externos).

---

## 2. Contexto Técnico

* **Lenguaje / Backend**: PHP 8.3 / Laravel 12 (estructura Laravel 10) / Livewire 3 / Tailwind CSS 3 / Vite.
* **Multi-tenancy**: `stancl/tenancy` v3 (base de datos central + bases de datos por tenant aisladas).
* **Entorno Móvil**: Node.js / Capacitor 6+ alojado en `mobile/`.
* **Plataformas Móviles Objetivo**: Android (Android Studio / Gradle) e iOS (Xcode / CocoaPods).
* **Almacenamiento Local Móvil**: `@capacitor/preferences` (almacena `tenant_code`, `target_url`, `band_name`, `logo_url`).
* **Autenticación / Sesión**: Cookies de sesión seguras de Laravel dentro del WebView (`remember_web_*`).
* **Pruebas Backend**: PHPUnit 10 (`tests/Feature/Api/MobileTenantResolverTest.php`).
* **Estilo y formato**: Laravel Pint en backend y ESLint/Prettier en móvil.

---

## 3. Revisión de Constitución (Constitution Check)

* **I. Monolito Laravel**: El backend sigue residiendo íntegramente en las capas estándar de Laravel (`app/Http/Controllers/Api`, `app/Http/Requests`, `routes/central.php`).
* **II. UI en Blade/Livewire**: La app móvil carga y reutiliza el 100% de la interfaz web existente de eBand dentro del WebView, sin duplicar vistas ni lógicas de negocio.
* **III. Tests**: El nuevo endpoint central se prueba mediante una suite completa de PHPUnit Feature Tests.
* **IV. Rutas y Autorización**: El endpoint de resolución se aloja en el dominio central con rate-limiting (`throttle:60,1`) y no expone datos sensibles.
* **V. Repositorio Unificado**: La carpeta `mobile/` coexiste sin alterar los flujos de Sail, Composer ni Artisan del proyecto Laravel principal.

---

## 4. Estructura del Proyecto

### Documentación de la Feature
```text
specs/mobile-app-wrapper/
├── spec.md
├── plan.md
└── tasks.md
```

### Código Fuente

```text
# Backend Laravel (Dominio Central)
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── MobileTenantResolverController.php
│   ├── Requests/
│   │   └── Mobile/
│   │       └── ResolveTenantRequest.php
│   └── Resources/
│       └── MobileTenantResource.php
routes/
└── central.php (o routes/api.php bajo dominio central)

tests/Feature/
└── Api/
    └── MobileTenantResolverTest.php

# Adaptación Web
resources/views/
└── components/layouts/app.blade.php (meta viewport-fit=cover y detección de app)

# Aplicación Móvil (Directorio mobile/)
mobile/
├── package.json
├── capacitor.config.ts
├── src/
│   ├── index.html        # Onboarding nativo: Introducir código / Confirmar banda / Offline
│   ├── css/
│   │   └── app.css       # Estilos del onboarding y estados de carga
│   └── js/
│       └── app.js        # Lógica de resolución, persistencia y control del WebView
├── android/              # Proyecto Android generado por Capacitor
└── ios/                  # Proyecto iOS generado por Capacitor
```

---

## 5. Diseño de Componentes y Flujo de Datos

### A. Contrato API de Resolución (`GET /api/v1/mobile/tenants/resolve`)
* **Parámetros Query**:
  * `code`: string (alfanumérico, no sensible a mayúsculas/espacios).
* **Respuesta Exitosa (`200 OK`)**:
  ```json
  {
    "success": true,
    "data": {
      "tenant_id": "9d8e7f6a-...",
      "name": "Sociedad Musical San José",
      "code": "SM-SANJOSE",
      "target_url": "https://sanjose.eband.es",
      "logo_url": "https://eband.es/storage/logos/sanjose.png",
      "primary_color": "#1e40af",
      "onesignal_app_id": "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
    }
  }
  ```
* **Respuestas de Error**:
  * `422 Unprocessable Content`: Código vacío o inválido.
  * `404 Not Found`: No existe ninguna agrupación con ese código.
  * `403 Forbidden`: Agrupación suspendida o no activa.

### B. Flujo del Contenedor Móvil (`mobile/src/js/app.js`)
1. **Arranque**:
   * Consultar `Preferences.get({ key: 'eband_tenant_url' })`.
   * Si existe `target_url`: Redirigir inmediatamente el WebView a `target_url` (o recargar la sesión web).
   * Si no existe: Mostrar la pantalla de bienvenida / formulario de código.
2. **Validación de Código**:
   * Mostrar spinner de carga y consultar el endpoint central de resolución.
   * Si es válido: Renderizar la "Tarjeta de Confirmación" con nombre y escudo.
   * Al pulsar "Acceder a mi banda":
     * Guardar en `Preferences`: `eband_tenant_code`, `eband_tenant_url`, `eband_tenant_name`.
     * Navegar el WebView hacia `target_url + '/login'`.
3. **Control de Navegación y Enlaces**:
   * Si la URL destino pertenece al dominio del tenant: Cargar en el WebView.
   * Si la URL destino es externa (ej. enlaces a YouTube, mapas, webs externas): Abrir con `@capacitor/browser` en el navegador del sistema.
4. **Manejo de Errores de Red**:
   * Si `@capacitor/network` detecta caída de conexión antes de cargar o durante la navegación inicial, mostrar overlay amigable de "Sin conexión" con botón para reintentar.
5. **Mecanismo de Desvinculación**:
   * Exponer una función JavaScript en el WebView o botón en ajustes que invoque `Preferences.clear()` y recargue `src/index.html` para permitir introducir otro código.

---

## 6. Fases de Ejecución

1. **Fase 1: Backend Central de Laravel**
   * Crear el Form Request `ResolveTenantRequest` con sanitización de código (`trim`, `strtoupper`).
   * Crear el `MobileTenantResolverController` y registrar la ruta en `routes/central.php`.
   * Escribir y ejecutar los tests PHPUnit en `tests/Feature/Api/MobileTenantResolverTest.php`.
   * Formatear con Laravel Pint.

2. **Fase 2: Adaptación del Frontend Web**
   * Actualizar meta tags en layouts Blade para dar soporte a safe areas (`viewport-fit=cover`).
   * Configurar reglas CSS utilitarias en Tailwind para safe-areas (`pt-[env(safe-area-inset-top)]`, `pb-[env(safe-area-inset-bottom)]`).

3. **Fase 3: Estructura del Proyecto Móvil (`mobile/`)**
   * Crear el directorio `mobile/` e inicializar `package.json` con dependencias de Capacitor (`@capacitor/core`, `@capacitor/cli`, `@capacitor/preferences`, `@capacitor/network`, `@capacitor/browser`, `@capacitor/app`).
   * Crear `capacitor.config.ts`.
   * Crear `src/index.html`, `src/css/app.css` y `src/js/app.js` con el diseño de bienvenida, resolución y pantalla offline.

4. **Fase 4: Inicialización de Plataformas Nativas**
   * Añadir `@capacitor/android` y generar la carpeta nativa `mobile/android`.
   * Añadir `@capacitor/ios` y generar la carpeta nativa `mobile/ios`.
   * Documentar en una guía rápida (`quickstart.md`) los pasos para compilar en Android Studio y Xcode.
