# Guía Rápida: App Móvil eBand (Capacitor)

Esta guía explica cómo compilar, sincronizar y ejecutar el proyecto móvil de **eBand** ubicado en el directorio `mobile/`.

---

## 📋 Requisitos Previos

1. **Node.js**: v18+ y `npm`.
2. **Para Android**:
   * [Android Studio](https://developer.android.com/studio) con SDK de Android (API 33+) y herramientas de línea de comandos.
   * Un emulador de Android configurado o un dispositivo físico con depuración USB activada.
3. **Para iOS** (sólo en macOS):
   * [Xcode](https://developer.apple.com/xcode/) v15+ y CocoaPods (`sudo gem install cocoapods`).

---

## 🚀 Instalación y Puesta en Marcha

### 1. Instalar dependencias del contenedor móvil

Desde la raíz del repositorio:

```bash
cd mobile
npm install
```

### 2. Generar plataformas nativas (primera vez)

Para inicializar las carpetas nativas de Android e iOS:

```bash
# Añadir plataforma Android (crea la carpeta mobile/android)
npx cap add android

# Añadir plataforma iOS (crea la carpeta mobile/ios - requiere macOS)
npx cap add ios
```

### 3. Sincronizar cambios web con las plataformas nativas

Cada vez que modifiques archivos en `mobile/src/` o la configuración de `mobile/capacitor.config.ts`, ejecuta:

```bash
npm run cap:sync
# o: npx cap sync
```

---

## 📱 Ejecutar y Probar

### Abrir en Android Studio:
```bash
npm run cap:android
```
En Android Studio, pulsa **Run 'app'** para desplegar en tu emulador o teléfono conectado.

### Abrir en Xcode (macOS):
```bash
npm run cap:ios
```
En Xcode, selecciona el simulador o tu iPhone y pulsa **Product > Run** (Cmd + R).

---

## 🧪 Probar el Flujo de Onboarding

1. Al abrir la aplicación, verás la pantalla de bienvenida solicitando el código de agrupación.
2. Introduce el código `demo` (o cualquier código de banda existente en tu base de datos central).
3. Pulsa **Continuar**:
   * La app consultará el endpoint `/api/v1/mobile/tenants/resolve?code=demo`.
   * Verás la tarjeta de confirmación con el nombre "Banda Demo".
4. Pulsa **Acceder a mi banda**:
   * El código y la URL del tenant se guardan de forma persistente en `@capacitor/preferences`.
   * El WebView cargará automáticamente el portal de tu banda.
5. Cierra la aplicación por completo y vuelve a abrirla: comprobarás que entra directamente al entorno de tu banda sin pedir el código.

---

## 🔄 Desvincular Agrupación

Para volver a la pantalla de solicitud de código y desvincular el dispositivo:
* En consola de depuración del WebView: ejecuta `window.app.desvincularBanda()`.
* O borra los datos de la app desde los ajustes del sistema del teléfono.
