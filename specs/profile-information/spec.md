# Especificación de la Feature: Perfil de usuario

**Feature Branch**: `[profile-information]`

**Creado**: 2026-07-18

**Estado**: Migrated

**Entrada**: Feature existente detectada en `app/Livewire/UpdateProfileInformationForm.php`, `app/Providers/JetstreamServiceProvider.php`, `resources/views/profile/update-profile-information-form.blade.php` y `tests/Feature/ProfileInformationTest.php`.

## Escenarios de usuario y pruebas

### Historia de usuario 1 - Actualizar información del perfil y la foto del usuario (Prioridad: P1)

Como usuario autenticado, quiero actualizar mi nombre, correo y foto de perfil para mantener mi cuenta al día.

**Por qué esta prioridad**: es el flujo principal del perfil y está directamente expuesto en la interfaz del usuario.

**Prueba independiente**: abrir el formulario de perfil, cambiar nombre y correo, y comprobar que el usuario se actualiza; después subir una foto y verificar la redirección al perfil.

**Escenarios de aceptación**:

1. **Dado** que cargo el formulario de perfil, **cuando** se monta el componente, **entonces** aparecen los datos actuales del usuario.
2. **Dado** que actualizo nombre y correo, **cuando** guardo, **entonces** el usuario queda persistido con los nuevos valores.
3. **Dado** que subo una foto nueva, **cuando** guardo, **entonces** el perfil usa la foto actualizada y redirige a la vista del perfil.

---

### Historia de usuario 2 - Gestionar datos extendidos del músico y verificación de correo (Prioridad: P2)

Como usuario de la banda, quiero indicar mi instrumento, teléfono y preferencias operativas, y recibir ayuda con la verificación del correo si sigue pendiente.

**Por qué esta prioridad**: la cuenta también sirve como ficha de miembro de la banda y condiciona otras pantallas.

**Prueba independiente**: abrir el formulario, cambiar instrumento, teléfono y opciones operativas, y verificar que el formulario refleja el estado del usuario y los permisos de admin.

**Escenarios de aceptación**:

1. **Dado** que el sistema gestiona fotos de perfil, **cuando** se abre el formulario, **entonces** se puede elegir una nueva foto o borrar la existente.
2. **Dado** que el correo no está verificado, **cuando** se muestra el formulario, **entonces** se puede reenviar el enlace de verificación.
3. **Dado** que el usuario pertenece a la banda, **cuando** edita su perfil, **entonces** puede seleccionar instrumento, teléfono, porcentaje y marcadores operativos según el rol.

### Casos límite

- ¿Qué ocurre si el usuario no tiene foto de perfil?
- ¿Qué ocurre si el sistema no gestiona fotos de perfil?
- ¿Qué ocurre si el usuario no es Admin y no debería editar ciertos campos?
- ¿Qué ocurre si el test existente sigue apuntando al namespace anterior de Jetstream?

## Requisitos

### Requisitos funcionales

- **FR-001**: El sistema debe permitir cargar la información actual del perfil en el formulario.
- **FR-002**: El sistema debe permitir actualizar nombre y correo del usuario.
- **FR-003**: El sistema debe permitir actualizar la foto de perfil cuando el sistema la gestione.
- **FR-004**: El sistema debe permitir borrar la foto de perfil.
- **FR-005**: El sistema debe permitir reenviar el correo de verificación cuando el email no esté validado.
- **FR-006**: El sistema debe permitir seleccionar el instrumento del usuario.
- **FR-007**: El sistema debe permitir editar teléfono y opciones operativas del músico.
- **FR-008**: El sistema debe mantener compatibilidad con la vista Jetstream/Blade existente.

### Superficie Laravel / Livewire

- **Livewire**: `app/Livewire/UpdateProfileInformationForm.php` contiene el componente principal.
- **Registro Livewire**: `app/Providers/JetstreamServiceProvider.php` registra el alias `profile.update-profile-information-form`.
- **Vista**: `resources/views/profile/update-profile-information-form.blade.php` implementa el formulario.
- **Prueba**: `tests/Feature/ProfileInformationTest.php` valida la carga y actualización básica del perfil.

### Entidades clave

- **Usuario**: cuenta autenticada que actualiza su información.
- **Instrumento**: relación seleccionable dentro del perfil.
- **Foto de perfil**: imagen opcional del usuario.

## Criterios de éxito

### Resultados medibles

- **SC-001**: Un usuario autenticado puede ver sus datos actuales en el formulario.
- **SC-002**: Un usuario autenticado puede actualizar nombre y correo con éxito.
- **SC-003**: Un usuario autenticado puede subir o borrar su foto de perfil.
- **SC-004**: Un usuario puede reenviar la verificación de correo cuando procede.
- **SC-005**: La vista sigue funcionando dentro de la interfaz de perfil ya existente.

## Suposiciones

- El formulario vive dentro de Jetstream y se consume desde la pantalla de perfil.
- La disponibilidad de campos como porcentaje, activo, forastero y observaciones depende del rol Admin.
- El test existente es útil como cobertura básica, aunque usa un namespace de Jetstream que no coincide con la clase local actual.
- La cobertura de pruebas del módulo es parcial, así que esta migración documenta comportamiento observado, no validado exhaustivamente.