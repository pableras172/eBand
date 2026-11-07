# Catálogo de Secretos y Guía de Configuración para iOS CI/CD

**Proyecto**: eBand  
**Componente**: Contenedor Móvil iOS (`mobile/ios`)  
**Identificador de Aplicación**: `es.eband.app`  
**Destino de Distribución**: TestFlight / App Store  
**Workflow de CI/CD**: `.github/workflows/build-ios.yml`  

---

## 1. Introducción y Principio de Seguridad

Para que GitHub Actions compile, firme y empaquete un archivo binario `.ipa` para distribución en TestFlight o App Store en un entorno desatendido (*headless*), el runner de macOS debe recibir las credenciales criptográficas de Apple Developer.

Nunca deben versionarse archivos de certificados (`.p12`, `.cer`), claves privadas (`.key`, `.p8`) ni perfiles de aprovisionamiento (`.mobileprovision`) en el repositorio Git. Toda la información sensible se inyecta en tiempo de ejecución a través de **GitHub Actions Secrets**.

---

## 2. Inventario Exhaustivo de Secretos de GitHub

La siguiente tabla resume todos los secretos necesarios para que `.github/workflows/build-ios.yml` complete la firma de producción:

| Nombre del Secreto | Obligatorio | Tipo / Formato | Descripción | Valor de Ejemplo |
| :--- | :--- | :--- | :--- | :--- |
| `BUILD_CERTIFICATE_BASE64` | **SÍ** | Cadena Base64 pura (sin saltos de línea) | Certificado de Distribución de Apple (`Apple Distribution`) junto con su clave privada en formato PKCS#12 (`.p12`), codificado en Base64. | `MIIKbwIBAzCCCWcGCSqGSIb3DQE...` |
| `P12_PASSWORD` | **SÍ** | Cadena de texto plano | Contraseña asignada al exportar el archivo `.p12` desde Keychain Access en macOS. | `ClaveFuerteExportacion2026!` |
| `BUILD_PROVISION_PROFILE_BASE64` | **SÍ** | Cadena Base64 pura (sin saltos de línea) | Perfil de aprovisionamiento de distribución (App Store Connect Distribution) para el App ID `es.eband.app`, codificado en Base64. | `MIIXrwYJKoZIhvcNAQcCoIIX...` |
| `APPLE_TEAM_ID` | **SÍ** | Cadena alfanumérica de 10 caracteres | Identificador de Equipo de Apple Developer (Team ID) de la organización en developer.apple.com. | `A1B2C3D4E5` |
| `KEYCHAIN_PASSWORD` | *Opcional* | Cadena alfanumérica | Contraseña del llavero temporal efímero en el runner. Si no se define, el workflow genera automáticamente una clave criptográfica aleatoria (`openssl rand -hex 16`) por ejecución. | `Auto-generado` |

---

## 3. Guía Paso a Paso para Generar los Secretos

### Paso 1: Exportar el Certificado de Distribución (`.p12`) desde macOS

1. Inicia sesión en una máquina macOS que tenga acceso al certificado de desarrollo/distribución de la organización.
2. Abre la aplicación **Keychain Access** (Acceso a Llaveros).
3. En la barra lateral izquierda, selecciona el llavero **login** y la categoría **Mis certificados** (*My Certificates*).
4. Localiza el certificado denominado **`Apple Distribution: [Nombre de tu Organización] ([TEAM_ID])`** o **`iPhone Distribution: ...`**.
5. Despliega la flecha junto al certificado para confirmar que contiene la **clave privada** asociada.
6. Haz clic derecho sobre el certificado (o sobre el certificado y la clave privada seleccionados conjuntamente) y elige **Exportar "Apple Distribution: ..."** (*Export*).
7. En el cuadro de diálogo:
   - Formato de archivo: **Intercambio de información personal (.p12)** (*Personal Information Exchange*).
   - Guarda el archivo temporalmente como `distribution.p12`.
8. El sistema te pedirá ingresar una contraseña para proteger el archivo exportado. Introduce una contraseña segura y anótala: este valor será tu secreto **`P12_PASSWORD`**.
9. Si el sistema operativo lo solicita, introduce la contraseña de inicio de sesión de tu Mac para autorizar la exportación de la clave privada.

---

### Paso 2: Descargar el Perfil de Aprovisionamiento (`.mobileprovision`)

