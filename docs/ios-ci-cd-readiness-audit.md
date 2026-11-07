# Auditoría de Preparación de la App iOS (Capacitor 6) para CI/CD en GitHub Actions

**Proyecto**: eBand  
**Componente**: Contenedor Móvil iOS (`mobile/ios`)  
**Fecha de Auditoría**: 7 de Noviembre de 2026  
**Identificador de Aplicación (Bundle ID)**: `es.eband.app`  
**Entorno de CI/CD Objetivo**: GitHub Actions (`macos-14`, Apple Silicon M1/M2)  

---

## 1. Resumen Ejecutivo

El presente informe documenta el estado técnico de la aplicación móvil iOS de **eBand**, estructurada sobre **Capacitor 6.2.3** en el subdirectorio `mobile/`, y diagnostica exhaustivamente la viabilidad de su compilación y empaquetado desatendido para generar binarios `.ipa` firmados para producción (destinados a **TestFlight** y **App Store**).

El análisis concluye que el proyecto nativo iOS (`mobile/ios/App`) cuenta con una base sólida, limpia y sin configuraciones de certificados o identificadores de equipo (*Team IDs*) hardcodeados. Sin embargo, el flujo de integración continua existente en `.github/workflows/build-ios.yml` y la configuración del repositorio presentan **6 bloqueadores críticos principales** (más un bloqueador colateral de caché de dependencias en `mobile/.gitignore`) que impiden de forma absoluta la compilación de binarios firmados distribuibles.

A continuación se detalla la arquitectura actual, los bloqueadores identificados y los ajustes obligatorios para habilitar una canalización de CI/CD 100% desatendida (*headless*).

---

## 2. Diagnóstico de la Configuración Móvil Actual

### 2.1 Ecosistema Capacitor 6 (`mobile/capacitor.config.json` y dependencias)
- **Archivo de configuración**: `mobile/capacitor.config.json`.
  - `appId`: `"es.eband.app"` (coincidente con el bundle identifier nativo en Xcode).
  - `appName`: `"eBand App"`.
  - `webDir`: `"src"`. El directorio `mobile/src` contiene ficheros estáticos HTML, CSS y JavaScript que actúan como puente hacia la plataforma web de eBand. Por tanto, no se requiere ningún empaquetador web intermedio (`npm run build` o Vite) antes de la sincronización de la plataforma móvil.
  - `server.allowNavigation`: Configurado para dominios `*.eband.app`, `*.eband.es`, `localhost` y `127.0.0.1`.
- **Versiones del núcleo y CLI**:
  - `@capacitor/core`: `^6.0.0` (instalado `6.2.3`).
  - `@capacitor/cli`: `^6.0.0` (instalado `6.2.3`).
  - `@capacitor/ios`: `^6.0.0` (instalado `6.2.3`).
- **Plugins nativos integrados**:
  - Oficiales: `@capacitor/app`, `@capacitor/browser`, `@capacitor/camera`, `@capacitor/network`, `@capacitor/preferences`, `@capacitor/splash-screen`, `@capacitor/status-bar`.
  - Terceros / Biometría: `@capgo/capacitor-native-biometric` (`6.0.4`).
  - Notificaciones Push: `onesignal-cordova-plugin` (`5.6.2`).
  - Utilidades: `jsqr` (`1.4.0`).
- **Scripts en `mobile/package.json`**:
  - Se definen scripts auxiliares como `"cap:sync": "cap sync"`. El comando canónico para actualizar los activos web y los plugins en el proyecto nativo es `npx cap sync ios`.

### 2.2 Gestión de Dependencias Nativas con CocoaPods (`mobile/ios/App/Podfile`)
- **Configuración del Podfile**:
  - Requiere el helper oficial de Capacitor: `require_relative '../../node_modules/@capacitor/ios/scripts/pods_helpers'`.
  - Plataforma de despliegue mínima: `platform :ios, '13.0'`.
  - Uso de frameworks dinámicos: `use_frameworks!`.
  - Directiva de instalación: `install! 'cocoapods', :disable_input_output_paths => true`.
  - Target principal: `target 'App' do ... capacitor_pods ... end`.
  - Dependencias externas: `OneSignalCordovaDependencies` (etiqueta `5.6.2` vía Git) y `CordovaPluginsStatic` (apuntando a la ruta local `../capacitor-cordova-ios-plugins`).
