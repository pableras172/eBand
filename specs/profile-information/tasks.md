# Tareas: Perfil de usuario

**Entrada**: Documentos de diseño en `specs/profile-information/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo tiene cobertura básica pero toca datos sensibles de cuenta.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de documentación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar la superficie real del módulo antes de documentar el flujo.

- [x] T001 Confirmar el componente principal en `app/Livewire/UpdateProfileInformationForm.php`
- [x] T002 [P] Confirmar el registro Livewire en `app/Providers/JetstreamServiceProvider.php`
- [x] T003 [P] Confirmar la vista principal en `resources/views/profile/update-profile-information-form.blade.php`

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que `mount()` carga los datos del usuario actual
- [x] T005 [P] Revisar que `updateProfileInformation()` delega en `UpdatesUserProfileInformation`
- [x] T006 [P] Revisar que `deleteProfilePhoto()` y `sendEmailVerification()` existen y se usan en la vista
- [x] T007 Revisar que el selector de instrumento consume `Instrument::all()`
- [x] T008 Confirmar que el formulario condicional de Admin expone campos adicionales
- [x] T009 Confirmar que la cobertura básica existente valida carga y actualización del perfil

**Punto de control**: La base está lista; el módulo puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Actualizar información del perfil y la foto del usuario (Prioridad: P1)

**Objetivo**: Documentar la edición básica de cuenta y fotografía.

**Prueba independiente**: Cambiar nombre, correo y foto, y verificar persistencia y redirección correcta.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar que el componente inicializa `state` con el usuario actual
- [x] T011 [P] [US1] Verificar que la actualización persistente modifica nombre y correo
- [x] T012 [P] [US1] Verificar que la foto nueva provoca redirección a `profile.show`

### Implementación para la historia 1

- [x] T013 [P] [US1] Documentar la vista principal en `resources/views/profile/update-profile-information-form.blade.php`
- [x] T014 [P] [US1] Documentar el flujo de guardado en `app/Livewire/UpdateProfileInformationForm.php`
- [x] T015 [US1] Mantener la carga inicial desde `Auth::user()`
- [x] T016 [US1] Mantener la subida, vista previa y borrado de foto
- [x] T017 [US1] Confirmar que la historia principal queda completa sin dependencias externas

**Punto de control**: La historia 1 queda documentada como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Gestionar datos extendidos del músico y verificación de correo (Prioridad: P2)

**Objetivo**: Documentar el perfil extendido del músico y la verificación de correo.

**Prueba independiente**: Editar instrumento, teléfono y opciones operativas; comprobar además el envío de verificación.

### Pruebas para la historia 2

- [x] T018 [P] [US2] Verificar que el selector de instrumento muestra opciones disponibles
- [x] T019 [P] [US2] Verificar que `sendEmailVerification()` marca el estado de enlace enviado
- [x] T020 [P] [US2] Verificar que los campos de admin aparecen solo cuando procede

### Implementación para la historia 2

- [x] T021 [P] [US2] Documentar la selección de instrumento en la vista de perfil
- [x] T022 [P] [US2] Documentar los campos extendidos del músico y el bloqueo por rol
- [x] T023 [US2] Mantener el reenvío de verificación de correo
- [x] T024 [US2] Mantener la actualización de navegación tras guardar o borrar foto
- [x] T025 [US2] Confirmar que la historia complementa el perfil estándar de Jetstream

**Punto de control**: La historia 2 queda documentada como capa extendida complementaria.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T026 [P] Documentar que existe una prueba básica para carga y actualización del perfil
- [x] T027 [P] Documentar el desajuste de namespace entre la prueba y el componente local actual
- [x] T028 Revisar consistencia entre componente, vista, registro Livewire y flujo de Jetstream
- [x] T029 Registrar que el módulo depende de Fortify y Jetstream para parte del comportamiento
- [x] T030 Marcar la feature como migrada con gap de alineación de prueba, no como feature nueva

---

## Dependencias y orden de ejecución

### Dependencias de fase

- **Preparación**: no depende de nada
- **Base bloqueante**: depende de Preparación
- **Historias de usuario**: dependen de la Base bloqueante
- **Pulido**: depende de todas las historias

### Dependencias entre historias

- **Historia 1**: puede documentarse primero; no depende de la verificación de correo
- **Historia 2**: depende del formulario y de la lógica condicional por rol

### Dentro de cada historia

- La prueba va antes que la documentación de implementación correspondiente
- El registro Livewire se documenta antes que la vista asociada
- La desalineación del test se registra antes de cerrar la migración

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010, T011 y T012 se pueden revisar en paralelo
- T018, T019 y T020 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Documentar la actualización básica del perfil.
3. Documentar el perfil extendido y la verificación.
4. Cerrar con el gap del test y su alineación de namespace.

### Entrega incremental

1. Base documental del componente.
2. Foto y datos básicos.
3. Instrumento, teléfono y flags operativos.
4. Registro del gap de cobertura y namespace.

### Estrategia de equipo

1. Una persona revisa componente y registro Livewire.
2. Otra persona revisa vista y lógica condicional por rol.
3. Otra persona revisa pruebas y alineación de namespace.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La brecha principal es que la prueba existente usa un namespace distinto al componente local actual.