1. Accede al portal de [Apple Developer](https://developer.apple.com/account/) con una cuenta con rol *Account Holder* o *Admin*.
2. Dirígete a **Certificates, Identifiers & Profiles** -> **Profiles**.
3. Pulsa el botón azul **+** para crear un nuevo perfil:
   - En **Distribution**, selecciona **App Store** (o **App Store Connect**). Pulsa *Continue*.
   - En **App ID**, selecciona el identificador registrado de la aplicación: `es.eband.app`. Pulsa *Continue*.
   - En **Certificates**, selecciona el certificado de distribución generado previamente (debe coincidir exactamente con el certificado del archivo `.p12`). Pulsa *Continue*.
   - En **Profile Name**, escribe un nombre descriptivo, por ejemplo: `eBand App Store Distribution`.
4. Pulsa **Generate** y a continuación **Download**.
5. Guarda el archivo descargado como `eBand_AppStore.mobileprovision`.

> 💡 **Nota sobre Notificaciones Push y Capacidades**:  
> Asegúrate de que el App ID `es.eband.app` tenga habilitada la capacidad de **Push Notifications** en *Identifiers* de Apple Developer, dado que la aplicación utiliza el plugin de OneSignal.

---

### Paso 3: Obtener el Identificador de Equipo (`APPLE_TEAM_ID`)

1. En el portal de [Apple Developer](https://developer.apple.com/account/), accede a la pestaña de afiliación o información de cuenta (**Membership details**).
2. Localiza el campo **Team ID**.
3. Consiste en una cadena alfanumérica de 10 caracteres (por ejemplo: `ABC123XYZ4`).
4. Este valor exacto será tu secreto **`APPLE_TEAM_ID`**.

---

### Paso 4: Codificación a Base64 según el Sistema Operativo

Los archivos binarios (`.p12` y `.mobileprovision`) deben transformarse en cadenas de texto Base64 continuas para pegarse en GitHub Secrets. Utiliza las siguientes instrucciones según el sistema operativo de tu máquina local:

#### Opción A: En macOS (Terminal)
```bash
# Codificar el certificado .p12 y copiar directamente al portapapeles
base64 -i distribution.p12 | pbcopy

# Codificar el perfil de aprovisionamiento y copiar directamente al portapapeles
base64 -i eBand_AppStore.mobileprovision | pbcopy
```

#### Opción B: En Linux (Bash)
```bash
# La opción -w 0 desactiva el salto de línea automático
base64 -w 0 distribution.p12 | xclip -selection clipboard

# O guardarlo en un archivo de texto plano:
base64 -w 0 distribution.p12 > cert_base64.txt
base64 -w 0 eBand_AppStore.mobileprovision > profile_base64.txt
```

#### Opción C: En Windows (PowerShell)

> ⚠️ **ADVERTENCIA CRÍTICA SOBRE WINDOWS**:  
> **NO UTILICES** la utilidad antigua `certutil -encode file.p12 out.b64`.  
> `certutil` añade encabezados de certificado PEM (`-----BEGIN CERTIFICATE-----`), pies de página y saltos de línea Windows (`\r\n`), lo cual corrompe la decodificación en los runners macOS (`base64 --decode`).  
> Utiliza exclusivamente los métodos nativos de .NET en **PowerShell**:

```powershell
# 1. Codificar el certificado .p12 y copiar al portapapeles:
[Convert]::ToBase64String([IO.File]::ReadAllBytes("distribution.p12")) | Set-Clipboard

# 2. Codificar el perfil de aprovisionamiento y copiar al portapapeles:
[Convert]::ToBase64String([IO.File]::ReadAllBytes("eBand_AppStore.mobileprovision")) | Set-Clipboard

# Alternativa: exportar a archivos de texto con codificación ASCII pura:
[Convert]::ToBase64String([IO.File]::ReadAllBytes("distribution.p12")) | Out-File -Encoding ascii cert_base64.txt
[Convert]::ToBase64String([IO.File]::ReadAllBytes("eBand_AppStore.mobileprovision")) | Out-File -Encoding ascii profile_base64.txt
```

---

## 4. Configuración de los Secretos en GitHub

1. Navega en tu navegador web al repositorio de GitHub de **eBand**.
2. Haz clic en la pestaña superior **Settings** (Configuración del repositorio).
3. En el menú lateral izquierdo, en la sección **Security**, despliega **Secrets and variables** y selecciona **Actions**.
4. Haz clic en el botón verde **New repository secret**.
5. Añade uno a uno los cuatro secretos requeridos:

   - **Secreto 1**:
     - *Name*: `BUILD_CERTIFICATE_BASE64`
     - *Secret*: Pega la cadena Base64 generada a partir de `distribution.p12`.
     - Haz clic en *Add secret*.

   - **Secreto 2**:
     - *Name*: `P12_PASSWORD`
     - *Secret*: Escribe la contraseña definida al exportar el `.p12`.
     - Haz clic en *Add secret*.

   - **Secreto 3**:
     - *Name*: `BUILD_PROVISION_PROFILE_BASE64`
     - *Secret*: Pega la cadena Base64 generada a partir de `eBand_AppStore.mobileprovision`.
     - Haz clic en *Add secret*.

   - **Secreto 4**:
     - *Name*: `APPLE_TEAM_ID`
     - *Secret*: Escribe tu Team ID de 10 caracteres (ej. `ABC123XYZ4`).
     - Haz clic en *Add secret*.

6. Tras introducirlos, la lista de *Repository secrets* mostrará los 4 secretos configurados y protegidos contra lectura directa.

---

## 5. Ejecución del Flujo de Trabajo en GitHub Actions

Una vez configurados los secretos:

1. Ve a la pestaña **Actions** en el repositorio de GitHub.
2. En la lista de flujos de trabajo (*Workflows*) a la izquierda, selecciona **Build iOS (Capacitor)**.
3. Haz clic en el menú desplegable **Run workflow** a la derecha.
4. Selecciona:
   - **Branch**: Rama deseada (ej. `main` o rama de trabajo).
   - **Modo de compilación**: `Release` (predeterminado para TestFlight / producción).
5. Pulsa el botón verde **Run workflow**.
6. El workflow ejecutará las fases en el runner `macos-14`:
   - Descarga del código e instalación de Node 20 y dependencias de `mobile/`.
   - Sincronización de Capacitor (`npx cap sync ios`) e instalación de CocoaPods (`pod install`).
   - Creación del llavero temporal seguro e importación del certificado.
   - Decodificación del perfil e identificación de su UUID.
   - Archivado del proyecto nativo (`xcodebuild clean archive`).
   - Exportación del paquete firmado `.ipa` (`xcodebuild -exportArchive`).
   - Carga del artefacto `.ipa` con `actions/upload-artifact@v4`.
   - Limpieza completa del llavero y credenciales efímeras.
7. Al finalizar con éxito, en la página de resumen del job (*Workflow run summary*), en la sección **Artifacts**, estará disponible para descarga el paquete comprimido:
   `eband-ios-Release.zip` conteniendo `App.ipa`.

---

## 6. Resolución de Problemas Frecuentes (Troubleshooting)

### Error 1: `errSecAuthFailed` o `-25293`
- **Causa**: La contraseña del `.p12` no coincide con el valor guardado en el secreto `P12_PASSWORD`, o el archivo Base64 está incompleto.
- **Solución**: Vuelve a exportar el certificado desde Keychain Access con una contraseña sencilla pero segura (sin caracteres de escape complejos) y actualiza ambos secretos en GitHub.

### Error 2: `User interaction is not allowed` o congelamiento en `codesign`
- **Causa**: El comando `security set-key-partition-list` no se ejecutó o la contraseña del llavero temporal fue rechazada.
- **Solución**: El workflow ya incluye la instrucción automatizada con `security set-key-partition-list -S apple-tool:,apple:,codesign:`. Verifica que el certificado contenga efectivamente la clave privada asociada.

### Error 3: `No profile matching UUID found` o `No profile for team '...' matching 'es.eband.app'`
- **Causa**: El perfil de aprovisionamiento en `BUILD_PROVISION_PROFILE_BASE64` no pertenece al Bundle Identifier `es.eband.app`, o el Team ID provisto no coincide con el equipo emisor del perfil.
- **Solución**: Abre el perfil descargado en un editor o comprueba en developer.apple.com que el App ID seleccionado sea exactamente `es.eband.app` y que el tipo sea **App Store Distribution**.

### Error 4: `Corrupted Base64 data` o fallo en `base64 --decode`
- **Causa**: El secreto fue generado en Windows utilizando `certutil -encode`, que introduce líneas `-----BEGIN CERTIFICATE-----` y saltos de línea `\r\n`.
- **Solución**: Vuelve a codificar el archivo usando el comando de PowerShell indicado en la sección 3 (Paso 4, Opción C): `[Convert]::ToBase64String([IO.File]::ReadAllBytes("..."))`.

### Error 5: `The scheme "App" does not exist`
- **Causa**: Falta el esquema compartido en el repositorio.
- **Solución**: Asegúrate de que el archivo `mobile/ios/App/App.xcodeproj/xcshareddata/xcschemes/App.xcscheme` esté commiteado en el repositorio Git.