- **Secuencia de sincronización obligatoria**:
  - El directorio `mobile/ios/capacitor-cordova-ios-plugins` es generado dinámicamente por Capacitor durante la sincronización para envolver plugins compatibles con Cordova (como OneSignal).
  - **Requisito crítico de orden**: Ejecutar `pod install` de forma aislada sin haber ejecutado previamente `npx cap sync ios` provoca el fallo inmediato de CocoaPods debido a la inexistencia de la ruta `../capacitor-cordova-ios-plugins`. El orden estricto en CI debe ser:
    1. `npm ci` (o `npm install`) en `mobile/`.
    2. `npx cap sync ios` en `mobile/`.
    3. `pod install` en `mobile/ios/App/`.

### 2.3 Estructura del Proyecto Nativo Xcode (`App.xcodeproj` y `App.xcworkspace`)
- **Workspace vs Project**:
  - CocoaPods genera `App.xcworkspace`, enlazando `App.xcodeproj` y `Pods.xcodeproj`.
  - La compilación en CI **debe invocar obligatoriamente `-workspace App.xcworkspace`**. Si se invoca directamente `-project App.xcodeproj`, el enlazador (*linker*) fallará con símbolos no resueltos al no enlazar `Pods_App.framework`.
- **Target Único**:
  - El proyecto define un único target nativo: `App` (ID interno PBXNativeTarget: `504EC3031FED79650016851F`).
  - No existen extensiones de servicio independientes como `OneSignalNotificationServiceExtension`. Esto simplifica la infraestructura de firma a un único perfil de aprovisionamiento para el Bundle ID `es.eband.app`.
- **Configuraciones de Compilación**:
  - Disponibles: `Debug` y `Release`.
  - Vinculadas a los archivos de configuración de CocoaPods: `Pods-App.debug.xcconfig` y `Pods-App.release.xcconfig`.
- **Parámetros de Compilación en `project.pbxproj`**:
  - `PRODUCT_BUNDLE_IDENTIFIER = es.eband.app;`
  - `IPHONEOS_DEPLOYMENT_TARGET = 13.0;`
  - `MARKETING_VERSION = 1.0;`
  - `CURRENT_PROJECT_VERSION = 1;`
  - `SWIFT_VERSION = 5.0;`
  - `CODE_SIGN_STYLE = Automatic;`
  - `DEVELOPMENT_TEAM`: No está configurado en el archivo del proyecto (neutral). Esto permite inyectar el identificador del equipo en tiempo de compilación sin ensuciar el control de versiones.

---

## 3. Análisis de los Bloqueadores Críticos en `.github/workflows/build-ios.yml`

El flujo de trabajo previo en `.github/workflows/build-ios.yml` fue concebido únicamente como una prueba de concepto mínima para simulador. A continuación se detallan los 6 bloqueadores críticos que impiden generar compilaciones firmadas para TestFlight / App Store:

### Bloqueador 1: Destino de Compilación Erróneo (iOS Simulator)
- **Línea 54**: `-destination 'generic/platform=iOS Simulator'`.
- **Impacto**: `xcodebuild` genera binarios con arquitecturas destinadas al simulador de macOS (`x86_64` o `arm64-simulator`). Estos binarios no pueden ejecutarse en dispositivos físicos iPhone/iPad reales y son rechazados categóricamente por Apple App Store Connect y TestFlight.
- **Solución requerida**: Cambiar el destino a `-destination 'generic/platform=iOS'`, lo que compila binarios `arm64` nativos para dispositivos iOS físicos.

### Bloqueador 2: Firma de Código Expresamente Desactivada
- **Líneas 55-57**:
  ```bash
  CODE_SIGNING_ALLOWED=NO \
  CODE_SIGNING_REQUIRED=NO \
  CODE_SIGN_IDENTITY="" \
  ```
- **Impacto**: Anula por completo cualquier proceso criptográfico de firma de código. El binario resultante carece de firma digital y del sello de entitlements necesario para la distribución en iOS.
- **Solución requerida**: Habilitar firma manual mediante `CODE_SIGN_STYLE=Manual`, `CODE_SIGN_IDENTITY="Apple Distribution"`, `DEVELOPMENT_TEAM="${{ secrets.APPLE_TEAM_ID }}"` y `PROVISIONING_PROFILE_SPECIFIER="$PROFILE_UUID"`.

