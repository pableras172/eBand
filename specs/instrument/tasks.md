# Tareas: Instrumentos

**Entrada**: Documentos de diseño en `specs/instrument/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y toca operaciones administrativas sensibles.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de documentación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar la superficie real del módulo antes de documentar el flujo.

- [x] T001 Confirmar el recurso principal en `app/Livewire/Instrument/InstrumentClass.php`
- [x] T002 [P] Confirmar la relación de modelo en `app/Models/Instrument.php`
- [x] T003 [P] Confirmar las vistas reales en `resources/views/instrument/index.blade.php`, `create.blade.php` y `show.blade.php`

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el listado ordena por `orden`
- [x] T005 [P] Revisar que la creación valida nombre, icono y orden
- [x] T006 [P] Revisar que la edición permite conservar o cambiar el icono
- [x] T007 Revisar que la eliminación redirige al listado
- [x] T008 Revisar que la subida de iconos usa `saveFile()` y almacenamiento público
- [x] T009 Confirmar que el módulo está protegido por el grupo de rutas de administración

**Punto de control**: La base está lista; el módulo puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Gestionar instrumentos de la banda (Prioridad: P1)

**Objetivo**: Documentar el CRUD administrativo principal.

**Prueba independiente**: Abrir el listado, crear un instrumento, editarlo y eliminarlo.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar que el listado muestra instrumentos ordenados por `orden`
- [x] T011 [P] [US1] Verificar que `store()` guarda un instrumento con icono válido
- [x] T012 [P] [US1] Verificar que `update()` conserva o reemplaza el icono

### Implementación para la historia 1

- [x] T013 [P] [US1] Documentar el listado en `resources/views/instrument/index.blade.php`
- [x] T014 [P] [US1] Documentar el formulario de alta en `resources/views/instrument/create.blade.php`
- [x] T015 [P] [US1] Documentar el formulario de edición en `resources/views/instrument/show.blade.php`
- [x] T016 [US1] Mantener la subida de iconos en `saveFile()`
- [x] T017 [US1] Mantener la eliminación de instrumentos desde el recurso administrativo
- [x] T018 [US1] Confirmar que la historia principal queda completa sin dependencias externas

**Punto de control**: La historia 1 queda documentada como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Reordenar instrumentos y consultar su relación con usuarios (Prioridad: P2)

**Objetivo**: Documentar el endpoint de reordenado y la relación con usuarios.

**Prueba independiente**: Reordenar instrumentos y verificar la relación con usuarios desde el modelo.

### Pruebas para la historia 2

- [x] T019 [P] [US2] Verificar que `updateOrder()` procesa el array de órdenes
- [x] T020 [P] [US2] Verificar que `Instrument::users()` expone la relación `hasMany`
- [x] T021 [P] [US2] Verificar que el endpoint devuelve una respuesta JSON de éxito

### Implementación para la historia 2

- [x] T022 [P] [US2] Documentar la ruta `instrument.updateOrder` en `routes/web.php`
- [x] T023 [P] [US2] Documentar la lógica de reordenado en `app/Livewire/Instrument/InstrumentClass.php`
- [x] T024 [US2] Mantener la relación de usuarios en `app/Models/Instrument.php`
- [x] T025 [US2] Confirmar que la historia complementa el CRUD sin romper el listado

**Punto de control**: La historia 2 queda documentada como capa operativa complementaria.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T026 [P] Documentar que no se detectaron pruebas dedicadas para Instrumentos
- [x] T027 [P] Documentar que el módulo está encerrado en la zona administrativa con permisos
- [x] T028 Revisar consistencia entre componente híbrido, rutas, modelo y vistas
- [x] T029 Registrar que la subida de iconos depende de archivos de imagen válidos
- [x] T030 Marcar la feature como migrada con gap de cobertura, no como feature nueva

---

## Dependencias y orden de ejecución

### Dependencias de fase

- **Preparación**: no depende de nada
- **Base bloqueante**: depende de Preparación
- **Historias de usuario**: dependen de la Base bloqueante
- **Pulido**: depende de todas las historias

### Dependencias entre historias

- **Historia 1**: puede documentarse primero; no depende del reordenado
- **Historia 2**: depende del modelo y del endpoint de actualización de orden

### Dentro de cada historia

- La prueba va antes que la documentación de implementación correspondiente
- La subida de archivos se documenta antes que la edición que la reutiliza
- Los permisos de administración se registran antes de cerrar la historia

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010, T011 y T012 se pueden revisar en paralelo
- T019, T020 y T021 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Documentar el CRUD principal.
3. Documentar el reordenado y la relación con usuarios.
4. Cerrar con los gaps de cobertura.

### Entrega incremental

1. Base documental del módulo.
2. Listado, alta y edición.
3. Reordenado y relación con usuarios.
4. Registro de gaps y ausencia de pruebas.

### Estrategia de equipo

1. Una persona revisa rutas y permisos.
2. Otra persona revisa vistas y subida de archivos.
3. Otra persona revisa endpoint de orden y relación con usuarios.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La brecha principal es la falta de pruebas dedicadas para un flujo administrativo sensible.