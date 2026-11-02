# Tareas: Previsualización de listas

**Entrada**: Documentos de diseño en `specs/preview-listas/`

**Prerequisitos**: plan.md, spec.md

**Pruebas**: Se incluyen tareas de pruebas porque el módulo no muestra cobertura dedicada y el comportamiento visual es importante.

**Organización**: Las tareas están agrupadas por historia de usuario para mantener independencia de documentación y validación.

## Formato: `[ID] [P?] [Story] Descripción`

- **[P]**: Se puede ejecutar en paralelo
- **[Story]**: Historia de usuario asociada
- Incluir rutas o archivos exactos en la descripción

## Fase 1: Preparación (infraestructura compartida)

**Propósito**: Confirmar la superficie real del módulo antes de documentar el flujo.

- [x] T001 Confirmar el componente principal en `app/Livewire/PreviewListas.php`
- [x] T002 [P] Confirmar la vista principal en `resources/views/livewire/preview-listas.blade.php`
- [x] T003 [P] Verificar que no existe una ruta explícita detectada para montar el componente

---

## Fase 2: Base bloqueante

**Propósito**: Dejar claras las dependencias que sustentan todas las historias.

- [x] T004 Revisar que el componente carga la actuación desde `mount($id)`
- [x] T005 [P] Revisar que `render()` obtiene la actuación y la lista relacionada
- [x] T006 [P] Revisar que los usuarios se filtran por activo, instrumento y no ser hijos
- [x] T007 Revisar que se marcan selección, disponibilidad, coche y furgoneta
- [x] T008 Revisar que existe `getUsuariosDisponibles()` para la relación pivote
- [x] T009 Confirmar que el componente depende de `Auth::user()` para el estado visual

**Punto de control**: La base está lista; el módulo puede documentarse como migrado.

---

## Fase 3: Historia de usuario 1 - Ver la previsualización de una lista de actuación (Prioridad: P1)

**Objetivo**: Documentar la ventana modal y el agrupado principal de la lista.

**Prueba independiente**: Abrir la previsualización de una actuación y comprobar que se ven la actuación, la lista y los usuarios agrupados.

### Pruebas para la historia 1

- [x] T010 [P] [US1] Verificar la estructura del modal en `resources/views/livewire/preview-listas.blade.php`
- [x] T011 [P] [US1] Verificar que el título del modal usa `actuacion->descripcion`
- [x] T012 [P] [US1] Verificar que la lista se agrupa por `instrument_id`

### Implementación para la historia 1

- [x] T013 [P] [US1] Documentar la visualización del modal en `resources/views/livewire/preview-listas.blade.php`
- [x] T014 [P] [US1] Documentar el flujo de carga en `app/Livewire/PreviewListas.php`
- [x] T015 [US1] Mantener el botón o disparador que abre `displayingPreviewListas`
- [x] T016 [US1] Mantener la información de actuación visible en el encabezado
- [x] T017 [US1] Confirmar que la historia es de consulta y no de edición

**Punto de control**: La historia 1 queda documentada como comportamiento existente.

---

## Fase 4: Historia de usuario 2 - Consultar disponibilidad y detalles operativos de los músicos (Prioridad: P2)

**Objetivo**: Documentar el estado operativo de cada usuario dentro de la lista.

**Prueba independiente**: Abrir una lista y verificar que se muestran selección, disponibilidad y transporte.

### Pruebas para la historia 2

- [x] T018 [P] [US2] Verificar que los usuarios no disponibles quedan fuera de la vista operativa
- [x] T019 [P] [US2] Verificar que se muestra el indicador de coche cuando el pivote lo marca
- [x] T020 [P] [US2] Verificar que el bloque del encabezado muestra músicos y coches de la actuación

### Implementación para la historia 2

- [x] T021 [P] [US2] Documentar el marcado de `seleccionado`, `disponible`, `coche` y `furgona`
- [x] T022 [P] [US2] Documentar la consulta `getUsuariosDisponibles()`
- [x] T023 [US2] Mantener el tratamiento visual de usuario actual autenticado
- [x] T024 [US2] Mantener la agrupación por instrumento y la inspección por fila
- [x] T025 [US2] Confirmar que la historia depende de relaciones Eloquent existentes

**Punto de control**: La historia 2 queda documentada como capa operativa complementaria.

---

## Fase final: Pulido y aspectos cruzados

**Propósito**: Consolidar lo ya existente y dejar claros los puntos de atención.

- [x] T026 [P] Documentar que no se detectaron pruebas dedicadas para PreviewListas
- [x] T027 [P] Documentar que no se detectó una ruta explícita de montaje para este componente
- [x] T028 Revisar consistencia entre componente, vista y dependencias Livewire/Eloquent
- [x] T029 Registrar que el cálculo de datos vive dentro de `render()`
- [x] T030 Marcar la feature como migrada con gap de integración y cobertura

---

## Dependencias y orden de ejecución

### Dependencias de fase

- **Preparación**: no depende de nada
- **Base bloqueante**: depende de Preparación
- **Historias de usuario**: dependen de la Base bloqueante
- **Pulido**: depende de todas las historias

### Dependencias entre historias

- **Historia 1**: puede documentarse primero; no depende del detalle operativo
- **Historia 2**: depende de la estructura del modal y de las relaciones con la lista

### Dentro de cada historia

- La prueba va antes que la documentación de implementación correspondiente
- La consulta de datos se documenta antes que el marcado visual
- La ausencia de ruta explícita se registra antes de cerrar la historia

### Oportunidades en paralelo

- T002 y T003 se pueden revisar en paralelo
- T005 y T006 se pueden revisar en paralelo
- T010, T011 y T012 se pueden revisar en paralelo
- T018, T019 y T020 se pueden revisar en paralelo

---

## Estrategia de implementación

### MVP primero

1. Completar Fase 1 y Fase 2.
2. Documentar la vista modal principal.
3. Documentar el estado operativo de los usuarios.
4. Cerrar con los gaps de integración y cobertura.

### Entrega incremental

1. Base documental del componente.
2. Modal de previsualización.
3. Marcado de disponibilidad y transporte.
4. Registro de gaps y ausencia de pruebas.

### Estrategia de equipo

1. Una persona revisa componente y dependencias.
2. Otra persona revisa vista y flujo visual.
3. Otra persona revisa gaps y documentación de pruebas.

---

## Notas

- [P] significa archivos distintos y sin dependencias directas.
- [Story] enlaza cada tarea con la historia correspondiente.
- La documentación refleja el estado real del módulo y de sus pruebas.
- El módulo ya existe; por eso todas las tareas se marcan como completadas.
- La brecha principal es la mezcla de cálculo, marcaje y presentación en un solo componente.