### Bloqueador 3: Ausencia de Gestión de Keychain Temporal y Secretos
- **Estado actual**: El workflow no contiene ninguna instrucción para crear llaveros (`security create-keychain`), ni importa certificados `.p12`, ni maneja secretos de GitHub Actions (`secrets.*`).
- **Impacto**: Los runners de GitHub Actions `macos-14` son máquinas virtuales limpias y efímeras. No contienen la clave privada ni el certificado de distribución de la organización. Además, en entornos desatendidos (*headless*), cualquier intento de acceder a un llavero por defecto (`login.keychain-db`) sin partición de permisos provoca un bloqueo interactivo de UI (*GUI prompt*) que congela el job hasta el timeout de 6 horas.
- **Solución requerida**:
  1. Crear un llavero temporal (`$RUNNER_TEMP/build.keychain-db`) con contraseña aleatoria efímera (`openssl rand -hex 16`).
  2. Configurar el timeout del llavero a 21.600 segundos (6 horas) con `security set-keychain-settings -lut 21600` para evitar que se bloquee durante la compilación.
  3. Desbloquear el llavero e incluirlo en la lista de búsqueda de dominios de usuario (`security list-keychains -d user -s ...`).
  4. Decodificar el certificado en Base64 e importarlo en el llavero con `security import`.
  5. Autorizar a `/usr/bin/codesign` en la lista de particiones de control de acceso mediante `security set-key-partition-list -S apple-tool:,apple:,codesign: -s -k "$KEYCHAIN_PASSWORD" "$KEYCHAIN_PATH"`.
  6. Decodificar el perfil de aprovisionamiento, extraer dinámicamente su UUID e instalarlo en `$HOME/Library/MobileDevice/Provisioning Profiles/${PROFILE_UUID}.mobileprovision`.

### Bloqueador 4: Ausencia de Fase de Archivado (`archive`) y Exportación a `.ipa`
- **Línea 50**: Ejecuta `xcodebuild clean build`.
- **Impacto**: `xcodebuild build` simplemente genera un paquete `.app` sin empaquetar dentro de un directorio de derivados (`DerivedData`). No produce un archivo de archivo nativo (`.xcarchive`) ni genera el paquete comprimido y firmado `.ipa` exigido por TestFlight.
- **Solución requerida**:
  1. Ejecutar `xcodebuild clean archive` con `-archivePath "$RUNNER_TEMP/eBand.xcarchive"`.
  2. Generar dinámicamente el manifiesto XML `ExportOptions.plist` con método `app-store`, `teamID`, firma manual y el mapeo de `es.eband.app` a su UUID.
  3. Ejecutar `xcodebuild -exportArchive` apuntando a dicho archivo y manifiesto para generar `eBand.ipa`.

### Bloqueador 5: Ausencia de Esquema Compartido de Xcode (`App.xcscheme`)
- **Estado actual**: En `mobile/ios/App/App.xcodeproj` no existe la carpeta `xcshareddata/xcschemes/` ni ningún esquema compartido.
- **Impacto**: En desarrollo local con interfaz gráfica, Xcode genera esquemas dinámicos para el usuario actual en `xcuserdata/`. Sin embargo, en el entorno headless de CI de GitHub Actions, `xcodebuild -workspace App.xcworkspace -scheme App` no puede descubrir el esquema y falla con el error: `xcodebuild: error: The scheme "App" does not exist`.
- **Solución requerida**: Crear y versionar en el repositorio el esquema compartido estándar `mobile/ios/App/App.xcodeproj/xcshareddata/xcschemes/App.xcscheme` vinculado al target `App` (`504EC3031FED79650016851F`).

### Bloqueador 6: Enmascaramiento de Errores y Ruta de Artefacto Rota
- **Línea 58**: `| xcpretty || true`. El operador `|| true` fuerza un código de salida `0` aunque `xcodebuild` falle estrepitosamente, engañando a GitHub Actions y reportando éxito falsamente.
- **Línea 64**: `path: mobile/ios/App/build/` con `if-no-files-found: warn`. `xcodebuild` no escribe en esa ruta por defecto, por lo que el paso de subida de artefactos no subía ningún archivo, emitiendo solo una advertencia silenciada.
- **Solución requerida**: Eliminar `|| true` para preservar el código de error real de `xcodebuild`, y actualizar `actions/upload-artifact@v4` para apuntar a `$RUNNER_TEMP/export/*.ipa` con `if-no-files-found: error`.

---

## 4. Bloqueador Adicional en Control de Versiones: `mobile/.gitignore`

En el archivo `mobile/.gitignore`:
- La línea 2 contiene: `package-lock.json`.
- **Impacto**: `mobile/package-lock.json` no está versionado en Git. En el workflow de GitHub Actions, el paso `actions/setup-node@v4` con `cache-dependency-path: mobile/package-lock.json` no encuentra el archivo para generar la clave de caché, y el comando `npm ci` falla al requerir obligatoriamente un lockfile sincronizado.
- **Solución requerida**: Eliminar `package-lock.json` de `mobile/.gitignore` para permitir que el árbol de dependencias de npm quede fijado de forma determinista en el repositorio.

---

## 5. Especificación de Ajustes para el Runner Headless (macOS)

Para garantizar una compilación desatendida y segura en GitHub Actions (`macos-14`), la canalización debe seguir el siguiente ciclo de vida:

```
[1. Checkout]
      │
[2. Setup Node 20 & npm Cache]
      │
[3. npm ci / npm install en mobile/]
      │
[4. npx cap sync ios en mobile/]
      │
[5. pod install en mobile/ios/App/]
      │
[6. Configurar Keychain Temporal e Importar Certificado]
      ├─ Crear $RUNNER_TEMP/build.keychain-db con openssl rand -hex 16
      ├─ Configurar timeout 21600s y añadir a la lista de búsqueda
      ├─ Decodificar BUILD_CERTIFICATE_BASE64 e importar con P12_PASSWORD
      └─ security set-key-partition-list -S apple-tool:,apple:,codesign:
      │
[7. Instalar Perfil de Aprovisionamiento]
      ├─ Decodificar BUILD_PROVISION_PROFILE_BASE64
      ├─ Extraer UUID mediante security cms | plutil
      └─ Copiar a ~/Library/MobileDevice/Provisioning Profiles/${UUID}.mobileprovision
      │
[8. xcodebuild clean archive]
      ├─ -workspace App.xcworkspace -scheme App -configuration Release
      ├─ -destination 'generic/platform=iOS'
      └─ CODE_SIGN_STYLE=Manual, TEAM_ID, Distribution Identity, Profile UUID
      │
[9. Generar ExportOptions.plist y xcodebuild -exportArchive]
      ├─ method: app-store, signingStyle: manual, bundleId -> UUID
      └─ Generar App.ipa en $RUNNER_TEMP/export/
      │
[10. Subir Artefacto con upload-artifact@v4]
      └─ Sube *.ipa con if-no-files-found: error
      │
[11. Limpieza de Seguridad Post-Ejecución (if: always())]
      ├─ Eliminar keychain temporal
      ├─ Restaurar login.keychain-db por defecto
      └─ Purgar certificados y perfiles del disco
```

---

## 6. Matriz de Requisitos y Estado de Preparación

| Requisito | Estado Previo | Acción Implementada |
| :--- | :--- | :--- |
| **Capacitor 6 Sync** | Funcional, pero dependiente de orden | Asegurada la ejecución de `npx cap sync ios` antes de CocoaPods |
| **CocoaPods Workspace** | Presente, pero sin lockfile en repo | Ejecución garantizada de `pod install` tras la sincronización |
| **Esquema de Xcode** | Inexistente (bloqueaba CI headless) | Creación de `App.xcscheme` compartido en `xcshareddata/xcschemes/` |
| **Lockfile de npm** | Ignorado en `mobile/.gitignore` | Eliminada la exclusión en `.gitignore` para caché determinista |
| **Runner macOS** | `macos-14` (adecuado) | Mantenido `macos-14` (Apple Silicon M1/M2) |
| **Llavero y Firma** | Inexistente (compilación sin firma) | Implementado ciclo completo de llavero temporal y partición |
| **Empaquetado IPA** | Compilaba `.app` de simulador | `xcodebuild clean archive` + `-exportArchive` produciendo `.ipa` |
| **Artefactos CI** | Ruta errónea, aviso silenciado | `upload-artifact@v4` subiendo el `.ipa` con validación estricta |
| **Limpieza Criptográfica**| Inexistente | Bloque `if: always()` garantizando borrado de claves y perfiles |

---

## 7. Conclusión de la Auditoría

El proyecto `mobile/ios` de eBand está preparado para la automatización total una vez aplicados los cambios en:
1. El esquema compartido de Xcode `App.xcscheme`.
2. La eliminación de `package-lock.json` en `mobile/.gitignore`.
3. La reescritura completa de `.github/workflows/build-ios.yml` siguiendo la especificación headless descrita.
4. La configuración en el repositorio de los 4 secretos requeridos (`BUILD_CERTIFICATE_BASE64`, `P12_PASSWORD`, `BUILD_PROVISION_PROFILE_BASE64`, `APPLE_TEAM_ID`).
